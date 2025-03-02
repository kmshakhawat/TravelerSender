<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\FilePond;
use App\Http\Controllers\TripController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
});
Route::post('/filepond/upload', [FilePond::class, 'uploadProfilePhoto'])->name('filepond.process');
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('/profile', [AuthController::class, 'profile'])->name('profile');
    Route::post('/profile', [AuthController::class, 'updateProfile'])->name('profile.update');
    Route::get('/verification', [AuthController::class, 'verification'])->name('verification');
    Route::post('/verification', [AuthController::class, 'verificationUpdate'])->name('verification.update');
    Route::resource('trip', TripController::class);

});
