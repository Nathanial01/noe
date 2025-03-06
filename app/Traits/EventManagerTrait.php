<?php

namespace App\Traits;

trait EventManagerTrait
{
    public function triggerAreaAndPreviewEvent()
    {
        $this->dispatch('updateAreaPreview');
        $this->dispatch('updatePreviewData');
    }

    public function triggerFullRefreshEvent()
    {
        $this->dispatch('updateAreaPreview');
        $this->dispatch('updatePreviewData');
        $this->dispatch('updateBathroomProperties');
        $this->dispatch('getKitchenAreas');
    }
}
