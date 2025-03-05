<?php

namespace App\Nova;

use Laravel\Nova\Fields\ID;
use Illuminate\Http\Request; // <-- Parent uses this for certain methods
use Laravel\Nova\Fields\URL;
use Laravel\Nova\Fields\Text;
use App\Nova\Metrics\NewLeads;
use Laravel\Nova\Fields\Email;
use App\Nova\Metrics\LeadsPerDay;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Actions\ExportAsCsv;
use Laravel\Nova\Http\Requests\NovaRequest;

class Lead extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var class-string<\App\Models\Lead>
     */
    public static $model = \App\Models\Lead::class;

    /**
     * The single value that should be used to represent the resource.
     *
     * @var string
     */
    public static $title = 'id';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id',
        'email',
        'address',
        'city',
        'postal_code'
    ];

    /**
     * Make this resource appear only to non-admin users in the sidebar.
     *
     * Must match parent's signature: availableForNavigation(\Illuminate\Http\Request $request).
     */
    public static function availableForNavigation(Request $request): bool
    {
        // TRUE if user *is* admin => admin only
        return $request->user()->is_admin;
    }

    /**
     * For the navigation menu badge.
     *
     * This method is typed to \Illuminate\Http\Request in the parent,
     * so keep it that way as well.
     */
    public function menu(Request $request)
    {
        return parent::menu($request)->withBadge(function () {
            return static::$model::count();
        });
    }

    /**
     * Get the fields displayed by the resource.
     *
     * Matches parent's signature: fields(\Laravel\Nova\Http\Requests\NovaRequest $request)
     */
    public function fields(NovaRequest $request)
    {
        return [
            ID::make()->sortable()->hideFromIndex(),
            Email::make()->sortable(),

            Text::make('Telefoonnummer', 'phone_number')
                ->sortable(),

            Text::make('Adres', 'address')
                ->sortable(),

            Text::make('Plaats', 'city')
                ->sortable(),

            Text::make('Postcode', 'postal_code')
                ->sortable()
                ->hideFromIndex(),

            Text::make('Woonsoort', function () {
                return $this->building_type === 'independent' ? 'Zelfstandig' : 'Onzelfstandig';
            })->sortable(),

            Text::make('Eigenaarstype', 'owner_type'),

            Text::make('Actuele huurprijs', 'current_rental_price')
                ->sortable()
                ->hideFromIndex(),

            DateTime::make('Aangemaakt op', 'created_at')
                ->sortable()
                ->readonly(),

            URL::make('Overzicht', function () {
                return $this->building_type === 'independent'
                    ? route('lead.independent.show', $this)
                    : route('lead.dependent.show', $this);
            })->hideFromIndex(),
        ];
    }

    /**
     * Get the cards available for the request.
     *
     * Matches parent's signature: cards(\Laravel\Nova\Http\Requests\NovaRequest $request)
     */
    public function cards(NovaRequest $request)
    {
        return [
            new NewLeads,
            new LeadsPerDay,
        ];
    }

    /**
     * Get the filters available for the resource.
     */
    public function filters(NovaRequest $request)
    {
        return [];
    }

    /**
     * Get the lenses available for the resource.
     */
    public function lenses(NovaRequest $request)
    {
        return [];
    }

    /**
     * Get the actions available for the resource.
     */
    public function actions(NovaRequest $request)
    {
        return [
            ExportAsCsv::make(),
        ];
    }
}
