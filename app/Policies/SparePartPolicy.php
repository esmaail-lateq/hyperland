<?php

namespace App\Policies;

use Illuminate\Auth\Access\Response;
use App\Models\SparePart;
use App\Models\User;
use Illuminate\Support\Facades\Gate;

class SparePartPolicy
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
    public function view(?User $user, SparePart $sparePart): bool
    {
        // Anyone can view approved spare parts
        if ($sparePart->approval_status === 'approved') {
            return true;
        }
        
        // The owner can view their own spare parts regardless of status
        if ($user && $sparePart->created_by === $user->id) {
            return true;
        }
        
        // Admins and sub-admins can view all spare parts
        if ($user && ($user->isAdmin() || $user->isSubAdmin())) {
            return true;
        }
        
        return false;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        // Only admins and sub-admins can create spare parts
        return $user->isAdmin() || $user->isSubAdmin();
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, SparePart $sparePart): bool
    {
        // The owner can update their own spare part
        if ($sparePart->created_by === $user->id) {
            return true;
        }
        
        // Admins and sub-admins can update any spare part
        if ($user->isAdmin() || $user->isSubAdmin()) {
            return true;
        }
        
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, SparePart $sparePart): bool
    {
        // The owner can delete their own spare part
        if ($sparePart->created_by === $user->id) {
            return true;
        }
        
        // Admins and sub-admins can delete any spare part
        if ($user->isAdmin() || $user->isSubAdmin()) {
            return true;
        }
        
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, SparePart $sparePart): bool
    {
        return $user->isAdmin() || $user->isSubAdmin();
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, SparePart $sparePart): bool
    {
        return $user->isAdmin() || $user->isSubAdmin();
    }
}
