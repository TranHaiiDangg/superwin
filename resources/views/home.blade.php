@extends('layouts.app')

@section('title', 'SuperWin - Máy bơm nước & Quạt công nghiệp')

@section('content')
<!-- Hero Section with Banner Slider -->
<section class="hero-section py-5">
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
    <div class="container">
        <div class="row g-3 d-flex justify-content-center">
            @foreach($mainCategories as $category)
            <div class="col-6 col-md-3 col-lg-2 d-flex align-items-stretch">
                <a href="{{ route('categories.show', $category->slug ?? $category->id) }}" class="menu-item">
                    <div class="icon-container">
                        @if($category->image)
                        <!-- <img src="{{ $category->image }}" alt="{{ $category->name }}" class="menu-img" /> -->
                        <img src="/image/bom.png" alt="Bơm Nước" class="menu-img" />
                        @else
                        <i class="fas fa-cog text-primary fa-2x"></i>
                        @endif
                    </div>
                    <p class="mb-0">{{ $category->name }}</p>
                </a>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endif
<!-- Flash Deals Section -->
@if($saleProducts->count() > 0)
<div class="container">
    <section class="flash-deals-section py-4">
        <div class="container">
            <div class="flash-deals-header d-flex justify-content-between align-items-center mb-4">
                <div class="d-flex align-items-center">
                    <h2 class="fw-bold text-white mb-0 me-3 flash-deal-title">
                        Flash Deal
                    </h2>
                    <div class="countdown-timer">
                        <span class="timer-label text-black me-2">Kết thúc trong:</span>
                        <div class="timer-display">
                            <span class="time-unit" id="hours">02</span>
                            <span class="time-unit" id="minutes">52</span>
                            <span class="time-unit" id="seconds">52</span>
                        </div>
                    </div>
                </div>
                <a href="{{ route('deals') }}" class="btn btn-outline-light btn-sm flash-deal-view-all">
                    Xem tất cả
                </a>
            </div>

            <div class="flash-deals-slider">
                <button class="slider-nav prev" id="flashDealsPrev">
                    <i class="fas fa-chevron-left"></i>
                </button>

                <div class="slider-container">
                    <div class="slider-track" id="flashDealsTrack">
                        @foreach($saleProducts->take(10) as $index => $product)
                        <div class="deal-item">
                            <div class="deal-card">
                                <div class="discount-badge">
                                    -{{ $product->discount_percentage }}%
                                </div>

                                <div class="product-image">
                                    <a href="{{ route('products.show', $product->slug ?? $product->id) }}">
                                        @if($product->baseImage)
                                        <img src="{{ $product->baseImage->url }}" alt="{{ $product->name }}" class="img-fluid">
                                        @else
                                        <img src="/image/sp1.png" alt="{{ $product->name }}" class="img-fluid">
                                        @endif
                                    </a>
                                </div>

                                <div class="deal-content">
                                    <h6 class="product-name">{{ $product->name }}</h6>

                                    <div class="price-section d-flex justify-content-center align-items-center">
                                        <div class="sale-price">{{ number_format($product->sale_price) }}đ</div>
                                        <div class="ms-2 original-price">{{ number_format($product->price) }}đ</div>
                                    </div>

                                    @php
                                    $soldCount = $product->sold_count ?? rand(20, 80);
                                    $totalStock = $product->stock_quantity + $soldCount;
                                    $progress = $totalStock > 0 ? round(($soldCount / $totalStock) * 100) : 0;
                                    @endphp

                                    <div class="progress-section text-center">
                                        <div class="sold-info">Đã bán {{ $soldCount }}/{{ $totalStock }}</div>
                                        <div class="progress-bar">
                                            <div class="progress-fill" style="width: {{ $progress }}%"></div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

                <button class="slider-nav next" id="flashDealsNext">
                    <i class="fas fa-chevron-right"></i>
                </button>
            </div>
        </div>
    </section>
</div>
@endif

<!-- Category Products Sections -->
@if(count($categoryProducts) > 0)
@foreach($categoryProducts as $categoryData)
<section class="py-4">
    <div class="container">
        <div class="category-section-wrapper">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h3 class="fw-bold mb-0 normal-product-title">{{ $categoryData['category']->name }}</h3>
                </div>
                <a href="{{ route('categories.show', $categoryData['category']->id) }}" class="btn btn-sm normal-product-view-all">
                    Xem tất cả
                </a>
            </div>

            <div class="category-products-slider" data-category="{{ $categoryData['category']->id }}">
                <button class="category-slider-nav normal-product-nav prev" data-direction="prev">
                    <i class="fas fa-chevron-left"></i>
                </button>

                <div class="category-slider-container">
                    <div class="category-slider-track">
                        @foreach($categoryData['products'] as $product)
                        <div class="category-product-item">
                            <div class="category-product-card">
                                <div class="category-product-image">
                                    <a href="{{ route('products.show', $product->slug ?? $product->id) }}">
                                        @if($product->baseImage)
                                        <img src="{{ $product->baseImage->url }}" alt="{{ $product->name }}" class="img-fluid">
                                        @else
                                        <img src="/image/sp1.png" alt="{{ $product->name }}" class="img-fluid">
                                        @endif
                                    </a>

                                    @if($product->isOnSale)
                                    <span class="category-discount-badge">
                                        -{{ $product->discount_percentage }}%
                                    </span>
                                    @endif
                                </div>

                                <div class="category-product-content">
                                    <h6 class="category-product-name">{{ $product->name }}</h6>

                                    <div class="category-price-section text-center">
                                        @if($product->isOnSale)
                                        <div class="category-regular-price">{{ number_format($product->sale_price) }}đ</div>
                                        <div class="category-original-price">{{ number_format($product->price) }}đ</div>
                                        @else
                                        <div class="category-regular-price">{{ number_format($product->price) }}đ</div>
                                        @endif
                                    </div>

                                    <div class="category-stock-info  d-flex justify-content-center align-items-center ">
                                        @if($product->stock_quantity > 0)
                                        <span class=" small normal-product-sold">
                                            <i class="fas fa-check-circle"></i> Còn hàng
                                        </span>
                                        @else
                                        <span class="text-danger small">
                                            <i class="fas fa-times-circle"></i> Hết hàng
                                        </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

                <button class="category-slider-nav normal-product-nav next" data-direction="next">
                    <i class="fas fa-chevron-right"></i>
                </button>
            </div>
        </div>
    </div>
</section>
@endforeach
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
                                <div class="suggested-sale-price">{{ number_format($product->sale_price) }}đ</div>
                                <div class="suggested-original-price">{{ number_format($product->price) }}đ</div>
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

    /* Banner Slider Styles */
    .banner-wrapper {
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 15px;
    }

    .banner-grid {
        display: grid;
        grid-template-columns: 2fr 1fr;
        grid-template-rows: 1fr 1fr;
        gap: 15px;
        height: 320px;
    }

    .main-banner {
        grid-row: 1 / 3;
        position: relative;
        overflow: hidden;
        border-radius: 12px;
    }

    .slider-column {
        height: 100%;
        position: relative;
    }

    .main-slider {
        height: 100%;
        position: relative;
        overflow: hidden;
    }

    .slide-container {
        display: flex;
        height: 100%;
        transition: transform 0.5s ease-in-out;
    }

    .slide {
        min-width: 100%;
        height: 100%;
    }

    .slide img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .slider-nav {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        background: rgba(255, 255, 255, 0.8);
        border: none;
        border-radius: 50%;
        width: 40px;
        height: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        z-index: 10;
        transition: all 0.3s ease;
    }

    .slider-nav:hover {
        background: rgba(255, 255, 255, 1);
    }

    .slider-nav.prev {
        left: 15px;
    }

    .slider-nav.next {
        right: 15px;
    }

    .pagination-dots {
        position: absolute;
        bottom: 20px;
        left: 50%;
        transform: translateX(-50%);
        display: flex;
        gap: 8px;
        z-index: 10;
    }

    .dot {
        width: 10px;
        height: 10px;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.5);
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .dot.active {
        background: rgba(255, 255, 255, 1);
    }

    .side-banner-1,
    .side-banner-2 {
        overflow: hidden;
        border-radius: 12px;
    }

    .image-box {
        height: 100%;
    }

    .image-box img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.3s ease;
    }

    .image-box:hover img {
        transform: scale(1.05);
    }

    /* Container Menu Styles */
    .container-menu {
        background: white;
        padding: 20px 0;
        border-bottom: 1px solid #eee;
    }

    .menu-item {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        text-decoration: none;
        color: #333;
        padding: 15px 10px;
        border-radius: 12px;
        transition: all 0.3s ease;
        text-align: center;
        min-height: 100px;
        width: 100%;
        height: 100%;
    }

    .menu-item:hover {
        /* background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
        color: white; */
        transform: translateY(-10px);
        /* box-shadow: 0 8px 25px rgba(79, 172, 254, 0.3); */
    }

    .icon-container {
        width: 60px;
        height: 60px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 10px;
        background: rgba(79, 172, 254, 0.1);
        border-radius: 50%;
        transition: all 0.3s ease;
    }

    .menu-item:hover .icon-container {
        background: rgba(255, 255, 255, 0.2);
    }

    .menu-img {
        max-width: 100%;
        max-height: 100%;
        transition: all 0.3s ease;
    }

    .menu-item p {
        font-size: 0.9rem;
        font-weight: 500;
        margin: 0;
        line-height: 1.2;
    }

    /* Đảm bảo các menu items có chiều cao đồng đều và căn giữa */
    .col-6.col-md-3.col-lg-2 {
        display: flex;
        align-items: stretch;
        min-height: 120px;
    }

    .col-6.col-md-3.col-lg-2>a {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        width: 100%;
        height: 100%;
        text-align: center;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .banner-grid {
            grid-template-columns: 1fr;
            grid-template-rows: auto auto auto;
            height: auto;
        }

        .main-banner {
            grid-row: 1;
            height: 250px;
        }

        .side-banner-1,
        .side-banner-2 {
            height: 150px;
        }

        /* Mobile menu items */
        .col-6.col-md-3.col-lg-2 {
            min-height: 100px;
        }

        .menu-item {
            min-height: 80px;
            padding: 10px 5px;
        }

        .icon-container {
            width: 40px;
            height: 40px;
            margin-bottom: 8px;
        }

        .menu-item p {
            font-size: 0.8rem;
        }
    }

    /* Flash Deals Section Styles */
    .flash-deals-section {
        background: #FFE5B4;
        border-radius: 16px;
        margin: 20px 0;
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

    .time-unit {
        background: #FF6B35;
        color: #fff;
        padding: 4px 8px;
        border-radius: 4px;
        font-weight: 700;
        font-size: 14px;
        min-width: 30px;
        text-align: center;
    }
    .flash-deal-view-all{
    background: #FF6B35;
    color: #fff;
    padding: 10px 20px !important;
    border: none;
    border-radius: 25px !important;
    font-size: 14px;
    font-weight: 600 !important;
    cursor: pointer;
    transition: all 0.3s ease !important;
    text-decoration: none;
    display: inline-block;
    box-shadow: 0 2px 8px rgba(255, 107, 53, 0.3);
    white-space: nowrap;
    flex-shrink: 0;
    }
    .normal-product-title{
    font-size: 20px;
    color: #fff;
    font-weight: 700;
    background: #4facfe;
    padding: 8px 16px;
    border-radius: 6px;
    display: flex;
    align-items: center;
    gap: 8px;
    white-space: nowrap;
    height: 40px;
    box-sizing: border-box;}
    .normal-product-nav{

    background: rgba(79, 172, 254, 0.9) !important;
    color: white;
    border: none !important;
    width: 40px !important;
    height: 40px !important;
    transition: all 0.3s ease;

    }
    .normal-product-view-all{
    background: #4facfe;
    color: #fff;
    padding: 10px 20px !important;
    border: none;
    border-radius: 25px !important;
    font-size: 14px;
    font-weight: 600 !important;
    cursor: pointer;
    transition: all 0.3s ease !important;
    text-decoration: none;
    display: inline-block;
    box-shadow: 0 2px 8px rgba(79, 172, 254, 0.3);
    white-space: nowrap;
    flex-shrink: 0;
    }
    .flash-deals-header {
        position: relative;
        z-index: 2;
    }

    .countdown-timer {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .timer-label {
        font-size: 0.9rem;
        font-weight: 500;
    }

    .timer-display {
        display: flex;
        gap: 4px;
    }


    .flash-deals-slider {
        position: relative;
        z-index: 2;
        display: flex;
        align-items: center;
        gap: 15px;
    }

    .slider-container {
        flex: 1;
        overflow: hidden;
        position: relative;
        margin: 0 10px;
    }

    .slider-track {
        display: flex;
        transition: transform 0.5s ease;
        gap: 15px;
    }

    .deal-item {
        flex: 0 0 250px;
        min-width: 250px;
    }

    .deal-card {
        background: white;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease;
        height: 100%;
        position: relative;
    }

    .deal-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
    }

    .discount-badge {
        position: absolute;
        top: 8px;
        left: 8px;
        background: #ff4757;
        color: white;
        padding: 4px 8px;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: bold;
        z-index: 3;
    }

    .product-image {
        position: relative;
        height: 160px;
        overflow: hidden;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #f8f9fa;
    }

    .product-image img {
        max-width: 100%;
        max-height: 100%;
        object-fit: contain;
        transition: transform 0.3s ease;
    }

    .deal-card:hover .product-image img {
        transform: scale(1.05);
    }

    .deal-content {
        padding: 12px;
    }

    .product-name {
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
        /* Cố định chiều cao cho 2 dòng (0.9rem * 1.3 line-height * 2 dòng) */
        text-overflow: ellipsis;
        word-wrap: break-word;
        word-break: break-word;
    }

    .price-section {
        margin-bottom: 12px;
    }

    .sale-price {
        color: #e74c3c;
        font-weight: bold;
        font-size: 1.1rem;
        display: block;
    }

    .original-price {
        text-decoration: line-through;
        color: #95a5a6;
        font-size: 0.8rem;
        margin-top: 2px;
    }

    .progress-section {
        margin-top: 10px;
    }

    .progress-bar {
        background: #ecf0f1;
        height: 6px;
        border-radius: 3px;
        overflow: hidden;
        margin-bottom: 6px;
        position: relative;
    }

    .progress-fill {
        background: linear-gradient(90deg, #ff6b35, #f7931e);
        height: 100%;
        border-radius: 3px;
        transition: width 0.3s ease;
    }

    .sold-info {
        font-size: 0.75rem;
        color: #666;
        text-align: center;
    }

    .deal-button {
        background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
        color: white;
        border: none;
        padding: 10px 16px;
        border-radius: 8px;
        font-weight: 600;
        font-size: 0.9rem;
        cursor: pointer;
        transition: all 0.3s ease;
        margin-top: auto;
        text-decoration: none;
        display: inline-block;
        text-align: center;
    }

    .deal-button:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(79, 172, 254, 0.4);
    }

    .flash-deals-slider .slider-nav {
        background: rgba(255, 255, 255, 0.9);
        border: none;
        border-radius: 50%;
        width: 40px;
        height: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        z-index: 10;
        transition: all 0.3s ease;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        color: #333;
        flex-shrink: 0;
    }

    .flash-deals-slider .slider-nav:hover {
        background: white;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        transform: scale(1.05);
    }

    .flash-deals-slider .slider-nav:disabled {
        opacity: 0.5;
        cursor: not-allowed;
    }

    .flash-deals-slider .slider-nav:disabled:hover {
        transform: none;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    }

    /* Flash Deals Responsive */
    @media (max-width: 768px) {
        .flash-deals-header {
            flex-direction: column;
            gap: 15px;
            text-align: center;
        }

        .countdown-timer {
            justify-content: center;
        }

        .deal-item {
            flex: 0 0 220px;
            min-width: 220px;
        }

        .flash-deals-slider .slider-nav {
            width: 35px;
            height: 35px;
        }

        .flash-deals-slider {
            gap: 10px;
        }

        .slider-container {
            margin: 0 5px;
        }
    }

    @media (max-width: 576px) {
        .deal-item {
            flex: 0 0 200px;
            min-width: 200px;
        }

        .product-image {
            height: 140px;
        }

        .product-name {
            font-size: 0.8rem;
            height: 2.08em;
            /* Điều chỉnh chiều cao cho mobile (0.8rem * 1.3 line-height * 2 dòng) */
        }

        .sale-price {
            font-size: 1rem;
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
