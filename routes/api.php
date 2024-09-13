<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CarController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;

Route::middleware('auth')->group(function () {
    Route::apiResource('cars', CarController::class);
});

Route::middleware('auth')->group(function () {
    Route::apiResource('rentals', CarController::class);
});
// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth');


Route::post('register', [UserController::class, 'register']);
Route::post('login', [UserController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('logout', [UserController::class, 'logout']);

    Route::resource('cars', CarController::class);
});
