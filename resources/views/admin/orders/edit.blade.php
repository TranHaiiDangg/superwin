@extends('admin.layouts.app')

@section('title', 'Chỉnh sửa đơn hàng')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-900">Chỉnh sửa đơn hàng #{{ $order->order_code }}</h1>
        <a href="{{ route('admin.orders.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg">
            <i class="fas fa-arrow-left mr-2"></i>Quay lại
        </a>
    </div>

    <div class="bg-white rounded-lg shadow-md p-6">
        <form action="{{ route('admin.orders.update', $order->id) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Order Information -->
                <div class="space-y-4">
                    <h3 class="text-lg font-semibold text-gray-700 border-b pb-2">Thông tin đơn hàng</h3>
                    
                    <div>
                        <label for="order_code" class="block text-sm font-medium text-gray-700 mb-2">Mã đơn hàng</label>
                        <input type="text" id="order_code" name="order_code" value="{{ old('order_code', $order->order_code) }}" required
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        @error('order_code')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="status" class="block text-sm font-medium text-gray-700 mb-2">Trạng thái</label>
                        <select id="status" name="status" required
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="pending" {{ old('status', $order->status) == 'pending' ? 'selected' : '' }}>Chờ xử lý</option>
                            <option value="confirmed" {{ old('status', $order->status) == 'confirmed' ? 'selected' : '' }}>Đã xác nhận</option>
                            <option value="processing" {{ old('status', $order->status) == 'processing' ? 'selected' : '' }}>Đang xử lý</option>
                            <option value="shipped" {{ old('status', $order->status) == 'shipped' ? 'selected' : '' }}>Đã gửi hàng</option>
                            <option value="delivered" {{ old('status', $order->status) == 'delivered' ? 'selected' : '' }}>Đã giao hàng</option>
                            <option value="cancelled" {{ old('status', $order->status) == 'cancelled' ? 'selected' : '' }}>Đã hủy</option>
                        </select>
                        @error('status')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="payment_method" class="block text-sm font-medium text-gray-700 mb-2">Phương thức thanh toán</label>
                        <select id="payment_method" name="payment_method"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="">Chọn phương thức thanh toán</option>
                            <option value="cod" {{ old('payment_method', $order->payment_method) == 'cod' ? 'selected' : '' }}>Thanh toán khi nhận hàng (COD)</option>
                        </select>
                        @error('payment_method')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="admin_note" class="block text-sm font-medium text-gray-700 mb-2">Ghi chú admin</label>
                        <textarea id="admin_note" name="admin_note" rows="3"
                                  class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">{{ $order->admin_note }}</textarea>
                        @error('admin_note')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Customer Information -->
                <div class="space-y-4">
                    <h3 class="text-lg font-semibold text-gray-700 border-b pb-2">Thông tin khách hàng</h3>
                    
                    <div>
                        <label for="customer_name" class="block text-sm font-medium text-gray-700 mb-2">Tên khách hàng</label>
                        <input type="text" id="customer_name" name="customer_name" value="{{ old('customer_name', $order->customer_name) }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        @error('customer_name')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="customer_email" class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                        <input type="email" id="customer_email" name="customer_email" value="{{ old('customer_email', $order->customer_email) }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        @error('customer_email')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="customer_phone" class="block text-sm font-medium text-gray-700 mb-2">Số điện thoại</label>
                        <input type="text" id="customer_phone" name="customer_phone" value="{{ old('customer_phone', $order->customer_phone) }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        @error('customer_phone')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="shipping_address" class="block text-sm font-medium text-gray-700 mb-2">Địa chỉ giao hàng</label>
                        <textarea id="shipping_address" name="shipping_address" rows="3"
                                  class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('shipping_address', $order->shipping_address) }}</textarea>
                        @error('shipping_address')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Financial Information (Read-only) -->
            <div class="mt-6">
                <h3 class="text-lg font-semibold text-gray-700 border-b pb-2 mb-4">Thông tin tài chính <span class="text-sm text-gray-500 font-normal">(chỉ xem)</span></h3>
                
                <div class="bg-gray-50 p-4 rounded-lg">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Tổng tiền hàng</label>
                            <p class="text-sm text-gray-900 font-medium">{{ number_format($order->subtotal ?? 0) }} VNĐ</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Giảm giá</label>
                            <p class="text-sm text-gray-900 font-medium">{{ number_format($order->discount_amount ?? 0) }} VNĐ</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Phí vận chuyển</label>
                            <p class="text-sm text-gray-900 font-medium">{{ number_format($order->shipping_fee ?? 0) }} VNĐ</p>
                        </div>
                    </div>

                    <div class="mt-4 pt-4 border-t border-gray-200">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Tổng cộng</label>
                        <p class="text-lg text-gray-900 font-bold">{{ number_format($order->total_amount) }} VNĐ</p>
                    </div>
                </div>
                
                <!-- Hidden fields để tránh lỗi validation -->
                <input type="hidden" name="subtotal" value="{{ $order->subtotal ?? 0 }}">
                <input type="hidden" name="discount_amount" value="{{ $order->discount_amount ?? 0 }}">
                <input type="hidden" name="shipping_fee" value="{{ $order->shipping_fee ?? 0 }}">
                <input type="hidden" name="total_amount" value="{{ $order->total_amount }}">
                
                <div class="mt-3 text-sm text-gray-600">
                    <i class="fas fa-info-circle mr-1"></i>
                    Thông tin tài chính không thể chỉnh sửa trực tiếp. Để thay đổi, vui lòng liên hệ quản trị viên.
                </div>
            </div>

            <!-- Nút submit -->
            <div class="mt-8 flex justify-end space-x-4">
                <a href="{{ route('admin.orders.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-2 rounded-lg">
                    Hủy
                </a>
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg">
                    <i class="fas fa-save mr-2"></i>Cập nhật đơn hàng
                </button>
            </div>
        </form>
    </div>
</div>

<script>
// Tự động tính tổng cộng
function calculateTotal() {
    const subtotal = parseFloat(document.getElementById('subtotal').value) || 0;
    const discount = parseFloat(document.getElementById('discount_amount').value) || 0;
    const shipping = parseFloat(document.getElementById('shipping_fee').value) || 0;
    
    const total = subtotal - discount + shipping;
    document.getElementById('total_amount').value = total;
}

document.getElementById('subtotal').addEventListener('input', calculateTotal);
document.getElementById('discount_amount').addEventListener('input', calculateTotal);
document.getElementById('shipping_fee').addEventListener('input', calculateTotal);
</script>
@endsection 