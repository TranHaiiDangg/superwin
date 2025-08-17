
// Product Page JavaScript - Complete Merged Version
(function() {
    'use strict';

    // Utility Functions
    function formatPrice(price) {
        return price.toLocaleString('vi-VN', {
            style: 'currency',
            currency: 'VND',
            minimumFractionDigits: 0
        });
    }

    function showNotification(message, type = 'info') {
        const notification = document.createElement('div');
        notification.className = `custom-notification ${type}`;
        notification.textContent = message;

        // Style cơ bản
        Object.assign(notification.style, {
            position: 'fixed',
            top: '80px',
            right: '20px',
            backgroundColor: type === 'success' ? '#28a745' :
                             type === 'error' ? '#dc3545' :
                             '#007bff',
            color: '#fff',
            padding: '12px 18px',
            borderRadius: '6px',
            fontSize: '14px',
            boxShadow: '0 4px 10px rgba(0,0,0,0.15)',
            zIndex: 9999,
            opacity: 0,
            transition: 'opacity 0.3s ease'
        });

        document.body.appendChild(notification);

        // Hiện
        setTimeout(() => {
            notification.style.opacity = 1;
        }, 10);

        // Tự ẩn sau 3 giây
        setTimeout(() => {
            notification.style.opacity = 0;
            setTimeout(() => notification.remove(), 300);
        }, 3000);
    }

    // Image Gallery Data
    const imageGallery = {
        images: [
            {
                main: "/image/sp1.png",
                alt: "Máy Bơm Super Win SW-750 - Góc chính"
            },
            {
                main: "/image/sp1.png",
                alt: "Máy Bơm Super Win SW-750 - Góc bên"
            },
            {
                main: "/image/sp1.png",
                alt: "Máy Bơm Super Win SW-750 - Chi tiết động cơ"
            },
            {
                main: "/image/sp1.png",
                alt: "Máy Bơm Super Win SW-750 - Kết nối ống"
            }
        ]
    };

    // Product Configuration
    const productConfig = {
        models: {
            'SW-500': { power: '500W', price: 2450000, originalPrice: 2750000 },
            'SW-750': { power: '750W', price: 2850000, originalPrice: 3200000 },
            'SW-1000': { power: '1000W', price: 3250000, originalPrice: 3650000 },
            'SW-1500': { power: '1500W', price: 4150000, originalPrice: 4650000 }
        },
        motorTypes: {
            '1-phase': { label: '1 Pha', priceModifier: 0 },
            '3-phase': { label: '3 Pha', priceModifier: 200000 }
        }
    };

    // Global State
    let currentState = {
        selectedImage: 0,
        selectedModel: 'SW-750',
        selectedMotor: '1-phase',
        quantity: 1
    };

    // Reviews Data
    const reviewsData = {
        summary: {
            averageRating: 4.6,
            totalReviews: 186,
            ratingBreakdown: {
                5: { count: 98, percentage: 53 },
                4: { count: 52, percentage: 28 },
                3: { count: 26, percentage: 14 },
                2: { count: 7, percentage: 4 },
                1: { count: 3, percentage: 1 }
            }
        },
        reviews: [
            {
                id: 1,
                userName: "Nguyễn Văn Minh",
                rating: 5,
                date: "2024-01-15",
                productVariant: "SW-750 | 1 Pha",
                title: "Máy bơm chất lượng, hoạt động êm",
                content: "Đã sử dụng được 6 tháng, máy bơm hoạt động rất ổn định. Lưu lượng nước mạnh, bơm từ giếng khoan 15m lên bể nước dễ dàng. Tiếng ồn nhỏ, không làm phiền hàng xóm. Đóng gói cẩn thận, giao hàng nhanh.",
                helpful: 24,
                images: ["review1.jpg"],
                verified: true
            },
            {
                id: 2,
                userName: "Trần Thị Lan",
                rating: 4,
                date: "2024-01-08",
                productVariant: "SW-750 | 1 Pha",
                title: "Tốt nhưng hướng dẫn lắp đặt chưa rõ",
                content: "Máy bơm chất lượng tốt, bơm nước mạnh. Tuy nhiên hướng dẫn lắp đặt trong sách còn sơ sài, phải tự tìm hiểu thêm. Dịch vụ hậu mãi của shop khá tốt, hỗ trợ tư vấn nhiệt tình.",
                helpful: 18,
                images: [],
                verified: true
            },
            {
                id: 3,
                userName: "Lê Công Thành",
                rating: 5,
                date: "2024-01-02",
                productVariant: "SW-750 | 3 Pha",
                title: "Máy bền, tiết kiệm điện",
                content: "Dùng để bơm nước tưới vườn, rất hài lòng. Motor 3 pha chạy êm, tiết kiệm điện hơn so với loại 1 pha cũ. Đã recommned cho nhiều bạn bè. Giá cả hợp lý so với chất lượng.",
                helpful: 31,
                images: ["review3_1.jpg", "review3_2.jpg"],
                verified: true
            },
            {
                id: 4,
                userName: "Phạm Minh Đức",
                rating: 4,
                date: "2023-12-28",
                productVariant: "SW-750 | 1 Pha",
                title: "Bơm tốt, giao hàng nhanh",
                content: "Đặt hàng chiều thứ 2, sáng thứ 4 đã nhận được hàng. Máy bơm hoạt động bình thường, chưa gặp vấn đề gì. Packaging cẩn thận, có bao xốp chống sốc.",
                helpful: 12,
                images: [],
                verified: true
            },
            {
                id: 5,
                userName: "Võ Thị Mai",
                rating: 3,
                date: "2023-12-20",
                productVariant: "SW-750 | 1 Pha",
                title: "Tạm ổn nhưng hơi ồn",
                content: "Máy bơm hoạt động tốt, lưu lượng nước ổn. Tuy nhiên có hơi ồn so với mong đợi, đặc biệt vào ban đêm. Có thể do vị trí đặt máy chưa phù hợp.",
                helpful: 8,
                images: [],
                verified: true
            }
        ],
        filters: {
            rating: 'all',
            withImages: false,
            verified: false
        }
    };

    // Menu System
    function initializeMenuSystem() {
        const menuBtn = document.getElementById('menuDotsBtn');
        const menuPopup = document.getElementById('menuDotsPopup');
        const shareBtn = document.getElementById('shareBtn');
        let menuOpen = false;

        if (menuBtn && menuPopup) {
            menuBtn.addEventListener('click', function(e) {
                e.stopPropagation();
                menuPopup.style.display = menuOpen ? 'none' : 'block';
                menuOpen = !menuOpen;
            });

            // Đóng menu khi click ra ngoài
            document.addEventListener('click', function(e) {
                if (menuOpen && !menuPopup.contains(e.target) && e.target !== menuBtn) {
                    menuPopup.style.display = 'none';
                    menuOpen = false;
                }
            });
        }

        // Chia sẻ
        if (shareBtn) {
            shareBtn.addEventListener('click', function() {
                if (navigator.share) {
                    navigator.share({
                        title: document.title,
                        url: window.location.href
                    }).catch(()=>{});
                } else {
                    // Fallback: copy link
                    navigator.clipboard.writeText(window.location.href);
                    showNotification('Đã sao chép liên kết!', 'success');
                }
                menuPopup.style.display = 'none';
                menuOpen = false;
            });
        }
    }

    // Image Gallery Functions
    function setupImageGallery() {
        const mainImage = document.getElementById('mainImage');
        const thumbnails = document.querySelectorAll('.preview-thumb');

        if (mainImage && thumbnails.length > 0) {
            // Initialize with first image
            mainImage.src = imageGallery.images[0].main;
            mainImage.alt = imageGallery.images[0].alt;

            // Setup thumbnail clicks
            thumbnails.forEach((thumb, index) => {
                thumb.addEventListener('click', () => changeImage(index));

                // Update thumbnail images
                const img = thumb.querySelector('img');
                if (img && imageGallery.images[index]) {
                    img.src = imageGallery.images[index].main;
                    img.alt = imageGallery.images[index].alt;
                }
            });

            // Set first thumbnail as selected
            thumbnails[0].classList.add('selected');
        }
    }

    function changeImage(imageIndex) {
        if (imageIndex < 0 || imageIndex >= imageGallery.images.length) return;

        currentState.selectedImage = imageIndex;

        const mainImage = document.getElementById('mainImage');
        const thumbnails = document.querySelectorAll('.preview-thumb');

        if (mainImage) {
            mainImage.classList.add('transitioning');
            mainImage.src = imageGallery.images[imageIndex].main;
            mainImage.alt = imageGallery.images[imageIndex].alt;

            setTimeout(() => {
                mainImage.classList.remove('transitioning');
            }, 300);
        }

        // Update thumbnail selection
        thumbnails.forEach((thumb, index) => {
            thumb.classList.toggle('selected', index === imageIndex);
        });
    }

    // Product Options Functions
    function setupProductOptions() {
        const modelButtons = document.querySelectorAll('[data-model]');
        const motorButtons = document.querySelectorAll('[data-motor]');

        // Model selection
        modelButtons.forEach(button => {
            button.addEventListener('click', () => {
                const model = button.dataset.model;
                if (model && productConfig.models[model]) {
                    currentState.selectedModel = model;

                    // Update button states
                    modelButtons.forEach(btn => btn.classList.remove('selected'));
                    button.classList.add('selected');

                    updatePricing();
                    updateProductTitle();
                }
            });
        });

        // Motor type selection
        motorButtons.forEach(button => {
            button.addEventListener('click', () => {
                const motor = button.dataset.motor;
                if (motor && productConfig.motorTypes[motor]) {
                    currentState.selectedMotor = motor;

                    // Update button states
                    motorButtons.forEach(btn => btn.classList.remove('selected'));
                    button.classList.add('selected');

                    updatePricing();
                }
            });
        });
    }

    // Quantity Controls
    function setupQuantityControls() {
        const quantityInput = document.getElementById('quantity');
        const quantityButtons = document.querySelectorAll('.quantity-button');

        if (quantityInput) {
            quantityInput.addEventListener('change', (event) => {
                const newQuantity = Math.max(1, parseInt(event.target.value) || 1);
                currentState.quantity = newQuantity;
                event.target.value = newQuantity;
            });
        }

        // Setup quantity buttons if they exist
        quantityButtons.forEach(button => {
            button.addEventListener('click', (event) => {
                const isIncrement = button.textContent.includes('+');
                const delta = isIncrement ? 1 : -1;
                changeQuantity(delta);
            });
        });
    }

    // Global quantity change function (for onclick handlers)
    function changeQuantity(delta) {
        const newQuantity = Math.max(1, currentState.quantity + delta);
        currentState.quantity = newQuantity;

        const quantityInput = document.getElementById('quantity');
        if (quantityInput) {
            quantityInput.value = newQuantity;
        }
    }

    // Action Buttons
    function setupActionButtons() {
        const cartButton = document.querySelector('.cart-button');
        const purchaseButton = document.querySelector('.purchase-button');

        if (cartButton) {
            cartButton.addEventListener('click', addToCart);
        }

        if (purchaseButton) {
            purchaseButton.addEventListener('click', buyNow);
        }
    }

    function getCurrentProductConfig() {
        const modelConfig = productConfig.models[currentState.selectedModel];
        const motorConfig = productConfig.motorTypes[currentState.selectedMotor];

        const finalPrice = modelConfig.price + motorConfig.priceModifier;

        return {
            id: productConfig.productId || window.productId, // Lấy ID từ global variable
            name: `Máy Bơm Super Win ${currentState.selectedModel} | ${motorConfig.label}`,
            model: currentState.selectedModel,
            motorType: currentState.selectedMotor,
            power: modelConfig.power,
            quantity: currentState.quantity,
            price: finalPrice,
            image: productConfig.productImage || '/image/sp1.png', // Lấy image từ global variable
            attributes: {
                model: currentState.selectedModel,
                motorType: currentState.selectedMotor,
                power: modelConfig.power
            }
        };
    }

    function addToCart() {
        const product = getCurrentProductConfig();

        // Use the global cartManager if available
        if (typeof cartManager !== 'undefined' && cartManager) {
            cartManager.addItem(product);
        } else {
            // Fallback to local notification
            showNotification(`Đã thêm ${product.name} vào giỏ hàng!`, 'success');
            console.log('Added to cart:', product);
        }
    }

    function buyNow() {
        const product = getCurrentProductConfig();
        const quantity = parseInt(document.getElementById('quantity')?.value || 1);

        if (!product || !product.id) {
            showNotification('Vui lòng chọn sản phẩm trước khi mua', 'error');
            return;
        }

        // Tạo dữ liệu giỏ hàng tạm thời cho mua ngay
        const buyNowData = {
            items: [{
                id: product.id,
                name: product.name,
                price: product.price,
                quantity: quantity,
                image: product.image,
                attributes: product.attributes || {}
            }],
            total: product.price * quantity,
            itemCount: quantity
        };

        // Lưu vào sessionStorage để checkout page có thể đọc
        sessionStorage.setItem('buyNowData', JSON.stringify(buyNowData));

        // Chuyển đến trang checkout với tham số buy_now
        window.location.href = `/checkout?buy_now=1&product_id=${product.id}&quantity=${quantity}`;
    }

    // Tab System
    function setupTabs() {
        const tabButtons = document.querySelectorAll('.tab-switch');

        tabButtons.forEach(button => {
            button.addEventListener('click', (event) => {
                event.preventDefault();

                // Extract tab ID from onclick attribute or use a data attribute
                const onclickAttr = button.getAttribute('onclick');
                if (onclickAttr) {
                    const match = onclickAttr.match(/switchTab\('([^']+)'\)/);
                    if (match) {
                        switchTab(match[1]);
                    }
                }
            });
        });

        // Initialize first tab as active
        switchTab('specs');
    }

    // Global tab switch function (for onclick handlers)
    function switchTab(tabId) {
        const tabButtons = document.querySelectorAll('.tab-switch');
        const tabPanels = document.querySelectorAll('.tab-panel');

        // Update button states
        tabButtons.forEach(button => {
            const onclickAttr = button.getAttribute('onclick');
            const isActive = onclickAttr && onclickAttr.includes(`'${tabId}'`);
            button.classList.toggle('active', isActive);
        });

        // Update panel visibility
        tabPanels.forEach(panel => {
            panel.classList.toggle('active', panel.id === tabId);
        });
    }

    // Pricing Functions
    function updatePricing() {
        const modelConfig = productConfig.models[currentState.selectedModel];
        const motorConfig = productConfig.motorTypes[currentState.selectedMotor];

        if (!modelConfig || !motorConfig) return;

        const finalPrice = modelConfig.price + motorConfig.priceModifier;
        const originalPrice = modelConfig.originalPrice + motorConfig.priceModifier;

        // Update price displays
        const priceDisplay = document.querySelector('.active-price');
        const originalPriceDisplay = document.querySelector('.crossed-price');
        const savingsTag = document.querySelector('.savings-tag');

        if (priceDisplay) {
            priceDisplay.textContent = formatPrice(finalPrice);
        }

        if (originalPriceDisplay) {
            originalPriceDisplay.textContent = formatPrice(originalPrice);
        }

        // Update discount percentage
        if (savingsTag) {
            const discountPercent = Math.round((1 - finalPrice / originalPrice) * 100);
            savingsTag.textContent = `-${discountPercent}%`;
        }
    }

    function updateProductTitle() {
        const titleElement = document.querySelector('.product-heading');
        if (titleElement) {
            titleElement.textContent = `Máy Bơm Super Win ${currentState.selectedModel}`;
        }

        const statusLabel = document.querySelector('.status-label');
        if (statusLabel) {
            const modelConfig = productConfig.models[currentState.selectedModel];
            statusLabel.textContent = modelConfig.power;
        }
    }

    // Reviews Functions
    function generateReviewsContent() {
        const reviewsTab = document.getElementById('reviews');
        if (!reviewsTab) return;

        const reviewsHTML = `
            <!-- Review Summary Section -->
            <div class="review-summary">
                <div class="rating-overview">
                    <div class="rating-score">${reviewsData.summary.averageRating}</div>
                    <div class="rating-stars">${generateStars(reviewsData.summary.averageRating)}</div>
                    <div class="rating-count">${reviewsData.summary.totalReviews} đánh giá</div>
                </div>

                <div class="rating-breakdown">
                    ${generateRatingBreakdown()}
                </div>
            </div>

            <!-- Review Filters -->
            <div class="review-filters">
                <div class="filter-section">
                    <span class="filter-label">Lọc theo:</span>
                    <div class="filter-buttons">
                        <button class="filter-btn active" data-filter="all">Tất cả</button>
                        <button class="filter-btn" data-filter="5">5 sao (${reviewsData.summary.ratingBreakdown[5].count})</button>
                        <button class="filter-btn" data-filter="4">4 sao (${reviewsData.summary.ratingBreakdown[4].count})</button>
                        <button class="filter-btn" data-filter="3">3 sao (${reviewsData.summary.ratingBreakdown[3].count})</button>
                        <button class="filter-btn" data-filter="withImages">Có hình ảnh</button>
                        <button class="filter-btn" data-filter="verified">Đã xác thực</button>
                    </div>
                </div>
            </div>

            <!-- Reviews List -->
            <div class="reviews-list">
                ${generateReviewsList()}
            </div>

            <!-- Write Review Button -->
            <div class="write-review-section">
                <button class="write-review-btn" onclick="openWriteReviewModal()">
                    ✍️ Viết đánh giá
                </button>
            </div>
        `;

        reviewsTab.innerHTML = reviewsHTML;
        setupReviewsEventListeners();
    }

    function generateStars(rating, size = 'normal') {
        const fullStars = Math.floor(rating);
        const hasHalfStar = rating % 1 >= 0.5;
        const emptyStars = 5 - fullStars - (hasHalfStar ? 1 : 0);

        let stars = '';
        for (let i = 0; i < fullStars; i++) stars += '★';
        if (hasHalfStar) stars += '☆';
        for (let i = 0; i < emptyStars; i++) stars += '☆';

        return stars;
    }

    function generateRatingBreakdown() {
        let html = '';
        for (let rating = 5; rating >= 1; rating--) {
            const data = reviewsData.summary.ratingBreakdown[rating];
            html += `
                <div class="rating-row">
                    <span class="rating-stars-small">${rating}★</span>
                    <div class="rating-bar">
                        <div class="rating-fill star-${rating}" style="width: ${data.percentage}%"></div>
                    </div>
                    <span class="rating-percent">${data.percentage}%</span>
                </div>
            `;
        }
        return html;
    }

    function generateReviewsList() {
        const filteredReviews = filterReviews();

        if (filteredReviews.length === 0) {
            return '<div class="no-reviews">Không có đánh giá nào phù hợp với bộ lọc.</div>';
        }

        return filteredReviews.map(review => `
            <div class="review-item">
                <div class="review-header">
                    <div class="reviewer-info">
                        <span class="reviewer-name">${review.userName}</span>
                        ${review.verified ? '<span class="verified-badge">✓ Đã xác thực</span>' : ''}
                    </div>
                    <div class="review-meta">
                        <span class="review-rating">${generateStars(review.rating)}</span>
                        <span class="review-date">${formatDate(review.date)}</span>
                    </div>
                </div>

                <div class="review-product-info">
                    <span class="review-product">${review.productVariant}</span>
                </div>

                ${review.title ? `<div class="review-title">${review.title}</div>` : ''}

                <div class="review-text">${review.content}</div>

                ${review.images.length > 0 ? `
                    <div class="review-images">
                        ${review.images.map(img => `<div class="review-image-placeholder">📷 Hình ảnh</div>`).join('')}
                    </div>
                ` : ''}

                <div class="review-actions">
                    <button class="helpful-btn ${review.helpful > 0 ? 'has-votes' : ''}" onclick="markHelpful(${review.id})">
                        👍 Hữu ích (${review.helpful})
                    </button>
                    <button class="reply-btn" onclick="replyToReview(${review.id})">
                        💬 Trả lời
                    </button>
                </div>
            </div>
        `).join('');
    }

    function filterReviews() {
        let filtered = [...reviewsData.reviews];

        // Filter by rating
        if (reviewsData.filters.rating !== 'all') {
            if (reviewsData.filters.rating === 'withImages') {
                filtered = filtered.filter(review => review.images.length > 0);
            } else if (reviewsData.filters.rating === 'verified') {
                filtered = filtered.filter(review => review.verified);
            } else {
                const rating = parseInt(reviewsData.filters.rating);
                filtered = filtered.filter(review => review.rating === rating);
            }
        }

        return filtered;
    }

    function setupReviewsEventListeners() {
        // Filter buttons
        const filterButtons = document.querySelectorAll('.filter-btn');
        filterButtons.forEach(btn => {
            btn.addEventListener('click', function() {
                // Update filter state
                reviewsData.filters.rating = this.dataset.filter;

                // Update button states
                filterButtons.forEach(b => b.classList.remove('active'));
                this.classList.add('active');

                // Refresh reviews list
                updateReviewsList();
            });
        });
    }

    function updateReviewsList() {
        const reviewsList = document.querySelector('.reviews-list');
        if (reviewsList) {
            reviewsList.innerHTML = generateReviewsList();
        }
    }

    function formatDate(dateString) {
        const date = new Date(dateString);
        return date.toLocaleDateString('vi-VN', {
            year: 'numeric',
            month: 'long',
            day: 'numeric'
        });
    }

    function markHelpful(reviewId) {
        const review = reviewsData.reviews.find(r => r.id === reviewId);
        if (review) {
            review.helpful += 1;
            updateReviewsList();
            showNotification('Cảm ơn phản hồi của bạn!', 'success');
        }
    }

    function replyToReview(reviewId) {
        showNotification('Tính năng trả lời đánh giá sẽ sớm có!', 'info');
    }

    function openWriteReviewModal() {
        showNotification('Modal viết đánh giá sẽ sớm có!', 'info');
    }

    // Touch and Keyboard Support
    function setupKeyboardAndTouch() {
        // Keyboard navigation
        document.addEventListener('keydown', function(event) {
            if (event.target.tagName === 'INPUT') return;

            switch(event.key) {
                case 'ArrowLeft':
                    event.preventDefault();
                    changeImage(Math.max(0, currentState.selectedImage - 1));
                    break;
                case 'ArrowRight':
                    event.preventDefault();
                    changeImage(Math.min(imageGallery.images.length - 1, currentState.selectedImage + 1));
                    break;
                case '+':
                    event.preventDefault();
                    changeQuantity(1);
                    break;
                case '-':
                    event.preventDefault();
                    changeQuantity(-1);
                    break;
            }
        });

        // Touch/Swipe support
        let touchStartX = 0;
        let touchEndX = 0;

        document.addEventListener('touchstart', function(event) {
            if (event.target.closest('.image-gallery')) {
                touchStartX = event.changedTouches[0].screenX;
            }
        });

        document.addEventListener('touchend', function(event) {
            if (event.target.closest('.image-gallery')) {
                touchEndX = event.changedTouches[0].screenX;
                handleSwipe();
            }
        });

        function handleSwipe() {
            const swipeThreshold = 50;
            const difference = touchStartX - touchEndX;

            if (Math.abs(difference) > swipeThreshold) {
                if (difference > 0) {
                    changeImage(Math.min(imageGallery.images.length - 1, currentState.selectedImage + 1));
                } else {
                    changeImage(Math.max(0, currentState.selectedImage - 1));
                }
            }
        }
    }

    // Main initialization function
    function initializeApp() {
        setupImageGallery();
        setupProductOptions();
        setupQuantityControls();
        setupActionButtons();
        setupTabs();
        updatePricing();
        generateReviewsContent();
        setupKeyboardAndTouch();
        initializeMenuSystem(); // Initialize menu system
    }

    // Global functions for onclick handlers
    window.changeQuantity = changeQuantity;
    window.switchTab = switchTab;
    window.markHelpful = markHelpful;
    window.replyToReview = replyToReview;
    window.openWriteReviewModal = openWriteReviewModal;

    // Initialize when DOM is loaded
    document.addEventListener('DOMContentLoaded', function() {
        initializeApp();
    });

})();
