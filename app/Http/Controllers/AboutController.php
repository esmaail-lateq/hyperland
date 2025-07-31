<?php

namespace App\Http\Controllers;

use App\Models\Car;
use Illuminate\Http\Request;

class AboutController extends Controller
{
    /**
     * Show the about page.
     */
    public function index()
    {
        // Get total cars count for statistics
        $totalCarsCount = Car::approved()->count();

        return view('about', compact('totalCarsCount'));
    }
} 