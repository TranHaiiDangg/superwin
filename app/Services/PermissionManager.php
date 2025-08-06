<?php

namespace App\Services;

use App\Models\Role;
use App\Models\Permission;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PermissionManager
{
    /**
     * Định nghĩa tất cả permissions trong code
     */
    public const PERMISSIONS_CONFIG = [
        // Dashboard
        'dashboard' => [
            'dashboard.view' => 'Xem Dashboard',
            'dashboard.stats' => 'Xem thống kê',
            'dashboard.reports' => 'Xem báo cáo', 
            'dashboard.charts' => 'Xem biểu đồ',
        ],
        
        // Products
        'products' => [
            'products.view' => 'Xem sản phẩm',
            'products.create' => 'Thêm sản phẩm',
            'products.edit' => 'Sửa sản phẩm',
            'products.delete' => 'Xóa sản phẩm',
            'products.export' => 'Xuất dữ liệu sản phẩm',
            'products.import' => 'Nhập dữ liệu sản phẩm',
            'products.restore' => 'Khôi phục sản phẩm',
        ],
        
        // Categories
        'categories' => [
            'categories.view' => 'Xem danh mục',
            'categories.create' => 'Thêm danh mục',
            'categories.edit' => 'Sửa danh mục',
            'categories.delete' => 'Xóa danh mục',
            'categories.restore' => 'Khôi phục danh mục',
        ],
        
        // Brands
        'brands' => [
            'brands.view' => 'Xem thương hiệu',
            'brands.create' => 'Thêm thương hiệu',
            'brands.edit' => 'Sửa thương hiệu',
            'brands.delete' => 'Xóa thương hiệu',
            'brands.restore' => 'Khôi phục thương hiệu',
        ],
        
        // Orders
        'orders' => [
            'orders.view' => 'Xem đơn hàng',
            'orders.create' => 'Tạo đơn hàng',
            'orders.edit' => 'Sửa đơn hàng',
            'orders.delete' => 'Xóa đơn hàng',
            'orders.export' => 'Xuất đơn hàng',
            'orders.print' => 'In hóa đơn',
            'orders.status' => 'Cập nhật trạng thái',
        ],
        
        // Users
        'users' => [
            'users.view' => 'Xem admin',
            'users.create' => 'Thêm admin',
            'users.edit' => 'Sửa admin',
            'users.delete' => 'Xóa admin',
            'users.ban' => 'Khóa/Mở khóa admin',
            'users.permissions' => 'Quản lý phân quyền',
        ],
        
        // Customers
        'customers' => [
            'customers.view' => 'Xem khách hàng',
            'customers.edit' => 'Sửa khách hàng',
            'customers.ban' => 'Khóa/Mở khóa khách hàng',
            'customers.export' => 'Xuất khách hàng',
        ],
        
        // Revenue
        'revenue' => [
            'revenue.view' => 'Xem báo cáo doanh thu',
            'revenue.export' => 'Xuất báo cáo doanh thu',
            'revenue.stats' => 'Xem thống kê chi tiết',
        ],
    ];

    /**
     * Định nghĩa roles mặc định với permissions
     */
    public const ROLES_CONFIG = [
        'super_admin' => [
            'display_name' => 'Super Admin',
            'description' => 'Có tất cả quyền trong hệ thống',
            'permissions' => 'ALL' // Có tất cả permissions
        ],
        'admin' => [
            'display_name' => 'Admin',
            'description' => 'Quản trị viên có đầy đủ quyền',
            'permissions' => [
                'dashboard.*', 'products.*', 'categories.*', 'brands.*',
                'orders.*', 'users.*', 'customers.*', 'revenue.*'
            ]
        ],
        'manager' => [
            'display_name' => 'Manager',
            'description' => 'Quản lý có quyền hạn chế',
            'permissions' => [
                'dashboard.view', 'dashboard.stats',
                'products.*', 'categories.*', 'brands.*',
                'orders.view', 'orders.edit', 'orders.status',
                'customers.view', 'customers.edit',
                'revenue.view', 'revenue.stats'
            ]
        ],
        'staff' => [
            'display_name' => 'Staff',
            'description' => 'Nhân viên có quyền cơ bản',
            'permissions' => [
                'dashboard.view',
                'products.view', 'products.create', 'products.edit',
                'orders.view', 'orders.status',
            ]
        ],
        'viewer' => [
            'display_name' => 'Viewer',
            'description' => 'Chỉ xem, không chỉnh sửa',
            'permissions' => [
                'dashboard.view',
                'products.view', 'categories.view', 'brands.view',
                'orders.view', 'customers.view', 'revenue.view'
            ]
        ]
    ];

    /**
     * Sync tất cả permissions từ config vào database
     */
    public function syncPermissions(): array
    {
        $results = ['created' => 0, 'updated' => 0];
        
        DB::transaction(function() use (&$results) {
            foreach (self::PERMISSIONS_CONFIG as $module => $permissions) {
                foreach ($permissions as $name => $displayName) {
                    $permission = Permission::updateOrCreate(
                        ['name' => $name],
                        [
                            'display_name' => $displayName,
                            'description' => "Quyền {$displayName}",
                            'module' => $module,
                            'is_active' => true,
                        ]
                    );
                    
                    if ($permission->wasRecentlyCreated) {
                        $results['created']++;
                    } else {
                        $results['updated']++;
                    }
                }
            }
        });
        
        return $results;
    }

    /**
     * Sync tất cả roles từ config vào database
     */
    public function syncRoles(): array
    {
        $results = ['created' => 0, 'updated' => 0, 'permissions_synced' => 0];
        
        DB::transaction(function() use (&$results) {
            foreach (self::ROLES_CONFIG as $name => $config) {
                $role = Role::updateOrCreate(
                    ['name' => $name],
                    [
                        'display_name' => $config['display_name'],
                        'description' => $config['description'],
                        'is_active' => true,
                    ]
                );
                
                if ($role->wasRecentlyCreated) {
                    $results['created']++;
                } else {
                    $results['updated']++;
                }
                
                // Sync permissions cho role
                $this->syncRolePermissions($role, $config['permissions']);
                $results['permissions_synced']++;
            }
        });
        
        return $results;
    }

    /**
     * Sync permissions cho một role
     */
    private function syncRolePermissions(Role $role, $permissionsConfig): void
    {
        if ($permissionsConfig === 'ALL') {
            // Super admin có tất cả permissions
            $allPermissions = Permission::where('is_active', true)->pluck('id');
            $role->permissions()->sync($allPermissions);
            return;
        }

        $permissionIds = [];
        
        foreach ($permissionsConfig as $permissionPattern) {
            if (str_ends_with($permissionPattern, '.*')) {
                // Wildcard: lấy tất cả permissions của module
                $module = str_replace('.*', '', $permissionPattern);
                $modulePermissions = Permission::where('module', $module)
                    ->where('is_active', true)
                    ->pluck('id');
                $permissionIds = array_merge($permissionIds, $modulePermissions->toArray());
            } else {
                // Permission cụ thể
                $permission = Permission::where('name', $permissionPattern)
                    ->where('is_active', true)
                    ->first();
                if ($permission) {
                    $permissionIds[] = $permission->id;
                }
            }
        }
        
        $role->permissions()->sync(array_unique($permissionIds));
    }

    /**
     * Lấy tất cả permissions được nhóm theo module
     */
    public function getPermissionsByModule(): array
    {
        return Permission::where('is_active', true)
            ->orderBy('module')
            ->orderBy('name')
            ->get()
            ->groupBy('module')
            ->toArray();
    }

    /**
     * Lấy tất cả roles với permissions
     */
    public function getRolesWithPermissions(): array
    {
        return Role::with('permissions')
            ->where('is_active', true)
            ->orderBy('name')
            ->get()
            ->toArray();
    }

    /**
     * Kiểm tra permission có tồn tại trong config không
     */
    public function isValidPermission(string $permission): bool
    {
        foreach (self::PERMISSIONS_CONFIG as $permissions) {
            if (array_key_exists($permission, $permissions)) {
                return true;
            }
        }
        return false;
    }

    /**
     * Thêm permission mới vào config và database
     */
    public function addPermission(string $module, string $name, string $displayName): bool
    {
        try {
            // Thêm vào database
            Permission::updateOrCreate(
                ['name' => $name],
                [
                    'display_name' => $displayName,
                    'description' => "Quyền {$displayName}",
                    'module' => $module,
                    'is_active' => true,
                ]
            );

            Log::info("Permission added: {$name} - {$displayName}");
            return true;
        } catch (\Exception $e) {
            Log::error("Failed to add permission: {$e->getMessage()}");
            return false;
        }
    }
}