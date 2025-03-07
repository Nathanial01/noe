<?php
//
//namespace App\Http\Controllers\Auth;
//
//use App\Http\Controllers\Controller;
//use App\Models\User;
//use Illuminate\Auth\Events\Registered;
//use Illuminate\Http\RedirectResponse;
//use Illuminate\Http\Request;
//use Illuminate\Support\Facades\Auth;
//use Illuminate\Support\Facades\Hash;
//use Illuminate\Validation\Rules;
//use Inertia\Inertia;
//use Inertia\Response;
//
//class RegisteredUserController extends Controller
//{
//    /**
//     * Display the registration view.
//     */
//    public function create(): Response
//    {
//        return Inertia::render('Auth/Register');
//    }
//
//    /**
//     * Handle an incoming registration request.
//     *
//     * @throws \Illuminate\Validation\ValidationException
//     */
//    public function store(Request $request): RedirectResponse
//    {
//        // Validate only the required fields for registration
//        $request->validate([
//            // Personal Information
//            'first_name'           => 'required|string|max:255',
//            'last_name'            => 'required|string|max:255',
//            'date_of_birth'        => 'required|date',
//            'nationality'          => 'required|string|max:255',
//            'country_of_residence' => 'required|string|max:255',
//            'gender'               => 'required|string|max:20',
//            'marital_status'       => 'nullable|string|max:50',
//            // Contact Details
//            'email'                => 'required|string|email|max:255|unique:users',
//            'phone'                => 'nullable|string|max:20',
//            'residential_address'  => 'nullable|string|max:500',
//            // Authentication
//            'password'             => ['required', 'confirmed', Rules\Password::defaults()],
//        ]);
//
//        // Create the user.
//        $user = User::create([
//            'first_name'           => $request->first_name,
//            'last_name'            => $request->last_name,
//            'date_of_birth'        => $request->date_of_birth,
//            'nationality'          => $request->nationality,
//            'country_of_residence' => $request->country_of_residence,
//            'gender'               => $request->gender,
//            'marital_status'       => $request->marital_status,
//            'email'                => $request->email,
//            'phone'                => $request->phone,
//            'residential_address'  => $request->residential_address,
//            'password'             => Hash::make($request->password),
//            'user_type'            => 'client',
//        ]);
//
//        event(new Registered($user));
//
//        // Determine the dashboard URL based on the user's is_admin flag.
//        $dashboardUrl = $user && $user->is_admin
//            ? '/nova/dashboards/main'
//            : '/nova/dashboards/clients';
//
//        return redirect()->intended($dashboardUrl);
//    }
//}


namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Inertia\Inertia;
use Inertia\Response;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): Response
    {
        return Inertia::render('Auth/Register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        // Validate the registration fields
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'date_of_birth' => 'required|date',
            'nationality' => 'required|string|max:255',
            'country_of_residence' => 'required|string|max:255',
            'gender' => 'required|string|max:20',
            'marital_status' => 'nullable|string|max:50',
            'email' => 'required|string|email|max:255|unique:users',
            'phone' => 'nullable|string|max:20',
            'residential_address' => 'nullable|string|max:500',
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        // Create a new user instance
        $user = User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'date_of_birth' => $request->date_of_birth,
            'nationality' => $request->nationality,
            'country_of_residence' => $request->country_of_residence,
            'gender' => $request->gender,
            'marital_status' => $request->marital_status,
            'email' => $request->email,
            'phone' => $request->phone,
            'residential_address' => $request->residential_address,
            'password' => Hash::make($request->password),
            'user_type' => 'client',
        ]);

        event(new Registered($user));

        // Authenticate the newly created user
        Auth::login($user);

        // Redirect based on the user's admin status
        $dashboardUrl = $user->is_admin
            ? '/nova/dashboards/main'
            : '/nova/dashboards/clients';

        return redirect()->intended($dashboardUrl);
    }
}
