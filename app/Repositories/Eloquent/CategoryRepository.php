<?php

namespace App\Repositories\Eloquent;

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
        // dd('sad');
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

    public function attachVendorToCategory($categoryId, $vendorId)
    {
        try {
            $category = Category::findOrFail($categoryId);
            $category->vendors()->attach($vendorId);
        } catch (\Exception $exception) {
            // TODO: Log the exception
            throw new \RuntimeException('Something went wrong while attaching a vendor to a category.');
        }
    }

    public function detachVendorFromCategory($categoryId, $vendorId)
    {
        try {
            $category = Category::findOrFail($categoryId);
            $category->vendors()->detach($vendorId);
        } catch (\Exception $exception) {
            // TODO: Log the exception
            throw new \RuntimeException('Something went wrong while detaching a vendor from a category.', 0, $exception);
        }
    }


    public function getVendorsByCategory($categoryId, $perPage = 10): LengthAwarePaginator
    {
        return Category::with('vendors')->findOrFail($categoryId)->vendors()->paginate($perPage);
    }
}
