<?php

namespace Database\Factories;

use App\Models\Volunteer;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Event>
 */
class EventFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        //             $table->string('name');
        //            $table->string('short_description');
        //            $table->text('description');
        //            $table->text('photo_url');
        return [
            'name' => $this->faker->name,
            'short_description' => $this->faker->text(50),
            'description' => $this->faker->text(500),
            'credo' => $this->faker->text(20),
            'city' => $this->faker->randomElement(['Lviv', 'Kyiv', 'Ternopil']),
            'time' => $this->faker->dateTime,
            'photo_url' => $this->faker->url,
            'creator_id' => $this->faker->randomElement(Volunteer::all()->pluck('id')->toArray())
        ];
    }
}
