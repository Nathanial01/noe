<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\ID;
use App\Models\Contact as Model;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Textarea;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Http\Requests\NovaRequest;
use App\Nova\Metrics\TotalContactMessages;
use App\Nova\Metrics\ContactMessageTrend;
use App\Nova\Metrics\UnreadContactNotifications;

class Contact extends Resource
{
    public static string $model = Model::class;
    public static $title = 'email';
    public static $search = ['id'];

    public function fields(Request $request)
    {
        return [
            ID::make()->sortable(),
            Text::make('First Name')->sortable(),
            Text::make('Last Name')->sortable(),
            Text::make('Email')->sortable(),
            Text::make('Phone'),
            Textarea::make('Message'),
            Boolean::make('Is Read'),
            DateTime::make('Created At')->sortable(),
        ];
    }

    public function cards(NovaRequest $request): array
    {
        return [
            new TotalContactMessages,
            new ContactMessageTrend,
            new UnreadContactNotifications,
        ];
    }

    public function filters(NovaRequest $request): array
    {
        return [];
    }

    public function lenses(NovaRequest $request): array
    {
        return [];
    }

    public function actions(NovaRequest $request): array
    {
        return [];
    }

    /**
     * Override the menu method to display an unread badge.
     */
    public function menu(Request $request)
    {
        return parent::menu($request)->withBadge(function () {
            try {
                // For example, count unread contacts
                return static::$model::where('is_read', false)->count();
            } catch (\Throwable $e) {
                return 0;
            }
        });
    }

    public static function availableForNavigation(Request $request): bool
    {
        return $request->user()?->is_admin ?? false;
    }
}
