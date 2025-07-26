<?php

use App\Http\Controllers\Api\AuthApiController;
use App\Http\Controllers\Api\MessageApiController;
use App\Http\Controllers\Api\RatingApiController;
use App\Http\Controllers\Api\TrackingApiController;
use App\Http\Controllers\Api\TripApiController;
use App\Http\Controllers\Api\BookingApiController;
use App\Http\Controllers\Api\OrderApiController;
use App\Http\Controllers\Api\UserApiController;
use App\Http\Controllers\Api\WithdrawApiController;
use Illuminate\Support\Facades\Route;

Route::post('/register', [AuthApiController::class, 'register']);
Route::post('/login', [AuthApiController::class, 'login']);
Route::get('/country_state_city', [TripApiController::class, 'locations']);
Route::get('/locations', [TripApiController::class, 'allLocations']);
Route::get('/search', [TripApiController::class, 'search']);
Route::get('/filter', [TripApiController::class, 'filter']);
Route::get('/trip/{trip}/details', [TripApiController::class, 'details'])->name('trip.details');
Route::get('/tracking', [TrackingApiController::class, 'search'])->name('tracking.search');
Route::post('/otp', [AuthApiController::class, 'otp'])->name('otp');
Route::post('/otp/verify', [AuthApiController::class, 'otpVerify']);
Route::post('/forget', [AuthApiController::class, 'forgetPassword'])->name('forget.password');
Route::post('/password/reset', [AuthApiController::class, 'resetPassword'])->name('reset.password');

Route::middleware(['auth:sanctum', 'api_json_respond'])->group(function () {
    Route::get('/dashboard', [AuthApiController::class, 'dashboard'])->name('dashboard');

    Route::get('/profile', [AuthApiController::class, 'profile']);
    Route::post('/profile', [AuthApiController::class, 'updateProfile'])->name('profile.update');
    Route::get('/verification', [AuthApiController::class, 'verification'])->name('verification');
    Route::post('/verification', [AuthApiController::class, 'verificationUpdate'])->name('verification.update');
    Route::post('/logout', [AuthApiController::class, 'logout']);

    Route::apiResource('trips', TripApiController::class);
    Route::get('trip/create', [TripApiController::class, 'create'])->name('trips.create');

    Route::apiResource('bookings', BookingApiController::class);
    Route::get('trip/{trip}/booking', [BookingApiController::class, 'create'])->name('booking');

    Route::apiResource('orders', OrderApiController::class);
    Route::get('/order/{booking}/pickup', [BookingApiController::class, 'pickup'])->name('order.pickup');
    Route::post('/order/{booking}/pickup-otp', [BookingApiController::class, 'pickupVerify'])->name('order.pickup-otp');
    Route::post('/order/{booking}/delivery-otp', [BookingApiController::class, 'deliveryVerify'])->name('order.delivery-otp');
    Route::post('/order/{booking}/resend-otp', [BookingApiController::class, 'otpResend'])->name('order.resend-otp');
//    Route::resource('user', UserApiController::class);

    Route::get('/message', [MessageApiController::class, 'index'])->name('message');
    Route::get('/message/{receiverId?}', [MessageApiController::class, 'loadMessages'])->name('message.load');

    Route::get('/rating/{booking}', [RatingApiController::class, 'create'])->name('rating.create');
    Route::post('/rating', [RatingApiController::class, 'store'])->name('rating.store');

    Route::get('/withdraw', [WithdrawApiController::class, 'index'])->name('withdraw');
    Route::get('/withdraw/{payment}/request', [WithdrawApiController::class, 'withdraw'])->name('withdraw.request');
    Route::post('/withdraw/{payment}/submit', [WithdrawApiController::class, 'withdrawStore'])->name('withdraw.store');

});
