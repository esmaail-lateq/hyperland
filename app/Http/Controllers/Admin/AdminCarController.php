<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Car;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Gate;

class AdminCarController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('admin');
    }

    /**
     * Display a listing of the cars for admin.
     */
    public function index(Request $request)
    {
        $status = $request->get('status', 'all');
        
        $cars = Car::with(['user', 'images'])
            ->when($status === 'pending', function ($query) {
                return $query->where('status', 'pending');
            })
            ->when($status === 'approved', function ($query) {
                return $query->where('status', 'approved');
            })
            ->when($status === 'rejected', function ($query) {
                return $query->where('status', 'rejected');
            })
            ->when($status === 'featured', function ($query) {
                return $query->where('is_featured', true);
            })
            ->latest()
            ->paginate(15);
            
        if ($request->has('status')) {
            $cars->appends(['status' => $status]);
        }
            
        return view('admin.cars.index', compact('cars', 'status'));
    }

    /**
     * Toggle the approval status of a car.
     */
    public function approve(Car $car)
    {
        if (!Gate::allows('admin')) {
            abort(403, 'Unauthorized action.');
        }

        $newStatus = $car->status === 'approved' ? 'pending' : 'approved';
        $car->update(['status' => $newStatus]);
        
        return back()->with('success', 'Car approval status updated successfully!');
    }
    
    /**
     * Reject a car listing.
     */
    public function reject(Car $car)
    {
        if (!Gate::allows('admin')) {
            abort(403, 'Unauthorized action.');
        }

        $car->update(['status' => 'rejected']);
        
        return back()->with('success', 'Car listing has been rejected!');
    }
    
    /**
     * Toggle the featured status of a car.
     */
    public function toggleFeatured(Car $car)
    {
        if (!Gate::allows('admin')) {
            abort(403, 'Unauthorized action.');
        }

        $car->update(['is_featured' => !$car->is_featured]);
        
        return back()->with('success', 'Car featured status updated successfully!');
    }

    /**
     * Remove the specified car listing from storage.
     */
    public function destroy(Car $car)
    {
        if (!Gate::allows('admin')) {
            abort(403, 'Unauthorized action.');
        }

        // Delete all images from storage
        foreach ($car->images as $image) {
            Storage::disk('public')->delete($image->image_path);
        }
        
        $car->delete();

        return back()->with('success', 'Car listing deleted successfully!');
    }
} 