<?php

namespace App\Http\Controllers\web;

use App\Http\Controllers\Controller;
use App\Http\Requests\web\StoreContactRequest;
use App\Http\Requests\web\UpdateContactRequest;
use App\Models\web\Contact;
use Inertia\Inertia;
use Inertia\Response;

class ContactController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('nav/Contact/Contact');
    }

    public function create(): Response
    {
        return Inertia::render('nav/Contact/Create');
    }

    public function store(StoreContactRequest $request)
    {
        Contact::create($request->validated());
        return redirect()->route('dynamic.page', 'contact')->with('success', 'Contact created successfully.');
    }

    public function show($id): Response
    {
        $contact = Contact::findOrFail($id);
        return Inertia::render('nav/Contact/Show', ['contact' => $contact]);
    }

    public function edit($id): Response
    {
        $contact = Contact::findOrFail($id);
        return Inertia::render('nav/Contact/Edit', ['contact' => $contact]);
    }

    public function update(UpdateContactRequest $request, $id)
    {
        $contact = Contact::findOrFail($id);
        $contact->update($request->validated());
        return redirect()->route('dynamic.page', 'contact')->with('success', 'Contact updated successfully.');
    }

    public function destroy($id)
    {
        $contact = Contact::findOrFail($id);
        $contact->delete();
        return redirect()->route('dynamic.page', 'contact')->with('success', 'Contact deleted successfully.');
    }
}
