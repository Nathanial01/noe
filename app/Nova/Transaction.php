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
    protected string $collection = 'transactions';

    public static $model = \App\Models\Transaction::class;
    public static $title = 'id';

    public static function label()
    {
        return __('Facturen');
    }

    public static function singularLabel()
    {
        return __('Factuur');
    }

    public static $showPollingToggle = true;
    public static $search = ['id', 'mollie_id', 'invoice_number'];

    public static function authorizable()
    {
        return false;
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

    public function fields(NovaRequest $request)
    {
        return [
            ID::make()->sortable(),
            Text::make('Factuurnummer', 'invoice_number')->sortable()->readonly(),
            Text::make('Mollie ID', 'mollie_id')->sortable()->readonly()->hideFromIndex(),
            BelongsTo::make('Company')->readonly(),
            BelongsTo::make('user')->readonly()->hideFromIndex(),
            Select::make('Status')->options([
                'created'  => 'Aangemaakt',
                'paid'     => 'Betaald',
                'failed'   => 'Gefaald',
                'expired'  => 'Vervallen',
                'canceled' => 'Afgebroken',
                'open'     => 'Open'
            ])->displayUsingLabels(),
            Select::make('Betaalmethode', 'payment_method')->options([
                'manual' => 'Handmatig',
                'mollie' => 'Mollie',
            ])->displayUsingLabels(),
            Text::make('Omschrijving', 'product_description'),
            Text::make('Credits', 'credit_amount')->sortable()->readonly(),
            Number::make('Subtotaal excl. btw', 'subtotal')->sortable()->readonly(),
            Number::make('Totaal incl. BTW', 'payment_amount')->sortable()->readonly(),
            Number::make('BTW', 'vat')->sortable()->readonly()->hideFromIndex(),
            Number::make('Betaalmethode', 'payment_method')->readonly()->hideFromIndex(),
            DateTime::make('Aangemaakt op', 'created_at')->sortable()->readonly(),
        ];
    }

    public function cards(NovaRequest $request)
    {
        return [
            new TotalRevenue,
            new RevenuePerDay
        ];
    }

    public function filters(NovaRequest $request)
    {
        return [
            new Filters\PaymentMethod,
            new Filters\TransactionStatus,
            new Filters\StartDate,
            new Filters\EndDate
        ];
    }

    public function lenses(NovaRequest $request)
    {
        return [];
    }

    public function actions(NovaRequest $request): array
    {
        return [
            CompanyCsvExport::make()->nameable(),
            ExportAsCsv::make()->nameable()->showOnIndex(),
            ExportInvoice::make(),
        ];
    }

    public static function availableForNavigation(Request $request): bool
    {
        return $request->user()?->is_admin ?? false;
    }
}
