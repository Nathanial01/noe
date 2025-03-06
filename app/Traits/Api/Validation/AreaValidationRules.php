<?php

namespace App\Traits\Api\Validation;

use App\Enums\AreaEnums\AreaOutsideTypeEnum;
use App\Enums\AreaEnums\AreaRemainingTypeEnum;
use App\Enums\AreaEnums\AreaTypeEnum;
use App\Enums\AreaEnums\DependentAreaOutsideTypeEnum;
use App\Enums\AreaEnums\V2\AreaRemainingTypeEnum as DepedentAreaRemainingTypeEnum;
use App\Enums\DependentKitchenCounterLengthEnum;
use App\Enums\DependentPropertyEnums\DependentBikeAreaTypeEnum;
use App\Enums\IndependentPropertyEnums\IndependentKitchenCounterLengthExtraTypeEnum;
use App\Enums\IndependentPropertyEnums\NewExtraBathroomFacilityEnum;
use App\Enums\IndependentPropertyEnums\NewExtraKitchenFacilityEnum;
use App\Enums\IndependentPropertyEnums\NewIndependentBathroomTypesEnum;
use App\Enums\IndependentPropertyEnums\ParkingOptionsEnum;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Validator;

trait AreaValidationRules
{
    public function independentAreaRules(): array
    {
        return [
            'areas.*' => ['required', 'array'],
            'areas.*.type' => ['required', 'string', Rule::in(array_merge(AreaTypeEnum::getValues(), AreaRemainingTypeEnum::getValues(), AreaOutsideTypeEnum::getValues(), ParkingOptionsEnum::getValues()))],
            'areas.*.length' => ['sometimes', 'decimal:0,2'],
            'areas.*.width' => ['sometimes', 'decimal:0,2'],
            'areas.*.surface' => ['required', 'decimal:0,2'],
            'areas.*.amount' => ['sometimes', 'integer'],
            'areas.*.heated' => ['sometimes', 'boolean'],
            'areas.*.cooled' => ['sometimes', 'boolean'],
            'areas.*.shared' => ['sometimes', 'boolean'],
            'areas.*.charging_station' => ['sometimes', 'boolean'],
            'areas.*.length_kitchen_counter' => ['sometimes', 'string', Rule::in(IndependentKitchenCounterLengthExtraTypeEnum::getValues())],
            'areas.*.sanitary_type' => ['sometimes', 'string', Rule::in(NewIndependentBathroomTypesEnum::getValues())],
            'areas.*.multi_washbasin' => ['sometimes', 'integer'],
            'areas.*.floating_toilet' => ['sometimes', 'integer'],
            'areas.*.toilet' => ['sometimes', 'integer'],
            'areas.*.washbasin' => ['sometimes', 'integer'],
            'areas.*.extra_facilities' => ['sometimes', 'array'],
            'areas.*.extra_facilities.*.extra_kitchen_facility' => ['sometimes', 'string', Rule::in(NewExtraKitchenFacilityEnum::getValues())],
            'areas.*.extra_facilities.*.extra_bathroom_facility' => ['sometimes', 'string', Rule::in(NewExtraBathroomFacilityEnum::getValues())],
            'areas.*.extra_facilities.*.amount' => ['required', 'integer'],
        ];
    }

    public function dependentAreaRules(): array
    {
        return [
            'areas.*' => ['required', 'array'],
            'areas.*.type' => ['required', 'string', Rule::in(array_merge(AreaTypeEnum::getValues(), DepedentAreaRemainingTypeEnum::getValues(), DependentAreaOutsideTypeEnum::getValues(), ParkingOptionsEnum::getValues(), DependentBikeAreaTypeEnum::getValues()))],
            'areas.*.address_count' => ['required', 'integer'],
            'areas.*.length' => ['sometimes', 'decimal:0,2'],
            'areas.*.width' => ['sometimes', 'decimal:0,2'],
            'areas.*.surface' => ['required', 'decimal:0,2'],
            'areas.*.amount' => ['sometimes', 'integer'],
            'areas.*.heated' => ['sometimes', 'boolean'],
            'areas.*.cooled' => ['sometimes', 'boolean'],
            'areas.*.shared' => ['sometimes', 'boolean'],
            'areas.*.charging_station' => ['sometimes', 'boolean'],
            'areas.*.length_kitchen_counter' => ['sometimes', 'string', Rule::in(DependentKitchenCounterLengthEnum::getValues())],
            'areas.*.sanitary_type' => ['sometimes', 'string', Rule::in(NewIndependentBathroomTypesEnum::getValues())],
            'areas.*.multi_washbasin' => ['sometimes', 'integer'],
            'areas.*.floating_toilet' => ['sometimes', 'integer'],
            'areas.*.toilet' => ['sometimes', 'integer'],
            'areas.*.washbasin' => ['sometimes', 'integer'],
            'areas.*.extra_facilities' => ['sometimes', 'array'],
            'areas.*.extra_facilities.*.extra_kitchen_facility' => ['sometimes', 'string', Rule::in(NewExtraKitchenFacilityEnum::getValues())],
            'areas.*.extra_facilities.*.extra_bathroom_facility' => ['sometimes', 'string', Rule::in(NewExtraBathroomFacilityEnum::getValues())],
            'areas.*.extra_facilities.*.amount' => ['required', 'integer'],
        ];
    }

    public function validateShared(Validator $validator, array $area): void
    {
        if (! array_key_exists('shared', $area)) {
            return;
        }

        $isShared = $area['shared'] ?? false;
        $hasAmount = array_key_exists('amount', $area) && $area['amount'] > 0;
        if ($isShared && ! $hasAmount) {
            $validator->errors()->add('shared', 'Shared cannot be used without amount');
        }
    }

    public function validateExtraAreaFacilities(Validator $validator, array $area): void
    {
        if (! array_key_exists('extra_facilities', $area)) {
            return;
        }

        if (! in_array($area['type'], AreaTypeEnum::kitchenTypes()) && ! in_array($area['type'], AreaTypeEnum::bathRoomTypes())) {
            // Extra facilities can only be use when type is of kitchen type or bathroom type
            $validator->errors()->add('extra_facilities', 'Extra facilities cannot be used with this area type');
        }

        if (in_array($area['type'], AreaTypeEnum::kitchenTypes())) {
            // Kitchen can't have bathroom facilities
            $hasBathroomFacilities = collect($area['extra_facilities'])->filter(function ($facility) {
                return array_key_exists('etxra_bathroom_facility', $facility);
            })->isNotEmpty();

            if ($hasBathroomFacilities) {
                $validator->errors()->add('extra_facilities', 'Extra bathroom facilities are not allowed with this area type');
            }
        }

        if (in_array($area['type'], AreaTypeEnum::bathRoomTypes())) {
            // Bathroom can't have kitchen facilities
            $hasKitchenFacilities = collect($area['extra_facilities'])->filter(function ($facility) {
                return array_key_exists('extra_kitchen_facility', $facility);
            })->isNotEmpty();

            if ($hasKitchenFacilities) {
                $validator->errors()->add('extra_facilities', 'Extra kitchen facilities are not allowed with this area type');
            }
        }
    }

    public function validateChargingStation(Validator $validator, array $area): void
    {
        if (! array_key_exists('charging_station', $area)) {
            return;
        }

        if ($area['charging_station'] && ! in_array($area['type'], ParkingOptionsEnum::getValues())) {
            $validator->errors()->add('charging_station', 'Charging station cannot be used with this area type');
        }
    }

    public function validateHeated(Validator $validator, array $area): void
    {
        if (! array_key_exists('heated', $area)) {
            return;
        }

        if ($area['heated'] && (! in_array($area['type'], AreaTypeEnum::getValues()) && ! in_array($area['type'], AreaRemainingTypeEnum::getValues()))) {
            $validator->errors()->add('heated', 'Heated cannot be used with this area type');

            return;
        }
    }

    public function validateCooled(Validator $validator, array $area): void
    {
        if (! array_key_exists('cooled', $area)) {
            return;
        }

        if ($area['cooled'] && (! in_array($area['type'], AreaTypeEnum::getValues()) && ! in_array($area['type'], AreaRemainingTypeEnum::getValues()))) {
            $validator->errors()->add('cooled', 'Cooled cannot be used with this area type');

            return;
        }
    }

    public function validateSanitaryType(Validator $validator, array $area)
    {
        if (! array_key_exists('sanitary_type', $area)) {
            return;
        }

        if (! in_array($area['type'], AreaTypeEnum::bathRoomTypes())) {
            $validator->errors()->add('sanitary_type', 'Sanitary type cannot be used with this area type');
        }
    }

    public function validateKitchenLength(Validator $validator, array $area)
    {
        if (! array_key_exists('length_kitchen_counter', $area)) {
            return;
        }

        if (! in_array($area['type'], AreaTypeEnum::kitchenTypes())) {
            $validator->errors()->add('length_kitchen_counter', 'Length kitchen counter cannot be used with this area type');
        }
    }

    public function validateAmount(Validator $validator, array $area)
    {
        if (! array_key_exists('amount', $area)) {
            return;
        }

        // amount can only be used with parking or shared areas
        if (! in_array($area['type'], ParkingOptionsEnum::getValues()) && (! array_key_exists('shared', $area) || (array_key_exists('shared', $area) && ! $area['shared']))) {
            $validator->errors()->add('amount', 'Amount can only be used with parking or shared areas');
        }
    }

    public function validateBathroomTypes(Validator $validator, array $area)
    {
        if (array_key_exists('washbasin', $area)) {
            if ($area['washbasin'] > 0 && ! in_array($area['type'], AreaTypeEnum::bathRoomTypes())) {
                $validator->errors()->add('washbasin', 'Washbasin cannot be used with this area type');
            }
        }

        if (array_key_exists('floating_toilet', $area)) {
            if ($area['floating_toilet'] > 0 && ! in_array($area['type'], AreaTypeEnum::bathRoomTypes())) {
                $validator->errors()->add('floating_toilet', 'Washbasin cannot be used with this area type');
            }
        }

        if (array_key_exists('toilet', $area)) {
            if ($area['toilet'] > 0 && ! in_array($area['type'], AreaTypeEnum::bathRoomTypes())) {
                $validator->errors()->add('toilet', 'Toilet cannot be used with this area type');
            }
        }

        if (array_key_exists('multi_washbasin', $area)) {
            if ($area['multi_washbasin'] > 0 && ! in_array($area['type'], AreaTypeEnum::bathRoomTypes())) {
                $validator->errors()->add('multi_washbasin', 'Multi washbasin cannot be used with this area type');
            }
        }
    }

    public function validateBikeshed(Validator $validator, array $area)
    {
        if ($area['type'] === DependentAreaOutsideTypeEnum::BikeShed && (! array_key_exists('shared', $area) || (array_key_exists('shared', $area) && ! $area['shared']))) {
            $validator->errors()->add('type', 'Bike shed can only be used with shared areas');
        }
    }
}
