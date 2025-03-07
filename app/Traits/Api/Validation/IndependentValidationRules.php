<?php

namespace App\Traits\Api\Validation;

use Illuminate\Validation\Validator;

trait IndependentValidationRules
{
    public function validateShowerOutsideBathroom(Validator $validator, array $independent): void
    {
        if (! array_key_exists('shower_outside_bathroom', $independent)) {
            return;
        }

        if ($independent['shower_outside_bathroom'] && ! array_key_exists('sanitary_type', $independent)) {
            $validator->errors()->add('sanitary_type', 'Sanitary type is required when shower outside bathroom is true');

            return;
        }
    }

    public function validateKitchenUnit(Validator $validator, array $independent): void
    {
        if (! array_key_exists('kitchen_unit_outside_kitchen', $independent)) {
            return;
        }

        if ($independent['kitchen_unit_outside_kitchen'] && ! array_key_exists('length_kitchen_counter', $independent)) {
            $validator->errors()->add('length_kitchen_counter', 'Length kitchen counter is required when kitchen unit outside kitchen is true');

            return;
        }
    }

    public function validateEnergyLabel(Validator $validator, array $independent): void
    {
        if (! array_key_exists('energy_label', $independent)) {
            return;
        }

        $types = [
            'energy_label' => $independent['energy_label'] ?? null,
            'energy_index' => $independent['energy_index'] ?? null,
            'no_energy_label' => $independent['no_energy_label'] ?? null,
        ];

        $filled = collect($types)->filter(function ($value) {
            return ! is_null($value);
        });

        if ($filled->count() > 1) {
            $validator->errors()->add('energy_label', 'Only one of energy label, energy index, no energy label should be filled');
        }
    }

    public function validateExtraFacilities(Validator $validator, array $independent): void
    {
        if (! array_key_exists('extra_facilities', $independent)) {
            return;
        }

        $hasKitchenOutsideKitchen = array_key_exists('kitchen_unit_outside_kitchen', $independent) && $independent['kitchen_unit_outside_kitchen'];
        $hasShowerOutsideBathroom = array_key_exists('shower_outside_bathroom', $independent) && $independent['shower_outside_bathroom'];

        if (! $hasKitchenOutsideKitchen && ! $hasShowerOutsideBathroom) {
            $validator->errors()->add('extra_facilities', 'Extra facilities can only be used when kitchen_unit_outside_kitchen or shower_outside_bathroom is used');

            return;
        }

        if ($hasKitchenOutsideKitchen && ! $hasShowerOutsideBathroom) {
            $hasBathroomFacilities = collect($independent['extra_facilities'])->filter(function ($facility) {
                return array_key_exists('extra_bathroom_facility', $facility);
            })->isNotEmpty();

            if ($hasBathroomFacilities) {
                $validator->errors()->add('extra_facilities', 'Extra bathroom facilities are not allowed for kitchen');
            }
        }

        if ($hasShowerOutsideBathroom && ! $hasKitchenOutsideKitchen) {
            $hasKitchenFacilities = collect($independent['extra_facilities'])->filter(function ($facility) {
                return array_key_exists('extra_kitchen_facility', $facility);
            })->isNotEmpty();

            if ($hasKitchenFacilities) {
                $validator->errors()->add('extra_facilities', 'Extra kitchen facilities are not allowed for bathroom');
            }
        }
    }

    public function validateExtraBathroomOptions(Validator $validator, array $independent)
    {
        $hasShowerOutsideBathroom = array_key_exists('shower_outside_bathroom', $independent) && $independent['shower_outside_bathroom'];
        $hasExtraToilet = array_key_exists('extra_toilets', $independent) && $independent['extra_toilets'] > 0;
        $hasExtraFloatingToilet = array_key_exists('extra_floating_toilets', $independent) && $independent['extra_floating_toilets'] > 0;
        $hasExtraWashbasin = array_key_exists('extra_washbasins', $independent) && $independent['extra_washbasins'] > 0;
        $hasExtraMultiWashbasin = array_key_exists('extra_multi_washbasins', $independent) && $independent['extra_multi_washbasins'] > 0;

        if (! $hasShowerOutsideBathroom && $hasExtraToilet) {
            $validator->errors()->add('extra_toilets', 'Extra toilets cannot be used with shower outside bathroom');
        }

        if (! $hasShowerOutsideBathroom && $hasExtraFloatingToilet) {
            $validator->errors()->add('extra_floating_toilets', 'Extra floating toilets cannot be used with shower outside bathroom');
        }

        if (! $hasShowerOutsideBathroom && $hasExtraWashbasin) {
            $validator->errors()->add('extra_washbasins', 'Extra washbasins cannot be used with shower outside bathroom');
        }

        if (! $hasShowerOutsideBathroom && $hasExtraMultiWashbasin) {
            $validator->errors()->add('extra_multi_washbasins', 'Extra multi washbasins cannot be used with shower outside bathroom');
        }
    }

    public function validateDisabledFacility(Validator $validator, array $independent)
    {
        $hasDisabledFacility = array_key_exists('has_disabled_facility', $independent) && $independent['has_disabled_facility'];
        $hasExtraCostsDisabled = array_key_exists('extra_costs_disabled', $independent) && $independent['extra_costs_disabled'] > 0;
        $hasExtraCostsDisabledDescription = array_key_exists('extra_costs_disabled_description', $independent) && ! empty($independent['extra_costs_disabled_description']);

        if (! $hasDisabledFacility && $hasExtraCostsDisabled) {
            $validator->errors()->add('extra_costs_disabled', 'Extra costs for disabled cannot be used when has disabled facility is false');
        }

        if (! $hasDisabledFacility && $hasExtraCostsDisabledDescription) {
            $validator->errors()->add('extra_costs_disabled_description', 'Extra costs for disabled description cannot be used when has disabled facility is false');
        }
    }
}
