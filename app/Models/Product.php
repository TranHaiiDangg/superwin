<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'category_id',
        'brand_id',
        'product_type',
        'description',
        'short_description',
        'price',
        'sale_price',
        'sku',
        'stock_quantity',
        'min_stock_level',
        'weight',
        'status',
        'is_featured',
        'view_count',
        'sold_count',
        'rating_average',
        'rating_count',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'meta_robots',
        'meta_author',
        'meta_canonical_url',
        'power',
        'voltage',
        'flow_rate',
        'pressure',
        'efficiency',
        'noise_level',
        'warranty_period'
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'sale_price' => 'decimal:2',
        'stock_quantity' => 'integer',
        'min_stock_level' => 'integer',
        'weight' => 'decimal:3',
        'status' => 'boolean',
        'is_featured' => 'boolean',
        'view_count' => 'integer',
        'sold_count' => 'integer',
        'rating_average' => 'decimal:1',
        'rating_count' => 'integer'
    ];

    // Relationships
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }

    public function images(): HasMany
    {
        return $this->hasMany(ProductImage::class);
    }

    public function baseImage(): HasOne
    {
        return $this->hasOne(ProductImage::class)->where('is_base', true);
    }

    public function primaryImage(): HasOne
    {
        return $this->hasOne(ProductImage::class)->where('is_primary', true);
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    // Product type specific relationships
    public function bomDetails(): HasOne
    {
        return $this->hasOne(BomDetail::class);
    }

    public function bomChimDetails(): HasOne
    {
        return $this->hasOne(BomChimDetail::class);
    }

    public function bomNhapDetails(): HasOne
    {
        return $this->hasOne(BomNhapDetail::class);
    }

    public function quatDetails(): HasOne
    {
        return $this->hasOne(QuatDetail::class);
    }

    public function motorDetails(): HasOne
    {
        return $this->hasOne(MotorDetail::class);
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('status', true);
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function scopeInStock($query)
    {
        return $query->where('stock_quantity', '>', 0);
    }

    // Accessors
    public function getFinalPriceAttribute()
    {
        return $this->sale_price ?? $this->price;
    }

    public function getDiscountPercentageAttribute()
    {
        if ($this->sale_price && $this->price > $this->sale_price) {
            return round((($this->price - $this->sale_price) / $this->price) * 100);
        }
        return 0;
    }

    public function getIsOnSaleAttribute()
    {
        return $this->sale_price && $this->sale_price < $this->price;
    }
} 