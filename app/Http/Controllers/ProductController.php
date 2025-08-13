<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with(['category', 'brand', 'baseImage'])
            ->where('status', true);

        // Filter by category
        if ($request->has('category')) {
            $query->whereHas('category', function($q) use ($request) {
                $q->where('slug', $request->category);
            });
        }

        // Filter by brand
        if ($request->has('brand')) {
            $query->whereHas('brand', function($q) use ($request) {
                $q->where('slug', $request->brand);
            });
        }

        // Filter by price range
        if ($request->has('min_price')) {
            $query->where('price', '>=', $request->min_price);
        }
        if ($request->has('max_price')) {
            $query->where('price', '<=', $request->max_price);
        }

        // Search
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhere('short_description', 'like', "%{$search}%");
            });
        }

        // Sort
        $sort = $request->get('sort', 'latest');
        switch ($sort) {
            case 'price_asc':
                $query->orderBy('price', 'asc');
                break;
            case 'price_desc':
                $query->orderBy('price', 'desc');
                break;
            case 'name_asc':
                $query->orderBy('name', 'asc');
                break;
            case 'name_desc':
                $query->orderBy('name', 'desc');
                break;
            case 'popular':
                $query->orderBy('view_count', 'desc');
                break;
            default:
                $query->latest();
        }

        $products = $query->paginate(12);
        $categories = Category::active()->get();
        $brands = Brand::active()->get();

        return view('products.index', compact('products', 'categories', 'brands'));
    }

    public function show($slug)
    {
        $product = Product::with(['category', 'brand', 'images', 'reviews', 'activeVariants'])
            ->where('slug', $slug)
            ->where('status', true)
            ->firstOrFail();

        // Increment view count
        $product->increment('view_count');

        // Related products
        $relatedProducts = Product::with(['category', 'brand', 'baseImage'])
            ->where('status', true)
            ->where('id', '!=', $product->id)
            ->where(function($query) use ($product) {
                $query->where('category_id', $product->category_id)
                      ->orWhere('brand_id', $product->brand_id);
            })
            ->take(4)
            ->get();

        // Same brand products
        $sameBrandProducts = collect();
        if ($product->brand_id) {
            $sameBrandProducts = Product::with(['category', 'brand', 'baseImage'])
                ->where('status', true)
                ->where('id', '!=', $product->id)
                ->where('brand_id', $product->brand_id)
                ->take(5)
                ->get();
        }

        // Same category products
        $sameCategoryProducts = collect();
        if ($product->category_id) {
            $sameCategoryProducts = Product::with(['category', 'brand', 'baseImage'])
                ->where('status', true)
                ->where('id', '!=', $product->id)
                ->where('category_id', $product->category_id)
                ->take(5)
                ->get();
        }

        return view('products.show', compact('product', 'relatedProducts', 'sameBrandProducts', 'sameCategoryProducts'));
    }

    public function featured()
    {
        $products = Product::with(['category', 'brand', 'baseImage'])
            ->where('is_featured', true)
            ->where('status', true)
            ->latest()
            ->paginate(12);

        return view('products.featured', compact('products'));
    }

    public function deals()
    {
        $products = Product::with(['category', 'brand', 'baseImage'])
            ->where('status', true)
            ->whereNotNull('sale_price')
            ->where('sale_price', '>', 0)
            ->latest()
            ->paginate(12);

        return view('products.deals', compact('products'));
    }

    public function bestsellers()
    {
        $products = Product::with(['category', 'brand', 'baseImage'])
            ->where('status', true)
            ->orderBy('sold_count', 'desc')
            ->paginate(12);

        return view('products.bestsellers', compact('products'));
    }

    public function trending()
    {
        $products = Product::with(['category', 'brand', 'baseImage'])
            ->where('status', true)
            ->where('view_count', '>', 0)
            ->orderBy('view_count', 'desc')
            ->take(8)
            ->get();

        return view('products.trending', compact('products'));
    }

    // API method for cart functionality
    public function apiShow(Product $product)
    {
        if (!$product->status) {
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
    }
}
