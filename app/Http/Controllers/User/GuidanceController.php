<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Resources\GuidanceResource;
use App\Models\Guidance;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class GuidanceController extends Controller
{
    public function index(): JsonResponse
    {
        try {
            return $this->_response(self::SUCCESS, "all guidances", GuidanceResource::collection(Guidance::all()));
        } catch (\Exception $e) {
            Log::error("error while getting all guidances", ['error_msg' => $e->getMessage() . "in line: " . $e->getLine(), "trace" => $e->getTraceAsString()]);

            return $this->_response(self::FAILED, 'Some error occurred while getting all guidances');
        }
    }
}
