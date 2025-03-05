<?php

namespace App\Traits;

trait ArrayModificationTrait
{
    public function filterByString($array, $needle)
    {
        return array_filter($array,
            function ($item) use ($needle) {
                return str_contains($item, $needle);
            }
        );
    }
}
