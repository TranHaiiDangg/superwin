<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\ProductAttributeController;

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
    Route::post('products/{product}/restore', [ProductController::class, 'restore'])->name('products.restore');
    Route::post('products/{product}/upload-images', [ProductController::class, 'uploadImages'])->name('products.upload-images');
    Route::post('products/{product}/set-base-image', [ProductController::class, 'setBaseImage'])->name('products.set-base-image');
    Route::post('products/{product}/delete-image', [ProductController::class, 'deleteImage'])->name('products.delete-image');
    Route::post('products/generate-sku', [ProductController::class, 'generateSKU'])->name('products.generate-sku');

    // Product Attributes
    Route::resource('product-attributes', ProductAttributeController::class);
    Route::post('product-attributes/{productAttribute}/restore', [ProductAttributeController::class, 'restore'])->name('product-attributes.restore');
    Route::get('products/{product}/attributes', [ProductAttributeController::class, 'getByProduct'])->name('products.attributes.get');
    Route::post('products/{product}/attributes', [ProductAttributeController::class, 'storeForProduct'])->name('products.attributes.store');
    
    // Categories
    Route::resource('categories', CategoryController::class);
    Route::post('categories/{category}/restore', [CategoryController::class, 'restore'])->name('categories.restore');
    
    // Brands
    Route::resource('brands', BrandController::class);
    Route::post('brands/{brand}/restore', [BrandController::class, 'restore'])->name('brands.restore');
    
    // Orders
    Route::resource('orders', OrderController::class);
    Route::patch('orders/{order}/status', [OrderController::class, 'updateStatus'])->name('orders.update-status');
    Route::get('orders/{order}/invoice', [OrderController::class, 'printInvoice'])->name('orders.printInvoice');
    Route::get('orders/export', [OrderController::class, 'exportOrders'])->name('orders.exportOrders');
    
    // Users (Admin)
    Route::resource('users', UserController::class);
    Route::post('users/{user}/ban', [UserController::class, 'ban'])->name('users.ban');
    Route::post('users/{user}/unban', [UserController::class, 'unban'])->name('users.unban');
    
    // Customers
    Route::resource('customers', CustomerController::class)->except(['create', 'store', 'destroy']);
    Route::post('customers/{customer}/ban', [CustomerController::class, 'ban'])->name('customers.ban');
    Route::post('customers/{customer}/unban', [CustomerController::class, 'unban'])->name('customers.unban');
    
        // Reports
        Route::get('reports/sales', [AdminController::class, 'salesReport'])->name('reports.sales');
        Route::get('reports/inventory', [AdminController::class, 'inventoryReport'])->name('reports.inventory');
    });
}); 