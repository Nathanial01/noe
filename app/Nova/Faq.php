<?php

namespace App\Nova;

use Laravel\Nova\Fields\ID;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\Slug;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Trix;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Textarea;
use Laravel\Nova\Http\Requests\NovaRequest;

class Faq extends Resource
{
    protected string $collection = 'faqs';

    public static string $model = \App\Models\Faq::class;
    public static $title = 'id';

    public static function label(): string
    {
        return __('Kennisbank & FAQ');
    }

    public static function singularLabel(): string
    {
        return __('Faq');
    }

    public static $search = [
        'title',
    ];

    public function fields(NovaRequest $request): array
    {
        return [
            ID::make()->sortable(),
            Text::make('Titel', 'title')->sortable(),
            Slug::make('Slug')->from('Title')->hideFromIndex(),
            Trix::make('Content')->alwaysShow(),
            Select::make('type')->options([
                'general' => 'Kennisbank',
                'app'     => 'Veelgestelde vragen',
            ])->displayUsingLabels(),
            Number::make('Positie', 'position'),
        ];
    }

    public function cards(NovaRequest $request): array
    {
        return [];
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
}
