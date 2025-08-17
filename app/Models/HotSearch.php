<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class HotSearch extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
        'title',
        'keyword',
        'image_url',
        'description',
        'sort_order',
        'max_items',
        'is_active',
        'click_count'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'sort_order' => 'integer',
        'max_items' => 'integer',
        'click_count' => 'integer'
    ];

    // Constants for types
    const TYPE_PRODUCT = 'product';
    const TYPE_KEYWORD = 'keyword';
    const TYPE_BRAND = 'brand';
    const TYPE_CATEGORY = 'category';

    const TYPES = [
        self::TYPE_PRODUCT => 'Sản phẩm',
        self::TYPE_KEYWORD => 'Từ khóa',
        self::TYPE_BRAND => 'Thương hiệu',
        self::TYPE_CATEGORY => 'Danh mục'
    ];

    // Relationships
    public function items()
    {
        return $this->hasMany(HotSearchItem::class)->ordered();
    }

    public function productItems()
    {
        return $this->hasMany(HotSearchItem::class)->byType(HotSearchItem::TYPE_PRODUCT)->ordered();
    }

    public function brandItems()
    {
        return $this->hasMany(HotSearchItem::class)->byType(HotSearchItem::TYPE_BRAND)->ordered();
    }

    public function categoryItems()
    {
        return $this->hasMany(HotSearchItem::class)->byType(HotSearchItem::TYPE_CATEGORY)->ordered();
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeByType($query, $type)
    {
        return $query->where('type', $type);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order', 'asc')->orderBy('created_at', 'desc');
    }

    // Accessors
    public function getTypeNameAttribute()
    {
        return self::TYPES[$this->type] ?? $this->type;
    }

    public function getDisplayImageAttribute()
    {
        if ($this->image_url) {
            return $this->image_url;
        }

        // Fallback to first item image
        $firstItem = $this->items()->first();
        if ($firstItem) {
            return $firstItem->item_image;
        }

        return asset('/image/logo.png');
    }

    public function getSearchUrlAttribute()
    {
        switch ($this->type) {
            case self::TYPE_PRODUCT:
                // Nếu chỉ có 1 sản phẩm thì link trực tiếp, nhiều sản phẩm thì search
                $productItems = $this->productItems;
                if ($productItems->count() === 1) {
                    return $productItems->first()->item_url;
                }
                return route('search'); // Hoặc có thể tạo route riêng cho hot search
            case self::TYPE_BRAND:
                $brandItems = $this->brandItems;
                if ($brandItems->count() === 1) {
                    return $brandItems->first()->item_url;
                }
                return route('search');
            case self::TYPE_CATEGORY:
                $categoryItems = $this->categoryItems;
                if ($categoryItems->count() === 1) {
                    return $categoryItems->first()->item_url;
                }
                return route('search');
            case self::TYPE_KEYWORD:
                return route('search', ['q' => $this->keyword]);
            default:
                return '#';
        }
    }

    public function getDisplayTitleAttribute()
    {
        if ($this->title) {
            return $this->title;
        }

        // Fallback to type name
        switch ($this->type) {
            case self::TYPE_KEYWORD:
                return $this->keyword ?? 'Từ khóa trống';
            default:
                return $this->type_name;
        }
    }

    // Methods
    public function incrementClickCount()
    {
        $this->increment('click_count');
    }

    public static function getActiveByType($type, $limit = null)
    {
        $query = self::active()->byType($type)->ordered();
        
        if ($limit) {
            $query->limit($limit);
        }

        return $query->get();
    }

    public static function getPopularByType($type, $limit = 10)
    {
        return self::active()
            ->byType($type)
            ->orderBy('click_count', 'desc')
            ->orderBy('sort_order', 'asc')
            ->limit($limit)
            ->get();
    }
}