<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Role;
use App\Models\Permission;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $users = User::with('roles')
            ->when(request('search'), function($query, $search) {
                $query->where(function($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                      ->orWhere('email', 'like', "%{$search}%")
                      ->orWhere('employee_id', 'like', "%{$search}%");
                });
            })
            ->when(request('role'), function($query, $role) {
                $query->where('role', $role);
            })
            ->when(request('is_active'), function($query, $is_active) {
                $query->where('is_active', $is_active === 'active');
            })
            ->latest()
            ->paginate(20);

        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        $roles = Role::active()->get();
        return view('admin.users.create', compact('roles'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|in:super_admin,admin,manager,staff',
            'roles' => 'nullable|array',
            'roles.*' => 'exists:roles,id',
            'permissions' => 'nullable|array',
            'department' => 'nullable|string|max:100',
            'employee_id' => 'nullable|string|max:50|unique:users,employee_id',
            'hire_date' => 'nullable|date',
            'is_active' => 'boolean',
        ]);

        // Tạo user mới
        $validated['password'] = bcrypt($validated['password']);
        $validated['is_active'] = $validated['is_active'] ?? true;

        // Handle permissions array
        if (isset($validated['permissions']) && is_array($validated['permissions'])) {
            $validated['permissions'] = array_filter($validated['permissions']);
        }

        $user = User::create($validated);

        // Gán roles nếu có
        if (isset($validated['roles']) && is_array($validated['roles'])) {
            $user->roles()->sync($validated['roles']);
        }

        return redirect()->route('admin.users.index')
            ->with('success', 'Admin mới đã được tạo thành công!');
    }

    public function show(User $user)
    {
        return view('admin.users.show', compact('user'));
    }

    public function edit(User $user)
    {
        $roles = Role::active()->get();
        $permissions = Permission::where('is_active', true)
            ->orderBy('module')
            ->orderBy('name')
            ->get()
            ->groupBy('module');
            
        $user->load('roles');
        return view('admin.users.edit', compact('user', 'roles', 'permissions'));
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'role' => 'required|in:super_admin,admin,manager,staff',
            'roles' => 'nullable|array',
            'roles.*' => 'exists:roles,id',
            'individual_permissions' => 'nullable|array',
            'department' => 'nullable|string|max:100',
            'employee_id' => 'nullable|string|max:50|unique:users,employee_id,' . $user->id,
            'hire_date' => 'nullable|date',
            'is_active' => 'boolean',
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        // Handle password update
        if ($request->filled('password')) {
            $validated['password'] = bcrypt($validated['password']);
        } else {
            unset($validated['password']);
        }

        // Handle individual permissions array (for legacy support)
        if (isset($validated['individual_permissions']) && is_array($validated['individual_permissions'])) {
            $validated['permissions'] = array_filter($validated['individual_permissions']);
            unset($validated['individual_permissions']);
        }

        $user->update($validated);

        // Cập nhật roles
        if (isset($validated['roles']) && is_array($validated['roles'])) {
            $user->roles()->sync($validated['roles']);
        } else {
            $user->roles()->detach(); // Xóa tất cả roles nếu không chọn
        }

        return redirect()->route('admin.users.index')
            ->with('success', 'Thông tin admin đã được cập nhật!');
    }

    public function ban(User $user)
    {
        $user->deactivate();

        return response()->json([
            'success' => true,
            'message' => 'Admin đã bị vô hiệu hóa!'
        ]);
    }

    public function unban(User $user)
    {
        $user->activate();

        return response()->json([
            'success' => true,
            'message' => 'Đã kích hoạt admin!'
        ]);
    }
} 