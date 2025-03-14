<?php

namespace App\Nova\Metrics;

use App\Models\User;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Metrics\Trend;

class UserTrend extends Trend
{
    /**
     * Calculate the value of the metric.
     *
     * We choose the grouping method based on the requested range.
     */
    public function calculate(NovaRequest $request)
    {
        $range = $request->range;

        if (is_numeric($range)) {
            if ($range <= 30) {
                // For a range of up to 30 days, group by days.
                return $this->countByDays($request, User::class);
            } elseif ($range <= 365) {
                // For a range up to one year, group by months.
                return $this->countByMonths($request, User::class);
            } else {
                // For ranges longer than one year (e.g., five years), group by years.
                return $this->countByYears($request, User::class);
            }
        }

        // For string ranges such as 'YTD', 'MTD', or 'QTD', default to daily grouping.
        return $this->countByDays($request, User::class);
    }

    /**
     * Get the ranges available for the metric.
     *
     * You can customize these ranges as needed.
     */
    public function ranges()
    {
        return [
            7       => 'Last 7 Days',
            30      => 'Last 30 Days',
            365     => 'Last 365 Days',
            1825    => 'Last 5 Years',
            'ALL'   => 'All Time',
            'YTD'   => 'Year To Date',
            'MTD'   => 'Month To Date',
            'QTD'   => 'Quarter To Date',
        ];
    }

    /**
     * Get the displayable name of the metric.
     */
    public function name()
    {
        return 'Gebruikerstijging';
    }

    /**
     * Get the URI key for the metric.
     */
    public function uriKey()
    {
        return 'user-trend';
    }
}
