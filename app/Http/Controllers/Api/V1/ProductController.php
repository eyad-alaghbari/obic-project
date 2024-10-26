<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use App\Trait\ApiResponseTrait;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProductParamsRequest;
use App\Http\Requests\ProductRequest;
use App\Http\Resources\ProductResource;
use App\Services\V1\ProductService;
use Illuminate\Http\JsonResponse;

class ProductController extends Controller
{
    use ApiResponseTrait;

    protected ProductService $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    /**
     * Display a paginated listing of the products with optional filters.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function index(ProductParamsRequest $request): JsonResponse
    {
        $products = $this->productService->getAllProducts($request->validated());
        return $this->paginatedResponse(ProductResource::collection($products), 200);
    }

    /**
     * Display the specified product by ID.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function show(ProductParamsRequest $request, int $id): JsonResponse
    {
        // dd($id);
        $product = $this->productService->getProductById($id, $request->validated('relations', []));
        return $this->successResponse(ProductResource::make($product), 200);
    }

    /**
     * Store a newly created product in storage.
     *
     * @param ProductRequest $request
     * @return JsonResponse
     */
    public function store(ProductRequest $request)
    {
        return $this->productService->createProduct($request->validated(), $request->file('images', []));
    }

    /**
     * Update the specified product in storage.
     *
     * @param ProductRequest $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(ProductRequest $request, int $id): JsonResponse
    {
        $product = $this->productService->updateProduct($id, $request->validated(), $request->file('images', []));
        return $this->successResponse(ProductResource::make($product),'Product updated successfully',200);
    }

    /**
     * Remove the specified product from storage.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        $this->productService->deleteProduct($id);
        return $this->successMessage('Product deleted successfully', 204);
    }
}
