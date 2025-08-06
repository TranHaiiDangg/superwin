<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Tạo các permissions cơ bản
        $permissions = [
            // Dashboard
            [
                'name' => 'dashboard.view',
                'display_name' => 'Xem Dashboard',
                'description' => 'Quyền truy cập trang dashboard',
                'module' => 'dashboard'
            ],
            [
                'name' => 'dashboard.stats',
                'display_name' => 'Xem thống kê',
                'description' => 'Quyền xem các số liệu thống kê (doanh thu, đơn hàng)',
                'module' => 'dashboard'
            ],
            [
                'name' => 'dashboard.reports',
                'display_name' => 'Xem báo cáo',
                'description' => 'Quyền xem các báo cáo chi tiết',
                'module' => 'dashboard'
            ],
            [
                'name' => 'dashboard.charts',
                'display_name' => 'Xem biểu đồ',
                'description' => 'Quyền xem biểu đồ và phân tích',
                'module' => 'dashboard'
            ],
            
            // Products
            [
                'name' => 'products.view',
                'display_name' => 'Xem sản phẩm',
                'description' => 'Quyền xem danh sách sản phẩm',
                'module' => 'products'
            ],
            [
                'name' => 'products.create',
                'display_name' => 'Tạo sản phẩm',
                'description' => 'Quyền tạo sản phẩm mới',
                'module' => 'products'
            ],
            [
                'name' => 'products.edit',
                'display_name' => 'Sửa sản phẩm',
                'description' => 'Quyền chỉnh sửa sản phẩm',
                'module' => 'products'
            ],
            [
                'name' => 'products.delete',
                'display_name' => 'Xóa sản phẩm',
                'description' => 'Quyền xóa sản phẩm',
                'module' => 'products'
            ],
            
            // Categories
            [
                'name' => 'categories.view',
                'display_name' => 'Xem danh mục',
                'description' => 'Quyền xem danh sách danh mục',
                'module' => 'categories'
            ],
            [
                'name' => 'categories.create',
                'display_name' => 'Tạo danh mục',
                'description' => 'Quyền tạo danh mục mới',
                'module' => 'categories'
            ],
            [
                'name' => 'categories.edit',
                'display_name' => 'Sửa danh mục',
                'description' => 'Quyền chỉnh sửa danh mục',
                'module' => 'categories'
            ],
            [
                'name' => 'categories.delete',
                'display_name' => 'Xóa danh mục',
                'description' => 'Quyền xóa danh mục',
                'module' => 'categories'
            ],
            
            // Brands
            [
                'name' => 'brands.view',
                'display_name' => 'Xem thương hiệu',
                'description' => 'Quyền xem danh sách thương hiệu',
                'module' => 'brands'
            ],
            [
                'name' => 'brands.create',
                'display_name' => 'Tạo thương hiệu',
                'description' => 'Quyền tạo thương hiệu mới',
                'module' => 'brands'
            ],
            [
                'name' => 'brands.edit',
                'display_name' => 'Sửa thương hiệu',
                'description' => 'Quyền chỉnh sửa thương hiệu',
                'module' => 'brands'
            ],
            [
                'name' => 'brands.delete',
                'display_name' => 'Xóa thương hiệu',
                'description' => 'Quyền xóa thương hiệu',
                'module' => 'brands'
            ],
            
            // Orders
            [
                'name' => 'orders.view',
                'display_name' => 'Xem đơn hàng',
                'description' => 'Quyền xem danh sách đơn hàng',
                'module' => 'orders'
            ],
            [
                'name' => 'orders.edit',
                'display_name' => 'Sửa đơn hàng',
                'description' => 'Quyền chỉnh sửa đơn hàng',
                'module' => 'orders'
            ],
            [
                'name' => 'orders.delete',
                'display_name' => 'Xóa đơn hàng',
                'description' => 'Quyền xóa đơn hàng',
                'module' => 'orders'
            ],
            
            // Users
            [
                'name' => 'users.view',
                'display_name' => 'Xem người dùng',
                'description' => 'Quyền xem danh sách người dùng',
                'module' => 'users'
            ],
            [
                'name' => 'users.create',
                'display_name' => 'Tạo người dùng',
                'description' => 'Quyền tạo người dùng mới',
                'module' => 'users'
            ],
            [
                'name' => 'users.edit',
                'display_name' => 'Sửa người dùng',
                'description' => 'Quyền chỉnh sửa thông tin người dùng',
                'module' => 'users'
            ],
            [
                'name' => 'users.delete',
                'display_name' => 'Xóa người dùng',
                'description' => 'Quyền xóa người dùng',
                'module' => 'users'
            ],
            
            // Customers
            [
                'name' => 'customers.view',
                'display_name' => 'Xem khách hàng',
                'description' => 'Quyền xem danh sách khách hàng',
                'module' => 'customers'
            ],
            [
                'name' => 'customers.edit',
                'display_name' => 'Sửa khách hàng',
                'description' => 'Quyền chỉnh sửa thông tin khách hàng',
                'module' => 'customers'
            ],
            
            // Product Attributes
            [
                'name' => 'product_attributes.view',
                'display_name' => 'Xem thuộc tính sản phẩm',
                'description' => 'Quyền xem thuộc tính sản phẩm',
                'module' => 'product_attributes'
            ],
            [
                'name' => 'product_attributes.create',
                'display_name' => 'Tạo thuộc tính sản phẩm',
                'description' => 'Quyền tạo thuộc tính sản phẩm',
                'module' => 'product_attributes'
            ],
            [
                'name' => 'product_attributes.edit',
                'display_name' => 'Sửa thuộc tính sản phẩm',
                'description' => 'Quyền sửa thuộc tính sản phẩm',
                'module' => 'product_attributes'
            ],
            [
                'name' => 'product_attributes.delete',
                'display_name' => 'Xóa thuộc tính sản phẩm',
                'description' => 'Quyền xóa thuộc tính sản phẩm',
                'module' => 'product_attributes'
            ],
        ];

        // Tạo các permissions
        foreach ($permissions as $permission) {
            Permission::firstOrCreate(
                ['name' => $permission['name']],
                $permission
            );
        }

        // Tạo các roles cơ bản
        $roles = [
            [
                'name' => 'super_admin',
                'display_name' => 'Super Admin',
                'description' => 'Có tất cả quyền trong hệ thống'
            ],
            [
                'name' => 'admin',
                'display_name' => 'Admin',
                'description' => 'Quản trị viên hệ thống'
            ],
            [
                'name' => 'manager',
                'display_name' => 'Manager',
                'description' => 'Quản lý sản phẩm và đơn hàng'
            ],
            [
                'name' => 'staff',
                'display_name' => 'Staff',
                'description' => 'Nhân viên bán hàng'
            ],
            [
                'name' => 'viewer',
                'display_name' => 'Viewer',
                'description' => 'Chỉ xem, không chỉnh sửa'
            ]
        ];

        foreach ($roles as $roleData) {
            $role = Role::firstOrCreate(
                ['name' => $roleData['name']],
                $roleData
            );

            // Gán quyền cho các role
            $this->assignPermissionsToRole($role);
        }
    }

    /**
     * Gán quyền cho từng role
     */
    private function assignPermissionsToRole(Role $role): void
    {
        switch ($role->name) {
            case 'super_admin':
                // Super admin có tất cả quyền (không cần gán vì đã xử lý trong code)
                break;
                
            case 'admin':
                // Admin có hầu hết quyền
                $permissions = Permission::whereNotIn('name', [])->get();
                $role->permissions()->sync($permissions->pluck('id')->toArray());
                break;
                
            case 'manager':
                // Manager có quyền quản lý sản phẩm, danh mục, thương hiệu, đơn hàng
                $permissions = Permission::whereIn('module', [
                    'dashboard', 'products', 'categories', 'brands', 'orders', 'product_attributes'
                ])->get();
                $role->permissions()->sync($permissions->pluck('id')->toArray());
                break;
                
            case 'staff':
                // Staff có quyền xem và chỉnh sửa đơn hàng, xem sản phẩm
                $permissions = Permission::whereIn('name', [
                    'dashboard.view',
                    'products.view',
                    'categories.view',
                    'brands.view',
                    'orders.view',
                    'orders.edit',
                    'customers.view',
                    'customers.edit'
                ])->get();
                $role->permissions()->sync($permissions->pluck('id')->toArray());
                break;
                
            case 'viewer':
                // Viewer chỉ có quyền xem
                $permissions = Permission::where('name', 'like', '%.view')->get();
                $role->permissions()->sync($permissions->pluck('id')->toArray());
                break;
        }
    }
}
