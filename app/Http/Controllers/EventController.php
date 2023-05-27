<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\EventVolunteer;
use App\Models\Volunteer;
use Illuminate\Http\Request;

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

        return response()->json($event, 201);
    }
}
