<?php

namespace App\Nova;

use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Resource;

class Notification extends Resource
{
    public static $model = \App\Models\Notification::class;

    public static $title = 'message';

    public static $search = ['id', 'message'];

    public function fields(NovaRequest $request)
    {
        return [
            ID::make()->sortable(),
            BelongsTo::make('User', 'user', User::class)->sortable(),
            Text::make('Type')->sortable(),
            Text::make('Message')->sortable(),
        ];
    }
}
