<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Profile\ProfileController;

Route::group(['middleware' => 'auth:api'], function () {
    Route::apiResource('/', ProfileController::class);
    // Route::get('/profile', [ProfileController::class, 'profile']);
});
