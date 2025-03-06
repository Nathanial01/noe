<?php

namespace App\Traits;

use App\Models\Property;
use App\Models\Woz;
use Carbon\Carbon;

trait FilterTrait
{
    public function checkLabelInfo($property)
    {
        return (is_null($property->labelLetter) || is_null($property->energieprestatieindex)) && is_null($property->registratiedatum);
    }

    public function previousYearFilter(Property $property)
    {
        $previous_year = Carbon::now()->subYear()->startOfYear();

        return Woz::where('property_id', $property->id)->where('reference_date', '=', $previous_year)->exists();
    }
}
