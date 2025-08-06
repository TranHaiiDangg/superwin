<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BomDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'cong_suat',
        'hut_sau',
        'cot_ap',
        'luu_luong',
        'ong',
        'dien_ap',
        'dong_dien',
        'duong_kinh_day',
        'warranty_months'
    ];

    protected $casts = [
        'warranty_months' => 'integer'
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
} 