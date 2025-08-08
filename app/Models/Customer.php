<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Customer extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'password',
        'google_id',
        'facebook_id',
        'avatar',
        'date_of_birth',
        'gender',
        'address',
        'city',
        'district',
        'ward',
        'email_verified_at',
        'phone_verified_at',
        'status',
        'is_active',
        'customer_code',
        'total_spent',
        'loyalty_points',
        'preferred_payment_method',
        'marketing_consent',
        'newsletter_subscription',
        'last_login_at',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'phone_verified_at' => 'datetime',
            'last_login_at' => 'datetime',
            'date_of_birth' => 'date',
            'password' => 'hashed',
            'total_spent' => 'decimal:2',
            'loyalty_points' => 'integer',
            'is_active' => 'boolean',
            'marketing_consent' => 'boolean',
            'newsletter_subscription' => 'boolean',
        ];
    }

    // Relationships
    public function orders(): HasMany
    {
        return $this->hasMany(Order::class, 'user_id');
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    public function cart(): HasOne
    {
        return $this->hasOne(Cart::class);
    }

    public function cartItems(): HasMany
    {
        return $this->hasMany(CartItem::class);
    }

    public function notifications(): HasMany
    {
        return $this->hasMany(Notification::class);
    }

    public function searchLogs(): HasMany
    {
        return $this->hasMany(SearchLog::class);
    }

    public function productViews(): HasMany
    {
        return $this->hasMany(ProductView::class);
    }

    public function couponUsage(): HasMany
    {
        return $this->hasMany(CouponUsage::class);
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeInactive($query)
    {
        return $query->where('is_active', false);
    }

    public function scopeBanned($query)
    {
        return $query->where('status', 'banned');
    }

    public function scopeStatusActive($query)
    {
        return $query->where('status', 'active');
    }

    // Accessors
    public function getFullNameAttribute()
    {
        return $this->name;
    }

    public function getIsVerifiedAttribute()
    {
        return !is_null($this->email_verified_at);
    }

    public function getIsPhoneVerifiedAttribute()
    {
        return !is_null($this->phone_verified_at);
    }

    public function getFullAddressAttribute()
    {
        $parts = array_filter([$this->address, $this->ward, $this->district, $this->city]);
        return implode(', ', $parts);
    }

    public function getLoyaltyLevelAttribute()
    {
        if ($this->loyalty_points >= 1000) return 'VIP';
        if ($this->loyalty_points >= 500) return 'Gold';
        if ($this->loyalty_points >= 100) return 'Silver';
        return 'Bronze';
    }

    // Methods
    public function addLoyaltyPoints(int $points): void
    {
        $this->increment('loyalty_points', $points);
    }

    public function deductLoyaltyPoints(int $points): bool
    {
        if ($this->loyalty_points >= $points) {
            $this->decrement('loyalty_points', $points);
            return true;
        }
        return false;
    }

    public function updateTotalSpent(float $amount): void
    {
        $this->increment('total_spent', $amount);
    }

    public function ban(): void
    {
        $this->update(['status' => 'banned', 'is_active' => false]);
    }

    public function unban(): void
    {
        $this->update(['status' => 'active', 'is_active' => true]);
    }

    public function activate(): void
    {
        $this->update(['is_active' => true]);
    }

    public function deactivate(): void
    {
        $this->update(['is_active' => false]);
    }

    public function isBanned(): bool
    {
        return $this->status === 'banned';
    }

    public function isActive(): bool
    {
        return $this->is_active === true;
    }
} 