@extends('layouts.app')

@section('title', 'SuperWin - Máy bơm nước & Quạt công nghiệp')

@section('content')
<!-- Hero Section with Banner Slider -->
<section class="hero-section">
    <div class="container-fluid">
        <div class="banner-wrapper">
            <div class="banner-grid">
                <!-- Main Banner Slider -->
                <div class="main-banner">
                    <div class="slider-column">
                        <div class="main-slider">
                            <div class="slide-container">
                                <!-- Clone of last slide (slide 3) -->
                                <div class="slide">
                                    <img src="/image/baner3.png" alt="Banner 3" loading="lazy">
                                </div>

                                <!-- Real slides -->
                                <div class="slide">
                                    <img src="/image/baner1.png" alt="Banner 1" loading="lazy">
                                </div>
                                <div class="slide">
                                    <img src="/image/baner2.png" alt="Banner 2" loading="lazy">
                                </div>
                                <div class="slide">
                                    <img src="/image/baner3.png" alt="Banner 3" loading="lazy">
                                </div>

                                <!-- Clone of first slide (slide 1) -->
                                <div class="slide">
                                    <img src="/image/baner1.png" alt="Banner 1" loading="lazy">
                                </div>
                            </div>

                            <!-- Navigation -->
                            <button class="slider-nav prev" aria-label="Previous slide">
                                <i class="fas fa-chevron-left"></i>
                            </button>
                            <button class="slider-nav next" aria-label="Next slide">
                                <i class="fas fa-chevron-right"></i>
                            </button>

                            <!-- Pagination Dots -->
                            <div class="pagination-dots" role="tablist" aria-label="Slide navigation"></div>
                        </div>
                    </div>
                </div>

                <!-- Side Banner 1 -->
                <div class="side-banner-1">
                    <div class="image-box">
                        <img src="/image/baner1.png" alt="Promotion 1" loading="lazy">
                    </div>
                </div>

                <!-- Side Banner 2 -->
                <div class="side-banner-2">
                    <div class="image-box">
                        <img src="/image/baner2.png" alt="Promotion 2" loading="lazy">
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Container Menu -->
@if($mainCategories->count() > 0)
<div class="container-menu">
    @foreach($mainCategories as $category)
    <a href="{{ route('categories.show', $category->slug ?? $category->id) }}" class="menu-item">
        <div class="icon-container">
            @if($category->image)
            <img src="{{ asset($category->image) }}" alt="{{ $category->name }}" class="menu-img" />
            @else
            <img src="/image/bom.png" alt="{{ $category->name }}" class="menu-img" />
            @endif
        </div>
        <p>{{ $category->name }}</p>
    </a>
    @endforeach
</div>
@endif
<!-- Flash Deals Section -->
@if($saleProducts->count() > 0)
<div class="flash-deal-container">
    <div class="flash-deal-header">
        <div class="flash-deal-left">
            <h1 class="flash-deal-title">Flash Deal</h1>
            <div class="flash-deal-timer">
                <span class="timer-label">Kết thúc trong:</span>
                <div class="timer-display">
                    <div class="timer-unit" id="hours">00</div>
                    <div class="timer-unit" id="minutes">00</div>
                    <div class="timer-unit" id="seconds">00</div>
                </div>
            </div>
        </div>
        <a href="{{ route('deals') }}" class="flash-deal-view-all">Xem tất cả</a>
    </div>
    
    <button id="flashDealsPrev" class="flash-deal-nav prev">‹</button>
    <button id="flashDealsNext" class="flash-deal-nav next">›</button>

    <div class="flash-deal-grid" id="flashDealsTrack">
        @foreach($saleProducts->take(10) as $index => $product)
        <div class="flash-deal-card deal-item">
            <div class="flash-deal-discount">-{{ $product->discount_percentage }}%</div>
            
            <a href="{{ route('products.show', $product->slug ?? $product->id) }}">
                @if($product->baseImage)
                <img src="{{ $product->baseImage->url }}" alt="{{ $product->name }}" class="flash-deal-img">
                @else
                <img src="/image/sp1.png" alt="{{ $product->name }}" class="flash-deal-img">
                @endif
            </a>
            
            <div class="flash-deal-title-product">{{ $product->name }}</div>
            
            <div class="flash-deal-price">
                <span class="flash-deal-price-current">{{ number_format($product->price) }}đ</span>
                @if($product->original_price && $product->original_price > $product->price)
                <span class="flash-deal-price-original">{{ number_format($product->original_price) }}đ</span>
                @endif
            </div>
            
            @php
            $soldCount = $product->sold_count ?? rand(20, 80);
            $totalStock = $product->stock_quantity + $soldCount;
            $progress = $totalStock > 0 ? round(($soldCount / $totalStock) * 100) : 0;
            @endphp
            
            <div class="flash-deal-progress">
                <div class="flash-deal-progress-label">Đã bán {{ $soldCount }}/{{ $totalStock }}</div>
                <div class="flash-deal-progress-bar">
                    <div class="flash-deal-progress-fill" style="width: {{ $progress }}%"></div>
                </div>
            </div>
            <div class="flash-deal-sold">{{ $soldCount }} đã bán</div>
        </div>
        @endforeach
    </div>
</div>
@endif

<!-- Category Products Sections -->
@if(count($categoryProducts) > 0)
    @foreach($categoryProducts as $categoryData)
    <div class="normal-product-container">
        <div class="normal-product-header">
            <h1 class="normal-product-title">{{ $categoryData['category']->name }}</h1>
            <a href="{{ route('categories.show', $categoryData['category']->id) }}" class="normal-product-view-all">
                Xem tất cả
            </a>
        </div>
        
        <button class="normal-product-nav prev" data-category="{{ $categoryData['category']->id }}" data-direction="prev">‹</button>
        <button class="normal-product-nav next" data-category="{{ $categoryData['category']->id }}" data-direction="next">›</button>

        <div class="normal-product-grid" data-category-grid="{{ $categoryData['category']->id }}">
            @foreach($categoryData['products'] as $product)
            <div class="normal-product-card">
                <a href="{{ route('products.show', $product->slug ?? $product->id) }}">
                    @if($product->baseImage)
                    <img src="{{ $product->baseImage->url }}" alt="{{ $product->name }}" class="normal-product-img">
                    @else
                    <img src="/image/sp1.png" alt="{{ $product->name }}" class="normal-product-img">
                    @endif
                    
                    @if($product->isOnSale)
                    <span class="product-discount-badge">
                        -{{ $product->discount_percentage }}%
                    </span>
                    @endif
                </a>

                <div class="normal-product-title-product">{{ $product->name }}</div>
                
                <div class="normal-product-price">
                    @if($product->isOnSale)
                    <span class="normal-product-price-current">{{ number_format($product->sale_price) }}đ</span>
                   
                    @else
                    <span class="normal-product-price-current">{{ number_format($product->price) }}đ</span>
                    @endif
                </div>

                <div class="normal-product-sold">
                    @if($product->stock_quantity > 0)
                    <i class="fas fa-check-circle"></i> Còn hàng
                    @else
                    <span class="text-danger">
                        <i class="fas fa-times-circle"></i> Hết hàng
                    </span>
                    @endif
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endforeach
@else
    <div class="no-products-message">
        <p>Hiện tại chưa có sản phẩm nào.</p>
    </div>
@endif

<!-- Suggested Products Section -->
@if(isset($suggestedProducts) && $suggestedProducts->count() > 0)
<section class="py-5">
    <div class="container">
        <div class="suggested-section-wrapper">
            <div class="text-center mb-4">
                <h3 class="fw-bold text-primary mb-2">Gợi Ý Cho Bạn</h3>
                <p class="text-muted small mb-0">Sản phẩm được chọn lọc dành riêng cho bạn</p>
            </div>

            <div class="suggested-products-grid">
                @foreach($suggestedProducts->take(10) as $product)
                <div class="suggested-product-item">
                    <div class="suggested-product-card">
                        <div class="suggested-product-image">
                            <a href="{{ route('products.show', $product->slug ?? $product->id) }}">
                                @if($product->baseImage)
                                <img src="{{ $product->baseImage->url }}" alt="{{ $product->name }}" class="img-fluid">
                                @else
                                <img src="/image/sp1.png" alt="{{ $product->name }}" class="img-fluid">
                                @endif
                            </a>

                            @if($product->isOnSale)
                            <span class="suggested-discount-badge">
                                -{{ $product->discount_percentage }}%
                            </span>
                            @endif
                        </div>

                        <div class="suggested-product-content">
                            <h6 class="suggested-product-name">{{ $product->name }}</h6>

                            <div class="suggested-price-section">
                                @if($product->isOnSale)
                                <div class="suggested-sale-price">{{ number_format($product->price) }}đ</div>
                                <!-- <div class="suggested-original-price">{{ number_format($product->price) }}đ</div> -->
                                @else
                                <div class="suggested-regular-price">{{ number_format($product->price) }}đ</div>
                                @endif
                            </div>

                            <div class="suggested-rating">
                                @for($i = 1; $i <= 5; $i++)
                                    <i class="fas fa-star {{ $i <= ($product->average_rating ?? 4) ? 'text-warning' : 'text-muted' }}"></i>
                                    @endfor
                                    <span class="suggested-rating-count">({{ $product->reviews_count ?? rand(10, 100) }})</span>
                            </div>

                            <button class="suggested-buy-btn">
                                Xem Ngay
                            </button>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <div class="text-center mt-4">
                <button class="suggested-view-more-btn">
                    Xem thêm
                </button>
            </div>
        </div>
    </div>
</section>
@endif

<!-- Brands Section -->
@if($brands->count() > 0)
<section class="py-5 bg-light">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="fw-bold">Thương hiệu uy tín</h2>
            <p class="text-muted">Đối tác chiến lược của chúng tôi</p>
        </div>

        <div class="row g-4 align-items-center">
            @foreach($brands as $brand)
            <div class="col-md-3 col-6">
                <div class="text-center p-3">
                    <a href="{{ route('brands.show', $brand->id) }}" class="brand-link-home" title="{{ $brand->name }}">
                        @if($brand->image)
                        <img src="{{ asset($brand->image) }}" alt="{{ $brand->name }}" class="img-fluid brand-image-home" style="max-height: 60px;">
                        @else
                        <div class="bg-white p-3 rounded shadow-sm brand-placeholder-home">
                            <h6 class="mb-0">{{ $brand->name }}</h6>
                        </div>
                        @endif
                        <div class="brand-name-overlay">{{ $brand->name }}</div>
                    </a>
                </div>
            </div>
            @endforeach
        </div>

        <div class="text-center mt-4">
            <a href="{{ route('brands') }}" class="btn btn-outline-primary btn-lg">
                <i class="fas fa-building me-2"></i>Xem tất cả thương hiệu
            </a>
        </div>
    </div>
</section>
@endif

<!-- Features Section -->
<section class="py-5">
    <div class="container">
        <div class="row g-4">
            <div class="col-md-3 text-center">
                <div class="p-3">
                    <i class="fas fa-shipping-fast text-primary fa-3x mb-3"></i>
                    <h5>Giao hàng nhanh</h5>
                    <p class="text-muted">Giao hàng toàn quốc trong 24-48h</p>
                </div>
            </div>
            <div class="col-md-3 text-center">
                <div class="p-3">
                    <i class="fas fa-shield-alt text-primary fa-3x mb-3"></i>
                    <h5>Bảo hành chính hãng</h5>
                    <p class="text-muted">Bảo hành 12-24 tháng tùy sản phẩm</p>
                </div>
            </div>
            <div class="col-md-3 text-center">
                <div class="p-3">
                    <i class="fas fa-headset text-primary fa-3x mb-3"></i>
                    <h5>Hỗ trợ 24/7</h5>
                    <p class="text-muted">Tư vấn kỹ thuật miễn phí</p>
                </div>
            </div>
            <div class="col-md-3 text-center">
                <div class="p-3">
                    <i class="fas fa-undo text-primary fa-3x mb-3"></i>
                    <h5>Đổi trả dễ dàng</h5>
                    <p class="text-muted">30 ngày đổi trả miễn phí</p>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

<!-- Floating Contact Icons -->
<div class="floating-contact-icons">
    <!-- Zalo Icon -->
    <div class="floating-icon zalo-icon">
        <a href="https://zalo.me/0971687711" target="_blank" title="Chat qua Zalo">
            <i class="fas fa-comments"></i>
        </a>
        <div class="icon-tooltip">Chat Zalo</div>
    </div>

    <!-- Phone Icon -->
    <div class="floating-icon phone-icon">
        <a href="tel:02862697382" title="Gọi ngay">
            <i class="fas fa-phone-alt"></i>
        </a>
        <div class="icon-tooltip">Gọi ngay</div>
    </div>
</div>

@push('scripts')
<script src="/js/trang_chu/banner_slider.js"></script>
<script src="/js/trang_chu/flass_deal.js"></script>
<script>
    // Banner Slider Functionality
    document.addEventListener('DOMContentLoaded', function() {
        // Flash Deal Countdown Timer
        function startCountdown() {
            const hoursEl = document.getElementById('hours');
            const minutesEl = document.getElementById('minutes');
            const secondsEl = document.getElementById('seconds');

            if (!hoursEl || !minutesEl || !secondsEl) return;

            // Set countdown to 6 hours from now (you can modify this)
            let endTime = new Date().getTime() + (6 * 60 * 60 * 1000);

            function updateCountdown() {
                const now = new Date().getTime();
                const distance = endTime - now;

                if (distance < 0) {
                    // Reset countdown to 6 hours
                    endTime = new Date().getTime() + (6 * 60 * 60 * 1000);
                    return;
                }

                const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                const seconds = Math.floor((distance % (1000 * 60)) / 1000);

                hoursEl.textContent = hours.toString().padStart(2, '0');
                minutesEl.textContent = minutes.toString().padStart(2, '0');
                secondsEl.textContent = seconds.toString().padStart(2, '0');
            }

            updateCountdown();
            setInterval(updateCountdown, 1000);
        }

        startCountdown();
        const slideContainer = document.querySelector('.slide-container');
        const slides = document.querySelectorAll('.slide');
        const prevBtn = document.querySelector('.slider-nav.prev');
        const nextBtn = document.querySelector('.slider-nav.next');
        const paginationDots = document.querySelector('.pagination-dots');

        if (!slideContainer || slides.length === 0) return;

        let currentSlide = 1; // Start from first real slide (index 1)
        const totalSlides = slides.length - 2; // Exclude clone slides
        let autoplayInterval;

        // Create pagination dots
        for (let i = 0; i < totalSlides; i++) {
            const dot = document.createElement('div');
            dot.className = 'dot';
            dot.setAttribute('data-slide', i + 1);
            if (i === 0) dot.classList.add('active');
            dot.addEventListener('click', () => goToSlide(i + 1));
            paginationDots.appendChild(dot);
        }

        // Initialize slider
        updateSlider();
        startAutoplay();

        // Navigation buttons
        if (prevBtn) {
            prevBtn.addEventListener('click', () => {
                currentSlide = currentSlide <= 1 ? totalSlides : currentSlide - 1;
                updateSlider();
                resetAutoplay();
            });
        }

        if (nextBtn) {
            nextBtn.addEventListener('click', () => {
                currentSlide = currentSlide >= totalSlides ? 1 : currentSlide + 1;
                updateSlider();
                resetAutoplay();
            });
        }

        // Touch/swipe support for mobile
        let startX = 0;
        let endX = 0;

        slideContainer.addEventListener('touchstart', (e) => {
            startX = e.touches[0].clientX;
        });

        slideContainer.addEventListener('touchend', (e) => {
            endX = e.changedTouches[0].clientX;
            handleSwipe();
        });

        function handleSwipe() {
            const swipeThreshold = 50;
            const diff = startX - endX;

            if (Math.abs(diff) > swipeThreshold) {
                if (diff > 0) {
                    // Swipe left - next slide
                    currentSlide = currentSlide >= totalSlides ? 1 : currentSlide + 1;
                } else {
                    // Swipe right - previous slide
                    currentSlide = currentSlide <= 1 ? totalSlides : currentSlide - 1;
                }
                updateSlider();
                resetAutoplay();
            }
        }

        function updateSlider() {
            const translateX = -currentSlide * 100;
            slideContainer.style.transform = `translateX(${translateX}%)`;

            // Update pagination dots
            document.querySelectorAll('.dot').forEach((dot, index) => {
                dot.classList.toggle('active', index === currentSlide - 1);
            });

            // Handle infinite loop
            if (currentSlide === 0) {
                setTimeout(() => {
                    slideContainer.style.transition = 'none';
                    currentSlide = totalSlides;
                    slideContainer.style.transform = `translateX(-${currentSlide * 100}%)`;
                    setTimeout(() => {
                        slideContainer.style.transition = 'transform 0.5s ease-in-out';
                    }, 10);
                }, 500);
            } else if (currentSlide === totalSlides + 1) {
                setTimeout(() => {
                    slideContainer.style.transition = 'none';
                    currentSlide = 1;
                    slideContainer.style.transform = `translateX(-${currentSlide * 100}%)`;
                    setTimeout(() => {
                        slideContainer.style.transition = 'transform 0.5s ease-in-out';
                    }, 10);
                }, 500);
            }
        }

        function goToSlide(slideNumber) {
            currentSlide = slideNumber;
            updateSlider();
            resetAutoplay();
        }

        function startAutoplay() {
            autoplayInterval = setInterval(() => {
                currentSlide = currentSlide >= totalSlides ? 1 : currentSlide + 1;
                updateSlider();
            }, 5000); // Change slide every 5 seconds
        }

        function resetAutoplay() {
            clearInterval(autoplayInterval);
            startAutoplay();
        }

        // Pause autoplay on hover
        slideContainer.addEventListener('mouseenter', () => {
            clearInterval(autoplayInterval);
        });

        slideContainer.addEventListener('mouseleave', () => {
            startAutoplay();
        });

        // Flash Deals Slider Functionality
        const flashDealsTrack = document.getElementById('flashDealsTrack');
        const flashDealsPrev = document.getElementById('flashDealsPrev');
        const flashDealsNext = document.getElementById('flashDealsNext');
        const flashDealsItems = document.querySelectorAll('.deal-item');

        if (flashDealsTrack && flashDealsItems.length > 0) {
            let currentIndex = 0;
            const itemsPerView = window.innerWidth <= 768 ? 1 : (window.innerWidth <= 1024 ? 2 : 4);
            const maxIndex = Math.max(0, flashDealsItems.length - itemsPerView);

            function updateFlashDealsSlider() {
                const translateX = -currentIndex * (250 + 15); // item width + gap
                flashDealsTrack.style.transform = `translateX(${translateX}px)`;

                // Update button states
                flashDealsPrev.disabled = currentIndex === 0;
                flashDealsNext.disabled = currentIndex >= maxIndex;
            }

            function nextFlashDeal() {
                if (currentIndex < maxIndex) {
                    currentIndex++;
                    updateFlashDealsSlider();
                }
            }

            function prevFlashDeal() {
                if (currentIndex > 0) {
                    currentIndex--;
                    updateFlashDealsSlider();
                }
            }

            // Event listeners
            flashDealsNext.addEventListener('click', nextFlashDeal);
            flashDealsPrev.addEventListener('click', prevFlashDeal);

            // Initialize
            updateFlashDealsSlider();

            // Handle window resize
            window.addEventListener('resize', function() {
                const newItemsPerView = window.innerWidth <= 768 ? 1 : (window.innerWidth <= 1024 ? 2 : 4);
                const newMaxIndex = Math.max(0, flashDealsItems.length - newItemsPerView);

                if (currentIndex > newMaxIndex) {
                    currentIndex = newMaxIndex;
                }
                updateFlashDealsSlider();
            });

            // Auto-scroll for flash deals (optional)
            let flashDealsAutoplay = setInterval(function() {
                if (currentIndex >= maxIndex) {
                    currentIndex = 0;
                } else {
                    currentIndex++;
                }
                updateFlashDealsSlider();
            }, 4000);

            // Pause autoplay on hover
            flashDealsTrack.addEventListener('mouseenter', function() {
                clearInterval(flashDealsAutoplay);
            });

            flashDealsTrack.addEventListener('mouseleave', function() {
                flashDealsAutoplay = setInterval(function() {
                    if (currentIndex >= maxIndex) {
                        currentIndex = 0;
                    } else {
                        currentIndex++;
                    }
                    updateFlashDealsSlider();
                }, 4000);
            });
        }

        // Category Products Sliders Functionality
        const categorySliders = document.querySelectorAll('.category-products-slider');

        categorySliders.forEach(slider => {
            const track = slider.querySelector('.category-slider-track');
            const items = slider.querySelectorAll('.category-product-item');
            const prevBtn = slider.querySelector('.category-slider-nav.prev');
            const nextBtn = slider.querySelector('.category-slider-nav.next');

            if (!track || !items.length || !prevBtn || !nextBtn) return;

            let currentIndex = 0;
            let itemsPerView = 4; // Mặc định 4 sản phẩm trên desktop

            function getItemsPerView() {
                if (window.innerWidth <= 576) return 1; // Mobile
                if (window.innerWidth <= 768) return 2; // Small tablet
                if (window.innerWidth <= 1024) return 3; // Tablet
                return 4; // Desktop: 4 sản phẩm
            }

            itemsPerView = getItemsPerView();
            let maxIndex = Math.max(0, items.length - itemsPerView);

            function updateCategorySlider() {
                // Cập nhật itemsPerView và maxIndex
                itemsPerView = getItemsPerView();
                maxIndex = Math.max(0, items.length - itemsPerView);

                // Đảm bảo currentIndex không vượt quá maxIndex
                if (currentIndex > maxIndex) currentIndex = maxIndex;

                // Sử dụng transform với % thay vì px để responsive tốt hơn
                const translatePercent = -(currentIndex * (100 / itemsPerView));
                track.style.transform = `translateX(${translatePercent}%)`;

                // Update button states
                prevBtn.disabled = currentIndex === 0;
                nextBtn.disabled = currentIndex >= maxIndex;
            }

            function nextCategory() {
                if (currentIndex < maxIndex) {
                    currentIndex++;
                    updateCategorySlider();
                }
            }

            function prevCategory() {
                if (currentIndex > 0) {
                    currentIndex--;
                    updateCategorySlider();
                }
            }

            // Event listeners
            nextBtn.addEventListener('click', nextCategory);
            prevBtn.addEventListener('click', prevCategory);

            // Initialize
            updateCategorySlider();

            // Handle window resize
            window.addEventListener('resize', function() {
                updateCategorySlider(); // Function này đã tự cập nhật itemsPerView và maxIndex
            });

            // Touch/swipe support for mobile
            let startX = 0;
            let endX = 0;

            track.addEventListener('touchstart', (e) => {
                startX = e.touches[0].clientX;
            });

            track.addEventListener('touchend', (e) => {
                endX = e.changedTouches[0].clientX;
                handleCategorySwipe();
            });

            function handleCategorySwipe() {
                const swipeThreshold = 50;
                const diff = startX - endX;

                if (Math.abs(diff) > swipeThreshold) {
                    if (diff > 0) {
                        // Swipe left - next slide
                        nextCategory();
                    } else {
                        // Swipe right - previous slide
                        prevCategory();
                    }
                }
            }
        });
    });
</script>
@endpush

@push('styles')
<link rel="stylesheet" href="/css/trang_chu/banner_silder.css">
<link rel="stylesheet" href="/css/trang_chu/container-menu.css">

<style>
    /*flash deal*/
    #flashDealsNext,
    #flashDealsPrev {
        background-color: #e74c3c;
    }

    #flashDealsNext i,
    #flashDealsPrev i {
        color: white;
    }
    .bg-gradient-primary {
        background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
    }

    .hover-lift {
        transition: transform 0.3s ease;
    }

    .hover-lift:hover {
        transform: translateY(-5px);
    }

    .product-card {
        transition: all 0.3s ease;
    }

    .product-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1) !important;
    }

    .badge {
        font-size: 0.75rem;
    }



   /* Container-menu*/
   .container-menu {
                width: 1280px;
                margin: 0 auto;
                display: flex;
                gap: 60px;
                padding: 15px 0 10px 0  ;
                background-color: #fff;
                justify-content: center;
            }
    
            .menu-item {
                display: flex;
                flex-direction: column;
                align-items: center;
                text-align: center;
                width: 120px;
                text-decoration: none;
                color: inherit;
                white-space: nowrap;
                transition: transform 0.3s ease;
            }
    
            .menu-item:hover {
                text-decoration: none;
                color: inherit;
                transform: scale(1.1);
            }
    
            .menu-item:hover .icon-container {
                transform: scale(1.1);
            }
    
            .icon-container {
                background: none;
                border-radius: 0;
                display: flex;
                align-items: center;
                justify-content: center;
                margin-bottom: 8px;
                padding: 0;
                box-shadow: none;
                transition: none;
            }
    
            .menu-img {
                width: auto;
                height: 50px;
                object-fit: contain;
                border-radius: 50%;
                display: block;
            }
    
            /* Icon colors */
            .menu-item:nth-child(1) .menu-icon {
                color: #ff6b6b;
            }
    
            .menu-item:nth-child(2) .menu-icon {
                color: #4ecdc4;
            }
    
            .menu-item:nth-child(3) .menu-icon {
                color: #45b7d1;
            }
    
            .menu-item:nth-child(4) .menu-icon {
                color: #96ceb4;
            }
    
            .menu-item:nth-child(5) .menu-icon {
                color: #ff9f1c;
            }
    
            .menu-item:nth-child(6) .menu-icon {
                color: #e76f51;
            }
    
            /* Hover effects */
            .menu-item:hover .icon-container {
                background: none;
            }
    
            .menu-item:hover .menu-icon {
                transform: scale(1.1);
            }
    
            .menu-item p {
                font-size: 13px;
                color: #333;
                margin: 0;
            }
    
            /* Responsive - Tablet (768px - 1024px) */
            @media (max-width: 1024px) and (min-width: 768px) {
                .container-menu {
                    width: 100%;
                    max-width: 100%;
                    gap: 15px;
                    padding: 20px 16px;
                    justify-content: center;
                    flex-wrap: nowrap;
                }
                
                .menu-item {
                    width: 100px;
                    min-width: 100px;
                    flex: 0 0 auto;
                }
                
                .icon-container {
                    width: 50px;
                    height: 50px;
                }   
                
                .menu-icon {
                    font-size: 20px;
                }
                
                .menu-item p {
                    font-size: 11px;
                    line-height: 1.2;
                }
            }
    
            /* Responsive - Mobile (ẩn menu trên mobile) */
            @media (max-width: 767px) {
                .container-menu {
                    display: flex;
                    flex-wrap: wrap;
                    justify-content: center;
                    width: 370px;
                    gap: 0;
                    padding: 0;
                    row-gap: 10px;
                }
                .container-menu .menu-item {
                    width: 25%;
                    flex: 0 0 25%;
                    box-sizing: border-box;
                    margin-bottom: 0;
                    padding: 0;
                    display: flex;
                    flex-direction: column;
                    align-items: center;
                }
            }
            @media (max-width: 767px) {
                .container-menu {
                    display: flex;
                    flex-wrap: wrap;
                    justify-content: center;
                    width: 100%;
                    padding: 0;
                    row-gap: 10px;
                }
            
                .container-menu .menu-item {
                    width: 25%; /* Mặc định 4 items mỗi hàng */
                    flex: 0 0 25%;
                    box-sizing: border-box;
                    margin-bottom: 0;
                    padding: 0;
                    display: flex;
                    flex-direction: column;
                    align-items: center;
                }
            }
            
            /* iPhone 5 (<=320px): chỉ hiển thị 2 item mỗi hàng */
            @media (max-width: 320px) {
                .container-menu .menu-item {
                    width: 50%;
                    flex: 0 0 50%;
                }
            }

    /* Flash Deals Section Styles */
    /* ===== FLASH DEAL STYLES ===== */
.flash-deal-container {
    max-width: 1280px;
    margin: 25px auto;
    background: #FFE5B4; /* Cam nhạt */
    border-radius: 12px;
    padding: 20px;
    position: relative;
    overflow: hidden;
}

.flash-deal-container.active {
    display: block; /* Hiện khi có sự kiện */
}

.flash-deal-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 20px;
    flex-wrap: nowrap;
    gap: 10px;
}

.flash-deal-left {
    display: flex;
    align-items: center;
    gap: 15px;
    flex-wrap: nowrap;
    flex: 1;
}

.flash-deal-title {
    font-size: 20px;
    color: #fff;
    font-weight: 700;
    background: #FF6B35;
    padding: 8px 16px;
    border-radius: 6px;
    display: flex;
    align-items: center;
    gap: 8px;
    white-space: nowrap;
    height: 40px;
    box-sizing: border-box;
}

.flash-deal-timer {
    display: flex;
    align-items: center;
    gap: 8px;
    padding: 8px 12px;
    border-radius: 6px;
    color: #fff;
    height: 40px;
    box-sizing: border-box;
}

.timer-label {
    font-size: 12px;
    color: #000;
}

.timer-display {
    display: flex;
    gap: 4px;
}

.timer-unit {
    background: #FF6B35;
    color: #fff;
    padding: 4px 8px;
    border-radius: 4px;
    font-weight: 700;
    font-size: 14px;
    min-width: 30px;
    text-align: center;
}

.flash-deal-view-all {
    background: #FF6B35;
    color: #fff;
    padding: 10px 20px;
    border: none;
    border-radius: 25px;
    font-size: 14px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    text-decoration: none;
    display: inline-block;
    box-shadow: 0 2px 8px rgba(255, 107, 53, 0.3);
    white-space: nowrap;
    flex-shrink: 0;
}

.flash-deal-view-all:hover {
    background: #E55A2B;
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(255, 107, 53, 0.4);
}

.flash-deal-nav {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    background: rgba(255, 107, 53, 0.9);
    color: white;
    border: none;
    width: 40px;
    height: 40px;
    border-radius: 50%;
    font-size: 18px;
    cursor: pointer;
    z-index: 10;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    justify-content: center;
}

.flash-deal-nav:hover {
    background: #FF6B35;
    transform: translateY(-50%) scale(1.1);
}

.flash-deal-nav.prev {
    left: 10px;
}

.flash-deal-nav.next {
    right: 10px;
}

.flash-deal-grid {
    display: flex;
    gap: 15px;
    padding: 10px 0;
    scroll-behavior: smooth;
    scrollbar-width: none;
    -ms-overflow-style: none;
    justify-content: space-between;
    transition: transform 0.3s ease;
}

.flash-deal-grid::-webkit-scrollbar {
    display: none;
}

.flash-deal-card {
    background: #fff;
    border-radius: 8px;
    padding: 15px;
    text-align: center;
    min-width: 250px;
    flex: 0 0 250px;
    position: relative;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    transition: transform 0.3s ease;
}

.flash-deal-nav:disabled {
    opacity: 0.5;
    cursor: not-allowed;
}

.flash-deal-card:hover {
    transform: translateY(-2px);
}

.flash-deal-discount {
    position: absolute;
    top: 10px;
    left: 10px;
    background: #FF6B35;
    color: white;
    padding: 4px 8px;
    border-radius: 12px;
    font-size: 12px;
    font-weight: 700;
}

.flash-deal-img {
    width: 100%;
    height: 260px;
    object-fit: contain;
    margin-bottom: 10px;
    border-radius: 6px;
    padding: 10px;
}

.flash-deal-title-product {
    font-size: 14px;
    color: #333;
    margin-bottom: 10px;
    font-weight: 600;
    line-height: 1.4;
    height: 40px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.flash-deal-price {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    margin-bottom: 10px;
}

.flash-deal-price-current {
    font-size: 16px;
    color: #FF6B35;
    font-weight: 700;
}

.flash-deal-price-original {
    font-size: 12px;
    color: #999;
    text-decoration: line-through;
}

.flash-deal-progress {
    margin-bottom: 10px;
}

.flash-deal-progress-label {
    font-size: 11px;
    color: #666;
    margin-bottom: 4px;
}

.flash-deal-progress-bar {
    width: 100%;
    height: 4px;
    background: #eee;
    border-radius: 2px;
    overflow: hidden;
}

.flash-deal-progress-fill {
    height: 100%;
    background: #FF6B35;
    border-radius: 2px;
    transition: width 0.3s ease;
}

.flash-deal-sold {
    font-size: 11px;
    color: #FF6B35;
    font-weight: 600;
    background: #FFF3E0;
    padding: 4px 8px;
    border-radius: 12px;
    display: inline-block;
}

/* ===== NORMAL PRODUCTS STYLES ===== */
.normal-product-container {
    max-width: 1280px;
    margin: 25px auto;
    background: #ffffff; /* Trắng */
    border-radius: 12px;
    padding: 20px;
    position: relative;
    overflow: hidden;
    box-shadow: 0 2px 8px rgba(0,0,0,0.05);
}

.normal-product-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 20px;
    flex-wrap: nowrap;
    gap: 10px;
}

.normal-product-title {
    font-size: 20px;
    color: #fff;
    font-weight: 700;
    background: #4facfe; /* Xanh dương */
    padding: 8px 16px;
    border-radius: 6px;
    display: flex;
    align-items: center;
    gap: 8px;
    white-space: nowrap;
    height: 40px;
    box-sizing: border-box;
}

.normal-product-view-all {
    background: #4facfe;
    color: #fff;
    padding: 10px 20px;
    border: none;
    border-radius: 25px;
    font-size: 14px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    text-decoration: none;
    display: inline-block;
    box-shadow: 0 2px 8px rgba(79, 172, 254, 0.3);
    white-space: nowrap;
    flex-shrink: 0;
}

.normal-product-view-all:hover {
    background: #3a8bdb;
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(79, 172, 254, 0.4);
}

.normal-product-nav {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    background: rgba(79, 172, 254, 0.9);
    color: white;
    border: none;
    width: 40px;
    height: 40px;
    border-radius: 50%;
    font-size: 18px;
    cursor: pointer;
    z-index: 10;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    justify-content: center;
}

.normal-product-nav:hover {
    background: #4facfe;
    transform: translateY(-50%) scale(1.1);
}

.normal-product-nav.prev {
    left: 10px;
}

.normal-product-nav.next {
    right: 10px;
}

.normal-product-grid {
    display: flex;
    gap: 15px;
    overflow-x: auto;
    padding: 10px 0;
    scroll-behavior: smooth;
    scrollbar-width: none;
    -ms-overflow-style: none;
    justify-content: space-between;
}

.normal-product-grid::-webkit-scrollbar {
    display: none;
}

.normal-product-card {
    background: #fff;
    border: 1px solid #e1e8ed;
    border-radius: 8px;
    padding: 15px;
    text-align: center;
    min-width: 200px;
    position: relative;
    box-shadow: 0 2px 8px rgba(0,0,0,0.05);
    transition: all 0.3s ease;
}

.product-discount-badge{
    position: absolute;
    top: 10px;
    left: 10px;
    background: #FF6B35;
    color: white;
    padding: 4px 8px;
    border-radius: 12px;
    font-size: 12px;
    font-weight: 700;
}

.normal-product-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(79, 172, 254, 0.1);
    border-color: #4facfe;
}

.normal-product-img {
    width: 100%;
    height: 120px;
    object-fit: contain;
    margin-bottom: 10px;
    border-radius: 6px;
    background: #f8f9fa;
    padding: 10px;
}

.normal-product-title-product {
    font-size: 14px;
    color: #333;
    margin-bottom: 10px;
    font-weight: 600;
    line-height: 1.4;
    height: 40px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.normal-product-price {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    margin-bottom: 10px;
}

.normal-product-price-current {
    font-size: 16px;
    color: #4facfe;
    font-weight: 700;
}

.normal-product-sold {
    font-size: 11px;
    color: #4facfe;
    font-weight: 600;
    background: #e3f2fd;
    padding: 4px 8px;
    border-radius: 12px;
    display: inline-block;
}

/* ===== RESPONSIVE CHO FLASH DEAL ===== */
@media (max-width: 896px) {
    .flash-deal-container {
        padding: 15px;
        margin: 25px 5px;
    }

    .flash-deal-header {
        flex-wrap: nowrap;
        gap: 8px;
    }

    .flash-deal-left {
        gap: 8px;
        flex: 1;
        min-width: 0;
    }

    .flash-deal-title {
        font-size: 16px;
        padding: 6px 10px;
        flex-shrink: 0;
        height: 32px;
    }

    .flash-deal-timer {
        padding: 6px 8px;
        flex-shrink: 0;
        height: 32px;
    }

    .timer-label {
        display: none;
    }

    .timer-unit {
        font-size: 12px;
        padding: 3px 6px;
        min-width: 25px;
    }

    .flash-deal-view-all {
        padding: 6px 12px;
        font-size: 12px;
        flex-shrink: 0;
    }

    .flash-deal-nav {
        display: none;
    }

    .flash-deal-card {
        width: calc(20% - 10px);
        min-width: 160px;
        padding: 12px;
    }

    .flash-deal-img {
        height: 135px;
    }

    .flash-deal-title-product {
        font-size: 12px;
        height: 32px;
    }

    .flash-deal-price-current {
        font-size: 14px;
    }
}

/* ===== RESPONSIVE CHO NORMAL PRODUCTS ===== */
@media (max-width: 896px) {
    .normal-product-container {
        padding: 15px;
        margin: 25px 5px;
    }

    .normal-product-header {
        flex-wrap: nowrap;
        gap: 8px;
    }

    .normal-product-title {
        font-size: 16px;
        padding: 6px 10px;
        flex-shrink: 0;
        height: 32px;
    }

    .normal-product-view-all {
        padding: 6px 12px;
        font-size: 12px;
        flex-shrink: 0;
    }

    .normal-product-nav {
        display: none;
    }

    .normal-product-card {
        width: calc(20% - 10px);
        min-width: 160px;
        padding: 12px;
    }

    .normal-product-img {
        height: 100px;
    }

    .normal-product-title-product {
        font-size: 12px;
        height: 32px;
    }

    .normal-product-price-current {
        font-size: 14px;
    }
}

/* iPhone 5/SE (320px) */
@media (max-width: 375px) {
    .flash-deal-container, .normal-product-container {
        padding: 10px;
        margin: 2px;
    }

    .flash-deal-header, .normal-product-header {
        gap: 6px;
    }

    .flash-deal-left {
        gap: 6px;
        flex: 1;
        min-width: 0;
    }

    .flash-deal-title, .normal-product-title {
        font-size: 14px;
        padding: 4px 8px;
        flex-shrink: 0;
        height: 28px;
    }

    .flash-deal-timer {
        padding: 4px 6px;
        flex-shrink: 0;
        height: 28px;
    }

    .timer-unit {
        font-size: 10px;
        padding: 2px 4px;
        min-width: 20px;
    }

    .flash-deal-view-all, .normal-product-view-all {
        padding: 4px 8px;
        font-size: 10px;
        flex-shrink: 0;
    }

    .flash-deal-card, .normal-product-card {
        width: calc(60% - 10px);
        min-width: 140px;
        padding: 10px;
    }

    .flash-deal-img, .normal-product-img {
        height: 150px;
    }

    .flash-deal-title-product, .normal-product-title-product {
        font-size: 11px;
        height: 28px;
    }

    .flash-deal-price-current, .normal-product-price-current {
        font-size: 13px;
    }

    .flash-deal-price-original {
        font-size: 10px;
    }
}

/* Tablet responsive */
@media (min-width: 768px) and (max-width: 1024px) {
    .flash-deal-nav, .normal-product-nav {
        display: none;
    }
    
    .flash-deal-container, .normal-product-container {
        padding: 20px;
    }
    
    .flash-deal-card, .normal-product-card {
        min-width: 220px;
    }
}   

    /* Category Products Sections Styles */
    .category-section-wrapper {
        background: white;
        border-radius: 16px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        padding: 30px;
        margin-bottom: 30px;
        border: 1px solid rgba(0, 0, 0, 0.05);
        transition: all 0.3s ease;
    }

    .category-section-wrapper:hover {
        box-shadow: 0 8px 30px rgba(0, 0, 0, 0.12);
        transform: translateY(-2px);
    }

    .category-products-slider {
        position: relative;
        display: flex;
        align-items: center;
        gap: 15px;
    }

    .category-slider-container {
        flex: 1;
        overflow: hidden;
        border-radius: 12px;
    }

    .category-slider-track {
        display: flex;
        gap: 20px;
        transition: transform 0.3s ease;
        padding: 5px 0;
    }

    .category-product-item {
        min-width: calc(25% - 15px);
        /* 4 sản phẩm mỗi hàng với gap 20px */
        flex-shrink: 0;
        width: calc(25% - 15px);
    }

    .category-product-card {
        background: white;
        border-radius: 12px;
        box-shadow: 0 2px 12px rgba(0, 0, 0, 0.08);
        overflow: hidden;
        transition: all 0.3s ease;
        height: 100%;
        border: 1px solid #f0f0f0;
    }

    .category-product-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.12);
        border: 2px solid #4facfe;
    }

    .category-product-image {
        position: relative;
        height: 180px;
        overflow: hidden;
        background: #f8f9fa;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .category-product-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.3s ease;
    }

    .category-product-card:hover .category-product-image img {
        transform: scale(1.05);
    }

    .category-discount-badge {
        position: absolute;
        top: 8px;
        right: 8px;
        background: linear-gradient(135deg, #ff6b35, #f7931e);
        color: white;
        padding: 4px 8px;
        border-radius: 12px;
        font-size: 0.75rem;
        font-weight: 600;
    }

    .category-product-content {
        padding: 15px;
    }

    .category-product-name {
        font-size: 0.9rem;
        font-weight: 600;
        margin-bottom: 10px;
        line-height: 1.3;
        color: #2c3e50;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        line-clamp: 2;
        overflow: hidden;
        height: 2.34em;
        text-overflow: ellipsis;
        word-wrap: break-word;
        word-break: break-word;
    }

    .category-price-section {
        margin-bottom: 10px;
    }

    .category-sale-price {
        font-size: 1.1rem;
        font-weight: 700;
        color: #e74c3c;
        margin-bottom: 2px;
    }

    .category-original-price {
        font-size: 0.85rem;
        color: #95a5a6;
        text-decoration: line-through;
    }

    .category-regular-price {
        font-size: 1.1rem;
        font-weight: 700;
        color: #3498db;
    }


    .normal-product-sold {
    font-size: 11px;
    color: #4facfe;
    font-weight: 600;
    background: #e3f2fd;
    padding: 4px 8px;
    border-radius: 12px;
    display: inline-block;
}

    .category-stock-info {
        font-size: 0.8rem;
    }

    .category-slider-nav {
        background: rgba(79, 172, 254, 0.9);
        border: 1px solid #e0e6ed;
        border-radius: 50%;
        width: 45px;
        height: 45px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.3s ease;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        color: #6c757d;
        font-size: 1rem;
        z-index: 2;
        flex-shrink: 0;
    }

    .category-slider-nav:hover {
        background: #3498db;
        color: white;
        border-color: #3498db;
        box-shadow: 0 4px 15px rgba(52, 152, 219, 0.3);
        transform: scale(1.05);
    }

    .category-slider-nav:disabled {
        opacity: 0.5;
        cursor: not-allowed;
        transform: none;
        background: #f8f9fa;
        color: #ced4da;
    }

    .category-slider-nav:disabled:hover {
        background: #f8f9fa;
        color: #ced4da;
        border-color: #e0e6ed;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    }

    /* Responsive for Category Sections */
    @media (max-width: 1024px) {
        .category-product-item {
            min-width: calc(33.333% - 14px);
            /* 3 sản phẩm trên tablet */
            width: calc(33.333% - 14px);
        }
    }

    @media (max-width: 768px) {
        .category-section-wrapper {
            padding: 20px;
            margin-bottom: 20px;
            border-radius: 12px;
        }

        .category-product-item {
            min-width: calc(50% - 10px);
            /* 2 sản phẩm trên mobile nhỏ */
            width: calc(50% - 10px);
        }

        .category-product-image {
            height: 150px;
        }

        .category-product-name {
            font-size: 0.8rem;
            height: 2.08em;
        }

        .category-sale-price,
        .category-regular-price {
            font-size: 1rem;
        }

        .category-slider-nav {
            width: 40px;
            height: 40px;
            font-size: 0.9rem;
        }
    }

    @media (max-width: 576px) {
        .category-section-wrapper {
            padding: 15px;
            margin-bottom: 15px;
            border-radius: 8px;
        }

        .category-products-slider {
            gap: 10px;
        }

        .category-product-item {
            min-width: 100%;
            /* 1 sản phẩm trên mobile rất nhỏ */
            width: 100%;
        }

        .category-product-image {
            height: 130px;
        }

        .category-product-content {
            padding: 12px;
        }

        .category-slider-nav {
            width: 35px;
            height: 35px;
            font-size: 0.8rem;
        }
    }

    /* Suggested Products Section Styles */
    .suggested-section-wrapper {
        background: white;
        border-radius: 16px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        padding: 30px;
        border: 1px solid rgba(0, 0, 0, 0.05);
        transition: all 0.3s ease;
    }

    .suggested-section-wrapper:hover {
        box-shadow: 0 8px 30px rgba(0, 0, 0, 0.12);
        transform: translateY(-2px);
    }

    .suggested-products-grid {
        display: grid;
        grid-template-columns: repeat(5, 1fr);
        gap: 20px;
        margin-bottom: 20px;
    }

    .suggested-product-item {
        position: relative;
    }

    .suggested-product-card {
        background: white;
        border-radius: 12px;
        box-shadow: 0 2px 12px rgba(0, 0, 0, 0.08);
        overflow: hidden;
        transition: all 0.3s ease;
        height: 100%;
        border: 1px solid #f0f0f0;
    }

    .suggested-product-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
    }

    .suggested-product-image {
        position: relative;
        height: 180px;
        overflow: hidden;
        background: #f8f9fa;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .suggested-product-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.3s ease;
    }

    .suggested-product-card:hover .suggested-product-image img {
        transform: scale(1.05);
    }

    .suggested-discount-badge {
        position: absolute;
        top: 8px;
        right: 8px;
        background: linear-gradient(135deg, #ff6b35, #f7931e);
        color: white;
        padding: 4px 8px;
        border-radius: 12px;
        font-size: 0.75rem;
        font-weight: 600;
    }

    .suggested-product-content {
        padding: 15px;
        text-align: center;
    }

    .suggested-product-name {
        font-size: 0.9rem;
        font-weight: 600;
        margin-bottom: 8px;
        line-height: 1.3;
        color: #2c3e50;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        line-clamp: 2;
        overflow: hidden;
        height: 2.34em;
        text-overflow: ellipsis;
        word-wrap: break-word;
    }

    .suggested-price-section {
        margin-bottom: 8px;
    }

    .suggested-sale-price {
        font-size: 1rem;
        font-weight: 700;
        color: #e74c3c;
        margin-bottom: 2px;
    }

    .suggested-original-price {
        font-size: 0.8rem;
        color: #95a5a6;
        text-decoration: line-through;
    }

    .suggested-regular-price {
        font-size: 1rem;
        font-weight: 700;
        color: #3498db;
    }

    .suggested-rating {
        margin-bottom: 12px;
        font-size: 0.8rem;
    }

    .suggested-rating-count {
        color: #95a5a6;
        margin-left: 4px;
        font-size: 0.75rem;
    }

    .suggested-buy-btn {
        background: linear-gradient(135deg, #3498db, #2980b9);
        color: white;
        border: none;
        padding: 8px 16px;
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        width: 100%;
    }

    .suggested-buy-btn:hover {
        background: linear-gradient(135deg, #2980b9, #1f5f88);
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(52, 152, 219, 0.3);
    }

    .suggested-view-more-btn {
        background: linear-gradient(135deg, #4facfe, #00f2fe);
        color: white;
        border: none;
        padding: 12px 30px;
        border-radius: 25px;
        font-size: 0.9rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .suggested-view-more-btn:hover {
        background: linear-gradient(135deg, #00f2fe, #4facfe);
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(79, 172, 254, 0.3);
    }

    /* Responsive for Suggested Products */
    @media (max-width: 1200px) {
        .suggested-products-grid {
            grid-template-columns: repeat(4, 1fr);
            gap: 18px;
        }
    }

    @media (max-width: 992px) {
        .suggested-products-grid {
            grid-template-columns: repeat(3, 1fr);
            gap: 16px;
        }

        .suggested-section-wrapper {
            padding: 25px;
        }

        .suggested-product-image {
            height: 160px;
        }
    }

    @media (max-width: 768px) {
        .suggested-products-grid {
            grid-template-columns: repeat(2, 1fr);
            gap: 15px;
        }

        .suggested-section-wrapper {
            padding: 20px;
            border-radius: 12px;
        }

        .suggested-product-image {
            height: 140px;
        }

        .suggested-product-name {
            font-size: 0.8rem;
            height: 2.08em;
        }

        .suggested-sale-price,
        .suggested-regular-price {
            font-size: 0.9rem;
        }
    }

    @media (max-width: 576px) {
        .suggested-products-grid {
            grid-template-columns: repeat(2, 1fr);
            gap: 12px;
        }

        .suggested-section-wrapper {
            padding: 15px;
            border-radius: 8px;
        }

        .suggested-product-image {
            height: 120px;
        }

        .suggested-product-content {
            padding: 10px;
        }

        .suggested-product-name {
            font-size: 0.75rem;
            margin-bottom: 6px;
        }

        .suggested-sale-price,
        .suggested-regular-price {
            font-size: 0.8rem;
        }

        .suggested-buy-btn {
            padding: 6px 12px;
            font-size: 0.7rem;
        }

        .suggested-view-more-btn {
            padding: 10px 20px;
            font-size: 0.8rem;
        }
    }

    @media (max-width: 400px) {
        .suggested-products-grid {
            grid-template-columns: 1fr;
        }
    }

    /* Brand Section Styles */
    .brand-link-home {
        display: block;
        text-decoration: none;
        color: inherit;
        position: relative;
        border-radius: 12px;
        overflow: hidden;
        transition: all 0.3s ease;
        background: white;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        padding: 15px;
    }

    .brand-link-home:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
        color: inherit;
        text-decoration: none;
    }

    .brand-image-home {
        transition: all 0.3s ease;
        filter: grayscale(20%);
    }

    .brand-link-home:hover .brand-image-home {
        filter: grayscale(0%);
        transform: scale(1.1);
    }

    .brand-placeholder-home {
        transition: all 0.3s ease;
        background: linear-gradient(135deg, #f8f9fa, #e9ecef) !important;
        border: 1px solid #dee2e6;
    }

    .brand-link-home:hover .brand-placeholder-home {
        background: linear-gradient(135deg, #3498db, #2980b9) !important;
        color: white;
        border-color: #3498db;
    }

    .brand-name-overlay {
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        background: linear-gradient(to top, rgba(0,0,0,0.8), transparent);
        color: white;
        padding: 8px 12px 12px;
        font-size: 0.85rem;
        font-weight: 600;
        text-align: center;
        opacity: 0;
        transform: translateY(10px);
        transition: all 0.3s ease;
    }

    .brand-link-home:hover .brand-name-overlay {
        opacity: 1;
        transform: translateY(0);
    }

    .brand-item {
        display: flex;
        align-items: center;
        gap: 8px;
        margin-top: 5px;
        padding: 5px 10px;
        border-radius: 8px;
        background-color: #f0f0f0;
        transition: all 0.3s ease;
    }

    .brand-item:hover {
        transform: translateX(5px);
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
    }

    /* Responsive for brand section */
    @media (max-width: 768px) {
        .brand-link-home {
            padding: 12px;
        }

        .brand-name-overlay {
            font-size: 0.75rem;
            padding: 6px 8px 8px;
        }
    }

    /* Floating Contact Icons */
    .floating-contact-icons {
        position: fixed;
        right: 20px;
        bottom: 20px;
        z-index: 1000;
        display: flex;
        flex-direction: column;
        gap: 15px;
    }

    .floating-icon {
        position: relative;
        width: 60px;
        height: 60px;
        border-radius: 50%;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
        cursor: pointer;
        transition: all 0.3s ease;
        animation: pulse 2s infinite;
    }

    .floating-icon a {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 100%;
        height: 100%;
        border-radius: 50%;
        text-decoration: none;
        color: white;
        font-size: 24px;
        transition: all 0.3s ease;
    }

    .zalo-icon {
        background: linear-gradient(135deg, #0068ff, #0052cc);
    }

    .zalo-icon:hover {
        background: linear-gradient(135deg, #0052cc, #003d99);
        transform: scale(1.1);
        box-shadow: 0 6px 25px rgba(0, 104, 255, 0.4);
    }

    .phone-icon {
        background: linear-gradient(135deg, #25d366, #128c7e);
    }

    .phone-icon:hover {
        background: linear-gradient(135deg, #128c7e, #075e54);
        transform: scale(1.1);
        box-shadow: 0 6px 25px rgba(37, 211, 102, 0.4);
    }

    .icon-tooltip {
        position: absolute;
        right: 70px;
        top: 50%;
        transform: translateY(-50%);
        background: rgba(0, 0, 0, 0.8);
        color: white;
        padding: 8px 12px;
        border-radius: 6px;
        font-size: 12px;
        white-space: nowrap;
        opacity: 0;
        visibility: hidden;
        transition: all 0.3s ease;
        pointer-events: none;
    }

    .icon-tooltip::after {
        content: '';
        position: absolute;
        top: 50%;
        left: 100%;
        transform: translateY(-50%);
        border: 6px solid transparent;
        border-left-color: rgba(0, 0, 0, 0.8);
    }

    .floating-icon:hover .icon-tooltip {
        opacity: 1;
        visibility: visible;
        right: 75px;
    }

    /* Pulse Animation */
    @keyframes pulse {
        0% {
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15), 0 0 0 0 rgba(0, 104, 255, 0.7);
        }
        70% {
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15), 0 0 0 10px rgba(0, 104, 255, 0);
        }
        100% {
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15), 0 0 0 0 rgba(0, 104, 255, 0);
        }
    }

    .phone-icon {
        animation: pulse-phone 2s infinite;
    }

    @keyframes pulse-phone {
        0% {
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15), 0 0 0 0 rgba(37, 211, 102, 0.7);
        }
        70% {
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15), 0 0 0 10px rgba(37, 211, 102, 0);
        }
        100% {
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15), 0 0 0 0 rgba(37, 211, 102, 0);
        }
    }

    /* Floating Icons Responsive */
    @media (max-width: 768px) {
        .floating-contact-icons {
            right: 15px;
            bottom: 15px;
            gap: 12px;
        }

        .floating-icon {
            width: 50px;
            height: 50px;
        }

        .floating-icon a {
            font-size: 20px;
        }

        .icon-tooltip {
            right: 60px;
            font-size: 11px;
            padding: 6px 10px;
        }

        .floating-icon:hover .icon-tooltip {
            right: 65px;
        }
    }

    @media (max-width: 480px) {
        .floating-contact-icons {
            right: 10px;
            bottom: 10px;
        }

        .floating-icon {
            width: 45px;
            height: 45px;
        }

        .floating-icon a {
            font-size: 18px;
        }
    }
</style>
@endpush
