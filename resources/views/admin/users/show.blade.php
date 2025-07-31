@extends('admin.layouts.app')

@section('title', 'Chi tiết Admin')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-900">Chi tiết Admin: {{ $user->name }}</h1>
        <a href="{{ route('admin.users.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg">
            <i class="fas fa-arrow-left mr-2"></i>Quay lại
        </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Admin Information -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Basic Information -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">Thông tin cơ bản</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Tên Admin</label>
                        <p class="text-sm text-gray-900">{{ $user->name }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Email</label>
                        <p class="text-sm text-gray-900">{{ $user->email }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Vai trò</label>
                        <div class="mt-1">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                @switch($user->role)
                                    @case('super_admin') bg-purple-100 text-purple-800 @break
                                    @case('admin') bg-blue-100 text-blue-800 @break
                                    @case('manager') bg-green-100 text-green-800 @break
                                    @case('staff') bg-gray-100 text-gray-800 @break
                                    @default bg-gray-100 text-gray-800
                                @endswitch">
                                {{ $user->role_display }}
                            </span>
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Trạng thái</label>
                        <div class="mt-1">
                            @if($user->is_active)
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    <i class="fas fa-check-circle mr-1"></i>Hoạt động
                                </span>
                            @else
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                    <i class="fas fa-ban mr-1"></i>Không hoạt động
                                </span>
                            @endif
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Phòng ban</label>
                        <p class="text-sm text-gray-900">{{ $user->department ?? 'Chưa có' }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Mã nhân viên</label>
                        <p class="text-sm text-gray-900">{{ $user->employee_id ?? 'Chưa có' }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Ngày thuê</label>
                        <p class="text-sm text-gray-900">{{ $user->hire_date ? $user->hire_date->format('d/m/Y') : 'Chưa có' }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Ngày tham gia</label>
                        <p class="text-sm text-gray-900">{{ $user->created_at->format('d/m/Y') }}</p>
                    </div>
                </div>
            </div>

            <!-- Permissions -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">Quyền hạn</h2>
                <div class="space-y-2">
                    @if($user->permissions && count($user->permissions) > 0)
                        @foreach($user->permissions as $permission)
                            <div class="flex items-center">
                                <i class="fas fa-check text-green-500 mr-2"></i>
                                <span class="text-sm text-gray-700">{{ $permission }}</span>
                            </div>
                        @endforeach
                    @else
                        <p class="text-sm text-gray-500">Chưa có quyền hạn cụ thể</p>
                    @endif
                </div>
            </div>

            <!-- Recent Activity -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">Hoạt động gần đây</h2>
                <div class="space-y-4">
                    @forelse($user->orderTracking()->with('order')->latest()->take(5)->get() as $tracking)
                    <div class="flex items-center justify-between p-4 border border-gray-200 rounded-lg">
                        <div>
                            <h3 class="text-sm font-medium text-gray-900">{{ $tracking->title ?? 'Cập nhật đơn hàng' }}</h3>
                            <p class="text-sm text-gray-500">{{ $tracking->created_at->format('d/m/Y H:i') }}</p>
                        </div>
                        <div class="text-right">
                            <p class="text-sm text-gray-900">#{{ $tracking->order->order_code ?? 'N/A' }}</p>
                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                {{ $tracking->status_display }}
                            </span>
                        </div>
                    </div>
                    @empty
                    <div class="text-center py-8">
                        <i class="fas fa-history text-4xl text-gray-300 mb-4"></i>
                        <p class="text-gray-500">Chưa có hoạt động nào</p>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Admin Avatar -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">Ảnh đại diện</h2>
                <div class="text-center">
                    <div class="h-32 w-32 rounded-full bg-blue-100 flex items-center justify-center mx-auto">
                        <i class="fas fa-user-shield text-4xl text-blue-600"></i>
                    </div>
                </div>
            </div>

            <!-- Admin Statistics -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">Thống kê</h2>
                <div class="space-y-4">
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-600">Hoạt động đã tạo:</span>
                        <span class="text-lg font-semibold text-blue-600">{{ $user->orderTracking()->count() }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-600">Ngày tham gia:</span>
                        <span class="text-sm font-medium">{{ $user->created_at->format('d/m/Y') }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-600">Đăng nhập cuối:</span>
                        <span class="text-sm font-medium">{{ $user->last_login_at ? $user->last_login_at->format('d/m/Y H:i') : 'Chưa có' }}</span>
                    </div>
                </div>
            </div>

            <!-- Actions -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">Thao tác</h2>
                <div class="space-y-3">
                    <a href="{{ route('admin.users.edit', $user) }}" class="w-full bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-center block">
                        <i class="fas fa-edit mr-2"></i>Chỉnh sửa
                    </a>
                    @if($user->is_active)
                    <button onclick="banUser({{ $user->id }})" class="w-full bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg">
                        <i class="fas fa-ban mr-2"></i>Vô hiệu hóa
                    </button>
                    @else
                    <button onclick="unbanUser({{ $user->id }})" class="w-full bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg">
                        <i class="fas fa-unlock mr-2"></i>Kích hoạt
                    </button>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function banUser(userId) {
    if (confirm('Bạn có chắc chắn muốn cấm người dùng này?')) {
        fetch(`/admin/users/${userId}/ban`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            } else {
                alert('Lỗi: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Có lỗi xảy ra');
        });
    }
}

function unbanUser(userId) {
    if (confirm('Bạn có chắc chắn muốn bỏ cấm người dùng này?')) {
        fetch(`/admin/users/${userId}/unban`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            } else {
                alert('Lỗi: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Có lỗi xảy ra');
        });
    }
}
</script>
@endsection 