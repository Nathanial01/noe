<?php

namespace App\Nova\Filters;

use Laravel\Nova\Filters\Filter;
use Laravel\Nova\Http\Requests\NovaRequest;

class PayingCompany extends Filter
{
    /**
     * The filter's component.
     *
     * @var string
     */
    public $component = 'select-filter';

    /**
     * Apply the filter to the given query.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  mixed  $value
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function apply(NovaRequest $request, $query, $value)
    {
        if($value == 'all')
        {
            return $query;
        } else if ($value == 'paid') {
            return $query->whereHas('transactions', function($q){
              $q->where('status', '=', 'paid');
          })->get();
        } else if ($value == 'nonpaid') {
            return $query->doesntHave('transactions')->orWhereHas('transactions', function($q){
                $q->where('status', '!=', 'paid');
            })->get();
        } else {
            return $query;
        }
        
    }

    /**
     * Get the filter's available options.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function options(NovaRequest $request)
    {
        return [
          'Alle' => 'all',
          'Heeft abonnement' => 'paid',
          'Geen geen abonnement' => 'nonpaid',
        ];
    }
}
