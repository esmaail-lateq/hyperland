<?php

namespace App\Policies;

use Illuminate\Auth\Access\Response;
use App\Models\Car;
use App\Models\User;

class FavoritePolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine whether the user can toggle favorite status for a car.
     */
    public function toggle(User $user, Car $car): bool
    {
        // Users can only favorite approved cars
        if ($car->status !== 'approved') {
            return false;
        }

        // Users can't favorite their own cars
        if ($car->user_id === $user->id) {
            return false;
        }

        return true;
    }

    /**
     * Determine whether the user can view their favorite cars.
     */
    public function viewOwn(User $user): bool
    {
        return true; // Any authenticated user can view their favorites
    }
}
