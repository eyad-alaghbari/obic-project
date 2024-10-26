<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Services\V1\CustomizationOptionService;
use App\Http\Requests\CustomizationOptionRequest;
use App\Http\Resources\CustomizationOptionResource;
use App\Trait\ApiResponseTrait;

class CustomizationOptionController extends Controller
{
    use ApiResponseTrait;

    /**
     * The customization option service.
     */
    protected $customizationOptionService;

    public function __construct(CustomizationOptionService $service)
    {
        $this->customizationOptionService = $service;
    }

    /**
     * Display a listing of the customization options.
     */
    public function index(): JsonResponse
    {
        $options = $this->customizationOptionService->getAll();
        return $this->successResponse(CustomizationOptionResource::collection($options), 200);
    }

    /**
     * Display the specified customization option.
     */
    public function show(int $id): JsonResponse
    {
        $option = $this->customizationOptionService->getById($id);
        $option ?? abort(404, 'Customization option not found.');
        return $this->successResponse(CustomizationOptionResource::make($option), 200);
    }

    /**
     * Display the specified customization option.
     */
    public function getByCustomizationId(int $customizationId): JsonResponse
    {
        // dd($customizationId);
        $option = $this->customizationOptionService->getByCustomizationId($customizationId);
        $option ?? abort(404, 'Customization option not found.');
        return $this->successResponse(CustomizationOptionResource::collection($option), 200);
    }

    /**
     * Store a newly created customization option in storage.
     */
    public function store(CustomizationOptionRequest $request): JsonResponse
    {
        $option = $this->customizationOptionService->create($request->validated());
        return $this->successResponse(CustomizationOptionResource::make($option), 'Customization option created.', 201);
    }

    /**
     * Update the specified customization option in storage.
     */
    public function update(CustomizationOptionRequest $request, int $id): JsonResponse
    {
        $option = $this->customizationOptionService->update($id, $request->validated());
        return $this->successResponse(CustomizationOptionResource::make($option), 'Customization option updated.', 200);
    }

    /**
     * Remove the specified customization option from storage.
     */
    public function destroy(int $id): JsonResponse
    {
        $this->customizationOptionService->delete($id);
        return $this->successMessage('Customization option deleted.', 204);
    }
}
