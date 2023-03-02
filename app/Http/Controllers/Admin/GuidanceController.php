<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreGuidanceRequest;
use App\Http\Resources\GuidanceResource;
use App\Models\Guidance;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;

class GuidanceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        try {
            return $this->_response(self::SUCCESS, "all guidances", GuidanceResource::collection(Guidance::all()));
        } catch (\Exception $e) {
            Log::error("error while getting all guidances", ['error_msg' => $e->getMessage() . "in line: " . $e->getLine(), "trace" => $e->getTraceAsString()]);

            return $this->_response(self::FAILED, 'Some error occurred while getting all guidances');
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreGuidanceRequest $request): JsonResponse
    {
        try {
            $guidance = Guidance::create($request->validated());

            return $this->_response(self::SUCCESS, "stored", new GuidanceResource($guidance));
        } catch (\Exception $e) {
            Log::error("error while storing an guidance", ['error_msg' => $e->getMessage() . "in line: " . $e->getLine(), "trace" => $e->getTraceAsString()]);

            return $this->_response(self::FAILED, 'Some error occurred while storing an guidance');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): JsonResponse
    {
        try {
            $guidance = Guidance::find($id);
            if (!$guidance) {
                return $this->_response(self::FAILED, 'No guidance was found with id: ' . $id);
            }
            return $this->_response(self::SUCCESS, "showed", new GuidanceResource($guidance));
        } catch (\Exception $e) {
            Log::error("error while showing an guidance", ['error_msg' => $e->getMessage() . "in line: " . $e->getLine(), "trace" => $e->getTraceAsString()]);

            return $this->_response(self::FAILED, 'Some error occurred while showing an guidance');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreGuidanceRequest $request, string $id): JsonResponse
    {
        try {
            $guidance = Guidance::find($id);
            if (!$guidance) {
                return $this->_response(self::FAILED, 'No guidance was found with id: ' . $id);
            }
            $guidance->update($request->validated());

            return $this->_response(self::SUCCESS, "guidance with id: $id has been updated successfully", new GuidanceResource($guidance));
        } catch (\Exception $e) {
            Log::error("error while update an guidance", ['error_msg' => $e->getMessage() . "in line: " . $e->getLine(), "trace" => $e->getTraceAsString()]);

            return $this->_response(self::FAILED, 'Some error occurred while updating an guidance');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): JsonResponse
    {
        try {
            $guidance = Guidance::find($id);
            if (!$guidance) {
                return $this->_response(self::FAILED, 'No guidance was found with id: ' . $id);
            }
            $guidance->delete();

            return $this->_response(self::SUCCESS, "guidance with id: $id has been deleted successfully");
        } catch (\Exception $e) {
            Log::error("error while deleting an guidance", ['error_msg' => $e->getMessage() . "in line: " . $e->getLine(), "trace" => $e->getTraceAsString()]);

            return $this->_response(self::FAILED, 'Some error occurred while deleting an guidance');
        }
    }
}
