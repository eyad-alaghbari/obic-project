<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Http\Resources\CategoryResource;
use App\Services\V1\CategoryService;
use App\Trait\ApiResponseTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    use ApiResponseTrait;

    /**
     * The category service.
     *
     *
     */
    protected $categoryService;

    /**
     * Create a new controller instance.
     *
     * @param \App\Services\V1\CategoryService $categoryService
     */
    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    /**
     * Get all categories parent and child.
     *
     * @param int $per_page
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(request $request)
    {
        $categories = $this->categoryService->getAllCategories($request->per_page);

        return $this->paginatedResponse(CategoryResource::collection($categories), 'Categories retrieved successfully', 200);
    }


    /**
     * Get all parent categories.
     *
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getParentCategories(request $request)
    {
        $categories = $this->categoryService->getAllParentCategories($request->input('per_page'));

        return $this->paginatedResponse(CategoryResource::collection($categories), 'Categories retrieved successfully', 200);
    }


    /**
     * Get all child categories by parent id.
     *
     * @param int $parentId
     * @param int $per_page
     * @return \Illuminate\Http\JsonResponse
     */
    public function getChildCategories(int $parentId, request $request)
    {
        $categories = $this->categoryService->getAllChildCategories($parentId, $request->per_page);

        return $this->paginatedResponse(CategoryResource::collection($categories), 'Categories retrieved successfully', 200);
    }


    /**
     * Search categories.
     *
     * @param string $keyword
     * @param int $per_page
     * @return \Illuminate\Http\JsonResponse
     */
    public function search(request $request)
    {
        $categories = $this->categoryService->searchCategory($request->input('keyword'), $request->per_page);

        return $this->paginatedResponse(CategoryResource::collection($categories), 'Categories retrieved successfully', 200);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Http\Requests\CategoryRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(CategoryRequest $request)
    {
        $category = $this->categoryService->createCategory($request->validated());

        return $this->successResponse(CategoryResource::make($category), 'Category created successfully', 201);
    }


    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(int $id)
    {
        $category = $this->categoryService->getCategoryById($id);

        return $this->successResponse(CategoryResource::make($category), 'Category retrieved successfully', 200);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param \App\Http\Requests\CategoryRequest $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(CategoryRequest $request, int $id)
    {
        $category = $this->categoryService->updateCategory($id, $request->validated());

        return $this->successResponse(CategoryResource::make($category), 'Category updated successfully', 201);
    }



    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(int $id)
    {
        $this->categoryService->deleteCategory($id);

        return $this->successMessage('Category deleted successfully', 200);
    }


    /**
     * Attach vendor to category
     * @param int $categoryId
     * @param int $vendorId
     * @return \Illuminate\Http\JsonResponse
     */
    public function attachVendorToCategory(Request $request, $categoryId)
    {
        $this->categoryService->attachVendorToCategory($categoryId, $request->vendorId);

        return $this->successMessage('Vendor attached successfully', 201);
    }



    /**
     * Detach vendor from category
     * @param int $categoryId
     * @param int $vendorId
     * @return \Illuminate\Http\JsonResponse
     */
    public function detachVendorFromCategory(Request $request, $categoryId)
    {
        $this->categoryService->detachVendorFromCategory($categoryId, $request->vendorId);

        return $this->successMessage('Vendor detached successfully', 201);
    }


    /**
     * Get all vendors by category
     * @param int $categoryId
     * @return \Illuminate\Http\JsonResponse
     */
    public function getVendorsByCategory(request $request, int $categoryId)
    {
        $vendors = $this->categoryService->getVendorsByCategory($categoryId, $request->per_page);

        return $this->successResponse($vendors, 'Vendors retrieved successfully', 200);
    }

    public function getCustomizationsForCategory(int $id): JsonResponse
    {
        $customizations = $this->categoryService->getCustomizationsForCategory($id, ['customizations']);
        return $this->successResponse(CategoryResource::make($customizations), 'Customizations retrieved successfully', 200);
    }

}
