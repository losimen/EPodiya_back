<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventVolunteer extends Model
{
    use HasFactory;
    protected $guarded = [];

    protected $primaryKey = ['event_id', 'volunteer_id'];
    public $incrementing = false;
    public $timestamps = true;
}
