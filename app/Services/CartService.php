<?php

namespace App\Services;

use App\Models\Product;
use App\Models\Cart;
use App\Models\CartItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartService
{
    protected $cart;

    public function __construct()
    {
        $this->cart = [];
    }

    /**
     * Lấy dữ liệu giỏ hàng từ request (được gửi từ JavaScript localStorage)
     */
    public function getCartFromRequest(Request $request)
    {
        $cartData = $request->input('cart_data', '[]');
        $this->cart = json_decode($cartData, true) ?: [];
        return $this->cart;
    }

    /**
     * Lấy dữ liệu giỏ hàng từ localStorage (được gửi từ JavaScript)
     */
    public function getCartFromLocalStorage($cartData)
    {
        if (is_string($cartData)) {
            $decodedData = json_decode($cartData, true) ?: [];
        } else {
            $decodedData = $cartData ?: [];
        }

        // Chuyển đổi từ array sang associative array với key
        $this->cart = [];
        if (is_array($decodedData)) {
            foreach ($decodedData as $item) {
                if (isset($item['id'])) {
                    // Đảm bảo item luôn có attributes field
                    if (!isset($item['attributes'])) {
                        $item['attributes'] = [];
                    }
                    // Đảm bảo item có sku field
                    if (!isset($item['sku'])) {
                        $item['sku'] = $item['model'] ?? '';
                    }

                    $itemKey = $this->generateItemKey($item['id'], $item['attributes']);
                    $this->cart[$itemKey] = $item;
                }
            }
        }

        return $this->cart;
    }

    public function add(Product $product, $quantity = 1, $attributes = [])
    {
        $cartItem = [
            'id' => $product->id,
            'name' => $product->name,
            'price' => $product->isOnSale ? $product->sale_price : $product->price,
            'quantity' => $quantity,
            'attributes' => $attributes,
            'image' => $product->baseImage ? $product->baseImage->url : '/images/default.png',
            'slug' => $product->slug,
            'sku' => $product->sku ?? '',
        ];

        $itemKey = $this->generateItemKey($product->id, $attributes);

        if (isset($this->cart[$itemKey])) {
            $this->cart[$itemKey]['quantity'] += $quantity;
        } else {
            $this->cart[$itemKey] = $cartItem;
        }

        return $this->cart[$itemKey];
    }

    public function update($itemKey, $quantity)
    {
        if (isset($this->cart[$itemKey])) {
            if ($quantity <= 0) {
                unset($this->cart[$itemKey]);
            } else {
                $this->cart[$itemKey]['quantity'] = $quantity;
            }
            return true;
        }
        return false;
    }

    public function updateQuantity($itemKey, $change)
    {
        if (isset($this->cart[$itemKey])) {
            $newQuantity = $this->cart[$itemKey]['quantity'] + $change;
            if ($newQuantity <= 0) {
                return $this->remove($itemKey);
            } else {
                $this->cart[$itemKey]['quantity'] = $newQuantity;
                return true;
            }
        }
        return false;
    }

    public function remove($itemKey)
    {
        if (isset($this->cart[$itemKey])) {
            unset($this->cart[$itemKey]);
            return true;
        }
        return false;
    }

    public function clear()
    {
        $this->cart = [];
    }

    public function content()
    {
        return collect($this->cart);
    }

    public function count()
    {
        return $this->content()->sum('quantity');
    }

    public function total()
    {
        return $this->content()->sum(function ($item) {
            return $item['price'] * $item['quantity'];
        });
    }

    public function subtotal()
    {
        return $this->total();
    }

    public function getItemByKey($itemKey)
    {
        return $this->cart[$itemKey] ?? null;
    }

    public function hasItems()
    {
        return count($this->cart) > 0;
    }

    public function getCartData()
    {
        return [
            'items' => $this->content(),
            'count' => $this->count(),
            'total' => $this->total(),
            'subtotal' => $this->subtotal(),
        ];
    }

    public function updateByProductId($productId, $quantity)
    {
        foreach ($this->cart as $itemKey => $item) {
            if ($item['id'] == $productId) {
                if ($quantity <= 0) {
                    unset($this->cart[$itemKey]);
                } else {
                    $this->cart[$itemKey]['quantity'] = $quantity;
                }
                return true;
            }
        }
        return false;
    }

    public function removeByProductId($productId)
    {
        foreach ($this->cart as $itemKey => $item) {
            if ($item['id'] == $productId) {
                unset($this->cart[$itemKey]);
                return true;
            }
        }
        return false;
    }

    protected function generateItemKey($productId, $attributes)
    {
        return $productId . '_' . md5(serialize($attributes));
    }

    /**
     * Lưu giỏ hàng vào database nếu user đã đăng nhập
     */
    public function syncToDatabase()
    {
        if (!Auth::guard('customer')->check()) {
            return;
        }

        $customer = Auth::guard('customer')->user();
        $cart = Cart::firstOrCreate(['user_id' => $customer->id]);

        // Xóa các item cũ
        $cart->items()->delete();

        // Thêm các item mới
        foreach ($this->cart as $itemKey => $item) {
            CartItem::create([
                'cart_id' => $customer->id, // Sử dụng customer->id thay vì cart->id
                'product_id' => $item['id'],
                'quantity' => $item['quantity'] ?? 1,
                'price' => $item['price'] ?? 0,
                'attributes' => $item['attributes'] ?? [],
            ]);
        }
    }

    /**
     * Xóa giỏ hàng khỏi database
     */
    public function clearDatabase()
    {
        if (!Auth::guard('customer')->check()) {
            return;
        }

        $customer = Auth::guard('customer')->user();
        $cart = Cart::where('user_id', $customer->id)->first();

        if ($cart) {
            $cart->items()->delete();
            $cart->delete();
        }
    }
}
