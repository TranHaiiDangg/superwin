@extends('layouts.app')

@section('title', 'Đơn hàng của tôi - SuperWin')

@section('content')
<div class="orders-page py-5">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h1 class="page-title mb-4">Đơn hàng của tôi</h1>

                @if($orders->count() > 0)
                    <div class="orders-list">
                        @foreach($orders as $order)
                        <div class="order-card mb-4">
                            <div class="order-header">
                                <div class="order-info">
                                    <h5 class="order-code">{{ $order->order_code }}</h5>
                                    <span class="order-date">{{ $order->created_at->format('d/m/Y H:i') }}</span>
                                </div>
                                <div class="order-status">
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
                                </div>
                            </div>

                            <div class="order-items">
                                @foreach($order->orderDetails->take(3) as $detail)
                                <div class="order-item">
                                    @if($detail->product && $detail->product->baseImage)
                                        <img src="{{ $detail->product->baseImage->url }}" alt="{{ $detail->product_name }}" class="item-image">
                                    @else
                                        <img src="/images/default.png" alt="{{ $detail->product_name }}" class="item-image">
                                    @endif
                                    <div class="item-details">
                                        <h6 class="item-name">{{ $detail->product_name }}</h6>
                                        <span class="item-quantity">Số lượng: {{ $detail->quantity }}</span>
                                    </div>
                                    <div class="item-price">
                                        {{ number_format($detail->total_price) }}đ
                                    </div>
                                </div>
                                @endforeach

                                @if($order->orderDetails->count() > 3)
                                <div class="more-items">
                                    +{{ $order->orderDetails->count() - 3 }} sản phẩm khác
                                </div>
                                @endif
                            </div>

                            <div class="order-footer">
                                <div class="order-total">
                                    <strong>Tổng tiền: {{ number_format($order->total_amount) }}đ</strong>
                                </div>
                                <div class="order-actions">
                                    <a href="{{ route('orders.show', $order->id) }}" class="btn btn-outline-primary btn-sm">
                                        Xem chi tiết
                                    </a>
                                    @if(in_array($order->status, ['pending', 'confirmed']))
                                    <button class="btn btn-outline-danger btn-sm" onclick="cancelOrder('{{ $order->id }}')">
                                        Hủy đơn hàng
                                    </button>
                                    @endif
                                    <!-- @if($order->status == 'delivered')
                                    <button class="btn btn-primary btn-sm">
                                        Đánh giá
                                    </button>
                                    @endif -->
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>

                    <!-- Pagination -->
                    <div class="d-flex justify-content-center">
                        {{ $orders->links() }}
                    </div>
                @else
                    <div class="empty-orders text-center py-5">
                        <i class="fas fa-box-open fa-3x text-muted mb-3"></i>
                        <h3>Bạn chưa có đơn hàng nào</h3>
                        <p class="text-muted">Hãy khám phá các sản phẩm của chúng tôi và đặt hàng ngay!</p>
                        <a href="{{ route('home') }}" class="btn btn-primary">
                            Bắt đầu mua sắm
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
.orders-page {
    background: #f8f9fa;
    min-height: 100vh;
}

.page-title {
    color: #333;
    font-weight: 600;
}

.order-card {
    background: white;
    border-radius: 8px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    overflow: hidden;
}

.order-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 20px;
    border-bottom: 1px solid #eee;
    background: #fafafa;
}

.order-code {
    font-family: monospace;
    font-weight: bold;
    color: #ff6b00;
    margin-bottom: 5px;
}

.order-date {
    color: #666;
    font-size: 0.9rem;
}

.status-badge {
    padding: 6px 12px;
    border-radius: 20px;
    font-size: 0.85rem;
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

.order-items {
    padding: 20px;
}

.order-item {
    display: flex;
    align-items: center;
    margin-bottom: 15px;
    padding-bottom: 15px;
    border-bottom: 1px solid #f0f0f0;
}

.order-item:last-child {
    margin-bottom: 0;
    padding-bottom: 0;
    border-bottom: none;
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
    font-weight: 600;
    color: #333;
    margin-bottom: 5px;
    font-size: 0.95rem;
}

.item-quantity {
    color: #666;
    font-size: 0.85rem;
}

.item-price {
    font-weight: 600;
    color: #ff6b00;
}

.more-items {
    text-align: center;
    color: #666;
    font-style: italic;
    padding: 10px;
    background: #f8f9fa;
    border-radius: 6px;
}

.order-footer {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 20px;
    border-top: 1px solid #eee;
    background: #fafafa;
}

.order-total {
    font-size: 1.1rem;
    color: #333;
}

.order-actions {
    display: flex;
    gap: 10px;
}

.empty-orders {
    background: white;
    border-radius: 8px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
}

@media (max-width: 768px) {
    .order-header {
        flex-direction: column;
        align-items: flex-start;
        gap: 15px;
    }

    .order-footer {
        flex-direction: column;
        align-items: flex-start;
        gap: 15px;
    }

    .order-actions {
        width: 100%;
        justify-content: flex-end;
    }

    .order-item {
        flex-direction: column;
        align-items: flex-start;
        text-align: left;
    }

    .item-image {
        margin-bottom: 10px;
        margin-right: 0;
    }

    .item-price {
        margin-top: 5px;
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
