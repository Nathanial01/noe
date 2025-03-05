<?php

namespace App\Traits;

use Gate;

trait PropertyModificationTrait
{
    public function saveRef()
    {
        if (Gate::denies('client-permission', $this->company)) {
            abort(403);
        }

        if (auth()->user()->roleForCompany($this->company) === 'client') {
            toast()->warning('Je hebt geen toegang tot deze aanpassing')->push();

            return;
        }

        if (empty($this->reference)) {
            $this->property->update([
                'reference' => null,
            ]);
            $this->reference = '';
            $this->dispatch('refreshComponent')->self();
            toast()->success('Referentie succesvol aangepast')->push();

            return;
        }

        foreach ($this->company->properties()->get() as $property) {
            if ($this->property->id != $property->id) {
                if ($property->reference === $this->reference) {
                    $this->addError('reference', 'Er is al een woning met dit referentie');

                    return;
                }
            }
        }

        if ($this->property->reference === $this->reference) {
            toast()->warning('Referentie bestaat al')->push();

            return;
        }

        $this->property->update([
            'reference' => $this->reference,
        ]);
        $this->reference = $this->reference;
        $this->dispatch('refreshComponent')->self();

        return toast()->success('Referentie succesvol aangepast')->push();
    }

    public function saveSubRef()
    {
        if (Gate::denies('client-permission', $this->company)) {
            abort(403);
        }
        if (auth()->user()->roleForCompany($this->company) === 'client') {
            toast()->warning('Je hebt geen toegang tot deze aanpassing')->push();

            return;
        }

        if (empty($this->sub_reference)) {
            $this->property->update([
                'sub_reference' => null,
            ]);
            $this->sub_reference = $this->sub_reference;
            $this->dispatch('refreshComponent')->self();
            toast()->success('Subreferentie succesvol aangepast')->push();

            return;
        } else {
            $this->property->update([
                'sub_reference' => $this->sub_reference,
            ]);
            $this->sub_reference = $this->sub_reference;
            $this->dispatch('refreshComponent')->self();
            toast()->success('Subreferentie succesvol aangepast')->push();

            return;
        }
    }

    public function saveConstYear()
    {
        if (Gate::denies('client-permission', $this->company)) {
            abort(403);
        }
        $this->validate([
            'construction_year' => ['gt:0', 'required'],
        ], [
            'construction_year.gt' => 'Ingevuld jaar moet groter zijn dan 0',
            'construction_year.required' => 'Verplicht invulveld.',
        ]);
        $this->property->update([
            'construction_year' => $this->construction_year,
        ]);
        toast()->success('Bouwjaar succesvol aangepast')->push();
    }

    public function savePrice()
    {
        if (Gate::denies('client-permission', $this->company)) {
            abort(403);
        }
        $this->validate([
            'current_price' => 'gt:0',
        ], ['current_price.gt' => 'Ingevuld bedrag moet groter zijn dan 0']);
        if (auth()->user()->roleForCompany($this->company) === 'client') {
            toast()->warning('Je hebt geen toegang tot deze aanpassing')->push();

            return;
        }
        $this->property->update([
            'current_rental_price' => $this->current_price,
        ]);
        toast()->success('Prijs succesvol aangepast')->push();
    }
}
