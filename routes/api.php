<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ListController;

Route::apiResource('lists', ListController::class);

Route::patch('lists/{list}', [ListController::class, 'patch']);

// Route::post('lists', [ListController::class, 'store']);

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
