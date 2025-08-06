@extends('admin.layouts.app')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('content')
<div class="space-y-6">
    <!-- Stats Cards -->
    @if(isset($can_view_stats) && $can_view_stats)
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Total Products -->
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-blue-100 text-blue-600">
                    <i class="fas fa-box text-2xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Tổng sản phẩm</p>
                    <p class="text-2xl font-semibold text-gray-900">{{ number_format($stats['total_products'] ?? 0) }}</p>
                </div>
            </div>
        </div>

        <!-- Total Orders -->
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-green-100 text-green-600">
                    <i class="fas fa-shopping-cart text-2xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Tổng đơn hàng</p>
                    <p class="text-2xl font-semibold text-gray-900">{{ number_format($stats['total_orders'] ?? 0) }}</p>
                </div>
            </div>
        </div>

        <!-- Total Users -->
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-purple-100 text-purple-600">
                    <i class="fas fa-users text-2xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Tổng người dùng</p>
                    <p class="text-2xl font-semibold text-gray-900">{{ number_format($stats['total_users'] ?? 0) }}</p>
                </div>
            </div>
        </div>

        <!-- Total Revenue -->
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-yellow-100 text-yellow-600">
                    <i class="fas fa-dollar-sign text-2xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Tổng doanh thu</p>
                    <p class="text-2xl font-semibold text-gray-900">{{ number_format($stats['total_revenue'] ?? 0) }} ₫</p>
                </div>
            </div>
        </div>
    </div>
    @else
    <!-- No stats permission message -->
    <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
        <div class="flex">
            <div class="flex-shrink-0">
                <i class="fas fa-info-circle text-yellow-400"></i>
            </div>
            <div class="ml-3">
                <h3 class="text-sm font-medium text-yellow-800">
                    Thông báo
                </h3>
                <div class="mt-2 text-sm text-yellow-700">
                    <p>Bạn không có quyền xem thống kê tổng quan. Liên hệ quản trị viên để được cấp quyền.</p>
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- Recent Orders & Low Stock -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Recent Orders -->
        @if(isset($can_view_orders) && $can_view_orders)
        <div class="bg-white rounded-lg shadow">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-medium text-gray-900">Đơn hàng gần đây</h3>
            </div>
            <div class="p-6">
                @if(isset($recent_orders) && $recent_orders->count() > 0)
                    <div class="space-y-4">
                        @foreach($recent_orders as $order)
                        <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                            <div>
                                <p class="font-medium text-gray-900">#{{ $order->order_code }}</p>
                                <p class="text-sm text-gray-600">{{ $order->customer_name }}</p>
                                <p class="text-xs text-gray-500">{{ $order->created_at->format('d/m/Y H:i') }}</p>
                            </div>
                            <div class="text-right">
                                <p class="font-medium text-gray-900">{{ number_format($order->total_amount) }} ₫</p>
                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full
                                    @if($order->status === 'pending') bg-yellow-100 text-yellow-800
                                    @elseif($order->status === 'confirmed') bg-blue-100 text-blue-800
                                    @elseif($order->status === 'processing') bg-purple-100 text-purple-800
                                    @elseif($order->status === 'shipped') bg-indigo-100 text-indigo-800
                                    @elseif($order->status === 'delivered') bg-green-100 text-green-800
                                    @else bg-red-100 text-red-800
                                    @endif">
                                    {{ ucfirst($order->status) }}
                                </span>
                            </div>
                        </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-gray-500 text-center py-4">Chưa có đơn hàng nào</p>
                @endif
            </div>
        </div>
        @else
        <div class="bg-white rounded-lg shadow">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-medium text-gray-900">Đơn hàng gần đây</h3>
            </div>
            <div class="p-6">
                <div class="text-center py-8 text-gray-500">
                    <i class="fas fa-lock text-4xl mb-4"></i>
                    <p>Bạn không có quyền xem đơn hàng</p>
                </div>
            </div>
        </div>
        @endif

        <!-- Low Stock Products -->
        @if(isset($can_view_products) && $can_view_products)
        <div class="bg-white rounded-lg shadow">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-medium text-gray-900">Sản phẩm sắp hết hàng</h3>
            </div>
            <div class="p-6">
                @if(isset($low_stock_products) && $low_stock_products->count() > 0)
                    <div class="space-y-4">
                        @foreach($low_stock_products as $product)
                        <div class="flex items-center justify-between p-4 bg-red-50 rounded-lg">
                            <div>
                                <p class="font-medium text-gray-900">{{ $product->name }}</p>
                                <p class="text-sm text-gray-600">SKU: {{ $product->sku }}</p>
                                <p class="text-xs text-red-600">Còn lại: {{ $product->stock_quantity }}</p>
                            </div>
                            <div class="text-right">
                                <a href="{{ route('admin.products.edit', $product) }}" 
                                   class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                                    Cập nhật
                                </a>
                            </div>
                        </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-gray-500 text-center py-4">Tất cả sản phẩm đều có đủ hàng</p>
                @endif
            </div>
        </div>
        @else
        <div class="bg-white rounded-lg shadow">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-medium text-gray-900">Sản phẩm sắp hết hàng</h3>
            </div>
            <div class="p-6">
                <div class="text-center py-8 text-gray-500">
                    <i class="fas fa-lock text-4xl mb-4"></i>
                    <p>Bạn không có quyền xem sản phẩm</p>
                </div>
            </div>
        </div>
        @endif
    </div>

    <!-- System Status & Alerts -->
    <div class="bg-white rounded-lg shadow">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-medium text-gray-900">Trạng thái hệ thống</h3>
        </div>
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- System Health -->
                <div class="text-center">
                    <div class="inline-flex items-center justify-center w-12 h-12 bg-green-100 rounded-full mb-3">
                        <i class="fas fa-check-circle text-green-600 text-xl"></i>
                    </div>
                    <h4 class="text-sm font-medium text-gray-900 mb-1">Hệ thống</h4>
                    <p class="text-sm text-green-600">Hoạt động bình thường</p>
                </div>

                <!-- Database Status -->
                <div class="text-center">
                    <div class="inline-flex items-center justify-center w-12 h-12 bg-blue-100 rounded-full mb-3">
                        <i class="fas fa-database text-blue-600 text-xl"></i>
                    </div>
                    <h4 class="text-sm font-medium text-gray-900 mb-1">Cơ sở dữ liệu</h4>
                    <p class="text-sm text-blue-600">Kết nối ổn định</p>
                </div>

                <!-- Storage Status -->
                <div class="text-center">
                    <div class="inline-flex items-center justify-center w-12 h-12 bg-purple-100 rounded-full mb-3">
                        <i class="fas fa-hdd text-purple-600 text-xl"></i>
                    </div>
                    <h4 class="text-sm font-medium text-gray-900 mb-1">Lưu trữ</h4>
                    <p class="text-sm text-purple-600">Còn trống 85%</p>
                </div>
            </div>

            <!-- Quick Stats Row -->
            @if(isset($can_view_stats) && $can_view_stats)
            <div class="mt-6 pt-6 border-t border-gray-200">
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-center">
                    <div>
                        <p class="text-2xl font-bold text-blue-600">{{ $stats['total_products'] ?? 0 }}</p>
                        <p class="text-xs text-gray-500">Sản phẩm</p>
                    </div>
                    <div>
                        <p class="text-2xl font-bold text-green-600">{{ $stats['total_orders'] ?? 0 }}</p>
                        <p class="text-xs text-gray-500">Đơn hàng</p>
                    </div>
                    <div>
                        <p class="text-2xl font-bold text-purple-600">{{ $stats['total_users'] ?? 0 }}</p>
                        <p class="text-xs text-gray-500">Người dùng</p>
                    </div>
                    <div>
                        <p class="text-2xl font-bold text-yellow-600">{{ number_format(($stats['total_revenue'] ?? 0) / 1000000, 1) }}M</p>
                        <p class="text-xs text-gray-500">Doanh thu (VNĐ)</p>
                    </div>
                </div>
            </div>
            @endif

            <!-- Action Buttons (Compact) -->
            <div class="mt-6 pt-6 border-t border-gray-200">
                <div class="flex flex-wrap gap-2 justify-center">
                    <a href="{{ route('admin.products.index') }}" 
                       class="inline-flex items-center px-3 py-2 bg-blue-100 text-blue-700 text-sm font-medium rounded-lg hover:bg-blue-200 transition-colors">
                        <i class="fas fa-box mr-2"></i>
                        Quản lý sản phẩm
                    </a>
                    <a href="{{ route('admin.orders.index') }}" 
                       class="inline-flex items-center px-3 py-2 bg-green-100 text-green-700 text-sm font-medium rounded-lg hover:bg-green-200 transition-colors">
                        <i class="fas fa-shopping-cart mr-2"></i>
                        Quản lý đơn hàng
                    </a>
                    @if(auth()->user()->hasPermission('revenue.view'))
                    <a href="{{ route('admin.revenue.index') }}" 
                       class="inline-flex items-center px-3 py-2 bg-yellow-100 text-yellow-700 text-sm font-medium rounded-lg hover:bg-yellow-200 transition-colors">
                        <i class="fas fa-chart-line mr-2"></i>
                        Báo cáo doanh thu
                    </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 