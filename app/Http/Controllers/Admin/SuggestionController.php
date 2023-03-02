<?php

namespace App\Http\Controllers\Admin;

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

    public function destroy(string $id)
    {
        try {
            $suggestion = Suggestion::find($id);
            if (!$suggestion) {
                return $this->_response(self::FAILED, "there is no suggestion with id: $id");
            }
            $suggestion->delete();
            return $this->_response(self::SUCCESS, "suggestion with id: '$id' has been deleted successfully");
        } catch (\Exception $e) {
            Log::error("error while storing an suggestions", ['error_msg' => $e->getMessage() . "in line: " . $e->getLine(), "trace" => $e->getTraceAsString()]);

            return $this->_response(self::FAILED, 'Some error occurred while deleting a suggestion');
        }
    }
}
