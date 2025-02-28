<?php

namespace App\Http\Controllers\web;

use App\Http\Controllers\Controller;
use Inertia\Inertia;

class PageController extends Controller
{
    public function dashboard()
    {
        return Inertia::render('nav/Dashboard/Dashboard');
    }

    public function privateEquity()
    {
        return Inertia::render('nav/PrivateEquity/PrivateEquity');
    }

    public function realEstate()
    {
        return Inertia::render('nav/RealEstate/RealEstate');
    }

    public function about()
    {
        return Inertia::render('nav/About/About');
    }

    public function contact()
    {
        return Inertia::render('nav/Contact/Contact');
    }
}
