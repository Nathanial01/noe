<?php

namespace App\Traits\Api;

use App\Livewire\App\Components\DependentVTwoPointsPreview;
use App\Livewire\App\Components\IndependentPointsPreview;
use App\Livewire\App\Property\DependentVTwoShow;
use App\Livewire\App\Property\IndependentShow;
use App\Models\ApiKey;
use App\Models\Check;
use App\Models\Property;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

trait ApiHelpers
{
    protected string $localPdfPath;

    /**
     * Find the check by property reference
     *
     * @param  string  $referencee  Unique reference of the property
     * @return Check Latest check of property
     *
     * @throws ModelNotFoundException If the company, property or check is not found
     */
    public function findCheck($reference): Check
    {
        $company = ApiKey::where('api_key', request()->bearerToken())->first()->company;
        if (! $company) {
            throw new ModelNotFoundException('Company not found', 404);
        }

        $property = $company->getPropertyWithReference($reference);
        if (! $property) {
            throw new ModelNotFoundException('Resource not found. Could not find property with the given reference.', 404);
        }

        $check = $property->latestCheck;
        if (! $check) {
            throw new ModelNotFoundException('Resource not found. Could not find check for the given property.', 404);
        }

        return $check;
    }

    /**
     * Calculate the total points and price for the check using Livewire component
     *
     * @param  Check  $check  The check to calculate points and price for
     * @return bool True if the calculation was successful
     *
     * @throws Exception If the calculation fails
     */
    private function calculateCheckTotal(Check $check): bool
    {
        try {
            $component = $check->independentProperty()->exists()
                ? new IndependentPointsPreview
                : new DependentVTwoPointsPreview;
            $component->check = $check;
            $component->property = $check->property;
            $component->company = $check->property->company;
            $component->boot();
            $component->mount();

            return true;
        } catch (Exception $e) {
            throw new Exception('Failed calculating check totals', 500);
        }
    }

    /**
     * Generate PDF for the check and upload it to GCS using LiveWire component
     *
     * @param  Check  $check  The check to generate the PDF for
     * @return string Relative path to the PDF in GCS
     *
     * @throws Exception If the PDF generation fails
     */
    private function generatePdf(Check $check): string
    {
        try {
            $component = $check->independentProperty()->exists()
                ? new IndependentShow
                : new DependentVTwoShow;
            $component->check = $check;
            $component->company = $check->property->company;
            $component->property = $check->property;
            $component->boot();
            $component->mount(true);
            $component->advice = true;
            $component->show_calculation = true;
            $this->localPdfPath = $component->exportToPdf();
            $gcsPath = $check->property->company->id.'/'.$check->property->id.'/'.basename($this->localPdfPath);

            $success = Storage::disk('gcs')->writeStream(
                $gcsPath,
                Storage::disk('local')->readStream($this->localPdfPath)
            );

            if (! $success) {
                throw new Exception('Failed uploading to GCS', 500);
            }

            return $gcsPath;
        } catch (Exception $e) {
            dd($e);
            throw new Exception('Failed exporting to PDF', 500);
        } finally {
            if (isset($this->localPdfPath) && Storage::disk('local')->exists($this->localPdfPath)) {
                Storage::disk('local')->delete($this->localPdfPath);
            }
        }
    }

    /**
     * Get the prefixed energy label string
     *
     * @param  Check  $check  The check to get energy label for
     * @param  string  $label  The unprefixed energy label string
     * @return string Prefixed energy label string
     */
    public function getPrefixedLabel(Check $check, string $label): string
    {
        $surface = $check->areas()->whereNull('outside_area')->where('shared_with', false)->sum('surface');
        if ($surface > 0) {
            if ($surface < 25) {
                $prefix = '<25 ';
            } elseif ($surface >= 25 && $surface < 40) {
                $prefix = '>= 25 en <40 ';
            } else {
                $prefix = '>= 40 ';
            }

            return $prefix.strtoupper($label);
        }

        return strtoupper($label);
    }

    /**
     * Get the municipality of a property
     *
     * @param  Property  $property  The property to get the municipality for
     * @return string|null The municipality of the property
     */
    public function getMunicipality(Property $property): ?string
    {
        $property->refresh();

        if (! $property->number_designation) {
            return null;
        }

        $request_array = [
            'api_token' => config('woz_api.woz_api_token'),
            'number_designation' => $property->number_designation,
        ];

        $response = Http::get('https://wozwaarde.app/api/municipality', $request_array);

        if ($response->status() === 200) {
            $response_body = json_decode($response->body());
            if (! empty($response_body)) {
                return $response_body->municipality ?? null;
            }
        }
    }
}
