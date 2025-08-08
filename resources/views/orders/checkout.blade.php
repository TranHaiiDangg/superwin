@extends('layouts.app')

@section('title', 'Thanh toán - SuperWin')

@section('content')
<div class="checkout-page py-5">
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                <div class="checkout-form">
                    <h2 class="checkout-title mb-4">Thông tin thanh toán</h2>

                    <form id="checkoutForm" method="POST" action="{{ route('orders.store') }}">
                        @csrf

                        <!-- Thông tin khách hàng -->
                        <div class="form-section mb-4">
                            <h4 class="section-title">Thông tin khách hàng</h4>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="customer_name" class="form-label">Họ và tên *</label>
                                        <input type="text" class="form-control" id="customer_name" name="customer_name"
                                               value="{{ old('customer_name', $customer->name ?? '') }}" required>
                                        @error('customer_name')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="customer_phone" class="form-label">Số điện thoại *</label>
                                        <input type="tel" class="form-control" id="customer_phone" name="customer_phone"
                                               value="{{ old('customer_phone', $customer->phone ?? '') }}" required>
                                        @error('customer_phone')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group mb-3">
                                        <label for="customer_email" class="form-label">Email *</label>
                                        <input type="email" class="form-control" id="customer_email" name="customer_email"
                                               value="{{ old('customer_email', $customer->email ?? '') }}" required>
                                        @error('customer_email')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Địa chỉ giao hàng -->
                        <div class="form-section mb-4">
                            <h4 class="section-title">Địa chỉ giao hàng</h4>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group mb-3">
                                        <label for="shipping_city" class="form-label">Tỉnh/Thành phố *</label>
                                        <select class="form-select" id="shipping_city" name="shipping_city" required>
                                            <option value="">Chọn tỉnh/thành phố</option>
                                            <option value="Hà Nội" {{ old('shipping_city') == 'Hà Nội' ? 'selected' : '' }}>Hà Nội</option>
                                            <option value="TP. Hồ Chí Minh" {{ old('shipping_city') == 'TP. Hồ Chí Minh' ? 'selected' : '' }}>TP. Hồ Chí Minh</option>
                                            <option value="Đà Nẵng" {{ old('shipping_city') == 'Đà Nẵng' ? 'selected' : '' }}>Đà Nẵng</option>
                                            <option value="Hải Phòng" {{ old('shipping_city') == 'Hải Phòng' ? 'selected' : '' }}>Hải Phòng</option>
                                            <option value="Cần Thơ" {{ old('shipping_city') == 'Cần Thơ' ? 'selected' : '' }}>Cần Thơ</option>
                                            <!-- Thêm các tỉnh/thành khác -->
                                        </select>
                                        @error('shipping_city')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group mb-3">
                                        <label for="shipping_district" class="form-label">Quận/Huyện *</label>
                                        <select class="form-select" id="shipping_district" name="shipping_district" required>
                                            <option value="">Chọn quận/huyện</option>
                                        </select>
                                        @error('shipping_district')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group mb-3">
                                        <label for="shipping_ward" class="form-label">Phường/Xã *</label>
                                        <select class="form-select" id="shipping_ward" name="shipping_ward" required>
                                            <option value="">Chọn phường/xã</option>
                                        </select>
                                        @error('shipping_ward')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group mb-3">
                                        <label for="shipping_address" class="form-label">Địa chỉ chi tiết *</label>
                                        <input type="text" class="form-control" id="shipping_address" name="shipping_address"
                                               placeholder="Số nhà, tên đường..." value="{{ old('shipping_address') }}" required>
                                        @error('shipping_address')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
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
                                        <strong>Thanh toán khi giao hàng (COD)</strong>
                                        <div class="text-muted">Thanh toán bằng tiền mặt khi nhận hàng</div>
                                    </label>
                                </div>
                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="radio" name="payment_method" id="bank_transfer" value="bank_transfer">
                                    <label class="form-check-label" for="bank_transfer">
                                        <i class="fas fa-university me-2"></i>
                                        <strong>Chuyển khoản ngân hàng</strong>
                                        <div class="text-muted">Chuyển khoản qua tài khoản ngân hàng</div>
                                    </label>
                                </div>
                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="radio" name="payment_method" id="credit_card" value="credit_card">
                                    <label class="form-check-label" for="credit_card">
                                        <i class="fas fa-credit-card me-2"></i>
                                        <strong>Thẻ tín dụng/Ghi nợ</strong>
                                        <div class="text-muted">Thanh toán online bằng thẻ</div>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <!-- Ghi chú -->
                        <div class="form-section mb-4">
                            <h4 class="section-title">Ghi chú đơn hàng</h4>
                            <div class="form-group">
                                <textarea class="form-control" id="customer_note" name="customer_note" rows="4"
                                          placeholder="Ghi chú về đơn hàng (không bắt buộc)">{{ old('customer_note') }}</textarea>
                            </div>
                        </div>

                        <div class="checkout-actions">
                            <button type="submit" class="btn btn-primary btn-lg w-100" id="submitBtn">
                                <i class="fas fa-shopping-cart me-2"></i>Đặt hàng
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Order Summary -->
            <div class="col-lg-4">
                <div class="order-summary">
                    <h4 class="summary-title">Tóm tắt đơn hàng</h4>

                    <div class="summary-items">
                        @foreach($cartData['items'] as $item)
                        <div class="summary-item">
                            <div class="item-info">
                                <img src="{{ $item['image'] }}" alt="{{ $item['name'] }}" class="item-image">
                                <div class="item-details">
                                    <h6 class="item-name">{{ $item['name'] }}</h6>
                                    <span class="item-quantity">Số lượng: {{ $item['quantity'] }}</span>
                                </div>
                            </div>
                            <div class="item-price">
                                {{ number_format($item['price'] * $item['quantity']) }}đ
                            </div>
                        </div>
                        @endforeach
                    </div>

                    <div class="summary-totals">
                        <div class="total-row">
                            <span>Tạm tính:</span>
                            <span>{{ number_format($cartData['total']) }}đ</span>
                        </div>
                        <div class="total-row">
                            <span>Phí vận chuyển:</span>
                            <span class="text-success">Miễn phí</span>
                        </div>
                        <div class="total-row total-final">
                            <span>Tổng cộng:</span>
                            <span>{{ number_format($cartData['total']) }}đ</span>
                        </div>
                    </div>

                    <div class="summary-info">
                        <div class="info-item">
                            <i class="fas fa-truck text-success"></i>
                            <span>Giao hàng trong 2-3 ngày</span>
                        </div>
                        <div class="info-item">
                            <i class="fas fa-shield-alt text-primary"></i>
                            <span>Bảo hành chính hãng</span>
                        </div>
                        <div class="info-item">
                            <i class="fas fa-undo text-info"></i>
                            <span>Đổi trả trong 30 ngày</span>
                        </div>
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
}

.checkout-title {
    color: #333;
    font-weight: 600;
}

.form-section {
    background: white;
    padding: 25px;
    border-radius: 8px;
    box-shadow: 0 1px 3px rgba(0,0,0,0.1);
}

.section-title {
    font-size: 1.1rem;
    font-weight: 600;
    color: #333;
    margin-bottom: 20px;
    padding-bottom: 10px;
    border-bottom: 2px solid #ff6b00;
}

.form-label {
    font-weight: 500;
    color: #555;
}

.form-control, .form-select {
    border: 1px solid #ddd;
    border-radius: 6px;
    padding: 12px;
    transition: border-color 0.3s;
}

.form-control:focus, .form-select:focus {
    border-color: #ff6b00;
    box-shadow: 0 0 0 2px rgba(255, 107, 0, 0.2);
}

.payment-methods .form-check {
    border: 1px solid #ddd;
    border-radius: 8px;
    padding: 15px;
    transition: all 0.3s;
}

.payment-methods .form-check:hover {
    border-color: #ff6b00;
    background: #fff8f3;
}

.payment-methods .form-check-input:checked ~ .form-check-label {
    color: #ff6b00;
}

.order-summary {
    background: white;
    padding: 25px;
    border-radius: 8px;
    box-shadow: 0 1px 3px rgba(0,0,0,0.1);
    position: sticky;
    top: 20px;
}

.summary-title {
    font-size: 1.2rem;
    font-weight: 600;
    margin-bottom: 20px;
    color: #333;
}

.summary-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 15px 0;
    border-bottom: 1px solid #eee;
}

.item-info {
    display: flex;
    align-items: center;
    flex: 1;
}

.item-image {
    width: 50px;
    height: 50px;
    object-fit: cover;
    border-radius: 6px;
    margin-right: 12px;
}

.item-name {
    font-size: 0.9rem;
    margin-bottom: 5px;
    color: #333;
}

.item-quantity {
    font-size: 0.85rem;
    color: #666;
}

.item-price {
    font-weight: 600;
    color: #ff6b00;
}

.summary-totals {
    margin-top: 20px;
    padding-top: 15px;
    border-top: 1px solid #eee;
}

.total-row {
    display: flex;
    justify-content: space-between;
    margin-bottom: 10px;
    color: #666;
}

.total-final {
    font-weight: 700;
    font-size: 1.1rem;
    color: #333;
    padding-top: 15px;
    border-top: 1px solid #eee;
    margin-top: 10px;
}

.summary-info {
    margin-top: 20px;
    padding-top: 15px;
    border-top: 1px solid #eee;
}

.info-item {
    display: flex;
    align-items: center;
    margin-bottom: 10px;
    font-size: 0.9rem;
    color: #666;
}

.info-item i {
    margin-right: 8px;
    width: 16px;
}

.checkout-actions {
    background: white;
    padding: 25px;
    border-radius: 8px;
    box-shadow: 0 1px 3px rgba(0,0,0,0.1);
}

.btn-primary {
    background: #ff6b00;
    border-color: #ff6b00;
    font-weight: 600;
    padding: 15px;
    transition: all 0.3s;
}

.btn-primary:hover {
    background: #e66000;
    border-color: #e66000;
}

.btn-primary:disabled {
    opacity: 0.7;
    cursor: not-allowed;
}

@media (max-width: 768px) {
    .form-section, .order-summary, .checkout-actions {
        margin-bottom: 20px;
    }

    .order-summary {
        position: static;
    }
}
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('checkoutForm');
    const submitBtn = document.getElementById('submitBtn');

    form.addEventListener('submit', function(e) {
        e.preventDefault();

        // Disable submit button
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Đang xử lý...';

        // Create FormData
        const formData = new FormData(form);

        fetch(form.action, {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Show success message
                showToast('Đặt hàng thành công!', 'success');

                // Redirect to success page
                setTimeout(() => {
                    window.location.href = data.redirect;
                }, 1000);
            } else {
                showToast(data.message || 'Có lỗi xảy ra', 'error');

                // Show validation errors
                if (data.errors) {
                    Object.keys(data.errors).forEach(field => {
                        const input = document.querySelector(`[name="${field}"]`);
                        if (input) {
                            const errorDiv = document.createElement('div');
                            errorDiv.className = 'text-danger';
                            errorDiv.textContent = data.errors[field][0];
                            input.parentNode.appendChild(errorDiv);
                        }
                    });
                }
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showToast('Có lỗi xảy ra khi đặt hàng', 'error');
        })
        .finally(() => {
            // Re-enable submit button
            submitBtn.disabled = false;
            submitBtn.innerHTML = '<i class="fas fa-shopping-cart me-2"></i>Đặt hàng';
        });
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
