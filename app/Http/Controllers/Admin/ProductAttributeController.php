<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProductAttribute;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductAttributeController extends Controller
{
    public function index()
    {
        $attributes = ProductAttribute::with('product')
            ->ordered()
            ->paginate(20);

        return view('admin.product-attributes.index', compact('attributes'));
    }

    public function create()
    {
        $products = Product::active()->get();
        $commonKeys = ProductAttribute::getCommonAttributeKeys();
        $commonUnits = ProductAttribute::getCommonUnits();

        return view('admin.product-attributes.create', compact('products', 'commonKeys', 'commonUnits'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'attribute_key' => 'required|string|max:100',
            'attribute_value' => 'nullable|string|max:255',
            'attribute_unit' => 'nullable|string|max:50',
            'attribute_description' => 'nullable|string',
            'sort_order' => 'integer|min:0',
            'is_visible' => 'boolean'
        ]);

        $validated['is_visible'] = $request->has('is_visible');

        ProductAttribute::create($validated);

        return redirect()->route('admin.product-attributes.index')
            ->with('success', 'Thuộc tính sản phẩm đã được tạo thành công!');
    }

    public function show(ProductAttribute $productAttribute)
    {
        $productAttribute->load('product');
        return view('admin.product-attributes.show', compact('productAttribute'));
    }

    public function edit(ProductAttribute $productAttribute)
    {
        $products = Product::active()->get();
        $commonKeys = ProductAttribute::getCommonAttributeKeys();
        $commonUnits = ProductAttribute::getCommonUnits();

        return view('admin.product-attributes.edit', compact('productAttribute', 'products', 'commonKeys', 'commonUnits'));
    }

    public function update(Request $request, ProductAttribute $productAttribute)
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'attribute_key' => 'required|string|max:100',
            'attribute_value' => 'nullable|string|max:255',
            'attribute_unit' => 'nullable|string|max:50',
            'attribute_description' => 'nullable|string',
            'sort_order' => 'integer|min:0',
            'is_visible' => 'boolean'
        ]);

        $validated['is_visible'] = $request->has('is_visible');

        $productAttribute->update($validated);

        return redirect()->route('admin.product-attributes.index')
            ->with('success', 'Thuộc tính sản phẩm đã được cập nhật thành công!');
    }

    public function destroy(ProductAttribute $productAttribute)
    {
        $productAttribute->update(['is_visible' => false]);

        return redirect()->route('admin.product-attributes.index')
            ->with('success', 'Thuộc tính sản phẩm đã được ẩn thành công!');
    }

    public function restore(ProductAttribute $productAttribute)
    {
        $productAttribute->update(['is_visible' => true]);

        return redirect()->route('admin.product-attributes.index')
            ->with('success', 'Thuộc tính sản phẩm đã được hiển thị lại thành công!');
    }

    // API methods for product forms
    public function getByProduct(Product $product)
    {
        $attributes = $product->attributes()->ordered()->get();
        return response()->json($attributes);
    }

    public function storeForProduct(Request $request, Product $product)
    {
        $validated = $request->validate([
            'attributes' => 'array',
            'attributes.*.attribute_key' => 'required|string|max:100',
            'attributes.*.attribute_value' => 'nullable|string|max:255',
            'attributes.*.attribute_unit' => 'nullable|string|max:50',
            'attributes.*.attribute_description' => 'nullable|string',
            'attributes.*.sort_order' => 'integer|min:0',
            'attributes.*.is_visible' => 'boolean'
        ]);

        // Delete existing attributes
        $product->attributes()->delete();

        // Create new attributes
        foreach ($validated['attributes'] as $index => $attributeData) {
            $attributeData['product_id'] = $product->id;
            $attributeData['sort_order'] = $attributeData['sort_order'] ?? $index;
            $attributeData['is_visible'] = $attributeData['is_visible'] ?? true;
            
            ProductAttribute::create($attributeData);
        }

        return response()->json([
            'success' => true,
            'message' => 'Thuộc tính sản phẩm đã được cập nhật thành công!'
        ]);
    }
}
