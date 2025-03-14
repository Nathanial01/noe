<?php

namespace App\Nova\Actions;

use Closure;
use Str;
use App\Models\Company;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Actions\ActionResponse;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Nova;
use Laravel\Nova\Fields\ActionFields;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Rules\Filename;

class CompanyCsvExport extends Action
{
    use InteractsWithQueue, Queueable;

    /**
    * All of the defined action fields.
    *
    * @var \Illuminate\Support\Collection
    */
    public $actionFields;

    /**
     * The custom field callback.
     *
     * @var (\Closure(\Laravel\Nova\Http\Requests\NovaRequest):(array<int, \Laravel\Nova\Fields\Field>))|null
     */
    public $withFieldsCallback;

    public function __construct($name = null)
    {
        $this->name = $name;
        $this->actionFields = collect();
    }


    /**
     * Perform the action on the given models.
     *
     * @param  \Laravel\Nova\Fields\ActionFields  $fields
     * @param  \Illuminate\Support\Collection  $models
     * @return mixed
     */
    public function handle(ActionFields $fields, Collection $models)
    {

        $inputs = [
            [
                'id',
                'company',
                'user',
                'mollie_id',
                'invoice_number',
                'status',
                'credit_amount',
                'subtotal',
                'payment_amount',
                'product_description',
                'vat',
                'payment_method',
                'created_at',
                'updated_at',
            ],
        ];
        foreach($models as $model)
        {
            $inputs [] = [
                $model->id,
                Company::find($model->company_id)->first()->name,
                User::find($model->user_id)->first()->name,
                $model->mollie_id,
                $model->invoice_number ?? '',
                $model->status,
                $model->credit_amount,
                $model->subtotal,
                $model->payment_amount,
                $model->product_description,
                $model->vat,
                $model->payment_method,
                Carbon::parse($model->created_at)->format('Y-m-d H:i:s'),
                Carbon::parse($model->updated_at)->format('Y-m-d H:i:s')
            ];
        }
        // ob_start();
        $filename = $fields->get('filename') ?? sprintf('%s-%d-.csv', $this->uriKey(), now()->format('YmdHis'));

        $extension = 'csv';

        if (Str::contains($filename, '.')) {
            [$filename, $extension] = explode('.', $filename);
        }

        $exportFilename = sprintf(
            '%s.%s',
            $filename,
            $fields->get('writerType') ?? $extension
        );

        $headers = array(
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$exportFilename",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        );

        $output = fopen($exportFilename, "w");

        foreach($inputs as $input) {
            fputcsv($output, $input);
        }

        fclose($output);

        return Action::openInNewTab(route('dump-download', ['file' => $exportFilename]));
    }


    /**
     * Get the fields available on the action.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function fields(NovaRequest $request)
    {
        if ($this->withFieldsCallback instanceof Closure) {
            $this->actionFields = $this->actionFields->merge(call_user_func($this->withFieldsCallback, $request));
        }

        return $this->actionFields->all();
    }

    public function nameable($default = null)
    {
        $this->actionFields->push(
            Text::make(Nova::__('Filename'), 'filename')->default($default)->rules(['required', 'min:1', new Filename])
        );

        return $this;
    }

    public function name()
    {
        return 'Export as Company csv';
    }
}
