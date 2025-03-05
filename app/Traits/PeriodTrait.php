<?php

namespace App\Traits;

use App\Enums\CheckEnums\CheckStartDateEnum;
use App\Models\Check;

trait PeriodTrait
{
    public function periodString(Check $check): string
    {
        if (is_null($check->start_date) || empty($check->start_date)) {
            return 'test-period';
        }
        if ($check->start_date === CheckStartDateEnum::PeriodTwentyOneTwo) {
            return 'period-1';
        } elseif ($check->start_date === CheckStartDateEnum::PeriodTwentyTwoThree) {
            return 'period-2';
        } elseif ($check->start_date === CheckStartDateEnum::PeriodTwentyThreeFour) {
            return 'period-3';
        } elseif ($check->start_date === CheckStartDateEnum::PeriodTwentyTwentyThree) {
            return 'period-4';
        } elseif ($check->start_date === CheckStartDateEnum::PeriodTwentyTwentyThreeTwo) {
            return 'period-5';
        } elseif ($check->start_date === CheckStartDateEnum::PeriodTwentyTwentyFourStart) {
            return 'period-6';
        } elseif ($check->start_date === CheckStartDateEnum::PeriodTwentyFiveOne) {
            return 'period-7';
        }
    }

    public function periodByString(string $date): string
    {
        if (is_null($date) || empty($date)) {
            return 'test-period';
        }
        if ($date === CheckStartDateEnum::PeriodTwentyOneTwo) {
            return 'period-1';
        } elseif ($date === CheckStartDateEnum::PeriodTwentyTwoThree) {
            return 'period-2';
        } elseif ($date === CheckStartDateEnum::PeriodTwentyThreeFour) {
            return 'period-3';
        } elseif ($date === CheckStartDateEnum::PeriodTwentyTwentyThree) {
            return 'period-4';
        } elseif ($date === CheckStartDateEnum::PeriodTwentyTwentyThreeTwo) {
            return 'period-5';
        } elseif ($date === CheckStartDateEnum::PeriodTwentyTwentyFourStart) {
            return 'period-6';
        } elseif ($date === CheckStartDateEnum::PeriodTwentyFiveOne) {
            return 'period-7';
        }
    }
}
