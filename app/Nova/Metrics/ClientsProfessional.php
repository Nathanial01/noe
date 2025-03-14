<?php

namespace App\Nova\Metrics;

use App\Models\Company;
use Illuminate\Support\Carbon;
use Laravel\Nova\Metrics\Value;
use Laravel\Nova\Http\Requests\NovaRequest;

class ClientsProfessional extends Value
{
    /**
     * Calculate the value of the metric.
     *
     * Counts the number of companies with status "professional"
     * and with a billing expiration date in the future.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return mixed
     */
    public function calculate(NovaRequest $request)
    {
        return $this->count(
            $request,
            Company::where('status', 'professional')
                ->whereDate('billing_expiration_date', '>', Carbon::today())
        )->format([
            'thousandSeparated' => true,
            'mantissa'          => 0,
        ]);
    }

    /**
     * Get the displayable name of the metric.
     *
     * @return string
     */
    public function name()
    {
        return 'Professional';
    }

    /**
     * Get the ranges available for the metric.
     *
     * @return array
     */
    public function ranges()
    {
        return [
            'ALL' => 'Huidig',  // "Huidig" means "Current"
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
        return 'clients-professional';
    }
}
