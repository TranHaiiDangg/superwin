<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class QuatDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'duong_kinh_canh',
        'dien_ap',
        'cong_suat',
        'luong_gio',
        'toc_do',
        'do_on',
        'dien_tich_lam_mat',
        'cot_ap',
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