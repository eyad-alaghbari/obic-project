<?php

namespace App\Repositories\Eloquent;

use App\Models\Category;
use Illuminate\Support\Facades\Log;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Repositories\Interfaces\CategoryRepositoryInterface;

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
        return Category::where('parent_id', $parentId)->paginate($per_page);
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

    public function attachVendorToCategory(int $categoryId, int $vendorId): bool
    {
        try {
            $category = Category::whereNull('parent_id')->findOrFail($categoryId);
            $category->vendors()->attach($vendorId);

            return true;
        } catch (\Exception $exception) {
            Log::error('Something went wrong while attaching a vendor to a category.', [
                'category_id' => $categoryId,
                'vendor_id' => $vendorId,
                'error' => $exception->getMessage(),
            ]);

            throw new \RuntimeException('Something went wrong while attaching a vendor to a category.');
            return false;
        }
    }

    public function detachVendorFromCategory($categoryId, $vendorId): bool
    {
        try {
            $category = Category::findOrFail($categoryId);
            $category->vendors()->detach($vendorId);

            return true;
        } catch (\Exception $exception) {
            Log::error('Something went wrong while detaching a vendor from a category.', [
                'category_id' => $categoryId,
                'vendor_id' => $vendorId,
                'error' => $exception->getMessage(),
            ]);
            throw new \RuntimeException('Something went wrong while detaching a vendor from a category.', 0, $exception);
            return false;
        }
    }

    public function getVendorsByCategory($categoryId, $perPage = 10): LengthAwarePaginator
    {
        return Category::with('vendors')->findOrFail($categoryId)->vendors()->paginate($perPage);
    }


    public function getByIdWithRelations(int $id, array $relations): ?Category
    {
        return Category::with($relations)->findOrFail($id);
    }

    public function syncCustomizionToCategory(int $categoryId, array $customizationIds): bool
    {
        try {
            $category = Category::query()->whereNull('parent_id')->findOrFail($categoryId);
            $category->customizations()->sync($customizationIds);

            return true;
        } catch (\Exception $exception) {
            Log::error('Something went wrong while attaching a vendor to a category.', [
                'category_id' => $categoryId,
                'customization_ids' => $customizationIds,
                'error' => $exception->getMessage(),
            ]);
            throw new \RuntimeException('Something went wrong while attaching a vendor to a category.');
            return false;
        }
    }
}
