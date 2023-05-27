<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Event extends Model
{
    use HasFactory;

    public function volunteers()
    {
        return $this->belongsToMany(User::class, 'event_volunteers', 'event_id', 'volunteer_id');

    }
}
