<?php

namespace App\Nova\Metrics;

use App\Models\Company;
use Laravel\Nova\Metrics\Value;
use Laravel\Nova\Http\Requests\NovaRequest;

class ConvertionRatio extends Value
{
    /**
     * Calculate the conversion ratio metric.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return mixed
     */
    public function calculate(NovaRequest $request)
    {
        // Total companies count
        $target = Company::count();

        // Count companies with at least one paid transaction
        return $this->count(
            $request,
            Company::whereHas('transactions', function($query) {
                $query->where('status', 'paid');
            }, '>', 0),
            function ($query) {
                return $query;
            },
            target: $target
        );
    }

    /**
     * Get the displayable name of the metric.
     *
     * @return string
     */
    public function name()
    {
        return 'Conversie ratio';
    }

    /**
     * Cache the metric for 5 minutes.
     */
    public function cacheFor()
    {
        return now()->addMinutes(5);
    }

    /**
     * Get the URI key for the metric.
     */
    public function uriKey()
    {
        return 'convertion-ratio';
    }
}
