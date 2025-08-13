<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Product;
use Illuminate\Http\Request;

class BrandController extends Controller
{
    public function index()
    {
        $brands = Brand::where('is_active', true)
            ->withCount('products')
            ->orderBy('products_count', 'desc')
            ->paginate(12);

        return view('brands.index', compact('brands'));
    }

    public function show($id, Request $request)
    {
        // Find brand by ID only
        $brand = Brand::where('id', $id)
            ->where('is_active', true)
            ->firstOrFail();

        // Build products query
        $query = Product::with(['category', 'brand', 'images', 'baseImage'])
            ->where('brand_id', $brand->id)
            ->where('status', true);

        // Apply category filter
        if ($request->filled('category_id')) {
            $query->where('category_id', (int) $request->category_id);
        }

        // Apply price range filter
        if ($request->filled('price_range')) {
            $priceRange = $request->price_range;
            if ($priceRange !== 'all') {
                if (strpos($priceRange, '+') !== false) {
                    $minPrice = (int) str_replace('+', '', $priceRange);
                    $query->where('price', '>=', $minPrice);
                } else {
                    [$minPrice, $maxPrice] = explode('-', $priceRange);
                    $query->whereBetween('price', [(int) $minPrice, (int) $maxPrice]);
                }
            }
        }

        // Apply quick filters
        if ($request->filled('filter')) {
            switch ($request->filter) {
                case 'sale':
                    $query->whereNotNull('sale_price')->where('sale_price', '>', 0);
                    break;
                case 'featured':
                    $query->where('is_featured', true);
                    break;
                case 'new':
                    $query->where('created_at', '>=', now()->subDays(30));
                    break;
            }
        }

        // Apply sorting
        $sortBy = $request->get('sort_by', 'newest');
        switch ($sortBy) {
            case 'price_low':
                $query->orderByRaw('COALESCE(sale_price, price) ASC');
                break;
            case 'price_high':
                $query->orderByRaw('COALESCE(sale_price, price) DESC');
                break;
            case 'name':
                $query->orderBy('name', 'asc');
                break;
            case 'bestseller':
                $query->orderBy('sold_count', 'desc');
                break;
            case 'newest':
            default:
                $query->orderBy('created_at', 'desc');
                break;
        }

        // Pagination
        $perPage = (int) $request->get('per_page', 12);
        $products = $query->paginate($perPage)->appends($request->query());

        // Get categories for filter (categories that have products from this brand)
        $categories = \App\Models\Category::whereHas('products', function ($q) use ($brand) {
            $q->where('brand_id', $brand->id)->where('status', true);
        })->withCount(['products' => function ($q) use ($brand) {
            $q->where('brand_id', $brand->id)->where('status', true);
        }])->get();

        // Get suggested products (other products from same brand or similar categories)
        $suggestedProducts = Product::with(['images', 'baseImage', 'brand'])
            ->where('status', true)
            ->where('id', '!=', $products->pluck('id')->toArray())
            ->where(function ($q) use ($brand) {
                $q->where('brand_id', $brand->id)
                  ->orWhereIn('category_id', $brand->products()->pluck('category_id')->unique());
            })
            ->inRandomOrder()
            ->limit(10)
            ->get();

        return view('brands.show', compact('brand', 'products', 'categories', 'suggestedProducts'));
    }

    public function superWin(Request $request)
    {
        $brand = Brand::where('name', 'LIKE', '%super%win%')
                     ->orWhere('name', 'LIKE', '%superwin%')
                     ->first();

        if (!$brand) {
            abort(404, 'Brand not found');
        }

        return $this->show($brand->id, $request);
    }

    public function vinaPump(Request $request)
    {
        $brand = Brand::where('name', 'LIKE', '%vina%pump%')
                     ->first();

        if (!$brand) {
            abort(404, 'Brand not found');
        }

        return $this->show($brand->id, $request);
    }

    public function abc(Request $request)
    {
        $brand = Brand::where('name', 'LIKE', '%abc%')
                     ->first();

        if (!$brand) {
            abort(404, 'Brand not found');
        }

        return $this->show($brand->id, $request);
    }

    public function superWinFan(Request $request)
    {
        $brand = Brand::where('name', 'LIKE', '%super%win%fan%')
                     ->first();

        if (!$brand) {
            // Fallback to Super Win brand if super-win-fan doesn't exist
            $brand = Brand::where('name', 'LIKE', '%super%win%')
                         ->first();
        }

        if (!$brand) {
            abort(404, 'Brand not found');
        }

        return $this->show($brand->id, $request);
    }

    public function deton(Request $request)
    {
        $brand = Brand::where('name', 'LIKE', '%deton%')
                     ->first();

        if (!$brand) {
            abort(404, 'Brand not found');
        }

        return $this->show($brand->id, $request);
    }

    public function sthc(Request $request)
    {
        $brand = Brand::where('name', 'LIKE', '%sthc%')
                     ->first();

        if (!$brand) {
            abort(404, 'Brand not found');
        }

        return $this->show($brand->id, $request);
    }

    public function inverter(Request $request)
    {
        $brand = Brand::where('name', 'LIKE', '%inverter%')
                     ->first();

        if (!$brand) {
            abort(404, 'Brand not found');
        }

        return $this->show($brand->id, $request);
    }

    public function apiList()
    {
        $brands = Brand::where('is_active', true)
            ->select('id', 'name', 'slug', 'image')
            ->get();

        return response()->json($brands);
    }
}
