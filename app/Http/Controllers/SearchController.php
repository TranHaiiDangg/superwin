<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use App\Models\HotSearch;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $query = trim(urldecode($request->get('q', '')));
        $categoryId = $request->get('category_id');
        $brandId = $request->get('brand_id');
        $sortBy = $request->get('sort_by', 'newest');
        $perPage = $request->get('per_page', 12);
        $priceRange = $request->get('price_range');
        $filter = $request->get('filter');
        
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

        // Apply additional filters
        if ($filter) {
            $this->applyAdditionalFilter($productsQuery, $filter);
        }

        // Apply sorting
        $this->applySorting($productsQuery, $sortBy);

        $products = $productsQuery->paginate($perPage)->withQueryString();

        // Get filter data
        $categories = Category::where('is_active', true)->get();
        $brands = Brand::where('is_active', true)->get();

        // Get suggested products (related products)
        $suggestedProducts = $this->getSuggestedProducts($query, $products->pluck('id')->toArray());

        return view('search.index', compact('products', 'categories', 'brands', 'query', 'suggestedProducts'));
    }

    public function suggestions(Request $request)
    {
        $query = trim(urldecode($request->get('q', '')));
        
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

    private function applyAdditionalFilter($query, $filter)
    {
        switch ($filter) {
            case 'sale':
                $query->where('is_sale', true);
                break;
            case 'featured':
                $query->where('is_featured', true);
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

    public function hotSuggestions(Request $request)
    {
        $query = trim($request->get('q', ''));
        
        // Get regular search suggestions (existing products)
        $productSuggestions = $this->getProductSuggestions($query);
        
        // Get Hot Search data
        $hotSearchData = $this->getHotSearchSuggestions($query);
        
        return response()->json([
            'success' => true,
            'query' => $query,
            'suggestions' => [
                'products' => $productSuggestions,
                'hot_categories' => $hotSearchData['categories'],
                'hot_brands' => $hotSearchData['brands'],
                'hot_products' => $hotSearchData['products'],
                'hot_keywords' => $hotSearchData['keywords']
            ]
        ]);
    }
    
    private function getProductSuggestions($query, $limit = 5)
    {
        if (empty($query)) {
            return [];
        }
        
        return Product::with(['baseImage', 'category', 'brand'])
            ->where('status', true)
            ->where(function($q) use ($query) {
                $q->where('name', 'like', "%{$query}%")
                  ->orWhere('sku', 'like', "%{$query}%");
            })
            ->limit($limit)
            ->get()
            ->map(function($product) {
                return [
                    'id' => $product->id,
                    'name' => $product->name,
                    'sku' => $product->sku,
                    'price' => $product->price,
                    'sale_price' => $product->sale_price,
                    'image' => $product->baseImage?->url ? asset($product->baseImage->url) : asset('/image/sp1.png'),
                    'category' => $product->category?->name,
                    'brand' => $product->brand?->name,
                    'url' => route('products.show', $product->slug ?? $product->id)
                ];
            });
    }
    
    private function getHotSearchSuggestions($query)
    {
        // Get active Hot Search entries
        $hotSearches = HotSearch::with(['items.product.baseImage', 'items.brand', 'items.category'])
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->orderBy('click_count', 'desc')
            ->get();
            
        $categories = [];
        $brands = [];
        $products = [];
        $keywords = [];
        
        foreach ($hotSearches as $hotSearch) {
            switch ($hotSearch->type) {
                case HotSearch::TYPE_CATEGORY:
                    $item = $hotSearch->items->first();
                    if ($item && $item->category) {
                        $categories[] = [
                            'id' => $item->category->id,
                            'name' => $item->category->name,
                            'image' => $hotSearch->display_image,
                            'url' => route('categories.show', $item->category->id),
                            'hot_search_id' => $hotSearch->id
                        ];
                    }
                    break;
                    
                case HotSearch::TYPE_BRAND:
                    $item = $hotSearch->items->first();
                    if ($item && $item->brand) {
                        $brands[] = [
                            'id' => $item->brand->id,
                            'name' => $item->brand->name,
                            'image' => $hotSearch->display_image,
                            'url' => route('search', ['brand_id' => $item->brand->id]),
                            'hot_search_id' => $hotSearch->id
                        ];
                    }
                    break;
                    
                case HotSearch::TYPE_PRODUCT:
                    $item = $hotSearch->items->first();
                    if ($item && $item->product) {
                        $products[] = [
                            'id' => $item->product->id,
                            'name' => $item->product->name,
                            'price' => $item->product->price,
                            'sale_price' => $item->product->sale_price,
                            'image' => $hotSearch->display_image,
                            'url' => route('products.show', $item->product->slug ?? $item->product->id),
                            'hot_search_id' => $hotSearch->id
                        ];
                    }
                    break;
                    
                case HotSearch::TYPE_KEYWORD:
                    $keywords[] = [
                        'keyword' => $hotSearch->keyword,
                        'title' => $hotSearch->display_title,
                        'image' => $hotSearch->display_image,
                        'url' => route('search', ['q' => $hotSearch->keyword]),
                        'hot_search_id' => $hotSearch->id
                    ];
                    break;
            }
        }
        
        return [
            'categories' => array_slice($categories, 0, 4),
            'brands' => array_slice($brands, 0, 4),
            'products' => array_slice($products, 0, 6),
            'keywords' => array_slice($keywords, 0, 5)
        ];
    }
} 