<?php

use App\Http\Controllers\User\AuthController;
use App\Http\Requests\SuggestionRequest;
use App\Http\Resources\InstructionResource;
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

Route::group(['prefix' => 'user'], function () {
    Route::controller(AuthController::class)->group(function () {
        Route::post("login", "login")->name("user.login")->middleware('guest');
        Route::post('register', "register")->name("user.register")->middleware('guest');
        Route::post("logout", "logout")->name("user.logout")->middleware(['auth:sanctum', 'role:user']);
        Route::post("suggestion", function (SuggestionRequest $request) {
            try {
                $suggestDetails = $request->validated();
                Suggestion::create(["body" => $suggestDetails['body'], "user_id" => auth('sanctum')->id()]);

                return response()->json(['success' => true, 'message' => "suggestion has been saved successfully", 'data' => []]);
            } catch (\Exception $e) {
                Log::error("error while storing an instruction", ['error_msg' => $e->getMessage() . "in line: " . $e->getLine(), "trace" => $e->getTraceAsString()]);

                return response()->json(['success' => false, 'message' => "Some error occurred while storing an instruction", 'data' => []]);
            }
        })->middleware(['auth:sanctum', 'role:user']);
    });
});
