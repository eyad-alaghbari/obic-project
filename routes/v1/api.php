<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\Auth\AdminAuthController;
use App\Http\Controllers\Api\V1\Auth\CustomerAuthController;
use App\Http\Controllers\Api\V1\VendorController;

Route::prefix('/admin')->middleware('api')->group(function () {
    Route::post('register', [AdminAuthController::class, 'register'])->middleware('guest:admin');
    Route::post('login', [AdminAuthController::class, 'login']);
    Route::post('logout', [AdminAuthController::class, 'logout'])->middleware('auth:admin');
    Route::get('getUser', [AdminAuthController::class, 'getUser'])->middleware('auth:admin');
});



Route::prefix('customer')->group(function () {
    Route::post('register', [CustomerAuthController::class, 'register'])->middleware('guest:customer');
    Route::post('login', [CustomerAuthController::class, 'login']);
    Route::post('logout', [CustomerAuthController::class, 'logout'])->middleware('auth:customer');
    // Route::post('refresh', [CustomerAuthController::class, 'refresh'])->middleware('auth:customer');
    // Route::get('me', [CustomerAuthController::class, 'me'])->middleware('auth:customer');
});

// i can use api resource here
// Route::apiResource('/vendors',VendorController::class)->middleware('auth:admin');

Route::prefix('vendors')->group(function () {
    Route::get('/', [VendorController::class, 'index']);
    Route::get('/{id}', [VendorController::class, 'show']);
    Route::post('/', [VendorController::class, 'store']);
    Route::put('/{id}', [VendorController::class, 'update']);
    Route::delete('/{id}', [VendorController::class, 'destroy']);

});
