<?php

namespace App\Traits;

use Illuminate\Support\Facades\Http;

trait FileValidationTrait
{
    private array $titles = [
        'postal_code',
        'house_number',
        'house_letter',
        'house_number_addition',
        'construction_year',
        'property_type',
        'rent',
        'portfolio',
        'complex',
        'reference',
    ];

    private array $property_types = [
        'dependent',
        'independent',
        'zelfstandig',
        'onzelfstandig',
    ];

    private array $ref_array = [];

    private string $postal_regex = '/^[0-9]{4}[a-zA-Z]{2}$/';

    private string $number_regex = '/^[0-9]{1,6}$/';

    private string $house_letter_regex = '/^[A-Za-z]{1}$/';

    private string $year_regex = '/^[0-9]{4}$/';

    private string $street_regex = '/^[A-Za-z]+(\s[A-Za-z]+)*$/u';

    private string $city_regex = '/^[\p{L}\s\-]+$/u';

    /**
     * Opens file and returns an array with any wrong data
     *
     * @param  File  $file
     */
    public function validateFile($file): array
    {
        $fp = fopen($file->getPath().'/'.$file->getFilename(), 'r');
        $count = 1;
        $property_count = 0;
        $errors = [];
        while ($csv_line = fgetcsv($fp, null, '|')) {
            $test = explode(';', $csv_line[0]);
            if (in_array($test[0], $this->titles) && count($test) < 10) {
                $errors['file_broken'] = 'Bestand kan niet gevalideert worden. U moet de template in stand houden zoals geleverd. Vakken zoals portfolio, referentie en complex mogen leeg zijn maar niet uit het bestand ontbreken.';
                break;
            }
            if ($this->checkHeader($test) === false) {
                $property_count += 1;
                $count += 1;
                $e = $this->createErrorArray($test);
                if (count($e) > 0) {
                    $errors[$count] = $e;
                }
            }
        }
        fclose($fp);

        return [$errors, $property_count > $this->company->credit_amount];
    }

    /**
     * Checks values in the array and returns the row and error messages
     *
     * @param  array  $array
     */
    private function createErrorArray($array): array
    {
        $errors = [];
        if (! empty($array[6])) {
            $price_array = explode(',', $array[6]);
            if (count($price_array) > 1) {
                $price = floatval($price_array[0].'.'.$price_array[1]);
            } else {
                $price = floatval($array[6]);
            }
        }

        if (empty($array[0]) || ! $this->validateRegex($array[0], $this->postal_regex)) {
            $errors[] = 'Postcode ongeldig of mag niet leeg zijn';
        }
        if (empty($array[1]) || ! $this->validateRegex($array[1], $this->number_regex)) {
            $errors[] = 'Huisnummer heeft een ongeldig formaat of mag niet leeg zijn';
        }
        if (! empty($array[2]) ? ! $this->validateRegex($array[2], $this->house_letter_regex) : false) {
            $errors[] = 'Huisletter heeft een ongeldig formaat';
        }
        if (! $this->grabAddress($array)) {
            $errors[] = 'Kan geen adres gevonden worden';
        }
        if (empty($array[4]) || ! $this->validateRegex($array[4], $this->year_regex)) {
            $errors[] = 'Bouwjaar heeft een ongeldig formaat of mag niet leeg zijn';
        }
        if (empty($array[5]) || ! in_array(strtolower($array[5]), $this->property_types)) {
            $errors[] = 'Woning type ongeldig of mist';
        }
        if (empty($array[6]) || ! is_numeric($price)) {
            $errors[] = 'Huidige huurprijs is verplicht of staat in een ongeldig formaat';
        }
        if (! empty($array[9]) ? $this->referenceCheck($array[9]) : false) {
            $errors[] = 'Er bestaat al een woning met deze referentie of er zit een referentie met dezelfde naam in het bestand';
        }

        return $errors;
    }

    /**
     * Checks if address can be found
     *
     * @param  array  $array
     */
    private function grabAddress($array): bool
    {
        if (count($array) < 4) {
            return false;
        } else {
            if (empty($array[0]) || empty($array[1])) {
                return false;
            }
            $request_array = [
                'api_token' => config('woz_api.woz_api_token'),
                'postcode' => $array[0],
                'huisnummer' => $array[1],
            ];
            if (! empty($array[2])) {
                $request_array['huisletter'] = $array[2];
            }
            if (! empty($array[3])) {
                $request_array['huisnummertoevoeging'] = $array[3];
            }

            try {
                $response = Http::get('https://wozwaarde.app/api/postcode', $request_array);

                if ($response->getStatusCode() === 200) {
                    return true;
                } elseif ($response->getStatusCode() === 404) {
                    return false;
                }
            } catch (\GuzzleHttp\Exception\BadResponseException $exception) {
                return false;
            }
        }
    }

    /**
     * Checks if item its a header so it can skip it
     *
     * @param  array  $array
     */
    private function checkHeader($array): bool
    {
        $count = 0;
        foreach ($array as $item) {
            $trimmed = trim($item);
            if (in_array($trimmed, $this->titles)) {
                $count += 1;
            }
        }

        return $count === 10;
    }

    /**
     * Checks if it's a valid postal code otherwise it rejects it
     *
     * @param  string  $postal_code
     * @param  string  $regex
     */
    private function validateRegex($postal_code, $regex): bool
    {
        return preg_match($regex, $postal_code);
    }

    /**
     * Checks if there are duplicate references in the file and in the company
     *
     * @param  string  $ref
     */
    public function referenceCheck($ref): bool
    {
        $refcheck = $this->company->properties()->where('reference', '=', $ref)->exists() || array_search($ref, $this->ref_array);
        $this->ref_array[] = $ref;

        return $refcheck;
    }
}
