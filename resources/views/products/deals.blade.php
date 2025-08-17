@extends('layouts.app')

@section('title', 'Flash Deal - Khuyến Mãi Hot - SuperWin')

@section('content')
<div class="container-fluid">
    <div class="row">
        <!-- Sidebar Filter (Desktop) -->
        <div class="col-lg-3 col-md-4 d-none d-md-block">
            <div class="category-sidebar">
                <!-- Deal Stats Section -->
                <div class="filter-section deal-intro">
                    <div class="deal-header">
                        <div class="deal-logo">
                            <i class="fas fa-fire text-danger fa-3x"></i>
                        </div>
                        <h5 class="deal-title">FLASH DEAL</h5>
                        <p class="deal-subtitle">Khuyến mãi cực hot</p>
                    </div>
                    
                    <!-- <div class="deal-stats">
                        <div class="stat-item">
                            <strong>{{ $dealStats['total_deals'] }}</strong>
                            <span>sản phẩm</span>
                        </div>
                        <div class="stat-item">
                            <strong>{{ $dealStats['avg_discount'] }}%</strong>
                            <span>giảm giá TB</span>
                        </div>
                        <div class="stat-item">
                            <strong>{{ $dealStats['max_discount'] }}%</strong>
                            <span>giảm tối đa</span>
                        </div>
                    </div> -->
                </div>

                <!-- Category Filter -->
                @if($categories->count() > 0)
                <div class="filter-section">
                    <h6 class="filter-subtitle">DANH MỤC</h6>
                    <div class="filter-content">
                        @foreach($categories as $category)
                        <div class="form-check">
                            <input class="form-check-input" type="radio" value="{{ $category->id }}" id="cat{{ $category->id }}" name="category_id" {{ request('category_id') == $category->id ? 'checked' : '' }}>
                            <label class="form-check-label" for="cat{{ $category->id }}">
                                {{ $category->name }} <span class="text-muted">({{ $category->products_count }})</span>
                            </label>
                        </div>
                        @endforeach
                        <div class="form-check">
                            <input class="form-check-input" type="radio" value="" id="catAll" name="category_id" {{ !request('category_id') ? 'checked' : '' }}>
                            <label class="form-check-label" for="catAll">Tất cả danh mục</label>
                        </div>
                    </div>
                </div>
                @endif

                <!-- Brand Filter -->
                @if($brands->count() > 0)
                <div class="filter-section">
                    <h6 class="filter-subtitle">THƯƠNG HIỆU</h6>
                    <div class="filter-content">
                        @foreach($brands as $brand)
                        <div class="form-check">
                            <input class="form-check-input" type="radio" value="{{ $brand->id }}" id="brand{{ $brand->id }}" name="brand_id" {{ request('brand_id') == $brand->id ? 'checked' : '' }}>
                            <label class="form-check-label" for="brand{{ $brand->id }}">
                                {{ $brand->name }} <span class="text-muted">({{ $brand->products_count }})</span>
                            </label>
                        </div>
                        @endforeach
                        <div class="form-check">
                            <input class="form-check-input" type="radio" value="" id="brandAll" name="brand_id" {{ !request('brand_id') ? 'checked' : '' }}>
                            <label class="form-check-label" for="brandAll">Tất cả thương hiệu</label>
                        </div>
                    </div>
                </div>
                @endif

                <!-- Price Filter -->
                <div class="filter-section">
                    <h6 class="filter-subtitle">KHOẢNG GIÁ</h6>
                    <div class="filter-content">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" value="0-1000000" id="price1" name="price_range" {{ request('price_range') == '0-1000000' ? 'checked' : '' }}>
                            <label class="form-check-label" for="price1">Dưới 1.000.000đ</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" value="1000000-3000000" id="price2" name="price_range" {{ request('price_range') == '1000000-3000000' ? 'checked' : '' }}>
                            <label class="form-check-label" for="price2">1.000.000đ - 3.000.000đ</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" value="3000000-5000000" id="price3" name="price_range" {{ request('price_range') == '3000000-5000000' ? 'checked' : '' }}>
                            <label class="form-check-label" for="price3">3.000.000đ - 5.000.000đ</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" value="5000000-10000000" id="price4" name="price_range" {{ request('price_range') == '5000000-10000000' ? 'checked' : '' }}>
                            <label class="form-check-label" for="price4">5.000.000đ - 10.000.000đ</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" value="10000000+" id="price5" name="price_range" {{ request('price_range') == '10000000+' ? 'checked' : '' }}>
                            <label class="form-check-label" for="price5">Trên 10.000.000đ</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" value="" id="priceAll" name="price_range" {{ !request('price_range') ? 'checked' : '' }}>
                            <label class="form-check-label" for="priceAll">Tất cả</label>
                        </div>
                    </div>
                </div>

                <!-- Discount Filter -->
                <div class="filter-section">
                    <h6 class="filter-subtitle">MỨC GIẢM GIÁ</h6>
                    <div class="filter-content">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" value="10-30" id="discount1" name="discount_range" {{ request('discount_range') == '10-30' ? 'checked' : '' }}>
                            <label class="form-check-label" for="discount1">10% - 30%</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" value="30-50" id="discount2" name="discount_range" {{ request('discount_range') == '30-50' ? 'checked' : '' }}>
                            <label class="form-check-label" for="discount2">30% - 50%</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" value="50+" id="discount3" name="discount_range" {{ request('discount_range') == '50+' ? 'checked' : '' }}>
                            <label class="form-check-label" for="discount3">Trên 50%</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" value="" id="discountAll" name="discount_range" {{ !request('discount_range') ? 'checked' : '' }}>
                            <label class="form-check-label" for="discountAll">Tất cả</label>
                        </div>
                    </div>
                </div>

                <!-- Product Type Filter -->
                <div class="filter-section">
                    <h6 class="filter-subtitle">LOẠI SẢN PHẨM</h6>
                    <div class="filter-content">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" value="featured" id="featured" name="filter" {{ request('filter') == 'featured' ? 'checked' : '' }}>
                            <label class="form-check-label" for="featured">Sản phẩm nổi bật</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" value="new" id="new" name="filter" {{ request('filter') == 'new' ? 'checked' : '' }}>
                            <label class="form-check-label" for="new">Sản phẩm mới</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" value="high_discount" id="high_discount" name="filter" {{ request('filter') == 'high_discount' ? 'checked' : '' }}>
                            <label class="form-check-label" for="high_discount">Giảm giá sốc (≥50%)</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" value="" id="filterAll" name="filter" {{ !request('filter') ? 'checked' : '' }}>
                            <label class="form-check-label" for="filterAll">Tất cả</label>
                        </div>
                    </div>
                </div>

                <!-- Filter Actions -->
                <div class="filter-actions">
                    <button type="button" class="btn btn-primary btn-sm w-100 mb-2" onclick="applyFilters()">
                        <i class="fas fa-filter me-2"></i>Áp dụng bộ lọc
                    </button>
                    <a href="{{ route('deals') }}" class="btn btn-outline-secondary btn-sm w-100">
                        <i class="fas fa-refresh me-2"></i>Xóa bộ lọc
                    </a>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="col-lg-9 col-md-8 col-12">
            <!-- Mobile Filter Button -->
            <div class="mobile-filter-section mb-3">
                <div class="d-flex justify-content-between-deal align-items-center">
                    <button class="mobile-filter-btn" type="button" data-bs-toggle="offcanvas" data-bs-target="#dealFilterOffcanvas" aria-controls="dealFilterOffcanvas">
                        <i class="fas fa-sliders-h me-2"></i>
                        <span>Bộ lọc</span>
                    </button>
                    <div class="mobile-sort-options">
                        <select class="form-select form-select-sm" id="mobileSortBy">
                            <option value="discount_high" {{ request('sort_by', 'discount_high') == 'discount_high' ? 'selected' : '' }}>Giảm giá cao nhất</option>
                            <option value="price_low" {{ request('sort_by') == 'price_low' ? 'selected' : '' }}>Giá thấp</option>
                            <option value="price_high" {{ request('sort_by') == 'price_high' ? 'selected' : '' }}>Giá cao</option>
                            <option value="bestseller" {{ request('sort_by') == 'bestseller' ? 'selected' : '' }}>Bán chạy</option>
                            <option value="newest" {{ request('sort_by') == 'newest' ? 'selected' : '' }}>Mới nhất</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Header -->
            <div class="category-header">
                <!-- Title Section -->
                <div class="header-top mb-3">
                    <h3 class="category-title">
                        <i class="fas fa-fire text-danger me-2"></i>
                        Flash Deal
                    </h3>
                    <p class="category-subtitle">({{ $products->total() }} sản phẩm đang khuyến mãi)</p>
                </div>

                <!-- Controls Section -->
                <div class="header-controls d-flex flex-column flex-md-row justify-content-between-deal align-items-center mb-3">
                    <!-- Quick Filters -->
                    <div class="quick-filters">
                        <button class="quick-filter-btn {{ !request('filter') && request('sort_by') != 'bestseller' ? 'active' : '' }}" data-filter="all">Tất cả</button>
                        <button class="quick-filter-btn {{ request('filter') == 'featured' ? 'active' : '' }}" data-filter="featured">Nổi bật</button>
                        <button class="quick-filter-btn {{ request('filter') == 'high_discount' ? 'active' : '' }}" data-filter="high_discount">Giảm sốc ≥50%</button>
                        <button class="quick-filter-btn {{ request('sort_by') == 'bestseller' ? 'active' : '' }}" data-filter="bestseller">Bán chạy</button>
                        <button class="quick-filter-btn {{ request('filter') == 'new' ? 'active' : '' }}" data-filter="new">Mới nhất</button>
                    </div>
                    
                    <!-- Sort Options -->
                    <div class="sort-options d-flex gap-2 align-items-center">
                        <select class="form-select form-select-sm" id="perPage">
                            <option value="6" {{ request('per_page') == 6 ? 'selected' : '' }}>6 sản phẩm</option>
                            <option value="12" {{ request('per_page', 12) == 12 ? 'selected' : '' }}>12 sản phẩm</option>
                            <option value="24" {{ request('per_page') == 24 ? 'selected' : '' }}>24 sản phẩm</option>
                            <option value="48" {{ request('per_page') == 48 ? 'selected' : '' }}>48 sản phẩm</option>
                        </select>
                        <select class="form-select form-select-sm" id="sortBy">
                            <option value="discount_high" {{ request('sort_by', 'discount_high') == 'discount_high' ? 'selected' : '' }}>Giảm giá cao nhất</option>
                            <option value="price_low" {{ request('sort_by') == 'price_low' ? 'selected' : '' }}>Giá thấp nhất</option>
                            <option value="price_high" {{ request('sort_by') == 'price_high' ? 'selected' : '' }}>Giá cao nhất</option>
                            <option value="bestseller" {{ request('sort_by') == 'bestseller' ? 'selected' : '' }}>Bán chạy</option>
                            <option value="newest" {{ request('sort_by') == 'newest' ? 'selected' : '' }}>Mới nhất</option>
                            <option value="name" {{ request('sort_by') == 'name' ? 'selected' : '' }}>Tên sản phẩm</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Products Grid -->
            @if($products->count() > 0)
            <div class="products-grid">
                @foreach($products as $product)
                <div class="product-item">
                    <div class="product-card"
                         data-product-id="{{ $product->id }}"
                         data-product-name="{{ $product->name }}"
                         data-product-model="{{ $product->sku ?? 'SW-' . $product->id }}"
                         data-product-price="{{ ($product->sale_price && $product->sale_price < $product->price) ? $product->sale_price : $product->price }}"
                         data-product-image="{{ $product->displayImage ? asset($product->displayImage->url) : asset('/image/sp1.png') }}">
                        <div class="product-image">
                            <a href="{{ route('products.show', $product->slug ?? $product->id) }}">
                            @if($product->displayImage && $product->displayImage->url)
                                <img src="{{ asset($product->displayImage->url) }}" alt="{{ $product->name }}" class="img-fluid">
                            @else
                                <img src="{{ asset('/image/sp1.png') }}" alt="{{ $product->name }}" class="img-fluid">
                            @endif
                            </a>

                            <!-- Only show discount badge if product has actual sale price -->
                            @if($product->sale_price && $product->sale_price < $product->price)
                            <span class="discount-badge">
                                -{{ $product->discount_percentage }}%
                            </span>
                            @endif

                            @if($product->is_featured)
                            <span class="featured-badge">
                                <i class="fas fa-star"></i>
                            </span>
                            @endif

                            <!-- Deal countdown timer (optional) -->
                            <div class="deal-timer">
                                <i class="fas fa-clock"></i>
                                <span class="timer-text">Còn {{ rand(1, 23) }}h{{ rand(10, 59) }}p</span>
                            </div>
                        </div>

                        <div class="product-content">
                            <div class="product-brand">{{ $product->brand->name ?? 'SuperWin' }}</div>
                            <h6 class="product-name">
                                <a href="{{ route('products.show', $product->slug ?? $product->id) }}">
                                    {{ $product->name }}
                                </a>
                            </h6>

                            <div class="product-rating">
                                @for($i = 1; $i <= 5; $i++)
                                <i class="fas fa-star {{ $i <= ($product->rating_average ?? 4) ? 'text-warning' : 'text-muted' }}"></i>
                                @endfor
                                <span class="rating-count">({{ $product->rating_count ?? rand(10, 500) }})</span>
                            </div>

                            <div class="product-price">
                                @if($product->sale_price && $product->sale_price < $product->price)
                                    <!-- Có giá sale -->
                                    <span class="sale-price">{{ number_format($product->sale_price) }}đ</span>
                                    <span class="original-price">{{ number_format($product->price) }}đ</span>
                                    <div class="savings">Tiết kiệm: {{ number_format($product->price - $product->sale_price) }}đ</div>
                                @else
                                    <!-- Không có giá sale, chỉ hiển thị giá chính -->
                                    <span class="sale-price">{{ number_format($product->price) }}đ</span>
                                @endif
                            </div>

                            <a href="{{ route('products.show', $product->slug ?? $product->id) }}" class="product-btn" style="text-decoration: none; display: block; text-align: center;">
                                <i class="fas fa-shopping-cart me-2"></i>Mua Ngay
                            </a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="pagination-wrapper">
                <div class="pagination-info">
                    <p class="text-muted small mb-3">
                        Hiển thị {{ $products->firstItem() }}-{{ $products->lastItem() }} trong {{ $products->total() }} sản phẩm khuyến mãi
                    </p>
                </div>
                @if($products->hasPages())
                <nav class="custom-pagination">
                    <ul class="pagination">
                        {{-- Previous Page Link --}}
                        @if ($products->onFirstPage())
                            <li class="page-item disabled">
                                <span class="page-link">‹</span>
                            </li>
                        @else
                            <li class="page-item">
                                <a class="page-link" href="{{ $products->appends(request()->query())->previousPageUrl() }}" rel="prev">‹</a>
                            </li>
                        @endif

                        {{-- Pagination Elements --}}
                        @php
                            $start = max(1, $products->currentPage() - 2);
                            $end = min($products->lastPage(), $products->currentPage() + 2);
                        @endphp

                        @if($start > 1)
                            <li class="page-item">
                                <a class="page-link" href="{{ $products->appends(request()->query())->url(1) }}">1</a>
                            </li>
                            @if($start > 2)
                                <li class="page-item disabled">
                                    <span class="page-link">...</span>
                                </li>
                            @endif
                        @endif

                        @for($page = $start; $page <= $end; $page++)
                            @if ($page == $products->currentPage())
                                <li class="page-item active">
                                    <span class="page-link">{{ $page }}</span>
                                </li>
                            @else
                                <li class="page-item">
                                    <a class="page-link" href="{{ $products->appends(request()->query())->url($page) }}">{{ $page }}</a>
                                </li>
                            @endif
                        @endfor

                        @if($end < $products->lastPage())
                            @if($end < $products->lastPage() - 1)
                                <li class="page-item disabled">
                                    <span class="page-link">...</span>
                                </li>
                            @endif
                            <li class="page-item">
                                <a class="page-link" href="{{ $products->appends(request()->query())->url($products->lastPage()) }}">{{ $products->lastPage() }}</a>
                            </li>
                        @endif

                        {{-- Next Page Link --}}
                        @if ($products->hasMorePages())
                            <li class="page-item">
                                <a class="page-link" href="{{ $products->appends(request()->query())->nextPageUrl() }}" rel="next">›</a>
                            </li>
                        @else
                            <li class="page-item disabled">
                                <span class="page-link">›</span>
                            </li>
                        @endif
                    </ul>
                </nav>
                @endif
            </div>
            @else
            <div class="empty-state">
                <i class="fas fa-percentage"></i>
                <h5>Không có sản phẩm khuyến mãi nào</h5>
                <p>Hiện tại không có sản phẩm nào phù hợp với bộ lọc của bạn</p>
                <div class="mt-3">
                    <a href="{{ route('deals') }}" class="btn btn-danger me-2">Xem tất cả deal</a>
                    <a href="{{ route('home') }}" class="btn btn-outline-primary">Về trang chủ</a>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>

<!-- Suggested Products Section -->
@if(isset($suggestedProducts) && $suggestedProducts->count() > 0)
<section class="py-5">
    <div class="container">
        <div class="suggested-section-wrapper">
            <div class="text-center mb-4">
                <h3 class="fw-bold text-danger mb-2">
                    <i class="fas fa-fire me-2"></i>Deal Hot Khác
                </h3>
                <p class="text-muted small mb-0">Các sản phẩm khuyến mãi khác có thể bạn quan tâm</p>
            </div>

            <div class="suggested-products-grid">
                @foreach($suggestedProducts->take(10) as $product)
                <div class="suggested-product-item">
                    <div class="suggested-product-card"
                         data-product-id="{{ $product->id }}"
                         data-product-name="{{ $product->name }}"
                         data-product-model="{{ $product->sku ?? 'SW-' . $product->id }}"
                         data-product-price="{{ ($product->sale_price && $product->sale_price < $product->price) ? $product->sale_price : $product->price }}"
                         data-product-image="{{ $product->displayImage ? asset($product->displayImage->url) : asset('/image/sp1.png') }}">
                        <div class="suggested-product-image">
                            <a href="{{ route('products.show', $product->slug ?? $product->id) }}">
                                @if($product->displayImage && $product->displayImage->url)
                                <img src="{{ asset($product->displayImage->url) }}" alt="{{ $product->name }}" class="img-fluid">
                                @else
                                <img src="{{ asset('/image/sp1.png') }}" alt="{{ $product->name }}" class="img-fluid">
                                @endif
                            </a>

                            @if($product->sale_price && $product->sale_price < $product->price)
                            <span class="suggested-discount-badge">
                                -{{ $product->discount_percentage }}%
                            </span>
                            @endif
                        </div>

                        <div class="suggested-product-content">
                            <h6 class="suggested-product-name">{{ $product->name }}</h6>

                            <div class="suggested-price-section">
                                @if($product->sale_price && $product->sale_price < $product->price)
                                    <!-- Có giá sale -->
                                    <div class="suggested-sale-price">{{ number_format($product->sale_price) }}đ</div>
                                    <div class="suggested-original-price">{{ number_format($product->price) }}đ</div>
                                @else
                                    <!-- Không có giá sale, chỉ hiển thị giá chính -->
                                    <div class="suggested-sale-price">{{ number_format($product->price) }}đ</div>
                                @endif
                            </div>

                            <div class="suggested-rating">
                                @for($i = 1; $i <= 5; $i++)
                                <i class="fas fa-star {{ $i <= ($product->rating_average ?? 4) ? 'text-warning' : 'text-muted' }}"></i>
                                @endfor
                                <span class="suggested-rating-count">({{ $product->rating_count ?? rand(10, 100) }})</span>
                            </div>

                            <a href="{{ route('products.show', $product->slug ?? $product->id) }}" class="suggested-buy-btn" style="text-decoration: none; display: block; text-align: center;">
                                Mua Ngay
                            </a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <div class="text-center mt-4">
                <a href="{{ route('products.index') }}" class="suggested-view-more-btn">
                    Xem thêm sản phẩm
                </a>
            </div>
        </div>
    </div>
</section>
@endif

<!-- Mobile Filter Offcanvas -->
<div class="offcanvas offcanvas-start mobile-filter-offcanvas" tabindex="-1" id="dealFilterOffcanvas" aria-labelledby="dealFilterOffcanvasLabel">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="dealFilterOffcanvasLabel">
            <i class="fas fa-filter me-2"></i>Bộ lọc Flash Deal
        </h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <!-- Deal Stats Section -->
        <div class="filter-section deal-intro">
            <div class="deal-header">
                <div class="deal-logo">
                    <i class="fas fa-fire text-danger fa-3x"></i>
                </div>
                <h5 class="deal-title">FLASH DEAL</h5>
                <p class="deal-subtitle">Khuyến mãi cực hot</p>
            </div>
        </div>

        <!-- Category Filter -->
        @if($categories->count() > 0)
        <div class="filter-section">
            <h6 class="filter-subtitle">DANH MỤC</h6>
            <div class="filter-content">
                @foreach($categories as $category)
                <div class="form-check">
                    <input class="form-check-input" type="radio" value="{{ $category->id }}" id="mobile-cat{{ $category->id }}" name="category_id" {{ request('category_id') == $category->id ? 'checked' : '' }}>
                    <label class="form-check-label" for="mobile-cat{{ $category->id }}">
                        {{ $category->name }} <span class="text-muted">({{ $category->products_count }})</span>
                    </label>
                </div>
                @endforeach
                <div class="form-check">
                    <input class="form-check-input" type="radio" value="" id="mobile-catAll" name="category_id" {{ !request('category_id') ? 'checked' : '' }}>
                    <label class="form-check-label" for="mobile-catAll">Tất cả danh mục</label>
                </div>
            </div>
        </div>
        @endif

        <!-- Brand Filter -->
        @if($brands->count() > 0)
        <div class="filter-section">
            <h6 class="filter-subtitle">THƯƠNG HIỆU</h6>
            <div class="filter-content">
                @foreach($brands as $brand)
                <div class="form-check">
                    <input class="form-check-input" type="radio" value="{{ $brand->id }}" id="mobile-brand{{ $brand->id }}" name="brand_id" {{ request('brand_id') == $brand->id ? 'checked' : '' }}>
                    <label class="form-check-label" for="mobile-brand{{ $brand->id }}">
                        {{ $brand->name }} <span class="text-muted">({{ $brand->products_count }})</span>
                    </label>
                </div>
                @endforeach
                <div class="form-check">
                    <input class="form-check-input" type="radio" value="" id="mobile-brandAll" name="brand_id" {{ !request('brand_id') ? 'checked' : '' }}>
                    <label class="form-check-label" for="mobile-brandAll">Tất cả thương hiệu</label>
                </div>
            </div>
        </div>
        @endif

        <!-- Price Filter -->
        <div class="filter-section">
            <h6 class="filter-subtitle">KHOẢNG GIÁ</h6>
            <div class="filter-content">
                <div class="form-check">
                    <input class="form-check-input" type="radio" value="0-1000000" id="mobile-price1" name="price_range" {{ request('price_range') == '0-1000000' ? 'checked' : '' }}>
                    <label class="form-check-label" for="mobile-price1">Dưới 1.000.000đ</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" value="1000000-3000000" id="mobile-price2" name="price_range" {{ request('price_range') == '1000000-3000000' ? 'checked' : '' }}>
                    <label class="form-check-label" for="mobile-price2">1.000.000đ - 3.000.000đ</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" value="3000000-5000000" id="mobile-price3" name="price_range" {{ request('price_range') == '3000000-5000000' ? 'checked' : '' }}>
                    <label class="form-check-label" for="mobile-price3">3.000.000đ - 5.000.000đ</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" value="5000000-10000000" id="mobile-price4" name="price_range" {{ request('price_range') == '5000000-10000000' ? 'checked' : '' }}>
                    <label class="form-check-label" for="mobile-price4">5.000.000đ - 10.000.000đ</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" value="10000000+" id="mobile-price5" name="price_range" {{ request('price_range') == '10000000+' ? 'checked' : '' }}>
                    <label class="form-check-label" for="mobile-price5">Trên 10.000.000đ</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" value="" id="mobile-priceAll" name="price_range" {{ !request('price_range') ? 'checked' : '' }}>
                    <label class="form-check-label" for="mobile-priceAll">Tất cả</label>
                </div>
            </div>
        </div>

        <!-- Discount Filter -->
        <div class="filter-section">
            <h6 class="filter-subtitle">MỨC GIẢM GIÁ</h6>
            <div class="filter-content">
                <div class="form-check">
                    <input class="form-check-input" type="radio" value="10-30" id="mobile-discount1" name="discount_range" {{ request('discount_range') == '10-30' ? 'checked' : '' }}>
                    <label class="form-check-label" for="mobile-discount1">10% - 30%</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" value="30-50" id="mobile-discount2" name="discount_range" {{ request('discount_range') == '30-50' ? 'checked' : '' }}>
                    <label class="form-check-label" for="mobile-discount2">30% - 50%</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" value="50+" id="mobile-discount3" name="discount_range" {{ request('discount_range') == '50+' ? 'checked' : '' }}>
                    <label class="form-check-label" for="mobile-discount3">Trên 50%</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" value="" id="mobile-discountAll" name="discount_range" {{ !request('discount_range') ? 'checked' : '' }}>
                    <label class="form-check-label" for="mobile-discountAll">Tất cả</label>
                </div>
            </div>
        </div>

        <!-- Product Type Filter -->
        <div class="filter-section">
            <h6 class="filter-subtitle">LOẠI SẢN PHẨM</h6>
            <div class="filter-content">
                <div class="form-check">
                    <input class="form-check-input" type="radio" value="featured" id="mobile-featured" name="filter" {{ request('filter') == 'featured' ? 'checked' : '' }}>
                    <label class="form-check-label" for="mobile-featured">Sản phẩm nổi bật</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" value="new" id="mobile-new" name="filter" {{ request('filter') == 'new' ? 'checked' : '' }}>
                    <label class="form-check-label" for="mobile-new">Sản phẩm mới</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" value="high_discount" id="mobile-high_discount" name="filter" {{ request('filter') == 'high_discount' ? 'checked' : '' }}>
                    <label class="form-check-label" for="mobile-high_discount">Giảm giá sốc (≥50%)</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" value="" id="mobile-filterAll" name="filter" {{ !request('filter') ? 'checked' : '' }}>
                    <label class="form-check-label" for="mobile-filterAll">Tất cả</label>
                </div>
            </div>
        </div>

        <!-- Filter Actions -->
        <div class="filter-actions">
            <button type="button" class="btn btn-primary btn-sm w-100 mb-2" onclick="applyMobileFilters()">
                <i class="fas fa-filter me-2"></i>Áp dụng
            </button>
            <a href="{{ route('deals') }}" class="btn btn-outline-secondary btn-sm w-100">
                <i class="fas fa-refresh me-2"></i>Xóa bộ lọc
            </a>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
// Filter functionality
document.addEventListener('DOMContentLoaded', function() {
    // Quick filter buttons
    const quickFilterBtns = document.querySelectorAll('.quick-filter-btn');
    quickFilterBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            quickFilterBtns.forEach(b => b.classList.remove('active'));
            this.classList.add('active');

            const filter = this.getAttribute('data-filter');
            filterProducts(filter);
        });
    });

    // Sort functionality
    const sortSelect = document.getElementById('sortBy');
    sortSelect.addEventListener('change', function() {
        const sortBy = this.value;
        sortProducts(sortBy);
    });

    // Per page functionality
    const perPageSelect = document.getElementById('perPage');
    perPageSelect.addEventListener('change', function() {
        const perPage = this.value;
        changePerPage(perPage);
    });

    // Mobile sort functionality
    const mobileSortSelect = document.getElementById('mobileSortBy');
    if (mobileSortSelect) {
        mobileSortSelect.addEventListener('change', function() {
            const sortBy = this.value;
            sortProducts(sortBy);
        });
    }
});

function applyFilters() {
    const url = new URL(window.location);
    
    // Get selected category
    const selectedCategory = document.querySelector('input[name="category_id"]:checked');
    if (selectedCategory && selectedCategory.value) {
        url.searchParams.set('category_id', selectedCategory.value);
    } else {
        url.searchParams.delete('category_id');
    }
    
    // Get selected brand
    const selectedBrand = document.querySelector('input[name="brand_id"]:checked');
    if (selectedBrand && selectedBrand.value) {
        url.searchParams.set('brand_id', selectedBrand.value);
    } else {
        url.searchParams.delete('brand_id');
    }
    
    // Get selected price range
    const selectedPrice = document.querySelector('input[name="price_range"]:checked');
    if (selectedPrice && selectedPrice.value) {
        url.searchParams.set('price_range', selectedPrice.value);
    } else {
        url.searchParams.delete('price_range');
    }
    
    // Get selected discount range
    const selectedDiscount = document.querySelector('input[name="discount_range"]:checked');
    if (selectedDiscount && selectedDiscount.value) {
        url.searchParams.set('discount_range', selectedDiscount.value);
    } else {
        url.searchParams.delete('discount_range');
    }
    
    // Get selected filter
    const selectedFilter = document.querySelector('input[name="filter"]:checked');
    if (selectedFilter && selectedFilter.value) {
        url.searchParams.set('filter', selectedFilter.value);
    } else {
        url.searchParams.delete('filter');
    }
    
    url.searchParams.delete('page'); // Reset to first page
    window.location.href = url.toString();
}

function filterProducts(filter) {
    const url = new URL(window.location);
    
    switch(filter) {
        case 'featured':
            url.searchParams.set('filter', 'featured');
            break;
        case 'high_discount':
            url.searchParams.set('filter', 'high_discount');
            break;
        case 'new':
            url.searchParams.set('filter', 'new');
            break;
        case 'bestseller':
            url.searchParams.set('sort_by', 'bestseller');
            url.searchParams.delete('filter');
            break;
        case 'all':
        default:
            url.searchParams.delete('filter');
            break;
    }
    
    url.searchParams.delete('page'); // Reset to first page
    window.location.href = url.toString();
}

function sortProducts(sortBy) {
    const url = new URL(window.location);
    url.searchParams.set('sort_by', sortBy);
    url.searchParams.delete('page'); // Reset to first page
    window.location.href = url.toString();
}

function changePerPage(perPage) {
    const url = new URL(window.location);
    url.searchParams.set('per_page', perPage);
    url.searchParams.delete('page'); // Reset to first page
    window.location.href = url.toString();
}

function applyMobileFilters() {
    const url = new URL(window.location);
    
    // Get selected category from mobile filter
    const selectedCategory = document.querySelector('#dealFilterOffcanvas input[name="category_id"]:checked');
    if (selectedCategory && selectedCategory.value) {
        url.searchParams.set('category_id', selectedCategory.value);
    } else {
        url.searchParams.delete('category_id');
    }
    
    // Get selected brand from mobile filter
    const selectedBrand = document.querySelector('#dealFilterOffcanvas input[name="brand_id"]:checked');
    if (selectedBrand && selectedBrand.value) {
        url.searchParams.set('brand_id', selectedBrand.value);
    } else {
        url.searchParams.delete('brand_id');
    }
    
    // Get selected price range from mobile filter
    const selectedPrice = document.querySelector('#dealFilterOffcanvas input[name="price_range"]:checked');
    if (selectedPrice && selectedPrice.value) {
        url.searchParams.set('price_range', selectedPrice.value);
    } else {
        url.searchParams.delete('price_range');
    }
    
    // Get selected discount range from mobile filter
    const selectedDiscount = document.querySelector('#dealFilterOffcanvas input[name="discount_range"]:checked');
    if (selectedDiscount && selectedDiscount.value) {
        url.searchParams.set('discount_range', selectedDiscount.value);
    } else {
        url.searchParams.delete('discount_range');
    }
    
    // Get selected filter from mobile filter
    const selectedFilter = document.querySelector('#dealFilterOffcanvas input[name="filter"]:checked');
    if (selectedFilter && selectedFilter.value) {
        url.searchParams.set('filter', selectedFilter.value);
    } else {
        url.searchParams.delete('filter');
    }
    
    url.searchParams.delete('page'); // Reset to first page
    window.location.href = url.toString();
}

// Deal countdown timers (optional enhancement)
function startDealTimers() {
    const timers = document.querySelectorAll('.timer-text');
    timers.forEach(timer => {
        // Simple random countdown for demo
        const hours = Math.floor(Math.random() * 24);
        const minutes = Math.floor(Math.random() * 60);
        timer.textContent = `Còn ${hours}h${minutes}p`;
    });
}

// Initialize timers
startDealTimers();
</script>
@endpush
    
@push('styles')
<style>
/* Deal Page Styles - Extended from Brand Page */
.category-sidebar {
    background: white;
    border-radius: 12px;
    box-shadow: 0 2px 12px rgba(0, 0, 0, 0.08);
    padding: 20px;
    position: sticky;
    top: 20px;
}

.filter-section {
    border-bottom: 1px solid #eee;
    padding-bottom: 20px;
    margin-bottom: 20px;
}

.filter-section:last-child {
    border-bottom: none;
    margin-bottom: 0;
}

/* Deal Introduction Styles */
.deal-intro {
    background: linear-gradient(135deg, #ff6b35, #f7931e);
    border-radius: 12px;
    padding: 25px;
    text-align: center;
    border: none;
    box-shadow: 0 4px 15px rgba(255, 107, 53, 0.3);
    color: white;
}

.deal-header {
    margin-bottom: 15px;
}

.deal-logo {
    margin-bottom: 10px;
}

.deal-title {
    color: white;
    font-weight: 700;
    font-size: 1.4rem;
    margin-bottom: 5px;
    text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
}

.deal-subtitle {
    color: rgba(255, 255, 255, 0.9);
    font-size: 0.9rem;
    margin: 0;
}

.deal-stats {
    display: flex;
    justify-content: space-between;
    gap: 10px;
}

.stat-item {
    text-align: center;
    padding: 10px 8px;
    background: rgba(255, 255, 255, 0.2);
    border-radius: 8px;
    border: 1px solid rgba(255, 255, 255, 0.3);
    flex: 1;
}

.stat-item strong {
    display: block;
    font-size: 1.1rem;
    font-weight: 700;
    color: white;
    margin-bottom: 2px;
}

.stat-item span {
    font-size: 0.75rem;
    color: rgba(255, 255, 255, 0.9);
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.filter-subtitle {
    color: #7f8c8d;
    font-weight: 600;
    font-size: 0.9rem;
    margin-bottom: 12px;
}

.filter-content .form-check {
    margin-bottom: 8px;
}

.filter-content .form-check-label {
    font-size: 0.9rem;
    color: #34495e;
    cursor: pointer;
}

.filter-actions {
    margin-top: 20px;
}

.category-header {
    background: white;
    border-radius: 12px;
    box-shadow: 0 2px 12px rgba(0, 0, 0, 0.08);
    padding: 20px;
    margin-bottom: 20px;
}

.category-title {
    color: #2c3e50;
    font-weight: 700;
    margin-bottom: 5px;
}

.category-subtitle {
    color: #7f8c8d;
    font-size: 0.9rem;
    margin: 0;
}

.sort-options .form-select {
    border: 1px solid #ddd;
    border-radius: 8px;
    padding: 8px 12px;
    font-size: 0.9rem;
    min-width: 140px;
    background-color: white;
    transition: all 0.3s ease;
}

.sort-options .form-select:focus {
    border-color: #ff6b35;
    box-shadow: 0 0 0 0.2rem rgba(255, 107, 53, 0.25);
}

.quick-filters {
    display: flex;
    gap: 10px;
    flex-wrap: wrap;
}

.quick-filter-btn {
    background: #f8f9fa;
    border: 1px solid #dee2e6;
    border-radius: 20px;
    padding: 8px 16px;
    font-size: 0.85rem;
    font-weight: 500;
    color: #6c757d;
    cursor: pointer;
    transition: all 0.3s ease;
}

.quick-filter-btn:hover,
.quick-filter-btn.active {
    background: #ff6b35;
    border-color: #ff6b35;
    color: white;
}

.products-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
    gap: 20px;
    margin-bottom: 30px;
}

.product-card {
    background: white;
    border-radius: 12px;
    box-shadow: 0 2px 12px rgba(0, 0, 0, 0.08);
    overflow: hidden;
    transition: all 0.3s ease;
    height: 100%;
    border: 1px solid #f0f0f0;
    position: relative;
}

.product-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
}

.product-image {
    position: relative;
    height: 200px;
    overflow: hidden;
    background: #f8f9fa;
    display: flex;
    align-items: center;
    justify-content: center;
}

.product-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.3s ease;
}

.product-card:hover .product-image img {
    transform: scale(1.05);
}

.discount-badge {
    position: absolute;
    top: 8px;
    right: 8px;
    background: linear-gradient(135deg, #ff6b35, #f7931e);
    color: white;
    padding: 4px 8px;
    border-radius: 12px;
    font-size: 0.75rem;
    font-weight: 600;
    z-index: 2;
}

.featured-badge {
    position: absolute;
    top: 8px;
    left: 8px;
    background: #f39c12;
    color: white;
    padding: 4px 8px;
    border-radius: 12px;
    font-size: 0.75rem;
    z-index: 2;
}

.deal-timer {
    position: absolute;
    bottom: 8px;
    left: 8px;
    background: rgba(0, 0, 0, 0.7);
    color: white;
    padding: 4px 8px;
    border-radius: 12px;
    font-size: 0.7rem;
    display: flex;
    align-items: center;
    gap: 4px;
}

.product-content {
    padding: 15px;
    text-align: center;
}

.product-brand {
    font-size: 0.75rem;
    color: #7f8c8d;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    margin-bottom: 5px;
}

.product-name {
    font-size: 0.9rem;
    font-weight: 600;
    margin-bottom: 8px;
    line-height: 1.3;
    height: 2.34em;
    overflow: hidden;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    line-clamp: 2;
}

.product-name a {
    color: #2c3e50;
    text-decoration: none;
}

.product-name a:hover {
    color: #ff6b35;
}

.product-rating {
    margin-bottom: 8px;
    font-size: 0.8rem;
}

.rating-count {
    color: #95a5a6;
    margin-left: 4px;
    font-size: 0.75rem;
}

.product-price {
    margin-bottom: 12px;
}

.sale-price {
    font-size: 1.1rem;
    font-weight: 700;
    color: #e74c3c;
    margin-right: 8px;
}

.original-price {
    font-size: 0.8rem;
    color: #95a5a6;
    text-decoration: line-through;
    display: block;
    margin-top: 2px;
}

.savings {
    font-size: 0.75rem;
    color: #27ae60;
    font-weight: 600;
    margin-top: 4px;
}

.product-btn {
    background: linear-gradient(135deg, #ff6b35, #f7931e);
    color: white;
    border: none;
    padding: 10px 16px;
    border-radius: 20px;
    font-size: 0.8rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    width: 100%;
}

.product-btn:hover {
    background: linear-gradient(135deg, #f7931e, #e67e22);
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(255, 107, 53, 0.3);
    color: white;
}

.empty-state {
    text-align: center;
    padding: 60px 20px;
    color: #7f8c8d;
}

.empty-state i {
    font-size: 4rem;
    margin-bottom: 20px;
    color: #ff6b35;
}

.pagination-wrapper {
    display: flex;
    flex-direction: column;
    align-items: center;
    margin-top: 30px;
}

.pagination-info {
    text-align: center;
    margin-bottom: 10px;
}

/* Custom Pagination Styles */
.custom-pagination .pagination {
    gap: 8px;
    display: inline-flex;
    align-items: center;
    margin: 0;
    padding: 0;
    list-style: none;
}

.custom-pagination .page-item {
    margin: 0;
}

.custom-pagination .page-link {
    border: none;
    border-radius: 4px;
    padding: 8px 12px;
    color: #666;
    text-decoration: none;
    margin: 0;
    transition: all 0.2s ease;
    font-weight: 400;
    background: transparent;
    min-width: 35px;
    text-align: center;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    font-size: 14px;
}

.custom-pagination .page-link:hover {
    background-color: #f0f0f0;
    color: #333;
    text-decoration: none;
}

.custom-pagination .page-item.active .page-link {
    background-color: #ff6b35;
    color: white;
    font-weight: 500;
}

.custom-pagination .page-item.disabled .page-link {
    background-color: transparent;
    color: #ccc;
    cursor: not-allowed;
}

/* Suggested Products Styles (reuse from search) */
.suggested-section-wrapper {
    background: white;
    border-radius: 16px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    padding: 30px;
    border: 1px solid rgba(0, 0, 0, 0.05);
    transition: all 0.3s ease;
}

.suggested-products-grid {
    display: grid;
    grid-template-columns: repeat(5, 1fr);
    gap: 20px;
    margin-bottom: 20px;
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
    background: linear-gradient(135deg, #ff6b35, #f7931e);
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
    background: linear-gradient(135deg, #f7931e, #e67e22);
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(255, 107, 53, 0.3);
    color: white;
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
    text-decoration: none;
    display: inline-block;
}

.suggested-view-more-btn:hover {
    background: linear-gradient(135deg, #00f2fe, #4facfe);
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(79, 172, 254, 0.3);
    color: white;
    text-decoration: none;
}

/* Mobile Filter Section */
.mobile-filter-section {
    background: white;
    border-radius: 12px;
    box-shadow: 0 2px 12px rgba(0, 0, 0, 0.08);
    padding: 15px;
    border: 1px solid rgba(0, 0, 0, 0.05);
    position: relative;
    z-index: 10;
    margin-top: 10px;
    display: block;
}

/* Hide on desktop */
@media (min-width: 992px) {
    .mobile-filter-section {
        display: none !important;
    }
}

.mobile-filter-btn {
    background: linear-gradient(135deg, #ff6b35, #f7931e);
    color: white;
    border: none;
    padding: 12px 20px;
    border-radius: 8px;
    font-weight: 600;
    font-size: 0.9rem;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    box-shadow: 0 2px 8px rgba(255, 107, 53, 0.2);
}

.mobile-filter-btn:hover {
    background: linear-gradient(135deg, #f7931e, #e67e22);
    transform: translateY(-2px);
    box-shadow: 0 4px 15px rgba(255, 107, 53, 0.4);
    color: white;
}

.mobile-filter-btn i {
    font-size: 1rem;
}

.mobile-sort-options {
    min-width: 140px;
}

.mobile-sort-options .form-select {
    border: 1px solid #ddd;
    border-radius: 8px;
    padding: 8px 12px;
    font-size: 0.85rem;
    background: white;
    transition: all 0.3s ease;
}

.mobile-sort-options .form-select:focus {
    border-color: #ff6b35;
    box-shadow: 0 0 0 0.2rem rgba(255, 107, 53, 0.25);
}

/* Offcanvas Customization */
.mobile-filter-offcanvas {
    width: 320px !important;
    box-shadow: 2px 0 15px rgba(0, 0, 0, 0.1);
    z-index: 1055 !important;
}

.mobile-filter-offcanvas .offcanvas-header {
    background: linear-gradient(135deg, #ff6b35, #f7931e);
    color: white;
    border-bottom: none;
    padding: 20px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
}

.mobile-filter-offcanvas .offcanvas-title {
    font-weight: 700;
    font-size: 1.1rem;
    margin: 0;
}

.mobile-filter-offcanvas .offcanvas-body {
    padding: 20px;
    background: #f8f9fa;
}

.mobile-filter-offcanvas .filter-section {
    background: white;
    border-radius: 12px;
    padding: 18px;
    margin-bottom: 15px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
    border: 1px solid rgba(0, 0, 0, 0.05);
}

.mobile-filter-offcanvas .filter-section:last-child {
    margin-bottom: 0;
}

.mobile-filter-offcanvas .filter-subtitle {
    color: #ff6b35;
    font-weight: 600;
    font-size: 0.9rem;
    margin-bottom: 12px;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.mobile-filter-offcanvas .form-check {
    margin-bottom: 10px;
    padding-left: 1.8em;
}

.mobile-filter-offcanvas .form-check-input {
    margin-left: -1.8em;
    border: 2px solid #dee2e6;
    border-radius: 4px;
    transition: all 0.2s ease;
}

.mobile-filter-offcanvas .form-check-input:checked {
    background-color: #ff6b35;
    border-color: #ff6b35;
}

.mobile-filter-offcanvas .form-check-label {
    font-size: 0.9rem;
    color: #495057;
    cursor: pointer;
    font-weight: 500;
}

.mobile-filter-offcanvas .form-check-label:hover {
    color: #ff6b35;
}

.mobile-filter-offcanvas .filter-actions {
    margin-top: 25px;
    padding-top: 20px;
    border-top: 1px solid #dee2e6;
}

.mobile-filter-offcanvas .filter-actions .btn {
    font-weight: 600;
    border-radius: 8px;
    padding: 12px 20px;
    transition: all 0.3s ease;
}

.mobile-filter-offcanvas .filter-actions .btn-primary {
    background: linear-gradient(135deg, #ff6b35, #f7931e);
    border: none;
    box-shadow: 0 2px 8px rgba(255, 107, 53, 0.3);
}

.mobile-filter-offcanvas .filter-actions .btn-primary:hover {
    background: linear-gradient(135deg, #f7931e, #e67e22);
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(255, 107, 53, 0.4);
}

.mobile-filter-offcanvas .filter-actions .btn-outline-secondary {
    border: 2px solid #6c757d;
    color: #6c757d;
}

.mobile-filter-offcanvas .filter-actions .btn-outline-secondary:hover {
    background: #6c757d;
    border-color: #6c757d;
    color: white;
}

/* Header Layout Updates */
.header-top {
    text-align: center;
}

.header-controls {
    border-top: 1px solid #eee;
    padding-top: 15px;
    gap: 15px;
}

@media (max-width: 991px) {
    .header-controls {
        flex-direction: column !important;
        align-items: center !important;
        gap: 15px;
    }
    
    .quick-filters {
        justify-content: center;
        width: 100%;
        align-items: center;
    }
    
    .sort-options {
        display: none !important;
    }
}

.quick-filters {
    align-items: center;
}

.quick-filter-btn {
    height: 38px;
}

.sort-options .form-select {
    height: 38px;
}

/* Responsive */
@media (max-width: 1200px) {
    .suggested-products-grid {
        grid-template-columns: repeat(4, 1fr);
    }
}

@media (max-width: 992px) {
    .suggested-products-grid {
        grid-template-columns: repeat(3, 1fr);
    }
    
    .products-grid {
        grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
        gap: 16px;
    }
    
    .category-sidebar {
        position: static;
        margin-bottom: 20px;
    }
}

@media (max-width: 768px) {
    .suggested-products-grid,
    .products-grid {
        grid-template-columns: repeat(2, 1fr);
        gap: 15px;
    }
    
    .category-header {
        padding: 15px;
    }
    
    .quick-filters {
        justify-content: center;
    }
    
    .d-flex.justify-content-between {
        flex-direction: row !important;
        gap: 15px;
    }
    
    .deal-stats {
        flex-direction: column;
        gap: 10px;
    }

    .container-fluid {
        padding-top: 80px !important;
    }

    .mobile-filter-section {
        padding: 12px;
        margin-bottom: 15px;
    }
    
    .mobile-filter-section .d-flex {
        flex-wrap: nowrap;
        align-items: center;
        justify-content: space-between;
    }

    .mobile-filter-btn {
        padding: 10px 16px;
        font-size: 0.85rem;
    }

    .mobile-sort-options {
        min-width: 120px;
    }

    .mobile-sort-options .form-select {
        padding: 6px 10px;
        font-size: 0.8rem;
    }

    .mobile-filter-offcanvas {
        width: 280px !important;
    }

    .mobile-filter-offcanvas .offcanvas-body {
        padding: 15px;
    }

    .mobile-filter-offcanvas .filter-section {
        padding: 15px;
        margin-bottom: 12px;
    }

    .mobile-filter-offcanvas .filter-subtitle {
        font-size: 0.85rem;
        margin-bottom: 10px;
    }
}

@media (max-width: 576px) {
    .suggested-products-grid,
    .products-grid {
        grid-template-columns: repeat(2, 1fr);
        gap: 12px;
    }
    
    .category-header {
        text-align: center;
    }
    
    .deal-stats .stat-item {
        padding: 8px;
    }

    .container-fluid {
        padding-top: 5px !important;
    }
}

/* Base styles cho container-fluid */
.container-fluid {
  width: 1320px;
  margin: 20px auto;
  max-width: 100%;
  box-sizing: border-box;
  padding: 0 20px;
}

/* Desktop nhỏ và Laptop lớn (1024px - 1439px) */
@media screen and (min-width: 1024px) and (max-width: 1439px) {
  .container-fluid {
    width: 95%;
    max-width: 1200px;
    margin: 20px auto;
  }
}

/* Desktop trung bình (1440px - 1679px) */
@media screen and (min-width: 1440px) and (max-width: 1679px) {
  .container-fluid {
    width: 1320px;
    margin: 15px auto;
  }
}

/* Desktop lớn và màn hình wide (1680px - 1919px) */
@media screen and (min-width: 1680px) and (max-width: 1919px) {
  .container-fluid {
    width: 1400px;
    margin: 40px auto;
  }
}

/* Màn hình 2K (1920px - 2559px) */
@media screen and (min-width: 1920px) and (max-width: 2559px) {
  .container-fluid {
    width: 1600px;
    margin: 50px auto;
  }
}

/* Màn hình 4K và siêu lớn (2560px+) */
@media screen and (min-width: 2560px) {
  .container-fluid {
    width: 2000px;
    margin: 60px auto;
  }
}
</style>
@endpush