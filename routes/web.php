<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
Route::post('/signup', [AuthController::class, 'signup']);
Route::get('/signup', [AuthController::class, 'register']);
//Route::get('/login', [AuthController::class, 'login']);
//Route::post('/logout', [AuthController::class, 'logout']);


Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});
