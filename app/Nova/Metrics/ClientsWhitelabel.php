<?php

namespace App\Nova\Metrics;

use App\Models\Company;
use Illuminate\Support\Carbon;
use Laravel\Nova\Metrics\Value;
use Laravel\Nova\Http\Requests\NovaRequest;

class ClientsWhitelabel extends Value
{
    /**
     * Calculate the value of the metric.
     *
     * This metric counts all companies with a 'whitelabel' status
     * whose billing expiration date is in the future (greater than today).
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return mixed
     */
    public function calculate(NovaRequest $request)
    {
        return $this->count(
            $request,
            Company::where('status', 'whitelabel')
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
        return 'Whitelabel';
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
}
