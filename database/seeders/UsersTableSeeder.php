<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Admin User
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
            'type' => 'user',
            'remember_token' => Str::random(10),
        ]);

        // Regular Users
        for ($i = 1; $i <= 5; $i++) {
            User::create([
                'name' => "User $i",
                'email' => "user$i@example.com",
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
                'type' => 'user',
                'phone' => '+359' . rand(10000000, 99999999),
                'remember_token' => Str::random(10),
            ]);
        }

        // Dealers
        for ($i = 1; $i <= 3; $i++) {
            User::create([
                'name' => "Dealer $i",
                'email' => "dealer$i@example.com",
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
                'type' => 'dealer',
                'dealer_name' => "Car Dealership $i",
                'slug' => "car-dealership-$i", 
                'phone' => '+359' . rand(10000000, 99999999),
                'dealer_description' => "This is a car dealership with a wide range of vehicles. We have been in business for over $i years and pride ourselves on excellent customer service.",
                'remember_token' => Str::random(10),
            ]);
        }
    }
}
