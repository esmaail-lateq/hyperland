<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use App\Models\Car; // Added this import for the new method

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
    
    /**
     * Display the user's car listings.
     */
    public function myCars(Request $request): View
    {
        $statusFilter = $request->get('status');
        
        $cars = $request->user()->cars()
            ->with('images')
            ->when($statusFilter, function($query) use ($statusFilter) {
                return $query->where('status', $statusFilter);
            })
            ->latest()
            ->paginate(12);
            
        if ($request->has('status')) {
            $cars->appends(['status' => $statusFilter]);
        }
        
        return view('profile.my-cars', compact('cars', 'statusFilter'));
    }

    /**
     * Update the status of a user's car.
     */
    public function updateCarStatus(Request $request, Car $car)
    {
        // Ensure the user owns this car
        if ($car->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'status' => ['required', 'string', 'in:available_in_yemen,available_at_customs,shipping_to_yemen,recently_purchased,admin_approved,sold']
        ]);

        $car->update(['status' => $request->status]);
        
        return back()->with('success', 'Car status updated successfully!');
    }
}
