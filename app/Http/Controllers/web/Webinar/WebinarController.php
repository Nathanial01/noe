<?php

namespace App\Http\Controllers\web\Webinar;

use App\Mail\WebinarMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Inertia\Inertia;
use App\Http\Controllers\Controller;

class WebinarController extends Controller
{
    public function index()
    {
        return Inertia::render('Website/Webinar/Index', [
            'send_webinar_request' => false,
        ]);
    }

    public function sendWebinarRequest(Request $request)
    {
        $validated = $request->validate([
            'email' => ['required', 'email'],
        ], [
            'email.required' => 'Email is verplicht.',
            'email.email'    => 'Email heeft geen geldig formaat.',
        ]);

        Mail::to('info@huurprijscheck.nl')->queue(new WebinarMail($validated['email']));

        return back()->with('success', 'Webinar request verstuurd.');
    }
}
