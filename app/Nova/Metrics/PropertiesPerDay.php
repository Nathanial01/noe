<?php

namespace App\Nova\Metrics;

use App\Models\Property;
use Laravel\Nova\Metrics\Trend;
use Laravel\Nova\Http\Requests\NovaRequest;

class PropertiesPerDay extends Trend
{
    /**
     * Calculate the daily count of properties.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return mixed
     */
    public function calculate(NovaRequest $request)
    {
        return $this->countByDays($request, Property::class)
            ->format([
                'thousandSeparated' => true,
                'mantissa' => 0,
            ])
            ->showLatestValue();
    }

    public function ranges()
    {
        return [
            30   => __('30 Days'),
            60   => __('60 Days'),
            90   => __('90 Days'),
            183  => __('6 maanden'),
            365  => __('1 Jaar'),
        ];
    }

    public function name()
    {
        return 'Nieuwe woningen vandaag';
    }

    public function cacheFor()
    {
        return now()->addMinutes(5);
    }

    public function uriKey()
    {
        return 'properties-per-day';
    }
}
