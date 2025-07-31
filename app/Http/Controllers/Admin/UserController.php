<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $users = User::when(request('search'), function($query, $search) {
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

    public function show(User $user)
    {
        return view('admin.users.show', compact('user'));
    }

    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'role' => 'required|in:super_admin,admin,manager,staff',
            'permissions' => 'nullable|array',
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

        // Handle permissions array
        if (isset($validated['permissions']) && is_array($validated['permissions'])) {
            $validated['permissions'] = array_filter($validated['permissions']);
        }

        $user->update($validated);

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