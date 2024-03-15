<?php

use App\Http\Controllers\WarehouseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/cars', [\App\Http\Controllers\CarController::class, 'getAll']);
Route::get('/cars/{id}', [\App\Http\Controllers\CarController::class, 'getSingle']);
