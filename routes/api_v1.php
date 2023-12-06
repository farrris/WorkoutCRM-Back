<?php

use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\Api\V1\TypeOfWorkoutController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::controller(AuthController::class)->group(function () {
    Route::post('login', 'login');
    Route::post('register', 'register');
    Route::post('logout', 'logout')->middleware("auth:api");
    Route::post('refresh', 'refresh')->middleware("auth:api");
    Route::post('protected', 'protected')->middleware("auth:api");
});

Route::apiResource("/type-of-workout", TypeOfWorkoutController::class)->middleware("auth:api");
