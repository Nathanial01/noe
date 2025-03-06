<?php

namespace App\Traits;

trait DependentSubtotalCalculationTrait
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
        $total = $this->wozPoints +
                    $this->insideAreaHeatingPoints +
                    $this->energyLabelInfo +
                    $this->parking_points +
                    $this->propertyTypePoints +
                    (! is_null($this->cooling_info) ? $this->cooling_info : 0) +
                    $this->homePhoneWithVideoPoints -
                    $this->totalMinus;

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
                    $this->remainingAreaHeatingPoints;

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
                    $this->total_bathroom_points +
                    $this->toiletPoints +
                    $this->washbasinPoints +
                    $this->multiWashbasinPoints +
                    $this->floatingToiletPoints;

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
