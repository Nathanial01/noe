<?php

use App\Http\Controllers\{AdminController, ChatbotController, ProfileController, web\PageController};
use App\Models\User;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\{Auth, Route};
use Inertia\Inertia;
use Laravel\Socialite\Facades\Socialite;


// Welcome to Route
Route::get('/', fn() => Inertia::render('Welcome', [
    'canLogin' => Route::has('login'),
    'canLogout' => Route::has('logout'),
    'canRegister' => Route::has('register'),
    'laravelVersion' => Application::VERSION,
    'phpVersion' => PHP_VERSION,
]));
// Dashboard Route
Route::get('/dashboard', function () {
    $user = Auth::user();
    return Inertia::render('Dashboard', [
        'user' => $user,
    ]);
})->middleware(['auth', 'verified'])->name('dashboard');

// Authenticated User Routes
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Admin Routes
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin', [AdminController::class, 'index'])->name('admin.index');
});

// Public Pages

Route::get('{page}', [PageController::class, 'renderPage'])
    ->where('page', 'about|contact|real-estate|private-equity')
    ->name('dynamic.page');

Route::prefix('{page}')
    ->whereIn('page', ['contact', 'real-estate', 'private-equity']) // Exclude static pages
    ->group(function () {
        Route::post('store', [PageController::class, 'store'])->name('page.store');
        Route::get('{id}', [PageController::class, 'show'])->name('page.show');
        Route::get('{id}/edit', [PageController::class, 'edit'])->name('page.edit');
        Route::put('{id}', [PageController::class, 'update'])->name('page.update');
        Route::delete('{id}', [PageController::class, 'destroy'])->name('page.destroy');
    });
// Chatbot and Cookie Consent
Route::view('/cookie-consent-html', 'vendor.cookie-consent.dialogContents');
Route::post('/chat', [ChatbotController::class, 'handleChat'])->name('api.chat');


// Auth Routes

// Google Authentication
Route::get('/auth/google/redirect', function () {
    return Socialite::driver('google')->redirect();
});

Route::get('/auth/google/callback', function () {
    $user = Socialite::driver('google')->user();

    // Find or create the user
    $existingUser = User::where('google_id', $user->getId())->first();

    if ($existingUser) {
        // Log in the user if they already exist
        Auth::login($existingUser);
    } else {
        // Create a new user if they don't exist
        $newUser = User::create([
            'name' => $user->getName(),
            'email' => $user->getEmail(),
            'google_id' => $user->getId(),
            'avatar' => $user->getAvatar(),
        ]);
        // Log in the newly created user
        Auth::login($newUser);
    }

    return redirect('/home'); // Redirect to a page after login
});

// Facebook Authentication
Route::get('/auth/facebook/redirect', function () {
    return Socialite::driver('facebook')->redirect();
});

Route::get('/auth/facebook/callback', function () {
    $user = Socialite::driver('facebook')->user();

    // Find or create the user
    $existingUser = User::where('facebook_id', $user->getId())->first();

    if ($existingUser) {
        // Log in the user if they already exist
        Auth::login($existingUser);
    } else {
        // Create a new user if they don't exist
        $newUser = User::create([
            'name' => $user->getName(),
            'email' => $user->getEmail(),
            'facebook_id' => $user->getId(),
            'avatar' => $user->getAvatar(),
        ]);
        // Log in the newly created user
        Auth::login($newUser);
    }

    return redirect('/home'); // Redirect to a page after login
});
require __DIR__ . '/auth.php';
