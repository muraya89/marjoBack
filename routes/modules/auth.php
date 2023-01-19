<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\auth\AuthController;

Route::group([],function (){
    Route::apiResource('', AuthController::class);
    Route::post('verify/{code}', [AuthController::class, 'verifyAccount']);
    Route::middleware('auth:api')->post('logout', [AuthController::class,'logout']);
});
