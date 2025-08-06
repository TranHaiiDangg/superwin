@extends('admin.layouts.app')

@section('title', 'Tạo Admin Mới')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-900">Tạo Admin Mới</h1>
        <a href="{{ route('admin.users.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg">
            <i class="fas fa-arrow-left mr-2"></i>Quay lại
        </a>
    </div>

    <div class="bg-white rounded-lg shadow-md p-6">
        <form action="{{ route('admin.users.store') }}" method="POST">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Basic Information -->
                <div class="space-y-4">
                    <h3 class="text-lg font-semibold text-gray-700 border-b pb-2">Thông tin cơ bản</h3>
                    
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                            Tên Admin <span class="text-red-500">*</span>
                        </label>
                        <input type="text" id="name" name="name" value="{{ old('name') }}" required
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
                        <input type="email" id="email" name="email" value="{{ old('email') }}" required
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                               placeholder="admin@example.com">
                        @error('email')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                            Mật khẩu <span class="text-red-500">*</span>
                        </label>
                        <input type="password" id="password" name="password" required
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                               placeholder="Nhập mật khẩu">
                        @error('password')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">
                            Xác nhận mật khẩu <span class="text-red-500">*</span>
                        </label>
                        <input type="password" id="password_confirmation" name="password_confirmation" required
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                               placeholder="Nhập lại mật khẩu">
                        @error('password_confirmation')
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
                            <option value="super_admin" {{ old('role') == 'super_admin' ? 'selected' : '' }}>Super Admin</option>
                            <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                            <option value="manager" {{ old('role') == 'manager' ? 'selected' : '' }}>Manager</option>
                            <option value="staff" {{ old('role') == 'staff' ? 'selected' : '' }}>Staff</option>
                        </select>
                        @error('role')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="department" class="block text-sm font-medium text-gray-700 mb-2">
                            Phòng ban
                        </label>
                        <input type="text" id="department" name="department" value="{{ old('department') }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                               placeholder="IT, Sales, Marketing...">
                        @error('department')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="employee_id" class="block text-sm font-medium text-gray-700 mb-2">
                            Mã nhân viên
                        </label>
                        <input type="text" id="employee_id" name="employee_id" value="{{ old('employee_id') }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                               placeholder="EMP001">
                        @error('employee_id')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="hire_date" class="block text-sm font-medium text-gray-700 mb-2">
                            Ngày thuê
                        </label>
                        <input type="date" id="hire_date" name="hire_date" value="{{ old('hire_date') }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        @error('hire_date')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="is_active" class="flex items-center">
                            <input type="checkbox" id="is_active" name="is_active" value="1" 
                                   {{ old('is_active', true) ? 'checked' : '' }}
                                   class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                            <span class="ml-2 text-sm text-gray-700">Kích hoạt tài khoản</span>
                        </label>
                        @error('is_active')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Roles & Permissions -->
                <div class="space-y-4">
                    <h3 class="text-lg font-semibold text-gray-700 border-b pb-2">Phân quyền</h3>
                    
                    <!-- Roles từ bảng roles -->
                    @if($roles->count() > 0)
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Vai trò hệ thống</label>
                        <div class="space-y-2 max-h-40 overflow-y-auto border border-gray-200 rounded-lg p-3">
                            @foreach($roles as $role)
                            <label class="flex items-start">
                                <input type="checkbox" name="roles[]" value="{{ $role->id }}" 
                                       {{ in_array($role->id, old('roles', [])) ? 'checked' : '' }}
                                       class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded mt-1">
                                <div class="ml-2">
                                    <span class="text-sm font-medium text-gray-700">{{ $role->display_name }}</span>
                                    @if($role->description)
                                        <p class="text-xs text-gray-500">{{ $role->description }}</p>
                                    @endif
                                </div>
                            </label>
                            @endforeach
                        </div>
                        @error('roles')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    @endif
                    
                    <!-- Permissions cũ (tương thích ngược) -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Quyền truy cập bổ sung</label>
                        <div class="space-y-2">
                            <label class="flex items-center">
                                <input type="checkbox" name="permissions[]" value="products.manage" 
                                       {{ in_array('products.manage', old('permissions', [])) ? 'checked' : '' }}
                                       class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                <span class="ml-2 text-sm text-gray-700">Quản lý sản phẩm</span>
                            </label>
                            <label class="flex items-center">
                                <input type="checkbox" name="permissions[]" value="categories.manage" 
                                       {{ in_array('categories.manage', old('permissions', [])) ? 'checked' : '' }}
                                       class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                <span class="ml-2 text-sm text-gray-700">Quản lý danh mục</span>
                            </label>
                            <label class="flex items-center">
                                <input type="checkbox" name="permissions[]" value="brands.manage" 
                                       {{ in_array('brands.manage', old('permissions', [])) ? 'checked' : '' }}
                                       class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                <span class="ml-2 text-sm text-gray-700">Quản lý thương hiệu</span>
                            </label>
                            <label class="flex items-center">
                                <input type="checkbox" name="permissions[]" value="orders.manage" 
                                       {{ in_array('orders.manage', old('permissions', [])) ? 'checked' : '' }}
                                       class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                <span class="ml-2 text-sm text-gray-700">Quản lý đơn hàng</span>
                            </label>
                            <label class="flex items-center">
                                <input type="checkbox" name="permissions[]" value="customers.manage" 
                                       {{ in_array('customers.manage', old('permissions', [])) ? 'checked' : '' }}
                                       class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                <span class="ml-2 text-gray-700">Quản lý khách hàng</span>
                            </label>
                            <label class="flex items-center">
                                <input type="checkbox" name="permissions[]" value="users.manage" 
                                       {{ in_array('users.manage', old('permissions', [])) ? 'checked' : '' }}
                                       class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                <span class="ml-2 text-sm text-gray-700">Quản lý người dùng</span>
                            </label>
                            <label class="flex items-center">
                                <input type="checkbox" name="permissions[]" value="reports.view" 
                                       {{ in_array('reports.view', old('permissions', [])) ? 'checked' : '' }}
                                       class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                <span class="ml-2 text-sm text-gray-700">Xem báo cáo</span>
                            </label>
                        </div>
                        @error('permissions')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Submit Button -->
            <div class="mt-8 flex justify-end space-x-3">
                <a href="{{ route('admin.users.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-2 rounded-lg">
                    Hủy
                </a>
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg">
                    <i class="fas fa-save mr-2"></i>Tạo Admin
                </button>
            </div>
        </form>
    </div>
</div>
@endsection