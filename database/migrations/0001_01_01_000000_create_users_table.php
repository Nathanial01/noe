<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class RegisteredUserController extends Controller
{
    /**
     * Show the registration form.
     */
    public function create()
    {
        return Inertia::render('Auth/Register', [
            'genders' => ['Male', 'Female', 'Other'], // Example gender options
        ]);
    }

    /**
     * Handle the registration form submission.
     */
    public function store(Request $request)
    {
        // Validate the incoming request
        $request->validate([
            // Personal Information
            'first_name'               => 'required|string|max:255',
            'last_name'                => 'required|string|max:255',
            'date_of_birth'            => 'nullable|date',
            'nationality'              => 'nullable|string|max:255',
            'country_of_residence'     => 'nullable|string|max:255',
            'gender'                   => 'nullable|string|max:50',
            'marital_status'           => 'nullable|string|max:255',

            // Contact Details
            'email'                    => 'required|email|max:255|unique:users',
            'phone'                    => 'nullable|string|max:50',
            'residential_address'      => 'nullable|string',

            // Government & Legal Identification (KYC)
            'government_id'            => 'nullable|string|max:255',
            'tax_id'                   => 'nullable|string|max:255',
            'social_security_number'   => 'nullable|string|max:255',
            'proof_of_address'         => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',

            // Financial Information & Investment Profile
            'employment_status'        => 'nullable|string|max:255',
            'source_of_income'         => 'nullable|string|max:255',
            'annual_income_range'      => 'nullable|string|max:255',
            'net_worth'                => 'nullable|numeric',
            'investment_experience'    => 'nullable|string|max:255',
            'risk_tolerance'           => 'nullable|string|max:255',
            'investment_objectives'    => 'nullable|string',

            // Regulatory Agreements & Declarations
            'terms_agreed'             => 'accepted',
            'privacy_policy_consented' => 'accepted',
            'risk_disclosure_agreed'   => 'accepted',
            'tax_form'                 => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',

            // Authentication
            'password'                 => 'required|string|confirmed|min:8',
        ]);

        // Handle file uploads
        $proofOfAddressPath = $request->hasFile('proof_of_address')
            ? $request->file('proof_of_address')->store('proof_of_address', 'public')
            : null;

        $taxFormPath = $request->hasFile('tax_form')
            ? $request->file('tax_form')->store('tax_forms', 'public')
            : null;

        // By default, all new registrations are non-admin (is_admin = false)
        $isAdmin = false;

        // Create the user record
        $user = User::create([
            'first_name'               => $request->first_name,
            'last_name'                => $request->last_name,
            'date_of_birth'            => $request->date_of_birth,
            'nationality'              => $request->nationality,
            'country_of_residence'     => $request->country_of_residence,
            'gender'                   => $request->gender,
            'marital_status'           => $request->marital_status,
            'email'                    => $request->email,
            'phone'                    => $request->phone,
            'residential_address'      => $request->residential_address,
            'government_id'            => $request->government_id,
            'tax_id'                   => $request->tax_id,
            'social_security_number'   => $request->social_security_number,
            'proof_of_address'         => $proofOfAddressPath,
            'employment_status'        => $request->employment_status,
            'source_of_income'         => $request->source_of_income,
            'annual_income_range'      => $request->annual_income_range,
            'net_worth'                => $request->net_worth,
            'investment_experience'    => $request->investment_experience,
            'risk_tolerance'           => $request->risk_tolerance,
            'investment_objectives'    => $request->investment_objectives,

            'terms_agreed'             => true,
            'privacy_policy_consented' => true,
            'risk_disclosure_agreed'   => true,
            'tax_form'                 => $taxFormPath,

            'password'                 => Hash::make($request->password),
            'is_admin'                 => $isAdmin,
        ]);

        // Fire the Registered event and log in the new user
        event(new Registered($user));
        Auth::login($user);

        // Log debug info
        \Log::info('User registered', [
            'id'         => $user->id,
            'is_admin'   => $user->is_admin,
            'redirect_to'=> $user->is_admin
                ? '/nova/dashboards/main'
                : '/nova/dashboards/clients',
        ]);

        // Redirect based on user role
        return redirect(
            $user->is_admin
                ? '/nova/dashboards/main'
                : '/nova/dashboards/clients'
        );
    }
}
