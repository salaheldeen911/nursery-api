<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    public function login(LoginRequest $request): JsonResponse
    {
        try {
            $validated = $request->validated();
            $user = User::where('email', $validated["email"])->first();
            if (!$user || !Hash::check($validated["password"], $user->password)) {

                return $this->_response(self::FAILED, 'Invalid password or email.');
            }

            if ($user->roles[0]->name !== "admin") {

                return $this->_response(self::FAILED, 'Invalid login form for this role.');
            }
            $token = $user->createToken("token")->plainTextToken;
            $user->token = $token;

            return $this->_response(self::SUCCESS, "loged in successfully", new UserResource($user));
        } catch (\Exception $e) {
            Log::error("error while user loging in", ['error_msg' => $e->getMessage() . "in line: " . $e->getLine(), "trace" => $e->getTraceAsString()]);

            return $this->_response(self::FAILED, 'Some error occurred while Loging in');
        }
    }

    public function logout(): JsonResponse
    {
        try {
            auth('sanctum')->user()->tokens()->delete();

            return $this->_response(self::SUCCESS, "loged out successfully");
        } catch (\Exception $e) {
            Log::error("error while loging out", ['error_msg' => $e->getMessage() . "in line: " . $e->getLine(), "trace" => $e->getTraceAsString()]);

            return $this->_response(self::FAILED, 'Some error occurred while Loging out');
        }
    }
}
