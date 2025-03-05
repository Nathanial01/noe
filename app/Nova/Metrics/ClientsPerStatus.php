<?php

namespace App\Nova\Metrics;

use Carbon\Carbon;
use App\Models\Company;
use Laravel\Nova\Metrics\Partition;
use Laravel\Nova\Http\Requests\NovaRequest;

class ClientsPerStatus extends Partition
{
    /**
     * Calculate the value of the metric.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return mixed
     */
    public function calculate(NovaRequest $request)
    {
        return $this->count($request, Company::whereDate('billing_expiration_date', '>', Carbon::today()), 'status');
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
    * Get the displayable name of the metric
    *
    * @return string
    */
    public function name()
    {
        return 'Abonnementen';
    }

    /**
     * Get the URI key for the metric.
     *
     * @return string
     */
    public function uriKey()
    {
        return 'clients-per-status';
    }
}
