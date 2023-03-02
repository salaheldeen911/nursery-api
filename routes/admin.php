<?php

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\GuidanceController;
use App\Http\Controllers\Admin\InstructionsController;
use App\Http\Controllers\SuggestionController;
use Illuminate\Support\Facades\Route;


Route::group(['prefix' => 'admin'], function () {
    Route::controller(AuthController::class)->group(function () {
        Route::post("login", "login")->name("admin.login")->middleware('guest');
        Route::post("logout", "logout")->name("admin.logout")->middleware(['auth:sanctum', 'role:admin']);
    });

    Route::group(['middleware' => ['auth:sanctum', 'role:admin']], function () {
        Route::apiResource('inetructions', InstructionsController::class);

        Route::get('suggestions', [SuggestionController::class, "index"]);
        Route::delete('suggestions/{suggestion}', [SuggestionController::class, "destroy"]);

        Route::apiResource('guidances', GuidanceController::class);
    });
});
