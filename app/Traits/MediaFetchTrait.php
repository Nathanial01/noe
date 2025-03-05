<?php

namespace App\Traits;

trait MediaFetchTrait
{
    public $areaMedia = [];

    public $commonMedia = [];

    public $generalMedia = [];

    public $kitchenMedia = [];

    public $sanitaryMedia = [];

    public $carportMedia = [];

    public $extrasMedia = [];

    public $disabledMedia = [];

    public $heatedMedia = [];

    // public $areaMedia       = [];
    // public $kitchenMedia    = [];
    // public $sanitaryMedia   = [];
    public $heatingMedia = [];

    public $outsideMedia = [];

    public $bikeRackMedia = [];

    public $minusMedia = [];

    public function getIndependentMedia()
    {
        $areaMedia = [];
        $commonMedia = [];
        foreach ($this->areas as $area) {
            $medias = $area->getMedia('area');
            foreach ($medias as $media) {
                $areaMedia[] = [
                    'thumb' => $media->getUrl('thumb'),
                    '300' => $media->getUrl('300'),
                    'normal' => $media->getUrl(),
                ];
            }
        }
        foreach ($this->shared_areas as $area) {
            $medias = $area->getMedia('area');
            foreach ($medias as $media) {
                $commonMedia[] = [
                    'thumb' => $media->getUrl('thumb'),
                    '300' => $media->getUrl('300'),
                    '1200' => $media->getUrl('1200'),
                    'normal' => $media->getUrl(),
                ];
            }
        }

        $this->areaMedia = $areaMedia;
        $this->commonMedia = $commonMedia;
        $this->generalMedia = $this->getImage($this->independentProperty->getMedia('independent-general'));
        $this->kitchenMedia = $this->getImage($this->independentProperty->getMedia('independent-kitchen'));
        $this->sanitaryMedia = $this->getImage($this->independentProperty->getMedia('independent-sanitary'));
        $this->carportMedia = $this->getImage($this->independentProperty->getMedia('independent-carport'));
        $this->extrasMedia = $this->getImage($this->independentProperty->getMedia('independent-extras'));
        $this->disabledMedia = $this->getImage($this->independentProperty->getMedia('independent-disabled-facilities'));
        $this->heatedMedia = $this->getImage($this->independentProperty->getMedia('independent-heated-spaces'));
        $company_media = $this->company->getMedia('company-logo');
        $this->company_logo = count($company_media) > 0 ? $company_media[0]->getUrl('400') : null;
    }

    public function getDependentVTwoMedia()
    {
        $areaMedia = [];
        $commonMedia = [];
        foreach ($this->areas as $area) {
            $medias = $area->getMedia('area');
            foreach ($medias as $media) {
                $areaMedia[] = [
                    'thumb' => $media->getUrl('thumb'),
                    '300' => $media->getUrl('300'),
                    'normal' => $media->getUrl(),
                ];
            }
        }
        foreach ($this->shared_areas as $area) {
            $medias = $area->getMedia('area');
            foreach ($medias as $media) {
                $commonMedia[] = [
                    'thumb' => $media->getUrl('thumb'),
                    '300' => $media->getUrl('300'),
                    '1200' => $media->getUrl('1200'),
                    'normal' => $media->getUrl(),
                ];
            }
        }

        $this->areaMedia = $areaMedia;
        $this->commonMedia = $commonMedia;
        $this->generalMedia = $this->getImage($this->dependentPropertyVTwo->getMedia('dependent-v2-general'));
        $this->kitchenMedia = $this->getImage($this->dependentPropertyVTwo->getMedia('dependent-v2-kitchen'));
        $this->sanitaryMedia = $this->getImage($this->dependentPropertyVTwo->getMedia('dependent-v2-sanitary'));
        $this->carportMedia = $this->getImage($this->dependentPropertyVTwo->getMedia('dependent-v2-carport'));
        $this->extrasMedia = $this->getImage($this->dependentPropertyVTwo->getMedia('dependent-v2-extras'));
        $this->disabledMedia = $this->getImage($this->dependentPropertyVTwo->getMedia('dependent-v2-disabled-facilities'));
        $this->heatedMedia = $this->getImage($this->dependentPropertyVTwo->getMedia('dependent-v2-heated-spaces'));
        $company_media = $this->company->getMedia('company-logo');
        $this->company_logo = count($company_media) > 0 ? $company_media[0]->getUrl('400') : null;
    }

    public function getDependentMedia()
    {
        $areaMedia = [];
        foreach ($this->areas as $area) {
            $medias = $area->getMedia('area');
            foreach ($medias as $media) {
                $areaMedia[] = [
                    'thumb' => $media->getUrl('thumb'),
                    '300' => $media->getUrl('300'),
                    'normal' => $media->getUrl(),
                ];
            }
        }
        $this->areaMedia = $areaMedia;
        $this->kitchenMedia = $this->getImage($this->dependentProperty->getMedia('dependent-kitchen'));
        $this->sanitaryMedia = $this->getImage($this->dependentProperty->getMedia('dependent-sanitary'));
        $this->heatingMedia = $this->getImage($this->dependentProperty->getMedia('dependent-heating'));
        $this->outsideMedia = $this->getImage($this->dependentProperty->getMedia('dependent-outside'));
        $this->bikeRackMedia = $this->getImage($this->dependentProperty->getMedia('dependent-bike-rack'));
        $this->minusMedia = $this->getImage($this->dependentProperty->getMedia('dependent-minus'));
        $company_media = $this->company->getMedia('company-logo');
        $this->company_logo = count($company_media) > 0 ? $company_media[0]->getUrl('400') : null;
    }

    public function getImage($values)
    {
        $imageArray = [];
        foreach ($values as $value) {
            $imageArray[] = [
                'thumb' => $value->getUrl('thumb'),
                '300' => $value->getUrl('300'),
                'normal' => $value->getUrl(),
            ];
        }

        return $imageArray;
    }
}
