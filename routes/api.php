<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::group(['middleware' => ['json.response']], function () {
    Route::group(['prefix' => 'v1'], function () {
        //Auth Routes
        Route::prefix('auth')->group(base_path('routes/modules/auth.php'));

        // Profile routes
        Route::prefix('profile')->group(base_path('routes/modules/Profile.php'));

        // Car routes
        Route::prefix('cars')->group(base_path('routes/modules/cars.php'));
    });
// });
