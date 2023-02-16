<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    const SUCCESS = true;
    const FAILED = false;

    public function _response(null|bool $success = true, string $message = "", $data = [])
    {
        if ($success) {
            return response()->json([
                'success' => $success,
                'message' => $message,
                'data' => $data
            ]);
        }

        return response()->json([
            'success' => $success,
            'message' => $message,
            'errors' => $data
        ]);
    }
}
