<?php

use App\Http\Controllers\CarController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/cars', [CarController::class, 'all']);
Route::get('/cars/{id}', [CarController::class, 'find']);
Route::post('/cars', [CarController::class, 'create']);
Route::put('/cars/{id}', [CarController::class, 'update']);
