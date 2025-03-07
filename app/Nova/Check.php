<?php

namespace App\Nova;

use Laravel\Nova\Fields\ID;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\BelongsTo;
use App\Nova\Metrics\NewProperties;
use Laravel\Nova\Actions\ExportAsCsv;
use App\Nova\Metrics\PropertiesPerDay;
use Laravel\Nova\Http\Requests\NovaRequest;

class Check extends Resource
{
    // MongoDB collection name for Check documents.
    protected string $collection = 'checks';

    public static $model = \App\Models\Check::class;
    public static $title = 'id';
    public static $search = ['id'];

    public static function label()
    {
        return __('Checks');
    }

    public static function singularLabel()
    {
        return __('Check');
    }

    public static $showPollingToggle = true;

    public static function authorizable()
    {
        return false;
    }

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
            BelongsTo::make('property'),
            BelongsTo::make('user'),
            Number::make('Punten', 'points')->sortable(),
            Text::make('Huurprijs', 'price')->sortable(),
            Text::make('Status')->sortable(),
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
        // Show this resource only to admin users.
        return $request->user()->is_admin;
    }
}
