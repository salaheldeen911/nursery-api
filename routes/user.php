<?php

use App\Http\Controllers\User\AuthController;
use Illuminate\Http\Request;
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

Route::group(['prefix' => 'user'], function () {
    Route::controller(AuthController::class)->group(function () {
        Route::post("login", "login")->name("user.login")->middleware('guest');
        Route::post('register', "register")->name("user.register")->middleware('guest');
        Route::post("logout", "logout")->name("user.logout")->middleware(['auth:sanctum', 'role:user']);
    });
});
