<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;
// use App\Http\Controllers\Auth\VerifyEmailController; // optional later

// Authenticated user info (Sanctum-protected)
Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});

// --- Core auth endpoints (per spec) ---

// Register (guest only)
Route::post('/register', [RegisteredUserController::class, 'store'])
    ->middleware(['guest']);

// Login (guest only) + throttle
Route::post('/login', [AuthenticatedSessionController::class, 'store'])
    ->middleware(['guest', 'throttle:login']);

// Logout (must be authenticated)
Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
    ->middleware(['auth:sanctum']);

// --- Helpful extras (optional spec items) ---

// Password reset (request link)
Route::post('/forgot-password', [PasswordResetLinkController::class, 'store'])
    ->middleware(['guest']);

// Password reset (perform reset)
Route::post('/reset-password', [NewPasswordController::class, 'store'])
    ->middleware(['guest']);

// Email verification re-send (optional)
Route::post('/email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
    ->middleware(['auth:sanctum']);
