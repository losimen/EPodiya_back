<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\EventVolunteer;
use App\Models\MessageEvent;
use App\Models\Volunteer;
use App\Notifications\SendNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
use Telegram\Bot\Api;
use Telegram\Bot\Keyboard\Keyboard;
use Telegram\Bot\Objects\Update;

class EventController extends Controller
{
    public function index()
    {
        return Event::where('is_approved', true)->get();
    }

    public function show(Event $event)
    {
        $event->volunteers;
        $event->creator;
        return $event;
    }

    protected function sendTg(Event $event, Volunteer $volunteer)
    {
        $telegram = new Api(env('TELEGRAM_BOT_TOKEN'));
        $chatId = env('TELEGRAM_CHAT_ID');

        $volunteerData = $volunteer->user()->first()->toArray();
        $eventData = $event->toArray();

        $keyboard = Keyboard::make()
            ->inline()
            ->row([
                Keyboard::inlineButton([
                    'text' => '✅ Підвердити',
                    'url' => env('PUBLIC_URL') . '/api/events/approve/' . $eventData['id']
                ])
            ])
            ->row([
                Keyboard::inlineButton([
                    'text' => '❌ Відхилити',
                    'url' => env('PUBLIC_URL') . '/api/events/refuse/' . $eventData['id']
                ])
            ]);

        $tgResponse = $telegram->sendMessage([
            'chat_id' => $chatId,
            'text' => '🚨 Зʼявилась <b>нова</b> подія!' . "\n" . "\n" .
                '✒️ <b>Імʼя:</b>' . $eventData['name'] . "\n" . "\n" .
                '📝 <b>Короткий опис:</b> ' . $eventData['short_description'] . "\n" . "\n" .
                '📍 <b>Місто:</b> ' . $eventData['city'] . "\n" .
                '🕐 <b>Час:</b> ' . $eventData['time'] . "\n" . "\n" .
                '👤 <b>Організатор:</b> ' . $volunteerData['first_name'] . ' ' .$volunteer['last_name'] . "\n" .
                '📧 <b>Контакти:</b> ' . $volunteerData['email'] . "\n",
            'reply_markup' => $keyboard,
            'parse_mode' => 'HTML'
        ]);

        MessageEvent::create([
            'message_id' => $tgResponse['message_id'],
            'event_id' => $eventData['id'],
        ]);
    }

    public function approve(Event $event)
    {
        $telegram = new Api(env('TELEGRAM_BOT_TOKEN'));
        $chatId = env('TELEGRAM_CHAT_ID');

        $event->is_approved = true;
        $event->save();

        $telegram->deleteMessage([
            'chat_id' => $chatId,
            'message_id' => MessageEvent::where('event_id', $event->id)->first()->message_id,
        ]);

        return "Approved";
    }

    public function refuse(Event $event)
    {
        $telegram = new Api(env('TELEGRAM_BOT_TOKEN'));
        $chatId = env('TELEGRAM_CHAT_ID');

        $event->is_approved = false;
        $event->save();

        $telegram->deleteMessage([
            'chat_id' => $chatId,
            'message_id' => MessageEvent::where('event_id', $event->id)->first()->message_id,
        ]);

        return "Refused";
    }

    public function store(Request $request)
    {
        $requestData = $request->all();

        $volunteer = Volunteer::find($requestData['creator_id']);
        if (Volunteer::find($requestData['creator_id']) == null) {
            $volunteer = Volunteer::create(['id' => $requestData['creator_id']]);
        }

        $event = Event::create([
            'name' => $requestData['name'],
            'short_description' => $requestData['short_description'],
            'credo' => $requestData['credo'],
            'description' => $requestData['description'],
            'city' => $requestData['city'],
            'time' => $requestData['time'],
            'is_approved' => false,
            'photo_url' => $requestData['photo_url'],
            'creator_id' => $requestData['creator_id'],
        ]);

        EventVolunteer::create([
            'event_id' => $event->id,
            'volunteer_id' => $requestData['creator_id'],
        ]);

        $this->sendTg($event, $volunteer);

        return response()->json($event, 201);
    }
}
