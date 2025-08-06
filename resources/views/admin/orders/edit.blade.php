@extends('admin.layouts.app')

@section('title', 'Chỉnh sửa đơn hàng')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-900">Chỉnh sửa đơn hàng #{{ $order->order_number }}</h1>
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
                        <label for="order_number" class="block text-sm font-medium text-gray-700 mb-2">Mã đơn hàng</label>
                        <input type="text" id="order_number" name="order_number" value="{{ old('order_number', $order->order_number) }}" required
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        @error('order_number')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="status" class="block text-sm font-medium text-gray-700 mb-2">Trạng thái</label>
                        <select id="status" name="status" required
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="pending" {{ old('status', $order->status) == 'pending' ? 'selected' : '' }}>Chờ xử lý</option>
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
                            <option value="cod" {{ old('payment_method', $order->payment_method) == 'cod' ? 'selected' : '' }}>Thanh toán khi nhận hàng</option>
                            <option value="bank_transfer" {{ old('payment_method', $order->payment_method) == 'bank_transfer' ? 'selected' : '' }}>Chuyển khoản ngân hàng</option>
                            <option value="credit_card" {{ old('payment_method', $order->payment_method) == 'credit_card' ? 'selected' : '' }}>Thẻ tín dụng</option>
                            <option value="momo" {{ old('payment_method', $order->payment_method) == 'momo' ? 'selected' : '' }}>Ví MoMo</option>
                            <option value="vnpay" {{ old('payment_method', $order->payment_method) == 'vnpay' ? 'selected' : '' }}>VNPay</option>
                        </select>
                        @error('payment_method')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="admin_note" class="block text-sm font-medium text-gray-700 mb-2">Ghi chú admin</label>
                        <textarea id="admin_note" name="admin_note" rows="3"
                                  class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('admin_note', $order->admin_note) }}</textarea>
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
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                        <input type="email" id="email" name="email" value="{{ old('email', $order->email) }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        @error('email')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">Số điện thoại</label>
                        <input type="text" id="phone" name="phone" value="{{ old('phone', $order->phone) }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        @error('phone')
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

            <!-- Financial Information -->
            <div class="mt-6">
                <h3 class="text-lg font-semibold text-gray-700 border-b pb-2 mb-4">Thông tin tài chính</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label for="subtotal" class="block text-sm font-medium text-gray-700 mb-2">Tổng tiền hàng</label>
                        <input type="number" id="subtotal" name="subtotal" value="{{ old('subtotal', $order->subtotal) }}" min="0" step="1000"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        @error('subtotal')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="discount_amount" class="block text-sm font-medium text-gray-700 mb-2">Giảm giá</label>
                        <input type="number" id="discount_amount" name="discount_amount" value="{{ old('discount_amount', $order->discount_amount) }}" min="0" step="1000"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        @error('discount_amount')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="shipping_fee" class="block text-sm font-medium text-gray-700 mb-2">Phí vận chuyển</label>
                        <input type="number" id="shipping_fee" name="shipping_fee" value="{{ old('shipping_fee', $order->shipping_fee) }}" min="0" step="1000"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        @error('shipping_fee')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="mt-4">
                    <label for="total_amount" class="block text-sm font-medium text-gray-700 mb-2">Tổng cộng</label>
                    <input type="number" id="total_amount" name="total_amount" value="{{ old('total_amount', $order->total_amount) }}" min="0" step="1000" required
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 bg-gray-50">
                    @error('total_amount')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
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