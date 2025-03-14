<?php

namespace App\Nova\Metrics;

use App\Models\Transaction;
use Laravel\Nova\Metrics\Value;
use Laravel\Nova\Http\Requests\NovaRequest;

class TotalRevenue extends Value
{
    /**
     * Calculate the total revenue.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return mixed
     */
    public function calculate(NovaRequest $request)
    {
        return $this->sum(
            $request,
            Transaction::where('status', 'paid'),
            'subtotal'
        )->currency('€')->format([
            'thousandSeparated' => true,
            'mantissa' => 2,
        ]);
    }

    public function name()
    {
        return 'Omzet';
    }

    public function ranges()
    {
        return [
            'ALL'   => 'All Time',
            'YTD'   => __('Year To Date'),
            'TODAY' => __('Today'),
            7       => __('Last week'),
            30      => __('30 Days'),
            60      => __('60 Days'),
            365     => __('365 Days'),
            'MTD'   => __('Month To Date'),
            'QTD'   => __('Quarter To Date'),
        ];
    }

    public function cacheFor()
    {
        return now()->addMinutes(5);
    }
}
