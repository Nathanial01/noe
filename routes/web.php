<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\web\PageController;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;
use App\Mail\Noe as NoeMailable;
use App\Notifications\Noe as NoeNotification;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin'       => Route::has('login'),
        'canLogout'      => Route::has('logout'),
        'canRegister'    => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion'     => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    $user = Auth::user();
    return redirect($user->is_admin ? '/nova/dashboards/main' : '/nova/dashboards/clients');
})->middleware(['auth', 'verified'])->name('dashboard');

// Authenticated user Routes
Route::middleware('auth')->group(function () {
    Route::get('/profile', [\App\Http\Controllers\ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [\App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [\App\Http\Controllers\ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Admin Routes
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin', [\App\Http\Controllers\AdminController::class, 'index'])->name('admin.index');
});

// Dynamic Public Pages
// GET route for rendering dynamic pages (e.g. about, contact, etc.)
Route::get('{page}', [PageController::class, 'renderPage'])
    ->where('page', 'about|contact|real-estate|private-equity|agendaevent|masterclass|webinar')
    ->name('dynamic.page');

// POST route for handling store actions (currently targeting the contact page)
Route::post('{page}', [PageController::class, 'storePage'])
    ->where('page', 'contact')
    ->name('dynamic.page.store');
// Additional dynamic routes (store, show, etc.) for specific pages can be defined here
// ...
// Additional dynamic routes (store, show, etc.) for specific pages can be defined here
// ...

// Chatbot & Cookie Consent
Route::view('/cookie-consent-html', 'vendor.cookie-consent.dialogContents');

// Authentication Routes (if using Laravel Fortify or custom auth, include here)
require __DIR__ . '/auth.php';

// ==========================
// 🚀 Noe Email & Notification Routes
// ==========================

// Send an email using Mailable (Noe)
Route::get('/send-mail', function () {
    Mail::to('recipient@example.com')->send(new NoeMailable());
    return 'Mailable email sent!';
})->middleware('auth'); // Optional: Protect this route

// Send an email using Notification (Noe)
Route::get('/send-notification', function () {
    Notification::route('mail', 'recipient@example.com')->notify(new NoeNotification());
    return 'Notification email sent!';
})->middleware('auth'); // Optional: Protect this route

