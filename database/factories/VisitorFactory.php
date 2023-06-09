<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Visitor>
 */
class VisitorFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    static public $uniqueCounter = 1;

    public function definition(): array
    {
        return [
            'id' => VisitorFactory::$uniqueCounter++,
        ];
    }
}
