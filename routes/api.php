<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\ChatbotController;
use App\Http\Controllers\BotSettingController;
use App\Http\Controllers\web\WebSearchController;



Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->middleware('auth:sanctum');
Route::post('/register', [RegisterController::class, 'register']);

Route::post('/search', [WebSearchController::class, 'search']);

// Chatbot API routes
Route::prefix('chat')->group(function () {
    Route::post('/', [ChatbotController::class, 'processMessage']);
    Route::get('/logs', [ChatbotController::class, 'getLogs']);
});

// Admin routes for managing chatbot settings
Route::prefix('admin')->group(function () {
    Route::get('/settings', [BotSettingController::class, 'index']);
    Route::post('/settings', [BotSettingController::class, 'store']);
    Route::get('/settings/{id}', [BotSettingController::class, 'show']);
    Route::put('/settings/{id}', [BotSettingController::class, 'update']);
    Route::delete('/settings/{id}', [BotSettingController::class, 'destroy']);
});
