<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\customizationRequest;
use App\Services\V1\CustomizationService;
use App\Trait\ApiResponseTrait;
use Illuminate\Http\Request;

class CustomizationController extends Controller
{
    use ApiResponseTrait;

    protected $customizationService;

    public function __construct(CustomizationService $customizationService)
    {
        $this->customizationService = $customizationService;
    }


    /**
     * Get all customizations.
     *
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $customizations = $this->customizationService->getAllCustomizations();

        return $this->successResponse($customizations, 'Customizations retrieved successfully', 200);
    }


    /**
     * Get customization by id.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(int $id)
    {
        $customization = $this->customizationService->getCustomizationById($id);

        return $this->successResponse($customization, 'Customization retrieved successfully', 200);
    }


    /**
     * Get customization by search keyword.
     *
     * @param request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function search(request $request)
    {
        $customizations = $this->customizationService->searchCustomizations($request->input('keyword'));

        return $this->successResponse($customizations, 'Customizations retrieved successfully', 200);
    }


    /**
     * Create new customization.
     *
     * @param array $data
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(CustomizationRequest $request)
    {
        $customization = $this->customizationService->createCustomization($request->validated());

        return $this->successResponse($customization, 'Customization created successfully', 200);
    }


    /**
     * Update customization.
     *
     * @param int $id
     * @param array $data
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(CustomizationRequest $request, int $id)
    {
        $customization = $this->customizationService->updateCustomization($id, $request->validated());

        return $this->successResponse($customization, 'Customization updated successfully', 200);
    }


    /**
     * Delete customization.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(int $id)
    {
        $this->customizationService->deleteCustomization($id);

        return $this->successMessage('Customization deleted successfully', 200);
    }

}
