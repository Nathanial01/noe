<?php

namespace App\Nova\Metrics;

use App\Models\Company;
use Illuminate\Support\Carbon;
use Laravel\Nova\Metrics\Value;
use Laravel\Nova\Http\Requests\NovaRequest;

class ClientsStandard extends Value
{
    /**
     * Calculate the value of the metric.
     *
     * Counts companies with status 'standard' and a billing expiration date in the future.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return mixed
     */
    public function calculate(NovaRequest $request)
    {
        return $this->count(
            $request,
            Company::where('status', 'standard')
                ->whereDate('billing_expiration_date', '>', Carbon::today())
        )->format([
            'thousandSeparated' => true,
            'mantissa' => 0,
        ]);
    }

    /**
     * Get the displayable name of the metric.
     *
     * @return string
     */
    public function name()
    {
        return 'Standard';
    }

    /**
     * Get the ranges available for the metric.
     *
     * @return array
     */
    public function ranges()
    {
        return [
            'ALL' => 'Huidig',
        ];
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
        return 'clients-standard';
    }
}
