<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\UserController;

Route::prefix('admin')->name('admin.')->group(function () {
    // Auth routes (no middleware)
    Route::get('login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('login', [AuthController::class, 'login']);
    Route::post('logout', [AuthController::class, 'logout'])->name('logout');

    // Protected routes
    Route::middleware('auth')->group(function () {
        // Dashboard
        Route::get('/', [AdminController::class, 'dashboard'])->name('dashboard');

    // Products
    Route::resource('products', ProductController::class);
    Route::post('products/{product}/upload-images', [ProductController::class, 'uploadImages'])->name('products.upload-images');
    Route::post('products/{product}/set-base-image', [ProductController::class, 'setBaseImage'])->name('products.set-base-image');
    Route::delete('products/{product}/delete-image', [ProductController::class, 'deleteImage'])->name('products.delete-image');
    
    // Categories
    Route::resource('categories', CategoryController::class);
    
    // Brands
    Route::resource('brands', BrandController::class);
    
    // Orders
    Route::resource('orders', OrderController::class);
    Route::patch('orders/{order}/status', [OrderController::class, 'updateStatus'])->name('orders.update-status');
    
    // Users
    Route::resource('users', UserController::class);
    
        // Reports
        Route::get('reports/sales', [AdminController::class, 'salesReport'])->name('reports.sales');
        Route::get('reports/inventory', [AdminController::class, 'inventoryReport'])->name('reports.inventory');
    });
}); 