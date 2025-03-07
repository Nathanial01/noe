<?php

namespace App\Http\Controllers\web;

use App\Http\Controllers\Controller;
use Inertia\Inertia;
use Inertia\Response;

class AboutController extends Controller
{
    public function index(): Response
    {
        // Directly render the Inertia view for the About page.
        return Inertia::render('nav/About/About');
    }

    public function create(): Response
    {
        return Inertia::render('nav/About/Create');
    }
}
