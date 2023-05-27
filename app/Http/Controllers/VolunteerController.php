<?php

namespace App\Http\Controllers;

use App\Models\Volunteer;
use Illuminate\Http\Request;

class VolunteerController extends Controller
{
    public function index()
    {
        return Volunteer::with('user')->get();
    }

    public function show(Volunteer $volunteer)
    {
        $volunteerEvents = [
            'events' => $volunteer->events,
            'user' => $volunteer->user
        ];

        return $volunteerEvents;
    }
}
