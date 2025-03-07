<?php

namespace App\Nova;

use Laravel\Nova\Fields\ID;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\HasMany;
use App\Nova\Metrics\NewProperties;
use App\Nova\Metrics\PropertiesPerDay;
use Laravel\Nova\Actions\ExportAsCsv;
use Laravel\Nova\Http\Requests\NovaRequest;

class Property extends Resource
{
    protected string $collection = 'properties';

    public static $model = \App\Models\Property::class;
    public static $title = 'address';

    public static function label()
    {
        return __('Woningen');
    }

    public static function singularLabel()
    {
        return __('Woning');
    }

    public static function authorizable()
    {
        return false;
    }

    public static $showPollingToggle = true;
    public static $search = ['id', 'name'];

    public function menu(Request $request)
    {
        return parent::menu($request)->withBadge(function () {
            try {
                return static::$model::count();
            } catch (\Throwable $e) {
                return 0;
            }
        });
    }

    public function fields(NovaRequest $request)
    {
        return [
            ID::make()->sortable(),
            Text::make('Adres', 'address')->sortable(),
            Text::make('Plaats', 'city')->sortable(),
            Text::make('Postcode', 'postal_code')->sortable(),
            Text::make('Bouwjaar', 'construction_year')->sortable()->hideFromIndex(),
            Text::make('Actuele huurprijs', 'current_rental_price')->sortable()->hideFromIndex(),
            HasMany::make('checks'),
            BelongsTo::make('company'),
        ];
    }

    public function cards(NovaRequest $request)
    {
        return [
            new NewProperties,
            new PropertiesPerDay
        ];
    }

    public function filters(NovaRequest $request)
    {
        return [];
    }

    public function lenses(NovaRequest $request)
    {
        return [];
    }

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

    public static function availableForNavigation(Request $request): bool
    {
        return $request->user()->is_admin;
    }
}
