<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\VendorRequest;
use App\Http\Resources\VendorResource;
use App\Services\V1\VendorService;
use App\Trait\ApiResponseTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class VendorController extends Controller
{
    use ApiResponseTrait;
    protected $vendorService;

    public function __construct(VendorService $vendorService)
    {
        $this->vendorService = $vendorService;
    }

    /**
     * Display a listing of the resource with pagination.
     */
    public function index(request $request) : JsonResponse
    {
        $vendors = $this->vendorService->getAllVendorsWithPagination($request->per_page);
        return $this->paginatedResponse(VendorResource::collection($vendors));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(VendorRequest $request): JsonResponse
    {
        $vendor = $this->vendorService->createVendor($request->validated());

        return $this->successResponse(VendorResource::make($vendor), 'Vendor created successfully', 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): JsonResponse
    {
        $vendor = $this->vendorService->getVendorById($id);
        return $this->successResponse(VendorResource::make($vendor));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(VendorRequest $request, string $id): JsonResponse
    {
        $vendor = $this->vendorService->updateVendor($id, $request->all());
        return $this->successResponse(VendorResource::make($vendor), 'Vendor updated successfully', 201);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): JsonResponse
    {
        $this->vendorService->deleteVendor($id);
        return $this->successMessage('Vendor deleted successfully', 201);
    }
}
