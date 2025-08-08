// Cart Manager for localStorage functionality
class CartManager {
    constructor() {
        this.storageKey = 'superwin_cart';
        this.cartData = this.loadFromStorage();
        this.init();
    }

    loadFromStorage() {
        try {
            const stored = localStorage.getItem(this.storageKey);
            return stored ? JSON.parse(stored) : [];
        } catch (error) {
            console.error('Error loading cart from localStorage:', error);
            return [];
        }
    }

    saveToStorage() {
        try {
            localStorage.setItem(this.storageKey, JSON.stringify(this.cartData));
            this.updateCartCount();
        } catch (error) {
            console.error('Error saving cart to localStorage:', error);
        }
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
                price: product.price,
                quantity: 1,
                image: product.image || '/image/sp1.png'
            });
        }

        this.saveToStorage();
        this.showNotification('Sản phẩm đã được thêm vào giỏ hàng', 'success');
    }

    updateQuantity(id, change) {
        const item = this.cartData.find(item => item.id === id);
        if (item) {
            const newQuantity = item.quantity + change;
            if (newQuantity >= 1) {
                item.quantity = newQuantity;
            } else if (change < 0 && item.quantity === 1) {
                this.removeItem(id);
                return;
            }
            this.saveToStorage();
        }
    }

    setQuantity(id, quantity) {
        const item = this.cartData.find(item => item.id === id);
        const newQuantity = parseInt(quantity);
        if (item && newQuantity >= 1) {
            item.quantity = newQuantity;
            this.saveToStorage();
        }
    }

    removeItem(id) {
        this.cartData = this.cartData.filter(item => item.id !== id);
        this.saveToStorage();
    }

    clear() {
        this.cartData = [];
        this.saveToStorage();
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

    updateCartCount() {
        const count = this.getCount();
        const cartCountElements = document.querySelectorAll('.cart-count');

        cartCountElements.forEach(element => {
            element.textContent = count;
            element.style.display = count > 0 ? 'inline-block' : 'none';
        });

        // Save count to localStorage for header
        localStorage.setItem('cartCount', count);
    }

    showNotification(message, type = 'info') {
        const notification = document.createElement('div');
        notification.className = `alert alert-${type} alert-dismissible fade show`;
        notification.style.cssText = 'position: fixed; top: 20px; right: 20px; z-index: 9999; min-width: 300px;';

        notification.innerHTML = `
            <i class="fas fa-${type === 'success' ? 'check-circle' : 'info-circle'} me-2"></i>
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        `;

        document.body.appendChild(notification);

        setTimeout(() => {
            notification.remove();
        }, 3000);
    }

    init() {
        this.updateCartCount();
    }
}

// Global cart manager instance
let cartManager;

// Initialize cart manager when page loads
document.addEventListener('DOMContentLoaded', function() {
    console.log('Initializing CartManager...');
    cartManager = new CartManager();
    console.log('CartManager initialized:', cartManager);
});

// Global functions for backward compatibility
function addToCart(productId) {
    console.log('addToCart called with productId:', productId);

    // Check if cartManager is initialized
    if (!cartManager) {
        console.error('CartManager not initialized');
        alert('Hệ thống giỏ hàng chưa sẵn sàng');
        return;
    }

    // Show loading notification
    cartManager.showNotification('Đang thêm vào giỏ hàng...', 'info');

    // Try to get product data from DOM
    const productElement = document.querySelector(`[data-product-id="${productId}"]`);
    let product;

    if (productElement) {
        product = {
            id: parseInt(productId),
            name: productElement.dataset.productName || `Sản phẩm ${productId}`,
            model: productElement.dataset.productModel || `SW-${productId}`,
            price: parseInt(productElement.dataset.productPrice) || 1000000,
            quantity: 1,
            image: productElement.dataset.productImage || '/image/sp1.png'
        };
    } else {
        // Fallback to default product data
        product = {
            id: parseInt(productId),
            name: `Sản phẩm ${productId}`,
            model: `SW-${productId}`,
            price: 1000000,
            quantity: 1,
            image: '/image/sp1.png'
        };
    }

    // Add to cart directly
    cartManager.addItem(product);
}

function updateQuantity(id, change) {
    if (cartManager) {
        cartManager.updateQuantity(id, change);
    }
}

function setQuantity(id, quantity) {
    if (cartManager) {
        cartManager.setQuantity(id, quantity);
    }
}

function removeItem(id) {
    if (cartManager) {
        cartManager.removeItem(id);
    }
}

function checkout() {
    if (!cartManager || cartManager.cartData.length === 0) {
        alert('Giỏ hàng trống!');
        return;
    }
    window.location.href = '/checkout';
}
