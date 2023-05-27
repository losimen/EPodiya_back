<?php

namespace App\Http\Controllers;

use App\Models\Volunteer;
use Illuminate\Http\Request;

class VolunteerController extends Controller
{
    public function show(Volunteer $volunteer)
    {
        $volunteerEvents = [
            'participated_events' => $volunteer->participatedEvents,
            'created_events' => $volunteer->createdEvents,
            'user' => $volunteer->user
        ];

        return $volunteerEvents;
    }
}
