<?php

namespace App\Traits;

use App\Enums\PropertyEnums\PropertyTypeEnum;

trait StringModificationTrait
{
    public $monument_string;

    public function getMonumentString()
    {
        if (in_array($this->period, config('check-versions.version-1'))) {
            if ($this->property->type === PropertyTypeEnum::NationalMonument) {
                $this->monument_string = '50';
            } elseif ($this->property->hasProtectedRights($this->check)) {
                $this->monument_string = '15% prijsopslag';
            } else {
                $this->monument_string = '0';
            }
        } elseif (in_array($this->period, config('check-versions.version-2'))) {
            if ($this->property->hasProtectedRights($this->check) && ! $this->check->pre_juli_contract) {
                $this->monument_string = ((config('independent.'.$this->period.'.property_type.'.$this->property->type) * 100) - 100).'% prijsopslag';
            } elseif ($this->property->type === PropertyTypeEnum::NationalMonument && $this->check->pre_juli_contract) {
                $dependency = $this->check->independentProperty()->exists() ? 'independent' : 'dependent';
                $this->monument_string = config($dependency.'.'.$this->period.'.property_type_old_contract.'.PropertyTypeEnum::NationalMonument);
            }
        }
    }
}
