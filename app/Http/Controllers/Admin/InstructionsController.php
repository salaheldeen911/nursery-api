<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\InstructionRequest;
use App\Http\Resources\InstructionResource;
use App\Models\Instruction;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;

class InstructionsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        try {
            return $this->_response(self::SUCCESS, "all instructions", InstructionResource::collection(Instruction::all()));
        } catch (\Exception $e) {
            Log::error("error while getting all instructions", ['error_msg' => $e->getMessage() . "in line: " . $e->getLine(), "trace" => $e->getTraceAsString()]);

            return $this->_response(self::FAILED, 'Some error occurred while getting all instructions');
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(InstructionRequest $request): JsonResponse
    {
        try {
            $instruction = Instruction::create($request->validated());

            return $this->_response(self::SUCCESS, "stored", new InstructionResource($instruction));
        } catch (\Exception $e) {
            Log::error("error while storing an instruction", ['error_msg' => $e->getMessage() . "in line: " . $e->getLine(), "trace" => $e->getTraceAsString()]);

            return $this->_response(self::FAILED, 'Some error occurred while storing an instruction');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): JsonResponse
    {
        try {
            $instruction = Instruction::find($id);
            if (!$instruction) {
                return $this->_response(self::FAILED, 'No instruction was found with id: ' . $id);
            }
            return $this->_response(self::SUCCESS, "showed", new InstructionResource($instruction));
        } catch (\Exception $e) {
            Log::error("error while showing an instruction", ['error_msg' => $e->getMessage() . "in line: " . $e->getLine(), "trace" => $e->getTraceAsString()]);

            return $this->_response(self::FAILED, 'Some error occurred while showing an instruction');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(InstructionRequest $request, string $id): JsonResponse
    {
        try {
            $instruction = Instruction::find($id);
            if (!$instruction) {
                return $this->_response(self::FAILED, 'No instruction was found with id: ' . $id);
            }
            $instruction->update($request->validated());

            return $this->_response(self::SUCCESS, "instruction with id: $id has been updated successfully", new InstructionResource($instruction));
        } catch (\Exception $e) {
            Log::error("error while updating an instruction", ['error_msg' => $e->getMessage() . "in line: " . $e->getLine(), "trace" => $e->getTraceAsString()]);

            return $this->_response(self::FAILED, 'Some error occurred while updating an instruction');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): JsonResponse
    {
        try {
            $instruction = Instruction::find($id);
            if (!$instruction) {
                return $this->_response(self::FAILED, 'No instruction was found with id: ' . $id);
            }
            $instruction->delete();

            return $this->_response(self::SUCCESS, "instruction with id: $id has been deleted successfully");
        } catch (\Exception $e) {
            Log::error("error while deleting an instruction", ['error_msg' => $e->getMessage() . "in line: " . $e->getLine(), "trace" => $e->getTraceAsString()]);

            return $this->_response(self::FAILED, 'Some error occurred while deleting an instruction');
        }
    }
}
