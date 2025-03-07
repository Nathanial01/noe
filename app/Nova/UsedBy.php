<?php

namespace App\Nova;

use Laravel\Nova\Fields\ID;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\Text;
use Ebess\AdvancedNovaMediaLibrary\Fields\Images;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Http\Requests\NovaRequest;

class UsedBy extends Resource
{
    protected string $collection = 'usedbys';

    public static $model = \App\Models\UsedBy::class;
    public static $title = 'altText';
    public static $showPollingToggle = true;
    public static $search = ['id', 'altText'];

    public static function label()
    {
        return __('Gebruikt door');
    }

    public static function singularLabel()
    {
        return __('Gebruikt door');
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
            Text::make('Alt Text')->sortable()->rules('required', 'max:255'),
            Images::make('Logo', 'logo')->rules('required'),
            DateTime::make('Aangemaakt op', 'created_at')->sortable()->readonly(),
        ];
    }

    public function cards(NovaRequest $request)
    {
        return [];
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
        return [];
    }

    public static function availableForNavigation(Request $request): bool
    {
        return $request->user()?->is_admin ?? false;
    }
}
