<?php

use App\Http\Controllers\Admin\AuthController;
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




Route::group(['prefix' => 'admin'], function () {
    Route::controller(AuthController::class)->group(function () {
        Route::post("login", "login")->name("admin.login")->middleware('guest');
        Route::post("logout", "logout")->name("admin.logout")->middleware(['auth:sanctum', 'role:admin']);
    });
});
