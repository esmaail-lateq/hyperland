<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UsersTableSeeder::class,
            CarSeeder::class,
        ]);

        // Add car images seeder (with external images - requires SSL certs)
        // $this->call(CarImagesSeeder::class);
        
        // Generate local car images with GD library (requires GD extension)
        // $this->call(LocalCarImagesSeeder::class);
        
        // Use simple SVG car images that don't require GD
        // $this->call(SimpleCarImagesSeeder::class);
        
        // Fix car images and recreate them with proper permissions
        // $this->call(FixCarImagesSeeder::class);
    }
}
