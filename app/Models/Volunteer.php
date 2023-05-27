<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Volunteer extends Model
{
    use HasFactory;

    public function events()
    {
        return $this->belongsToMany(Event::class, 'event_volunteers', 'volunteer_id', 'event_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'id', 'id');
    }
}
