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

    /**
     * Get the displayable label of the resource.
     *
     * @return string
     */
    public static function label()
    {
        return __('Agenda Events');
    }

    /**
     * Get the displayable singular label of the resource.
     *
     * @return string
     */
    public static function singularLabel()
    {
        return __('Agenda Event');
    }

    /**
     * Make this resource appear only to admin users in the sidebar.
     *
     * @param  Request  $request
     * @return bool
     */
    public static function availableForNavigation(Request $request): bool
    {
        return $request->user()?->is_admin ?? false;
    }

    /**
     * Get the fields displayed by the resource.
     *
     * @param  NovaRequest  $request
     * @return array
     */
    public function fields(NovaRequest $request)
    {
        return [
            // For MySQL, use the default primary key "id".
            ID::make('ID')->sortable(),

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

    /**
     * Get the cards available for the request.
     *
     * @param  NovaRequest  $request
     * @return array
     */
    public function cards(NovaRequest $request)
    {
        return [];
    }

    /**
     * Get the filters available for the resource.
     *
     * @param  NovaRequest  $request
     * @return array
     */
    public function filters(NovaRequest $request)
    {
        return [];
    }

    /**
     * Get the lenses available for the resource.
     *
     * @param  NovaRequest  $request
     * @return array
     */
    public function lenses(NovaRequest $request)
    {
        return [];
    }

    /**
     * Get the actions available for the resource.
     *
     * @param  NovaRequest  $request
     * @return array
     */
    public function actions(NovaRequest $request): array
    {
        return [];
    }
}
