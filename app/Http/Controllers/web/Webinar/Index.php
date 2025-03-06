<?php

namespace App\Livewire\Website\Webinar;

use App\Mail\WebinarMail;
use Illuminate\Support\Facades\Mail;
use Livewire\Component;

class Index extends Component
{
    public $send_webinar_request = false;
    public $email;

    public function sendWebinarRequest()
    {
        if($this->send_webinar_request) return;
        $validated = $this->validate([
            'email' => ['required', 'email'],
        ], [
            'email.required' => 'Email is verplicht.',
            'email.email'    => 'Email heeft geen geldig formaat.'
        ]);

        Mail::to('info@huurprijscheck.nl')->queue(new WebinarMail($validated['email']));

        $this->email = null;
        $this->send_webinar_request = true;
    }

    public function render()
    {
        return view('livewire.website.webinar.index')->layout('layouts.website');
    }
}
