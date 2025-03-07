<?php

namespace App\Traits\Api\Validation;

use App\Enums\PropertyEnums\PropertyTypeEnum;
use App\Models\ApiKey;
use Illuminate\Validation\Rule;

trait PropertyValidationRules
{
    public function propertyStoreRules(): array
    {
        $company = ApiKey::where('api_key', request()->bearerToken())->first()?->company;

        return [
            'property' => 'required|array',
            'property.reference' => [
                'required',
                'string',
                'max:255',
                $company ? Rule::unique('properties', 'reference')->where('company_id', $company->id) : 'unique:properties,reference',
            ],
            'property.street' => ['required', 'string', 'max:255'],
            'property.city' => ['required', 'string', 'max:255'],
            'property.postal_code' => ['required', 'regex:/^[0-9]{4}[a-zA-Z]{2}$/'],
            'property.house_number' => ['required', 'regex:/^[0-9]{0,4}$/'],
            'property.house_number_addition' => ['nullable'],
            'property.house_letter' => ['nullable', 'max:1', 'regex:/^[A-Za-z]$/'],
            'property.current_rental_price' => ['required', 'numeric'],
            'property.type' => ['required', Rule::in(PropertyTypeEnum::getValues())],
            'property.construction_year' => ['required', 'numeric'],
            'property.pre_juli_contract' => ['sometimes', 'boolean'],
            'property.new_construction_raise' => ['sometimes', 'boolean'],
        ];
    }

    public function propertyUpdateRules(): array
    {
        return [
            'property' => 'sometimes|array',
            'property.current_rental_price' => ['sometimes', 'required', 'numeric'],
            'property.type' => ['sometimes', 'required', Rule::in(PropertyTypeEnum::getValues())],
            'property.construction_year' => ['sometimes', 'required', 'numeric'],
        ];
    }
}
