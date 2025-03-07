<?php

namespace App\Nova;

use Laravel\Nova\Fields\ID;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\Date;
use Laravel\Nova\Fields\File;
use Laravel\Nova\Fields\Text;
use App\Jobs\PropertyImportJob;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Select;
use App\Nova\Actions\AddCredits;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\DateTime;
use App\Nova\Metrics\NewCompanies;
use App\Nova\Actions\RemoveCredits;
use App\Nova\Metrics\CompaniesPerDay;
use Laravel\Nova\Actions\ExportAsCsv;
use App\Enums\CompanyEnums\StatusEnum;
use App\Nova\Actions\CreateManualInvoice;
use Laravel\Nova\Http\Requests\NovaRequest;
use Illuminate\Database\Query\Builder as QueryBuilder;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;

class Company extends Resource
{
    // MongoDB collection name for companies.
    protected string $collection = 'companies';

    public static $model = \App\Models\Company::class;
    public static $title = 'name';

    public static function label()
    {
        return __('Bedrijven');
    }

    public static function singularLabel()
    {
        return __('Bedrijf');
    }

    public static $showPollingToggle = true;
    public static $search = ['id', 'name'];

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

    public function fields(NovaRequest $request)
    {
        return [
            ID::make()->sortable(),
            Text::make('Bedrijfsnaam', 'name')
                ->sortable()
                ->rules('required', 'max:255'),
            Text::make('Plaats', 'city')->sortable(),
            Text::make('Straatnaam', 'street')
                ->hideFromIndex()
                ->rules('required', 'max:255'),
            Number::make('Huisnummer', 'house_number')->hideFromIndex(),
            Text::make('Huisnummer toevoeging', 'house_number_addition')
                ->hideFromIndex()
                ->rules('max:255'),
            Text::make('Postcode toevoeging', 'postal_code')
                ->hideFromIndex()
                ->rules('max:255'),
            Text::make('KVK', 'kvk_number')
                ->hideFromIndex()
                ->rules('max:255'),
            Text::make('BTW', 'vat_number')
                ->hideFromIndex()
                ->rules('max:255'),
            Number::make('Beschikbare credits', 'credit_amount')
                ->sortable()
                ->readonly(),
            Text::make('Telefoonnummer', 'phone_number')
                ->sortable()
                ->readonly(),
            Number::make('Omzet', 'total_revenue')
                ->sortable()
                ->readonly(),
            Text::make('Promo', 'promotional_code')
                ->sortable()
                ->rules('max:255'),
            Select::make('Abonnement', 'status')->options(
                StatusEnum::doubleArray()
            ),
            Date::make('Abonnement vervaldatum', 'billing_expiration_date')
                ->rules('nullable', 'date'),
            HasMany::make('Properties'),
            HasMany::make('Transactions'),
            HasMany::make('Users'),
            DateTime::make('Aangemaakt op', 'created_at')
                ->sortable()
                ->readonly(),
            Boolean::make('API actief', 'api_active'),
            File::make('Attachment')
                ->acceptedTypes('.csv')
                ->store(function (Request $request, $model) {
                    $model->addMediaFromRequest('attachment')
                        ->toMediaCollection('property-imports');
                    PropertyImportJob::dispatch($model);
                    return true;
                }),
        ];
    }

    public static function indexQuery(NovaRequest $request, $query)
    {
        $query = parent::indexQuery($request, $query);
        return self::totalRevenueSubSelect($query);
    }

    public static function detailQuery(NovaRequest $request, $query)
    {
        parent::detailQuery($request, $query);
        return self::totalRevenueSubSelect($query);
    }

    private static function totalRevenueSubSelect(EloquentBuilder|QueryBuilder $query): EloquentBuilder|QueryBuilder
    {
        return $query->addSelect(['total_revenue' => function (EloquentBuilder|QueryBuilder $query) {
            $query->selectRaw('sum(subtotal) as total_revenue')
                ->from('transactions')
                ->where('status', '=', 'paid')
                ->whereColumn('companies.id', '=', 'transactions.company_id')
                ->groupBy('transactions.company_id');
        }]);
    }

    public function cards(NovaRequest $request)
    {
        return [
            new NewCompanies,
            new CompaniesPerDay,
        ];
    }

    public function filters(NovaRequest $request)
    {
        return [
            new Filters\PayingCompany,
            new Filters\StartDate,
            new Filters\EndDate
        ];
    }

    public function lenses(NovaRequest $request)
    {
        return [];
    }

    public function actions(NovaRequest $request)
    {
        return [
            ExportAsCsv::make(),
            AddCredits::make(),
            CreateManualInvoice::make()->onlyOnDetail(),
            RemoveCredits::make()
        ];
    }

    public static function authorizedToCreate(Request $request)
    {
        return false;
    }

    public static function availableForNavigation(Request $request): bool
    {
        return $request->user()->is_admin;
    }
}
