<?php

namespace App\Http\Controllers;

use App\Models\Event;

class EventController extends Controller
{
    public function index()
    {
        return Event::all();
    }

    public function show(Event $event)
    {
        $event->volunteers;
        return $event;
    }
}
