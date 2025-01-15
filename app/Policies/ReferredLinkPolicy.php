<?php

namespace App\Policies;

use App\Models\RerferredLink;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ReferredLinkPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->roles()->where('name', ['Admin', 'Agent', 'Refererrer'])->exists();
    }
}
