<?php

namespace App\Nova;

use App\Nova\Actions\CompanyCsvExport;
use Filter\PaymentMethod;
use Laravel\Nova\Fields\ID;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\HasOne;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\DateTime;
use App\Nova\Metrics\TotalRevenue;
use Laravel\Nova\Fields\BelongsTo;
use App\Nova\Actions\ExportInvoice;
use App\Nova\Metrics\RevenuePerDay;
use Laravel\Nova\Actions\ExportAsCsv;
use App\Nova\Filters\TransactionStatus;
use Laravel\Nova\Http\Requests\NovaRequest;

class Transaction extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var class-string<\App\Models\Transaction>
     */
    public static $model = \App\Models\Transaction::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'id';

    /**
     * Get the displayable label of the resource.
     *
     * @return string
     */
    public static function label()
    {
        return __('Facturen');
    }

    /**
     * Get the displayable singular label of the resource.
     *
     * @return string
     */
    public static function singularLabel()
    {
        return __('Factuur');
    }

    /**
     * Indicates whether to show the polling toggle button inside Nova.
     *
     * @var bool
     */
    public static $showPollingToggle = true;


    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id',
        'mollie_id',
        'invoice_number',

    ];

    public static function authorizable()
    {
        return false;
    }

    /**
     * Get the menu that should represent the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Laravel\Nova\Menu\MenuItem
     */
    public function menu(Request $request)
    {
        return parent::menu($request)->withBadge(function () {
            return static::$model::count();
        });
    }

    public static function authorizedToCreate(Request $request)
    {
        return false;
    }

    public function authorizedToDelete(Request $request)
    {
        return false;
    }

    public function authorizedToUpdate(Request $request)
    {
        return true;
    }

    public function authorizedToReplicate(Request $request)
    {
        return false;
    }

    /**
     * Get the fields displayed by the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function fields(NovaRequest $request)
    {
        return [
            ID::make()->sortable(),

            Text::make('Factuurnummer', 'invoice_number')
                ->sortable()
                ->readonly(),

            Text::make('Mollie ID', 'mollie_id')
                ->sortable()
                ->readonly()
                ->hideFromIndex(),

            BelongsTo::make('Company')->readonly(),

            BelongsTo::make('User')->readonly()->hideFromIndex(),

            Select::make('Status')->options([
                'created' => 'Aangemaakt',
                'paid' => 'Betaald',
                'failed' => 'Gefaald',
                'expired' => 'Vervallen',
                'canceled' => 'Afgebroken',
                'open' => 'Open'
            ])->displayUsingLabels(),

            Select::make('Betaalmethode', 'payment_method')->options([
                'manual' => 'Handmatig',
                'mollie' => 'Mollie',
            ])->displayUsingLabels(),

            Text::make('Omschrijving', 'product_description'),

            Text::make('Credits', 'credit_amount')
                ->sortable()
                ->readonly(),

            Number::make('Subtotaal excl. btw', 'subtotal')
                ->sortable()
                ->readonly(),

            Number::make('Totaal incl. BTW', 'payment_amount')
                ->sortable()
                ->readonly(),

            Number::make('BTW', 'vat')
                ->sortable()
                ->readonly()
                ->hideFromIndex(),

            Number::make('Betaalmethode', 'payment_method')
                ->readonly()
                ->hideFromIndex(),

            DateTime::make('Aangemaakt op', 'created_at')->sortable()->readonly(),
        ];
    }

    /**
     * Get the cards available for the request.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function cards(NovaRequest $request)
    {
        return [
            new TotalRevenue,
            new RevenuePerDay
        ];
    }

    /**
     * Get the filters available for the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function filters(NovaRequest $request)
    {
        return [
            new Filters\PaymentMethod,
            new Filters\TransactionStatus,
            new Filters\StartDate,
            new Filters\EndDate
        ];
    }

    /**
     * Get the lenses available for the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function lenses(NovaRequest $request)
    {
        return [];
    }

    /**
     * Get the actions available for the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function actions(NovaRequest $request)
    {
        return [
            CompanyCsvExport::make()->nameable(),
            ExportAsCsv::make()->nameable()->showOnIndex(),
            ExportInvoice::make(),
        ];
    }
    /**
     * Make this resource appear only to non-admin users in the sidebar.
     *
     * Must match parent's signature: availableForNavigation(\Illuminate\Http\Request $request).
     */
    public static function availableForNavigation(Request $request): bool
    {
        // TRUE if user *is* admin => admin only
        return $request->user()->is_admin;
    }
}
