<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Car;
use App\Models\CarImage;
use App\Models\User;
use Faker\Factory as Faker;

class CarsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();
        $users = User::all();
        
        // Car make & models mapping
        $carModels = [
            'Audi' => ['A3', 'A4', 'A6', 'Q5', 'Q7'],
            'BMW' => ['3 Series', '5 Series', 'X3', 'X5', 'X6'],
            'Mercedes-Benz' => ['C-Class', 'E-Class', 'S-Class', 'GLC', 'GLE'],
            'Toyota' => ['Corolla', 'Camry', 'RAV4', 'Land Cruiser', 'Yaris'],
            'Honda' => ['Civic', 'Accord', 'CR-V', 'HR-V', 'Jazz'],
            'Ford' => ['Focus', 'Fiesta', 'Mustang', 'Explorer', 'Kuga'],
            'Volkswagen' => ['Golf', 'Passat', 'Tiguan', 'Polo', 'Touareg'],
        ];
        
        // Fuel types
        $fuelTypes = ['gasoline', 'diesel', 'electric', 'hybrid', 'lpg'];
        
        // Transmissions
        $transmissions = ['manual', 'automatic', 'semi-automatic'];
        
        // Locations
        $locations = ['Sofia', 'Plovdiv', 'Varna', 'Burgas', 'Ruse', 'Stara Zagora', 'Pleven'];
        
        // Status options
        $statuses = ['pending', 'approved', 'rejected'];
        
        // Generate 30 random cars
        for ($i = 0; $i < 30; $i++) {
            $make = array_rand($carModels);
            $model = $faker->randomElement($carModels[$make]);
            $year = $faker->numberBetween(2010, 2023);
            $price = $faker->numberBetween(5000, 50000);
            $mileage = $faker->numberBetween(10000, 150000);
            $fuelType = $faker->randomElement($fuelTypes);
            $transmission = $faker->randomElement($transmissions);
            $location = $faker->randomElement($locations);
            $user = $faker->randomElement($users);
            
            // If user is a dealer, car is automatically approved
            $status = $user->type === 'dealer' ? 'approved' : $faker->randomElement($statuses);
            
            $car = Car::create([
                'user_id' => $user->id,
                'title' => "$year $make $model",
                'make' => $make,
                'model' => $model,
                'year' => $year,
                'price' => $price,
                'mileage' => $mileage,
                'fuel_type' => $fuelType,
                'transmission' => $transmission,
                'description' => $faker->paragraphs(rand(2, 5), true),
                'location' => "$location, Bulgaria",
                'status' => $status,
                'is_featured' => $faker->boolean(20), // 20% chance to be featured
            ]);
            
            // Add dummy car images (in a real app, these would be actual image files)
            $imageCount = $faker->numberBetween(1, 5);
            for ($j = 0; $j < $imageCount; $j++) {
                $car->images()->create([
                    'image_path' => 'cars/default-' . rand(1, 5) . '.jpg',
                    'is_primary' => $j === 0,
                    'display_order' => $j,
                ]);
            }
        }
    }
}
