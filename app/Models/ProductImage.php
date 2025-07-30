<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductImage extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'url',
        'alt_text',
        'sort_order',
        'is_primary',
        'is_base'
    ];

    protected $casts = [
        'is_primary' => 'boolean',
        'is_base' => 'boolean',
        'sort_order' => 'integer'
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    // Scopes
    public function scopeBase($query)
    {
        return $query->where('is_base', true);
    }

    public function scopePrimary($query)
    {
        return $query->where('is_primary', true);
    }

    // Methods
    public function setAsBase()
    {
        // Remove base flag from other images of the same product
        static::where('product_id', $this->product_id)
            ->where('id', '!=', $this->id)
            ->update(['is_base' => false]);
        
        // Set this image as base
        $this->update(['is_base' => true]);
    }
} 