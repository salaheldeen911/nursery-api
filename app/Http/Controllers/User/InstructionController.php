<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Resources\InstructionResource;
use App\Models\Instruction;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class InstructionController extends Controller
{
    public function index(): JsonResponse
    {
        try {
            return $this->_response(self::SUCCESS, "all instructions", InstructionResource::collection(Instruction::all()));
        } catch (\Exception $e) {
            Log::error("error while getting all instructions", ['error_msg' => $e->getMessage() . "in line: " . $e->getLine(), "trace" => $e->getTraceAsString()]);

            return $this->_response(self::FAILED, 'Some error occurred while getting all instructions');
        }
    }
}
