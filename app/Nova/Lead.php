<?php

namespace App\Nova;

use Laravel\Nova\Fields\ID;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\URL;
use Laravel\Nova\Fields\Text;
use App\Nova\Metrics\NewLeads;
use Laravel\Nova\Fields\Email;
use App\Nova\Metrics\LeadsPerDay;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Actions\ExportAsCsv;
use Laravel\Nova\Http\Requests\NovaRequest;

class Lead extends Resource
{
    protected string $collection = 'leads';

    public static $model = \App\Models\Lead::class;
    public static $title = 'id';

    public static $search = [
        'id',
        'email',
        'address',
        'city',
        'postal_code'
    ];

    public static function availableForNavigation(Request $request): bool
    {
        return $request->user()->is_admin;
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
            ID::make()->sortable()->hideFromIndex(),
            Email::make()->sortable(),
            Text::make('Telefoonnummer', 'phone_number')->sortable(),
            Text::make('Adres', 'address')->sortable(),
            Text::make('Plaats', 'city')->sortable(),
            Text::make('Postcode', 'postal_code')->sortable()->hideFromIndex(),
            Text::make('Woonsoort', function () {
                return $this->building_type === 'independent' ? 'Zelfstandig' : 'Onzelfstandig';
            })->sortable(),
            Text::make('Eigenaarstype', 'owner_type'),
            Text::make('Actuele huurprijs', 'current_rental_price')->sortable()->hideFromIndex(),
            DateTime::make('Aangemaakt op', 'created_at')->sortable()->readonly(),
            URL::make('Overzicht', function () {
                return $this->building_type === 'independent'
                    ? route('lead.independent.show', $this)
                    : route('lead.dependent.show', $this);
            })->hideFromIndex(),
        ];
    }

    public function cards(NovaRequest $request)
    {
        return [
            new NewLeads,
            new LeadsPerDay,
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
}
