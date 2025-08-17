@extends('layouts.app')

@section('title', 'Chi tiết đơn hàng #' . $order->order_code . ' - SuperWin')

@section('content')
<div class="order-detail-page py-5">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <!-- Breadcrumb -->
                <nav aria-label="breadcrumb" class="mb-4">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Trang chủ</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('orders.index') }}">Đơn hàng của tôi</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{ $order->order_code }}</li>
                    </ol>
                </nav>

                <!-- Order Header -->
                <div class="order-header-card mb-4">
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <h1 class="order-title">Đơn hàng #{{ $order->order_code }}</h1>
                            <p class="order-date">Đặt ngày: {{ $order->created_at->format('d/m/Y H:i') }}</p>
                        </div>
                        <div class="col-md-6 text-md-end">
                            <span class="status-badge status-{{ $order->status }}">
                                @switch($order->status)
                                    @case('pending')
                                        Chờ xử lý
                                        @break
                                    @case('confirmed')
                                        Đã xác nhận
                                        @break
                                    @case('processing')
                                        Đang xử lý
                                        @break
                                    @case('shipped')
                                        Đang giao hàng
                                        @break
                                    @case('delivered')
                                        Đã giao hàng
                                        @break
                                    @case('cancelled')
                                        Đã hủy
                                        @break
                                    @default
                                        {{ $order->status }}
                                @endswitch
                            </span>
                            @if(in_array($order->status, ['pending', 'confirmed']))
                            <div class="mt-2">
                                <button class="btn btn-outline-danger btn-sm" onclick="cancelOrder('{{ $order->id }}')">
                                    Hủy đơn hàng
                                </button>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="row">
                    <!-- Order Items -->
                    <div class="col-lg-8">
                        <div class="order-items-card">
                            <h3 class="card-title">Sản phẩm đã đặt</h3>

                            <div class="items-list">
                                @foreach($order->orderDetails as $detail)
                                <div class="order-item">
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
                                            <span class="item-unit-price">Đơn giá: {{ number_format($detail->unit_price) }}đ</span>
                                        </div>
                                    </div>
                                    <div class="item-total">
                                        {{ number_format($detail->total_price) }}đ
                                    </div>
                                </div>
                                @endforeach
                            </div>

                            <!-- Order Totals -->
                            <div class="order-totals">
                                <div class="total-row">
                                    <span>Tạm tính:</span>
                                    <span>{{ number_format($order->subtotal) }}đ</span>
                                </div>
                                <div class="total-row">
                                    <span>Phí vận chuyển:</span>
                                    <span>{{ number_format($order->shipping_fee) }}đ</span>
                                </div>
                                @if($order->discount_amount > 0)
                                <div class="total-row discount">
                                    <span>Giảm giá:</span>
                                    <span>-{{ number_format($order->discount_amount) }}đ</span>
                                </div>
                                @endif
                                <div class="total-row final-total">
                                    <span>Tổng cộng:</span>
                                    <span>{{ number_format($order->total_amount) }}đ</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Order Information -->
                    <div class="col-lg-4">
                        <!-- Payment Information -->
                        <div class="info-card mb-4">
                            <h4 class="card-title">Thông tin thanh toán</h4>
                            <div class="info-content">
                                <div class="info-item">
                                    <strong>Phương thức:</strong>
                                    <span>
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
                                    <strong>Tổng tiền:</strong>
                                    <span class="text-success">{{ number_format($order->total_amount) }}đ</span>
                                </div>
                            </div>

                            @if($order->payment_method == 'bank_transfer' && in_array($order->status, ['pending', 'confirmed']))
                            <div class="bank-info mt-3">
                                <div class="alert alert-info">
                                    <h6><i class="fas fa-info-circle me-2"></i>Thông tin chuyển khoản</h6>
                                    <p><strong>Ngân hàng:</strong> Vietcombank</p>
                                    <p><strong>Số tài khoản:</strong> 1234567890</p>
                                    <p><strong>Chủ tài khoản:</strong> CÔNG TY SUPERWIN</p>
                                    <p><strong>Nội dung:</strong> {{ $order->order_code }}</p>
                                </div>
                            </div>
                            @endif
                        </div>

                        <!-- Delivery Information -->
                        <div class="info-card mb-4">
                            <h4 class="card-title">Thông tin giao hàng</h4>
                            <div class="info-content">
                                <div class="info-item">
                                    <strong>Người nhận:</strong>
                                    <span>{{ $order->customer_name }}</span>
                                </div>
                                <div class="info-item">
                                    <strong>Số điện thoại:</strong>
                                    <span>{{ $order->customer_phone }}</span>
                                </div>
                                <div class="info-item">
                                    <strong>Email:</strong>
                                    <span>{{ $order->customer_email }}</span>
                                </div>
                                <div class="info-item">
                                    <strong>Địa chỉ:</strong>
                                    <span>
                                        {{ $order->shipping_address }}<br>
                                        {{ $order->shipping_ward }}, {{ $order->shipping_district }}<br>
                                        {{ $order->shipping_city }}
                                    </span>
                                </div>
                                @if($order->estimated_delivery_date)
                                <div class="info-item">
                                    <strong>Dự kiến giao hàng:</strong>
                                    <span>{{ $order->estimated_delivery_date->format('d/m/Y') }}</span>
                                </div>
                                @endif
                                @if($order->customer_note)
                                <div class="info-item">
                                    <strong>Ghi chú:</strong>
                                    <span>{{ $order->customer_note }}</span>
                                </div>
                                @endif
                            </div>
                        </div>

                        <!-- Order Timeline -->
                        <div class="info-card">
                            <h4 class="card-title">Trạng thái đơn hàng</h4>
                            <div class="timeline">
                                <div class="timeline-item {{ $order->status != 'cancelled' ? 'completed' : '' }}">
                                    <div class="timeline-marker"></div>
                                    <div class="timeline-content">
                                        <h6>Đơn hàng đã được tạo</h6>
                                        <small>{{ $order->created_at->format('d/m/Y H:i') }}</small>
                                    </div>
                                </div>

                                @if($order->status == 'cancelled')
                                <div class="timeline-item completed cancelled">
                                    <div class="timeline-marker"></div>
                                    <div class="timeline-content">
                                        <h6>Đơn hàng đã bị hủy</h6>
                                        <small>{{ $order->cancelled_at ? $order->cancelled_at->format('d/m/Y H:i') : '' }}</small>
                                        @if($order->cancel_reason)
                                        <div class="cancel-reason">{{ $order->cancel_reason }}</div>
                                        @endif
                                    </div>
                                </div>
                                @else
                                <div class="timeline-item {{ in_array($order->status, ['confirmed', 'processing', 'shipped', 'delivered']) ? 'completed' : '' }}">
                                    <div class="timeline-marker"></div>
                                    <div class="timeline-content">
                                        <h6>Đơn hàng đã được xác nhận</h6>
                                        <small>{{ in_array($order->status, ['confirmed', 'processing', 'shipped', 'delivered']) ? 'Đã xác nhận' : 'Chờ xác nhận' }}</small>
                                    </div>
                                </div>

                                <div class="timeline-item {{ in_array($order->status, ['processing', 'shipped', 'delivered']) ? 'completed' : '' }}">
                                    <div class="timeline-marker"></div>
                                    <div class="timeline-content">
                                        <h6>Đang chuẩn bị hàng</h6>
                                        <small>{{ in_array($order->status, ['processing', 'shipped', 'delivered']) ? 'Đang chuẩn bị' : 'Chưa bắt đầu' }}</small>
                                    </div>
                                </div>

                                <div class="timeline-item {{ in_array($order->status, ['shipped', 'delivered']) ? 'completed' : '' }}">
                                    <div class="timeline-marker"></div>
                                    <div class="timeline-content">
                                        <h6>Đang giao hàng</h6>
                                        <small>{{ in_array($order->status, ['shipped', 'delivered']) ? 'Đang giao hàng' : 'Chưa giao hàng' }}</small>
                                    </div>
                                </div>

                                <div class="timeline-item {{ $order->status == 'delivered' ? 'completed' : '' }}">
                                    <div class="timeline-marker"></div>
                                    <div class="timeline-content">
                                        <h6>Giao hàng thành công</h6>
                                        <small>{{ $order->status == 'delivered' ? ($order->delivered_at ? $order->delivered_at->format('d/m/Y H:i') : 'Đã giao hàng') : 'Chưa giao hàng' }}</small>
                                    </div>
                                </div>
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
.order-detail-page {
    background: #f8f9fa;
    min-height: 100vh;
}

.breadcrumb {
    background: transparent;
    padding: 0;
}

.order-header-card {
    background: white;
    padding: 25px;
    border-radius: 8px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
}

.order-title {
    font-size: 1.8rem;
    font-weight: 600;
    color: #333;
    margin-bottom: 5px;
}

.order-date {
    color: #666;
    margin-bottom: 0;
}

.status-badge {
    padding: 8px 16px;
    border-radius: 20px;
    font-size: 0.9rem;
    font-weight: 600;
    text-transform: uppercase;
}

.status-pending {
    background: #fff3cd;
    color: #856404;
}

.status-confirmed {
    background: #d1ecf1;
    color: #0c5460;
}

.status-processing {
    background: #e2e3e5;
    color: #383d41;
}

.status-shipped {
    background: #cce7ff;
    color: #004085;
}

.status-delivered {
    background: #d4edda;
    color: #155724;
}

.status-cancelled {
    background: #f8d7da;
    color: #721c24;
}

.order-items-card, .info-card {
    background: white;
    padding: 25px;
    border-radius: 8px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
}

.card-title {
    font-size: 1.3rem;
    font-weight: 600;
    color: #333;
    margin-bottom: 20px;
    padding-bottom: 10px;
    border-bottom: 2px solid #ff6b00;
}

.order-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 20px 0;
    border-bottom: 1px solid #eee;
}

.order-item:last-child {
    border-bottom: none;
}

.item-info {
    display: flex;
    align-items: center;
    flex: 1;
}

.item-image {
    width: 80px;
    height: 80px;
    object-fit: cover;
    border-radius: 8px;
    margin-right: 15px;
}

.item-name {
    font-weight: 600;
    color: #333;
    margin-bottom: 5px;
}

.item-sku, .item-quantity, .item-unit-price {
    display: block;
    font-size: 0.9rem;
    color: #666;
    margin-bottom: 3px;
}

.item-total {
    font-weight: 700;
    color: #ff6b00;
    font-size: 1.1rem;
}

.order-totals {
    margin-top: 20px;
    padding-top: 20px;
    border-top: 1px solid #eee;
}

.total-row {
    display: flex;
    justify-content: space-between;
    margin-bottom: 10px;
    color: #666;
}

.total-row.discount {
    color: #28a745;
}

.total-row.final-total {
    font-weight: 700;
    font-size: 1.2rem;
    color: #333;
    padding-top: 15px;
    border-top: 1px solid #eee;
    margin-top: 10px;
}

.info-content {
    font-size: 0.95rem;
}

.info-item {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    margin-bottom: 12px;
    padding-bottom: 8px;
    border-bottom: 1px solid #f0f0f0;
}

.info-item:last-child {
    border-bottom: none;
    margin-bottom: 0;
}

.info-item strong {
    color: #333;
    min-width: 100px;
    margin-right: 15px;
}

.timeline {
    position: relative;
}

.timeline::before {
    content: '';
    position: absolute;
    left: 10px;
    top: 20px;
    bottom: 20px;
    width: 2px;
    background: #ddd;
}

.timeline-item {
    position: relative;
    padding-left: 40px;
    margin-bottom: 25px;
}

.timeline-item:last-child {
    margin-bottom: 0;
}

.timeline-marker {
    position: absolute;
    left: 0;
    top: 5px;
    width: 20px;
    height: 20px;
    border-radius: 50%;
    background: #ddd;
    border: 3px solid white;
    box-shadow: 0 0 0 2px #ddd;
}

.timeline-item.completed .timeline-marker {
    background: #28a745;
    box-shadow: 0 0 0 2px #28a745;
}

.timeline-item.cancelled .timeline-marker {
    background: #dc3545;
    box-shadow: 0 0 0 2px #dc3545;
}

.timeline-content h6 {
    font-weight: 600;
    color: #333;
    margin-bottom: 5px;
}

.timeline-content small {
    color: #666;
}

.cancel-reason {
    color: #dc3545;
    font-size: 0.85rem;
    margin-top: 5px;
}

@media (max-width: 768px) {
    .order-header-card .row {
        text-align: center;
    }

    .order-item {
        flex-direction: column;
        align-items: flex-start;
        text-align: left;
    }

    .item-info {
        margin-bottom: 15px;
        width: 100%;
    }

    .item-total {
        align-self: flex-end;
    }

    .info-item {
        flex-direction: column;
        align-items: flex-start;
    }

    .info-item strong {
        margin-bottom: 5px;
    }
}
</style>
@endpush

@push('scripts')
<script>
function cancelOrder(orderId) {
    if (!confirm('Bạn có chắc chắn muốn hủy đơn hàng này?')) {
        return;
    }

    fetch(`/orders/${orderId}/cancel`, {
        method: 'PATCH',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Accept': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showToast('Đã hủy đơn hàng thành công', 'success');
            setTimeout(() => {
                location.reload();
            }, 1500);
        } else {
            showToast(data.message || 'Có lỗi xảy ra', 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showToast('Có lỗi xảy ra khi hủy đơn hàng', 'error');
    });
}

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
