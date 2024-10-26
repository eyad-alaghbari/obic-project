<?php

namespace App\Repositories\Eloquent;

use App\Models\Product;
use App\Repositories\Interfaces\ProductRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;

class ProductRepository implements ProductRepositoryInterface
{
    /**
     * Retrieve paginated products with optional filters.
     *
     * @param array $filters
     * @return LengthAwarePaginator
     */
    public function getallproducts(array $filters): lengthawarepaginator
    {
        $per_page = $filters['per_page'] ?? 10;

        return Product::select(['id', 'name', 'description', 'price', 'stock', 'vendor_id'])
            ->with([
                'category',
                'customizationOptions',
                'reviews',
                'images',
                'vendor'
            ])
            ->filter($filters)
            ->paginate($per_page);
    }

    /**
     * Retrieve a single product by ID.
     *
     * @param int $id
     * @return Product
     */
    public function getProductById(int $id, array $relations): Product
    {
        return Product::with($relations)->findOrFail($id);
    }

    /**
     * Create a new product.
     *
     * @param array $data
     * @return Product
     * @throws \InvalidArgumentException
     */
    public function createProduct(array $data): Product
    {
        try {
            return Product::create($data);
        } catch (\Exception $e) {
            throw new \RuntimeException('Failed to create product', 0, $e);
        }
    }

    /**
     * Update an existing product.
     *
     * @param int $id
     * @param array $data
     * @return Product
     */
    public function updateProduct(int $id, array $data): Product
    {
        $product = Product::findOrFail($id);
        try {
            $product->update($data);
        } catch (\Exception $e) {
            throw new \RuntimeException('Failed to update product', 0, $e);
        }

        return $product;
    }

    /**
     * Delete a product by ID.
     *
     * @param int $id
     * @return void
     */
    public function deleteProduct(int $id): void
    {
        Product::findOrFail($id)->delete();
    }
}
