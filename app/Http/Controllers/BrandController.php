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

    public function show($slug)
    {
        $brand = Brand::where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();

        $products = Product::with(['category', 'brand', 'baseImage'])
            ->where('brand_id', $brand->id)
            ->where('status', true)
            ->paginate(12);

        return view('brands.show', compact('brand', 'products'));
    }

    public function superWin()
    {
        $brand = Brand::where('slug', 'super-win')->first();

        if (!$brand) {
            abort(404, 'Brand not found');
        }

        $products = Product::with(['category', 'brand', 'baseImage'])
            ->where('brand_id', $brand->id)
            ->where('status', true)
            ->paginate(12);

        return view('brands.show', compact('brand', 'products'));
    }

    public function vinaPump()
    {
        $brand = Brand::where('slug', 'vina-pump')->first();

        if (!$brand) {
            abort(404, 'Brand not found');
        }

        $products = Product::with(['category', 'brand', 'baseImage'])
            ->where('brand_id', $brand->id)
            ->where('status', true)
            ->paginate(12);

        return view('brands.show', compact('brand', 'products'));
    }

    public function abc()
    {
        $brand = Brand::where('slug', 'abc')->first();

        if (!$brand) {
            abort(404, 'Brand not found');
        }

        $products = Product::with(['category', 'brand', 'baseImage'])
            ->where('brand_id', $brand->id)
            ->where('status', true)
            ->paginate(12);

        return view('brands.show', compact('brand', 'products'));
    }

    public function superWinFan()
    {
        $brand = Brand::where('slug', 'super-win-fan')->first();

        if (!$brand) {
            // Fallback to Super Win brand if super-win-fan doesn't exist
            $brand = Brand::where('slug', 'super-win')->first();
        }

        if (!$brand) {
            abort(404, 'Brand not found');
        }

        $products = Product::with(['category', 'brand', 'baseImage'])
            ->where('brand_id', $brand->id)
            ->where('status', true)
            ->paginate(12);

        return view('brands.show', compact('brand', 'products'));
    }

    public function deton()
    {
        $brand = Brand::where('slug', 'deton')->first();

        if (!$brand) {
            abort(404, 'Brand not found');
        }

        $products = Product::with(['category', 'brand', 'baseImage'])
            ->where('brand_id', $brand->id)
            ->where('status', true)
            ->paginate(12);

        return view('brands.show', compact('brand', 'products'));
    }

    public function sthc()
    {
        $brand = Brand::where('slug', 'sthc')->first();

        if (!$brand) {
            abort(404, 'Brand not found');
        }

        $products = Product::with(['category', 'brand', 'baseImage'])
            ->where('brand_id', $brand->id)
            ->where('status', true)
            ->paginate(12);

        return view('brands.show', compact('brand', 'products'));
    }

    public function inverter()
    {
        $brand = Brand::where('slug', 'inverter')->first();

        if (!$brand) {
            abort(404, 'Brand not found');
        }

        $products = Product::with(['category', 'brand', 'baseImage'])
            ->where('brand_id', $brand->id)
            ->where('status', true)
            ->paginate(12);

        return view('brands.show', compact('brand', 'products'));
    }

    public function apiList()
    {
        $brands = Brand::where('is_active', true)
            ->select('id', 'name', 'slug', 'image')
            ->get();

        return response()->json($brands);
    }
}
