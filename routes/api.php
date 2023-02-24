<?php

use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Support\Facades\Route;

Route::get('/checkAuthentication', function () {
    if (!auth('sanctum')->check()) {

        return response()->json(["status" => false]);
    }
    $user = User::with('roles')->find(auth('sanctum')->id());

    return response()->json(["status" => true, 'user' => new UserResource($user)]);
});
