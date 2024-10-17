<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\Auth\AdminAuthController;
use App\Http\Controllers\Api\V1\Auth\CustomerAuthController;


Route::prefix('/admin')->group(function () {
    Route::post('login', [AdminAuthController::class, 'login']);   // تسجيل الدخول
    Route::post('logout', [AdminAuthController::class, 'logout'])->middleware('auth:admin');  // تسجيل الخروج
    // Route::post('refresh', [AdminAuthController::class, 'refresh'])->middleware('auth:admin'); // تحديث التوكن
    Route::get('me', [AdminAuthController::class, 'getUser'])->middleware('auth:admin');  // استرجاع بيانات الإداري
});



Route::prefix('customer')->group(function () {
    Route::post('login', [CustomerAuthController::class, 'login']);   // تسجيل الدخول
    Route::post('logout', [CustomerAuthController::class, 'logout'])->middleware('auth:customer');  // تسجيل الخروج
    // Route::post('refresh', [CustomerAuthController::class, 'refresh'])->middleware('auth:customer'); // تحديث التوكن
    // Route::get('me', [CustomerAuthController::class, 'me'])->middleware('auth:customer');  // استرجاع بيانات العميل
});
