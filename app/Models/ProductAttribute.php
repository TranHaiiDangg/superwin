<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductAttribute extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'attribute_key',
        'attribute_value',
        'attribute_unit',
        'attribute_description',
        'sort_order',
        'is_visible'
    ];

    protected $casts = [
        'is_visible' => 'boolean',
        'sort_order' => 'integer'
    ];

    // Relationships
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    // Scopes
    public function scopeVisible($query)
    {
        return $query->where('is_visible', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderBy('attribute_key');
    }

    // Accessors
    public function getDisplayValueAttribute()
    {
        $value = $this->attribute_value;
        if ($this->attribute_unit) {
            $value .= ' ' . $this->attribute_unit;
        }
        return $value;
    }

    // Static methods for common attribute keys
    public static function getCommonAttributeKeys()
    {
        return [
            'power' => 'Công suất',
            'voltage' => 'Điện áp',
            'flow_rate' => 'Lưu lượng',
            'pressure' => 'Áp lực/Cột áp',
            'efficiency' => 'Hiệu suất',
            'noise_level' => 'Mức ồn',
            'warranty_period' => 'Bảo hành',
            'material' => 'Chất liệu',
            'weight' => 'Trọng lượng',
            'dimensions' => 'Kích thước',
            'inlet_size' => 'Kích thước đầu vào',
            'outlet_size' => 'Kích thước đầu ra',
            'max_temperature' => 'Nhiệt độ tối đa',
            'protection_class' => 'Cấp bảo vệ',
            'speed' => 'Tốc độ'
        ];
    }

    public static function getCommonUnits()
    {
        return [
            'power' => ['HP', 'W', 'kW'],
            'voltage' => ['V', 'VAC'],
            'flow_rate' => ['L/phút', 'L/giờ', 'm³/h'],
            'pressure' => ['m', 'bar', 'psi'],
            'efficiency' => ['%'],
            'noise_level' => ['dB'],
            'warranty_period' => ['tháng', 'năm'],
            'weight' => ['kg', 'g'],
            'dimensions' => ['mm', 'cm', 'm'],
            'inlet_size' => ['inch', 'mm'],
            'outlet_size' => ['inch', 'mm'],
            'max_temperature' => ['°C'],
            'speed' => ['vòng/phút', 'rpm']
        ];
    }
}
