<?php

namespace Database\Seeders;

use App\Models\Car;
use App\Models\CarImage;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class CarSeeder extends Seeder
{
    public function run()
    {
        // Get all existing car images
        $carImages = File::files(storage_path('app/public/car-images'));
        
        // Create 100 cars
        Car::factory()
            ->count(100)
            ->create()
            ->each(function ($car) use ($carImages) {
                // For each car, create 2-4 images
                $numImages = rand(2, 4);
                
                for ($i = 0; $i < $numImages; $i++) {
                    // Randomly select an image
                    $randomImage = $carImages[array_rand($carImages)];
                    
                    // Create image record
                    CarImage::create([
                        'car_id' => $car->id,
                        'image_path' => 'car-images/' . $randomImage->getFilename(),
                        'is_primary' => $i === 0 // First image is primary
                    ]);
                }
            });
    }
} 