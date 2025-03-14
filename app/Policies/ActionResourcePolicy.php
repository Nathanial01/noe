<?php

namespace App\Policies;

use App\Models\User;
use Laravel\Nova\Actions\ActionResource;

class ActionResourcePolicy
{
    /**
     * Determine whether the user can create a new ActionResource.
     *
     * @param  \App\Models\User  $user
     * @param  \Laravel\Nova\Actions\ActionResource  $actionResource
     * @return bool
     */
    public function create(User $user, ActionResource $actionResource)
    {
        // Allow creation only for admin users
        return $user->is_admin;
    }

    // Optionally, you can define other methods like view, update, delete if needed.
}
