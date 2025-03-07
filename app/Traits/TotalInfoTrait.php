<?php

namespace App\Traits;

use App\Models\Points;

trait TotalInfoTrait
{
    public $basePrice;

    public function getBasePrice()
    {
        $this->basePrice = Points::where('points', $this->check->points)->whereDate('end_date', $this->check->end_date)->whereDate('start_date', $this->check->start_date)->first();
    }
}
