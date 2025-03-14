<?php

namespace App\Nova\Metrics;

use App\Models\User;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Metrics\Partition;

class UserPortfolioDistribution extends Partition
{
    /**
     * Calculate the value of the metric.
     *
     * This partitions users into ranges based on their investment amount.
     */
    public function calculate(NovaRequest $request)
    {
        $data = [
            '1M - 5M'    => User::whereBetween('investment_amount', [1000000, 5000000])->count(),
            '5M - 25M'   => User::whereBetween('investment_amount', [5000000, 25000000])->count(),
            '25M - 50M'  => User::whereBetween('investment_amount', [25000000, 50000000])->count(),
            '50M - 60M'  => User::whereBetween('investment_amount', [50000000, 60000000])->count(),
        ];

        return $this->result($data);
    }

    /**
     * Get the displayable name of the metric.
     */
    public function name()
    {
        return 'User Portfolio Distribution';
    }

    /**
     * Get the URI key for the metric.
     */
    public function uriKey()
    {
        return 'user-portfolio-distribution';
    }
}
