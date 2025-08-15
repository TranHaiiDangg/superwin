@extends('layouts.app')

@section('title', 'Tìm kiếm: "' . $query . '" - SuperWin')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <!-- Sidebar Filter (Desktop) -->
        <div class="col-lg-3 col-md-4 d-none d-md-block">
            <div class="category-sidebar">
                <!-- Search Info -->
                <div class="filter-section">
                    <h5 class="filter-title">KẾT QUẢ TÌM KIẾM</h5>
                    <div class="search-query">
                        <strong>"{{ $query }}"</strong>
                            </div>
                    <div class="search-count">
                        {{ $products->total() }} sản phẩm
                    </div>
                    </div>

                <!-- Category Filter -->
                    @if($categories->count() > 0)
                <div class="filter-section">
                    <h6 class="filter-subtitle">DANH MỤC</h6>
                    <div class="filter-content">
                            @foreach($categories as $category)
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="{{ $category->id }}" id="cat{{ $category->id }}" name="category_id" {{ request('category_id') == $category->id ? 'checked' : '' }}>
                            <label class="form-check-label" for="cat{{ $category->id }}">
                                {{ $category->name }}
                            </label>
                        </div>
                        @endforeach
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
                            <input class="form-check-input" type="checkbox" value="{{ $brand->id }}" id="brand{{ $brand->id }}" name="brand_id" {{ request('brand_id') == $brand->id ? 'checked' : '' }}>
                            <label class="form-check-label" for="brand{{ $brand->id }}">
                                {{ $brand->name }}
                            </label>
                        </div>
                            @endforeach
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

                <!-- Filter Actions -->
                <div class="filter-actions">
                    <button type="button" class="btn btn-primary btn-sm w-100 mb-2" onclick="applyFilters()">
                        <i class="fas fa-filter me-2"></i>Áp dụng bộ lọc
                    </button>
                    <a href="{{ route('search', ['q' => $query]) }}" class="btn btn-outline-secondary btn-sm w-100">
                        <i class="fas fa-refresh me-2"></i>Xóa bộ lọc
                    </a>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="col-lg-9 col-md-8 col-12">
            <!-- Mobile Filter Button -->
            <div class="mobile-filter-section d-md-none mb-3">
                <div class="d-flex justify-content-between align-items-center">
                    <button class="mobile-filter-btn" type="button" data-bs-toggle="offcanvas" data-bs-target="#filterOffcanvas" aria-controls="filterOffcanvas">
                        <i class="fas fa-sliders-h me-2"></i>
                        <span>Bộ lọc</span>
                    </button>
                    <div class="mobile-sort-options">
                        <select class="form-select form-select-sm" id="mobileSortBy">
                            <option value="newest" {{ request('sort_by', 'newest') == 'newest' ? 'selected' : '' }}>Mới nhất</option>
                            <option value="bestseller" {{ request('sort_by') == 'bestseller' ? 'selected' : '' }}>Bán chạy</option>
                            <option value="price_low" {{ request('sort_by') == 'price_low' ? 'selected' : '' }}>Giá thấp</option>
                            <option value="price_high" {{ request('sort_by') == 'price_high' ? 'selected' : '' }}>Giá cao</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Header -->
            <div class="category-header">
                <!-- Title Section -->
                <div class="header-top mb-3">
                    <h3 class="category-title">Kết quả tìm kiếm</h3>
                    <p class="category-subtitle">Tìm kiếm: "<strong>{{ $query }}</strong>" ({{ $products->total() }} sản phẩm)</p>
                </div>

                <!-- Controls Section -->
                <div class="header-controls d-none d-md-flex justify-content-between align-items-center mb-3">
                    <!-- Quick Filters -->
                    <div class="quick-filters">
                        <button class="quick-filter-btn {{ !request('filter') && request('sort_by') != 'bestseller' ? 'active' : '' }}" data-filter="all">Tất cả</button>
                        <button class="quick-filter-btn {{ request('filter') == 'sale' ? 'active' : '' }}" data-filter="sale">Đang giảm giá</button>
                        <button class="quick-filter-btn {{ request('filter') == 'featured' ? 'active' : '' }}" data-filter="featured">Nổi bật</button>
                        <button class="quick-filter-btn {{ request('sort_by') == 'bestseller' ? 'active' : '' }}" data-filter="bestseller">Bán chạy</button>
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
                            <option value="newest" {{ request('sort_by', 'newest') == 'newest' ? 'selected' : '' }}>Mới nhất</option>
                            <option value="bestseller" {{ request('sort_by') == 'bestseller' ? 'selected' : '' }}>Bán chạy</option>
                            <option value="price_low" {{ request('sort_by') == 'price_low' ? 'selected' : '' }}>Giá thấp nhất</option>
                            <option value="price_high" {{ request('sort_by') == 'price_high' ? 'selected' : '' }}>Giá cao nhất</option>
                            <option value="name" {{ request('sort_by') == 'name' ? 'selected' : '' }}>Tên sản phẩm</option>
                        </select>
                    </div>
                </div>

                <!-- Mobile Quick Filters -->
                <div class="mobile-quick-filters d-md-none mb-3">
                    <div class="quick-filters justify-content-center">
                        <button class="quick-filter-btn {{ !request('filter') && request('sort_by') != 'bestseller' ? 'active' : '' }}" data-filter="all">Tất cả</button>
                        <button class="quick-filter-btn {{ request('filter') == 'sale' ? 'active' : '' }}" data-filter="sale">Đang giảm giá</button>
                        <button class="quick-filter-btn {{ request('filter') == 'featured' ? 'active' : '' }}" data-filter="featured">Nổi bật</button>
                        <button class="quick-filter-btn {{ request('sort_by') == 'bestseller' ? 'active' : '' }}" data-filter="bestseller">Bán chạy</button>
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
                         data-product-price="{{ $product->sale_price ?? $product->price }}"
                         data-product-image="{{ $product->displayImage ? asset($product->displayImage->url) : asset('/image/sp1.png') }}">
                        <div class="product-image">
                            <a href="{{ route('products.show', $product->slug ?? $product->id) }}">
                            @if($product->displayImage && $product->displayImage->url)
                                <img src="{{ asset($product->displayImage->url) }}" alt="{{ $product->name }}" class="img-fluid">
                            @else
                                <img src="{{ asset('/image/sp1.png') }}" alt="{{ $product->name }}" class="img-fluid">
                            @endif
                            </a>

                            @if($product->isOnSale)
                            <span class="discount-badge">
                                    -{{ $product->discount_percentage }}%
                                </span>
                            @endif

                            @if($product->is_featured)
                            <span class="featured-badge">
                                <i class="fas fa-star"></i>
                                </span>
                            @endif
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
                                    @if($product->isOnSale)
                                <span class="sale-price">{{ number_format($product->sale_price) }}đ</span>
                                <span class="original-price">{{ number_format($product->price) }}đ</span>
                                    @else
                                <span class="regular-price">{{ number_format($product->price) }}đ</span>
                                    @endif
                                </div>

                            <!-- <button class="product-btn" onclick="addToCart('{{ $product->id }}')">
                                Xem Ngay
                            </button> -->
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="pagination-wrapper">
                <div class="pagination-info">
                    <p class="text-muted small mb-3">
                        Hiển thị {{ $products->firstItem() }}-{{ $products->lastItem() }} trong {{ $products->total() }} sản phẩm
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
                <i class="fas fa-search"></i>
                <h5>Không tìm thấy sản phẩm nào</h5>
                <p>Không có sản phẩm nào khớp với từ khóa "<strong>{{ $query }}</strong>"</p>
                <div class="mt-3">
                    <a href="{{ route('products.index') }}" class="btn btn-primary me-2">Xem tất cả sản phẩm</a>
                    <a href="{{ route('home') }}" class="btn btn-outline-primary">Về trang chủ</a>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>

<!-- Mobile Filter Offcanvas -->
<div class="offcanvas offcanvas-start mobile-filter-offcanvas" tabindex="-1" id="filterOffcanvas" aria-labelledby="filterOffcanvasLabel">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="filterOffcanvasLabel">
            <i class="fas fa-filter me-2"></i>Bộ lọc sản phẩm
        </h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <!-- Search Info -->
        <div class="filter-section">
            <h5 class="filter-title">KẾT QUẢ TÌM KIẾM</h5>
            <div class="search-query">
                <strong>"{{ $query }}"</strong>
            </div>
            <div class="search-count">
                {{ $products->total() }} sản phẩm
            </div>
        </div>

        <!-- Category Filter -->
        @if($categories->count() > 0)
        <div class="filter-section">
            <h6 class="filter-subtitle">DANH MỤC</h6>
            <div class="filter-content">
                @foreach($categories as $category)
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="{{ $category->id }}" id="mobile-cat{{ $category->id }}" name="category_id" {{ request('category_id') == $category->id ? 'checked' : '' }}>
                    <label class="form-check-label" for="mobile-cat{{ $category->id }}">
                        {{ $category->name }}
                    </label>
                </div>
                @endforeach
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
                    <input class="form-check-input" type="checkbox" value="{{ $brand->id }}" id="mobile-brand{{ $brand->id }}" name="brand_id" {{ request('brand_id') == $brand->id ? 'checked' : '' }}>
                    <label class="form-check-label" for="mobile-brand{{ $brand->id }}">
                        {{ $brand->name }}
                    </label>
                </div>
                @endforeach
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

        <!-- Filter Actions -->
        <div class="filter-actions">
            <button type="button" class="btn btn-primary btn-sm w-100 mb-2" onclick="applyMobileFilters()">
                <i class="fas fa-filter me-2"></i>Áp dụng
            </button>
            <a href="{{ route('search', ['q' => $query]) }}" class="btn btn-outline-secondary btn-sm w-100">
                <i class="fas fa-refresh me-2"></i>Xóa bộ lọc
            </a>
        </div>
    </div>
</div>

<!-- Suggested Products Section -->
@if(isset($suggestedProducts) && $suggestedProducts->count() > 0)
<section class="py-5">
    <div class="container">
        <div class="suggested-section-wrapper">
            <div class="text-center mb-4">
                <h3 class="fw-bold text-primary mb-2">Sản Phẩm Liên Quan</h3>
                <p class="text-muted small mb-0">Các sản phẩm khác có thể bạn quan tâm</p>
            </div>

            <div class="suggested-products-grid">
                @foreach($suggestedProducts->take(10) as $product)
                <div class="suggested-product-item">
                    <div class="suggested-product-card"
                         data-product-id="{{ $product->id }}"
                         data-product-name="{{ $product->name }}"
                         data-product-model="{{ $product->sku ?? 'SW-' . $product->id }}"
                         data-product-price="{{ $product->sale_price ?? $product->price }}"
                         data-product-image="{{ $product->displayImage ? asset($product->displayImage->url) : asset('/image/sp1.png') }}">
                        <div class="suggested-product-image">
                            <a href="{{ route('products.show', $product->slug ?? $product->id) }}">
                                @if($product->displayImage && $product->displayImage->url)
                                <img src="{{ asset($product->displayImage->url) }}" alt="{{ $product->name }}" class="img-fluid">
                                @else
                                <img src="{{ asset('/image/sp1.png') }}" alt="{{ $product->name }}" class="img-fluid">
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
                                <i class="fas fa-star {{ $i <= ($product->rating_average ?? 4) ? 'text-warning' : 'text-muted' }}"></i>
                                @endfor
                                <span class="suggested-rating-count">({{ $product->rating_count ?? rand(10, 100) }})</span>
                            </div>

                            <button class="suggested-buy-btn" onclick="addToCart('{{ $product->id }}')">
                                Xem Ngay
                            </button>
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
    if (selectedCategory) {
        url.searchParams.set('category_id', selectedCategory.value);
    } else {
        url.searchParams.delete('category_id');
    }

    // Get selected brand
    const selectedBrand = document.querySelector('input[name="brand_id"]:checked');
    if (selectedBrand) {
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

    url.searchParams.delete('page'); // Reset to first page
    window.location.href = url.toString();
}

function applyMobileFilters() {
    const url = new URL(window.location);

    // Get selected category from mobile filter
    const selectedCategory = document.querySelector('#filterOffcanvas input[name="category_id"]:checked');
    if (selectedCategory) {
        url.searchParams.set('category_id', selectedCategory.value);
    } else {
        url.searchParams.delete('category_id');
    }

    // Get selected brand from mobile filter
    const selectedBrand = document.querySelector('#filterOffcanvas input[name="brand_id"]:checked');
    if (selectedBrand) {
        url.searchParams.set('brand_id', selectedBrand.value);
    } else {
        url.searchParams.delete('brand_id');
    }

    // Get selected price range from mobile filter
    const selectedPrice = document.querySelector('#filterOffcanvas input[name="price_range"]:checked');
    if (selectedPrice && selectedPrice.value) {
        url.searchParams.set('price_range', selectedPrice.value);
    } else {
        url.searchParams.delete('price_range');
    }

    url.searchParams.delete('page'); // Reset to first page
    window.location.href = url.toString();
}

function filterProducts(filter) {
    const url = new URL(window.location);

    switch(filter) {
        case 'sale':
            url.searchParams.set('filter', 'sale');
            break;
        case 'featured':
            url.searchParams.set('filter', 'featured');
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

// Add to cart function (placeholder)
function addToCart(productId) {
    console.log('Add to cart:', productId);
    // Implement add to cart functionality
}
</script>
@endpush

@push('styles')
<style>
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
}

.mobile-filter-btn {
    background: linear-gradient(135deg, #3498db, #2980b9);
    color: white;
    border: none;
    padding: 12px 20px;
    border-radius: 8px;
    font-weight: 600;
    font-size: 0.9rem;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    box-shadow: 0 2px 8px rgba(52, 152, 219, 0.2);
}

.mobile-filter-btn:hover {
    background: linear-gradient(135deg, #2980b9, #1f5f88);
    transform: translateY(-2px);
    box-shadow: 0 4px 15px rgba(52, 152, 219, 0.4);
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
    border-color: #3498db;
    box-shadow: 0 0 0 0.2rem rgba(52, 152, 219, 0.25);
}

/* Offcanvas Customization */
.mobile-filter-offcanvas {
    width: 320px !important;
    box-shadow: 2px 0 15px rgba(0, 0, 0, 0.1);
    z-index: 1055 !important;
}

.mobile-filter-offcanvas .offcanvas-header {
    background: linear-gradient(135deg, #3498db, #2980b9);
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

.mobile-filter-offcanvas .filter-title {
    color: #2c3e50;
    font-weight: 700;
    font-size: 1rem;
    margin-bottom: 15px;
    border-bottom: 2px solid #3498db;
    padding-bottom: 8px;
}

.mobile-filter-offcanvas .filter-subtitle {
    color: #3498db;
    font-weight: 600;
    font-size: 0.9rem;
    margin-bottom: 12px;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.mobile-filter-offcanvas .search-query {
    background: linear-gradient(135deg, #e8f4fd, #d4edda);
    padding: 12px 16px;
    border-radius: 8px;
    margin-bottom: 10px;
    border-left: 4px solid #3498db;
    font-weight: 600;
}

.mobile-filter-offcanvas .search-count {
    color: #6c757d;
    font-size: 0.85rem;
    font-style: italic;
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
    background-color: #3498db;
    border-color: #3498db;
}

.mobile-filter-offcanvas .form-check-label {
    font-size: 0.9rem;
    color: #495057;
    cursor: pointer;
    font-weight: 500;
}

.mobile-filter-offcanvas .form-check-label:hover {
    color: #3498db;
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
    background: linear-gradient(135deg, #3498db, #2980b9);
    border: none;
    box-shadow: 0 2px 8px rgba(52, 152, 219, 0.3);
}

.mobile-filter-offcanvas .filter-actions .btn-primary:hover {
    background: linear-gradient(135deg, #2980b9, #1f5f88);
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(52, 152, 219, 0.4);
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



/* Reuse styles from category show page */
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

.filter-title {
    color: #2c3e50;
    font-weight: 700;
    font-size: 1.1rem;
    margin-bottom: 15px;
}

.filter-subtitle {
    color: #7f8c8d;
    font-weight: 600;
    font-size: 0.9rem;
    margin-bottom: 12px;
}

.search-query {
    background: #f8f9fa;
    padding: 10px 15px;
    border-radius: 8px;
    margin-bottom: 10px;
    border-left: 4px solid #3498db;
}

.search-count {
    color: #7f8c8d;
    font-size: 0.9rem;
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

.header-top {
    text-align: center;
    border-bottom: 1px solid #f0f0f0;
    padding-bottom: 15px;
}

.category-title {
    color: #2c3e50;
    font-weight: 700;
    margin-bottom: 8px;
    font-size: 1.5rem;
}

.category-subtitle {
    color: #7f8c8d;
    font-size: 0.9rem;
    margin: 0;
}

.header-controls {
    padding-top: 15px;
}

.sort-options .form-select {
    border: 2px solid #dee2e6;
    border-radius: 8px;
    padding: 8px 12px;
    font-size: 0.85rem;
    min-width: 140px;
    background-color: white;
    transition: all 0.3s ease;
    height: 40px;
    font-weight: 500;
}

.sort-options .form-select:focus {
    border-color: #3498db;
    box-shadow: 0 0 0 0.2rem rgba(52, 152, 219, 0.25);
    outline: none;
}

.sort-options .form-select:hover {
    border-color: #3498db;
}

.quick-filters {
    display: flex;
    gap: 8px;
    flex-wrap: wrap;
    align-items: center;
}

.quick-filter-btn {
    background: #f8f9fa;
    border: 2px solid #dee2e6;
    border-radius: 25px;
    padding: 10px 18px;
    font-size: 0.85rem;
    font-weight: 600;
    color: #6c757d;
    cursor: pointer;
    transition: all 0.3s ease;
    white-space: nowrap;
    height: 40px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.quick-filter-btn:hover {
    background: #e3f2fd;
    border-color: #3498db;
    color: #3498db;
    transform: translateY(-1px);
}

.quick-filter-btn.active {
    background: linear-gradient(135deg, #3498db, #2980b9);
    border-color: #3498db;
    color: white;
    box-shadow: 0 2px 8px rgba(52, 152, 219, 0.3);
}

.products-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(240px, 1fr));
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
    color: #3498db;
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
    font-size: 1rem;
    font-weight: 700;
    color: #e74c3c;
    margin-right: 8px;
}

.original-price {
    font-size: 0.8rem;
    color: #95a5a6;
    text-decoration: line-through;
}

.regular-price {
    font-size: 1rem;
    font-weight: 700;
    color: #3498db;
}

.product-btn {
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

.product-btn:hover {
    background: linear-gradient(135deg, #2980b9, #1f5f88);
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(52, 152, 219, 0.3);
}

.empty-state {
    text-align: center;
    padding: 60px 20px;
    color: #7f8c8d;
}

.empty-state i {
    font-size: 4rem;
    margin-bottom: 20px;
    color: #bdc3c7;
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

/* Suggested Products Styles (reuse from category) */
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

/* Responsive */
@media (max-width: 1200px) {
    .suggested-products-grid {
        grid-template-columns: repeat(4, 1fr);
    }
}

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
    /* Mobile header spacing to avoid fixed header overlap */
    .container-fluid {
        padding-top: 80px !important;
    }

    .suggested-products-grid,
    .products-grid {
        grid-template-columns: repeat(2, 1fr);
        gap: 15px;
    }

    .category-header {
        padding: 15px;
    }

    .header-top {
        padding-bottom: 12px;
        margin-bottom: 15px;
    }

    .category-title {
        font-size: 1.3rem;
        margin-bottom: 6px;
    }

    .category-subtitle {
        font-size: 0.85rem;
    }

    .mobile-quick-filters .quick-filters {
        justify-content: center;
        gap: 6px;
        flex-wrap: wrap;
    }

    .mobile-quick-filters .quick-filter-btn {
        font-size: 0.8rem;
        padding: 8px 14px;
        height: 36px;
    }

    .sort-options {
        flex-direction: column;
        gap: 10px;
    }

    .sort-options .form-select {
        min-width: auto;
        width: 100%;
        height: 36px;
        font-size: 0.8rem;
    }
}

@media (max-width: 576px) {
    /* Small mobile header spacing */
    .container-fluid {
        padding-top: 5px !important;
    }

    .suggested-products-grid,
    .products-grid {
        grid-template-columns: repeat(2, 1fr);
        gap: 12px;
    }

    .category-header {
        text-align: center;
        padding: 12px;
    }

    .mobile-filter-section {
        padding: 12px;
        margin-bottom: 15px;
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

    .product-card {
        border-radius: 8px;
    }

    .product-image {
        height: 160px;
    }

    .product-content {
        padding: 12px;
    }

    .product-name {
        font-size: 0.85rem;
        height: 2.04em;
    }

    .quick-filters {
        gap: 6px;
        margin-bottom: 20px;
    }

    .quick-filter-btn {
        font-size: 0.75rem;
        padding: 5px 10px;
    }

    .container-fluid {
        padding-left: 15px;
        padding-right: 15px;
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

    .mobile-filter-offcanvas .filter-title {
        font-size: 0.95rem;
        margin-bottom: 12px;
    }

    .mobile-filter-offcanvas .filter-subtitle {
        font-size: 0.85rem;
        margin-bottom: 10px;
    }

    .pagination-wrapper {
        margin-top: 20px;
    }

    .custom-pagination .page-link {
        padding: 6px 10px;
        font-size: 13px;
        min-width: 30px;
    }
}
</style>
@endpush
