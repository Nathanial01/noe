<?php

namespace App\Nova\Actions;

use Carbon\Carbon;
use App\Models\Company;
use App\Models\Transaction;
use Illuminate\Bus\Queueable;
use Laravel\Nova\Fields\Date;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Actions\Action;
use Illuminate\Support\Collection;
use Laravel\Nova\Fields\ActionFields;
use App\Enums\CompanyEnums\StatusEnum;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Laravel\Nova\Http\Requests\NovaRequest;

class CreateManualInvoice extends Action
{
    use InteractsWithQueue, Queueable;

    public $onlyOnDetail = true;

    public $name = 'Handmatige factuur aanmaken';

    /**
     * Perform the action on the given models.
     *
     * @param  \Laravel\Nova\Fields\ActionFields  $fields
     * @param  \Illuminate\Support\Collection  $models
     * @return mixed
     */
    public function handle(ActionFields $fields, Collection $models)
    {
        

        foreach ($models as $model) {
            $model->addCredits($fields->credit_amount);
            $model->status = $fields->status;
            $model->billing_expiration_date = $fields->billing_expiration_date;
            $model->save();

            $transaction = new Transaction();
            $transaction->company_id = $model->id;

            $lastest_invoice = Transaction::where('status', 'paid')->latest()->first();
            $transaction->invoice_number = $lastest_invoice->invoice_number + 1;

            $subtotal = $fields->payment_amount / 1.21;
            $subtotal = number_format($subtotal, 2, '.', '');
            $transaction->subtotal = $subtotal;
            $transaction->payment_amount = $fields->payment_amount;
            $transaction->vat = 21;

            $transaction->payment_method = 'manual';
            $transaction->status = 'paid';
            $transaction->product_description = $fields->description;
            $transaction->credit_amount = $fields->credit_amount;
            $transaction->mollie_id = 'tr_0000000000';
            $transaction->user_id = $model->owners()->first()->id;
            $transaction->is_subscription = true;

            $transaction->save();
        }

        return Action::message('De handmatige factuur is aangemaakt.');
    }

    /**
     * Get the fields available on the action.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function fields(NovaRequest $request)
    {
        return [
            Number::make('Prijs incl. BTW','payment_amount')->min(1)->step(0.01),
            Number::make('Aantal credits','credit_amount')->min(1)->step(1),
            Text::make('Omschrijving','description'),
            Select::make('Pakket','status')->options([
              'whitelabel' => 'Whitelabel', 
              'professional' => 'Professional', 
            ]),
            Date::make('Einddatum','billing_expiration_date')->default(Carbon::now()->addYear()),
        ];
    }
}
