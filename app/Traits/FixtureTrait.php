<?php

namespace App\Traits;

use App\Enums\AreaEnums\AreaTypeEnum;
use App\Enums\AreaEnums\V2\AreaRemainingTypeEnum;
use App\Models\Area;
use App\Models\DependentPropertyVTwo;
use App\Models\IndependentProperty;

trait FixtureTrait
{
    use CalculationTrait;

    public $kitchen_array;

    public $total_kitchen_points;

    public $bathroom_array;

    public $total_bathroom_points;

    public $bathroomToiletPoints = 0;

    public $bathroomWashbasinPoints = 0;

    private $kitchenTypes;

    private $bathroomTypes;

    public function __construct() {}

    public function calculateKitchenPreview($property)
    {
        $this->bathroomTypes = config('areas.bathrooms');
        $this->kitchenTypes = config('areas.kitchens');
        $kitchen_array = [];
        $total_points = 0;
        $kitchenAreas = [];
        $sharedKitchenAreas = [];

        foreach ($this->kitchenTypes as $kitchen) {
            foreach ($this->check->areas()->where('type', AreaTypeEnum::getValue($kitchen))->where('shared_with', 0)->get() as $area) {
                $kitchenAreas[] = $area;
            }
        }
        if (in_array($this->period, config('check-versions.version-2'))) {
            foreach ($this->kitchenTypes as $kitchen) {
                foreach ($this->check->areas()->where('type', AreaTypeEnum::getValue($kitchen))->where('shared_with', 1)->get() as $area) {
                    $sharedKitchenAreas[] = $area;
                }
            }
        }

        if ($property->kitchen_unit_outside_kitchen) {
            $extra_facilities = $this->check->extraFacilities()->whereNotNull('extra_kitchen_facility')->whereNull('area_id')->get();

            $info = $this->generateKitchenArray($extra_facilities, $property, 'Extra keuken');
            $kitchen_array[] = $info[0];
            $total_points += $info[1];
        }

        foreach ($kitchenAreas as $index => $kitchen) {
            $facilities = $kitchen->extraFacilities()
                ->whereNotNull('extra_kitchen_facility')
                ->get();
            $index_message = $index + 1;
            $info = $this->generateKitchenArray($facilities, $kitchen, "Keuken {$index_message}");
            $kitchen_array[] = $info[0];
            $total_points += $info[1];
        }
        if (in_array($this->period, config('check-versions.version-2'))) {
            foreach ($sharedKitchenAreas as $i => $kitchen) {
                $facilities = $kitchen->extraFacilities()
                    ->whereNotNull('extra_kitchen_facility')
                    ->get();
                $index_message = $i + 1;
                $info = $this->generateKitchenArray($facilities, $kitchen, "Gedeelde keuken {$index_message}");
                $kitchen_array[] = $info[0];
                $total_points += $info[1];
            }
        }
        $this->kitchen_array = $kitchen_array;
        $this->total_kitchen_points = $total_points;
    }

    public function calculateBathroomView($property)
    {
        $this->bathroomTypes = config('areas.bathrooms');
        $this->kitchenTypes = config('areas.kitchens');
        $bathroom_array = [];
        $totalPoints = 0;
        $bathroomAreas = [];
        $sharedBathroomAreas = [];

        foreach ($this->bathroomTypes as $bathroom) {
            foreach ($this->check->areas()->where('type', AreaTypeEnum::getValue($bathroom))->where('shared_with', 0)->get() as $area) {
                $bathroomAreas[] = $area;
            }
        }

        if (in_array($this->period, config('check-versions.version-2'))) {
            foreach ($this->bathroomTypes as $bathroom) {
                foreach ($this->check->areas()->where('type', AreaTypeEnum::getValue($bathroom))->where('shared_with', 1)->get() as $area) {
                    $sharedBathroomAreas[] = $area;
                }
            }
        }

        if ($property->shower_outside_bathroom) {
            $extra_facilities = $this->check->extraFacilities()->whereNotNull('extra_bathroom_facility')->whereNull('area_id')->get();

            $info = $this->generateBathroomArray($extra_facilities, $property, 'Extra badkamer');
            $bathroom_array[] = $info[0];
            $totalPoints += $info[1];
        }

        foreach ($bathroomAreas as $index => $bathroom) {
            $facilities = $bathroom->extraFacilities()
                ->whereNotNull('extra_bathroom_facility')
                ->get();
            $index_message = $index + 1;
            $info = $this->generateBathroomArray($facilities, $bathroom, "Badkamer {$index_message}");
            $bathroom_array[] = $info[0];
            $totalPoints += $info[1];
        }

        if (in_array($this->period, config('check-versions.version-2'))) {
            foreach ($sharedBathroomAreas as $i => $bathroom) {
                $facilities = $bathroom->extraFacilities()
                    ->whereNotNull('extra_bathroom_facility')
                    ->get();
                $index_message = $i + 1;
                $info = $this->generateBathroomArray($facilities, $bathroom, "Gedeelde badkamer {$index_message}");
                $bathroom_array[] = $info[0];
                $totalPoints += $info[1];
            }
        }
        $this->total_bathroom_points = $totalPoints;
        $this->bathroom_array = $bathroom_array;
    }

    public function generateFixtureArray($areas)
    {
        $this->bathroomTypes = config('areas.bathrooms');
        $this->kitchenTypes = config('areas.kitchens');
        $fixture_array = [];
        $bathroom_counter = 0;
        $kitchen_counter = 0;
        foreach ($areas as $area) {
            if ($area->isBathroom()) {
                $bathroom_counter++;
                $info_block = $this->generateBathroomArray($area->extraFacilities, $area, 'Badkamer '.$bathroom_counter);
                $fixture_array[] = $info_block[0];
                $this->total = $info_block[1];
            }
            if ($area->isKitchen()) {
                $kitchen_counter++;
                $info_block = $this->generateKitchenArray($area->extraFacilities, $area, 'Keuken '.$kitchen_counter);
                $fixture_array[] = $info_block[0];
                $this->total = $info_block[1];
            }
        }

        return $fixture_array;
    }

    public function generateBathroomArray($extra_facilities, $type, $index)
    {
        $this->bathroomTypes = config('areas.bathrooms');
        $this->kitchenTypes = config('areas.kitchens');

        $washing_type = $type->sanitary_type;
        $max_points = $washing_type ? $this->config['washbasin_units'][$washing_type] * 2 : null;
        $type_points = $this->service->calculateWashingUnitPoints($type, $this->period)[0];
        $extra_facility_points = in_array($this->period, config('check-versions.version-2')) ? ($type instanceof IndependentProperty ? $this->service->calculateNewBathroomFacilities($extra_facilities, $type->extra_washbasin, $type->extra_multi_washbasin, $this->period) : $this->service->calculateNewBathroomFacilities($extra_facilities, $type->washbasin, $type->multi_washbasin, $this->period)) : $this->service->calculateBathroomFacilities($extra_facilities, $this->period);
        $tile_points = $this->service->calculateKitchenTilePoints($type->extra_bathroom_tiles, null, $this->period);

        $sum_bathroom_points = ($type_points + $extra_facility_points[0] + (in_array($this->period, config('check-versions.version-1')) ? $tile_points + $type->extra_bathroom_luxury_points : 0));

        $bathroomMessage = $sum_bathroom_points > $max_points ? 'Voorzieningen badkamer afgetopt ('.$max_points.' punten)' : '';
        $total = $sum_bathroom_points > $max_points ? $max_points : $sum_bathroom_points;

        if (($type instanceof IndependentProperty || $type instanceof DependentPropertyVTwo) && in_array($this->period, config('check-versions.version-2'))) {
            $toilet_points = $type->extra_toilet * config('independent.'.$this->period.'.bathroom_points.toilet');
            $floating_toilet_points = $type->extra_floating_toilet * config('independent.'.$this->period.'.bathroom_points.floating_toilet');
            $washbasin_points = $type->extra_washbasin * config('independent.'.$this->period.'.bathroom_points.washbasin');
            $multi_washbasin_points = $type->extra_multi_washbasin * config('independent.'.$this->period.'.bathroom_points.multi_washbasin');
            $this->bathroomToiletPoints += $toilet_points + $floating_toilet_points;
            $this->bathroomWashbasinPoints += $washbasin_points + $multi_washbasin_points;
            $total = $total + $toilet_points + $floating_toilet_points + $washbasin_points + $multi_washbasin_points;
        } elseif ($type instanceof Area && in_array($this->period, config('check-versions.version-2'))) {
            $toilet_points = $type->toilet * config('independent.'.$this->period.'.bathroom_points.toilet');
            $floating_toilet_points = $type->floating_toilet * config('independent.'.$this->period.'.bathroom_points.floating_toilet');
            $washbasin_points = $type->washbasin * config('independent.'.$this->period.'.bathroom_points.washbasin');
            $multi_washbasin_points = $type->multi_washbasin * config('independent.'.$this->period.'.bathroom_points.multi_washbasin');
            $this->bathroomToiletPoints += $toilet_points + $floating_toilet_points;
            $this->bathroomWashbasinPoints += $washbasin_points + $multi_washbasin_points;
            if ($type->shared_with) {
                $amount = $type->amount > 1 ? $type->amount : 1;
                $address_count = $type->address_count > 1 ? $type->address_count : 1;
                if ($type->check->dependentPropertyVTwo()->exists()) {
                    $sum_bathroom_points = $type_points + $extra_facility_points[0] + $toilet_points + $floating_toilet_points + $washbasin_points + $multi_washbasin_points;
                    $bathroomMessage = $sum_bathroom_points > $max_points ? 'Voorzieningen badkamer afgetopt ('.$max_points.' punten)' : '';
                    $total = $sum_bathroom_points > $max_points ? $max_points : $sum_bathroom_points;
                    $total = $this->quarterRounding((($total) / $address_count) / $amount, 2);
                } else {
                    $total = round((($total + $toilet_points + $floating_toilet_points + $washbasin_points + $multi_washbasin_points) / $address_count) / $amount, 2);
                    $this->bathroomToiletPoints += ($toilet_points + $floating_toilet_points / $address_count) / $amount;
                    $this->bathroomWashbasinPoints += ($washbasin_points + $multi_washbasin_points / $address_count) / $amount;
                }
            } elseif ($type->check->dependentPropertyVTwo()->exists()) {
                $sum_bathroom_points = $type_points + $extra_facility_points[0] + $toilet_points + $floating_toilet_points + $washbasin_points + $multi_washbasin_points;
                $bathroomMessage = $sum_bathroom_points > $max_points ? 'Voorzieningen badkamer afgetopt ('.$max_points.' punten)' : '';
                $total = $sum_bathroom_points > $max_points ? $max_points : $sum_bathroom_points;

                $total = $this->quarterRounding($total);
            } else {
                $total = $total + $toilet_points + $floating_toilet_points + $washbasin_points + $multi_washbasin_points;

            }
        }
        if (in_array($this->period, config('check-versions.version-1'))) {

            return [[
                'index' => $index,
                'type' => $washing_type,
                'type_points' => $type_points,
                'extra_facilities' => $extra_facility_points[1],
                'extra_facilities_total' => $extra_facility_points[0],
                'tile' => $type->extra_bathroom_tiles,
                'tile_points' => $tile_points,
                'luxury_points' => $type->extra_bathroom_luxury_points,
                'message' => $bathroomMessage,
                'total' => $total,
            ], $total];
        } else {
            return [[
                'index' => $index,
                'type' => $washing_type,
                'type_points' => $type_points,
                'extra_facilities' => $extra_facility_points[1],
                'extra_facilities_total' => $extra_facility_points[0],
                'toilet' => $toilet_points,
                'floating_toilet' => $floating_toilet_points,
                'washbasin' => $washbasin_points,
                'multi_washbasin' => $multi_washbasin_points,
                'toilet_count' => $type instanceof IndependentProperty ? $type->extra_toilet : $type->toilet,
                'floating_toilet_count' => $type instanceof IndependentProperty ? $type->extra_floating_toilet : $type->floating_toilet,
                'washbasin_count' => $type instanceof IndependentProperty ? $type->extra_washbasin : $type->washbasin,
                'multi_washbasin_count' => $type instanceof IndependentProperty ? $type->extra_multi_washbasin : $type->multi_washbasin,
                'tile' => null,
                'tile_points' => null,
                'luxury_points' => null,
                'message' => $bathroomMessage,
                'total' => $total,
            ], $total];
        }
    }

    public function generateKitchenArray($extra_facilities, $type, $index)
    {
        $this->bathroomTypes = config('areas.bathrooms');
        $this->kitchenTypes = config('areas.kitchens');

        $counter_type = $type->length_kitchen_counter;
        $max_points = $counter_type ? $this->config['kitchen_counter'][$counter_type] * 2 : null;
        $extra_facilities = $this->service->calculateKitchenFacilityPoints($extra_facilities, $this->period);
        $counter_type_points = $this->service->calculateKitchenCounterPoints($counter_type, $this->period);
        $tile_points = $this->service->calculateKitchenTilePoints($type->wall_tiles, $type->floor_tiles, $this->period);
        $sumKitchenPoints = ((in_array($this->period, config('check-versions.version-1')) ? $type->extra_luxury_points + $tile_points : 0) + $extra_facilities[0] + $counter_type_points);
        $kitchenMessage = $sumKitchenPoints > $max_points ? 'Voorzieningen keuken afgetopt ('.$max_points.' punten)' : '';

        if (in_array($this->period, config('check-versions.version-2')) && $type instanceof Area) {
            $amount = $type->amount > 1 ? $type->amount : 1;
            $address_count = $type->address_count > 1 ? $type->address_count : 1;
            $total = $sumKitchenPoints > $max_points ? $max_points : $sumKitchenPoints;
            if ($type->shared_with) {
                if ($type->check->dependentPropertyVTwo()->exists()) {
                    $total = round(($total / $address_count) / $amount, 2);
                } else {
                    $total = round(($total / $address_count) / $amount, 2);
                }
            }
        } else {
            $total = $sumKitchenPoints > $max_points ? $max_points : $sumKitchenPoints;
        }

        if (in_array($this->period, config('check-versions.version-1'))) {
            return [[
                'index' => $index,
                'type' => $counter_type,
                'type_points' => $counter_type_points,
                'extra_facilities' => $extra_facilities[1],
                'facility_total' => $extra_facilities[0],
                'wall_tiles' => $type->wall_tiles,
                'floor_tiles' => $type->floor_tiles,
                'tile_points' => $tile_points,
                'luxury_points' => $type->extra_luxury_points,
                'message' => $kitchenMessage,
                'total' => $total,
            ], $total];
        } else {
            return [[
                'index' => $index,
                'type' => $counter_type,
                'type_points' => $counter_type_points,
                'extra_facilities' => $extra_facilities[1],
                'facility_total' => $extra_facilities[0],
                'wall_tiles' => null,
                'floor_tiles' => null,
                'tile_points' => null,
                'luxury_points' => null,
                'message' => $kitchenMessage,
                'total' => $total,
            ], $total];
        }
    }

    public function calculateToiletRooms()
    {
        $toilet_rooms = $this->check->areas()->where('remaining_area', AreaRemainingTypeEnum::ToiletRoom)->get();
        $toilet_points = 0;
        $floating_toilet_points = 0;
        $washbasin_points = 0;
        $multi_washbasin_points = 0;

        $toilet_count = 0;
        $floating_toilet_count = 0;
        $washbasin_count = 0;
        $multi_washbasin_count = 0;

        foreach ($toilet_rooms as $room) {
            if (! is_null($room->check->dependentPropertyVTwo)) {
                $toilet_points += $this->service->calculateToiletPoints($room->toilet, $room, $this->period);
                $floating_toilet_points += $this->service->calculateFloatingToiletPoints($room->floating_toilet, $room, $this->period);
                $washbasin_points += $this->service->calculateWashbasinPoints($room->washbasin, $room, $this->period);
                $multi_washbasin_points += $this->service->calculateMultiWashbasinPoints($room->multi_washbasin, $room, $this->period);
            } else {
                $toilet_points += $this->service->calculateToiletPointsPThree($room->toilet, $room, $this->period);
                $floating_toilet_points += $this->service->calculateFloatingToiletPointsPThree($room->floating_toilet, $room, $this->period);
                $washbasin_points += $this->service->calculateWashbasinPointsPThree($room->washbasin, $room, $this->period);
                $multi_washbasin_points += $this->service->calculateMultiWashbasinPointsPThree($room->multi_washbasin, $room, $this->period);
            }
            $toilet_count += $room->toilet;
            $floating_toilet_count += $room->floating_toilet;
            $washbasin_count += $room->washbasin;
            $multi_washbasin_count += $room->multi_washbasin;
        }

        $this->toiletPoints = $toilet_points;
        $this->floatingToiletPoints = $floating_toilet_points;
        $this->washbasinPoints = $washbasin_points;
        $this->multiWashbasinPoints = $multi_washbasin_points;

        $this->washbasinCount = $washbasin_count;
        $this->multiWashbasinCount = $multi_washbasin_count;
        $this->toiletCount = $toilet_count;
        $this->floatingToiletCount = $floating_toilet_count;
    }
}
