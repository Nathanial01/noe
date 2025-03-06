<?php

namespace App\Nova\Metrics;

use Carbon\Carbon;
use App\Models\Company;
use Laravel\Nova\Metrics\Progress;
use Laravel\Nova\Http\Requests\NovaRequest;

class ConvertionRatio extends Progress
{
    /**
     * Calculate the value of the metric.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return mixed
     */
    public function calculate(NovaRequest $request)
    {

        $target = Company::all()->count();

        return $this->count($request, Company::whereHas('transactions', function($query) {
          $query->where('status', 'paid');
      }, '>', 0), function ($query) {
            return $query;
        }, target: $target);
    }

    /**
    * Get the displayable name of the metric
    *
    * @return string
    */
    public function name()
    {
        return 'Conversie ratio';
    }

    /**
     * Determine the amount of time the results of the metric should be cached.
     *
     * @return  \DateTimeInterface|\DateInterval|float|int
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
        return 'convertion-ratio';
    }
}
