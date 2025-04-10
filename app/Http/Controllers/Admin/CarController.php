<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Car;
use Illuminate\Http\Request;

class CarController extends Controller
{
    /**
     * Display a listing of the cars.
     */
    public function index(Request $request)
    {
        $query = Car::with(['user', 'images']);

        // Filter by status
        if ($request->has('status') && in_array($request->status, ['pending', 'approved', 'rejected'])) {
            $query->where('status', $request->status);
        }

        // Search functionality
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('make', 'like', "%{$search}%")
                  ->orWhere('model', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        $cars = $query->latest()->paginate(10);
        
        return view('admin.cars.index', compact('cars'));
    }

    /**
     * Approve a car listing.
     */
    public function approve(Request $request, Car $car)
    {
        $car->update(['status' => 'approved']);
        
        return redirect()->back()
            ->withInput()
            ->with('success', 'Car listing has been approved successfully.');
    }

    /**
     * Reject a car listing.
     */
    public function reject(Request $request, Car $car)
    {
        $car->update(['status' => 'rejected']);
        
        return redirect()->back()
            ->withInput()
            ->with('success', 'Car listing has been rejected.');
    }

    /**
     * Toggle the featured status of a car.
     */
    public function toggleFeatured(Request $request, Car $car)
    {
        $car->update(['is_featured' => !$car->is_featured]);
        
        return redirect()->back()
            ->withInput()
            ->with('success', $car->is_featured 
                ? 'Car listing has been marked as featured.' 
                : 'Car listing has been removed from featured.');
    }
} 