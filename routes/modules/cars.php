<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Cars\CarController;

Route::group(['middleware' => 'auth:api'], function () {
    Route::apiResource('/', CarController::class);
    Route::get('/{id}', [CarController::class, 'show']);
    Route::post('/{id}', [CarController::class, 'update']);
});
