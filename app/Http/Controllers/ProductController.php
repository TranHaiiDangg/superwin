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
        $product = Product::with(['category', 'brand', 'images', 'reviews.customer', 'activeVariants'])
            ->where('slug', $slug)
            ->where('status', true)
            ->firstOrFail();
        
        // Ensure rating data is calculated if not cached
        if ($product->rating_average === null || $product->rating_count === null) {
            $approvedReviews = $product->reviews()->where('is_approved', true)->get();
            $averageRating = $approvedReviews->count() > 0 ? round($approvedReviews->avg('rating'), 1) : 0;
            $reviewsCount = $approvedReviews->count();
            
            $product->update([
                'rating_average' => $averageRating,
                'rating_count' => $reviewsCount
            ]);
            
            // Update the model instance with fresh data
            $product->rating_average = $averageRating;
            $product->rating_count = $reviewsCount;
        }

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

    // public function deals()
    // {
    //     $products = Product::with(['category', 'brand', 'baseImage'])
    //         ->where('status', true)
    //         ->whereNotNull('sale_price')
    //         ->where('sale_price', '>', 0)
    //         ->latest()
    //         ->paginate(12);

    //     return view('products.deals', compact('products'));
    // }

    public function bestsellers(Request $request)
    {
        // Build products query for bestsellers (products with sold_count > 0)
        $query = Product::with(['category', 'brand', 'images', 'baseImage'])
            ->where('status', true)
            ->where('sold_count', '>', 0);

        // Apply category filter
        if ($request->filled('category_id')) {
            $query->where('category_id', (int) $request->category_id);
        }

        // Apply brand filter
        if ($request->filled('brand_id')) {
            $query->where('brand_id', (int) $request->brand_id);
        }

        // Apply price range filter
        if ($request->filled('price_range')) {
            $priceRange = $request->price_range;
            if ($priceRange !== 'all') {
                if (strpos($priceRange, '+') !== false) {
                    $minPrice = (int) str_replace('+', '', $priceRange);
                    $query->whereRaw('COALESCE(sale_price, price) >= ?', [$minPrice]);
                } else {
                    [$minPrice, $maxPrice] = explode('-', $priceRange);
                    $query->whereRaw('COALESCE(sale_price, price) BETWEEN ? AND ?', [(int) $minPrice, (int) $maxPrice]);
                }
            }
        }

        // Apply sales range filter
        if ($request->filled('sales_range')) {
            $salesRange = $request->sales_range;
            if ($salesRange !== 'all') {
                if (strpos($salesRange, '+') !== false) {
                    $minSales = (int) str_replace('+', '', $salesRange);
                    $query->where('sold_count', '>=', $minSales);
                } else {
                    [$minSales, $maxSales] = explode('-', $salesRange);
                    $query->whereBetween('sold_count', [(int) $minSales, (int) $maxSales]);
                }
            }
        }

        // Apply quick filters
        if ($request->filled('filter')) {
            switch ($request->filter) {
                case 'sale':
                    $query->whereNotNull('sale_price')->where('sale_price', '>', 0)->where('is_sale', true);
                    break;
                case 'featured':
                    $query->where('is_featured', true);
                    break;
                case 'new':
                    $query->where('created_at', '>=', now()->subDays(30));
                    break;
                case 'top_seller':
                    $query->where('sold_count', '>=', 100);
                    break;
            }
        }

        // Apply sorting
        $sortBy = $request->get('sort_by', 'bestseller');
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
            case 'newest':
                $query->orderBy('created_at', 'desc');
                break;
            case 'bestseller':
            default:
                $query->orderBy('sold_count', 'desc');
                break;
        }

        // Pagination
        $perPage = (int) $request->get('per_page', 12);
        $products = $query->paginate($perPage)->appends($request->query());

        // Get categories for filter (categories that have bestseller products)
        $categories = Category::whereHas('products', function ($q) {
            $q->where('status', true)->where('sold_count', '>', 0);
        })->withCount(['products' => function ($q) {
            $q->where('status', true)->where('sold_count', '>', 0);
        }])->get();

        // Get brands for filter (brands that have bestseller products)
        $brands = Brand::whereHas('products', function ($q) {
            $q->where('status', true)->where('sold_count', '>', 0);
        })->withCount(['products' => function ($q) {
            $q->where('status', true)->where('sold_count', '>', 0);
        }])->get();

        // Get suggested products (other bestseller products)
        $suggestedProducts = Product::with(['images', 'baseImage', 'brand'])
            ->where('status', true)
            ->where('sold_count', '>', 0)
            ->whereNotIn('id', $products->pluck('id')->toArray())
            ->inRandomOrder()
            ->limit(10)
            ->get();

        // Calculate bestseller stats
        $totalBestsellers = Product::where('status', true)
            ->where('sold_count', '>', 0)
            ->count();

        $totalSold = Product::where('status', true)
            ->where('sold_count', '>', 0)
            ->sum('sold_count');

        $avgSold = Product::where('status', true)
            ->where('sold_count', '>', 0)
            ->avg('sold_count');

        $bestsellerStats = [
            'total_bestsellers' => $totalBestsellers,
            'total_sold' => $totalSold,
            'avg_sold' => round($avgSold, 0),
            'top_sold' => Product::where('status', true)->max('sold_count') ?? 0,
        ];

        return view('products.bestsellers', compact('products', 'categories', 'brands', 'suggestedProducts', 'bestsellerStats'));
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

    public function deals(Request $request)
    {
        // Build products query for hot deals (products with sale_price)
        $query = Product::with(['category', 'brand', 'images', 'baseImage'])
            ->where('status', true)
            // ->whereNotNull('sale_price')
            // ->where('sale_price', '>', 0)
            ->where('is_sale', true); // Sử dụng is_sale flag

        // Apply category filter
        if ($request->filled('category_id')) {
            $query->where('category_id', (int) $request->category_id);
        }

        // Apply brand filter
        if ($request->filled('brand_id')) {
            $query->where('brand_id', (int) $request->brand_id);
        }

        // Apply price range filter
        if ($request->filled('price_range')) {
            $priceRange = $request->price_range;
            if ($priceRange !== 'all') {
                if (strpos($priceRange, '+') !== false) {
                    $minPrice = (int) str_replace('+', '', $priceRange);
                    $query->whereRaw('COALESCE(sale_price, price) >= ?', [$minPrice]);
                } else {
                    [$minPrice, $maxPrice] = explode('-', $priceRange);
                    $query->whereRaw('COALESCE(sale_price, price) BETWEEN ? AND ?', [(int) $minPrice, (int) $maxPrice]);
                }
            }
        }

        // Apply discount range filter
        if ($request->filled('discount_range')) {
            $discountRange = $request->discount_range;
            if ($discountRange !== 'all') {
                if (strpos($discountRange, '+') !== false) {
                    $minDiscount = (int) str_replace('+', '', $discountRange);
                    $query->whereRaw('((price - sale_price) / price * 100) >= ?', [$minDiscount]);
                } else {
                    [$minDiscount, $maxDiscount] = explode('-', $discountRange);
                    $query->whereRaw('((price - sale_price) / price * 100) BETWEEN ? AND ?', [(int) $minDiscount, (int) $maxDiscount]);
                }
            }
        }

        // Apply quick filters
        if ($request->filled('filter')) {
            switch ($request->filter) {
                case 'featured':
                    $query->where('is_featured', true);
                    break;
                case 'new':
                    $query->where('created_at', '>=', now()->subDays(30));
                    break;
                case 'high_discount':
                    $query->whereRaw('((price - sale_price) / price * 100) >= 50');
                    break;
            }
        }

        // Apply sorting
        $sortBy = $request->get('sort_by', 'discount_high');
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
                $query->orderBy('created_at', 'desc');
                break;
            case 'discount_high':
            default:
                $query->orderByRaw('((price - sale_price) / price * 100) DESC');
                break;
        }

        // Pagination
        $perPage = (int) $request->get('per_page', 12);
        $products = $query->paginate($perPage)->appends($request->query());

        // Get categories for filter (categories that have sale products)
        $categories = Category::whereHas('products', function ($q) {
            $q->where('status', true)
              ->whereNotNull('sale_price')
              ->where('sale_price', '>', 0)
              ->where('is_sale', true);
        })->withCount(['products' => function ($q) {
            $q->where('status', true)
              ->whereNotNull('sale_price')
              ->where('sale_price', '>', 0)
              ->where('is_sale', true);
        }])->get();

        // Get brands for filter (brands that have sale products)
        $brands = Brand::whereHas('products', function ($q) {
            $q->where('status', true)
              ->whereNotNull('sale_price')
              ->where('sale_price', '>', 0)
              ->where('is_sale', true);
        })->withCount(['products' => function ($q) {
            $q->where('status', true)
              ->whereNotNull('sale_price')
              ->where('sale_price', '>', 0)
              ->where('is_sale', true);
        }])->get();

        // Get suggested products (other sale products)
        $suggestedProducts = Product::with(['images', 'baseImage', 'brand'])
            ->where('status', true)
            ->whereNotNull('sale_price')
            ->where('sale_price', '>', 0)
            ->where('is_sale', true)
            ->whereNotIn('id', $products->pluck('id')->toArray())
            ->inRandomOrder()
            ->limit(10)
            ->get();

        // Calculate deal stats
        $totalDeals = Product::where('status', true)
            ->whereNotNull('sale_price')
            ->where('sale_price', '>', 0)
            ->where('is_sale', true)
            ->count();

        $avgDiscount = Product::where('status', true)
            ->whereNotNull('sale_price')
            ->where('sale_price', '>', 0)
            ->where('is_sale', true)
            ->selectRaw('AVG((price - sale_price) / price * 100) as avg_discount')
            ->first()
            ->avg_discount ?? 0;

        $dealStats = [
            'total_deals' => $totalDeals,
            'avg_discount' => round($avgDiscount, 1),
            'max_discount' => 70, // Có thể tính động nếu cần
        ];

        return view('products.deals', compact('products', 'categories', 'brands', 'suggestedProducts', 'dealStats'));
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
