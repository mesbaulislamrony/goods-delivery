<?php

use App\Http\Controllers\TripController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;

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


Route::prefix('user')->controller(AuthController::class)->group(function (){
    Route::post('login', 'login');
    Route::post('register', 'register');
    Route::middleware('auth:api')->group(function () {
        Route::get('me', 'me');
        Route::post('logout', 'logout');
        Route::post('refresh', 'refresh');
    });
});

Route::middleware('jwt.auth')->group(function () {
    Route::prefix('trips')->controller(TripController::class)->group(function (){
        Route::get('/', 'trips');
        Route::post('/store', 'store');
    });
});
