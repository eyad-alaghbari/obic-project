<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Http\Resources\CategoryResource;
use App\Services\V1\CategoryService;
use App\Trait\ApiResponseTrait;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    use ApiResponseTrait;

    /**
     * The category service.
     *
     * @var \App\Services\V1\CategoryService
     */
    protected CategoryService $categoryService;

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

        return $this->successResponse(CategoryResource::collection($categories), 'Categories retrieved successfully', 200);
    }


    /**
     * Get all parent categories.
     *
     * @param int $per_page
     * @return \Illuminate\Http\JsonResponse
     */
    public function getParentCategories(request $request)
    {
        $categories = $this->categoryService->getAllParentCategories($request->per_page);

        return $this->successResponse(CategoryResource::collection($categories), 'Categories retrieved successfully', 200);
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

        return $this->successResponse(CategoryResource::collection($categories), 'Categories retrieved successfully', 200);
    }

    public function search(request $request)
    {
        $categories = $this->categoryService->searchCategory($request->input('keyword'), $request->per_page);

        return $this->successResponse(CategoryResource::collection($categories), 'Categories retrieved successfully', 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(CategoryRequest $request)
    {
        $category = $this->categoryService->createCategory($request->validate());

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
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(CategoryRequest $request, int $id)
    {
        $category = $this->categoryService->updateCategory($id, $request->validate());

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
}
