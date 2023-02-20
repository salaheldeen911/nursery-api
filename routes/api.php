<?php

use App\Http\Resources\UserResource;
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

// Route::group(['prefix' => 'v1'], function () {
//     Route::post('/check', [AuthController::class, "check"]);
// });

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/checkAuthentication', function () {
    if (auth('sanctum')->check()) {

        return response()->json(["status" => true, 'user' => new UserResource(auth('sanctum')->user())]);
    }

    return response()->json(["status" => false]);
});
