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
use App\Http\Controllers\Admin\ProductVariantController;

Route::prefix('admin')->name('admin.')->group(function () {
    // Auth routes (no middleware)
    Route::get('login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('login', [AuthController::class, 'login']);
    Route::post('logout', [AuthController::class, 'logout'])->name('logout');
    



    // Protected routes
    Route::middleware(['auth', 'admin'])->group(function () {
        // Dashboard
        Route::get('/', [AdminController::class, 'dashboard'])->name('dashboard')->middleware('permission:dashboard.view');

    // Products
    Route::middleware('permission:products.view')->group(function () {
        Route::get('products', [ProductController::class, 'index'])->name('products.index');
    });
    Route::get('products/create', [ProductController::class, 'create'])->name('products.create')->middleware('permission:products.create');
    Route::post('products', [ProductController::class, 'store'])->name('products.store')->middleware('permission:products.create');
    Route::get('products/{product}/edit', [ProductController::class, 'edit'])->name('products.edit')->middleware('permission:products.edit');
    Route::put('products/{product}', [ProductController::class, 'update'])->name('products.update')->middleware('permission:products.edit');
    Route::delete('products/{product}', [ProductController::class, 'destroy'])->name('products.destroy')->middleware('permission:products.delete');
    
    Route::post('products/{product}/restore', [ProductController::class, 'restore'])->name('products.restore')->middleware('permission:products.edit');
    Route::post('products/{product}/upload-images', [ProductController::class, 'uploadImages'])->name('products.upload-images')->middleware('permission:products.edit');
    Route::post('products/{product}/set-base-image', [ProductController::class, 'setBaseImage'])->name('products.set-base-image')->middleware('permission:products.edit');
    Route::post('products/{product}/delete-image', [ProductController::class, 'deleteImage'])->name('products.delete-image')->middleware('permission:products.edit');
    Route::post('products/generate-sku', [ProductController::class, 'generateSKU'])->name('products.generate-sku')->middleware('permission:products.create');

    Route::get('products/{product}/variants', [ProductVariantController::class, 'index'])->name('products.variants.index')->middleware('permission:product_variants.view');
    Route::post('products/{product}/variants/bulk-update', [ProductVariantController::class, 'bulkUpdate'])->name('products.variants.bulk-update')->middleware('permission:product_variants.edit');

    // Product Attributes - Đặt routes cụ thể trước routes có parameter
    Route::get('product-attributes/create', [ProductAttributeController::class, 'create'])->name('product-attributes.create')->middleware('permission:product_attributes.create');
    Route::post('product-attributes', [ProductAttributeController::class, 'store'])->name('product-attributes.store')->middleware('permission:product_attributes.create');
    
    Route::middleware('permission:product_attributes.view')->group(function () {
        Route::get('product-attributes', [ProductAttributeController::class, 'index'])->name('product-attributes.index');
        Route::get('product-attributes/{productAttribute}', [ProductAttributeController::class, 'show'])->name('product-attributes.show');
        Route::get('products/{product}/attributes', [ProductAttributeController::class, 'getByProduct'])->name('products.attributes.get');
    });
    
    Route::get('product-attributes/{productAttribute}/edit', [ProductAttributeController::class, 'edit'])->name('product-attributes.edit')->middleware('permission:product_attributes.edit');
    Route::put('product-attributes/{productAttribute}', [ProductAttributeController::class, 'update'])->name('product-attributes.update')->middleware('permission:product_attributes.edit');
    Route::delete('product-attributes/{productAttribute}', [ProductAttributeController::class, 'destroy'])->name('product-attributes.destroy')->middleware('permission:product_attributes.delete');
    Route::post('product-attributes/{productAttribute}/restore', [ProductAttributeController::class, 'restore'])->name('product-attributes.restore')->middleware('permission:product_attributes.edit');
    Route::post('products/{product}/attributes', [ProductAttributeController::class, 'storeForProduct'])->name('products.attributes.store')->middleware('permission:product_attributes.create');
    
    // Categories - Đặt routes cụ thể trước routes có parameter
    Route::get('categories/create', [CategoryController::class, 'create'])->name('categories.create')->middleware('permission:categories.create');
    Route::post('categories', [CategoryController::class, 'store'])->name('categories.store')->middleware('permission:categories.create');
    
    Route::middleware('permission:categories.view')->group(function () {
        Route::get('categories', [CategoryController::class, 'index'])->name('categories.index');
        Route::get('categories/{category}', [CategoryController::class, 'show'])->name('categories.show');
    });
    
    Route::get('categories/{category}/edit', [CategoryController::class, 'edit'])->name('categories.edit')->middleware('permission:categories.edit');
    Route::put('categories/{category}', [CategoryController::class, 'update'])->name('categories.update')->middleware('permission:categories.edit');
    Route::delete('categories/{category}', [CategoryController::class, 'destroy'])->name('categories.destroy')->middleware('permission:categories.delete');
    Route::post('categories/{category}/restore', [CategoryController::class, 'restore'])->name('categories.restore')->middleware('permission:categories.edit');
    
    // Brands  
    Route::get('brands/create', [BrandController::class, 'create'])->name('brands.create')->middleware('permission:brands.create');
    Route::post('brands', [BrandController::class, 'store'])->name('brands.store')->middleware('permission:brands.create');
    Route::middleware('permission:brands.view')->group(function () {
        Route::get('brands', [BrandController::class, 'index'])->name('brands.index');
        Route::get('brands/{brand}', [BrandController::class, 'show'])->name('brands.show');
    });
    Route::get('brands/{brand}/edit', [BrandController::class, 'edit'])->name('brands.edit')->middleware('permission:brands.edit');
    Route::put('brands/{brand}', [BrandController::class, 'update'])->name('brands.update')->middleware('permission:brands.edit');
    Route::delete('brands/{brand}', [BrandController::class, 'destroy'])->name('brands.destroy')->middleware('permission:brands.delete');
    Route::post('brands/{brand}/restore', [BrandController::class, 'restore'])->name('brands.restore')->middleware('permission:brands.edit');
    
    // Orders - Đặt routes cụ thể trước routes có parameter
    Route::get('orders/export', [OrderController::class, 'exportOrders'])->name('orders.exportOrders')->middleware('permission:orders.view');
    
    Route::middleware('permission:orders.view')->group(function () {
        Route::get('orders', [OrderController::class, 'index'])->name('orders.index');
        Route::get('orders/{order}', [OrderController::class, 'show'])->name('orders.show');
        Route::get('orders/{order}/invoice', [OrderController::class, 'printInvoice'])->name('orders.printInvoice');
    });
    
    Route::get('orders/{order}/edit', [OrderController::class, 'edit'])->name('orders.edit')->middleware('permission:orders.edit');
    Route::put('orders/{order}', [OrderController::class, 'update'])->name('orders.update')->middleware('permission:orders.edit');
    Route::delete('orders/{order}', [OrderController::class, 'destroy'])->name('orders.destroy')->middleware('permission:orders.delete');
    Route::patch('orders/{order}/status', [OrderController::class, 'updateStatus'])->name('orders.update-status')->middleware('permission:orders.edit');
    
    // Users (Admin)
    Route::get('users/create', [UserController::class, 'create'])->name('users.create')->middleware('permission:users.create');
    Route::middleware('permission:users.view')->group(function () {
        Route::get('users', [UserController::class, 'index'])->name('users.index');
        Route::get('users/{user}', [UserController::class, 'show'])->name('users.show');
    });
    Route::post('users', [UserController::class, 'store'])->name('users.store')->middleware('permission:users.create');
    Route::get('users/{user}/edit', [UserController::class, 'edit'])->name('users.edit')->middleware('permission:users.edit');
    Route::put('users/{user}', [UserController::class, 'update'])->name('users.update')->middleware('permission:users.edit');
    Route::delete('users/{user}', [UserController::class, 'destroy'])->name('users.destroy')->middleware('permission:users.delete');
    Route::post('users/{user}/ban', [UserController::class, 'ban'])->name('users.ban')->middleware('permission:users.edit');
    Route::post('users/{user}/unban', [UserController::class, 'unban'])->name('users.unban')->middleware('permission:users.edit');
    
    // Customers
    Route::middleware('permission:customers.view')->group(function () {
        Route::get('customers', [CustomerController::class, 'index'])->name('customers.index');
        Route::get('customers/{customer}', [CustomerController::class, 'show'])->name('customers.show');
    });
    Route::get('customers/{customer}/edit', [CustomerController::class, 'edit'])->name('customers.edit')->middleware('permission:customers.edit');
    Route::put('customers/{customer}', [CustomerController::class, 'update'])->name('customers.update')->middleware('permission:customers.edit');
    Route::post('customers/{customer}/ban', [CustomerController::class, 'ban'])->name('customers.ban')->middleware('permission:customers.edit');
    Route::post('customers/{customer}/unban', [CustomerController::class, 'unban'])->name('customers.unban')->middleware('permission:customers.edit');
    Route::post('customers/{customer}/activate', [CustomerController::class, 'activate'])->name('customers.activate')->middleware('permission:customers.edit');
    Route::post('customers/{customer}/deactivate', [CustomerController::class, 'deactivate'])->name('customers.deactivate')->middleware('permission:customers.edit');
    
        // Reports
        Route::get('reports/sales', [AdminController::class, 'salesReport'])->name('reports.sales')->middleware('permission:dashboard.reports');
        Route::get('reports/inventory', [AdminController::class, 'inventoryReport'])->name('reports.inventory')->middleware('permission:dashboard.reports');
        
        // Permissions Management
        Route::get('permissions', [\App\Http\Controllers\Admin\PermissionController::class, 'index'])->name('permissions.index')->middleware('permission:users.permissions');
        Route::post('permissions/sync', [\App\Http\Controllers\Admin\PermissionController::class, 'sync'])->name('permissions.sync')->middleware('permission:users.permissions');
        Route::post('permissions/artisan-sync', [\App\Http\Controllers\Admin\PermissionController::class, 'runArtisanSync'])->name('permissions.artisanSync')->middleware('permission:users.permissions');
        Route::post('permissions', [\App\Http\Controllers\Admin\PermissionController::class, 'store'])->name('permissions.store')->middleware('permission:users.permissions');
        Route::delete('permissions/{permission}', [\App\Http\Controllers\Admin\PermissionController::class, 'destroy'])->name('permissions.destroy')->middleware('permission:users.permissions');
        Route::put('permissions/roles/{role}', [\App\Http\Controllers\Admin\PermissionController::class, 'updateRolePermissions'])->name('permissions.updateRolePermissions')->middleware('permission:users.permissions');
        
        // Revenue Management
        Route::get('revenue', [\App\Http\Controllers\Admin\RevenueController::class, 'index'])->name('revenue.index')->middleware('permission:revenue.view');
        Route::get('revenue/monthly-data', [\App\Http\Controllers\Admin\RevenueController::class, 'getMonthlyData'])->name('revenue.monthlyData')->middleware('permission:revenue.stats');
        Route::get('revenue/date-range-data', [\App\Http\Controllers\Admin\RevenueController::class, 'getDateRangeData'])->name('revenue.dateRangeData')->middleware('permission:revenue.stats');
        Route::get('revenue/export', [\App\Http\Controllers\Admin\RevenueController::class, 'exportExcel'])->name('revenue.export')->middleware('permission:revenue.export');
    });
}); 