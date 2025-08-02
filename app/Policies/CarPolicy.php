<?php

namespace App\Policies;

use Illuminate\Auth\Access\Response;
use App\Models\Car;
use App\Models\User;
use Illuminate\Support\Facades\Gate;

class CarPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(?User $user): bool
    {
        return true; // Anyone can view listings
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(?User $user, Car $car): bool
    {
        // Anyone can view approved cars
        if ($car->status === 'approved') {
            return true;
        }
        
        // The owner can view their own cars regardless of status
        if ($user && $car->user_id === $user->id) {
            return true;
        }
        
        // Admins can view all cars
        if ($user && Gate::allows('admin')) {
            return true;
        }
        
        return false;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        // Only admins and sub-admins can create cars
        return $user->isAdmin() || $user->isSubAdmin();
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Car $car): bool
    {
        // The owner can update their own car
        if ($car->user_id === $user->id) {
            return true;
        }
        
        // Admins and sub-admins can update any car
        if ($user->isAdmin() || $user->isSubAdmin()) {
            return true;
        }
        
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Car $car): bool
    {
        // The owner can delete their own car
        if ($car->user_id === $user->id) {
            return true;
        }
        
        // Admins and sub-admins can delete any car
        if ($user->isAdmin() || $user->isSubAdmin()) {
            return true;
        }
        
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Car $car): bool
    {
        return Gate::allows('admin');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Car $car): bool
    {
        return Gate::allows('admin');
    }
}
