<?php

namespace App\Http\Controllers;

use App\Services\CartService;
use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    protected $cartService;

    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
        $this->middleware('auth:customer')->except(['index']);
    }

    public function index()
    {
        $cart = $this->cartService->content();
        return view('cart.index', compact('cart'));
    }

    public function add(Request $request, Product $product)
    {
        $quantity = $request->input('quantity', 1);
        $attributes = $request->input('attributes', []);

        $cartItem = $this->cartService->add($product, $quantity, $attributes);

        if ($request->ajax()) {
            return response()->json([
                'message' => 'Sản phẩm đã được thêm vào giỏ hàng',
                'cartItem' => $cartItem,
                'cartCount' => $this->cartService->count(),
                'cartTotal' => $this->cartService->total()
            ]);
        }

        return redirect()->back()->with('success', 'Sản phẩm đã được thêm vào giỏ hàng');
    }

    public function update(Request $request, $itemKey)
    {
        $quantity = $request->input('quantity');
        $this->cartService->update($itemKey, $quantity);

        if ($request->ajax()) {
            return response()->json([
                'message' => 'Giỏ hàng đã được cập nhật',
                'cartCount' => $this->cartService->count(),
                'cartTotal' => $this->cartService->total()
            ]);
        }

        return redirect()->back()->with('success', 'Giỏ hàng đã được cập nhật');
    }

    public function remove($itemKey)
    {
        $this->cartService->remove($itemKey);

        if (request()->ajax()) {
            return response()->json([
                'message' => 'Sản phẩm đã được xóa khỏi giỏ hàng',
                'cartCount' => $this->cartService->count(),
                'cartTotal' => $this->cartService->total()
            ]);
        }

        return redirect()->back()->with('success', 'Sản phẩm đã được xóa khỏi giỏ hàng');
    }

    public function clear()
    {
        $this->cartService->clear();

        if (request()->ajax()) {
            return response()->json([
                'message' => 'Giỏ hàng đã được xóa',
                'cartCount' => 0,
                'cartTotal' => 0
            ]);
        }

        return redirect()->back()->with('success', 'Giỏ hàng đã được xóa');
    }
}
