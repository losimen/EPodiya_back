<?php

use App\Http\Controllers\EventController;
use App\Http\Controllers\VolunteerController;
use Illuminate\Support\Facades\Route;

Route::get('/events', [EventController::class, 'index']);

Route::get('/events/{event}', [EventController::class, 'show']);

Route::get('/volunteers', [VolunteerController::class, 'index']);

Route::get('/volunteers/{volunteer}', [VolunteerController::class, 'show']);
