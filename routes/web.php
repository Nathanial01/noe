<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ChatbotController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\web\PageController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return Inertia::render('welcome', [
        'canLogin'       => Route::has('login'),
        'canLogout'      => Route::has('logout'),
        'canRegister'    => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion'     => PHP_VERSION,
    ]);
});

// Instead of rendering an Inertia 'Dashboard' page, we redirect to Nova:
Route::get('/dashboard', function () {
    $user = Auth::user();

    // If the user is admin, go to "main" dashboard
    if ($user->is_admin) {
        return redirect('/nova/dashboards/main');
    }

    // Otherwise, go to "clients" dashboard
    return redirect('/nova/dashboards/clients');
})->middleware(['auth', 'verified'])->name('dashboard');

// Authenticated User Routes
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Admin Routes (ensure 'admin' middleware is registered in Kernel)
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin', [AdminController::class, 'index'])->name('admin.index');
});

// Public Pages
Route::get('{page}', [PageController::class, 'renderPage'])
    ->where('page', 'about|contact|real-estate|private-equity|agendaEvent|masterclass|webinar')
    ->name('dynamic.page');

Route::prefix('{page}')
    ->whereIn('page', ['contact', 'real-estate', 'private-equity'])
    ->group(function () {
        Route::post('store', [PageController::class, 'store'])->name('page.store');
        Route::get('{id}', [PageController::class, 'show'])->name('page.show');
        Route::get('{id}/edit', [PageController::class, 'edit'])->name('page.edit');
        Route::put('{id}', [PageController::class, 'update'])->name('page.update');
        Route::delete('{id}', [PageController::class, 'destroy'])->name('page.destroy');
    });

// Chatbot & Cookie Consent
Route::view('/cookie-consent-html', 'vendor.cookie-consent.dialogContents');
Route::post('/chat', [ChatbotController::class, 'handleChat'])->name('api.chat');

// Authentication Routes
require __DIR__ . '/auth.php';
