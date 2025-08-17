<?php

namespace App\Http\Controllers;

use App\Services\CartService;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CartController extends Controller
{
    protected $cartService;

    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }

    public function index()
    {
        // Không cần lấy dữ liệu từ CartService nữa vì sẽ được xử lý bởi JavaScript
        return view('cart.index');
    }

    public function add(Request $request, Product $product)
    {
        $validator = Validator::make($request->all(), [
            'quantity' => 'required|integer|min:1|max:99',
            'attributes' => 'array'
        ]);

        if ($validator->fails()) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Dữ liệu không hợp lệ',
                    'errors' => $validator->errors()
                ], 422);
            }
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $quantity = $request->input('quantity', 1);
        $attributes = $request->input('attributes', []);

        try {
            $cartItem = $this->cartService->add($product, $quantity, $attributes);

            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Sản phẩm đã được thêm vào giỏ hàng',
                    'cartItem' => $cartItem,
                    'cartData' => $this->cartService->getCartData()
                ]);
            }

            return redirect()->back()->with('success', 'Sản phẩm đã được thêm vào giỏ hàng');
        } catch (\Exception $e) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Có lỗi xảy ra khi thêm sản phẩm vào giỏ hàng'
                ], 500);
            }
            return redirect()->back()->with('error', 'Có lỗi xảy ra khi thêm sản phẩm vào giỏ hàng');
        }
    }

    public function update(Request $request, $itemKey)
    {
        $validator = Validator::make($request->all(), [
            'quantity' => 'required|integer|min:1|max:99'
        ]);

        if ($validator->fails()) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Số lượng không hợp lệ'
                ], 422);
            }
            return redirect()->back()->with('error', 'Số lượng không hợp lệ');
        }

        $quantity = $request->input('quantity');
        $result = $this->cartService->update($itemKey, $quantity);

        if ($result) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Giỏ hàng đã được cập nhật',
                    'cartData' => $this->cartService->getCartData()
                ]);
            }
            return redirect()->back()->with('success', 'Giỏ hàng đã được cập nhật');
        }

        if ($request->ajax()) {
            return response()->json([
                'success' => false,
                'message' => 'Không tìm thấy sản phẩm trong giỏ hàng'
            ], 404);
        }
        return redirect()->back()->with('error', 'Không tìm thấy sản phẩm trong giỏ hàng');
    }

    public function updateQuantity(Request $request, $itemKey)
    {
        $validator = Validator::make($request->all(), [
            'change' => 'required|integer|between:-10,10'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Dữ liệu không hợp lệ'
            ], 422);
        }

        $change = $request->input('change');
        $result = $this->cartService->updateQuantity($itemKey, $change);

        if ($result) {
            return response()->json([
                'success' => true,
                'message' => 'Số lượng đã được cập nhật',
                'cartData' => $this->cartService->getCartData()
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Không thể cập nhật số lượng'
        ], 400);
    }

    public function remove($itemKey)
    {
        $result = $this->cartService->remove($itemKey);

        if ($result) {
            if (request()->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Sản phẩm đã được xóa khỏi giỏ hàng',
                    'cartData' => $this->cartService->getCartData()
                ]);
            }
            return redirect()->back()->with('success', 'Sản phẩm đã được xóa khỏi giỏ hàng');
        }

        if (request()->ajax()) {
            return response()->json([
                'success' => false,
                'message' => 'Không tìm thấy sản phẩm trong giỏ hàng'
            ], 404);
        }
        return redirect()->back()->with('error', 'Không tìm thấy sản phẩm trong giỏ hàng');
    }

    public function clear()
    {
        $this->cartService->clear();

        if (request()->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Giỏ hàng đã được xóa',
                'cartData' => $this->cartService->getCartData()
            ]);
        }

        return redirect()->back()->with('success', 'Giỏ hàng đã được xóa');
    }

    public function count()
    {
        return response()->json([
            'count' => $this->cartService->count()
        ]);
    }

    public function getCartData()
    {
        return response()->json([
            'success' => true,
            'data' => $this->cartService->getCartData()
        ]);
    }

    // API methods for localStorage cart
    public function apiCount()
    {
        return response()->json([
            'count' => $this->cartService->count()
        ]);
    }

    public function apiAdd(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'product_id' => 'required|exists:products,id',
            'quantity' => 'integer|min:1|max:99'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Dữ liệu không hợp lệ',
                'errors' => $validator->errors()
            ], 422);
        }

        $product = Product::findOrFail($request->product_id);
        $quantity = $request->input('quantity', 1);

        try {
            $cartItem = $this->cartService->add($product, $quantity);
            return response()->json([
                'success' => true,
                'message' => 'Sản phẩm đã được thêm vào giỏ hàng',
                'cartItem' => $cartItem,
                'cartData' => $this->cartService->getCartData()
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra khi thêm sản phẩm vào giỏ hàng'
            ], 500);
        }
    }

    public function apiUpdate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1|max:99'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Dữ liệu không hợp lệ'
            ], 422);
        }

        $productId = $request->product_id;
        $quantity = $request->quantity;

        try {
            $result = $this->cartService->updateByProductId($productId, $quantity);
            if ($result) {
                return response()->json([
                    'success' => true,
                    'message' => 'Giỏ hàng đã được cập nhật',
                    'cartData' => $this->cartService->getCartData()
                ]);
            }
            return response()->json([
                'success' => false,
                'message' => 'Không tìm thấy sản phẩm trong giỏ hàng'
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra khi cập nhật giỏ hàng'
            ], 500);
        }
    }

    public function apiRemove(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'product_id' => 'required|exists:products,id'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Dữ liệu không hợp lệ'
            ], 422);
        }

        $productId = $request->product_id;

        try {
            $result = $this->cartService->removeByProductId($productId);
            if ($result) {
                return response()->json([
                    'success' => true,
                    'message' => 'Sản phẩm đã được xóa khỏi giỏ hàng',
                    'cartData' => $this->cartService->getCartData()
                ]);
            }
            return response()->json([
                'success' => false,
                'message' => 'Không tìm thấy sản phẩm trong giỏ hàng'
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra khi xóa sản phẩm'
            ], 500);
        }
    }
}
