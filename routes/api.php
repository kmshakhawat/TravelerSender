<?php

use App\Http\Controllers\Api\AuthApiController;
use App\Http\Controllers\Api\TripApiController;
use App\Http\Controllers\Api\BookingApiController;
use App\Http\Controllers\Api\OrderApiController;
use App\Http\Controllers\Api\UserApiController;
use Illuminate\Support\Facades\Route;

Route::post('/register', [AuthApiController::class, 'register']);
Route::post('/login', [AuthApiController::class, 'login']);

Route::middleware(['auth:sanctum', 'api_json_respond'])->group(function () {
    Route::post('/otp/resend', [AuthApiController::class, 'otpResend']);
    Route::post('/otp/verify', [AuthApiController::class, 'otpVerify']);
    Route::get('/profile', [AuthApiController::class, 'profile']);
    Route::post('/profile', [AuthApiController::class, 'updateProfile'])->name('profile.update');
    Route::get('/verification', [AuthApiController::class, 'verification'])->name('verification');
    Route::post('/verification', [AuthApiController::class, 'verificationUpdate'])->name('verification.update');
    Route::post('/logout', [AuthApiController::class, 'logout']);

    Route::apiResource('trips', TripApiController::class);
    Route::apiResource('bookings', BookingApiController::class);
    Route::apiResource('orders', OrderApiController::class);
    Route::resource('user', UserApiController::class);
});
