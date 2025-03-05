<?php

namespace App\Nova;

use Illuminate\Support\Str;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Date;
use Laravel\Nova\Fields\Textarea;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Resource;
use Laravel\Nova\Panel;

class AgendaEvent extends Resource
{
    public static string $model = 'App\Models\AgendaEvent';

    public static $title = 'title';

    public static $search = ['title', 'place', 'location'];

    /**
     * Accessor for the Google Maps embed URL.
     */
    public function getMapEmbedAttribute(): ?string
    {
        if (!empty($this->location)) {
            $formattedLocation = Str::replace([',', ' '], ['', '+'], $this->location);
            $apiKey = config('services.google.javascript_maps');
            return "https://www.google.com/maps/embed/v1/place?q={$formattedLocation}&key={$apiKey}";
        }
        return null;
    }

    public function fields(NovaRequest $request): array
    {
        return [
            ID::make()->sortable(),

            // Title field.
            Text::make('Title')
                ->sortable()
                ->rules('required'),

            Date::make('Start Date', 'start_date')
                ->sortable()
                ->rules('required', 'date')
                ->help('Select the start date for the event.'),

            Date::make('End Date', 'end_date')
                ->sortable()
                ->rules('required', 'date')
                ->help('Select the end date for the event.'),

            Text::make('Start Time', 'start_time')
                ->rules('required', 'regex:/^([0-1]?[0-9]|2[0-3]):[0-5][0-9]$/')
                ->help('Enter the start time in 24-hour format (HH:MM).'),

            Text::make('End Time', 'end_time')
                ->rules('required', 'regex:/^([0-1]?[0-9]|2[0-3]):[0-5][0-9]$/')
                ->help('Enter the end time in 24-hour format (HH:MM).'),

            Text::make('Place')
                ->rules('required', 'regex:/^[A-Za-z0-9\s]+$/')
                ->help('Enter the place using only letters, numbers, and spaces.'),

            Textarea::make('Description')
                ->rules('nullable')
                ->help('Enter a description for the event.'),

            Text::make('Location')
                ->sortable()
                ->rules('required')
                ->help('Enter the event location. The map preview will update automatically.'),

            // Event URL fields:
            // Editable field on forms:
            Text::make('Event URL', 'event_url')
                ->onlyOnForms()
                ->rules('nullable', 'url')
                ->help('Enter the registration URL for the event.'),

            // Display-only field on index and detail views:
            Text::make('Event URL', 'event_link')
                ->exceptOnForms()
                ->asHtml()
                ->displayUsing(function ($link) {
                    return $link ? '<a href="' . $link . '" target="_blank">' . $link . '</a>' : '-';
                }),

            // Panel for live map viewer on forms.
            new Panel('Map Viewer', [
                Text::make('Map Viewer', function () {
                    return '';
                })
                    ->asHtml()
                    ->onlyOnForms()
                    ->dependsOn(['location'], function ($field, $request, $formData) {
                        $location = data_get($formData, 'location');
                        if ($location) {
                            $formattedLocation = Str::replace([',', ' '], ['', '+'], $location);
                            $apiKey = config('services.google.javascript_maps');
                            $mapEmbed = "https://www.google.com/maps/embed/v1/place?q={$formattedLocation}&key={$apiKey}";
                            $field->value = <<<HTML
<div style="margin-top: 1rem;">
    <div class="w-full h-64">
        <iframe class="w-full h-full rounded-lg shadow"
                style="border:0"
                src="{$mapEmbed}"
                allowfullscreen
                loading="lazy">
        </iframe>
    </div>
</div>
HTML;
                        } else {
                            $field->value = '<p>Please enter a location to view the map.</p>';
                        }
                    }),
            ]),

            // Panel for detail view map viewer.
            new Panel('Map Viewer (Detail)', [
                Text::make('Map Viewer', function ($event) {
                    if (!empty($event->location)) {
                        $formattedLocation = Str::replace([',', ' '], ['', '+'], $event->location);
                        $apiKey = config('services.google.javascript_maps');
                        $mapEmbed = "https://www.google.com/maps/embed/v1/place?q={$formattedLocation}&key={$apiKey}";
                        return <<<HTML
<div style="margin-top: 1rem;">
    <div class="w-full h-64">
        <iframe class="w-full h-full rounded-lg shadow"
                style="border:0"
                src="{$mapEmbed}"
                allowfullscreen
                loading="lazy">
        </iframe>
    </div>
</div>
HTML;
                    }
                    return '<p>No location provided.</p>';
                })
                    ->asHtml()
                    ->onlyOnDetail(),
            ]),

            // Cancelled flag.
            Boolean::make('Cancelled')
                ->help('Mark the event as cancelled if needed.'),
        ];
    }
    /**
     * Make this resource appear only to non-admin users in the sidebar.
     *
     * Must match parent's signature: availableForNavigation(\Illuminate\Http\Request $request).
     */
    public static function availableForNavigation(Request|\Illuminate\Http\Request $request): bool
    {
        // TRUE if user *is* admin => admin only
        return $request->user()->is_admin;
    }
}
