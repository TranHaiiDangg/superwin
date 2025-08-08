@extends('admin.layouts.app')

@section('title', 'Quản lý đơn hàng')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-900">Quản lý đơn hàng</h1>
        <div class="flex space-x-2">
            <!-- Export Options Button -->
            <div class="relative">
                <button onclick="toggleExportMenu()" 
                        class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg flex items-center">
                    <i class="fas fa-download mr-2"></i>
                    Xuất Excel
                    <i class="fas fa-chevron-down ml-2"></i>
                </button>
                
                <!-- Export Menu -->
                <div id="exportMenu" class="hidden absolute right-0 mt-2 w-80 bg-white rounded-lg shadow-lg border border-gray-200 z-50">
                    <div class="p-4">
                        <h3 class="text-sm font-medium text-gray-900 mb-3">Tùy chọn xuất dữ liệu</h3>
                        
                        <!-- Export Today -->
                        <div class="mb-4">
                            <label class="flex items-center">
                                <input type="radio" name="exportType" value="today" checked class="mr-2">
                                <span class="text-sm">Xuất đơn hàng hôm nay</span>
                            </label>
                        </div>
                        
                        <!-- Export by Date Range -->
                        <div class="mb-4">
                            <label class="flex items-center mb-2">
                                <input type="radio" name="exportType" value="date_range" class="mr-2">
                                <span class="text-sm">Xuất theo khoảng thời gian</span>
                            </label>
                            <div id="dateRangeInputs" class="ml-6 hidden">
                                <div class="flex space-x-2 mb-2">
                                    <div>
                                        <label class="block text-xs text-gray-600 mb-1">Từ ngày</label>
                                        <input type="date" id="startDate" 
                                               class="px-3 py-1 border border-gray-300 rounded text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                                               value="{{ date('Y-m-01') }}">
                                    </div>
                                    <div>
                                        <label class="block text-xs text-gray-600 mb-1">Đến ngày</label>
                                        <input type="date" id="endDate" 
                                               class="px-3 py-1 border border-gray-300 rounded text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                                               value="{{ date('Y-m-d') }}">
                                    </div>
                                </div>
                                <div class="flex space-x-2">
                                    <button onclick="setDateRange('today')" 
                                            class="px-2 py-1 bg-gray-100 hover:bg-gray-200 text-xs rounded">Hôm nay</button>
                                    <button onclick="setDateRange('week')" 
                                            class="px-2 py-1 bg-gray-100 hover:bg-gray-200 text-xs rounded">7 ngày qua</button>
                                    <button onclick="setDateRange('month')" 
                                            class="px-2 py-1 bg-gray-100 hover:bg-gray-200 text-xs rounded">Tháng này</button>
                                </div>
                            </div>
                        </div>
                        
                        <div class="flex justify-end space-x-2 pt-3 border-t border-gray-200">
                            <button onclick="toggleExportMenu()" 
                                    class="px-3 py-1 text-sm text-gray-600 hover:text-gray-800">Hủy</button>
                            <button onclick="performExport()" 
                                    class="px-3 py-1 bg-green-600 hover:bg-green-700 text-white text-sm rounded">
                                Xuất Excel
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <i class="fas fa-shopping-cart text-2xl text-blue-500"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-500">Tổng đơn hàng</p>
                    <p class="text-2xl font-semibold text-gray-900">{{ number_format($stats['total']) }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <i class="fas fa-clock text-2xl text-yellow-500"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-500">Chờ xử lý</p>
                    <p class="text-2xl font-semibold text-gray-900">{{ number_format($stats['pending']) }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <i class="fas fa-money-bill-wave text-2xl text-green-500"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-500">Doanh thu hôm nay</p>
                    <p class="text-2xl font-semibold text-gray-900">{{ number_format($stats['today_revenue']) }}đ</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <i class="fas fa-chart-line text-2xl text-purple-500"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-500">Doanh thu tháng này</p>
                    <p class="text-2xl font-semibold text-gray-900">{{ number_format($stats['month_revenue']) }}đ</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Status Overview -->
    <div class="bg-white rounded-lg shadow-md p-6 mb-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Tổng quan trạng thái</h3>
        <div class="grid grid-cols-2 md:grid-cols-6 gap-4">
            <div class="text-center">
                <div class="text-2xl font-bold text-yellow-600">{{ $stats['pending'] }}</div>
                <div class="text-sm text-gray-500">Chờ xử lý</div>
            </div>
                                    <div class="text-center">
                            <div class="text-2xl font-bold text-green-600">{{ $stats['confirmed'] }}</div>
                            <div class="text-sm text-gray-500">Đã xác nhận</div>
                        </div>
                        <div class="text-center">
                            <div class="text-2xl font-bold text-blue-600">{{ $stats['processing'] }}</div>
                            <div class="text-sm text-gray-500">Đang xử lý</div>
                        </div>
            <div class="text-center">
                <div class="text-2xl font-bold text-purple-600">{{ $stats['shipped'] }}</div>
                <div class="text-sm text-gray-500">Đã gửi hàng</div>
            </div>
            <div class="text-center">
                <div class="text-2xl font-bold text-green-600">{{ $stats['delivered'] }}</div>
                <div class="text-sm text-gray-500">Đã giao hàng</div>
            </div>
            <div class="text-center">
                <div class="text-2xl font-bold text-red-600">{{ $stats['cancelled'] }}</div>
                <div class="text-sm text-gray-500">Đã hủy</div>
            </div>
        </div>
    </div>

    <!-- Search and Filter -->
    <div class="bg-white rounded-lg shadow-md p-6 mb-6">
        <form method="GET" action="{{ route('admin.orders.index') }}" class="space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Tìm kiếm</label>
                    <input type="text" name="search" value="{{ request('search') }}" 
                           placeholder="Mã đơn hàng, tên khách hàng, email..."
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Trạng thái</label>
                    <select name="status" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="">Tất cả trạng thái</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Chờ xử lý</option>
                        <option value="confirmed" {{ request('status') == 'confirmed' ? 'selected' : '' }}>Đã xác nhận</option>
                        <option value="processing" {{ request('status') == 'processing' ? 'selected' : '' }}>Đang xử lý</option>
                        <option value="shipped" {{ request('status') == 'shipped' ? 'selected' : '' }}>Đã gửi hàng</option>
                        <option value="delivered" {{ request('status') == 'delivered' ? 'selected' : '' }}>Đã giao hàng</option>
                        <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Đã hủy</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Phương thức thanh toán</label>
                    <select name="payment_method" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="">Tất cả</option>
                        <option value="cod" {{ request('payment_method') == 'cod' ? 'selected' : '' }}>Thanh toán khi nhận hàng (COD)</option>
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Từ ngày</label>
                    <input type="date" name="date_from" value="{{ request('date_from') }}"
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Đến ngày</label>
                    <input type="date" name="date_to" value="{{ request('date_to') }}"
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
            </div>

            <div class="flex space-x-2">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg">
                    <i class="fas fa-search mr-2"></i>Tìm kiếm
                </button>
                <a href="{{ route('admin.orders.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg">
                    <i class="fas fa-times mr-2"></i>Xóa bộ lọc
                </a>
            </div>
        </form>
    </div>

    <!-- Orders Table -->
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Mã đơn hàng
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Khách hàng
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Sản phẩm
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Tổng tiền
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Trạng thái
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Ngày đặt
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Thao tác
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($orders as $order)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900">#{{ $order->order_code }}</div>
                            <div class="text-sm text-gray-500">ID: {{ $order->id }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div>
                                    <div class="text-sm font-medium text-gray-900">{{ $order->customer->name ?? $order->customer_name ?? 'Khách' }}</div>
                                    <div class="text-sm text-gray-500">{{ $order->customer->email ?? $order->customer_email ?? 'N/A' }}</div>
                                    <div class="text-sm text-gray-500">{{ $order->customer_phone }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">{{ $order->orderDetails->count() }} sản phẩm</div>
                            @if($order->orderDetails->count() > 0)
                                <div class="text-xs text-gray-500">
                                    {{ $order->orderDetails->first()->product->name ?? 'N/A' }}
                                    @if($order->orderDetails->count() > 1)
                                        và {{ $order->orderDetails->count() - 1 }} sản phẩm khác
                                    @endif
                                </div>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900">
                                {{ number_format($order->total_amount) }} VNĐ
                            </div>
                            @if($order->discount_amount > 0)
                                <div class="text-sm text-green-600">
                                    -{{ number_format($order->discount_amount) }} VNĐ
                                </div>
                            @endif
                            <div class="text-xs text-gray-500">
                                @if($order->payment_method == 'cod')
                                    <span class="bg-orange-100 text-orange-800 px-2 py-1 rounded-full text-xs">COD</span>
                                @else
                                    <span class="bg-gray-100 text-gray-800 px-2 py-1 rounded-full text-xs">N/A</span>
                                @endif
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @switch($order->status)
                                @case('pending')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                        <i class="fas fa-clock mr-1"></i>Chờ xử lý
                                    </span>
                                    @break
                                @case('confirmed')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        <i class="fas fa-check mr-1"></i>Đã xác nhận
                                    </span>
                                    @break
                                @case('processing')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                        <i class="fas fa-cog mr-1"></i>Đang xử lý
                                    </span>
                                    @break
                                @case('shipped')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800">
                                        <i class="fas fa-shipping-fast mr-1"></i>Đã gửi hàng
                                    </span>
                                    @break
                                @case('delivered')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        <i class="fas fa-check mr-1"></i>Đã giao hàng
                                    </span>
                                    @break
                                @case('cancelled')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                        <i class="fas fa-times mr-1"></i>Đã hủy
                                    </span>
                                    @break
                                @default
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                        {{ $order->status }}
                                    </span>
                            @endswitch
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $order->created_at->format('d/m/Y H:i') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <div class="flex space-x-2">
                                <a href="{{ route('admin.orders.show', $order) }}" 
                                   class="text-blue-600 hover:text-blue-900" title="Xem chi tiết">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('admin.orders.edit', $order) }}" 
                                   class="text-green-600 hover:text-green-900" title="Chỉnh sửa">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <a href="{{ route('admin.orders.printInvoice', $order) }}" 
                                   class="text-purple-600 hover:text-purple-900" title="In hóa đơn" target="_blank">
                                    <i class="fas fa-print"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-6 py-4 text-center text-gray-500">
                            <div class="flex flex-col items-center py-8">
                                <i class="fas fa-shopping-cart text-4xl text-gray-300 mb-4"></i>
                                <p class="text-lg font-medium">Không có đơn hàng nào</p>
                                <p class="text-sm">Chưa có đơn hàng nào được tạo</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($orders->hasPages())
        <div class="bg-white px-4 py-3 border-t border-gray-200 sm:px-6">
            {{ $orders->appends(request()->query())->links() }}
        </div>
        @endif
    </div>
</div>

<script>
function toggleExportMenu() {
    const menu = document.getElementById('exportMenu');
    menu.classList.toggle('hidden');
}

// Đóng menu khi click bên ngoài
document.addEventListener('click', function(event) {
    const menu = document.getElementById('exportMenu');
    const button = event.target.closest('[onclick="toggleExportMenu()"]');
    if (!button && !menu.contains(event.target)) {
        menu.classList.add('hidden');
    }
});

// Toggle hiển thị date range inputs
document.addEventListener('change', function(event) {
    if (event.target.name === 'exportType') {
        const dateRangeInputs = document.getElementById('dateRangeInputs');
        if (event.target.value === 'date_range') {
            dateRangeInputs.classList.remove('hidden');
        } else {
            dateRangeInputs.classList.add('hidden');
        }
    }
});

function setDateRange(type) {
    const today = new Date();
    const startDate = document.getElementById('startDate');
    const endDate = document.getElementById('endDate');
    
    let start, end;
    
    switch(type) {
        case 'today':
            start = end = today;
            break;
        case 'week':
            start = new Date(today.getTime() - 6 * 24 * 60 * 60 * 1000);
            end = today;
            break;
        case 'month':
            start = new Date(today.getFullYear(), today.getMonth(), 1);
            end = today;
            break;
    }
    
    startDate.value = start.toISOString().split('T')[0];
    endDate.value = end.toISOString().split('T')[0];
}

function performExport() {
    const exportType = document.querySelector('input[name="exportType"]:checked').value;
    
    if (exportType === 'today') {
        window.location.href = '{{ route("admin.orders.exportOrders") }}?export_type=today';
    } else {
        const startDate = document.getElementById('startDate').value;
        const endDate = document.getElementById('endDate').value;
        
        if (!startDate || !endDate) {
            alert('Vui lòng chọn khoảng thời gian');
            return;
        }
        
        if (new Date(startDate) > new Date(endDate)) {
            alert('Ngày bắt đầu phải nhỏ hơn ngày kết thúc');
            return;
        }
        
        window.location.href = `{{ route("admin.orders.exportOrders") }}?export_type=date_range&start_date=${startDate}&end_date=${endDate}`;
    }
    
    // Đóng menu
    toggleExportMenu();
}
</script>

@endsection 