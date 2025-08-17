@extends('layouts.app')

@section('title', 'Thanh toán - SuperWin')

@section('content')
<div class="checkout-page py-4">
    <div class="container">
        @if(isset($isBuyNow) && $isBuyNow)
            <div class="alert alert-info mb-4" role="alert">
                <i class="fas fa-bolt me-2"></i>
                <strong>Chế độ Mua ngay:</strong> Bạn đang thực hiện mua nhanh sản phẩm này. Sản phẩm sẽ được giao ngay sau khi đặt hàng thành công.
            </div>
        @endif

        <div class="row">
            <!-- Left Side - Main Content -->
            <div class="col-lg-8 col-md-12">
                <div class="checkout-form">
                    <form id="checkoutForm" method="POST" action="{{ route('orders.store') }}">
                        @csrf
                        <!-- Hidden input để gửi dữ liệu giỏ hàng từ localStorage -->
                        <input type="hidden" name="cart_data" id="cartDataInput">

                        @if(isset($isBuyNow) && $isBuyNow)
                            <input type="hidden" name="buy_now" value="1">
                            <input type="hidden" name="product_id" value="{{ request()->get('product_id') }}">
                            <input type="hidden" name="quantity" value="{{ request()->get('quantity', 1) }}">
                            <input type="hidden" name="variant_id" value="{{ request()->get('variant_id') }}">
                        @endif

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
                            <h4 class="section-title">
                                <i class="fas fa-map-marker-alt me-2"></i>Địa chỉ nhận hàng
                            </h4>
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
                                    <button type="button" class="btn btn-link" data-bs-toggle="modal" data-bs-target="#updateAddressModal">
                                        <i class="fas fa-edit me-1"></i>Thay đổi
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Phương thức thanh toán -->
                        <div class="form-section mb-4">
                            <h4 class="section-title">
                                <i class="fas fa-credit-card me-2"></i>Phương thức thanh toán
                            </h4>
                            <div class="payment-methods">
                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="radio" name="payment_method" id="cod" value="cod" checked>
                                    <label class="form-check-label" for="cod">
                                        <i class="fas fa-truck me-2"></i>
                                        <strong>Thanh toán khi nhận hàng (COD)</strong>
                                        <div class="text-muted">Thanh toán bằng tiền mặt khi nhận hàng</div>
                                    </label>
                                </div>
                                <!-- <div class="form-check mb-3">
                                    <input class="form-check-input" type="radio" name="payment_method" id="vnpay" value="vnpay">
                                    <label class="form-check-label" for="vnpay">
                                        <i class="fas fa-credit-card me-2"></i>
                                        <strong>Thanh toán trực tuyến (VNPAY)</strong>
                                        <div class="text-muted">Thanh toán online qua VNPAY</div>
                                    </label>
                                </div> -->
                            </div>
                        </div>

                        <!-- Ghi chú đơn hàng -->
                        <div class="form-section mb-4">
                            <h4 class="section-title">
                                <i class="fas fa-sticky-note me-2"></i>Ghi chú đơn hàng
                            </h4>
                            <div class="form-group">
                                <textarea class="form-control" id="customer_note" name="customer_note" rows="4"
                                          placeholder="Nhập ghi chú cho đơn hàng (không bắt buộc)">{{ old('customer_note') }}</textarea>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Right Side - Order Summary -->
            <div class="col-lg-4 col-md-12">
                <div class="order-summary">
                    <div class="summary-header">
                        <h4 class="summary-title">
                            <i class="fas fa-shopping-bag me-2"></i>
                            @if(isset($isBuyNow) && $isBuyNow)
                                Mua ngay
                            @else
                                Đơn hàng của bạn
                            @endif
                        </h4>
                        @if(!isset($isBuyNow) || !$isBuyNow)
                            <a href="{{ route('cart.index') }}" class="change-link">
                                <i class="fas fa-edit me-1"></i>Thay đổi
                            </a>
                        @endif
                    </div>

                    <!-- Thông tin xuất hóa đơn -->
                    <!-- <div class="invoice-info mb-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <span>Thông tin xuất hóa đơn</span>
                            <a href="#" class="enter-link">Nhập</a>
                        </div>
                    </div> -->

                    <!-- Danh sách sản phẩm -->
                    <div class="summary-items">
                        @foreach($cartData['items'] as $item)
                        <div class="summary-item">
                            <div class="item-info">
                                <img src="{{ $item['image'] }}" alt="{{ $item['name'] }}" class="item-image">
                                <div class="item-details">
                                    <h6 class="item-name">
                                        {{ $item['name'] }}
                                        @if(isset($item['variant_name']) && $item['variant_name'])
                                            <br><small class="text-muted">{{ $item['variant_name'] }}</small>
                                        @endif
                                    </h6>
                                    <span class="item-price">{{ number_format($item['price']) }}₫ x {{ $item['quantity'] }}</span>
                                    @if(isset($item['variant_code']) && $item['variant_code'])
                                        <br><small class="text-muted">Mã: {{ $item['variant_code'] }}</small>
                                    @endif
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

<!-- Update Address Modal -->
<div class="modal fade" id="updateAddressModal" tabindex="-1" aria-labelledby="updateAddressModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="updateAddressModalLabel">
                    <i class="fas fa-map-marker-alt me-2"></i>Cập nhật địa chỉ giao hàng
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="updateAddressForm">
                    <div class="row">
                        <div class="col-md-6 col-12">
                            <div class="mb-3">
                                <label for="modal_name" class="form-label">Họ và tên *</label>
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="fas fa-user"></i>
                                    </span>
                                    <input type="text" class="form-control" id="modal_name"
                                           value="{{ auth('customer')->user()->name ?? '' }}" required>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="modal_phone" class="form-label">Số điện thoại *</label>
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="fas fa-phone"></i>
                                    </span>
                                    <input type="tel" class="form-control" id="modal_phone"
                                           value="{{ auth('customer')->user()->phone ?? '' }}" required>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="modal_address" class="form-label">Địa chỉ *</label>
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="fas fa-map-marker-alt"></i>
                                    </span>
                                    <input type="text" class="form-control" id="modal_address"
                                           value="{{ auth('customer')->user()->address ?? '' }}"
                                           placeholder="Số nhà, tên đường" required>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6 col-12">
                            <div class="mb-3">
                                <label for="modal_city" class="form-label">Tỉnh/Thành phố *</label>
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="fas fa-city"></i>
                                    </span>
                                    <select class="form-select" id="modal_city" required>
                                        <option value="">-- Chọn Tỉnh/Thành phố --</option>
                                    </select>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="modal_district" class="form-label">Quận/Huyện *</label>
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="fas fa-map"></i>
                                    </span>
                                    <select class="form-select" id="modal_district" required disabled>
                                        <option value="">-- Chọn Quận/Huyện --</option>
                                    </select>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="modal_ward" class="form-label">Phường/Xã *</label>
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="fas fa-home"></i>
                                    </span>
                                    <select class="form-select" id="modal_ward" required disabled>
                                        <option value="">-- Chọn Phường/Xã --</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                    <i class="fas fa-times me-1"></i>Hủy
                </button>
                <button type="button" class="btn btn-primary" id="saveAddressBtn">
                    <i class="fas fa-save me-1"></i>Cập nhật địa chỉ
                </button>
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

/* Mobile-first improvements */
@media (max-width: 768px) {
    .checkout-page {
        background: white;
    }

    .form-section, .order-summary {
        box-shadow: none;
        border: 1px solid #e9ecef;
    }
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

/* Modal Styles */
.modal-header {
    background: linear-gradient(135deg, #007bff 0%, #0056b3 100%);
    color: white;
    border-bottom: none;
}

.modal-header .btn-close {
    filter: invert(1) grayscale(100%) brightness(200%);
}

.modal-body {
    padding: 2rem;
}

.modal .form-select:disabled {
    background-color: #f8f9fa;
    opacity: 0.65;
}

.modal .input-group .form-select {
    border-left: 0;
}

.modal .input-group .input-group-text {
    background-color: #e9ecef;
    border-right: 0;
}

.address-loading {
    position: relative;
}

.address-loading::after {
    content: '';
    position: absolute;
    right: 30px;
    top: 50%;
    transform: translateY(-50%);
    width: 16px;
    height: 16px;
    border: 2px solid #f3f3f3;
    border-top: 2px solid #007bff;
    border-radius: 50%;
    animation: spin 1s linear infinite;
}

@keyframes spin {
    0% { transform: translateY(-50%) rotate(0deg); }
    100% { transform: translateY(-50%) rotate(360deg); }
}

/* Responsive */
@media (max-width: 768px) {
    .checkout-page {
        padding: 10px 0;
    }

    .container {
        padding: 0 15px;
    }

    .form-section, .order-summary {
        margin-bottom: 15px;
        padding: 20px 15px;
    }

    .order-summary {
        position: static;
        margin-top: 20px;
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

    .shipping-address-box {
        padding: 15px;
    }

    .customer-info {
        font-size: 1rem;
    }

    .address-details {
        font-size: 0.9rem;
    }

    .summary-item {
        padding: 12px 0;
    }

    .item-image {
        width: 50px;
        height: 50px;
        margin-right: 12px;
    }

    .item-name {
        font-size: 0.9rem;
    }

    .item-price {
        font-size: 0.85rem;
    }

    .total-row {
        font-size: 0.9rem;
        margin-bottom: 10px;
    }

    .total-final {
        font-size: 1rem;
    }

    .btn-primary {
        padding: 12px;
        font-size: 1rem;
    }

    .modal-body {
        padding: 1rem;
    }

    .modal-dialog {
        margin: 10px;
    }

    .section-title {
        font-size: 1.1rem;
        margin-bottom: 15px;
    }

    .payment-methods .form-check {
        padding: 12px;
    }

    .form-control {
        padding: 10px;
    }
}

@media (max-width: 576px) {
    .checkout-page {
        padding: 5px 0;
    }

    .form-section, .order-summary {
        padding: 15px 10px;
        border-radius: 6px;
    }

    .shipping-address-box {
        padding: 12px;
    }

    .address-actions {
        text-align: center;
        margin-top: 10px;
    }

    .btn-link {
        display: inline-block;
        padding: 8px 16px;
        background: #007bff;
        color: white;
        border-radius: 4px;
        text-decoration: none;
    }

    .btn-link:hover {
        background: #0056b3;
        color: white;
        text-decoration: none;
    }

    .summary-items {
        margin: 15px 0;
    }

    .summary-item {
        padding: 10px 0;
    }

    .item-image {
        width: 45px;
        height: 45px;
        margin-right: 10px;
    }

    .item-details {
        min-width: 0;
    }

    .item-name {
        font-size: 0.85rem;
        line-height: 1.2;
    }

    .item-price {
        font-size: 0.8rem;
    }

    .total-row {
        font-size: 0.85rem;
        margin-bottom: 8px;
    }

    .total-final {
        font-size: 0.95rem;
        padding-top: 12px;
    }

    .btn-primary {
        padding: 10px;
        font-size: 0.95rem;
    }

    .modal-dialog {
        margin: 5px;
    }

    .modal-body {
        padding: 15px 10px;
    }

    .section-title {
        font-size: 1rem;
        margin-bottom: 12px;
    }

    .payment-methods .form-check {
        padding: 10px;
        margin-bottom: 8px;
    }

    .form-control {
        padding: 8px;
        font-size: 0.9rem;
    }

    .form-label {
        font-size: 0.9rem;
    }

    .alert {
        padding: 12px;
        font-size: 0.9rem;
    }
}

@media (max-width: 480px) {
    .checkout-page {
        padding: 0;
    }

    .container {
        padding: 0 10px;
    }

    .form-section, .order-summary {
        padding: 12px 8px;
        margin-bottom: 10px;
    }

    .shipping-address-box {
        padding: 10px;
    }

    .customer-info {
        font-size: 0.95rem;
    }

    .address-details {
        font-size: 0.85rem;
    }

    .summary-item {
        padding: 8px 0;
    }

    .item-image {
        width: 40px;
        height: 40px;
        margin-right: 8px;
    }

    .item-name {
        font-size: 0.8rem;
    }

    .item-price {
        font-size: 0.75rem;
    }

    .total-row {
        font-size: 0.8rem;
        margin-bottom: 6px;
    }

    .total-final {
        font-size: 0.9rem;
    }

    .btn-primary {
        padding: 8px;
        font-size: 0.9rem;
    }

    .section-title {
        font-size: 0.95rem;
        margin-bottom: 10px;
    }

    .payment-methods .form-check {
        padding: 8px;
    }

    .form-control {
        padding: 6px;
        font-size: 0.85rem;
    }

    .form-label {
        font-size: 0.85rem;
    }

    .alert {
        padding: 10px;
        font-size: 0.85rem;
    }

    .modal-dialog {
        margin: 2px;
    }

    .modal-body {
        padding: 12px 8px;
    }
}
</style>
@endpush

@push('scripts')
<script>
// Address Manager for Checkout Modal
class CheckoutAddressManager {
    constructor() {
        this.citySelect = document.getElementById('modal_city');
        this.districtSelect = document.getElementById('modal_district');
        this.wardSelect = document.getElementById('modal_ward');

        // Store current values for pre-selection
        this.currentCity = '{{ auth("customer")->user()->city ?? "" }}';
        this.currentDistrict = '{{ auth("customer")->user()->district ?? "" }}';
        this.currentWard = '{{ auth("customer")->user()->ward ?? "" }}';

        this.init();
    }

    async init() {
        await this.loadProvinces();
        this.bindEvents();
    }

    async loadProvinces() {
        try {
            this.showLoading(this.citySelect, 'Đang tải tỉnh/thành phố...');

            const response = await fetch('/api/provinces');
            const data = await response.json();

            if (data.success && data.data) {
                this.populateSelect(this.citySelect, data.data, 'name', 'name', '-- Chọn Tỉnh/Thành phố --');
                this.citySelect.parentElement.classList.remove('address-loading');

                // Pre-select current city if exists
                if (this.currentCity) {
                    this.selectOptionByText(this.citySelect, this.currentCity);
                    const selectedOption = this.citySelect.options[this.citySelect.selectedIndex];
                    if (selectedOption.dataset.code) {
                        await this.loadDistricts(selectedOption.dataset.code);
                    }
                }
            } else {
                this.showError(this.citySelect, 'Không thể tải danh sách tỉnh/thành phố');
            }
        } catch (error) {
            console.error('Error loading provinces:', error);
            this.showError(this.citySelect, 'Lỗi kết nối. Vui lòng thử lại');
        }
    }

    async loadDistricts(provinceCode) {
        try {
            this.showLoading(this.districtSelect, 'Đang tải quận/huyện...');
            this.resetSelect(this.wardSelect, '-- Chọn Phường/Xã --');
            this.wardSelect.disabled = true;

            const response = await fetch(`/api/districts/${provinceCode}`);
            const data = await response.json();

            if (data.success && data.data) {
                this.populateSelect(this.districtSelect, data.data, 'name', 'name', '-- Chọn Quận/Huyện --');
                this.districtSelect.parentElement.classList.remove('address-loading');

                if (this.currentDistrict) {
                    this.selectOptionByText(this.districtSelect, this.currentDistrict);
                    const selectedOption = this.districtSelect.options[this.districtSelect.selectedIndex];
                    if (selectedOption.dataset.code) {
                        await this.loadWards(selectedOption.dataset.code);
                    }
                }
            } else {
                this.showError(this.districtSelect, 'Không thể tải danh sách quận/huyện');
            }
        } catch (error) {
            console.error('Error loading districts:', error);
            this.showError(this.districtSelect, 'Lỗi kết nối. Vui lòng thử lại');
        }
    }

    async loadWards(districtCode) {
        try {
            this.showLoading(this.wardSelect, 'Đang tải phường/xã...');

            const response = await fetch(`/api/wards/${districtCode}`);
            const data = await response.json();

            if (data.success && data.data) {
                this.populateSelect(this.wardSelect, data.data, 'name', 'name', '-- Chọn Phường/Xã --');
                this.wardSelect.parentElement.classList.remove('address-loading');

                if (this.currentWard) {
                    this.selectOptionByText(this.wardSelect, this.currentWard);
                }
            } else {
                this.showError(this.wardSelect, 'Không thể tải danh sách phường/xã');
            }
        } catch (error) {
            console.error('Error loading wards:', error);
            this.showError(this.wardSelect, 'Lỗi kết nối. Vui lòng thử lại');
        }
    }

    populateSelect(select, items, valueField, textField, placeholder) {
        select.innerHTML = `<option value="">${placeholder}</option>`;

        items.forEach(item => {
            const option = document.createElement('option');
            option.value = item[valueField];
            option.textContent = item[textField];
            option.dataset.code = item.code || '';
            select.appendChild(option);
        });

        select.disabled = false;
    }

    resetSelect(select, placeholder) {
        select.innerHTML = `<option value="">${placeholder}</option>`;
        select.disabled = true;
    }

    showLoading(select, message) {
        select.innerHTML = `<option value="" class="loading-option">${message}</option>`;
        select.disabled = true;
        select.parentElement.classList.add('address-loading');
    }

    showError(select, message) {
        select.innerHTML = `<option value="" class="error-option">${message}</option>`;
        select.disabled = true;
        select.parentElement.classList.remove('address-loading');
    }

    selectOptionByText(select, text) {
        for (let i = 0; i < select.options.length; i++) {
            if (select.options[i].textContent.trim() === text.trim()) {
                select.selectedIndex = i;
                break;
            }
        }
    }

    bindEvents() {
        this.citySelect.addEventListener('change', async (e) => {
            const selectedOption = e.target.options[e.target.selectedIndex];
            const provinceCode = selectedOption.dataset.code;

            this.currentDistrict = '';
            this.currentWard = '';

            if (provinceCode) {
                await this.loadDistricts(provinceCode);
            } else {
                this.resetSelect(this.districtSelect, '-- Chọn Quận/Huyện --');
                this.resetSelect(this.wardSelect, '-- Chọn Phường/Xã --');
                this.districtSelect.disabled = true;
                this.wardSelect.disabled = true;
            }
        });

        this.districtSelect.addEventListener('change', async (e) => {
            const selectedOption = e.target.options[e.target.selectedIndex];
            const districtCode = selectedOption.dataset.code;

            this.currentWard = '';

            if (districtCode) {
                await this.loadWards(districtCode);
            } else {
                this.resetSelect(this.wardSelect, '-- Chọn Phường/Xã --');
                this.wardSelect.disabled = true;
            }
        });
    }
}

document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('checkoutForm');
    const submitBtn = document.getElementById('submitBtn');
    const cartDataInput = document.getElementById('cartDataInput');

    // Initialize Address Manager
    let addressManager;

    // Initialize address manager when modal is opened
    document.getElementById('updateAddressModal').addEventListener('shown.bs.modal', function () {
        if (!addressManager) {
            addressManager = new CheckoutAddressManager();
        }
    });

    // Save address button handler
    document.getElementById('saveAddressBtn').addEventListener('click', function() {
        const name = document.getElementById('modal_name').value;
        const phone = document.getElementById('modal_phone').value;
        const address = document.getElementById('modal_address').value;
        const city = document.getElementById('modal_city').value;
        const district = document.getElementById('modal_district').value;
        const ward = document.getElementById('modal_ward').value;

        // Validate required fields
        if (!name || !phone || !address || !city || !district || !ward) {
            showToast('Vui lòng điền đầy đủ thông tin địa chỉ', 'error');
            return;
        }

        // Update the address display on checkout page
        updateAddressDisplay(name, phone, address, city, district, ward);

        // Update hidden form inputs
        updateFormInputs(name, phone, address, city, district, ward);

        // Close modal
        const modal = bootstrap.Modal.getInstance(document.getElementById('updateAddressModal'));
        modal.hide();

        showToast('Cập nhật địa chỉ thành công!', 'success');
    });

    // Lấy dữ liệu giỏ hàng từ localStorage hoặc sessionStorage (cho mua ngay)
    function loadCartData() {
        // Kiểm tra nếu là mua ngay
        const urlParams = new URLSearchParams(window.location.search);
        const isBuyNow = urlParams.get('buy_now');

        if (isBuyNow === '1') {
            // Lấy dữ liệu từ sessionStorage cho mua ngay
            const buyNowData = sessionStorage.getItem('buyNowData');
            if (buyNowData) {
                try {
                    const buyNowInfo = JSON.parse(buyNowData);

                    // Tạo cart item với thông tin biến thể
                    const cartItem = {
                        id: buyNowInfo.productId,
                        name: buyNowInfo.productName,
                        model: buyNowInfo.productModel,
                        price: buyNowInfo.variant_price || buyNowInfo.price || 0,
                        quantity: buyNowInfo.quantity,
                        image: buyNowInfo.productImage,
                        variant_id: buyNowInfo.variant_id,
                        variant_name: buyNowInfo.variant_name,
                        variant_code: buyNowInfo.variant_code
                    };

                    // Tạo cart array với item này
                    const cartArray = [cartItem];
                    cartDataInput.value = JSON.stringify(cartArray);

                    console.log('Buy now cart data created:', cartArray);

                    // Xóa dữ liệu mua ngay sau khi load
                    sessionStorage.removeItem('buyNowData');
                } catch (error) {
                    console.error('Error parsing buy now data:', error);
                    window.history.back();
                }
            } else {
                // Nếu không có dữ liệu mua ngay, redirect về trang trước
                window.history.back();
            }
        } else {
            // Lấy dữ liệu giỏ hàng từ localStorage
            const cartData = localStorage.getItem('superwin_cart');
            if (cartData) {
                cartDataInput.value = cartData;
            } else {
                // Nếu không có dữ liệu giỏ hàng, redirect về trang giỏ hàng
                window.location.href = '{{ route("cart.index") }}';
            }
        }
    }

    // Load dữ liệu giỏ hàng khi trang load
    loadCartData();

    // Function to update address display
    function updateAddressDisplay(name, phone, address, city, district, ward) {
        const customerInfo = document.querySelector('.customer-info');
        const addressDetails = document.querySelector('.address-details');

        if (customerInfo) {
            customerInfo.innerHTML = `<strong>${name}</strong> - <span>${phone}</span>`;
        }

        if (addressDetails) {
            addressDetails.textContent = `${address}, ${ward}, ${district}, ${city}`;
        }
    }

    // Function to update hidden form inputs
    function updateFormInputs(name, phone, address, city, district, ward) {
        const inputs = {
            'customer_name': name,
            'customer_phone': phone,
            'shipping_address': address,
            'shipping_city': city,
            'shipping_district': district,
            'shipping_ward': ward
        };

        Object.keys(inputs).forEach(name => {
            const input = document.querySelector(`input[name="${name}"]`);
            if (input) {
                input.value = inputs[name];
            }
        });
    }

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
    max-width: 300px;
    word-wrap: break-word;
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

/* Mobile toast improvements */
@media (max-width: 768px) {
    .toast-notification {
        top: 10px;
        right: 10px;
        left: 10px;
        max-width: none;
        transform: translateY(-100%);
    }

    .toast-notification.show {
        transform: translateY(0);
    }
}

@media (max-width: 480px) {
    .toast-notification {
        top: 5px;
        right: 5px;
        left: 5px;
        padding: 10px 15px;
        font-size: 0.9rem;
    }
}
</style>
@endpush
@endsection
