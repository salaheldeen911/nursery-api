<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\SuggestionRequest;
use App\Http\Resources\SuggestionResource;
use App\Models\Suggestion;
use Illuminate\Support\Facades\Log;

class SuggestionController extends Controller
{
    public function index()
    {
        try {
            return $this->_response(self::SUCCESS, "all suggestions", SuggestionResource::collection(Suggestion::with("user")->get()));
        } catch (\Exception $e) {
            Log::error("error while getting all suggestions", ['error_msg' => $e->getMessage() . "in line: " . $e->getLine(), "trace" => $e->getTraceAsString()]);

            return $this->_response(self::FAILED, 'Some error occurred while getting all suggestions');
        }
    }

    public function store(SuggestionRequest $request)
    {
        try {
            $data = [...$request->validated(), ...['user_id' => auth('sanctum')->id()]];
            $instruction = Suggestion::create($data);

            return $this->_response(self::SUCCESS, "suggestion has been stored successfully", new SuggestionResource($instruction));
        } catch (\Exception $e) {
            Log::error("error while storing an suggestions", ['error_msg' => $e->getMessage() . "in line: " . $e->getLine(), "trace" => $e->getTraceAsString()]);

            return $this->_response(self::FAILED, 'Some error occurred while storing an suggestions');
        }
    }
}
