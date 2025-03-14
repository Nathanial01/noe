<?php

namespace App\Nova\Metrics;

use Carbon\Carbon;
use App\Models\Company;
use Laravel\Nova\Metrics\Progress;
use Laravel\Nova\Http\Requests\NovaRequest;

class AnualChurn extends Progress
{
    /**
     * Calculate the value of the metric.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return mixed
     */
    public function calculate(NovaRequest $request)
    {
        $oneYearAgo = Carbon::today()->subYear();

        // Count companies with specific statuses that expired in the last year
        $target = Company::where(function ($query) {
            $query->where('status', 'premium')
                ->orWhere('status', 'standard')
                ->orWhere('status', 'professional')
                ->orWhere('status', 'professional-xl')
                ->orWhere('status', 'unlimited')
                ->orWhere('status', 'whitelabel');
        })
            ->where('billing_expiration_date', '<=', Carbon::today())
            ->where('billing_expiration_date', '>', $oneYearAgo)
            ->count();

        // Count companies with exactly one paid transaction
        return $this->count(
            $request,
            Company::whereHas('transactions', function ($query) {
                $query->where('status', 'paid');
            }, '=', 1)
                ->where('billing_expiration_date', '<=', Carbon::today())
                ->where('billing_expiration_date', '>', $oneYearAgo),
            function ($query) {
                return $query;
            },
            target: $target
        );
    }

    /**
     * Determine the amount of time the results of the metric should be cached.
     *
     * @return \DateTimeInterface|\DateInterval|float|int
     */
    public function cacheFor()
    {
        return now()->addMinutes(5);
    }

    /**
     * Get the displayable name of the metric.
     *
     * @return string
     */
    public function name()
    {
        return 'Jaarlijkse Churn rate';
    }

    /**
     * Get the URI key for the metric.
     *
     * @return string
     */
    public function uriKey()
    {
        return 'anual-churn';
    }
}
