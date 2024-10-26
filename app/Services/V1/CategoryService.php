<?php

namespace App\Services\V1;

use App\Models\Category;
use App\Repositories\Interfaces\CategoryRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;

class CategoryService
{
    /**
     * The category repository.
     *
     * @var \App\Repositories\Interfaces\CategoryRepositoryInterface
     */
    protected CategoryRepositoryInterface $categoryRepository;

    /**
     * Create a new service instance.
     *
     * @param \App\Repositories\Interfaces\CategoryRepositoryInterface $categoryRepository
     */
    public function __construct(CategoryRepositoryInterface $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    /**
     * Get all categories.
     *
     * @param int $per_page
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function getAllCategories($per_page): LengthAwarePaginator
    {
        return $this->categoryRepository->getAllCategories($per_page);
    }


    /**
     * Get all parent categories.
     *
     *@param int $per_page
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function getAllParentCategories($per_page): LengthAwarePaginator
    {
        return $this->categoryRepository->getAllParentCategories($per_page);
    }


    /**
     * Get all child categories by parent id.
     *
     * @param int $per_page
     * @param int $parentId
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function getAllChildCategories(int $parentId, $per_page): LengthAwarePaginator
    {
        return $this->categoryRepository->getAllChildCategories($parentId, $per_page);
    }

    /**
     * Search category by name.
     *
     * @param string $keyword
     * @param int $perPage
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function searchCategory(string $keyword, $perPage): LengthAwarePaginator
    {
        $keyword = trim($keyword);

        if (empty($keyword)) {
            return $this->categoryRepository->getAllCategories($perPage);
        }

        return $this->categoryRepository->searchCategory($keyword, $perPage);
    }

    /**
     * Get category by id.
     *
     * @param int $id
     * @return \App\Models\Category|null
     */
    public function getCategoryById(int $id): ?Category
    {
        return $this->categoryRepository->getCategoryById($id);
    }

    /**
     * Create a new category.
     *
     * @param array $data
     * @return \App\Models\Category
     */
    public function createCategory(array $data): Category
    {
        // dd($data);
        return $this->categoryRepository->createCategory($data);
    }

    /**
     * Update the specified category in storage.
     *
     * @param int $id
     * @param array $data
     * @return \App\Models\Category
     */
    public function updateCategory(int $id, array $data): Category
    {
        // dd($data);
        return $this->categoryRepository->updateCategory($id, $data);
    }

    /**
     * Remove the specified category from storage.
     *
     * @param int $id
     * @return bool|null
     */
    public function deleteCategory(int $id): ?bool
    {
        return $this->categoryRepository->deleteCategory($id);
    }


    /**
     * Attach vendor to category
     * @param int $categoryId
     * @param int $vendorId
     * @return bool
     */
    public function attachVendorToCategory(int $categoryId, int $vendorId): bool
    {
        return $this->categoryRepository->attachVendorToCategory($categoryId, $vendorId);
    }


    /**
     * Detach vendor from category
     * @param int $categoryId
     * @param int $vendorId
     * @return bool
     */
    public function detachVendorFromCategory(int $categoryId, int $vendorId): bool
    {

        return $this->categoryRepository->detachVendorFromCategory($categoryId, $vendorId);
    }


    /**
     * @param int $categoryId
     * @param int $perPage
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function getVendorsByCategory(int $categoryId, int $perPage): LengthAwarePaginator
    {
        return $this->categoryRepository->getVendorsByCategory($categoryId, $perPage);
    }

    /**
     * @param int $categoryId
     * @param array $relations
     * @return Category | null
     */
    public function getByIdWithRelations(int $categoryId, array $relations): ?Category
    {
        return $this->categoryRepository->getByIdWithRelations($categoryId, $relations);
    }

    /**
     * @param int $categoryId
     * @param array $customizationIds
     * @return bool
     */
    public function syncCustomizionToCategory(int $categoryId, array $customizationIds): bool
    {
        return $this->categoryRepository->syncCustomizionToCategory($categoryId, $customizationIds);
    }


    /**
     * @param int $categoryId
     * @param int $perPage
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    // public function getProductsByCategory(int $categoryId, int $perPage): LengthAwarePaginator
    // {
    //     return $this->categoryRepository->getProductsByCategory($categoryId, $perPage);
    // }


}
