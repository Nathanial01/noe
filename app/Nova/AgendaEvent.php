<?php

namespace App\Nova;

use Laravel\Nova\Fields\ID;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Http\Requests\NovaRequest;

class AgendaEvent extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var class-string<\App\Models\AgendaEvent>
     */
    public static $model = \App\Models\AgendaEvent::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'title';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id', 'title', 'description'
    ];

    public static function label()
    {
        return __('Agenda Events');
    }

    public static function singularLabel()
    {
        return __('Agenda Event');
    }

    /**
     * Appear only to admin users.
     */
    public static function availableForNavigation(Request $request): bool
    {
        return $request->user()?->is_admin ?? false;
    }

    /**
     * Get the fields displayed by the resource.
     */
    public function fields(NovaRequest $request)
    {
        return [
            ID::make()->sortable(),
            Text::make('Title')
                ->sortable()
                ->rules('required', 'max:255'),
            Text::make('Description')
                ->hideFromIndex(),
            DateTime::make('Start Daytime', 'start_daytime')
                ->sortable(),
            DateTime::make('End Daytime', 'end_daytime')
                ->sortable(),
            Text::make('Place')
                ->sortable(),
            Text::make('Location')
                ->sortable(),
            Text::make('Event URL', 'event_url')
                ->hideFromIndex(),
            Boolean::make('Cancelled')
                ->sortable(),
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
