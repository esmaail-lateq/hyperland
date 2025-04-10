<?php

namespace App\Http\Controllers;

use App\Models\Car;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Show the home page.
     */
    public function index()
    {
        // Get exactly 4 featured cars for the grid
        $featuredCars = Car::with(['images'])
            ->where('is_featured', true)
            ->approved()
            ->latest()
            ->take(4)
            ->get();

        // Get latest cars for the grid
        $latestCars = Car::with(['images'])
            ->approved()
            ->latest()
            ->take(6)
            ->get();

        return view('home', compact('featuredCars', 'latestCars'));
    }

    /**
     * Get latest cars for the API.
     */
    public function latestCars()
    {
        $cars = Car::with(['images'])
            ->approved()
            ->latest()
            ->take(6)
            ->get()
            ->map(function($car) {
                return [
                    'id' => $car->id,
                    'title' => $car->title,
                    'make' => $car->make,
                    'model' => $car->model,
                    'year' => $car->year,
                    'price' => $car->price,
                    'mileage' => $car->mileage,
                    'transmission' => ucfirst($car->transmission),
                    'image' => $car->images->where('is_primary', true)->first()?->image_url ?? '/images/default-car.jpg'
                ];
            });

        return response()->json(['cars' => $cars]);
    }
} 