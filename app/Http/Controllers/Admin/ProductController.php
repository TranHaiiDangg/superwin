<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\Category;
use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with([
            'category', 
            'brand', 
            'images' => function($query) {
                $query->orderBy('sort_order')->orderBy('id');
            }, 
            'baseImage'
        ]);

        // Search filter
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('sku', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // Category filter
        if ($request->filled('category_id')) {
            $categoryId = (int) $request->category_id;
            $query->where('category_id', $categoryId);
        }

        // Brand filter
        if ($request->filled('brand_id')) {
            $query->where('brand_id', $request->brand_id);
        }

        // Status filter
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Featured filter
        if ($request->filled('is_featured')) {
            $query->where('is_featured', $request->is_featured);
        }

        // Sale filter
        if ($request->filled('is_sale')) {
            $query->where('is_sale', $request->is_sale);
        }



        $products = $query->latest()->paginate(20)->withQueryString();

        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        $categories = Category::active()->get();
        $brands = Brand::active()->get();

        return view('admin.products.create', compact('categories', 'brands'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'brand_id' => 'required|exists:brands,id',

            'description' => 'nullable|string',
            'short_description' => 'nullable|string|max:500',
            'price' => 'required|numeric|min:0',
            'sale_price' => 'nullable|numeric|min:0',
            'sku' => 'nullable|string|unique:products,sku',
            'stock_quantity' => 'required|integer|min:0',
            'min_stock_level' => 'required|integer|min:0',
            'weight' => 'nullable|numeric|min:0',
            'status' => 'boolean',
            'is_featured' => 'boolean',
            'is_sale' => 'boolean',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string',
            'meta_keywords' => 'nullable|string|max:500',
            'meta_robots' => 'nullable|string|max:100',
            'meta_author' => 'nullable|string|max:255',
            'meta_canonical_url' => 'nullable|url|max:500',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'attributes' => 'array',
            'attributes.*.attribute_key' => 'required|string|max:100',
            'attributes.*.attribute_value' => 'nullable|string|max:255',
            'attributes.*.attribute_unit' => 'nullable|string|max:50',
            'attributes.*.attribute_description' => 'nullable|string',
            'attributes.*.sort_order' => 'integer|min:0',
            'attributes.*.is_visible' => 'boolean',
            'variants' => 'nullable|array',
            'variants.*.name' => 'nullable|string|max:255',
            'variants.*.code' => 'nullable|string|max:50',
            'variants.*.quantity' => 'nullable|integer|min:0',
            'variants.*.price' => 'nullable|numeric|min:0',
            'variants.*.price_sale' => 'nullable|numeric|min:0',
            'variants.*.is_active' => 'nullable|boolean',
            'variants.*.sort_order' => 'nullable|integer|min:0'
        ]);

        $validated['slug'] = Str::slug($validated['name']);
        $validated['status'] = $request->has('status');
        $validated['is_featured'] = $request->has('is_featured');
        $validated['is_sale'] = $request->has('is_sale');

        // Auto-generate SKU if empty
        if (empty($validated['sku'])) {
            $validated['sku'] = Product::generateSKU(
                $validated['category_id'], 
                $validated['brand_id']
            );
        }

        // Create product (exclude images, attributes and variants from mass assignment)
        $product = Product::create(collect($validated)->except(['attributes', 'images', 'variants'])->toArray());

        // Handle image uploads
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $index => $image) {
                $filename = time() . '_' . $index . '_' . $image->getClientOriginalName();
                
                // Save directly to public/images/products/
                $destinationPath = public_path('images/products');
                if (!file_exists($destinationPath)) {
                    mkdir($destinationPath, 0755, true);
                }
                
                $image->move($destinationPath, $filename);
                
                $product->images()->create([
                    'url' => '/images/products/' . $filename,
                    'alt_text' => $product->name,
                    'sort_order' => $index + 1,
                    'is_base' => $index === 0 // First image becomes base
                ]);
            }
        }

        // Handle attributes
        if (isset($validated['attributes'])) {
            foreach ($validated['attributes'] as $index => $attributeData) {
                if (!empty($attributeData['attribute_key'])) {
                    $attributeData['product_id'] = $product->id;
                    $attributeData['sort_order'] = $attributeData['sort_order'] ?? $index;
                    $attributeData['is_visible'] = $attributeData['is_visible'] ?? true;
                    
                    \App\Models\ProductAttribute::create($attributeData);
                }
            }
        }

        // Handle variants
        if (isset($validated['variants'])) {
            foreach ($validated['variants'] as $index => $variantData) {
                if (!empty($variantData['name']) && !empty($variantData['code'])) {
                    $variantData['product_id'] = $product->id;
                    $variantData['sort_order'] = $variantData['sort_order'] ?? $index;
                    $variantData['is_active'] = $variantData['is_active'] ?? true;
                    
                    ProductVariant::create($variantData);
                }
            }
        }

        return redirect()->route('admin.products.index')
            ->with('success', 'Sản phẩm đã được tạo thành công!');
    }

    public function edit(Product $product)
    {
        $categories = Category::active()->get();
        $brands = Brand::active()->get();

        return view('admin.products.edit', compact('product', 'categories', 'brands'));
    }

    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'brand_id' => 'required|exists:brands,id',

            'description' => 'nullable|string',
            'short_description' => 'nullable|string|max:500',
            'price' => 'required|numeric|min:0',
            'sale_price' => 'nullable|numeric|min:0',
            'sku' => 'nullable|string|unique:products,sku,' . $product->id,
            'stock_quantity' => 'required|integer|min:0',
            'min_stock_level' => 'required|integer|min:0',
            'weight' => 'nullable|numeric|min:0',
            'status' => 'boolean',
            'is_featured' => 'boolean',
            'is_sale' => 'boolean',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string',
            'meta_keywords' => 'nullable|string|max:500',
            'meta_robots' => 'nullable|string|max:100',
            'meta_author' => 'nullable|string|max:255',
            'meta_canonical_url' => 'nullable|url|max:500',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'attributes' => 'array',
            'attributes.*.attribute_key' => 'required|string|max:100',
            'attributes.*.attribute_value' => 'nullable|string|max:255',
            'attributes.*.attribute_unit' => 'nullable|string|max:50',
            'attributes.*.attribute_description' => 'nullable|string',
            'attributes.*.sort_order' => 'integer|min:0',
            'attributes.*.is_visible' => 'boolean'
        ]);

        $validated['slug'] = Str::slug($validated['name']);
        $validated['status'] = $request->has('status');
        $validated['is_featured'] = $request->has('is_featured');
        $validated['is_sale'] = $request->has('is_sale');

        // Auto-generate SKU if empty
        if (empty($validated['sku'])) {
            $validated['sku'] = $product->generateUniqueSKU();
        }

        // Update product basic info (exclude images and attributes)
        $product->update(collect($validated)->except(['attributes', 'images'])->toArray());

        // Handle new image uploads
        if ($request->hasFile('images')) {
            $currentImageCount = $product->images()->count();
            foreach ($request->file('images') as $index => $image) {
                $filename = time() . '_' . ($currentImageCount + $index) . '_' . $image->getClientOriginalName();
                
                // Save directly to public/images/products/
                $destinationPath = public_path('images/products');
                if (!file_exists($destinationPath)) {
                    mkdir($destinationPath, 0755, true);
                }
                
                $image->move($destinationPath, $filename);
                
                $product->images()->create([
                    'url' => '/images/products/' . $filename,
                    'alt_text' => $product->name,
                    'sort_order' => $currentImageCount + $index + 1,
                    'is_base' => $currentImageCount === 0 && $index === 0 // First image becomes base if no existing images
                ]);
            }
        }

        // Update attributes
        if (isset($validated['attributes'])) {
            // Delete existing attributes
            $product->attributes()->delete();

            // Create new attributes
            foreach ($validated['attributes'] as $index => $attributeData) {
                if (!empty($attributeData['attribute_key'])) {
                    $attributeData['product_id'] = $product->id;
                    $attributeData['sort_order'] = $attributeData['sort_order'] ?? $index;
                    $attributeData['is_visible'] = $attributeData['is_visible'] ?? true;
                    
                    \App\Models\ProductAttribute::create($attributeData);
                }
            }
        }

        return redirect()->route('admin.products.index')
            ->with('success', 'Sản phẩm đã được cập nhật thành công!');
    }

    public function destroy(Product $product)
    {
        $product->update(['status' => 0]);

        return redirect()->route('admin.products.index')
        ->with('success', 'Sản phẩm đã được vô hiệu hóa thành công!');
    }

    public function restore(Product $product)
    {
        $product->update(['status' => 1]);

        return redirect()->route('admin.products.index')
            ->with('success', 'Sản phẩm đã được kích hoạt lại thành công!');
    }

    public function uploadImages(Request $request, Product $product)
    {
        $request->validate([
            'images.*' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        try {
            $uploadedImages = [];
            
            foreach ($request->file('images') as $image) {
                $filename = time() . '_' . $image->getClientOriginalName();
                
                // Save directly to public/images/products/
                $destinationPath = public_path('images/products');
                if (!file_exists($destinationPath)) {
                    mkdir($destinationPath, 0755, true);
                }
                
                $image->move($destinationPath, $filename);
                
                $productImage = $product->images()->create([
                    'url' => '/images/products/' . $filename,
                    'alt_text' => $product->name,
                    'sort_order' => $product->images()->count() + 1,
                    'is_base' => $product->images()->count() === 0 // First image becomes base
                ]);
                
                $uploadedImages[] = $productImage;
            }

            return response()->json([
                'success' => true,
                'message' => count($uploadedImages) . ' hình ảnh đã được tải lên thành công!',
                'images' => $uploadedImages
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Lỗi khi tải lên hình ảnh: ' . $e->getMessage()
            ], 500);
        }
    }

    public function setBaseImage(Request $request, Product $product)
    {
        $request->validate([
            'image_id' => 'required|exists:product_images,id'
        ]);

        try {
            $image = $product->images()->findOrFail($request->image_id);
            $image->setAsBase();

            return response()->json([
                'success' => true,
                'message' => 'Đã đặt ảnh làm ảnh chính!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Lỗi: ' . $e->getMessage()
            ], 500);
        }
    }

    public function deleteImage(Request $request, Product $product)
    {
        $request->validate([
            'image_id' => 'required|exists:product_images,id'
        ]);

        try {
            $image = $product->images()->findOrFail($request->image_id);
            
            // Don't delete if it's the only image
            if ($product->images()->count() <= 1) {
                return response()->json([
                    'success' => false,
                    'message' => 'Không thể xóa ảnh cuối cùng!'
                ], 400);
            }

            // If deleting base image, set another as base
            if ($image->is_base) {
                $nextImage = $product->images()->where('id', '!=', $image->id)->first();
                if ($nextImage) {
                    $nextImage->setAsBase();
                }
            }

            $image->delete();

            return response()->json([
                'success' => true,
                'message' => 'Đã xóa ảnh thành công!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Lỗi: ' . $e->getMessage()
            ], 500);
        }
    }

    public function generateSKU(Request $request)
    {
        $request->validate([
            'category_id' => 'nullable|exists:categories,id',
            'brand_id' => 'nullable|exists:brands,id'
        ]);

        $sku = Product::generateSKU(
            $request->category_id,
            $request->brand_id
        );

        return response()->json([
            'success' => true,
            'sku' => $sku
        ]);
    }
} 