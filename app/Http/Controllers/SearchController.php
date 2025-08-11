<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $query = trim($request->get('q', ''));
        $categoryId = $request->get('category_id');
        $brandId = $request->get('brand_id');
        $sortBy = $request->get('sort_by', 'newest');
        $perPage = $request->get('per_page', 12);
        $priceRange = $request->get('price_range');
        
        if (empty($query)) {
            return redirect()->route('home');
        }

        // Build products query
        $productsQuery = Product::with([
            'category', 
            'brand', 
            'images' => function($query) {
                $query->orderBy('sort_order')->orderBy('id');
            }, 
            'baseImage'
        ])->where('status', true);

        // Search logic
        $productsQuery->where(function($q) use ($query) {
            $q->where('name', 'like', "%{$query}%")
              ->orWhere('description', 'like', "%{$query}%")
              ->orWhere('short_description', 'like', "%{$query}%")
              ->orWhere('sku', 'like', "%{$query}%")
              ->orWhere('meta_keywords', 'like', "%{$query}%")
              ->orWhereHas('category', function($categoryQuery) use ($query) {
                  $categoryQuery->where('name', 'like', "%{$query}%");
              })
              ->orWhereHas('brand', function($brandQuery) use ($query) {
                  $brandQuery->where('name', 'like', "%{$query}%");
              });
        });

        // Apply filters
        if ($categoryId) {
            $productsQuery->where('category_id', $categoryId);
        }

        if ($brandId) {
            $productsQuery->where('brand_id', $brandId);
        }

        if ($priceRange) {
            $this->applyPriceFilter($productsQuery, $priceRange);
        }

        // Apply sorting
        $this->applySorting($productsQuery, $sortBy);

        $products = $productsQuery->paginate($perPage)->withQueryString();

        // Get filter data
        $categories = Category::where('status', true)->get();
        $brands = Brand::where('status', true)->get();

        // Get suggested products (related products)
        $suggestedProducts = $this->getSuggestedProducts($query, $products->pluck('id')->toArray());

        return view('search.index', compact('products', 'categories', 'brands', 'query', 'suggestedProducts'));
    }

    public function suggestions(Request $request)
    {
        $query = trim($request->get('q', ''));
        
        if (strlen($query) < 2) {
            return response()->json([
                'products' => [],
                'keyword' => $query
            ]);
        }

        // Get product suggestions
        $products = Product::with(['baseImage', 'brand'])
            ->where('status', true)
            ->where(function($q) use ($query) {
                $q->where('name', 'like', "%{$query}%")
                  ->orWhere('sku', 'like', "%{$query}%");
            })
            ->select('id', 'name', 'slug', 'price', 'sale_price', 'brand_id')
            ->limit(5)
            ->get()
            ->map(function($product) {
                return [
                    'id' => $product->id,
                    'name' => $product->name,
                    'slug' => $product->slug,
                    'price' => $product->sale_price ?? $product->price,
                    'formatted_price' => number_format($product->sale_price ?? $product->price) . 'đ',
                    'brand' => $product->brand->name ?? 'SuperWin',
                    'image' => $product->baseImage ? asset($product->baseImage->url) : asset('/image/sp1.png'),
                    'url' => route('products.show', $product->slug ?? $product->id)
                ];
            });

        return response()->json([
            'products' => $products,
            'keyword' => $query,
            'search_url' => route('search', ['q' => $query])
        ]);
    }

    public function hotKeywords()
    {
        $keywords = [
            'máy bơm nước',
            'máy bơm chìm',
            'quạt công nghiệp',
            'quạt thông gió',
            'máy bơm tăng áp',
            'quạt hút gió',
            'máy bơm nước thải',
            'quạt làm mát'
        ];

        return response()->json($keywords);
    }

    private function applyPriceFilter($query, $priceRange)
    {
        switch ($priceRange) {
            case '0-1000000':
                $query->where(function($q) {
                    $q->where('sale_price', '<', 1000000)->orWhere(function($subQ) {
                        $subQ->whereNull('sale_price')->where('price', '<', 1000000);
                    });
                });
                break;
            case '1000000-3000000':
                $query->where(function($q) {
                    $q->whereBetween('sale_price', [1000000, 3000000])->orWhere(function($subQ) {
                        $subQ->whereNull('sale_price')->whereBetween('price', [1000000, 3000000]);
                    });
                });
                break;
            case '3000000-5000000':
                $query->where(function($q) {
                    $q->whereBetween('sale_price', [3000000, 5000000])->orWhere(function($subQ) {
                        $subQ->whereNull('sale_price')->whereBetween('price', [3000000, 5000000]);
                    });
                });
                break;
            case '5000000-10000000':
                $query->where(function($q) {
                    $q->whereBetween('sale_price', [5000000, 10000000])->orWhere(function($subQ) {
                        $subQ->whereNull('sale_price')->whereBetween('price', [5000000, 10000000]);
                    });
                });
                break;
            case '10000000+':
                $query->where(function($q) {
                    $q->where('sale_price', '>', 10000000)->orWhere(function($subQ) {
                        $subQ->whereNull('sale_price')->where('price', '>', 10000000);
                    });
                });
                break;
        }
    }

    private function applySorting($query, $sortBy)
    {
        switch ($sortBy) {
            case 'price_low':
                $query->orderByRaw('COALESCE(sale_price, price) ASC');
                break;
            case 'price_high':
                $query->orderByRaw('COALESCE(sale_price, price) DESC');
                break;
            case 'name':
                $query->orderBy('name', 'ASC');
                break;
            case 'bestseller':
                $query->orderBy('sold_count', 'DESC');
                break;
            case 'newest':
            default:
                $query->orderBy('created_at', 'DESC');
                break;
        }
    }

    private function getSuggestedProducts($searchQuery, $excludeIds = [])
    {
        return Product::with(['baseImage', 'brand'])
            ->where('status', true)
            ->whereNotIn('id', $excludeIds)
            ->where(function($q) use ($searchQuery) {
                $q->where('name', 'like', "%{$searchQuery}%")
                  ->orWhereHas('category', function($categoryQuery) use ($searchQuery) {
                      $categoryQuery->where('name', 'like', "%{$searchQuery}%");
                  });
            })
            ->inRandomOrder()
            ->limit(10)
            ->get();
    }
} 