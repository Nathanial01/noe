<?php

namespace App\Nova\Metrics;

use App\Models\Check;
use Laravel\Nova\Metrics\Trend;
use Laravel\Nova\Http\Requests\NovaRequest;

class ChecksPerDay extends Trend
{
    /**
     * Calculate the value of the metric.
     *
     * In this SQL setup, we assume the Check model is configured for MySQL.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return mixed
     */
    public function calculate(NovaRequest $request)
    {
        return $this->countByDays($request, Check::class)
            ->format([
                'thousandSeparated' => true,
                'mantissa' => 0,
            ])
            ->showLatestValue();
    }

    /**
     * Get the ranges available for the metric.
     *
     * @return array
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
     * Get the displayable name of the metric.
     *
     * @return string
     */
    public function name()
    {
        return 'Checks vandaag';
    }

    /**
     * Determine the amount of time the results of the metric should be cached.
     *
     * @return \DateTimeInterface|\DateInterval|float|int|null
     */
    public function cacheFor()
    {
        return now()->addMinutes(5);
    }

    /**
     * Get the URI key for the metric.
     *
     * @return string
     */
    public function uriKey()
    {
        return 'checks-per-day';
    }
}
