<?php

namespace App\Traits;

use App\Models\Area;
use App\Models\Check;
use App\Models\Property;

trait CalculationTrait
{
    // TODO::this function has a terrible name, should be renamed
    public function countEarlier(Area $area, array $dividedInfo, string $areaAttribute): int
    {
        $counter = 1;
        foreach ($dividedInfo as $info) {
            if ($info['name'] == $area->getAttribute($areaAttribute)) {
                $counter += 1;
            }
        }

        return $counter;
    }

    public function minWidthLength($area)
    {
        return $area->width >= 1.50 && $area->length >= 1.50;
    }

    public function quarterRounding($points)
    {
        return round(round($points * 4) / 4, 2);
    }

    /**
     * Pass a model instance here for record
     */
    public function calculatePriceAggregate(mixed $record, string $column, ?string $relation = null, ?string $base_relation = null): string
    {
        $aggregate = 0;
        if (! is_null($base_relation)) {
            foreach ($record->{$base_relation} as $item) {
                $aggregate += $item->{$relation}->sum($column);
            }
        }
        if (! is_null($relation)) {
            $aggregate += $record->{$relation}->sum($column);
        } else {
            $aggregate += $record->sum($column);
        }

        return str_replace(',', '', number_format($aggregate, 2, ',', '.'));
    }

    public function calculateModifierAggregate(Property $property, Check $check, $period, $type)
    {
        $aggregate = 0.00;
        // dd($property->hasProtectedRights($check), $property, $check);
        if ($property->hasProtectedRights($check)) {
            $aggregate += (config($type.'.'.$period.'.property_type.'.$this->property->type) - 1);
        }
        if ($property->hasNewConstructionRights($check)) {
            $aggregate += (config('new-construction.new_property_raise') - 1);
        }
        $aggregate += 1;

        return $aggregate;
    }
}
