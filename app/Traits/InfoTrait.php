<?php

namespace App\Traits;

trait InfoTrait
{
    public function setAreaInfo(object $area, string $area_type, array $dividedInfo, string $type, $points = null, $amount = null)
    {
        $info = [
            'name' => $area_type,
            'counter' => $this->countEarlier($area, $dividedInfo, $type),
            'length' => $area->length,
            'width' => $area->width,
            'surface' => $area->surface,
            'heated' => $area->heated ?? false,
            'cooling' => $area->cooling_function ?? false,
            'points' => ! is_null($points) ? $points : '-',
        ];

        if ($area->shared_with) {
            $info['shared'] = $area->shared_with;
            $info['amount'] = $area->amount ?? 0;
            $info['address_count'] = $area->address_count ?? 0;
        }
        if (! is_null($area->parking_area)) {
            $info['charging_pole'] = $area->charging_station;
            $info['amount'] = $area->amount;
            if ($area->check->dependentPropertyVTwo()->exists()) {
                $info['address_count'] = $area->address_count > 1 ? $area->address_count : 1;
            }
        }

        return $info;
    }
}
