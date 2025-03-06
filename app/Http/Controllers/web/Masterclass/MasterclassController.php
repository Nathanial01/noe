<?php

namespace App\\Website\Masterclass\;




class MasterclassController extends Component
{
    public function render()
    {
        return view('.website.masterclass.index')->layout('layouts.website');
    }
}
