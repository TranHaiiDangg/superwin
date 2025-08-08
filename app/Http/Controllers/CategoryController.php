<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\Brand;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function show(Category $category)
    {
        // Ensure category is active
        if (!$category->is_active) {
            abort(404);
        }

        $category->load(['children' => function($query) {
            $query->where('is_active', true);
        }]);

        // Lấy products của category và subcategories
        $categoryIds = collect([$category->id]);
        if ($category->children->isNotEmpty()) {
            $categoryIds = $categoryIds->merge($category->children->pluck('id'));
        }

        $perPage = request('per_page', 3); // Changed from 16 to 3 for testing pagination
        $sortBy = request('sort_by', 'newest'); // Default sort by newest

        $products = Product::with(['category', 'brand', 'baseImage'])
            ->whereIn('category_id', $categoryIds)
            ->where('status', true);

        // Apply sorting
        switch ($sortBy) {
            case 'newest':
                $products = $products->latest();
                break;
            case 'bestseller':
                $products = $products->orderBy('sold_count', 'desc');
                break;
            case 'price_low':
                $products = $products->orderBy('price', 'asc');
                break;
            case 'price_high':
                $products = $products->orderBy('price', 'desc');
                break;
            case 'name':
                $products = $products->orderBy('name', 'asc');
                break;
            default:
                $products = $products->latest();
                break;
        }

        $products = $products->paginate($perPage);

        // Lấy brands trong category này
        $brands = Brand::whereHas('products', function($query) use ($categoryIds) {
            $query->whereIn('category_id', $categoryIds)
                  ->where('status', true);
        })->where('is_active', true)->get();

        // Lấy sản phẩm gợi ý (tương tự home page)
        $suggestedProducts = Product::with(['category', 'brand', 'baseImage'])
            ->where('status', true)
            ->where(function($query) {
                $query->where('is_featured', true)
                      ->orWhereNotNull('sale_price')
                      ->orWhere('sold_count', '>', 0);
            })
            ->whereNotIn('id', $products->pluck('id')) // Loại trừ products đã hiển thị
            ->orderByRaw('RAND()')
            ->take(10)
            ->get();

        return view('categories.show', compact('category', 'products', 'brands', 'suggestedProducts'));
    }

    public function mayBomNuoc()
    {
        $category = Category::where('name', 'LIKE', '%Máy bơm nước%')
            ->where('is_active', true)
            ->first();

        if (!$category) {
            abort(404, 'Category not found');
        }

        $products = Product::with(['category', 'brand', 'baseImage'])
            ->where('category_id', $category->id)
            ->where('status', true)
            ->paginate(12);

        return view('categories.show', compact('category', 'products'));
    }

    public function quatCongNghiep()
    {
        $category = Category::where('name', 'LIKE', '%Quạt công nghiệp%')
            ->where('is_active', true)
            ->first();

        if (!$category) {
            abort(404, 'Category not found');
        }

        $products = Product::with(['category', 'brand', 'baseImage'])
            ->where('category_id', $category->id)
            ->where('status', true)
            ->paginate(12);

        return view('categories.show', compact('category', 'products'));
    }

    public function quatThongGio()
    {
        $category = Category::where('name', 'LIKE', '%Quạt thông gió%')
            ->where('is_active', true)
            ->first();

        if (!$category) {
            abort(404, 'Category not found');
        }

        $products = Product::with(['category', 'brand', 'baseImage'])
            ->where('category_id', $category->id)
            ->where('status', true)
            ->paginate(12);

        return view('categories.show', compact('category', 'products'));
    }

    public function quatDacBiet()
    {
        $category = Category::where('name', 'LIKE', '%Quạt đặc biệt%')
            ->where('is_active', true)
            ->first();

        if (!$category) {
            abort(404, 'Category not found');
        }

        $products = Product::with(['category', 'brand', 'baseImage'])
            ->where('category_id', $category->id)
            ->where('status', true)
            ->paginate(12);

        return view('categories.show', compact('category', 'products'));
    }

    public function tamLamMat()
    {
        $category = Category::where('name', 'LIKE', '%Tấm làm mát%')
            ->where('is_active', true)
            ->first();

        if (!$category) {
            abort(404, 'Category not found');
        }

        $products = Product::with(['category', 'brand', 'baseImage'])
            ->where('category_id', $category->id)
            ->where('status', true)
            ->paginate(12);

        return view('categories.show', compact('category', 'products'));
    }
}
