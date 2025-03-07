<?php

namespace App\Nova;

use Laravel\Nova\Fields\ID;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Trix;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Http\Requests\NovaRequest;

class Feedback extends Resource
{
    protected string $collection = 'feedbacks';

    public static $model = \App\Models\Feedback::class;
    public static $title = 'id';

    public static function label()
    {
        return __('Feedback');
    }

    public static function singularLabel()
    {
        return __('Feedback');
    }

    public static $search = [
        'type',
    ];

    public static function authorizedToCreate(Request $request)
    {
        return false;
    }

    public function authorizedToDelete(Request $request)
    {
        return true;
    }

    public function authorizedToUpdate(Request $request)
    {
        return false;
    }

    public function authorizedToReplicate(Request $request)
    {
        return false;
    }

    public function fields(NovaRequest $request)
    {
        return [
            ID::make()->sortable(),
            Text::make('Soort', 'type')->sortable(),
            Text::make('Telefoon nummer', 'phone_number'),
            Trix::make('Description')->alwaysShow(),
            BelongsTo::make('user'),
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
}
