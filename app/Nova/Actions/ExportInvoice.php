<?php

namespace App\Nova\Actions;

use Carbon\Carbon;
use App\Models\Transaction;
use Illuminate\Bus\Queueable;
use Laravel\Nova\Actions\Action;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\App;
use Laravel\Nova\Fields\ActionFields;
use Illuminate\Queue\InteractsWithQueue;
use Laravel\Nova\Http\Requests\NovaRequest;
use Illuminate\Support\Facades\View;

class ExportInvoice extends Action
{
    use InteractsWithQueue, Queueable;

    public $name = 'Factuur downloaden als PDF';

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
            return Action::redirect(route('nova.download-invoice', [
                'file' => $this->downloadInvoice($model->id),
            ]));
        }
    }

    /**
     * Get the fields available on the action.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function fields(NovaRequest $request)
    {
        return [];
    }

    public function downloadInvoice($transactionId)
    {
        $transaction = Transaction::findOrfail($transactionId);
        if ($transaction->status != 'Betaald') return;

        if ($transaction->payment_method == 'mollie') {
            $mollie_transaction = mollie()->payments()->get($transaction['mollie_id']);
            $paid_at = $mollie_transaction->paidAt;
        } else {
            $paid_at = $transaction->created_at;
        }

        $des_array = [
            "Standaard pakket",
            "Premium pakket",
            "Professioneel pakket",
            "Professioneel XL pakket",
        ];

        $in_array = false;
        if (in_array($transaction->product_description, $des_array)) {
            $in_array = true;
        }

        $snappy = App::make('snappy.pdf');
        $footer = View::make('export-bill-footer');
        $snappy->setOption('footer-html', $footer, ['page'], ['topage']);
        $snappy->setOption('margin-left', 0);
        $snappy->setOption('margin-right', 0);
        $snappy->setOption('margin-bottom', 5);
        $filename = 'Factuur-' . $transaction->invoice_number . '-' . Carbon::parse($transaction->created_at)->format('d-m-Y') . '.pdf';

        //To file
        $html = view('export-bill', [
            'transaction' => $transaction,
            'payment_date' => Carbon::parse($paid_at)->format('d-m-Y'),
            'until_date' => Carbon::parse($paid_at)->addYear()->format('d F Y'),
            'in_array' => $in_array,
            'company' => $this->company ?? $transaction->company
        ]); // Grab html;
        $snappy->generateFromHtml($html, storage_path($filename)); // Generate pdf from html

        return $filename;
    }
}
