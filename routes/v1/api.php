<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\VendorController;
use App\Http\Controllers\Api\V1\ProductController;
use App\Http\Controllers\Api\V1\CategoryController;
use App\Http\Controllers\Api\V1\CustomizationController;
use App\Http\Controllers\Api\V1\Auth\AdminAuthController;
use App\Http\Controllers\Api\V1\Auth\CustomerAuthController;
use App\Http\Controllers\Api\V1\CustomizationOptionController;

Route::prefix('/admin')->group(function () {
    Route::post('register', [AdminAuthController::class, 'register'])->middleware('guest');
    Route::post('login', [AdminAuthController::class, 'login']);
    Route::post('logout', [AdminAuthController::class, 'logout'])->middleware('auth:admin');
    Route::get('getUser', [AdminAuthController::class, 'getUser'])->middleware('auth:admin');
});


Route::prefix('/customer')->group(function () {
    Route::post('register', [CustomerAuthController::class, 'register'])->middleware('guest');
    Route::post('login', [CustomerAuthController::class, 'log
    in']);
    Route::post('logout', [CustomerAuthController::class, 'logout'])->middleware('auth:customer');
});

// Routes For Admin permission
Route::middleware('auth:admin')->group(function () {

    Route::prefix('vendors')->group(function () {

        Route::post('/', [VendorController::class, 'store']);

        Route::put('/{id}', [VendorController::class, 'update']);

        Route::delete('/{id}', [VendorController::class, 'destroy']);
    });

    Route::prefix('categories')->group(function () {

        Route::post('/{categoryId}/customizations', [CategoryController::class, 'syncCustomizionToCategory']);

        Route::post('/', [CategoryController::class, 'store']);

        Route::put('/{id}', [CategoryController::class, 'update']);

        Route::delete('/{id}',[CategoryController::class, 'destroy']);

        Route::post('/{categoryId}/vendors', [CategoryController::class, 'attachVendorToCategory']);

        Route::delete('/{categoryId}/vendors', [CategoryController::class, 'detachVendorFromCategory']);


    });

    // Route::apiResource('categories', CategoryController::class)->except(['index','show']);

    Route::prefix('customizations')->group(function () {

        Route::post('/', [CustomizationController::class, 'store']);

        Route::put('/{id}', [CustomizationController::class, 'update']);

        Route::delete('/{id}', [CustomizationController::class, 'destroy']);
    });


    Route::prefix('products')->group(function () {

        Route::post('/', [ProductController::class, 'store']);

        Route::put('/{id}', [ProductController::class, 'update']);

        Route::delete('/{id}', [ProductController::class, 'destroy']);
    });


    Route::prefix('customization-options')->group(function () {

        Route::post('/', [CustomizationOptionController::class, 'store']);

        Route::put('/{id}', [CustomizationOptionController::class, 'update']);

        Route::delete('/{id}', [CustomizationOptionController::class, 'destroy']);
    });
});

// Routes For Admin and Customer permission
Route::middleware(['auth:admin,customer'])->group(function () {

    Route::prefix('vendors')->group(function () {

        Route::get('/', [VendorController::class, 'index']);

        Route::get('/{id}', [VendorController::class, 'show']);
    });

    Route::prefix('options')->group(function () {
        Route::get('/', [CustomizationOptionController::class, 'index']);

        Route::get('by-customization/{customizationId}', [CustomizationOptionController::class, 'getByCustomizationId']);

        Route::get('/{id}', [CustomizationOptionController::class, 'show']);
    });


    Route::prefix('categories')->group(function () {

        Route::get('/parent-categories', [CategoryController::class, 'getParentCategories']);

        Route::get('/nested/{parentId}', [CategoryController::class, 'getChildCategories']);

        Route::get('/search', [CategoryController::class, 'search']);

        Route::get('/{id}', [CategoryController::class, 'show']);

        Route::get('/', [CategoryController::class, 'index']);

        Route::get('/{categoryId}/vendors', [CategoryController::class, 'getVendorsByCategory']);

        Route::get('/{id}/relations', [CategoryController::class, 'getByIdWithRelations']);
    });


    Route::prefix('customizations')->group(function () {

        Route::get('/', [CustomizationController::class, 'index']);

        Route::get('/search', [CustomizationController::class, 'search']);

        Route::get('/{id}', [CustomizationController::class, 'show']);
    });

    Route::prefix('products')->group(function () {
        // GET /api/products?search=example&vendor_id=1&category_id=2&custom_options[]=3&price_sort=asc&stock_sort=desc

        Route::get('/', [ProductController::class, 'index']);
        Route::get('/getAllProductsByCategory/{categoryId}', [ProductController::class, 'getAllProductsByCategory']);
        Route::get('/{id}', [ProductController::class, 'show']);
    });
});
