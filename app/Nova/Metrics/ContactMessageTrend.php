<?php

namespace App\Nova\Metrics;

use App\Models\Contact;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Metrics\Trend;

class ContactMessageTrend extends Trend
{
    public function calculate(NovaRequest $request)
    {
        return $this->countByDays($request, Contact::class);
    }

    public function uriKey(): string
    {
        return 'contact-message-trend';
    }

    public function name(): string
    {
        return 'Contactbericht Trend';
    }
}
