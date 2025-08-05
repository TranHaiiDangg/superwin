<?php

namespace App\Services;

use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class CartService
{
    protected $cart;

    public function __construct()
    {
        $this->cart = Session::get('cart', []);
    }

    public function add(Product $product, $quantity = 1, $attributes = [])
    {
        $cartItem = [
            'id' => $product->id,
            'name' => $product->name,
            'price' => $product->isOnSale ? $product->sale_price : $product->price,
            'quantity' => $quantity,
            'attributes' => $attributes,
            'image' => $product->baseImage ? $product->baseImage->url : '/image/default.png',
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
        }
    }

    public function remove($itemKey)
    {
        if (isset($this->cart[$itemKey])) {
            unset($this->cart[$itemKey]);
            $this->save();
        }
    }

    public function clear()
    {
        $this->cart = [];
        $this->save();
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

    protected function save()
    {
        Session::put('cart', $this->cart);

        // Nếu user đã đăng nhập, lưu giỏ hàng vào database
        if (Auth::check()) {
            $this->syncToDatabase();
        }
    }

    protected function generateItemKey($productId, $attributes)
    {
        return $productId . '_' . md5(serialize($attributes));
    }

    protected function syncToDatabase()
    {
        // TODO: Implement database sync
        // Sẽ thêm logic này sau khi tạo migration và model
    }
}
