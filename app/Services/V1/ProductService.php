<?php

namespace App\Services\V1;

use App\Events\V1\ProductCreated;
use App\Events\V1\ProductDeleted;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use App\Trait\ApiResponseTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Resources\ProductResource;
use Illuminate\Support\Facades\Storage;
use App\Repositories\Interfaces\ProductRepositoryInterface;

class ProductService
{
    use ApiResponseTrait;

    protected ProductRepositoryInterface $productRepository;

    public function __construct(ProductRepositoryInterface $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    /**
     * Retrieve all products with optional filters.
     *
     * @param Request $request
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getAllProducts(array $filters)
    {

        return $this->productRepository->getAllProducts($filters);
    }

    /**
     * Retrieve a single product by ID.
     *
     * @param int $id
     *
     */
    public function getProductById(int $id, array $relations = [])
    {
        return $this->productRepository->getProductById($id, $relations);
    }

    /**
     * Create a new product with multiple images.
     *
     * @param array $data
     * @param array $images
     * @return JsonResponse
     */
    public function createProduct(array $data, array $images = []): JsonResponse
    {
        DB::beginTransaction();
        try {

            $product = $this->productRepository->createProduct($data);

            $this->syncProductRelations($product, $data);

            // save product images
            if (!empty($images)) {
                foreach ($images as $image) {
                    $this->saveProductImage($product, $image);
                }
            }

            event(new ProductCreated($product));

            DB::commit();
            $product = $product->load(['category', 'customizationOptions', 'reviews', 'vendor', 'images']);
            return $this->successResponse(ProductResource::make($product), 201);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e->getMessage());
            return $this->errorResponse($e->getMessage() . " error in creating product", 500);
        }
    }

    /**
     * Update an existing product with optional new images.
     *
     * @param int $id
     * @param array $data
     * @param array $images
     * @return JsonResponse
     */
    public function updateProduct(int $id, array $data, array $images = []): JsonResponse
    {
        DB::beginTransaction();
        try {
            $product = $this->productRepository->updateProduct($id, $data);

            $this->syncProductRelations($product, $data);

            DB::commit();
            $product = $product->load(['category', 'customizationOptions', 'reviews', 'vendor']);
            return $this->successResponse(ProductResource::make($product), 200);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e->getMessage());
            return $this->errorResponse($e->getMessage() . " error updating product", 500);
        }
    }

    /**
     * Delete a product by ID.
     *
     * @param int $id
     * @return void
     */
    public function deleteProduct(int $id): void
    {
        $this->productRepository->deleteProduct($id);
        event(new ProductDeleted($id));
    }




    /**
     * Delete an image from a product.
     *
     * @param int $imageId
     * @return JsonResponse
     */
    public function deleteImage(int $imageId): JsonResponse
    {
        $image = ProductImage::findOrFail($imageId);

        // Delete the file from storage
        Storage::disk('public')->delete($image->image_path);

        // Delete the record from the database
        $image->delete();

        return $this->successMessage(200);
    }

    /**
     * Sync product categories and customization options.
     *
     * @param Product $product
     * @param array $data
     */
    protected function syncProductRelations(Product $product, array $data): void
    {
        if (isset($data['category_ids'])) {
            $product->category()->sync($data['category_ids']);
        }

        if (isset($data['customization_option_ids'])) {
            $product->customizationOptions()->sync($data['customization_option_ids']);
        }
    }


    /**
     * Save a single product image.
     *
     * @param Product $product
     * @param \Illuminate\Http\UploadedFile $image
     * @return void
     */
    protected function saveProductImage(Product $product, $image): void
    {
        // store image in `public/storage`
        $path = $image->store('uploads/product_images', 'public');

        // create image record in product_images
        $product->images()->create(['image_path' => $path]);
    }
}
