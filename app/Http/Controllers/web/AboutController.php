<?php

namespace App\Http\Controllers\web;

use App\Http\Controllers\Controller;
use App\Http\Requests\web\StoreAboutRequest;
use App\Http\Requests\web\UpdateAboutRequest;
use App\Models\About;
use Inertia\Inertia;
use Inertia\Response;

class AboutController extends Controller
{
    public function index(): Response
    {
        return $this->renderPage('about', 'nav/About/About');
    }

    public function create(): Response
    {
        return Inertia::render('nav/About/Create');
    }

    public function store(StoreAboutRequest $request)
    {
        About::create($request->validated());
        return redirect()->route('about')->with('success', 'About page created successfully.');
    }

    public function show(About $about): Response
    {
        return Inertia::render('nav/About/Show', ['about' => $about]);
    }

    public function edit(About $about): Response
    {
        return Inertia::render('nav/About/Edit', ['about' => $about]);
    }

    public function update(UpdateAboutRequest $request, About $about)
    {
        $about->update($request->validated());
        return redirect()->route('about')->with('success', 'About page updated successfully.');
    }

    public function destroy(About $about)
    {
        $about->delete();
        return redirect()->route('about')->with('success', 'About page deleted successfully.');
    }
}
