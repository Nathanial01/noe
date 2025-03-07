<?php

namespace App\Traits;

trait SubtotalCalculationTrait
{
    public $generalSubtotal;

    public $careSubtotal;

    public $areaSubtotal;

    public $kitchenSubtotal;

    public $sanitarySubtotal;

    public $sharedAreaSubtotal;

    public $sanitaryAggregate;

    public function calculateGeneralSubtotal(): void
    {
        $total = $this->propertyTypePoints +
                    $this->wozInfo +
                    $this->insideAreaHeatingInfo +
                    $this->energyLabelInfo +
                    $this->renovationInfo +
                    $this->parking_points +
                    (! is_null($this->cooling_info) ? $this->cooling_info : 0) +
                    $this->homePhoneWithVideoPoints;

        $this->generalSubtotal = $total;
    }

    public function calculateCareSubtotal(): void
    {
        $total = $this->generalSubtotal +
                    $this->careHomePoints +
                    $this->facilitiesForDisabledPoints;

        $this->careSubtotal = $total;
    }

    public function calculateAreaSubtotal(): void
    {
        $total = $this->careSubtotal +
                    $this->areaTotalPoints +
                    $this->carportInfo +
                    $this->remainingAreaHeatingInfo;

        $this->areaSubtotal = $total;
    }

    public function calculateKitchenSubtotal(): void
    {
        $total = $this->areaSubtotal +
                    $this->total_kitchen_points;

        $this->kitchenSubtotal = $total;
    }

    public function calculateSanitarySubtotal(): void
    {
        $total = $this->kitchenSubtotal +
                    $this->total_bathroom_points;

        if (in_array($this->period, config('check-versions.version-1'))) {
            $total += $this->toiletInfo;
            $total += $this->washbasinInfo;
        }

        if (in_array($this->period, config('check-versions.version-2'))) {
            $total += $this->toiletPoints;
            $total += $this->washbasinPoints;
            $total += $this->floatingToiletPoints;
            $total += $this->multiWashbasinPoints;
        }

        $this->sanitarySubtotal = $total;
    }

    public function calculateSharedAreaSubtotal(): void
    {
        $total = $this->sanitarySubtotal +
                    $this->sharedAreaPoints +
                    $this->sharedAreaHeatingPoints;

        $this->sharedAreaSubtotal = $total;
    }

    public function calculateSanitaryAggregate()
    {
        $total = $this->toiletPoints +
                    $this->washbasinPoints +
                    $this->floatingToiletPoints +
                    $this->multiWashbasinPoints +
                    $this->total_bathroom_points;

        $this->sanitaryAggregate = $total;
    }
}
