<?php

use App\Http\Controllers\Api\AuthApiController;
use App\Http\Controllers\Api\TripApiController;
use App\Http\Controllers\Api\BookingApiController;
use App\Http\Controllers\Api\OrderApiController;
use Illuminate\Support\Facades\Route;

Route::post('/register', [AuthApiController::class, 'register']);
Route::post('/login', [AuthApiController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/profile', [AuthApiController::class, 'profile']);
    Route::post('/logout', [AuthApiController::class, 'logout']);

    Route::apiResource('trips', TripApiController::class);
    Route::apiResource('bookings', BookingApiController::class);
    Route::apiResource('orders', OrderApiController::class);
});
