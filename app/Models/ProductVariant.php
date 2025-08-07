<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductVariant extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'name',
        'code',
        'quantity',
        'price',
        'price_sale',
        'is_active',
        'sort_order'
    ];

    protected $casts = [
        'quantity' => 'integer',
        'price' => 'decimal:2',
        'price_sale' => 'decimal:2',
        'is_active' => 'boolean',
        'sort_order' => 'integer'
    ];

    // Relationships
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeByCode($query, $code)
    {
        return $query->where('code', 'like', "%{$code}%");
    }

    public function scopeByName($query, $name)
    {
        return $query->where('name', 'like', "%{$name}%");
    }

    public function scopeInStock($query)
    {
        return $query->where('quantity', '>', 0);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderBy('name');
    }

    // Accessors
    public function getFinalPriceAttribute()
    {
        return $this->price_sale ?? $this->price;
    }

    public function getDiscountPercentageAttribute()
    {
        if ($this->price_sale && $this->price > $this->price_sale) {
            return round((($this->price - $this->price_sale) / $this->price) * 100);
        }
        return 0;
    }

    public function getIsOnSaleAttribute()
    {
        return $this->price_sale && $this->price_sale < $this->price;
    }

    public function getDisplayNameAttribute()
    {
        return $this->name . ' (' . $this->code . ')';
    }

    public function getIsInStockAttribute()
    {
        return $this->quantity > 0;
    }

    // Methods
    public function generateCode($baseName = '')
    {
        if (empty($this->code)) {
            // Auto-generate code based on name or product
            $base = $baseName ?: ($this->name ?: ($this->product->name ?? 'VAR'));
            $words = explode(' ', $base);
            $code = '';
            
            foreach ($words as $word) {
                $code .= strtoupper(substr($word, 0, 1));
            }
            
            // Add number suffix if needed
            $counter = 1;
            $originalCode = $code;
            while (self::where('product_id', $this->product_id)
                      ->where('code', $code)
                      ->where('id', '!=', $this->id ?? 0)
                      ->exists()) {
                $code = $originalCode . $counter;
                $counter++;
            }
            
            return $code;
        }
        
        return $this->code;
    }

    public function updateStock($quantity, $operation = 'subtract')
    {
        if ($operation === 'subtract') {
            $this->quantity = max(0, $this->quantity - $quantity);
        } else {
            $this->quantity += $quantity;
        }
        
        $this->save();
        
        return $this;
    }

    // Boot method to auto-generate code if empty
    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($variant) {
            if (empty($variant->code)) {
                $variant->code = $variant->generateCode();
            }
        });
    }
}