@extends('admin.layouts.app')

@section('title', 'Quản lý Khách hàng')

@section('content')
<div class="p-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-900">Quản lý Khách hàng</h1>
    </div>

    <!-- Search and Filters -->
    <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
        <form method="GET" action="{{ route('admin.customers.index') }}" class="flex flex-wrap gap-4">
            <div class="flex-1 min-w-64">
                <input type="text" name="search" value="{{ request('search') }}" 
                       placeholder="Tìm kiếm theo tên, email, số điện thoại, mã khách hàng..."
                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            
            <div>
                <select name="status" class="px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">Tất cả trạng thái</option>
                    <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Hoạt động</option>
                    <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Không hoạt động</option>
                    <option value="banned" {{ request('status') == 'banned' ? 'selected' : '' }}>Bị cấm</option>
                </select>
            </div>

            <div>
                <select name="loyalty_level" class="px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">Tất cả hạng</option>
                    <option value="bronze" {{ request('loyalty_level') == 'bronze' ? 'selected' : '' }}>Đồng</option>
                    <option value="silver" {{ request('loyalty_level') == 'silver' ? 'selected' : '' }}>Bạc</option>
                    <option value="gold" {{ request('loyalty_level') == 'gold' ? 'selected' : '' }}>Vàng</option>
                    <option value="diamond" {{ request('loyalty_level') == 'diamond' ? 'selected' : '' }}>Kim cương</option>
                </select>
            </div>

            <div>
                <select name="newsletter" class="px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">Newsletter</option>
                    <option value="yes" {{ request('newsletter') == 'yes' ? 'selected' : '' }}>Đăng ký</option>
                    <option value="no" {{ request('newsletter') == 'no' ? 'selected' : '' }}>Chưa đăng ký</option>
                </select>
            </div>
            
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md">
                Tìm kiếm
            </button>
            
            <a href="{{ route('admin.customers.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-md">
                Reset
            </a>
        </form>
    </div>

    <!-- Customers Table -->
    <div class="bg-white rounded-lg shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Khách hàng
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Liên hệ
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Địa chỉ
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Thống kê
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Trạng thái
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Thao tác
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($customers as $customer)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-10 w-10">
                                    <div class="h-10 w-10 rounded-full bg-blue-500 flex items-center justify-center">
                                        <span class="text-white font-medium">{{ substr($customer->name, 0, 1) }}</span>
                                    </div>
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-medium text-gray-900">{{ $customer->name }}</div>
                                    <div class="text-sm text-gray-500">{{ $customer->customer_code }}</div>
                                    <div class="text-sm text-gray-500">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                            {{ $customer->loyalty_level == 'diamond' ? 'bg-purple-100 text-purple-800' : '' }}
                                            {{ $customer->loyalty_level == 'gold' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                            {{ $customer->loyalty_level == 'silver' ? 'bg-gray-100 text-gray-800' : '' }}
                                            {{ $customer->loyalty_level == 'bronze' ? 'bg-orange-100 text-orange-800' : '' }}">
                                            {{ ucfirst($customer->loyalty_level) }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">{{ $customer->email }}</div>
                            <div class="text-sm text-gray-500">{{ $customer->phone }}</div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-sm text-gray-900">{{ $customer->address }}</div>
                            <div class="text-sm text-gray-500">{{ $customer->ward }}, {{ $customer->district }}, {{ $customer->city }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">{{ $customer->orders_count }} đơn hàng</div>
                            <div class="text-sm text-gray-500">{{ number_format($customer->total_spent) }}đ</div>
                            <div class="text-sm text-gray-500">{{ $customer->loyalty_points }} điểm</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex flex-col space-y-1">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                    {{ $customer->status == 'active' ? 'bg-green-100 text-green-800' : '' }}
                                    {{ $customer->status == 'inactive' ? 'bg-gray-100 text-gray-800' : '' }}
                                    {{ $customer->status == 'banned' ? 'bg-red-100 text-red-800' : '' }}">
                                    {{ $customer->status == 'active' ? 'Hoạt động' : '' }}
                                    {{ $customer->status == 'inactive' ? 'Không hoạt động' : '' }}
                                    {{ $customer->status == 'banned' ? 'Bị cấm' : '' }}
                                </span>
                                @if($customer->is_active)
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                        <i class="fas fa-check mr-1"></i>Kích hoạt
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-orange-100 text-orange-800">
                                        <i class="fas fa-pause mr-1"></i>Tạm dừng
                                    </span>
                                @endif
                                @if($customer->newsletter_subscription)
                                    <div class="text-xs text-green-600">📧 Newsletter</div>
                                @endif
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-2">
                            <a href="{{ route('admin.customers.show', $customer) }}"
                               class="text-blue-600 hover:text-blue-900" title="Xem chi tiết">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ route('admin.customers.edit', $customer) }}"
                               class="text-yellow-600 hover:text-yellow-900" title="Chỉnh sửa">
                                <i class="fas fa-edit"></i>
                            </a>
                            @if($customer->is_active)
                                <form method="POST" action="{{ route('admin.customers.deactivate', $customer) }}" class="inline">
                                    @csrf
                                    <button type="submit" class="text-orange-600 hover:text-orange-900" 
                                            title="Tạm dừng khách hàng"
                                            onclick="return confirm('Bạn có chắc muốn tạm dừng khách hàng này?')">
                                        <i class="fas fa-pause"></i>
                                    </button>
                                </form>
                            @else
                                <form method="POST" action="{{ route('admin.customers.activate', $customer) }}" class="inline">
                                    @csrf
                                    <button type="submit" class="text-green-600 hover:text-green-900" 
                                            title="Kích hoạt khách hàng"
                                            onclick="return confirm('Bạn có chắc muốn kích hoạt khách hàng này?')">
                                        <i class="fas fa-play"></i>
                                    </button>
                                </form>
                            @endif
                            @if($customer->status !== 'banned')
                                <button type="button" class="text-red-600 hover:text-red-900" 
                                        title="Cấm khách hàng"
                                        data-customer-id="{{ $customer->id }}"
                                        onclick="banCustomer(this.getAttribute('data-customer-id'))">
                                    <i class="fas fa-ban"></i>
                                </button>
                            @else
                                <button type="button" class="text-green-600 hover:text-green-900" 
                                        title="Bỏ cấm khách hàng"
                                        data-customer-id="{{ $customer->id }}"
                                        onclick="unbanCustomer(this.getAttribute('data-customer-id'))">
                                    <i class="fas fa-check-circle"></i>
                                </button>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-4 text-center text-gray-500">
                            Không tìm thấy khách hàng nào
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($customers->hasPages())
        <div class="bg-white px-4 py-3 border-t border-gray-200 sm:px-6">
            {{ $customers->links() }}
        </div>
        @endif
    </div>
</div>

<script>
function banCustomer(customerId) {
    if (!confirm('Bạn có chắc muốn cấm khách hàng này?')) {
        return;
    }
    
    fetch(`/admin/customers/${customerId}/ban`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => {
        console.log('Response status:', response.status);
        console.log('Response headers:', response.headers);
        
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        
        return response.json();
    })
    .then(data => {
        console.log('Response data:', data);
        
        if (data.success) {
            // Show success message
            const alertDiv = document.createElement('div');
            alertDiv.className = 'fixed top-4 right-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg z-50';
            alertDiv.textContent = data.message;
            document.body.appendChild(alertDiv);
            
            // Auto hide after 3 seconds
            setTimeout(() => {
                alertDiv.remove();
            }, 3000);
            
            // Reload page after short delay
            setTimeout(() => {
                location.reload();
            }, 1000);
        } else {
            alert('Có lỗi xảy ra: ' + (data.message || 'Unknown error'));
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Có lỗi xảy ra khi cấm khách hàng: ' + error.message);
    });
}

function unbanCustomer(customerId) {
    if (!confirm('Bạn có chắc muốn bỏ cấm khách hàng này?')) {
        return;
    }
    
    fetch(`/admin/customers/${customerId}/unban`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => {
        console.log('Response status:', response.status);
        console.log('Response headers:', response.headers);
        
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        
        return response.json();
    })
    .then(data => {
        console.log('Response data:', data);
        
        if (data.success) {
            // Show success message
            const alertDiv = document.createElement('div');
            alertDiv.className = 'fixed top-4 right-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg z-50';
            alertDiv.textContent = data.message;
            document.body.appendChild(alertDiv);
            
            // Auto hide after 3 seconds
            setTimeout(() => {
                alertDiv.remove();
            }, 3000);
            
            // Reload page after short delay
            setTimeout(() => {
                location.reload();
            }, 1000);
        } else {
            alert('Có lỗi xảy ra: ' + (data.message || 'Unknown error'));
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Có lỗi xảy ra khi bỏ cấm khách hàng: ' + error.message);
    });
}
</script>
@endsection 