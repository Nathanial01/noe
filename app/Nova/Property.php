<?php

namespace App\Nova;

use Laravel\Nova\Fields\ID;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\BelongsTo;
use App\Nova\Metrics\NewProperties;
use Laravel\Nova\Actions\ExportAsCsv;
use App\Nova\Metrics\PropertiesPerDay;
use Laravel\Nova\Http\Requests\NovaRequest;

class Property extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var class-string<\App\Models\User>
     */
    public static $model = \App\Models\Property::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'address';

    /**
     * Get the displayable label of the resource.
     *
     * @return string
     */
    public static function label()
    {
        return __('Woningen');
    }

    /**
     * Get the displayable singular label of the resource.
     *
     * @return string
     */
    public static function singularLabel()
    {
        return __('Woning');
    }

    public static function authorizable()
    {
        return false;
    }


    /**
     * Indicates whether to show the polling toggle button inside Nova.
     *
     * @var bool
     */
    public static $showPollingToggle = true;

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id',
        'name',
    ];

    /**
     * Get the menu that should represent the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Laravel\Nova\Menu\MenuItem
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
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function fields(NovaRequest $request)
    {
        return [
            ID::make()->sortable(),

            Text::make('Adres', 'address')
                ->sortable(),

            Text::make('Plaats', 'city')
                ->sortable(),

            Text::make('Postcode', 'postal_code')
                ->sortable(),

            Text::make('Bouwjaar', 'construction_year')
                ->sortable()
                ->hideFromIndex(),

            Text::make('Actuele huurprijs', 'current_rental_price')
                ->sortable()
                ->hideFromIndex(),

            hasMany::make('checks'),

            BelongsTo::make('company'),

        ];
    }

    /**
     * Get the cards available for the request.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function cards(NovaRequest $request)
    {
        return [
            new NewProperties,
            new PropertiesPerDay
        ];
    }

    /**
     * Get the filters available for the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function filters(NovaRequest $request)
    {
        return [];
    }

    /**
     * Get the lenses available for the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function lenses(NovaRequest $request)
    {
        return [];
    }

    /**
     * Get the actions available for the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function actions(NovaRequest $request)
    {
        return [
            ExportAsCsv::make(),
        ];
    }

    public static function authorizedToCreate(Request $request)
    {
        return false;
    }
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
}
