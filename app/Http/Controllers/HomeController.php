<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index()
    {
        // Lấy sản phẩm nổi bật
        $featuredProducts = Product::with(['category', 'brand', 'baseImage'])
            ->where('is_featured', true)
            ->where('status', true)
            ->latest()
            ->take(8)
            ->get();

        // Lấy sản phẩm bán chạy
        $bestSellers = Product::with(['category', 'brand', 'baseImage'])
            ->where('status', true)
            ->orderBy('sold_count', 'desc')
            ->take(8)
            ->get();

        // Lấy sản phẩm mới
        $newProducts = Product::with(['category', 'brand', 'baseImage'])
            ->where('status', true)
            ->latest()
            ->take(8)
            ->get();

        // Lấy sản phẩm khuyến mãi cho Flash Deals
        $saleProducts = Product::with(['category', 'brand', 'baseImage'])
            ->where('status', true)
            ->whereNotNull('sale_price')
            ->where('sale_price', '>', 0)
            ->where('sale_price', '<', DB::raw('price')) // Đảm bảo sale_price < price
            ->orderByRaw('((price - sale_price) / price * 100) DESC') // Sắp xếp theo % giảm giá cao nhất
            ->take(10)
            ->get();

        // Lấy danh mục chính
        $mainCategories = Category::where('parent_id', null)
            ->where('is_active', true)
            ->with(['children' => function($query) {
                $query->where('is_active', true)->take(5);
            }])
            ->take(6)
            ->get();

        // Lấy thương hiệu
        $brands = Brand::where('is_active', true)
            ->withCount('products')
            ->orderBy('products_count', 'desc')
            ->take(8)
            ->get();

        return view('home', compact(
            'featuredProducts',
            'bestSellers',
            'newProducts',
            'saleProducts',
            'mainCategories',
            'brands'
        ));
    }
}
