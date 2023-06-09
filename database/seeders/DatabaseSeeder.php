<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Category;
use App\Models\City;
use App\Models\EventVolunteer;
use App\Models\User;
use App\Models\Visitor;
use App\Models\Volunteer;
use App\Models\Event;
use Database\Factories\EventVolunteerFactory;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        City::create([
            'name' => 'Lviv'
        ]);

        City::create([
            'name' => 'Kyiv'
        ]);

        City::create([
            'name' => 'Kharkiv'
        ]);

        Category::create([
            'name' => 'Концерт'
        ]);

        Category::create([
            'name' => 'Ярмарок'
        ]);
        // концерт, ярмарок, стендап, виставка, семінар, кінопоказ, змагання
        Category::create([
            'name' => 'Стендап'
        ]);

        Category::create([
            'name' => 'Виставка'
        ]);

        Category::create([
            'name' => 'Семінар'
        ]);

        Category::create([
            'name' => 'Кінопоказ'
        ]);

        Category::create([
            'name' => 'Змагання'
        ]);

        User::factory()
            ->count(100)
            ->create();

        Volunteer::factory()
            ->count(10)
            ->create();

        Visitor::factory()
            ->count(100)
            ->create();

        Event::factory()
            ->count(10)
            ->create();

        EventVolunteer::factory()
            ->count(10)
            ->create();
    }
}
