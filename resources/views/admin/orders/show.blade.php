@extends('admin.layouts.app')

@section('title', 'Chi tiết đơn hàng')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-900">Chi tiết đơn hàng #{{ $order->order_number }}</h1>
        <a href="{{ route('admin.orders.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg">
            <i class="fas fa-arrow-left mr-2"></i>Quay lại
        </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Order Details -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Order Information -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">Thông tin đơn hàng</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Mã đơn hàng</label>
                        <p class="text-sm text-gray-900">#{{ $order->order_number }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Ngày đặt</label>
                        <p class="text-sm text-gray-900">{{ $order->created_at->format('d/m/Y H:i') }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Trạng thái</label>
                        <div class="mt-1">
                            @switch($order->status)
                                @case('pending')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                        <i class="fas fa-clock mr-1"></i>Chờ xử lý
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
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Phương thức thanh toán</label>
                        <p class="text-sm text-gray-900">{{ $order->payment_method ?? 'Chưa chọn' }}</p>
                    </div>
                </div>
            </div>

            <!-- Order Items -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">Sản phẩm đã đặt</h2>
                <div class="space-y-4">
                    @forelse($order->orderDetails as $item)
                    <div class="flex items-center space-x-4 p-4 border border-gray-200 rounded-lg">
                        <div class="flex-shrink-0">
                            @if($item->product && $item->product->images->first())
                                <img src="{{ $item->product->images->first()->url }}" alt="{{ $item->product->name }}" 
                                     class="h-16 w-16 object-cover rounded-lg">
                            @else
                                <div class="h-16 w-16 bg-gray-200 rounded-lg flex items-center justify-center">
                                    <i class="fas fa-image text-gray-400"></i>
                                </div>
                            @endif
                        </div>
                        <div class="flex-1 min-w-0">
                            <h3 class="text-sm font-medium text-gray-900">{{ $item->product->name ?? 'Sản phẩm không tồn tại' }}</h3>
                            <p class="text-sm text-gray-500">SKU: {{ $item->product->sku ?? 'N/A' }}</p>
                            <p class="text-sm text-gray-500">Số lượng: {{ $item->quantity }}</p>
                        </div>
                        <div class="text-right">
                            <p class="text-sm font-medium text-gray-900">{{ number_format($item->price) }} VNĐ</p>
                            <p class="text-sm text-gray-500">Tổng: {{ number_format($item->price * $item->quantity) }} VNĐ</p>
                        </div>
                    </div>
                    @empty
                    <div class="text-center py-8">
                        <i class="fas fa-box text-4xl text-gray-300 mb-4"></i>
                        <p class="text-gray-500">Không có sản phẩm nào trong đơn hàng</p>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Customer & Payment Info -->
        <div class="space-y-6">
            <!-- Customer Information -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">Thông tin khách hàng</h2>
                <div class="space-y-3">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Tên khách hàng</label>
                        <p class="text-sm text-gray-900">{{ $order->user->name ?? $order->customer_name ?? 'Khách' }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Email</label>
                        <p class="text-sm text-gray-900">{{ $order->user->email ?? $order->email ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Số điện thoại</label>
                        <p class="text-sm text-gray-900">{{ $order->phone ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Địa chỉ giao hàng</label>
                        <p class="text-sm text-gray-900">{{ $order->shipping_address ?? 'N/A' }}</p>
                    </div>
                </div>
            </div>

            <!-- Order Summary -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">Tổng quan đơn hàng</h2>
                <div class="space-y-3">
                    <div class="flex justify-between">
                        <span class="text-sm text-gray-600">Tổng tiền hàng:</span>
                        <span class="text-sm font-medium">{{ number_format($order->subtotal ?? $order->total_amount) }} VNĐ</span>
                    </div>
                    @if($order->discount_amount > 0)
                    <div class="flex justify-between">
                        <span class="text-sm text-gray-600">Giảm giá:</span>
                        <span class="text-sm text-green-600">-{{ number_format($order->discount_amount) }} VNĐ</span>
                    </div>
                    @endif
                    @if($order->shipping_fee > 0)
                    <div class="flex justify-between">
                        <span class="text-sm text-gray-600">Phí vận chuyển:</span>
                        <span class="text-sm font-medium">{{ number_format($order->shipping_fee) }} VNĐ</span>
                    </div>
                    @endif
                    <div class="border-t pt-3">
                        <div class="flex justify-between">
                            <span class="text-base font-semibold text-gray-900">Tổng cộng:</span>
                            <span class="text-base font-semibold text-gray-900">{{ number_format($order->total_amount) }} VNĐ</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Status Update -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">Cập nhật trạng thái</h2>
                <form action="{{ route('admin.orders.update-status', $order) }}" method="POST">
                    @csrf
                    @method('PATCH')
                    <div class="space-y-3">
                        <div>
                            <label for="status" class="block text-sm font-medium text-gray-700">Trạng thái mới</label>
                            <select id="status" name="status" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Chờ xử lý</option>
                                <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>Đang xử lý</option>
                                <option value="shipped" {{ $order->status == 'shipped' ? 'selected' : '' }}>Đã gửi hàng</option>
                                <option value="delivered" {{ $order->status == 'delivered' ? 'selected' : '' }}>Đã giao hàng</option>
                                <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Đã hủy</option>
                            </select>
                        </div>
                        <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg">
                            <i class="fas fa-save mr-2"></i>Cập nhật trạng thái
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection 