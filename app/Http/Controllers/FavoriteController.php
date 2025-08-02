<?php

namespace App\Http\Controllers;

use App\Models\Car;
use Illuminate\Http\Request;

class FavoriteController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    /**
     * Display a listing of the user's favorite cars.
     */
    public function index()
    {
        $favoriteCars = auth()->user()->favoriteCars()->with(['images', 'user'])->paginate(12);
        
        return view('favorites.index', compact('favoriteCars'));
    }

    /**
     * Toggle favorite status for a car.
     */
    public function toggle(Car $car)
    {
        auth()->user()->favoriteCars()->toggle($car->id);
        
        if (request()->wantsJson()) {
            return response()->json([
                'isFavorited' => auth()->user()->favoriteCars()->where('car_id', $car->id)->exists(),
            ]);
        }
        
        return back()->with('success', __('favorites.status_updated'));
    }
} 