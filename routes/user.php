<?php

use App\Http\Controllers\User\AuthController;
use App\Http\Controllers\User\GuidanceController;
use App\Http\Controllers\User\InstructionController;
use App\Http\Controllers\User\SuggestionController;
use App\Http\Controllers\User\UserController;
use Illuminate\Support\Facades\Route;


Route::group(['prefix' => 'user'], function () {
    Route::controller(AuthController::class)->group(function () {
        Route::post('login', 'login')->name('user.login')->middleware('guest');
        Route::post('register', 'register')->name('user.register')->middleware('guest');
        Route::post('logout', 'logout')->name("user.logout")->middleware(['auth:sanctum', 'role:user']);
    });
    Route::group(['middleware' => ['auth:sanctum', 'role:user']], function () {
        Route::get('suggestions', [SuggestionController::class, 'index']);
        Route::post('suggestions', [SuggestionController::class, "store"]);
        Route::put('update-profile', [UserController::class, 'update']);
        Route::get('inetructions', [InstructionController::class, 'index']);
        Route::get('guidances', [GuidanceController::class, 'index']);
    });
});
