<?php

use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/signup', [AuthController::class, 'signup']);

Route::middleware('auth:sanctum')->group(function () {
//    Route::apiResource('products', ProductController::class);
//    Route::get('/profile', [AuthController::class, 'profile']);
//    Route::post('/logout', [AuthController::class, 'logout']);
});
