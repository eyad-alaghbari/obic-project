<?php

namespace App\Repositories\Interfaces;

use App\Models\Category;
use Illuminate\Pagination\LengthAwarePaginator;

interface CategoryRepositoryInterface
{
    /**
     * @param int $perPage
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function getAllCategories(int $perPage): LengthAwarePaginator;

    /**
     * @param int $perPage
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function getAllParentCategories(int $perPage): LengthAwarePaginator;

    /**
     * @param int $parentId
     * @param int $perPage
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function getAllChildCategories(int $parentId, int $perPage): LengthAwarePaginator;

    /**
     * @param int $id
     * @return Category|null
     */
    public function getCategoryById(int $id): ?Category;

    /**
     * @param string $keyword
     * @param int $perPage
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function searchCategory(string $keyword, int $perPage): LengthAwarePaginator;

    /**
     * @param array $data
     * @return Category
     */
    public function createCategory(array $data): Category;

    /**
     * @param int $id
     * @param array $data
     * @return Category
     */
    public function updateCategory(int $id, array $data): Category;

    /**
     * @param int $id
     * @return bool|null
     */
    public function deleteCategory(int $id): ?bool;

    /**
     * Attach vendor to category
     * @param int $categoryId
     * @param int $vendorId
     * @return bool
     */
    public function attachVendorToCategory(int $categoryId, int $vendorId);

    /**
     * Detach vendor from category
     * @param int $categoryId
     * @param int $vendorId
     * @return bool
     */
    public function detachVendorFromCategory(int $categoryId, int $vendorId);

    /**
     * @param int $vendorId
     * @param int $perPage
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function getVendorsByCategory(int $categoryId, int $perPage): LengthAwarePaginator;

/**
 * @param int $categoryId
 * @param array $relations
 * @return Category | null
 *
 */
    public function getByIdWithRelations(int $id, array $relations): ?Category;

}
