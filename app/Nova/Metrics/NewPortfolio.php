<?php

namespace App\Nova\Metrics;

use App\Models\Portfolio;
use Laravel\Nova\Metrics\Value;
use Laravel\Nova\Http\Requests\NovaRequest;

class NewPortfolio extends Value
{
    /**
     * Calculate the number of portfolios.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return mixed
     */
    public function calculate(NovaRequest $request)
    {
        return $this->count($request, Portfolio::class);
    }

    public function ranges()
    {
        return [
            'ALL'   => 'All Time',
            'YTD'   => __('Year To Date'),
            'TODAY' => __('Today'),
            30      => __('30 Days'),
            60      => __('60 Days'),
            365     => __('365 Days'),
            'MTD'   => __('Month To Date'),
            'QTD'   => __('Quarter To Date'),
        ];
    }

    public function name()
    {
        return 'Portefeuilles';
    }

    public function cacheFor()
    {
        return now()->addMinutes(5);
    }
}
