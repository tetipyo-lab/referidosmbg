<?php

namespace App\Policies;

use App\Models\User;

class ReferredLinkPolicy
{
    public function __construct()
    {
        //
    }
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->roles()->whereIn('name', ['Admin', 'Agent','Referrer'])->exists();
    }

    public function create(User $user): bool
    {
        return $user->roles()->whereIn('name', ['Admin', 'Agent'])->exists();
    }
    
    public function update(User $user): bool
    {
        return $user->roles()->whereIn('name', ['Admin', 'Agent'])->exists();
    }
}
