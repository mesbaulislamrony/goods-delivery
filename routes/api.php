<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\BillingController;
use App\Http\Controllers\TripController;
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


Route::prefix('user')->controller(AuthController::class)->group(
    function () {
        Route::post('login', 'login');
        Route::post('register', 'register');
        Route::post('verify', 'verify');
    }
);

Route::middleware('jwt.auth')->group(
    function () {
        Route::prefix('user')->controller(AuthController::class)->group(
            function () {
                Route::get('me', 'me');
                Route::post('logout', 'logout');
                Route::post('refresh', 'refresh');
            }
        );
        Route::prefix('trips')->controller(TripController::class)->group(
            function () {
                Route::get('/', 'trips');
                Route::get('/accept/{id}', 'accept');
                Route::post('/store', 'store');
            }
        );
        Route::prefix('billing')->controller(BillingController::class)->group(
            function () {
                Route::get('/', 'index');
                Route::get('/total', 'total');
            }
        );
    }
);
