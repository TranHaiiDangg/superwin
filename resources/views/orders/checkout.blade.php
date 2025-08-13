@extends('layouts.app')

@section('title', 'Thanh toán - SuperWin')

@section('content')
<div class="checkout-page py-4">
    <div class="container">
        <div class="row">
            <!-- Left Side - Main Content -->
            <div class="col-lg-8">
                <div class="checkout-form">
                    <form id="checkoutForm" method="POST" action="{{ route('orders.store') }}">
                        @csrf
                        <!-- Hidden input để gửi dữ liệu giỏ hàng từ localStorage -->
                        <input type="hidden" name="cart_data" id="cartDataInput">

                        <!-- Hidden inputs cho thông tin khách hàng và địa chỉ -->
                        <input type="hidden" name="customer_name" value="{{ auth('customer')->user()->name ?? 'Khách hàng' }}">
                        <input type="hidden" name="customer_phone" value="{{ auth('customer')->user()->phone ?? '0000000000' }}">
                        <input type="hidden" name="customer_email" value="{{ auth('customer')->user()->email ?? 'customer@example.com' }}">
                        <input type="hidden" name="shipping_address" value="{{ auth('customer')->user()->address ?? 'Địa chỉ mặc định' }}">
                        <input type="hidden" name="shipping_city" value="{{ auth('customer')->user()->city ?? 'TP. Hồ Chí Minh' }}">
                        <input type="hidden" name="shipping_district" value="{{ auth('customer')->user()->district ?? 'Quận 1' }}">
                        <input type="hidden" name="shipping_ward" value="{{ auth('customer')->user()->ward ?? 'Phường 1' }}">

                        <!-- Địa chỉ nhận hàng -->
                        <div class="form-section mb-4">
                            <h4 class="section-title">Địa chỉ nhận hàng</h4>
                            <div class="shipping-address-box">
                                <div class="address-content">
                                    <div class="customer-info">
                                        <strong>{{ auth('customer')->user()->name ?? 'Chưa có tên' }}</strong> -
                                        <span>{{ auth('customer')->user()->phone ?? 'Chưa có số điện thoại' }}</span>
                                    </div>
                                    <div class="address-details">
                                        {{ auth('customer')->user()->address ?? 'Chưa có địa chỉ' }},
                                        {{ auth('customer')->user()->ward ?? 'Chưa có phường/xã' }},
                                        {{ auth('customer')->user()->district ?? 'Chưa có quận/huyện' }},
                                        {{ auth('customer')->user()->city ?? 'Chưa có tỉnh/thành phố' }}
                                    </div>
                                    <div class="address-tags">
                                        <span class="tag tag-home">Nhà riêng</span>
                                        <span class="tag tag-default">Địa chỉ mặc định</span>
                                    </div>
                                </div>
                                <div class="address-actions">
                                    <a href="#" class="btn btn-link">Thay đổi</a>
                                </div>
                            </div>
                        </div>

                        <!-- Phương thức thanh toán -->
                        <div class="form-section mb-4">
                            <h4 class="section-title">Phương thức thanh toán</h4>
                            <div class="payment-methods">
                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="radio" name="payment_method" id="cod" value="cod" checked>
                                    <label class="form-check-label" for="cod">
                                        <i class="fas fa-truck me-2"></i>
                                        <strong>Thanh toán khi nhận hàng (COD)</strong>
                                        <div class="text-muted">Thanh toán bằng tiền mặt khi nhận hàng</div>
                                    </label>
                                </div>
                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="radio" name="payment_method" id="vnpay" value="vnpay">
                                    <label class="form-check-label" for="vnpay">
                                        <i class="fas fa-credit-card me-2"></i>
                                        <strong>Thanh toán trực tuyến (VNPAY)</strong>
                                        <div class="text-muted">Thanh toán online qua VNPAY</div>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <!-- Ghi chú đơn hàng -->
                        <div class="form-section mb-4">
                            <h4 class="section-title">Ghi chú đơn hàng</h4>
                            <div class="form-group">
                                <textarea class="form-control" id="customer_note" name="customer_note" rows="4"
                                          placeholder="Nhập ghi chú cho đơn hàng (không bắt buộc)">{{ old('customer_note') }}</textarea>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Right Side - Order Summary -->
            <div class="col-lg-4">
                <div class="order-summary">
                    <div class="summary-header">
                        <h4 class="summary-title">Đơn hàng của bạn</h4>
                        <a href="{{ route('cart.index') }}" class="change-link">Thay đổi</a>
                    </div>

                    <!-- Thông tin xuất hóa đơn -->
                    <div class="invoice-info mb-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <span>Thông tin xuất hóa đơn</span>
                            <a href="#" class="enter-link">Nhập</a>
                        </div>
                    </div>

                    <!-- Danh sách sản phẩm -->
                    <div class="summary-items">
                        @foreach($cartData['items'] as $item)
                        <div class="summary-item">
                            <div class="item-info">
                                <img src="{{ $item['image'] }}" alt="{{ $item['name'] }}" class="item-image">
                                <div class="item-details">
                                    <h6 class="item-name">{{ $item['name'] }}</h6>
                                    <span class="item-price">{{ number_format($item['price']) }}₫ x {{ $item['quantity'] }}</span>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>

                    <!-- Tóm tắt giá -->
                    <div class="summary-totals">
                        @php
                            $subtotal = $cartData['total'];
                            $shippingFee = 30000;
                            $discount = 50000;
                            $vat = $subtotal * 0.08;
                            $totalAmount = $subtotal + $shippingFee - $discount + $vat;
                        @endphp
                        <div class="total-row">
                            <span>Tạm tính:</span>
                            <span>{{ number_format($subtotal) }}₫</span>
                        </div>
                        <div class="total-row">
                            <span>Phí vận chuyển:</span>
                            <span>{{ number_format($shippingFee) }}₫</span>
                        </div>
                        <div class="total-row discount">
                            <span>Giảm giá:</span>
                            <span class="text-danger">-{{ number_format($discount) }}₫</span>
                        </div>
                        <div class="total-row">
                            <span>Thuế VAT (8%):</span>
                            <span>{{ number_format($vat) }}₫</span>
                        </div>
                        <div class="total-row total-final">
                            <span>Tổng cộng (Đã VAT):</span>
                            <span>{{ number_format($totalAmount) }}₫</span>
                        </div>
                    </div>

                    <!-- Nút đặt hàng -->
                    <div class="checkout-actions">
                        <button type="submit" form="checkoutForm" class="btn btn-primary btn-lg w-100" id="submitBtn">
                            <i class="fas fa-shopping-cart me-2"></i>Đặt hàng
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
.checkout-page {
    background: #f8f9fa;
    min-height: 100vh;
}

.section-title {
    font-size: 1.2rem;
    font-weight: 600;
    color: #333;
    margin-bottom: 20px;
    padding-bottom: 10px;
    border-bottom: 2px solid #007bff;
}

.form-section {
    background: white;
    padding: 25px;
    border-radius: 8px;
    box-shadow: 0 1px 3px rgba(0,0,0,0.1);
    margin-bottom: 20px;
}

/* Shipping Address Box */
.shipping-address-box {
    border: 2px solid #007bff;
    border-radius: 8px;
    padding: 20px;
    background: #f8f9ff;
    position: relative;
}

.address-content {
    margin-bottom: 15px;
}

.customer-info {
    font-size: 1.1rem;
    margin-bottom: 8px;
}

.address-details {
    color: #666;
    line-height: 1.5;
    margin-bottom: 10px;
}

.address-tags {
    display: flex;
    gap: 10px;
    flex-wrap: wrap;
}

.tag {
    padding: 4px 8px;
    border-radius: 4px;
    font-size: 0.8rem;
    font-weight: 500;
}

.tag-home {
    background: #e3f2fd;
    color: #1976d2;
}

.tag-default {
    background: #fff3cd;
    color: #856404;
}

.address-actions {
    text-align: right;
}

.btn-link {
    color: #007bff;
    text-decoration: none;
    font-weight: 500;
}

.btn-link:hover {
    text-decoration: underline;
}

/* Payment Methods */
.payment-methods .form-check {
    border: 1px solid #ddd;
    border-radius: 8px;
    padding: 15px;
    transition: all 0.3s;
    margin-bottom: 10px;
}

.payment-methods .form-check:hover {
    border-color: #007bff;
    background: #f8f9ff;
}

.payment-methods .form-check-input:checked ~ .form-check-label {
    color: #007bff;
}

.payment-methods .form-check-input:checked ~ .form-check-label strong {
    color: #007bff;
}

/* Order Summary */
.order-summary {
    background: white;
    padding: 25px;
    border-radius: 8px;
    box-shadow: 0 1px 3px rgba(0,0,0,0.1);
    position: sticky;
    top: 20px;
}

.summary-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 20px;
    padding-bottom: 15px;
    border-bottom: 1px solid #eee;
}

.summary-title {
    font-size: 1.2rem;
    font-weight: 600;
    margin: 0;
    color: #333;
}

.change-link, .enter-link {
    color: #007bff;
    text-decoration: none;
    font-size: 0.9rem;
    font-weight: 500;
}

.change-link:hover, .enter-link:hover {
    text-decoration: underline;
}

.invoice-info {
    padding: 10px 0;
    border-bottom: 1px solid #eee;
}

.summary-items {
    margin: 20px 0;
}

.summary-item {
    display: flex;
    align-items: center;
    padding: 15px 0;
    border-bottom: 1px solid #f0f0f0;
}

.item-info {
    display: flex;
    align-items: center;
    flex: 1;
}

.item-image {
    width: 60px;
    height: 60px;
    object-fit: cover;
    border-radius: 6px;
    margin-right: 15px;
}

.item-details {
    flex: 1;
}

.item-name {
    font-size: 0.95rem;
    font-weight: 500;
    margin-bottom: 5px;
    color: #333;
    line-height: 1.3;
}

.item-price {
    font-size: 0.9rem;
    color: #666;
}

.summary-totals {
    margin-top: 20px;
    padding-top: 15px;
    border-top: 1px solid #eee;
}

.total-row {
    display: flex;
    justify-content: space-between;
    margin-bottom: 12px;
    color: #666;
    font-size: 0.95rem;
}

.total-row.discount {
    color: #dc3545;
}

.total-final {
    font-weight: 700;
    font-size: 1.1rem;
    color: #333;
    padding-top: 15px;
    border-top: 1px solid #eee;
    margin-top: 10px;
}

.checkout-actions {
    margin-top: 25px;
}

.btn-primary {
    background: #007bff;
    border-color: #007bff;
    font-weight: 600;
    padding: 15px;
    font-size: 1.1rem;
    transition: all 0.3s;
}

.btn-primary:hover {
    background: #0056b3;
    border-color: #0056b3;
}

.btn-primary:disabled {
    opacity: 0.7;
    cursor: not-allowed;
}

/* Form Controls */
.form-control {
    border: 1px solid #ddd;
    border-radius: 6px;
    padding: 12px;
    transition: border-color 0.3s;
}

.form-control:focus {
    border-color: #007bff;
    box-shadow: 0 0 0 2px rgba(0, 123, 255, 0.2);
}

/* Responsive */
@media (max-width: 768px) {
    .form-section, .order-summary {
        margin-bottom: 15px;
    }

    .order-summary {
        position: static;
    }

    .summary-header {
        flex-direction: column;
        align-items: flex-start;
        gap: 10px;
    }

    .address-tags {
        flex-direction: column;
        gap: 5px;
    }
}
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('checkoutForm');
    const submitBtn = document.getElementById('submitBtn');
    const cartDataInput = document.getElementById('cartDataInput');

    // Lấy dữ liệu giỏ hàng từ localStorage
    function loadCartData() {
        const cartData = localStorage.getItem('superwin_cart');
        if (cartData) {
            cartDataInput.value = cartData;
        } else {
            // Nếu không có dữ liệu giỏ hàng, redirect về trang giỏ hàng
            window.location.href = '{{ route("cart.index") }}';
        }
    }

    // Load dữ liệu giỏ hàng khi trang load
    loadCartData();

    // Form submit handler
    form.addEventListener('submit', function(e) {
        console.log('Form submit event triggered');
        console.log('Cart data:', cartDataInput.value);

        // Kiểm tra dữ liệu giỏ hàng
        if (!cartDataInput.value) {
            e.preventDefault();
            alert('Giỏ hàng trống! Vui lòng thêm sản phẩm trước khi đặt hàng.');
            submitBtn.disabled = false;
            submitBtn.innerHTML = '<i class="fas fa-shopping-cart me-2"></i>Đặt hàng';
            return;
        }

        // Disable submit button to prevent double submission
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Đang xử lý...';

        console.log('Form will be submitted to:', form.action);
        // Let the form submit naturally - no preventDefault()
        // The form will handle the submission and redirect automatically
    });

    // Clear previous error messages on input
    form.addEventListener('input', function(e) {
        const errorDiv = e.target.parentNode.querySelector('.text-danger');
        if (errorDiv) {
            errorDiv.remove();
        }
    });
});

function showToast(message, type = 'info') {
    const toast = document.createElement('div');
    toast.className = `toast-notification toast-${type}`;
    toast.textContent = message;

    document.body.appendChild(toast);

    setTimeout(() => toast.classList.add('show'), 100);

    setTimeout(() => {
        toast.classList.remove('show');
        setTimeout(() => toast.remove(), 300);
    }, 3000);
}
</script>

<style>
.toast-notification {
    position: fixed;
    top: 20px;
    right: 20px;
    padding: 12px 20px;
    border-radius: 6px;
    color: white;
    font-weight: 500;
    z-index: 9999;
    transform: translateX(100%);
    transition: transform 0.3s ease;
}

.toast-notification.show {
    transform: translateX(0);
}

.toast-success {
    background: #28a745;
}

.toast-error {
    background: #dc3545;
}

.toast-info {
    background: #17a2b8;
}
</style>
@endpush
@endsection
