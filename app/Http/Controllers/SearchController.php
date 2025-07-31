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
        $query = $request->get('q', '');
        
        if (empty($query)) {
            return redirect()->route('home');
        }

        $products = Product::with(['category', 'brand', 'baseImage'])
            ->where('status', true)
            ->where(function($q) use ($query) {
                $q->where('name', 'like', "%{$query}%")
                  ->orWhere('description', 'like', "%{$query}%")
                  ->orWhere('short_description', 'like', "%{$query}%")
                  ->orWhere('sku', 'like', "%{$query}%");
            })
            ->paginate(12);

        $categories = Category::active()->get();
        $brands = Brand::active()->get();

        return view('search.index', compact('products', 'categories', 'brands', 'query'));
    }

    public function suggestions(Request $request)
    {
        $query = $request->get('q', '');
        
        if (strlen($query) < 2) {
            return response()->json([]);
        }

        $suggestions = Product::where('status', true)
            ->where('name', 'like', "%{$query}%")
            ->select('name', 'slug')
            ->limit(5)
            ->get();

        return response()->json($suggestions);
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
} 