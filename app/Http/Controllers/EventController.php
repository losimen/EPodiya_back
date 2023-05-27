<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function index()
    {
        return Event::all();
    }

    public function show(Event $event)
    {
        $eventVolunteers = [
            'volunteers' => $event->volunteers,
        ];

        return compact('event', 'eventVolunteers');
    }
}
