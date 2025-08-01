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
<div class="container-menu">
    <a href="#" class="menu-item">
        <div class="icon-container">
            <img src="/image/bom.png" alt="Bơm Nước" class="menu-img" />
        </div>
        <p>Bơm Nước</p>
    </a>
</div>

<!-- Categories Section -->
@if($mainCategories->count() > 0)
<section class="py-5">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="fw-bold">Danh mục sản phẩm</h2>
            <p class="text-muted">Khám phá các sản phẩm chất lượng của chúng tôi</p>
        </div>
        
        <div class="row g-4">
            @foreach($mainCategories as $category)
            <div class="col-md-4 col-lg-3">
                <div class="card h-100 border-0 shadow-sm hover-lift">
                    <div class="card-body text-center p-4">
                        <div class="mb-3">
                            <i class="fas fa-cog text-primary fa-3x"></i>
                        </div>
                        <h5 class="card-title">{{ $category->name }}</h5>
                        <p class="card-text text-muted small">{{ $category->description }}</p>
                        <a href="#" class="btn btn-outline-primary btn-sm">Xem sản phẩm</a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

<!-- Featured Products -->
@if($featuredProducts->count() > 0)
<section class="py-5 bg-light">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="fw-bold">Sản phẩm nổi bật</h2>
            <p class="text-muted">Những sản phẩm được khách hàng tin tưởng lựa chọn</p>
        </div>
        
        <div class="row g-4">
            @foreach($featuredProducts as $product)
            <div class="col-md-6 col-lg-3">
                <div class="card h-100 border-0 shadow-sm product-card">
                    <div class="position-relative">
                        @if($product->baseImage)
                            <img src="{{ $product->baseImage->url }}" class="card-img-top" alt="{{ $product->name }}" style="height: 200px; object-fit: cover;">
                        @else
                            <img src="/image/sp1.png" class="card-img-top" alt="{{ $product->name }}" style="height: 200px; object-fit: cover;">
                        @endif
                        
                        @if($product->isOnSale)
                            <span class="badge bg-danger position-absolute top-0 end-0 m-2">
                                -{{ $product->discount_percentage }}%
                            </span>
                        @endif
                        
                        @if($product->is_featured)
                            <span class="badge bg-warning position-absolute top-0 start-0 m-2">
                                <i class="fas fa-star"></i> Nổi bật
                            </span>
                        @endif
                    </div>
                    
                    <div class="card-body d-flex flex-column">
                        <h6 class="card-title">{{ $product->name }}</h6>
                        <p class="card-text text-muted small">{{ Str::limit($product->short_description, 80) }}</p>
                        
                        <div class="mt-auto">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                @if($product->isOnSale)
                                    <span class="text-danger fw-bold">{{ number_format($product->sale_price) }}đ</span>
                                    <span class="text-muted text-decoration-line-through">{{ number_format($product->price) }}đ</span>
                                @else
                                    <span class="text-primary fw-bold">{{ number_format($product->price) }}đ</span>
                                @endif
                            </div>
                            
                            <div class="d-grid">
                                <a href="#" class="btn btn-primary btn-sm">
                                    <i class="fas fa-shopping-cart me-1"></i>Thêm vào giỏ
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        
        <div class="text-center mt-4">
            <a href="{{ route('products.index') }}" class="btn btn-outline-primary">
                Xem tất cả sản phẩm <i class="fas fa-arrow-right ms-1"></i>
            </a>
        </div>
    </div>
</section>
@endif

<!-- Sale Products -->
@if($saleProducts->count() > 0)
<section class="py-5">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="fw-bold">Khuyến mãi hot</h2>
            <p class="text-muted">Giảm giá sốc, mua ngay kẻo lỡ!</p>
        </div>
        
        <div class="row g-4">
            @foreach($saleProducts as $product)
            <div class="col-md-6 col-lg-3">
                <div class="card h-100 border-0 shadow-sm product-card">
                    <div class="position-relative">
                        @if($product->baseImage)
                            <img src="{{ $product->baseImage->url }}" class="card-img-top" alt="{{ $product->name }}" style="height: 200px; object-fit: cover;">
                        @else
                            <img src="/image/sp1.png" class="card-img-top" alt="{{ $product->name }}" style="height: 200px; object-fit: cover;">
                        @endif
                        
                        <span class="badge bg-danger position-absolute top-0 end-0 m-2">
                            -{{ $product->discount_percentage }}%
                        </span>
                    </div>
                    
                    <div class="card-body d-flex flex-column">
                        <h6 class="card-title">{{ $product->name }}</h6>
                        <p class="card-text text-muted small">{{ Str::limit($product->short_description, 80) }}</p>
                        
                        <div class="mt-auto">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span class="text-danger fw-bold">{{ number_format($product->sale_price) }}đ</span>
                                <span class="text-muted text-decoration-line-through">{{ number_format($product->price) }}đ</span>
                            </div>
                            
                            <div class="d-grid">
                                <a href="#" class="btn btn-danger btn-sm">
                                    <i class="fas fa-fire me-1"></i>Mua ngay
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
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
                    @if($brand->image)
                        <img src="{{ $brand->image }}" alt="{{ $brand->name }}" class="img-fluid" style="max-height: 60px;">
                    @else
                        <div class="bg-white p-3 rounded shadow-sm">
                            <h6 class="mb-0">{{ $brand->name }}</h6>
                        </div>
                    @endif
                </div>
            </div>
            @endforeach
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

@push('scripts')
<script src="/js/trang_chu/banner_slider.js"></script>
<script>
// Banner Slider Functionality
document.addEventListener('DOMContentLoaded', function() {
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
    box-shadow: 0 10px 25px rgba(0,0,0,0.1) !important;
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
    height: 400px;
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

.side-banner-1, .side-banner-2 {
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
    text-decoration: none;
    color: #333;
    padding: 10px;
    border-radius: 8px;
    transition: all 0.3s ease;
}

.menu-item:hover {
    background: #f8f9fa;
    color: #4facfe;
}

.icon-container {
    width: 50px;
    height: 50px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 8px;
}

.menu-img {
    max-width: 100%;
    max-height: 100%;
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
    
    .side-banner-1, .side-banner-2 {
        height: 150px;
    }
}
</style>
@endpush