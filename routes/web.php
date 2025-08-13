<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CartController;
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
use App\Http\Controllers\AuthController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ReviewController;

/*
|--------------------------------------------------------------------------
| Web Routes for SuperWin Website
|--------------------------------------------------------------------------
*/

// ===== MAIN NAVIGATION ROUTES =====

// ===== AUTHENTICATION ROUTES =====

// Đăng nhập
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');

// Đăng ký
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');

// Đăng xuất
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Routes cần customer authentication
Route::middleware(['customer'])->group(function () {
    // Profile routes
    Route::get('/profile', [AuthController::class, 'profile'])->name('profile');
    Route::put('/profile', [AuthController::class, 'updateProfile'])->name('profile.update');

    // Order routes
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');
    Route::get('/checkout', [OrderController::class, 'checkout'])->name('orders.checkout');
    Route::post('/orders', [OrderController::class, 'store'])->name('orders.store');
    Route::get('/orders/{order}/success', [OrderController::class, 'success'])->name('orders.success');
    Route::patch('/orders/{order}/cancel', [OrderController::class, 'cancel'])->name('orders.cancel');
});

// ===== MAIN NAVIGATION ROUTES =====

// Trang chủ
Route::get('/', [HomeController::class, 'index'])->name('home');

// Cart Routes
Route::prefix('cart')->group(function () {
    Route::get('/', [CartController::class, 'index'])->name('cart.index');
    Route::get('/count', [CartController::class, 'count'])->name('cart.count');
    Route::get('/data', [CartController::class, 'getCartData'])->name('cart.data');
    Route::post('/add/{product}', [CartController::class, 'add'])->name('cart.add');
    Route::patch('/update/{itemKey}', [CartController::class, 'update'])->name('cart.update');
    Route::patch('/quantity/{itemKey}', [CartController::class, 'updateQuantity'])->name('cart.quantity');
    Route::delete('/remove/{itemKey}', [CartController::class, 'remove'])->name('cart.remove');
    Route::post('/clear', [CartController::class, 'clear'])->name('cart.clear');
});

// API Routes for Cart
Route::prefix('api')->group(function () {
    Route::get('/products/{product}', [ProductController::class, 'apiShow'])->name('api.products.show');
    Route::get('/cart/count', [CartController::class, 'apiCount'])->name('api.cart.count');
    Route::post('/cart/add', [CartController::class, 'apiAdd'])->name('api.cart.add');
    Route::put('/cart/update', [CartController::class, 'apiUpdate'])->name('api.cart.update');
    Route::delete('/cart/remove', [CartController::class, 'apiRemove'])->name('api.cart.remove');

    // Test route for debugging
    Route::get('/test/product/{id}', function($id) {
        $product = \App\Models\Product::find($id);
        if (!$product) {
            return response()->json(['error' => 'Product not found'], 404);
        }
        return response()->json([
            'id' => $product->id,
            'name' => $product->name,
            'model' => $product->sku,
            'price' => $product->price,
            'sale_price' => $product->sale_price,
            'image' => $product->baseImage ? $product->baseImage->url : '/image/sp1.png',
            'slug' => $product->slug
        ]);
    });
});

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
Route::get('/category/{category}', [CategoryController::class, 'show'])->name('categories.show');

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
Route::get('/brands/{brand}', [BrandController::class, 'show'])->name('brands.show');

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

// ===== REVIEW ROUTES =====

// Review routes
Route::post('/reviews', [ReviewController::class, 'store'])->name('reviews.store');
Route::get('/products/{product}/reviews', [ReviewController::class, 'getProductReviews'])->name('reviews.product');

// API routes cho search suggestions (nếu cần)
Route::prefix('api')->group(function () {
    Route::get('/search/suggestions', [SearchController::class, 'suggestions'])->name('api.search.suggestions');
    Route::get('/search-suggestions', [SearchController::class, 'suggestions'])->name('api.search.suggestions.old'); // Backward compatibility
    Route::get('/hot-keywords', [SearchController::class, 'hotKeywords'])->name('api.hot-keywords');
    Route::get('/search/hot-suggestions', [SearchController::class, 'hotSuggestions'])->name('api.search.hot-suggestions');
    Route::get('/brands-list', [BrandController::class, 'apiList'])->name('api.brands');
});

// Sitemap (optional)
Route::get('/sitemap.xml', function () {
    return response()->view('sitemap')->header('Content-Type', 'text/xml');
})->name('sitemap');

// Admin routes
require __DIR__.'/admin.php';

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
