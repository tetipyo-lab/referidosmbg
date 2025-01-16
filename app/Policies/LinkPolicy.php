<?php

namespace App\Policies;

use App\Models\User;

class LinkPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }
    
    public function viewAny(User $user): bool
    {
        return $user->roles()->whereIn('name', ['Admin', 'Agent'])->exists();
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
