<?php

namespace App\Services;

use App\Models\Product;
use App\Models\Cart;
use App\Models\CartItem;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class CartService
{
    protected $cart;

    public function __construct()
    {
        $this->cart = Session::get('cart', []);
        $this->loadFromDatabase();
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

        $this->save();

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
            $this->save();
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
                $this->save();
                return true;
            }
        }
        return false;
    }

    public function remove($itemKey)
    {
        if (isset($this->cart[$itemKey])) {
            unset($this->cart[$itemKey]);
            $this->save();
            return true;
        }
        return false;
    }

    public function clear()
    {
        $this->cart = [];
        $this->save();

        // Xóa cả trong database nếu user đã đăng nhập
        if (Auth::guard('customer')->check()) {
            $this->clearDatabase();
        }
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
                $this->save();
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
                $this->save();
                return true;
            }
        }
        return false;
    }

    protected function save()
    {
        Session::put('cart', $this->cart);

        // Nếu user đã đăng nhập, lưu giỏ hàng vào database
        if (Auth::guard('customer')->check()) {
            $this->syncToDatabase();
        }
    }

    protected function generateItemKey($productId, $attributes)
    {
        return $productId . '_' . md5(serialize($attributes));
    }

    protected function loadFromDatabase()
    {
        if (Auth::guard('customer')->check()) {
            $customer = Auth::guard('customer')->user();
            $cart = Cart::where('user_id', $customer->id)->first();

            if ($cart && $cart->items->count() > 0) {
                $dbCart = [];
                foreach ($cart->items as $item) {
                    $itemKey = $this->generateItemKey($item->product_id, $item->attributes ?: []);
                    $dbCart[$itemKey] = [
                        'id' => $item->product_id,
                        'name' => $item->product->name,
                        'price' => $item->price,
                        'quantity' => $item->quantity,
                        'attributes' => $item->attributes ?: [],
                        'image' => $item->product->baseImage ? $item->product->baseImage->url : '/images/default.png',
                        'slug' => $item->product->slug,
                        'sku' => $item->product->sku ?? '',
                    ];
                }

                // Merge với cart trong session, ưu tiên session cart
                $this->cart = array_merge($dbCart, $this->cart);
                Session::put('cart', $this->cart);
            }
        }
    }

    protected function syncToDatabase()
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
                'cart_id' => $cart->id,
                'product_id' => $item['id'],
                'quantity' => $item['quantity'],
                'price' => $item['price'],
                'attributes' => $item['attributes'],
            ]);
        }
    }

    protected function clearDatabase()
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
