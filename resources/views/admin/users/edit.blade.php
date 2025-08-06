@extends('admin.layouts.app')

@section('title', 'Chỉnh sửa Admin')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-900">Chỉnh sửa Admin: {{ $user->name }}</h1>
        <a href="{{ route('admin.users.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg">
            <i class="fas fa-arrow-left mr-2"></i>Quay lại
        </a>
    </div>

    <div class="bg-white rounded-lg shadow-md p-6">
        <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Basic Information -->
                <div class="space-y-4">
                    <h3 class="text-lg font-semibold text-gray-700 border-b pb-2">Thông tin cơ bản</h3>
                    
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                            Tên Admin <span class="text-red-500">*</span>
                        </label>
                        <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}" required
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                               placeholder="Nhập tên admin">
                        @error('name')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                            Email <span class="text-red-500">*</span>
                        </label>
                        <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}" required
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                               placeholder="admin@example.com">
                        @error('email')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="role" class="block text-sm font-medium text-gray-700 mb-2">
                            Vai trò <span class="text-red-500">*</span>
                        </label>
                        <select id="role" name="role" required
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="">Chọn vai trò</option>
                            <option value="super_admin" {{ old('role', $user->role) == 'super_admin' ? 'selected' : '' }}>Super Admin</option>
                            <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>Admin</option>
                            <option value="manager" {{ old('role', $user->role) == 'manager' ? 'selected' : '' }}>Manager</option>
                            <option value="staff" {{ old('role', $user->role) == 'staff' ? 'selected' : '' }}>Staff</option>
                        </select>
                        @error('role')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                            Mật khẩu mới
                        </label>
                        <input type="password" id="password" name="password"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                               placeholder="Để trống nếu không đổi">
                        @error('password')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">
                            Xác nhận mật khẩu
                        </label>
                        <input type="password" id="password_confirmation" name="password_confirmation"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                               placeholder="Nhập lại mật khẩu mới">
                    </div>

                    <div>
                        <label for="department" class="block text-sm font-medium text-gray-700 mb-2">
                            Phòng ban
                        </label>
                        <input type="text" id="department" name="department" value="{{ old('department', $user->department) }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                               placeholder="Phòng ban">
                        @error('department')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="employee_id" class="block text-sm font-medium text-gray-700 mb-2">
                            Mã nhân viên
                        </label>
                        <input type="text" id="employee_id" name="employee_id" value="{{ old('employee_id', $user->employee_id) }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                               placeholder="NV001">
                        @error('employee_id')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="hire_date" class="block text-sm font-medium text-gray-700 mb-2">
                            Ngày thuê
                        </label>
                        <input type="date" id="hire_date" name="hire_date" value="{{ old('hire_date', $user->hire_date ? $user->hire_date->format('Y-m-d') : '') }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        @error('hire_date')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="is_active" class="flex items-center">
                            <input type="checkbox" id="is_active" name="is_active" value="1" 
                                   {{ old('is_active', $user->is_active) ? 'checked' : '' }}
                                   class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                            <span class="ml-2 text-sm text-gray-700">Kích hoạt tài khoản</span>
                        </label>
                        @error('is_active')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Unified Permissions -->
                <div class="space-y-4">
                    <h3 class="text-lg font-semibold text-gray-700 border-b pb-2">Phân quyền</h3>
                    
                    <!-- Tab Navigation -->
                    <div class="flex border-b border-gray-200">
                        <button type="button" onclick="switchTab('roles-content')" 
                                class="tab-button active px-4 py-2 text-sm font-medium text-blue-600 border-b-2 border-blue-600">
                            Vai trò hệ thống
                        </button>
                        <button type="button" onclick="switchTab('permissions-content')" 
                                class="tab-button px-4 py-2 text-sm font-medium text-gray-500 hover:text-gray-700">
                            Quyền chi tiết
                        </button>
                    </div>

                    <!-- Roles Tab -->
                    <div id="roles-content" class="tab-content">
                        @if(isset($roles) && $roles->count() > 0)
                        <div class="space-y-3">
                            <p class="text-sm text-gray-600">Chọn vai trò có sẵn (đã được cấu hình permissions):</p>
                            <div class="grid grid-cols-1 gap-3 max-h-60 overflow-y-auto">
                                @foreach($roles as $role)
                                <label class="flex items-start p-3 border border-gray-200 rounded-lg hover:bg-gray-50 cursor-pointer">
                                    <input type="checkbox" name="roles[]" value="{{ $role->id }}" 
                                           {{ $user->roles->contains($role->id) || in_array($role->id, old('roles', [])) ? 'checked' : '' }}
                                           class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded mt-1 flex-shrink-0">
                                    <div class="ml-3">
                                        <div class="text-sm font-medium text-gray-700">{{ $role->display_name }}</div>
                                        @if($role->description)
                                            <p class="text-xs text-gray-500 mt-1">{{ $role->description }}</p>
                                        @endif
                                        <div class="text-xs text-blue-600 mt-1">
                                            {{ $role->permissions->count() }} permissions
                                        </div>
                                    </div>
                                </label>
                                @endforeach
                            </div>
                        </div>
                        @error('roles')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                        @endif
                    </div>

                    <!-- Permissions Tab -->
                    <div id="permissions-content" class="tab-content hidden">
                        @if(isset($permissions) && $permissions->count() > 0)
                        <div class="space-y-4">
                            <p class="text-sm text-gray-600">Chọn quyền chi tiết (dùng khi cần phân quyền đặc biệt):</p>
                            @foreach($permissions as $module => $modulePermissions)
                            <div class="border border-gray-200 rounded-lg">
                                <div class="bg-gray-50 px-4 py-2 border-b border-gray-200">
                                    <h4 class="font-medium text-gray-700 capitalize">{{ $module }}</h4>
                                </div>
                                <div class="p-3 space-y-2">
                                    @foreach($modulePermissions as $permission)
                                    <label class="flex items-center">
                                        <input type="checkbox" name="individual_permissions[]" value="{{ $permission->name }}" 
                                               {{ in_array($permission->name, old('individual_permissions', $user->permissions ?? [])) ? 'checked' : '' }}
                                               class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                        <span class="ml-2 text-sm text-gray-700">{{ $permission->display_name }}</span>
                                    </label>
                                    @endforeach
                                </div>
                            </div>
                            @endforeach
                        </div>
                        @error('individual_permissions')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                        @endif
                    </div>

                    <!-- Info Box -->
                    <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-blue-800">Lưu ý phân quyền</h3>
                                <div class="mt-2 text-sm text-blue-700">
                                    <ul class="list-disc list-inside space-y-1">
                                        <li><strong>Vai trò hệ thống:</strong> Sử dụng cho phân quyền chuẩn, dễ quản lý</li>
                                        <li><strong>Quyền chi tiết:</strong> Chỉ dùng khi cần phân quyền đặc biệt</li>
                                        <li>Vai trò hệ thống sẽ được ưu tiên hơn quyền chi tiết</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex justify-end space-x-3 mt-6">
                <a href="{{ route('admin.users.index') }}" 
                   class="px-6 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-500">
                    Hủy
                </a>
                <button type="submit" 
                        class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <i class="fas fa-save mr-2"></i>Cập nhật
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function switchTab(activeContentId) {
    // Hide all tab contents
    document.querySelectorAll('.tab-content').forEach(content => {
        content.classList.add('hidden');
    });
    
    // Remove active class from all tab buttons
    document.querySelectorAll('.tab-button').forEach(button => {
        button.classList.remove('active', 'text-blue-600', 'border-blue-600');
        button.classList.add('text-gray-500');
    });
    
    // Show active content
    document.getElementById(activeContentId).classList.remove('hidden');
    
    // Set active tab button
    event.target.classList.add('active', 'text-blue-600', 'border-blue-600');
    event.target.classList.remove('text-gray-500');
}
</script>
@endsection