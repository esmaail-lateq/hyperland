<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Models\CarImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CarController extends Controller
{
    /**
     * Display a listing of the cars.
     */
    public function index(Request $request)
    {
        $carsQuery = Car::with('user')
            ->approved()
            ->latest();
        
        // Apply search filters if provided
        if ($request->has('search')) {
            $search = $request->search;
            $carsQuery->where(function($query) use ($search) {
                $query->where('title', 'like', "%{$search}%")
                    ->orWhere('make', 'like', "%{$search}%")
                    ->orWhere('model', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            });
        }
        
        if ($request->has('make') && $request->make !== 'All Cars') {
            $carsQuery->where('make', $request->make);
        }
        
        if ($request->filled('min_price')) {
            $carsQuery->where('price', '>=', $request->min_price);
        }
        
        if ($request->filled('max_price')) {
            $carsQuery->where('price', '<=', $request->max_price);
        }
        
        if ($request->filled('min_year')) {
            $carsQuery->where('year', '>=', $request->min_year);
        }
        
        if ($request->filled('max_year')) {
            $carsQuery->where('year', '<=', $request->max_year);
        }
        
        if ($request->filled('fuel_type')) {
            $carsQuery->where('fuel_type', $request->fuel_type);
        }
        
        if ($request->filled('transmission')) {
            $carsQuery->where('transmission', $request->transmission);
        }
        
        // Add condition filter
        if ($request->filled('condition')) {
            $carsQuery->where('condition', $request->condition);
        }

        // Add feature filters
        $features = [
            'has_air_conditioning',
            'has_leather_seats',
            'has_navigation',
            'has_parking_sensors',
            'has_parking_camera',
            'has_heated_seats',
            'has_bluetooth',
            'has_led_lights'
        ];

        foreach ($features as $feature) {
            if ($request->has($feature)) {
                $carsQuery->where($feature, true);
            }
        }

        $cars = $carsQuery->paginate(12);
        
        // If request is JSON, return JSON response
        if ($request->expectsJson() || $request->ajax()) {
            $carsData = $cars->map(function($car) {
                return [
                    'id' => $car->id,
                    'make' => $car->make,
                    'model' => $car->model,
                    'year' => $car->year,
                    'price' => $car->price,
                    'formattedPrice' => $car->formattedPrice,
                    'mileage' => $car->mileage,
                    'location' => $car->location,
                    'is_featured' => $car->is_featured,
                    'imageUrl' => '/test.jpg', // Use test image for all cars
                    'isFavorite' => auth()->check() ? auth()->user()->favoriteCars->contains($car->id) : false
                ];
            });
            
            return response()->json([
                'cars' => $carsData,
                'pagination' => [
                    'total' => $cars->total(),
                    'per_page' => $cars->perPage(),
                    'current_page' => $cars->currentPage(),
                    'last_page' => $cars->lastPage(),
                    'from' => $cars->firstItem(),
                    'to' => $cars->lastItem(),
                    'links' => $cars->linkCollection()->toArray()
                ]
            ]);
        }
        
        // Makes list for filter dropdown
        $makes = Car::approved()
            ->select('make')
            ->distinct()
            ->orderBy('make')
            ->pluck('make');
            
        return view('cars.index', compact('cars', 'makes'));
    }

    /**
     * Show the form for creating a new car listing.
     */
    public function create()
    {
        return view('cars.create');
    }

    /**
     * Store a newly created car listing in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => ['required', 'string', 'max:100'],
            'make' => ['required', 'string', 'max:50'],
            'model' => ['required', 'string', 'max:50'],
            'year' => ['required', 'integer', 'min:1900', 'max:' . (date('Y') + 1)],
            'price' => ['required', 'numeric', 'min:0'],
            'mileage' => ['required', 'integer', 'min:0'],
            'fuel_type' => ['required', 'string', 'in:gasoline,diesel,electric,hybrid,lpg,other'],
            'transmission' => ['required', 'string', 'in:manual,automatic,semi-automatic'],
            'condition' => ['required', 'string', 'in:new,used,for_parts'],
            'description' => ['nullable', 'string'],
            'location' => ['required', 'string', 'max:100'],
            'images' => ['required', 'array', 'min:1', 'max:10'],
            'images.*' => ['image', 'mimes:jpeg,png,jpg', 'max:2048'],
            'has_air_conditioning' => ['nullable', 'boolean'],
            'has_leather_seats' => ['nullable', 'boolean'],
            'has_navigation' => ['nullable', 'boolean'],
            'has_parking_sensors' => ['nullable', 'boolean'],
            'has_parking_camera' => ['nullable', 'boolean'],
            'has_heated_seats' => ['nullable', 'boolean'],
            'has_bluetooth' => ['nullable', 'boolean'],
            'has_led_lights' => ['nullable', 'boolean'],
        ]);

        // Create car with user_id set directly
        $car = new Car([
            'title' => $request->title,
            'make' => $request->make,
            'model' => $request->model,
            'year' => $request->year,
            'price' => $request->price,
            'mileage' => $request->mileage,
            'fuel_type' => $request->fuel_type,
            'transmission' => $request->transmission,
            'condition' => $request->condition,
            'description' => $request->description,
            'location' => $request->location,
            'status' => 'pending', // Default to pending for all users
            'has_air_conditioning' => $request->boolean('has_air_conditioning'),
            'has_leather_seats' => $request->boolean('has_leather_seats'),
            'has_navigation' => $request->boolean('has_navigation'),
            'has_parking_sensors' => $request->boolean('has_parking_sensors'),
            'has_parking_camera' => $request->boolean('has_parking_camera'),
            'has_heated_seats' => $request->boolean('has_heated_seats'),
            'has_bluetooth' => $request->boolean('has_bluetooth'),
            'has_led_lights' => $request->boolean('has_led_lights'),
        ]);
        
        $car->user_id = auth()->id();
        $car->save();

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $index => $image) {
                $path = $image->store('cars', 'public');
                
                $car->images()->create([
                    'image_path' => $path,
                    'is_primary' => $index === 0,
                    'display_order' => $index,
                ]);
            }
        }

        return redirect()->route('cars.show', $car)
            ->with('success', 'Your car listing has been created successfully!');
    }

    /**
     * Display the specified car listing.
     */
    public function show(Car $car)
    {
        $car->load(['user', 'images']);
        
        return view('cars.show', compact('car'));
    }

    /**
     * Show the form for editing the specified car listing.
     */
    public function edit(Car $car)
    {
        $this->authorize('update', $car);
        
        return view('cars.edit', compact('car'));
    }

    /**
     * Update the specified car listing in storage.
     */
    public function update(Request $request, Car $car)
    {
        $this->authorize('update', $car);
        
        $request->validate([
            'title' => ['required', 'string', 'max:100'],
            'make' => ['required', 'string', 'max:50'],
            'model' => ['required', 'string', 'max:50'],
            'year' => ['required', 'integer', 'min:1900', 'max:' . (date('Y') + 1)],
            'price' => ['required', 'numeric', 'min:0'],
            'mileage' => ['required', 'integer', 'min:0'],
            'fuel_type' => ['required', 'string', 'in:gasoline,diesel,electric,hybrid,lpg,other'],
            'transmission' => ['required', 'string', 'in:manual,automatic,semi-automatic'],
            'condition' => ['required', 'string', 'in:new,used,for_parts'],
            'description' => ['nullable', 'string'],
            'location' => ['required', 'string', 'max:100'],
            'images' => ['nullable', 'array', 'max:10'],
            'images.*' => ['image', 'mimes:jpeg,png,jpg', 'max:2048'],
            'has_air_conditioning' => ['nullable', 'boolean'],
            'has_leather_seats' => ['nullable', 'boolean'],
            'has_navigation' => ['nullable', 'boolean'],
            'has_parking_sensors' => ['nullable', 'boolean'],
            'has_parking_camera' => ['nullable', 'boolean'],
            'has_heated_seats' => ['nullable', 'boolean'],
            'has_bluetooth' => ['nullable', 'boolean'],
            'has_led_lights' => ['nullable', 'boolean'],
        ]);

        $car->update([
            'title' => $request->title,
            'make' => $request->make,
            'model' => $request->model,
            'year' => $request->year,
            'price' => $request->price,
            'mileage' => $request->mileage,
            'fuel_type' => $request->fuel_type,
            'transmission' => $request->transmission,
            'condition' => $request->condition,
            'description' => $request->description,
            'location' => $request->location,
            'has_air_conditioning' => $request->boolean('has_air_conditioning'),
            'has_leather_seats' => $request->boolean('has_leather_seats'),
            'has_navigation' => $request->boolean('has_navigation'),
            'has_parking_sensors' => $request->boolean('has_parking_sensors'),
            'has_parking_camera' => $request->boolean('has_parking_camera'),
            'has_heated_seats' => $request->boolean('has_heated_seats'),
            'has_bluetooth' => $request->boolean('has_bluetooth'),
            'has_led_lights' => $request->boolean('has_led_lights'),
        ]);

        if ($request->hasFile('images')) {
            // Get the highest display order
            $maxOrder = $car->images()->max('display_order') ?? -1;
            
            foreach ($request->file('images') as $index => $image) {
                $path = $image->store('cars', 'public');
                
                $car->images()->create([
                    'image_path' => $path,
                    'is_primary' => $car->images()->count() === 0 && $index === 0,
                    'display_order' => $maxOrder + $index + 1,
                ]);
            }
        }

        return redirect()->route('cars.show', $car)
            ->with('success', 'Your car listing has been updated successfully!');
    }

    /**
     * Remove the specified car listing from storage.
     */
    public function destroy(Car $car)
    {
        $this->authorize('delete', $car);
        
        // Delete all images from storage
        foreach ($car->images as $image) {
            Storage::disk('public')->delete($image->image_path);
        }
        
        $car->delete();

        return redirect()->route('cars.index')
            ->with('success', 'Your car listing has been deleted successfully!');
    }
} 