<?php

namespace App\Policies;

use Illuminate\Auth\Access\Response;
use App\Models\User;
use Illuminate\Support\Facades\Gate;

class UserPolicy
{
    /**
     * Determine whether the user can view the model.
     */
    public function view(?User $user, User $model): bool
    {
        // If the user is a dealer, anyone can view their profile
        if ($model->isDealer()) {
            return true;
        }
        
        // Only the user themselves or admins can view the profile
        return $user && ($user->id === $model->id || Gate::allows('admin'));
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, User $model): bool
    {
        // Only the user themselves or admins can update the profile
        return $user->id === $model->id || Gate::allows('admin');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, User $model): bool
    {
        // Only the user themselves or admins can delete the profile
        return $user->id === $model->id || Gate::allows('admin');
    }
}
