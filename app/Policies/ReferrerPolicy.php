<?php

namespace App\Policies;

use App\Models\User;

class ReferrerPolicy
{
   /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->roles()->where('name', ['Admin', 'Agent'])->exists();
    }
}
