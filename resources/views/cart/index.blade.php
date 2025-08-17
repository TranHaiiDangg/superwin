@extends('layouts.app')

@section('title', 'Giỏ Hàng - SuperWin')

@section('content')
<div class="container-fluid py-4">
    <div class="cart-wrapper">
        <!-- Left Section: GIỎ HÀNG -->
        <div class="cart-section">
            <h2 class="section-title">GIỎ HÀNG</h2>
            <div id="cartItems">
                <!-- Cart items will be rendered here -->
            </div>
        </div>

        <!-- Right Section: THANH TOÁN -->
        <div class="payment-section">
            <h2 class="section-title">THANH TOÁN</h2>
            <div class="payment-summary">
                <div class="summary-item">
                    <span>Số lượng sản phẩm:</span>
                    <span id="productCount">0</span>
                </div>
                <div class="summary-item">
                    <span>Tạm tính:</span>
                    <span id="subtotal">0₫</span>
                </div>
                <div class="summary-item">
                    <span>Phí VAT (8%):</span>
                    <span id="vat">0₫</span>
                </div>
                <div class="summary-item">
                    <span>Phí vận chuyển:</span>
                    <span id="shipping">30.000₫</span>
                </div>
                <div class="summary-item">
                    <span>Giảm giá:</span>
                    <span id="discount">0₫</span>
                </div>
                <div class="summary-divider"></div>
                <div class="summary-item total">
                    <span>Tổng cộng:</span>
                    <span id="total">0₫</span>
                </div>
            </div>

            <button class="checkout-btn" onclick="checkout()">
                <i class="fas fa-credit-card"></i>
                Tiến Hành Thanh Toán
            </button>

            <div class="security-info">
                <div class="security-icon">
                    <i class="fas fa-shield-alt"></i>
                </div>
                <div class="security-text">
                    <div class="security-title">Thanh toán an toàn & bảo mật</div>
                    <div class="security-subtitle">Thông tin của bạn được mã hóa và bảo vệ</div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div id="deleteModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h4>Xác nhận xóa</h4>
        </div>
        <div class="modal-body">
            <p>Bạn có chắc chắn muốn xóa sản phẩm này khỏi giỏ hàng?</p>
        </div>
        <div class="modal-footer">
            <button id="cancelDelete" class="btn btn-secondary">Hủy</button>
            <button id="confirmDelete" class="btn btn-danger">Xóa</button>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
// Cart functionality with localStorage
class Cart {
    constructor() {
        this.storageKey = 'superwin_cart';
        this.cartData = this.loadFromStorage();
        this.init();
    }

    loadFromStorage() {
        const stored = localStorage.getItem(this.storageKey);
        return stored ? JSON.parse(stored) : [];
    }

    saveToStorage() {
        localStorage.setItem(this.storageKey, JSON.stringify(this.cartData));
    }

    addItem(product) {
        const existingItem = this.cartData.find(item => item.id === product.id);

        if (existingItem) {
            existingItem.quantity += 1;
        } else {
            this.cartData.push({
                id: product.id,
                name: product.name,
                model: product.model || product.sku || `SW-${product.id}`,
                price: product.sale_price || product.price,
                quantity: 1,
                image: product.image || '/image/sp1.png'
            });
        }

        this.saveToStorage();
        this.render();
        this.updateCartCount();
    }

    updateQuantity(id, change) {
        const item = this.cartData.find(item => item.id === id);
        if (item) {
            const newQuantity = item.quantity + change;
            if (newQuantity >= 1) {
                item.quantity = newQuantity;
            } else if (change < 0 && item.quantity === 1) {
                this.showDeleteModal(id);
                return;
            }
            this.saveToStorage();
            this.render();
        }
    }

    setQuantity(id, quantity) {
        const item = this.cartData.find(item => item.id === id);
        const newQuantity = parseInt(quantity);
        if (item && newQuantity >= 1) {
            item.quantity = newQuantity;
            this.saveToStorage();
            this.render();
        }
    }

    removeItem(id) {
        this.showDeleteModal(id);
    }

    showDeleteModal(id) {
        this.deleteProductId = id;
        document.getElementById('deleteModal').style.display = 'flex';
    }

    confirmDelete() {
        if (this.deleteProductId !== null) {
            this.cartData = this.cartData.filter(item => item.id !== this.deleteProductId);
            this.saveToStorage();
            this.render();
            this.closeModal();
        }
    }

    closeModal() {
        document.getElementById('deleteModal').style.display = 'none';
        this.deleteProductId = null;
    }

    clear() {
        this.cartData = [];
        this.saveToStorage();
        this.render();
    }

    getTotal() {
        return this.cartData.reduce((sum, item) => sum + (item.price * item.quantity), 0);
    }

    getCount() {
        return this.cartData.reduce((sum, item) => sum + item.quantity, 0);
    }

    formatPrice(price) {
        return price.toLocaleString('vi-VN') + '₫';
    }

    render() {
        const cartItemsContainer = document.getElementById('cartItems');

        if (this.cartData.length === 0) {
            cartItemsContainer.innerHTML = `
                <div class="empty-cart">
                    <i class="fas fa-shopping-cart"></i>
                    <h3>Giỏ hàng trống</h3>
                    <p>Hãy thêm sản phẩm vào giỏ hàng để tiếp tục mua sắm</p>
                    <a href="{{ route('home') }}" class="continue-shopping">Tiếp tục mua sắm</a>
                </div>
            `;
            this.updatePaymentSummary();
            return;
        }

        cartItemsContainer.innerHTML = `
            <table class="products-table">
                <thead>
                    <tr>
                        <th>Sản phẩm</th>
                        <th>Model</th>
                        <th>Số lượng</th>
                        <th>Giá</th>
                        <th>Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    ${this.cartData.map(item => `
                        <tr>
                            <td>
                                <div class="product-info">
                                    <img src="${item.image}" alt="${item.name}" class="product-image">
                                    <div class="product-details">
                                        <h4>${item.name}</h4>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="product-model">${item.model}</div>
                            </td>
                            <td>
                                <div class="quantity-controls">
                                    <button class="quantity-btn" onclick="cart.updateQuantity(${item.id}, -1)"
                                            ${item.quantity === 1 ? 'disabled' : ''}>
                                        <i class="fas fa-minus"></i>
                                    </button>
                                    <input type="number" class="quantity-input" value="${item.quantity}"
                                           onchange="cart.setQuantity(${item.id}, this.value)" min="1">
                                    <button class="quantity-btn" onclick="cart.updateQuantity(${item.id}, 1)">
                                        <i class="fas fa-plus"></i>
                                    </button>
                                </div>
                            </td>
                            <td>${this.formatPrice(item.price * item.quantity)}</td>
                            <td>
                                <button class="remove-btn" onclick="cart.removeItem(${item.id})">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                    `).join('')}
                </tbody>
            </table>
        `;

        this.updatePaymentSummary();
    }

    updatePaymentSummary() {
        const productCount = this.cartData.length;
        const subtotal = this.getTotal();
        const vat = subtotal * 0.08;
        const shipping = 30000;
        const discount = 0;
        const total = subtotal + vat + shipping - discount;

        document.getElementById('productCount').textContent = productCount;
        document.getElementById('subtotal').textContent = this.formatPrice(subtotal);
        document.getElementById('vat').textContent = this.formatPrice(vat);
        document.getElementById('shipping').textContent = this.formatPrice(shipping);
        document.getElementById('discount').textContent = this.formatPrice(discount);
        document.getElementById('total').textContent = this.formatPrice(total);
    }

    updateCartCount() {
        const count = this.getCount();
        const cartCountElement = document.querySelector('.cart-count');
        if (cartCountElement) {
            cartCountElement.textContent = count;
            cartCountElement.style.display = count > 0 ? 'block' : 'none';
        }
    }

    init() {
        this.render();
        this.updateCartCount();

        // Modal event listeners
        document.getElementById('confirmDelete').onclick = () => this.confirmDelete();
        document.getElementById('cancelDelete').onclick = () => this.closeModal();

        document.getElementById('deleteModal').onclick = (e) => {
            if (e.target === document.getElementById('deleteModal')) {
                this.closeModal();
            }
        };
    }
}

// Global cart instance
let cart;

// Initialize cart when page loads
document.addEventListener('DOMContentLoaded', function() {
    cart = new Cart();
});

// Global functions for backward compatibility
function updateQuantity(id, change) {
    cart.updateQuantity(id, change);
}

function setQuantity(id, quantity) {
    cart.setQuantity(id, quantity);
}

function removeItem(id) {
    cart.removeItem(id);
}

function checkout() {
    if (cart.cartData.length === 0) {
        alert('Giỏ hàng trống!');
        return;
    }

    // Tạo form để gửi dữ liệu giỏ hàng
    const form = document.createElement('form');
    form.method = 'GET';
    form.action = '{{ route("orders.checkout") }}';

    // Thêm dữ liệu giỏ hàng vào form
    const cartDataInput = document.createElement('input');
    cartDataInput.type = 'hidden';
    cartDataInput.name = 'cart_data';
    cartDataInput.value = JSON.stringify(cart.cartData);

    form.appendChild(cartDataInput);
    document.body.appendChild(form);
    form.submit();
}
</script>
@endpush

@push('styles')
<style>
/* Cart Page Styles */
.cart-wrapper {
    max-width: 1200px;
    margin: 0 auto;
    display: grid;
    grid-template-columns: 2fr 1fr;
    gap: 30px;
    align-items: start;
}

.cart-section, .payment-section {
    background: white;
    border-radius: 15px;
    padding: 25px;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
}

.section-title {
    font-size: 24px;
    color: #0066cc;
    margin-bottom: 20px;
    padding-bottom: 10px;
    border-bottom: 2px solid #0066cc;
    font-weight: 600;
}

/* Products Table */
.products-table {
    width: 100%;
    border-collapse: collapse;
    margin-bottom: 20px;
}

.products-table th {
    background: #f8f9fa;
    padding: 15px 10px;
    text-align: center;
    font-weight: 600;
    color: #333;
    border-bottom: 2px solid #dee2e6;
}

.products-table td {
    padding: 20px 10px;
    text-align: center;
    border-bottom: 1px solid #dee2e6;
    vertical-align: middle;
}

.product-info {
    display: flex;
    align-items: center;
    gap: 15px;
    text-align: left;
}

.product-image {
    width: 80px;
    height: 80px;
    border-radius: 10px;
    object-fit: cover;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
}

.product-details h4 {
    font-size: 16px;
    color: #333;
    margin-bottom: 5px;
    font-weight: 600;
}

.product-model {
    color: #666;
    font-size: 14px;
}

/* Quantity Controls */
.quantity-controls {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
}

.quantity-btn {
    width: 35px;
    height: 35px;
    border: none;
    border-radius: 50%;
    background: #0066cc;
    color: white;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.3s ease;
}

.quantity-btn:hover:not(:disabled) {
    background: #0056b3;
    transform: scale(1.1);
}

.quantity-btn:disabled {
    background: #ccc;
    cursor: not-allowed;
}

.quantity-input {
    width: 60px;
    height: 35px;
    text-align: center;
    border: 1px solid #ddd;
    border-radius: 5px;
    font-size: 14px;
}

/* Remove Button */
.remove-btn {
    width: 40px;
    height: 40px;
    border: none;
    border-radius: 50%;
    background: #dc3545;
    color: white;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.3s ease;
}

.remove-btn:hover {
    background: #c82333;
    transform: scale(1.1);
}

/* Payment Summary */
.payment-summary {
    margin-bottom: 30px;
}

.summary-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 12px 0;
    border-bottom: 1px solid #eee;
    font-size: 16px;
}

.summary-item.total {
    font-size: 18px;
    font-weight: 700;
    color: #dc3545;
    border-bottom: none;
    margin-top: 10px;
}

.summary-divider {
    height: 1px;
    background: #ddd;
    margin: 15px 0;
}

/* Checkout Button */
.checkout-btn {
    width: 100%;
    background: #28a745;
    color: white;
    border: none;
    padding: 15px 20px;
    border-radius: 10px;
    font-size: 16px;
    font-weight: 600;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
    transition: all 0.3s ease;
    margin-bottom: 20px;
}

.checkout-btn:hover {
    background: #218838;
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(40, 167, 69, 0.3);
}

/* Security Info */
.security-info {
    display: flex;
    align-items: center;
    gap: 15px;
    padding: 20px;
    background: #f8f9fa;
    border-radius: 10px;
    border: 1px solid #e9ecef;
}

.security-icon {
    width: 50px;
    height: 50px;
    background: #28a745;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 20px;
}

.security-text {
    flex: 1;
}

.security-title {
    font-weight: 600;
    color: #333;
    margin-bottom: 5px;
}

.security-subtitle {
    font-size: 14px;
    color: #666;
}

/* Empty Cart */
.empty-cart {
    text-align: center;
    padding: 60px 20px;
    color: #666;
}

.empty-cart i {
    font-size: 4rem;
    color: #ccc;
    margin-bottom: 20px;
}

.empty-cart h3 {
    margin-bottom: 10px;
    color: #333;
}

.empty-cart p {
    margin-bottom: 20px;
}

.continue-shopping {
    display: inline-block;
    background: #0066cc;
    color: white;
    padding: 12px 24px;
    border-radius: 25px;
    text-decoration: none;
    transition: all 0.3s ease;
}

.continue-shopping:hover {
    background: #0056b3;
    transform: translateY(-2px);
    color: white;
    text-decoration: none;
}

/* Modal */
.modal {
    display: none;
    position: fixed;
    z-index: 1000;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5);
    align-items: center;
    justify-content: center;
}

.modal-content {
    background-color: white;
    border-radius: 10px;
    padding: 0;
    width: 400px;
    max-width: 90%;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.3);
}

.modal-header {
    padding: 20px;
    border-bottom: 1px solid #eee;
}

.modal-header h4 {
    margin: 0;
    color: #333;
}

.modal-body {
    padding: 20px;
}

.modal-footer {
    padding: 20px;
    border-top: 1px solid #eee;
    display: flex;
    gap: 10px;
    justify-content: flex-end;
}

.btn {
    padding: 8px 16px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    font-size: 14px;
    transition: all 0.3s ease;
}

.btn-secondary {
    background: #6c757d;
    color: white;
}

.btn-secondary:hover {
    background: #5a6268;
}

.btn-danger {
    background: #dc3545;
    color: white;
}

.btn-danger:hover {
    background: #c82333;
}

/* Responsive */
@media (max-width: 992px) {
    .cart-wrapper {
        grid-template-columns: 1fr;
        gap: 20px;
    }
}

@media (max-width: 768px) {
    .cart-section, .payment-section {
        padding: 15px;
    }

    .products-table {
        font-size: 14px;
    }

    .product-info {
        flex-direction: column;
        text-align: center;
        gap: 10px;
    }

    .product-image {
        width: 60px;
        height: 60px;
    }

    .quantity-controls {
        flex-direction: column;
        gap: 5px;
    }

    .quantity-input {
        width: 50px;
    }
}
</style>
@endpush
