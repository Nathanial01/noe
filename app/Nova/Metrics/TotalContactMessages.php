<?php

namespace App\Nova\Metrics;

use App\Models\Contact;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Metrics\Value;

class TotalContactMessages extends Value
{
    public function calculate(NovaRequest $request)
    {
        return $this->result(Contact::count());
    }

    public function uriKey(): string
    {
        return 'total-contact-messages';
    }

    public function name(): string
    {
        return 'Totaal Contactberichten';
    }
}
