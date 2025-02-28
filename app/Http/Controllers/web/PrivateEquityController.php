<?php

namespace App\Http\Controllers\web;

use App\Http\Controllers\Controller;
use App\Http\Requests\web\StoreRealEstateRequest;
use App\Http\Requests\web\UpdateRealEstateRequest;
use App\Models\web\RealEstate;
use Inertia\Inertia;
use Inertia\Response;

class PrivateEquityController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('nav/PrivateEquity/PrivateEquity');
    }

    public function create(): Response
    {
        return Inertia::render('nav/RealEstate/Create');
    }

    public function store(StoreRealEstateRequest $request)
    {
        RealEstate::create($request->validated());
        return redirect()->route('dynamic.page', 'real-estate')->with('success', 'Real estate created successfully.');
    }

    public function show($id): Response
    {
        $realEstate = RealEstate::findOrFail($id);
        return Inertia::render('nav/RealEstate/Show', ['realEstate' => $realEstate]);
    }

    public function edit($id): Response
    {
        $realEstate = RealEstate::findOrFail($id);
        return Inertia::render('nav/RealEstate/Edit', ['realEstate' => $realEstate]);
    }

    public function update(UpdateRealEstateRequest $request, $id)
    {
        $realEstate = RealEstate::findOrFail($id);
        $realEstate->update($request->validated());
        return redirect()->route('dynamic.page', 'real-estate')->with('success', 'Real estate updated successfully.');
    }

    public function destroy($id)
    {
        $realEstate = RealEstate::findOrFail($id);
        $realEstate->delete();
        return redirect()->route('dynamic.page', 'real-estate')->with('success', 'Real estate deleted successfully.');
    }
}
