<?php

namespace App\Livewire\Website\Masterclass;


use Livewire\Component;

class Index extends Component
{
    public function render()
    {
        return view('livewire.website.masterclass.index')->layout('layouts.website');
    }
}
