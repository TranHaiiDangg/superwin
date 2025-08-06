<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'permissions',
        'department',
        'employee_id',
        'hire_date',
        'is_active',
        'last_login_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'last_login_at' => 'datetime',
            'hire_date' => 'date',
            'permissions' => 'array',
            'is_active' => 'boolean',
            'password' => 'hashed',
        ];
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

    public function scopeByRole($query, $role)
    {
        return $query->where('role', $role);
    }

    public function scopeByDepartment($query, $department)
    {
        return $query->where('department', $department);
    }

    // Accessors
    public function getFullNameAttribute(): string
    {
        return $this->name;
    }

    public function getIsVerifiedAttribute(): bool
    {
        return !is_null($this->email_verified_at);
    }

    public function getRoleDisplayAttribute(): string
    {
        return match($this->role) {
            'super_admin' => 'Super Admin',
            'admin' => 'Admin',
            'manager' => 'Manager',
            'staff' => 'Staff',
            default => ucfirst($this->role)
        };
    }

    // Methods
    public function hasPermission(string $permission): bool
    {
        // Cache để tránh query nhiều lần
        static $cache = [];
        $cacheKey = $this->id . '_' . $permission;
        
        if (isset($cache[$cacheKey])) {
            return $cache[$cacheKey];
        }

        // Super admin có tất cả quyền
        if ($this->role === 'super_admin') {
            return $cache[$cacheKey] = true;
        }

        // Kiểm tra từ roles system (ưu tiên)
        $hasRolePermission = $this->roles()
            ->whereHas('permissions', function($query) use ($permission) {
                $query->where('name', $permission)
                      ->where('is_active', true);
            })
            ->exists();

        if ($hasRolePermission) {
            return $cache[$cacheKey] = true;
        }

        // Fallback: Kiểm tra permissions cũ (chỉ khi không có roles)
        if ($this->roles()->count() === 0 && !empty($this->permissions)) {
            $result = $this->checkLegacyPermissions($permission);
            return $cache[$cacheKey] = $result;
        }

        return $cache[$cacheKey] = false;
    }

    /**
     * Kiểm tra permissions cũ với mapping
     */
    private function checkLegacyPermissions(string $permission): bool
    {
        $oldPermissions = $this->permissions ?? [];
        
        // Kiểm tra permission trực tiếp
        if (in_array($permission, $oldPermissions)) {
            return true;
        }
        
        // Mapping permissions cũ sang mới
        $permissionMapping = [
            'products.manage' => ['products.view', 'products.create', 'products.edit', 'products.delete'],
            'categories.manage' => ['categories.view', 'categories.create', 'categories.edit', 'categories.delete'],
            'brands.manage' => ['brands.view', 'brands.create', 'brands.edit', 'brands.delete'],
            'orders.manage' => ['orders.view', 'orders.edit', 'orders.delete'],
            'users.manage' => ['users.view', 'users.create', 'users.edit', 'users.delete'],
            'customers.manage' => ['customers.view', 'customers.edit'],
            'dashboard.manage' => ['dashboard.view', 'dashboard.stats', 'dashboard.reports'],
        ];
        
        // Kiểm tra qua mapping
        foreach ($permissionMapping as $oldPerm => $newPerms) {
            if (in_array($oldPerm, $oldPermissions) && in_array($permission, $newPerms)) {
                return true;
            }
        }
        
        return false;
    }

    public function hasRole(string $role): bool
    {
        // Kiểm tra từ role cũ (string field)
        if ($this->role === $role) {
            return true;
        }

        // Kiểm tra từ roles mới
        return $this->roles()->where('name', $role)->where('is_active', true)->exists();
    }

    public function assignRole(Role $role): void
    {
        $this->roles()->attach($role->id);
    }

    public function removeRole(Role $role): void
    {
        $this->roles()->detach($role->id);
    }

    public function getAllPermissions(): array
    {
        $permissions = $this->permissions ?? [];
        
        // Thêm permissions từ roles
        $rolePermissions = $this->roles()->with('permissions')->get()
            ->pluck('permissions')
            ->flatten()
            ->where('is_active', true)
            ->pluck('name')
            ->toArray();
        
        return array_unique(array_merge($permissions, $rolePermissions));
    }

    public function isSuperAdmin(): bool
    {
        return $this->role === 'super_admin';
    }

    public function isAdmin(): bool
    {
        return in_array($this->role, ['super_admin', 'admin']);
    }

    public function activate(): void
    {
        $this->update(['is_active' => true]);
    }

    public function deactivate(): void
    {
        $this->update(['is_active' => false]);
    }

    // Relationships
    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class, 'user_roles');
    }

    public function orderTracking(): HasMany
    {
        return $this->hasMany(OrderTracking::class, 'created_by');
    }
}
