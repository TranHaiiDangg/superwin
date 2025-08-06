<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\PermissionManager;
use App\Models\Permission;
use App\Models\Role;
use Illuminate\Http\Request;

class PermissionController extends Controller
{
    private PermissionManager $permissionManager;

    public function __construct(PermissionManager $permissionManager)
    {
        $this->permissionManager = $permissionManager;
    }

    /**
     * Hiển thị trang quản lý permissions
     */
    public function index()
    {
        $permissions = Permission::with('roles')
            ->orderBy('module')
            ->orderBy('name')
            ->get()
            ->groupBy('module');

        $roles = Role::with('permissions')
            ->where('is_active', true)
            ->orderBy('name')
            ->get();

        return view('admin.permissions.index', compact('permissions', 'roles'));
    }

    /**
     * Sync permissions từ code config
     */
    public function sync(Request $request)
    {
        try {
            // Sync permissions
            $permissionResults = $this->permissionManager->syncPermissions();
            
            // Sync roles nếu có yêu cầu
            $roleResults = null;
            if ($request->has('sync_roles') || $request->boolean('sync_roles')) {
                $roleResults = $this->permissionManager->syncRoles();
            }

            $message = "✅ Permissions: {$permissionResults['created']} tạo mới, {$permissionResults['updated']} cập nhật";
            
            if ($roleResults) {
                $message .= "\n✅ Roles: {$roleResults['created']} tạo mới, {$roleResults['updated']} cập nhật";
                $message .= "\n✅ Permissions đã gán cho {$roleResults['permissions_synced']} roles";
            }

            // Log hoạt động
            \Log::info('Permissions synced via admin interface', [
                'user_id' => auth()->id(),
                'permissions_results' => $permissionResults,
                'roles_results' => $roleResults,
                'sync_roles' => $request->boolean('sync_roles')
            ]);

            return response()->json([
                'success' => true,
                'message' => $message,
                'results' => [
                    'permissions' => $permissionResults,
                    'roles' => $roleResults
                ],
                'summary' => [
                    'total_permissions' => \App\Models\Permission::count(),
                    'total_roles' => \App\Models\Role::count(),
                    'active_users' => \App\Models\User::where('is_active', true)->count()
                ]
            ]);

        } catch (\Exception $e) {
            \Log::error('Failed to sync permissions via admin interface', [
                'user_id' => auth()->id(),
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Lỗi sync permissions: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Chạy artisan command từ giao diện
     */
    public function runArtisanSync(Request $request)
    {
        try {
            $syncRoles = $request->boolean('sync_roles', true);
            $force = $request->boolean('force', true);
            
            // Build command
            $command = 'permissions:sync';
            if ($syncRoles) {
                $command .= ' --roles';
            }
            if ($force) {
                $command .= ' --force';
            }

            // Run artisan command
            \Artisan::call($command);
            $output = \Artisan::output();

            // Log hoạt động
            \Log::info('Artisan permissions:sync executed via admin interface', [
                'user_id' => auth()->id(),
                'command' => $command,
                'output' => $output
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Command đã chạy thành công!',
                'output' => $output,
                'command' => "php artisan {$command}",
                'summary' => [
                    'total_permissions' => \App\Models\Permission::count(),
                    'total_roles' => \App\Models\Role::count(),
                    'active_users' => \App\Models\User::where('is_active', true)->count()
                ]
            ]);

        } catch (\Exception $e) {
            \Log::error('Failed to run artisan permissions:sync via admin interface', [
                'user_id' => auth()->id(),
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Lỗi chạy command: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Thêm permission mới
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|unique:permissions,name',
            'display_name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'module' => 'required|string|max:100',
        ]);

        try {
            $permission = Permission::create([
                'name' => $validated['name'],
                'display_name' => $validated['display_name'],
                'description' => $validated['description'] ?? "Quyền {$validated['display_name']}",
                'module' => $validated['module'],
                'is_active' => true,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Permission đã được tạo thành công!',
                'permission' => $permission
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Lỗi tạo permission: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Cập nhật role permissions
     */
    public function updateRolePermissions(Request $request, Role $role)
    {
        $validated = $request->validate([
            'permissions' => 'nullable|array',
            'permissions.*' => 'exists:permissions,id',
        ]);

        try {
            $permissionIds = $validated['permissions'] ?? [];
            $role->permissions()->sync($permissionIds);

            return response()->json([
                'success' => true,
                'message' => "Permissions của role '{$role->display_name}' đã được cập nhật!",
                'count' => count($permissionIds)
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Lỗi cập nhật role permissions: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Xóa permission
     */
    public function destroy(Permission $permission)
    {
        try {
            // Kiểm tra permission có đang được sử dụng không
            if ($permission->roles()->count() > 0) {
                return response()->json([
                    'success' => false,
                    'message' => 'Không thể xóa permission đang được sử dụng bởi roles!'
                ], 400);
            }

            $permission->delete();

            return response()->json([
                'success' => true,
                'message' => 'Permission đã được xóa thành công!'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Lỗi xóa permission: ' . $e->getMessage()
            ], 500);
        }
    }
}
