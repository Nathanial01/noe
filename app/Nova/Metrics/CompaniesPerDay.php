<?php

namespace App\Nova\Metrics;

use App\Models\Company;
use Laravel\Nova\Metrics\Trend;
use Laravel\Nova\Http\Requests\NovaRequest;

class CompaniesPerDay extends Trend
{
    /**
     * Calculate the value of the metric.
     *
     * This metric counts companies created per day.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return mixed
     */
    public function calculate(NovaRequest $request)
    {
        return $this->countByDays($request, Company::class)
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
            30  => __('30 Days'),
            60  => __('60 Days'),
            90  => __('90 Days'),
            183 => __('6 maanden'),
            365 => __('1 Jaar'),
        ];
    }

    /**
     * Get the displayable name of the metric.
     *
     * @return string
     */
    public function name()
    {
        return 'Nieuwe bedrijven vandaag';
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
        return 'companies-per-day';
    }
}
