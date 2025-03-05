<?php

namespace App\Traits;

trait DependentAreaInfoTrait
{
    public $normal_info;

    public $normal_surface;

    public $normal_total;

    public $remaining_info;

    public $remaining_surface;

    public $remaining_total;

    public $outside_info;

    public $outside_surface;

    public $outside_total;

    public $areaTotalPoints;

    public $shared;

    public $shared_remaining;

    public $shared_outside;

    public $shared_normal_total;

    public $shared_remaining_total;

    public $shared_outside_total;

    public $fullCommonSurface;

    public $sharedAreaPoints;

    public $sharedAreaHeatingPoints;

    public $cooling_info;

    public $parking_points;

    public $parking_info;

    public function generateAreaInfo()
    {
        $normal_areas = count($this->normal_areas) > 0 ?
            $this->service->calculateNormalAreaPoints($this->normal_areas, $this->period, $this->outside_areas->count()) : [];
        $remaining_areas = count($this->remaining_areas) > 0 ?
            $this->service->calculateRemainingAreaPoints($this->remaining_areas, $this->period) : [];
        $outside_areas = count($this->outside_areas) > 0 ?
            $this->service->calculatePeriodThreeOutsidePoints($this->outside_areas, $this->period) : [];

        $this->normal_info = count($this->normal_areas) > 0 ? $normal_areas[1] : [];
        $this->normal_surface = count($this->normal_areas) > 0 ? $this->getSurface($this->normal_info) : 0;
        $this->normal_total = count($this->normal_areas) > 0 ? $normal_areas[0] : 0;

        $this->remaining_info = count($this->remaining_areas) > 0 ? $remaining_areas[1] : [];
        $this->remaining_surface = count($this->remaining_areas) > 0 ? $this->getSurface($this->remaining_info) : 0;
        $this->remaining_total = count($this->remaining_areas) > 0 ? $remaining_areas[0] : 0;

        $this->outside_info = count($this->outside_areas) > 0 ? $outside_areas[1] : [];
        $this->outside_surface = count($this->outside_areas) > 0 ? $this->getSurface($this->outside_info) : 0;
        $this->outside_total = count($this->outside_areas) > 0 ? $outside_areas[0] : 0;

        $this->areaTotalPoints = $this->normal_total + $this->remaining_total + $this->outside_total;

        $shared_normal_info = $this->service->calculateSharedNormalAreaPoints($this->shared_normal_areas, $this->period);
        $shared_remaining_info = $this->service->calculateSharedRemainingPoints($this->shared_remaining_areas, $this->period);

        $this->shared = count($this->shared_normal_areas) > 0 ? $shared_normal_info[1] : [];
        $shared_surface = count($this->shared_normal_areas) > 0 ? $this->getSurface($this->shared) : 0;
        $this->shared_normal_total = count($this->shared_normal_areas) > 0 ? $shared_normal_info[0] : 0;

        $this->shared_remaining = count($this->shared_remaining_areas) > 0 ? $shared_remaining_info[1] : [];
        $shared_remaining_surface = count($this->shared_remaining_areas) > 0 ? $this->getSurface($this->shared_remaining) : 0;
        $this->shared_remaining_total = count($this->shared_remaining_areas) > 0 ? $shared_remaining_info[0] : 0;

        $this->fullCommonSurface = $shared_surface + $shared_remaining_surface;

        $this->sharedAreaPoints = $this->shared_normal_total + $this->shared_remaining_total;
        $this->sharedAreaHeatingPoints = $this->service->calculateSharedHeatedAreasPoints($this->shared_areas, $this->period);

        $this->service->calculatePeriodThreeOutsidePoints($this->check->areas()->whereNotNull('outside_area')->get(), $this->period);

        if (in_array($this->period, config('check-versions.version-1'))) {
            return;
        }
        $parking_area_info = count($this->parking_areas) > 0 ?
            $this->service->calculateParkingAreas($this->parking_areas, $this->period) : [];

        $this->parking_points = count($this->parking_areas) > 0 ? $parking_area_info[0] : 0;
        $this->parking_info = count($this->parking_areas) > 0 ? $parking_area_info[1] : [];
        $this->cooling_info = count($this->normal_areas) > 0 || count($this->remaining_areas) > 0 ? $this->service->calculateCoolingPoints($this->normal_areas, $this->remaining_areas, $this->period) : 0;
        $this->cooling_info += count($this->shared_normal_areas) > 0 || count($this->shared_remaining_areas) > 0 ? $this->service->calculateSharedCoolingPoints($this->shared_normal_areas, $this->shared_remaining_areas, $this->period) : 0;
    }

    public function getSurface($array)
    {
        return array_sum(
            array_map(
                function ($item) {
                    return $item['surface'];
                }, $array
            )
        );
    }
}
