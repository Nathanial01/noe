<?php

namespace App\Nova\Metrics;

use Illuminate\Support\Facades\DB;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Metrics\Value;

class UnreadContactNotifications extends Value
{
    public function calculate(NovaRequest $request)
    {
        $count = DB::table('notifications')
            ->where('read', false)
            ->count();

        return $this->result($count);
    }

    public function uriKey(): string
    {
        return 'unread-contact-notifications';
    }

    public function name(): string
    {
        return 'Ongelezen Contact Notificaties';
    }
}
