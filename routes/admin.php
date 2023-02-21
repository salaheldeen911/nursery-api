<?php

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\InstructionsController;
use App\Http\Resources\SuggestionResource;
use App\Models\Suggestion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
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

    Route::group(['middleware' => ['auth:sanctum', 'role:admin']], function () {
        Route::apiResource('inetructions', InstructionsController::class);
        Route::get("suggestions", function () {
            try {
                return response()->json([
                    'success' => true,
                    'message' => "all suggestions",
                    'data' => SuggestionResource::collection(Suggestion::with("user")->get())
                ]);
            } catch (\Exception $e) {
                Log::error("error while getting all suggestions", ['error_msg' => $e->getMessage() . "in line: " . $e->getLine(), "trace" => $e->getTraceAsString()]);

                return response()->json([
                    'success' => false,
                    'message' => "Some error occurred while getting all suggestions",
                    'errors' => []
                ]);
            }
        });
    });
});
