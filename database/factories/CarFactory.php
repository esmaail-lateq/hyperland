<?php

namespace Database\Factories;

use App\Models\Car;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class CarFactory extends Factory
{
    protected $model = Car::class;

    public function definition()
    {
        $carBrands = [
            'BMW' => ['3 Series', '5 Series', 'X5', 'X3', 'M3', 'M5'],
            'Mercedes-Benz' => ['C-Class', 'E-Class', 'S-Class', 'GLE', 'GLC', 'A-Class'],
            'Audi' => ['A3', 'A4', 'A6', 'Q5', 'Q7', 'RS6'],
            'Volkswagen' => ['Golf', 'Passat', 'Tiguan', 'Polo', 'Arteon', 'T-Roc'],
            'Toyota' => ['Corolla', 'Camry', 'RAV4', 'Yaris', 'C-HR', 'Land Cruiser'],
            'Honda' => ['Civic', 'Accord', 'CR-V', 'HR-V', 'Jazz'],
            'Ford' => ['Focus', 'Fiesta', 'Kuga', 'Puma', 'Mustang'],
            'Peugeot' => ['208', '308', '3008', '5008', '2008']
        ];

        $brand = $this->faker->randomElement(array_keys($carBrands));
        $model = $this->faker->randomElement($carBrands[$brand]);

        $conditions = ['new', 'used', 'for_parts'];
        $transmissions = ['manual', 'automatic', 'semi-automatic'];
        $fuelTypes = ['gasoline', 'diesel', 'electric', 'hybrid', 'lpg', 'other'];
        $locations = ['Sofia', 'Plovdiv', 'Varna', 'Burgas', 'Ruse', 'Stara Zagora', 'Pleven', 'Sliven'];
        $statuses = ['approved', 'pending', 'rejected'];
        
        $year = $this->faker->numberBetween(2015, 2024);
        $mileage = $year === 2024 ? 0 : $this->faker->numberBetween(10000, 150000);
        
        return [
            'title' => $brand . ' ' . $model . ' ' . $year,
            'description' => $this->faker->paragraphs(3, true),
            'make' => $brand,
            'model' => $model,
            'year' => $year,
            'mileage' => $mileage,
            'price' => $this->faker->numberBetween(10000, 100000),
            'transmission' => $this->faker->randomElement($transmissions),
            'fuel_type' => $this->faker->randomElement($fuelTypes),
            'condition' => $this->faker->randomElement($conditions),
            'location' => $this->faker->randomElement($locations),
            'user_id' => User::factory(),
            'status' => $this->faker->randomElement($statuses),
            'has_air_conditioning' => $this->faker->boolean(80),
            'has_leather_seats' => $this->faker->boolean(60),
            'has_navigation' => $this->faker->boolean(70),
            'has_parking_sensors' => $this->faker->boolean(75),
            'has_parking_camera' => $this->faker->boolean(65),
            'has_heated_seats' => $this->faker->boolean(55),
            'has_bluetooth' => $this->faker->boolean(85),
            'has_led_lights' => $this->faker->boolean(45),
            'owners_count' => $this->faker->numberBetween(1, 5),
            'has_service_history' => $this->faker->boolean(70)
        ];
    }
} 