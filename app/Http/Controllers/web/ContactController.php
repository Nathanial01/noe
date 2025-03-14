<?php

namespace App\Http\Controllers\web;

use App\Http\Controllers\Controller;
use App\Http\Requests\web\StoreContactRequest;
use App\Models\Contact;
use App\Models\User;
use App\Notifications\ContactNotification;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Support\Facades\Notification;

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
        // Create the contact record using validated data.
        $contact = Contact::create($request->validated());

        // Retrieve all admin users (assuming they are marked with an is_admin flag).
        $admins = User::where('is_admin', true)->get();

        // Send the email notification.
        Notification::send($admins, new ContactNotification($contact));

        // Manually insert a notification record into your notifications table for each admin.
        foreach ($admins as $admin) {
            \DB::table('notifications')->insert([
                'uuid'       => (string)\Illuminate\Support\Str::uuid(),
                'type'       => ContactNotification::class,
                'user_id'    => $admin->id,
                'message'    => "Nieuw contactbericht van {$contact->first_name}. Bekijk het contactformulier voor details.",
                'read'       => false,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        return redirect()->route('dynamic.page', 'contact')
            ->with('success', 'Contact created successfully.');
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

    public function update(StoreContactRequest $request, $id)
    {
        $contact = Contact::findOrFail($id);
        $contact->update($request->validated());
        return redirect()->route('dynamic.page', 'contact')
            ->with('success', 'Contact updated successfully.');
    }

    public function destroy($id)
    {
        $contact = Contact::findOrFail($id);
        $contact->delete();
        return redirect()->route('dynamic.page', 'contact')
            ->with('success', 'Contact deleted successfully.');
    }
}
