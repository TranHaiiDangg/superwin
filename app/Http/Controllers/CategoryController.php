<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function show($slug)
    {
        $category = Category::where('slug', $slug)
            ->where('status', true)
            ->with(['children', 'products'])
            ->firstOrFail();

        $products = Product::with(['category', 'brand', 'baseImage'])
            ->where('category_id', $category->id)
            ->where('status', true)
            ->paginate(12);

        return view('categories.show', compact('category', 'products'));
    }

    public function mayBomNuoc()
    {
        $category = Category::where('slug', 'may-bom-nuoc')->first();
        $products = Product::with(['category', 'brand', 'baseImage'])
            ->where('category_id', $category->id)
            ->where('status', true)
            ->paginate(12);

        return view('categories.show', compact('category', 'products'));
    }

    public function quatCongNghiep()
    {
        $category = Category::where('slug', 'quat-cong-nghiep')->first();
        $products = Product::with(['category', 'brand', 'baseImage'])
            ->where('category_id', $category->id)
            ->where('status', true)
            ->paginate(12);

        return view('categories.show', compact('category', 'products'));
    }

    public function quatThongGio()
    {
        $category = Category::where('slug', 'quat-thong-gio')->first();
        $products = Product::with(['category', 'brand', 'baseImage'])
            ->where('category_id', $category->id)
            ->where('status', true)
            ->paginate(12);

        return view('categories.show', compact('category', 'products'));
    }

    public function quatDacBiet()
    {
        $category = Category::where('slug', 'quat-dac-biet')->first();
        $products = Product::with(['category', 'brand', 'baseImage'])
            ->where('category_id', $category->id)
            ->where('status', true)
            ->paginate(12);

        return view('categories.show', compact('category', 'products'));
    }

    public function tamLamMat()
    {
        $category = Category::where('slug', 'tam-lam-mat')->first();
        $products = Product::with(['category', 'brand', 'baseImage'])
            ->where('category_id', $category->id)
            ->where('status', true)
            ->paginate(12);

        return view('categories.show', compact('category', 'products'));
    }
} 