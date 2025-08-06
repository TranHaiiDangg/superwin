<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BomChimDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'cong_suat',
        'dien_ap',
        'cot_ap',
        'luu_luong',
        'ong',
        'dong_dien',
        'max_depth',
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