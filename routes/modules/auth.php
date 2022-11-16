<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\auth\AuthController;

Route::group([],function (){
    Route::apiResource('', AuthController::class);
});
