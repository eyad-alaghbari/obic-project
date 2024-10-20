<?php

namespace App\Repositories\Interfaces;

use App\Models\Category;

interface CategoryRepositoryInterface
{
    /**
     * @param int $perPage
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function getAllCategories(int $perPage): \Illuminate\Pagination\LengthAwarePaginator;

    /**
     * @param int $perPage
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function getAllParentCategories(int $perPage): \Illuminate\Pagination\LengthAwarePaginator;

    /**
     * @param int $parentId
     * @param int $perPage
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function getAllChildCategories(int $parentId, int $perPage): \Illuminate\Pagination\LengthAwarePaginator;

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
    public function searchCategory(string $keyword, int $perPage): \Illuminate\Pagination\LengthAwarePaginator;

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

}
