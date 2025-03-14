<?php

namespace App\Nova\Metrics;

use App\Models\User;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Metrics\Partition;

class NewVsOldUsers extends Partition
{
    public function calculate(NovaRequest $request)
    {
        $thirtyDaysAgo = now()->subDays(30);

        $newUsers = User::where('created_at', '>=', $thirtyDaysAgo)->count();
        $oldUsers = User::where('created_at', '<', $thirtyDaysAgo)->count();

        return $this->result([
            'Nieuw (Laatste 30 Dagen)' => $newUsers,
            'Ouder (Meer dan 30 Dagen)' => $oldUsers,
        ]);
    }

    public function name()
    {
        return 'Nieuwe vs. Oude Gebruikers';
    }

    public function uriKey()
    {
        return 'new-vs-old-users';
    }
}
