<?php

namespace App\Traits;

use App\Enums\CheckEnums\CheckStartDateEnum;
use Carbon\Carbon;
use Illuminate\Support\Facades\File;

trait PropertyExportTrait
{
    use SpecialCharacterTrait;

    public function exportCSV($all = false)
    {
        if (! File::exists(public_path().'/files')) {
            File::makeDirectory(public_path().'/files');
        }
        if (! $all) {
            $periods = CheckStartDateEnum::getValues();
            $start_date = $periods[$this->period != 0 ? $this->period - 1 : 0];
        }

        if (! $this->properties) {
            return toast()->warning('Geen woningen gevonden om te exporteren!')->push();
        }

        $name = $this->replaceSpecialCharacters($this->company->name);
        $fileName = public_path("files/Overzicht woningen {$name}.csv");
        $headers = [
            'Content-type' => 'text/csv; charset=utf-8',
            'Content-Disposition' => "attachment; filename=$fileName",
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0',
        ];

        $columns = ['Adres', 'Referentie', 'Stad', 'Postcode', 'Actuele huurprijs', 'Punten', 'Maximale huurprijs', 'WOZ-waarde', 'Label', 'Label registratiedatum', 'Type', 'Portefeuille', 'Complex'];

        $file = fopen($fileName, 'w');
        // Add BOM for UTF-8 encoding
        fwrite($file, "\xEF\xBB\xBF");
        fputcsv($file, $columns, ';');
        $total_current = 0;
        $total = 0;

        foreach ($this->properties as $property) {
            if ($all) {
                $row['Adres'] = $property->address ? strval($property->address) : '-';
                $row['Referentie'] = $property->reference ? strval($property->reference) : '-';
                $row['Stad'] = $property->city ? strval($property->city) : '-';
                $row['Postcode'] = $property->postal_code ? strval($property->postal_code) : '-';
                $row['Actuele huurprijs'] = $property->current_rental_price ? str_replace(',', '.', strval('€'.$property->current_rental_price)) : '-';
                $row['Punten'] = $property->latestCheck->points ? strval($property->latestCheck->points) : '-';
                $row['Maximale huurprijs'] = $property->latestCheck ? str_replace(',', '.', strval('€'.$property->latestCheck->price)) : '-';
                $row['WOZ-waarde'] = ! is_null($property->getLatestWoz()) ? $property->getLatestWoz()->determined_value : '-';
                $row['Label'] = ! is_null($property->energy_label) ? (Carbon::parse($property->label_registration_date) >= Carbon::parse('2021-01-01') ? strval($property->energy_label) : $property->energy_index) : '-';
                $row['Label registratiedatum'] = ! is_null($property->label_registration_date) ? strval($property->label_registration_date) : '-';
                $row['Type'] = $property->property_kind ? strval($property->property_kind) : '-';
                $row['Portefeuille'] = $property->portfolios ? strval($property->portfolios->pluck('name')->implode(', ')) : '-';
                $row['Complex'] = $property->complexes ? strval($property->complexes->pluck('name')->implode(', ')) : '-';

                fputcsv($file, [$row['Adres'], $row['Referentie'], $row['Stad'], $row['Postcode'], $row['Actuele huurprijs'], $row['Punten'], $row['Maximale huurprijs'], $row['WOZ-waarde'], $row['Label'], $row['Label registratiedatum'], $row['Type'], $row['Portefeuille'], $row['Complex']], ';');
                $total_current += $property->current_rental_price;
                $total += $property->latestCheck ? $property->latestCheck->price : 0;
            } else {
                $check = $property->checks()->where('start_date', $start_date)->first();
                if (! is_null($check)) {
                    $row['Adres'] = $property->address ? strval($property->address) : '-';
                    $row['Referentie'] = $property->reference ? strval($property->reference) : '-';
                    $row['Stad'] = $property->city ? strval($property->city) : '-';
                    $row['Postcode'] = $property->postal_code ? strval($property->postal_code) : '-';
                    $row['Actuele huurprijs'] = $property->current_rental_price ? str_replace(',', '.', strval('€'.$property->current_rental_price)) : '-';
                    $row['Punten'] = ! is_null($check->points) ? strval($check->points) : '-';
                    $row['Maximale huurprijs'] = ! is_null($check->price) ? str_replace(',', '.', strval('€'.$check->price)) : '-';
                    $row['WOZ-waarde'] = ! is_null($property->getLatestWoz()) ? $property->getLatestWoz()->determined_value : '-';
                    $row['Label'] = ! is_null($property->energy_label) ? (Carbon::parse($property->label_registration_date) >= Carbon::parse('2021-01-01') ? strval($property->energy_label) : $property->energy_index) : '-';
                    $row['Label registratiedatum'] = $property->label_registration_date ? strval($property->label_registration_date) : '-';
                    $row['Type'] = $property->property_kind ? strval($property->property_kind) : '-';
                    $row['Portefeuille'] = $property->portfolios ? strval($property->portfolios->pluck('name')->implode(', ')) : '-';
                    $row['Complex'] = $property->complexes ? strval($property->complexes->pluck('name')->implode(', ')) : '-';

                    fputcsv($file, [$row['Adres'], $row['Referentie'], $row['Stad'], $row['Postcode'], $row['Actuele huurprijs'], $row['Punten'], $row['Maximale huurprijs'], $row['WOZ-waarde'], $row['Label'], $row['Label registratiedatum'], $row['Type'], $row['Portefeuille'], $row['Complex']], ';');
                    $total_current += $property->current_rental_price;
                    $total += $check->price ?? 0;
                }
            }
        }

        $total_column = ['Totaal', '-', '-', '-', '€'.str_replace(',', '.', strval($total_current)), '-', '€'.str_replace(',', '.', strval($total)), '-', '-', '-', '-', '-', '-'];
        fputcsv($file, $total_column, ';');

        fclose($file);

        return response()->download($fileName, "Overzicht woningen {$name}.csv", $headers)->deleteFileAfterSend(true);
    }
}
