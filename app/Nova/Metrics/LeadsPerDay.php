<?php

namespace App\Nova\Metrics;

use App\Models\Lead;
use Laravel\Nova\Metrics\Trend;
use Laravel\Nova\Http\Requests\NovaRequest;

class LeadsPerDay extends Trend
{
    /**
     * Calculate new leads per day.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return mixed
     */
    public function calculate(NovaRequest $request)
    {
        return $this->countByDays($request, Lead::class)
            ->format([
                'thousandSeparated' => true,
                'mantissa' => 0,
            ])
            ->showLatestValue();
    }

    /**
     * Available ranges for the trend.
     */
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

    /**
     * Displayable name.
     */
    public function name()
    {
        return 'Nieuwe leads vandaag';
    }

    /**
     * Cache duration.
     */
    public function cacheFor()
    {
        return now()->addMinutes(5);
    }

    /**
     * URI key.
     */
    public function uriKey()
    {
        return 'leads-per-day';
    }
}
