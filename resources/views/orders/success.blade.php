@extends('layouts.app')

@section('title', 'Đặt hàng thành công - SuperWin')

@section('content')
<div class="success-page py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="success-card text-center">
                    <div class="success-icon mb-4">
                        <i class="fas fa-check-circle"></i>
                    </div>

                    <h1 class="success-title">Đặt hàng thành công!</h1>
                    <p class="success-message">
                        Cảm ơn bạn đã đặt hàng tại SuperWin. Chúng tôi đã nhận được đơn hàng và sẽ xử lý trong thời gian sớm nhất.
                    </p>

                    <div class="order-info">
                        <div class="info-item">
                            <strong>Mã đơn hàng:</strong>
                            <span class="order-code">{{ $order->order_code }}</span>
                        </div>
                        <div class="info-item">
                            <strong>Tổng tiền:</strong>
                            <span class="order-total">{{ number_format($order->total_amount) }}đ</span>
                        </div>
                        <div class="info-item">
                            <strong>Phương thức thanh toán:</strong>
                            <span class="payment-method">
                                @switch($order->payment_method)
                                    @case('cod')
                                        Thanh toán khi giao hàng (COD)
                                        @break
                                    @case('bank_transfer')
                                        Chuyển khoản ngân hàng
                                        @break
                                    @case('credit_card')
                                        Thẻ tín dụng/Ghi nợ
                                        @break
                                    @default
                                        {{ $order->payment_method }}
                                @endswitch
                            </span>
                        </div>
                        <div class="info-item">
                            <strong>Dự kiến giao hàng:</strong>
                            <span class="delivery-date">{{ $order->estimated_delivery_date->format('d/m/Y') }}</span>
                        </div>
                    </div>

                    @if($order->payment_method == 'bank_transfer')
                    <div class="bank-info mt-4">
                        <div class="alert alert-info">
                            <h5><i class="fas fa-info-circle me-2"></i>Thông tin chuyển khoản</h5>
                            <p><strong>Ngân hàng:</strong> Vietcombank</p>
                            <p><strong>Số tài khoản:</strong> 1234567890</p>
                            <p><strong>Chủ tài khoản:</strong> CÔNG TY SUPERWIN</p>
                            <p><strong>Nội dung:</strong> {{ $order->order_code }} - {{ $order->customer_name }}</p>
                            <p><strong>Số tiền:</strong> {{ number_format($order->total_amount) }}đ</p>
                        </div>
                    </div>
                    @endif

                    <div class="action-buttons">
                        <a href="{{ route('orders.show', $order->id) }}" class="btn btn-primary">
                            <i class="fas fa-eye me-2"></i>Xem chi tiết đơn hàng
                        </a>
                        <a href="{{ route('home') }}" class="btn btn-outline-primary">
                            <i class="fas fa-home me-2"></i>Về trang chủ
                        </a>
                    </div>
                </div>

                <!-- Order Details -->
                <div class="order-details mt-5">
                    <h3 class="details-title">Chi tiết đơn hàng</h3>

                    <div class="details-card">
                        @foreach($order->orderDetails as $detail)
                        <div class="detail-item">
                            <div class="item-info">
                                @if($detail->product && $detail->product->baseImage)
                                    <img src="{{ $detail->product->baseImage->url }}" alt="{{ $detail->product_name }}" class="item-image">
                                @else
                                    <img src="/images/default.png" alt="{{ $detail->product_name }}" class="item-image">
                                @endif
                                <div class="item-details">
                                    <h6 class="item-name">{{ $detail->product_name }}</h6>
                                    @if($detail->product_sku)
                                        <span class="item-sku">SKU: {{ $detail->product_sku }}</span>
                                    @endif
                                    <span class="item-quantity">Số lượng: {{ $detail->quantity }}</span>
                                </div>
                            </div>
                            <div class="item-pricing">
                                <div class="unit-price">{{ number_format($detail->unit_price) }}đ</div>
                                <div class="total-price">{{ number_format($detail->total_price) }}đ</div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

                <!-- Delivery Information -->
                <div class="delivery-info mt-4">
                    <h3 class="details-title">Thông tin giao hàng</h3>

                    <div class="details-card">
                        <div class="row">
                            <div class="col-md-6">
                                <h6>Người nhận:</h6>
                                <p>{{ $order->customer_name }}</p>

                                <h6>Số điện thoại:</h6>
                                <p>{{ $order->customer_phone }}</p>

                                <h6>Email:</h6>
                                <p>{{ $order->customer_email }}</p>
                            </div>
                            <div class="col-md-6">
                                <h6>Địa chỉ giao hàng:</h6>
                                <p>
                                    {{ $order->shipping_address }}<br>
                                    {{ $order->shipping_ward }}, {{ $order->shipping_district }}<br>
                                    {{ $order->shipping_city }}
                                </p>

                                @if($order->customer_note)
                                <h6>Ghi chú:</h6>
                                <p>{{ $order->customer_note }}</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
.success-page {
    background: #f8f9fa;
    min-height: 100vh;
}

.success-card {
    background: white;
    padding: 50px 30px;
    border-radius: 12px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.1);
}

.success-icon {
    font-size: 4rem;
    color: #28a745;
}

.success-title {
    font-size: 2.5rem;
    font-weight: 700;
    color: #333;
    margin-bottom: 20px;
}

.success-message {
    font-size: 1.1rem;
    color: #666;
    margin-bottom: 30px;
    line-height: 1.6;
}

.order-info {
    background: #f8f9fa;
    padding: 25px;
    border-radius: 8px;
    margin: 30px 0;
    text-align: left;
}

.info-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 8px 0;
    border-bottom: 1px solid #eee;
}

.info-item:last-child {
    border-bottom: none;
}

.order-code {
    font-family: monospace;
    font-weight: bold;
    color: #ff6b00;
    font-size: 1.1rem;
}

.order-total {
    font-weight: bold;
    color: #28a745;
    font-size: 1.2rem;
}

.bank-info {
    text-align: left;
}

.bank-info .alert {
    border-left: 4px solid #17a2b8;
}

.action-buttons {
    margin-top: 30px;
}

.action-buttons .btn {
    margin: 5px;
    padding: 12px 25px;
    font-weight: 600;
}

.details-title {
    font-size: 1.5rem;
    font-weight: 600;
    color: #333;
    margin-bottom: 20px;
}

.details-card {
    background: white;
    border-radius: 8px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    overflow: hidden;
}

.detail-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 20px;
    border-bottom: 1px solid #eee;
}

.detail-item:last-child {
    border-bottom: none;
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

.item-name {
    font-weight: 600;
    color: #333;
    margin-bottom: 5px;
}

.item-sku, .item-quantity {
    display: block;
    font-size: 0.9rem;
    color: #666;
    margin-bottom: 2px;
}

.item-pricing {
    text-align: right;
}

.unit-price {
    font-size: 0.9rem;
    color: #666;
    margin-bottom: 5px;
}

.total-price {
    font-weight: 600;
    color: #ff6b00;
    font-size: 1.1rem;
}

.delivery-info .details-card {
    padding: 25px;
}

.delivery-info h6 {
    font-weight: 600;
    color: #333;
    margin-bottom: 8px;
    margin-top: 15px;
}

.delivery-info h6:first-child {
    margin-top: 0;
}

.delivery-info p {
    color: #666;
    margin-bottom: 0;
}

@media (max-width: 768px) {
    .success-card {
        padding: 30px 20px;
    }

    .success-title {
        font-size: 2rem;
    }

    .success-icon {
        font-size: 3rem;
    }

    .info-item {
        flex-direction: column;
        align-items: flex-start;
        text-align: left;
    }

    .detail-item {
        flex-direction: column;
        align-items: flex-start;
        text-align: left;
    }

    .item-pricing {
        text-align: left;
        margin-top: 10px;
        width: 100%;
    }
}
</style>
@endpush

@push('scripts')
<script>
// Auto redirect after successful order (optional)
document.addEventListener('DOMContentLoaded', function() {
    // Optional: Auto refresh order status
    // setInterval(function() {
    //     // Check order status via AJAX
    // }, 30000);

    // Track order completion event for analytics
    if (typeof gtag !== 'undefined') {
        gtag('event', 'purchase', {
            'transaction_id': '{{ $order->order_code }}',
            'value': {{ $order->total_amount }},
            'currency': 'VND'
        });
    }
});
</script>
@endpush
@endsection
