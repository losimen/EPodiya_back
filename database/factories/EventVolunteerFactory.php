<?php

namespace Database\Factories;

use App\Models\Event;
use App\Models\Volunteer;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class EventVolunteerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
//        dd(Volunteer::all()->pluck('id')->toArray());
        return [
            'event_id' => $this->faker->randomElement(Event::all()->pluck('id')->toArray()),
            'volunteer_id' => $this->faker->randomElement(Volunteer::all()->pluck('id')->toArray()),
        ];
    }
}
