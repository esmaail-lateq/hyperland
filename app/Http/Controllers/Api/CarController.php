<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Car;
use Illuminate\Http\JsonResponse;

class CarController extends Controller
{
    public function latest(): JsonResponse
    {
        $latestCars = Car::with(['images', 'brand', 'model'])
            ->latest()
            ->take(8)
            ->get()
            ->map(function ($car) {
                return [
                    'id' => $car->id,
                    'title' => $car->title,
                    'year' => $car->year,
                    'mileage' => $car->mileage,
                    'transmission' => $car->transmission,
                    'price' => $car->price,
                    'image' => $car->images->first()?->url ?? null,
                    'brand' => $car->brand?->name,
                    'model' => $car->model?->name,
                ];
            });

        return response()->json([
            'cars' => $latestCars
        ]);
    }
} 