@extends('admin.layouts.app')

@section('title', 'Chi tiết đơn hàng')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-900">Chi tiết đơn hàng #{{ $order->order_number }}</h1>
        <div class="flex space-x-2">
            <a href="{{ route('admin.orders.printInvoice', $order) }}" class="bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded-lg" target="_blank">
                <i class="fas fa-print mr-2"></i>In hóa đơn
            </a>
            <a href="{{ route('admin.orders.edit', $order) }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg">
                <i class="fas fa-edit mr-2"></i>Chỉnh sửa
            </a>
            <a href="{{ route('admin.orders.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg">
                <i class="fas fa-arrow-left mr-2"></i>Quay lại
            </a>
        </div>
    </div>

    <!-- Quick Status Update -->
    <div class="bg-white rounded-lg shadow-md p-6 mb-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Cập nhật trạng thái nhanh</h3>
        <form action="{{ route('admin.orders.update-status', $order) }}" method="POST" class="flex items-end space-x-4">
            @csrf
            @method('PATCH')
            <div class="flex-1">
                <label class="block text-sm font-medium text-gray-700 mb-1">Trạng thái mới</label>
                <select name="status" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Chờ xử lý</option>
                    <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>Đang xử lý</option>
                    <option value="shipped" {{ $order->status == 'shipped' ? 'selected' : '' }}>Đã gửi hàng</option>
                    <option value="delivered" {{ $order->status == 'delivered' ? 'selected' : '' }}>Đã giao hàng</option>
                    <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Đã hủy</option>
                </select>
            </div>
            <div class="flex-1">
                <label class="block text-sm font-medium text-gray-700 mb-1">Ghi chú admin</label>
                <input type="text" name="admin_note" placeholder="Ghi chú (tùy chọn)" 
                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded-lg">
                <i class="fas fa-save mr-2"></i>Cập nhật
            </button>
        </form>
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
                        <p class="text-sm text-gray-900 font-medium">#{{ $order->order_number }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Ngày đặt</label>
                        <p class="text-sm text-gray-900">{{ $order->created_at->format('d/m/Y H:i') }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Trạng thái hiện tại</label>
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
                            @endswitch
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Phương thức thanh toán</label>
                        <p class="text-sm text-gray-900">{{ $order->payment_method ?? 'Chưa xác định' }}</p>
                    </div>
                    @if($order->admin_note)
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700">Ghi chú admin</label>
                        <p class="text-sm text-gray-900 bg-yellow-50 p-2 rounded">{{ $order->admin_note }}</p>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Order Items -->
            <div class="bg-white rounded-lg shadow-md">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h2 class="text-lg font-semibold text-gray-900">Sản phẩm đã đặt</h2>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Sản phẩm</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">SKU</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Đơn giá</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Số lượng</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Thành tiền</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($order->orderDetails as $detail)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        @if($detail->product && $detail->product->images->count() > 0)
                                            <img src="{{ $detail->product->images->first()->url }}" alt="{{ $detail->product_name }}" class="h-10 w-10 rounded object-cover mr-3">
                                        @else
                                            <div class="h-10 w-10 bg-gray-200 rounded flex items-center justify-center mr-3">
                                                <i class="fas fa-image text-gray-400"></i>
                                            </div>
                                        @endif
                                        <div>
                                            <div class="text-sm font-medium text-gray-900">{{ $detail->product_name }}</div>
                                            @if($detail->product)
                                                <div class="text-sm text-gray-500">{{ $detail->product->category->name ?? '' }}</div>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $detail->product->sku ?? 'N/A' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ number_format($detail->unit_price) }} VNĐ
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ $detail->quantity }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                    {{ number_format($detail->total_price) }} VNĐ
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Customer & Payment Info -->
        <div class="lg:col-span-1 space-y-6">
            <!-- Customer Information -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">Thông tin khách hàng</h2>
                <div class="space-y-3">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Tên khách hàng</label>
                        <p class="text-sm text-gray-900">{{ $order->customer->name ?? $order->customer_name ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Email</label>
                        <p class="text-sm text-gray-900">{{ $order->customer->email ?? $order->customer_email ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Số điện thoại</label>
                        <p class="text-sm text-gray-900">{{ $order->phone ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Địa chỉ giao hàng</label>
                        <p class="text-sm text-gray-900">{{ $order->shipping_address ?? 'N/A' }}</p>
                    </div>
                    @if($order->customer)
                    <div class="pt-3 border-t">
                        <a href="{{ route('admin.customers.show', $order->customer) }}" class="text-blue-600 hover:text-blue-900 text-sm font-medium">
                            <i class="fas fa-user mr-1"></i>Xem thông tin khách hàng
                        </a>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Order Summary -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">Tổng kết đơn hàng</h2>
                <div class="space-y-3">
                    <div class="flex justify-between">
                        <span class="text-sm text-gray-600">Tạm tính:</span>
                        <span class="text-sm text-gray-900">{{ number_format($order->subtotal ?? 0) }} VNĐ</span>
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
                        <span class="text-sm text-gray-900">{{ number_format($order->shipping_fee) }} VNĐ</span>
                    </div>
                    @endif
                    <div class="flex justify-between pt-3 border-t font-semibold">
                        <span class="text-base text-gray-900">Tổng cộng:</span>
                        <span class="text-base text-gray-900">{{ number_format($order->total_amount) }} VNĐ</span>
                    </div>
                </div>
            </div>

            <!-- Order Timeline -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">Lịch sử đơn hàng</h2>
                <div class="space-y-4">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 w-8 h-8 bg-green-100 rounded-full flex items-center justify-center">
                            <i class="fas fa-plus text-green-600 text-sm"></i>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-gray-900">Đơn hàng được tạo</p>
                            <p class="text-sm text-gray-500">{{ $order->created_at->format('d/m/Y H:i') }}</p>
                        </div>
                    </div>
                    
                    @if($order->updated_at != $order->created_at)
                    <div class="flex items-center">
                        <div class="flex-shrink-0 w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center">
                            <i class="fas fa-edit text-blue-600 text-sm"></i>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-gray-900">Cập nhật lần cuối</p>
                            <p class="text-sm text-gray-500">{{ $order->updated_at->format('d/m/Y H:i') }}</p>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 