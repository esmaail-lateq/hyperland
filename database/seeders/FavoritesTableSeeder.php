<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Car;
use Faker\Factory as Faker;

class FavoritesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();
        $users = User::where('type', 'user')->get(); // Only regular users add favorites
        $cars = Car::where('status', 'approved')->get(); // Only approved cars can be favorited
        
        // Each user will have 1-5 random favorite cars
        foreach ($users as $user) {
            $favoriteCarsCount = $faker->numberBetween(1, 5);
            $randomCars = $cars->where('user_id', '!=', $user->id)->random(min($favoriteCarsCount, $cars->count()));
            
            foreach ($randomCars as $car) {
                $user->favoriteCars()->attach($car->id);
            }
        }
    }
}
