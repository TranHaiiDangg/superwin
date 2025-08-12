<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class HotSearchItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'hot_search_id',
        'item_type',
        'item_id',
        'sort_order'
    ];

    protected $casts = [
        'hot_search_id' => 'integer',
        'item_id' => 'integer',
        'sort_order' => 'integer'
    ];

    // Constants for item types
    const TYPE_PRODUCT = 'product';
    const TYPE_BRAND = 'brand';
    const TYPE_CATEGORY = 'category';

    // Relationships
    public function hotSearch(): BelongsTo
    {
        return $this->belongsTo(HotSearch::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'item_id');
    }

    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class, 'item_id');
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'item_id');
    }

    // Scopes
    public function scopeByType($query, $type)
    {
        return $query->where('item_type', $type);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order', 'asc')->orderBy('id', 'asc');
    }

    // Accessors
    public function getItemAttribute()
    {
        switch ($this->item_type) {
            case self::TYPE_PRODUCT:
                return $this->product;
            case self::TYPE_BRAND:
                return $this->brand;
            case self::TYPE_CATEGORY:
                return $this->category;
            default:
                return null;
        }
    }

    public function getItemNameAttribute()
    {
        $item = $this->item;
        return $item ? $item->name : 'Không tồn tại';
    }

    public function getItemImageAttribute()
    {
        switch ($this->item_type) {
            case self::TYPE_PRODUCT:
                return $this->product?->baseImage?->url ? asset($this->product->baseImage->url) : asset('/image/sp1.png');
            case self::TYPE_BRAND:
                return $this->brand?->image ? asset($this->brand->image) : asset('/image/logo.png');
            case self::TYPE_CATEGORY:
                return $this->category?->image ? asset($this->category->image) : asset('/image/logo.png');
            default:
                return asset('/image/logo.png');
        }
    }

    public function getItemUrlAttribute()
    {
        switch ($this->item_type) {
            case self::TYPE_PRODUCT:
                return $this->product ? route('products.show', $this->product->id) : '#';
            case self::TYPE_BRAND:
                return $this->brand ? route('search', ['brand_id' => $this->brand->id]) : '#';
            case self::TYPE_CATEGORY:
                return $this->category ? route('search', ['category_id' => $this->category->id]) : '#';
            default:
                return '#';
        }
    }
}