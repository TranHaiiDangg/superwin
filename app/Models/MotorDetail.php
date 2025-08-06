<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MotorDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'cong_suat',
        'dien_ap',
        'toc_do',
        'loai_dong_co',
        'hieu_suat',
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