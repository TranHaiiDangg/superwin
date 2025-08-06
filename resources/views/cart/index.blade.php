@extends('layouts.app')

@section('title', 'Giỏ hàng - SuperWin')

@section('content')
<div class="cart-page py-5">
    <div class="container">
        <h1 class="cart-title mb-4">Giỏ hàng của bạn</h1>

        @if($cart->count() > 0)
            <div class="row">
                <div class="col-lg-8">
                    <div class="cart-items">
                        @foreach($cart as $itemKey => $item)
                            <div class="cart-item" data-item-key="{{ $itemKey }}">
                                <div class="row align-items-center">
                                    <div class="col-md-2">
                                        <img src="{{ $item['image'] }}" alt="{{ $item['name'] }}" class="img-fluid">
                                    </div>
                                    <div class="col-md-4">
                                        <h5 class="product-name">{{ $item['name'] }}</h5>
                                        @if(!empty($item['attributes']))
                                            <div class="product-attributes">
                                                @foreach($item['attributes'] as $attribute => $value)
                                                    <span class="attribute-item">{{ $attribute }}: {{ $value }}</span>
                                                @endforeach
                                            </div>
                                        @endif
                                    </div>
                                    <div class="col-md-2">
                                        <div class="product-price">{{ number_format($item['price']) }}đ</div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="quantity-controls">
                                            <button class="btn-quantity" onclick="updateQuantity('{{ $itemKey }}', -1)">-</button>
                                            <input type="number" class="quantity-input" value="{{ $item['quantity'] }}"
                                                   min="1" onchange="updateQuantity('{{ $itemKey }}', this.value)">
                                            <button class="btn-quantity" onclick="updateQuantity('{{ $itemKey }}', 1)">+</button>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="subtotal">{{ number_format($item['price'] * $item['quantity']) }}đ</div>
                                        <button class="btn-remove" onclick="removeItem('{{ $itemKey }}')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="cart-summary">
                        <h3 class="summary-title">Tổng giỏ hàng</h3>
                        <div class="summary-item">
                            <span>Tạm tính:</span>
                            <span class="cart-total">{{ number_format($cart->sum(function($item) {
                                return $item['price'] * $item['quantity'];
                            })) }}đ</span>
                        </div>
                        <div class="summary-item">
                            <span>Phí vận chuyển:</span>
                            <span>Miễn phí</span>
                        </div>
                        <div class="summary-total">
                            <span>Tổng cộng:</span>
                            <span class="total-amount">{{ number_format($cart->sum(function($item) {
                                return $item['price'] * $item['quantity'];
                            })) }}đ</span>
                        </div>
                        <button class="btn-checkout" onclick="window.location.href='{{ route('checkout') }}'">
                            Tiến hành thanh toán
                        </button>
                        <button class="btn-continue" onclick="window.location.href='{{ route('home') }}'">
                            Tiếp tục mua sắm
                        </button>
                    </div>
                </div>
            </div>
        @else
            <div class="empty-cart text-center">
                <i class="fas fa-shopping-cart fa-3x mb-3"></i>
                <h3>Giỏ hàng của bạn đang trống</h3>
                <p>Hãy thêm sản phẩm vào giỏ hàng để tiến hành mua sắm</p>
                <a href="{{ route('home') }}" class="btn-continue">Tiếp tục mua sắm</a>
            </div>
        @endif
    </div>
</div>

@push('styles')
<style>
.cart-page {
    background: #f8f9fa;
}

.cart-title {
    font-size: 1.5rem;
    font-weight: bold;
    color: #333;
}

.cart-item {
    background: white;
    padding: 20px;
    margin-bottom: 15px;
    border-radius: 8px;
    box-shadow: 0 1px 3px rgba(0,0,0,0.1);
}

.product-name {
    font-size: 1rem;
    margin-bottom: 5px;
}

.product-attributes {
    font-size: 0.9rem;
    color: #666;
}

.attribute-item {
    display: inline-block;
    margin-right: 10px;
}

.product-price {
    font-weight: 500;
    color: #ff6b00;
}

.quantity-controls {
    display: flex;
    align-items: center;
    gap: 5px;
}

.btn-quantity {
    width: 30px;
    height: 30px;
    border: 1px solid #ddd;
    background: white;
    border-radius: 4px;
    cursor: pointer;
}

.quantity-input {
    width: 50px;
    text-align: center;
    border: 1px solid #ddd;
    border-radius: 4px;
    padding: 5px;
}

.subtotal {
    font-weight: bold;
    color: #ff6b00;
    margin-bottom: 5px;
}

.btn-remove {
    border: none;
    background: none;
    color: #dc3545;
    cursor: pointer;
}

.cart-summary {
    background: white;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 1px 3px rgba(0,0,0,0.1);
}

.summary-title {
    font-size: 1.2rem;
    margin-bottom: 20px;
    padding-bottom: 10px;
    border-bottom: 1px solid #eee;
}

.summary-item {
    display: flex;
    justify-content: space-between;
    margin-bottom: 15px;
    color: #666;
}

.summary-total {
    display: flex;
    justify-content: space-between;
    margin: 20px 0;
    padding-top: 15px;
    border-top: 1px solid #eee;
    font-weight: bold;
    font-size: 1.1rem;
}

.total-amount {
    color: #ff6b00;
}

.btn-checkout {
    width: 100%;
    padding: 12px;
    background: #ff6b00;
    color: white;
    border: none;
    border-radius: 6px;
    margin-bottom: 10px;
    cursor: pointer;
    transition: background 0.3s ease;
}

.btn-checkout:hover {
    background: #e66000;
}

.btn-continue {
    width: 100%;
    padding: 12px;
    background: white;
    color: #ff6b00;
    border: 1px solid #ff6b00;
    border-radius: 6px;
    cursor: pointer;
    transition: all 0.3s ease;
}

.btn-continue:hover {
    background: #fff0e6;
}

.empty-cart {
    padding: 50px 0;
}

.empty-cart i {
    color: #ddd;
}

.empty-cart h3 {
    margin: 20px 0;
    color: #333;
}

.empty-cart p {
    color: #666;
    margin-bottom: 30px;
}
</style>
@endpush

@push('scripts')
<script>
function updateQuantity(itemKey, value) {
    let input = document.querySelector(`.cart-item[data-item-key="${itemKey}"] .quantity-input`);
    let currentQty = parseInt(input.value);

    if (typeof value === 'string') {
        value = parseInt(value);
    } else {
        value = currentQty + value;
    }

    if (value < 1) value = 1;

    fetch(`/cart/update/${itemKey}`, {
        method: 'PATCH',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({ quantity: value })
    })
    .then(response => response.json())
    .then(data => {
        input.value = value;
        updateCartUI(data);
    });
}

function removeItem(itemKey) {
    if (!confirm('Bạn có chắc muốn xóa sản phẩm này?')) return;

    fetch(`/cart/remove/${itemKey}`, {
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        }
    })
    .then(response => response.json())
    .then(data => {
        document.querySelector(`.cart-item[data-item-key="${itemKey}"]`).remove();
        updateCartUI(data);

        if (data.cartCount === 0) {
            location.reload();
        }
    });
}

function updateCartUI(data) {
    // Update cart count in header
    document.querySelector('.cart-count').textContent = data.cartCount;

    // Update total
    document.querySelector('.cart-total').textContent = new Intl.NumberFormat('vi-VN').format(data.cartTotal) + 'đ';
    document.querySelector('.total-amount').textContent = new Intl.NumberFormat('vi-VN').format(data.cartTotal) + 'đ';
}
</script>
@endpush
