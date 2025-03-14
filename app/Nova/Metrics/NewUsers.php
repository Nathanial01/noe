<?php

namespace App\Nova\Metrics;

use App\Models\User;
use Laravel\Nova\Metrics\Value;
use Laravel\Nova\Http\Requests\NovaRequest;

class NewUsers extends Value
{
    /**
     * Calculate the value of the metric.
     *
     * This metric counts the number of new users stored in your SQL database,
     * filtered by the selected range.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return mixed
     */
    public function calculate(NovaRequest $request)
    {
        // The "count" helper method applies the appropriate time filter based on the range.
        return $this->count($request, User::class)
            ->format([
                'thousandSeparated' => true,
                'mantissa'          => 0,
            ]);
    }

    /**
     * Get the ranges available for the metric.
     *
     * @return array
     */
    public function ranges()
    {
        return [
            'ALL'   => 'All Time',
            'YTD'   => __('Year To Date'),
            'TODAY' => __('Today'),
            7       => __('Last Week'),
            30      => __('30 Days'),
            60      => __('60 Days'),
            365     => __('365 Days'),
            'MTD'   => __('Month To Date'),
            'QTD'   => __('Quarter To Date'),
        ];
    }

    /**
     * Get the displayable name of the metric.
     *
     * @return string
     */
    public function name()
    {
        return 'Nieuwe Gebruikers';
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
}
