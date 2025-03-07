<?php

namespace App\Traits\Api\Validation;

use Illuminate\Validation\Validator;

trait DependentValidationRules
{
    public function validateDisabledFacility(Validator $validator, array $dependent)
    {
        $hasDisabledFacility = array_key_exists('has_disabled_facility', $dependent) && $dependent['has_disabled_facility'];
        $hasExtraCostsDisabled = array_key_exists('extra_costs_disabled', $dependent) && $dependent['extra_costs_disabled'] > 0;
        $hasExtraCostsDisabledDescription = array_key_exists('extra_costs_disabled_description', $dependent) && ! empty($dependent['extra_costs_disabled_description']);

        if (! $hasDisabledFacility && $hasExtraCostsDisabled) {
            $validator->errors()->add('extra_costs_disabled', 'Extra costs for disabled cannot be used when has disabled facility is false');
        }

        if (! $hasDisabledFacility && $hasExtraCostsDisabledDescription) {
            $validator->errors()->add('extra_costs_disabled_description', 'Extra costs for disabled description cannot be used when has disabled facility is false');
        }
    }

    public function validateCareHome(Validator $validator, array $dependent)
    {
        $hasDisabledFacility = array_key_exists('has_disabled_facility', $dependent) && $dependent['has_disabled_facility'];
        $hasCareAccessCount = array_key_exists('care_access_count', $dependent) && ! empty($dependent['care_access_count']);

        if (! $hasDisabledFacility && $hasCareAccessCount) {
            $validator->errors()->add('care_access_count', 'Care access count cannot be used when is has disabled facility is false');
        }
    }
}
