<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\SupportController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\WarrantyController;

/*
|--------------------------------------------------------------------------
| Web Routes for SuperWin Website
|--------------------------------------------------------------------------
*/

// ===== MAIN NAVIGATION ROUTES =====

// Trang chủ
Route::get('/', [HomeController::class, 'index'])->name('home');

// Sản phẩm
Route::prefix('products')->name('products.')->group(function () {
    Route::get('/', [ProductController::class, 'index'])->name('index');
    Route::get('/featured', [ProductController::class, 'featured'])->name('featured');
    Route::get('/{slug}', [ProductController::class, 'show'])->name('show');
});

// Hỗ trợ
Route::get('/support', [SupportController::class, 'index'])->name('support');

// Liên hệ
Route::get('/contact', [ContactController::class, 'index'])->name('contact');
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');

// Tìm kiếm
Route::get('/search', [SearchController::class, 'index'])->name('search');

// ===== CATEGORY ROUTES =====

Route::prefix('categories')->name('categories.')->group(function () {
    // Danh mục chính
    Route::get('/may-bom-nuoc', [CategoryController::class, 'mayBomNuoc'])->name('show');
    Route::get('/quat-cong-nghiep', [CategoryController::class, 'quatCongNghiep'])->name('show');
    Route::get('/quat-thong-gio', [CategoryController::class, 'quatThongGio'])->name('show');
    Route::get('/quat-dac-biet', [CategoryController::class, 'quatDacBiet'])->name('show');
    Route::get('/tam-lam-mat', [CategoryController::class, 'tamLamMat'])->name('show');
});

// Hoặc sử dụng dynamic route cho categories
Route::get('/category/{slug}', [CategoryController::class, 'show'])->name('categories.show');

// ===== BRAND ROUTES =====

Route::prefix('brands')->name('products.brand.')->group(function () {
    // Máy bơm nước brands
    Route::get('/super-win', [BrandController::class, 'superWin'])->name('super-win');
    Route::get('/vina-pump', [BrandController::class, 'vinaPump'])->name('vina-pump');
    Route::get('/abc', [BrandController::class, 'abc'])->name('abc');
    
    // Quạt brands
    Route::get('/super-win-fan', [BrandController::class, 'superWinFan'])->name('super-win-fan');
    Route::get('/deton', [BrandController::class, 'deton'])->name('deton');
    Route::get('/sthc', [BrandController::class, 'sthc'])->name('sthc');
    Route::get('/inverter', [BrandController::class, 'inverter'])->name('inverter');
});

// Hoặc sử dụng dynamic route cho brands
Route::get('/brand/{slug}', [BrandController::class, 'show'])->name('products.brand');

// ===== PRODUCT CATEGORY ROUTES =====

Route::prefix('product-category')->name('products.category.')->group(function () {
    // Máy bơm nước categories
    Route::get('/may-bom-nuoc-bien', [ProductController::class, 'categoryShow'])->name('may-bom-nuoc-bien');
    Route::get('/may-bom-ho-boi', [ProductController::class, 'categoryShow'])->name('may-bom-ho-boi');
    Route::get('/may-bom-nhap-khau', [ProductController::class, 'categoryShow'])->name('may-bom-nhap-khau');
    
    // Quạt thông gió categories
    Route::get('/quat-thong-gio-vuong-super-win', [ProductController::class, 'categoryShow'])->name('quat-thong-gio-vuong-super-win');
    Route::get('/quat-thong-gio-vuong-deton', [ProductController::class, 'categoryShow'])->name('quat-thong-gio-vuong-deton');
    Route::get('/quat-thong-gio-tron', [ProductController::class, 'categoryShow'])->name('quat-thong-gio-tron');
    
    // Quạt đặc biệt categories
    Route::get('/quat-huong-truc-noi-ong', [ProductController::class, 'categoryShow'])->name('quat-huong-truc-noi-ong');
    Route::get('/quat-san-cong-nghiep', [ProductController::class, 'categoryShow'])->name('quat-san-cong-nghiep');
    Route::get('/quat-tran-cong-nghiep', [ProductController::class, 'categoryShow'])->name('quat-tran-cong-nghiep');
    Route::get('/quat-chong-chay-no', [ProductController::class, 'categoryShow'])->name('quat-chong-chay-no');
    Route::get('/quat-vuong', [ProductController::class, 'categoryShow'])->name('quat-vuong');
    Route::get('/quat-composite', [ProductController::class, 'categoryShow'])->name('quat-composite');
});

// Hoặc sử dụng dynamic route cho product categories
Route::get('/products/category/{slug}', [ProductController::class, 'categoryShow'])->name('products.category');

// ===== QUICK LINKS ROUTES =====

// Hot Deals
Route::get('/deals', [ProductController::class, 'deals'])->name('deals');

// Thương hiệu
Route::get('/brands', [BrandController::class, 'index'])->name('brands');

// Bán chạy
Route::get('/bestsellers', [ProductController::class, 'bestsellers'])->name('bestsellers');

// Top tìm kiếm
Route::get('/trending', [ProductController::class, 'trending'])->name('trending');

// ===== INFORMATION ROUTES =====

// Tin tức - Sự kiện
Route::get('/news', [NewsController::class, 'index'])->name('news');
Route::get('/news/{slug}', [NewsController::class, 'show'])->name('news.show');

// Bài viết
Route::get('/blog', [BlogController::class, 'index'])->name('blog');
Route::get('/blog/{slug}', [BlogController::class, 'show'])->name('blog.show');

// Chính sách bảo hành
Route::get('/warranty', [WarrantyController::class, 'index'])->name('warranty');

// ===== ADDITIONAL ROUTES =====

// API routes cho search suggestions (nếu cần)
Route::prefix('api')->group(function () {
    Route::get('/search-suggestions', [SearchController::class, 'suggestions'])->name('api.search.suggestions');
    Route::get('/hot-keywords', [SearchController::class, 'hotKeywords'])->name('api.hot-keywords');
    Route::get('/brands-list', [BrandController::class, 'apiList'])->name('api.brands');
});

// Sitemap (optional)
Route::get('/sitemap.xml', function () {
    return response()->view('sitemap')->header('Content-Type', 'text/xml');
})->name('sitemap');

// 404 fallback
Route::fallback(function () {
    return response()->view('errors.404', [], 404);
});

/*
|--------------------------------------------------------------------------
| Alternative Dynamic Routes (Recommended)
|--------------------------------------------------------------------------
| Thay vì tạo nhiều route cố định, bạn có thể sử dụng các route động:
*/

// Dynamic category route
// Route::get('/category/{category:slug}', [CategoryController::class, 'show'])->name('categories.show');

// Dynamic brand route  
// Route::get('/brand/{brand:slug}', [BrandController::class, 'show'])->name('products.brand');

// Dynamic product category route
// Route::get('/products/{category:slug}', [ProductController::class, 'categoryShow'])->name('products.category');

/*
|--------------------------------------------------------------------------
| Route Model Binding Examples
|--------------------------------------------------------------------------
| Trong các Controller, bạn có thể sử dụng Route Model Binding:
*/

// Ví dụ trong CategoryController:
// public function show(Category $category) {
//     return view('categories.show', compact('category'));
// }

// Ví dụ trong BrandController:
// public function show(Brand $brand) {
//     $products = $brand->products()->paginate(12);
//     return view('brands.show', compact('brand', 'products'));
// }

/*
|--------------------------------------------------------------------------
| Middleware Examples
|--------------------------------------------------------------------------
| Bạn có thể thêm middleware nếu cần:
*/

// Route::middleware(['auth'])->group(function () {
//     Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
// });

// Route::middleware(['admin'])->prefix('admin')->group(function () {
//     Route::resource('products', AdminProductController::class);
//     Route::resource('categories', AdminCategoryController::class);
// });