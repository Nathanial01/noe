<?php

namespace App\Observers;

use App\Models\User;
use App\Notifications\ReportReadyNotification;
use Laravel\Nova\Notifications\NovaNotification;

class UserObserver
{
    /**
     * Handle the User "created" event.
     */
    public function created(User $user)
    {
        // For example, notify all other users about the new user.
        $otherUsers = User::where('id', '<>', $user->id)->get();
        foreach ($otherUsers as $u) {
            // You can send a Nova notification (or a custom one)
            $u->notify(
                NovaNotification::make()
                    ->message('New user: ' . $user->name)
                    ->icon('user')
                    ->type('success')
            );
        }
    }
}
