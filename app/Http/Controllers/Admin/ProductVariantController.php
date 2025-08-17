<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductVariant;
use Illuminate\Http\Request;

class ProductVariantController extends Controller
{
    public function index(Product $product)
    {
        $variants = $product->variants()->ordered()->get();
        
        return response()->json([
            'success' => true,
            'variants' => $variants
        ]);
    }

    public function store(Request $request, Product $product)
    {
        $validated = $request->validate([
            'variants' => 'required|array|min:1',
            'variants.*.name' => 'required|string|max:255',
            'variants.*.code' => 'required|string|max:50',
            'variants.*.quantity' => 'required|integer|min:0',
            'variants.*.price' => 'required|numeric|min:0',
            'variants.*.price_sale' => 'nullable|numeric|min:0',
            'variants.*.is_active' => 'boolean',
            'variants.*.sort_order' => 'integer|min:0'
        ]);

        try {
            $createdVariants = [];

            foreach ($validated['variants'] as $index => $variantData) {
                // Check for duplicate code
                $existingVariant = $product->variants()
                    ->where('code', $variantData['code'])
                    ->first();

                if ($existingVariant) {
                    return response()->json([
                        'success' => false,
                        'message' => "Biến thể với mã '{$variantData['code']}' đã tồn tại!"
                    ], 422);
                }

                $variantData['product_id'] = $product->id;
                $variantData['is_active'] = $variantData['is_active'] ?? true;
                $variantData['sort_order'] = $variantData['sort_order'] ?? $index;

                $variant = ProductVariant::create($variantData);
                $createdVariants[] = $variant;
            }

            return response()->json([
                'success' => true,
                'message' => count($createdVariants) . ' biến thể đã được tạo thành công!',
                'variants' => $createdVariants
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Lỗi khi tạo biến thể: ' . $e->getMessage()
            ], 500);
        }
    }

    public function update(Request $request, Product $product, ProductVariant $variant)
    {
        // Ensure variant belongs to the product
        if ($variant->product_id !== $product->id) {
            return response()->json([
                'success' => false,
                'message' => 'Biến thể không thuộc về sản phẩm này!'
            ], 403);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:50',
            'quantity' => 'required|integer|min:0',
            'price' => 'required|numeric|min:0',
            'price_sale' => 'nullable|numeric|min:0',
            'is_active' => 'boolean',
            'sort_order' => 'integer|min:0'
        ]);

        try {
            // Check for duplicate code (excluding current variant)
            $existingVariant = $product->variants()
                ->where('id', '!=', $variant->id)
                ->where('code', $validated['code'])
                ->first();

            if ($existingVariant) {
                return response()->json([
                    'success' => false,
                    'message' => "Biến thể với mã '{$validated['code']}' đã tồn tại!"
                ], 422);
            }

            $variant->update($validated);

            return response()->json([
                'success' => true,
                'message' => 'Biến thể đã được cập nhật thành công!',
                'variant' => $variant->fresh()
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Lỗi khi cập nhật biến thể: ' . $e->getMessage()
            ], 500);
        }
    }

    public function destroy(Product $product, ProductVariant $variant)
    {
        // Ensure variant belongs to the product
        if ($variant->product_id !== $product->id) {
            return response()->json([
                'success' => false,
                'message' => 'Biến thể không thuộc về sản phẩm này!'
            ], 403);
        }

        try {
            $variant->delete();

            return response()->json([
                'success' => true,
                'message' => 'Biến thể đã được xóa thành công!'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Lỗi khi xóa biến thể: ' . $e->getMessage()
            ], 500);
        }
    }

    public function bulkUpdate(Request $request, Product $product)
    {
        $validated = $request->validate([
            'variants' => 'required|array|min:1',
            'variants.*.id' => 'nullable|integer|exists:product_variants,id',
            'variants.*.name' => 'required|string|max:255',
            'variants.*.code' => 'required|string|max:50',
            'variants.*.quantity' => 'required|integer|min:0',
            'variants.*.price' => 'required|numeric|min:0',
            'variants.*.price_sale' => 'nullable|numeric|min:0',
            'variants.*.is_active' => 'boolean',
            'variants.*.sort_order' => 'integer|min:0'
        ]);

        try {
            $updatedVariants = [];
            $createdVariants = [];

            foreach ($validated['variants'] as $index => $variantData) {
                $variantData['product_id'] = $product->id;
                $variantData['is_active'] = $variantData['is_active'] ?? true;
                $variantData['sort_order'] = $variantData['sort_order'] ?? $index;

                if (isset($variantData['id']) && $variantData['id']) {
                    // Update existing variant
                    $variant = ProductVariant::where('id', $variantData['id'])
                        ->where('product_id', $product->id)
                        ->first();

                    if ($variant) {
                        $variant->update($variantData);
                        $updatedVariants[] = $variant;
                    }
                } else {
                    // Create new variant
                    unset($variantData['id']);
                    
                    // Check for duplicate code
                    $existingVariant = $product->variants()
                        ->where('code', $variantData['code'])
                        ->first();

                    if (!$existingVariant) {
                        $variant = ProductVariant::create($variantData);
                        $createdVariants[] = $variant;
                    }
                }
            }

            return response()->json([
                'success' => true,
                'message' => 'Biến thể đã được cập nhật thành công!',
                'updated_count' => count($updatedVariants),
                'created_count' => count($createdVariants),
                'variants' => $product->variants()->ordered()->get()
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Lỗi khi cập nhật biến thể: ' . $e->getMessage()
            ], 500);
        }
    }

    public function toggleStatus(Product $product, ProductVariant $variant)
    {
        // Ensure variant belongs to the product
        if ($variant->product_id !== $product->id) {
            return response()->json([
                'success' => false,
                'message' => 'Biến thể không thuộc về sản phẩm này!'
            ], 403);
        }

        try {
            $variant->update(['is_active' => !$variant->is_active]);

            return response()->json([
                'success' => true,
                'message' => 'Trạng thái biến thể đã được cập nhật!',
                'variant' => $variant->fresh()
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Lỗi khi cập nhật trạng thái: ' . $e->getMessage()
            ], 500);
        }
    }
}