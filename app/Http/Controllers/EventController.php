<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\EventVolunteer;
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
        return Event::all();
    }

    public function show(Event $event)
    {
        $event->volunteers;
        $event->creator;
        return $event;
    }

    protected function sendTg()
    {
        $telegram = new Api(env('TELEGRAM_BOT_TOKEN'));
        $chatId = env('TELEGRAM_CHAT_ID');

        // Створити інлайн-клавіатуру
        $keyboard = Keyboard::make()
            ->inline()
            ->row([
                Keyboard::inlineButton([
                    'text' => '✅ Підвердити',
                    'callback_data' => 'button1'])
            ])
            ->row([
                Keyboard::inlineButton([
                    'text' => '❌ Відхилити',
                    'callback_data' => 'button2'])
            ]);

        // Надіслати повідомлення з інлайн-клавіатурою
        $telegram->sendMessage([
            'chat_id' => $chatId,
            'text' => 'Привіт! Виберіть одну з кнопок:',
            'reply_markup' => $keyboard,
        ]);
    }

    public function store(Request $request)
    {
        $requestData = $request->all();

        if (Volunteer::find($requestData['creator_id']) == null) {
            Volunteer::create(['id' => $requestData['creator_id']]);
        }

        $event = Event::create([
            'name' => $requestData['name'],
            'short_description' => $requestData['short_description'],
            'credo' => $requestData['credo'],
            'description' => $requestData['description'],
            'photo_url' => $requestData['photo_url'],
            'creator_id' => $requestData['creator_id'],
        ]);

        EventVolunteer::create([
            'event_id' => $event->id,
            'volunteer_id' => $requestData['creator_id'],
        ]);

        $this->sendTg();

        return response()->json($event, 201);
    }
}
