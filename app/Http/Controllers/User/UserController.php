<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    public function update(UpdateUserRequest $request)
    {
        try {
            $user = User::with('roles')->find(auth('sanctum')->id());
            $user->update($request->validated());

            return $this->_response(self::SUCCESS, "users data has been updated successfully", new UserResource($user));
        } catch (\Exception $e) {
            Log::error("error while storing an suggestions", ['error_msg' => $e->getMessage() . "in line: " . $e->getLine(), "trace" => $e->getTraceAsString()]);

            return $this->_response(self::FAILED, 'Some error occurred while updating the user data');
        }
    }
}
