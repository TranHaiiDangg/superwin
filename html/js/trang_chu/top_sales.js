// Danh sách sản phẩm mẫu

// Tạo HTML cho sản phẩm
function createProductHTML(product, index) {
    const fullStars = Math.floor(product.rating);
    const halfStar = product.rating % 1 >= 0.5;
    const emptyStars = 5 - fullStars - (halfStar ? 1 : 0);
    
    let starsHTML = '';
    for (let i = 0; i < fullStars; i++) {
        starsHTML += '<i class="fas fa-star"></i>';
    }
    if (halfStar) {
        starsHTML += '<i class="fas fa-star-half-alt"></i>';
    }
    for (let i = 0; i < emptyStars; i++) {
        starsHTML += '<i class="far fa-star"></i>';
    }
    
    const isHot = index < 3; // 3 sản phẩm đầu có badge "HOT"
    
    return `
        <div class="product-card">
            <div class="product-inner bg-white rounded shadow-sm position-relative">
                ${isHot ? '<div class="badge-hot">HOT</div>' : ''}
                <img src="${product.image}" class="img-fluid rounded" alt="${product.name}" loading="lazy" />
                <div class="product-content">
                    <div class="rating">
                        <span class="stars">${starsHTML}</span>
                        <span class="count">(${product.reviews.toLocaleString()})</span>
                    </div>
                    <h6 class="text-truncate" title="${product.name}">${product.name}</h6>
                    <div class="fw-bold text-danger">${product.price}.000đ</div>
                </div>
            </div>
        </div>
    `;
}

// Render sản phẩm  

// Điều hướng slider




// Thêm tính năng kéo thả trên mobile
let isDown = false;
let startX;
let scrollLeft;

// Đợi element được tạo trước khi add event listener
setTimeout(() => {
    const slider = document.getElementById('topSlider');
    if (!slider) return;

    slider.addEventListener('mousedown', (e) => {
        isDown = true;
        slider.classList.add('active');
        startX = e.pageX - slider.offsetLeft;
        scrollLeft = slider.scrollLeft;
    });

    slider.addEventListener('mouseleave', () => {
        isDown = false;
        slider.classList.remove('active');
    });

    slider.addEventListener('mouseup', () => {
        isDown = false;
        slider.classList.remove('active');
    });

    slider.addEventListener('mousemove', (e) => {
        if (!isDown) return;
        e.preventDefault();
        const x = e.pageX - slider.offsetLeft;
        const walk = (x - startX) * 2;
        slider.scrollLeft = scrollLeft - walk;
    });

    // Touch events for mobile
    slider.addEventListener('touchstart', (e) => {
        startX = e.touches[0].pageX - slider.offsetLeft;
        scrollLeft = slider.scrollLeft;
    });

    slider.addEventListener('touchmove', (e) => {
        if (!startX) return;
        const x = e.touches[0].pageX - slider.offsetLeft;
        const walk = (x - startX) * 2;
        slider.scrollLeft = scrollLeft - walk;
    });

    slider.addEventListener('touchend', () => {
        startX = null;
    });
}, 200);