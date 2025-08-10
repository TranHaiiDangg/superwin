<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $query = Category::root() // Chỉ lấy danh mục cha (parent_id = null)
            ->withCount(['products', 'children']); // Đếm cả sản phẩm và danh mục con

        // Filter by status if requested
        if (request('status') !== null && request('status') !== '') {
            $query->where('is_active', request('status'));
        }

        $categories = $query->orderBy('sort_order')->paginate(20);

        return view('admin.categories.index', compact('categories'));
    }

    public function show(Category $category)
    {
        $category->load(['children.products', 'products']);
        $category->loadCount(['products', 'children']);
        
        return view('admin.categories.show', compact('category'));
    }

    public function create()
    {
        $categories = Category::active()->get();
        return view('admin.categories.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'parent_id' => 'nullable|exists:categories,id',
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
            
            // Save directly to public/images/categories/
            $destinationPath = public_path('images/categories');
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0755, true);
            }
            
            $image->move($destinationPath, $filename);
            $validated['image'] = '/images/categories/' . $filename;
        }

        Category::create($validated);

        return redirect()->route('admin.categories.index')
            ->with('success', 'Danh mục đã được tạo thành công!');
    }

    public function edit(Category $category)
    {
        $categories = Category::where('id', '!=', $category->id)->active()->get();
        return view('admin.categories.edit', compact('category', 'categories'));
    }

    public function update(Request $request, Category $category)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'parent_id' => 'nullable|exists:categories,id',
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
            if ($category->image && file_exists(public_path($category->image))) {
                unlink(public_path($category->image));
            }
        }
        // Handle new image upload
        elseif ($request->hasFile('image')) {
            // Delete old image file if exists
            if ($category->image && file_exists(public_path($category->image))) {
                unlink(public_path($category->image));
            }
            
            $image = $request->file('image');
            $filename = time() . '_' . $image->getClientOriginalName();
            
            // Save directly to public/images/categories/
            $destinationPath = public_path('images/categories');
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0755, true);
            }
            
            $image->move($destinationPath, $filename);
            $validated['image'] = '/images/categories/' . $filename;
        }

        $category->update($validated);

        return redirect()->route('admin.categories.index')
            ->with('success', 'Danh mục đã được cập nhật thành công!');
    }

    public function destroy(Category $category)
    {
        // Check if category has active children
        if ($category->children()->where('is_active', true)->count() > 0) {
            return back()->with('error', 'Không thể vô hiệu hóa danh mục có danh mục con đang hoạt động!');
        }

        // Check if category has active products
        if ($category->products()->where('status', true)->count() > 0) {
            return back()->with('error', 'Không thể vô hiệu hóa danh mục có sản phẩm đang hoạt động!');
        }

        $category->update(['is_active' => false]);

        return redirect()->route('admin.categories.index')
            ->with('success', 'Danh mục đã được vô hiệu hóa thành công!');
    }

    public function restore(Category $category)
    {
        $category->update(['is_active' => true]);

        return redirect()->route('admin.categories.index')
            ->with('success', 'Danh mục đã được kích hoạt lại thành công!');
    }
} 