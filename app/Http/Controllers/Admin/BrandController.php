<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class BrandController extends Controller
{
    public function index()
    {
        $query = Brand::withCount('products');

        // Filter by status if requested
        if (request('status') !== null && request('status') !== '') {
            $query->where('is_active', request('status'));
        }

        $brands = $query->orderBy('sort_order')->paginate(20);

        return view('admin.brands.index', compact('brands'));
    }

    public function create()
    {
        return view('admin.brands.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'description' => 'nullable|string',
            'sort_order' => 'nullable|integer|min:0',
            'is_active' => 'boolean',
        ]);

        $validated['is_active'] = $request->has('is_active');

        // Handle image upload
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $filename = time() . '_' . $image->getClientOriginalName();
            
            // Save directly to public/images/brands/
            $destinationPath = public_path('images/brands');
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0755, true);
            }
            
            $image->move($destinationPath, $filename);
            $validated['image'] = '/images/brands/' . $filename;
        }

        Brand::create($validated);

        return redirect()->route('admin.brands.index')
            ->with('success', 'Thương hiệu đã được tạo thành công!');
    }

    public function edit(Brand $brand)
    {
        $brand->loadCount('products');
        return view('admin.brands.edit', compact('brand'));
    }

    public function update(Request $request, Brand $brand)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'description' => 'nullable|string',
            'sort_order' => 'nullable|integer|min:0',
            'is_active' => 'boolean',
            'remove_image' => 'nullable|boolean',
        ]);

        $validated['is_active'] = $request->has('is_active');

        // Handle image removal
        if ($request->has('remove_image') && $request->remove_image) {
            $validated['image'] = null;
            // Delete old image file if exists
            if ($brand->image && file_exists(public_path($brand->image))) {
                unlink(public_path($brand->image));
            }
        }
        // Handle new image upload
        elseif ($request->hasFile('image')) {
            // Delete old image file if exists
            if ($brand->image && file_exists(public_path($brand->image))) {
                unlink(public_path($brand->image));
            }
            
            $image = $request->file('image');
            $filename = time() . '_' . $image->getClientOriginalName();
            
            // Save directly to public/images/brands/
            $destinationPath = public_path('images/brands');
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0755, true);
            }
            
            $image->move($destinationPath, $filename);
            $validated['image'] = '/images/brands/' . $filename;
        }

        $brand->update($validated);

        return redirect()->route('admin.brands.index')
            ->with('success', 'Thương hiệu đã được cập nhật thành công!');
    }

    public function destroy(Brand $brand)
    {
        // Check if brand has active products
        if ($brand->products()->where('status', true)->count() > 0) {
            return back()->with('error', 'Không thể vô hiệu hóa thương hiệu có sản phẩm đang hoạt động!');
        }

        $brand->update(['is_active' => false]);

        return redirect()->route('admin.brands.index')
            ->with('success', 'Thương hiệu đã được vô hiệu hóa thành công!');
    }

    public function restore(Brand $brand)
    {
        $brand->update(['is_active' => true]);

        return redirect()->route('admin.brands.index')
            ->with('success', 'Thương hiệu đã được kích hoạt lại thành công!');
    }
} 