<?php

namespace App\Traits;

use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\View;

trait InvoiceTrait
{
    private function downloadInvoice(Transaction $transaction)
    {
        $this->authorize('view', [Transaction::class, $transaction, $this->company]);

        if ($transaction->status != 'Betaald') {
            return;
        }

        if ($transaction->payment_method == 'mollie') {
            $mollie_transaction = mollie()->payments()->get($transaction['mollie_id']);
            $paid_at = $mollie_transaction->paidAt;
        } else {
            $paid_at = $transaction->created_at;
        }

        $des_array = [
            'Standaard pakket',
            'Premium pakket',
            'Professioneel pakket',
            'Professioneel XL pakket',
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
        $filename = 'Factuur-'.$transaction->invoice_number.'-'.Carbon::parse($transaction->created_at)->format('d-m-Y').'.pdf';

        // To file
        $html = view('export-bill', [
            'transaction' => $transaction,
            'payment_date' => Carbon::parse($paid_at)->format('d-m-Y'),
            'until_date' => Carbon::parse($paid_at)->addYear()->format('d F Y'),
            'in_array' => $in_array,
            'company' => $this->company ?? $transaction->company,
        ]); // Grab html;
        $snappy->generateFromHtml($html, storage_path($filename)); // Generate pdf from html

        return response()->download(storage_path($filename))->deleteFileAfterSend(true);
    }
}
