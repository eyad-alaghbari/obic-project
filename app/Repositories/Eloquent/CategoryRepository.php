<?php

namespace App\Repositories;

use App\Models\Category;
use App\Repositories\Interfaces\CategoryRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;

class CategoryRepository implements CategoryRepositoryInterface
{
    public function getAllCategories($per_page = 10): LengthAwarePaginator
    {
        return Category::with('children')->paginate($per_page);
    }

    public function getCategoryById($id): Category
    {
        return Category::with('children')->findOrFail($id);
    }

    public function getAllParentCategories($per_page = 10): LengthAwarePaginator
    {
        return Category::whereNull('parent_id')->with('children')->paginate($per_page);
    }

    public function getAllChildCategories($parentId, $per_page = 10): LengthAwarePaginator
    {
        return Category::where('parent_id', $parentId)->with('children')->paginate($per_page);
    }

    public function searchCategory($keyword, $perPage = 10): LengthAwarePaginator
    {
        return Category::where('name', 'LIKE', "%{$keyword}%")
            ->orWhere('description', 'LIKE', "%{$keyword}%")->paginate($perPage);
    }

    public function createCategory(array $data): Category
    {
        try {
            return Category::create($data);
        } catch (\Exception $exception) {
            // TODO: Log the exception
            throw new \RuntimeException('Something went wrong while creating a category.');
        }
    }

    public function updateCategory($id, array $data): Category
    {
        $category = Category::findOrFail($id);
        $category->update($data);
        return $category;
    }

    public function deleteCategory($id): bool
    {
        $category = Category::findOrFail($id);
        return $category->delete();
    }
}
