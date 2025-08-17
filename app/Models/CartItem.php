<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
    protected $fillable = ['cart_id', 'product_id', 'quantity', 'price', 'attributes'];

    protected $casts = [
        'attributes' => 'array',
        'price' => 'decimal:2'
    ];

    public function cart()
    {
        return $this->belongsTo(Cart::class, 'cart_id', 'user_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function subtotal()
    {
        return $this->price * $this->quantity;
    }
}
