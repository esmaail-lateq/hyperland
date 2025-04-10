<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class DealerController extends Controller
{
    /**
     * Display a listing of the dealers.
     */
    public function index()
    {
        $dealers = User::where('type', 'dealer')
            ->withCount('cars')
            ->orderBy('dealer_name')
            ->paginate(12);
            
        return view('dealers.index', compact('dealers'));
    }

    /**
     * Display the specified dealer's profile.
     */
    public function show(User $dealer)
    {
        // Make sure the user is a dealer
        if (!$dealer->isDealer()) {
            abort(404);
        }
        
        $cars = $dealer->cars()
            ->with('images')
            ->approved()
            ->latest()
            ->paginate(12);
            
        return view('dealers.show', compact('dealer', 'cars'));
    }
} 