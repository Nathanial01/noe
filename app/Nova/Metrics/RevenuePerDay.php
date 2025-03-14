<?php

namespace App\Nova\Metrics;

use App\Models\Transaction;
use Laravel\Nova\Metrics\Trend;
use Laravel\Nova\Http\Requests\NovaRequest;

class RevenuePerDay extends Trend
{
    /**
     * Calculate the daily revenue.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return mixed
     */
    public function calculate(NovaRequest $request)
    {
        return $this->sumByDays(
            $request,
            Transaction::where('status', 'paid'),
            'subtotal'
        )->prefix('€')->format([
            'thousandSeparated' => true,
            'mantissa' => 2,
        ])->showLatestValue();
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
        return 'Omzet vandaag';
    }

    public function cacheFor()
    {
        return now()->addMinutes(5);
    }

    public function uriKey()
    {
        return 'revenue-per-day';
    }
}
