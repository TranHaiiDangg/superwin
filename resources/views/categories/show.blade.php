@extends('layouts.app')

@section('title', $category->name . ' - SuperWin')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <!-- Sidebar Filter -->
        <div class="col-lg-3 col-md-4">
            <div class="category-sidebar">
                <!-- Category Filter -->
                <div class="filter-section">
                    <h5 class="filter-title">{{ strtoupper($category->name) }}</h5>
                    @if($category->children->count() > 0)
                    <div class="filter-content">
                        @foreach($category->children as $child)
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="{{ $child->id }}" id="cat{{ $child->id }}">
                            <label class="form-check-label" for="cat{{ $child->id }}">
                            {{ $child->name }}
                            </label>
                        </div>
                        @endforeach
                    </div>
                    @endif
                </div>

                <!-- Brand Filter -->
                @if($brands->count() > 0)
                <div class="filter-section">
                    <h6 class="filter-subtitle">DÒNG SẢN PHẨM</h6>
                    <div class="filter-content">
                        @foreach($brands as $brand)
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="{{ $brand->id }}" id="brand{{ $brand->id }}">
                            <label class="form-check-label" for="brand{{ $brand->id }}">
                                {{ $brand->name }} <span class="text-muted">({{ $brand->products_count ?? 0 }})</span>
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
                            <input class="form-check-input" type="checkbox" value="0-1000000" id="price1">
                            <label class="form-check-label" for="price1">Dưới 1.000.000đ</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="1000000-3000000" id="price2">
                            <label class="form-check-label" for="price2">1.000.000đ - 3.000.000đ</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="3000000-5000000" id="price3">
                            <label class="form-check-label" for="price3">3.000.000đ - 5.000.000đ</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="5000000-10000000" id="price4">
                            <label class="form-check-label" for="price4">5.000.000đ - 10.000.000đ</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="10000000+" id="price5">
                            <label class="form-check-label" for="price5">Trên 10.000.000đ</label>
                        </div>
                    </div>
                </div>

                <!-- Rating Filter -->
                <div class="filter-section">
                    <h6 class="filter-subtitle">LỌI SẢN PHẨM</h6>
                    <div class="filter-content">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="sale" id="sale">
                            <label class="form-check-label" for="sale">Đang khuyến mãi</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="featured" id="featured">
                            <label class="form-check-label" for="featured">Sản phẩm nổi bật</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="new" id="new">
                            <label class="form-check-label" for="new">Sản phẩm mới</label>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="col-lg-9 col-md-8">
            <!-- Header -->
            <div class="category-header">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div>
                        <h3 class="category-title">{{ $category->name }}</h3>
                        <p class="category-subtitle">({{ $products->total() }} sản phẩm)</p>
                    </div>
                    <div class="sort-options d-flex gap-2">
                        <select class="form-select form-select-sm" id="perPage">
                            <option value="3" {{ request('per_page') == 3 ? 'selected' : '' }}>3 sản phẩm</option>
                            <option value="6" {{ request('per_page') == 6 ? 'selected' : '' }}>6 sản phẩm</option>
                            <option value="9" {{ request('per_page') == 9 ? 'selected' : '' }}>9 sản phẩm</option>
                            <option value="12" {{ request('per_page') == 12 ? 'selected' : '' }}>12 sản phẩm</option>
                            <option value="16" {{ request('per_page') == 16 ? 'selected' : '' }}>16 sản phẩm</option>
                        </select>
                        <select class="form-select form-select-sm" id="sortBy">
                            <option value="newest" {{ request('sort_by') == 'newest' ? 'selected' : '' }}>Mới nhất</option>
                            <option value="bestseller" {{ request('sort_by') == 'bestseller' ? 'selected' : '' }}>Bán chạy</option>
                            <option value="price_low" {{ request('sort_by') == 'price_low' ? 'selected' : '' }}>Giá thấp nhất</option>
                            <option value="price_high" {{ request('sort_by') == 'price_high' ? 'selected' : '' }}>Giá cao nhất</option>
                            <option value="name" {{ request('sort_by') == 'name' ? 'selected' : '' }}>Tên sản phẩm</option>
                        </select>
                    </div>
                </div>

                <!-- Quick Filters -->
                <div class="quick-filters mb-4">
                    <button class="quick-filter-btn active" data-filter="all">Tất cả</button>
                    <button class="quick-filter-btn" data-filter="sale">Đang giảm giá</button>
                    <button class="quick-filter-btn" data-filter="featured">Nổi bật</button>
                    <button class="quick-filter-btn" data-filter="bestseller">Bán chạy</button>
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
                         data-product-image="{{ $product->baseImage ? $product->baseImage->url : '/image/sp1.png' }}">
                        <div class="product-image">
                            <a href="{{ route('products.show', $product->slug ?? $product->id) }}">
                            @if($product->baseImage)
                                <img src="{{ $product->baseImage->url }}" alt="{{ $product->name }}" class="img-fluid">
                            @else
                                <img src="/image/sp1.png" alt="{{ $product->name }}" class="img-fluid">
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
                                <i class="fas fa-star {{ $i <= ($product->average_rating ?? 4) ? 'text-warning' : 'text-muted' }}"></i>
                                @endfor
                                <span class="rating-count">({{ $product->reviews_count ?? rand(10, 500) }})</span>
                            </div>

                            <div class="product-price">
                                    @if($product->isOnSale)
                                <span class="sale-price">{{ number_format($product->sale_price) }}đ</span>
                                <span class="original-price">{{ number_format($product->price) }}đ</span>
                                    @else
                                <span class="regular-price">{{ number_format($product->price) }}đ</span>
                                    @endif
                                </div>

                            <button class="product-btn" onclick="addToCart('{{ $product->id }}')">
                                Xem Ngay
                                    </button>
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
                <i class="fas fa-box-open"></i>
                <h5>Không có sản phẩm nào</h5>
                <p>Danh mục này chưa có sản phẩm</p>
                <a href="{{ route('products.index') }}" class="btn btn-primary">Xem tất cả sản phẩm</a>
            </div>
            @endif
        </div>
    </div>
</div>

<!-- Suggested Products Section (Reused from Home) -->
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
                    <div class="suggested-product-card"
                         data-product-id="{{ $product->id }}"
                         data-product-name="{{ $product->name }}"
                         data-product-model="{{ $product->sku ?? 'SW-' . $product->id }}"
                         data-product-price="{{ $product->sale_price ?? $product->price }}"
                         data-product-image="{{ $product->baseImage ? $product->baseImage->url : '/image/sp1.png' }}">
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
                    Xem thêm
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
});

function filterProducts(filter) {
    // Implementation for filtering products
    console.log('Filtering by:', filter);
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
</script>
@endpush

@push('styles')
<style>
/* Category Page Styles */
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

.filter-content .form-check {
    margin-bottom: 8px;
}

.filter-content .form-check-label {
    font-size: 0.9rem;
    color: #34495e;
    cursor: pointer;
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
    border-color: #3498db;
    box-shadow: 0 0 0 0.2rem rgba(52, 152, 219, 0.25);
}

.sort-options .form-select:hover {
    border-color: #3498db;
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
    background: #3498db;
    border-color: #3498db;
    color: white;
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

.custom-pagination .page-item.disabled .page-link:hover {
    background-color: transparent;
    color: #ccc;
}

/* Pagination dots */
.custom-pagination .page-item.disabled .page-link:not(:hover) {
    background-color: transparent;
    color: #999;
}

/* Previous and Next buttons */
.custom-pagination .page-item:first-child .page-link,
.custom-pagination .page-item:last-child .page-link {
    font-size: 16px;
    padding: 8px 10px;
}

/* Reuse Suggested Products Styles from Home */
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
        gap: 18px;
    }
}

@media (max-width: 992px) {
    .suggested-products-grid {
        grid-template-columns: repeat(3, 1fr);
        gap: 16px;
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

    .suggested-section-wrapper {
        padding: 20px;
        border-radius: 12px;
    }

    .category-header {
        padding: 15px;
    }

    .quick-filters {
        justify-content: center;
    }
}

@media (max-width: 576px) {
    .suggested-products-grid,
    .products-grid {
        grid-template-columns: repeat(2, 1fr);
        gap: 12px;
    }

    .suggested-section-wrapper {
        padding: 15px;
        border-radius: 8px;
    }

    .category-header {
        text-align: center;
    }

    .d-flex.justify-content-between {
        flex-direction: column;
        gap: 15px;
    }

    .custom-pagination .page-link {
        padding: 6px 8px;
        font-size: 13px;
        min-width: 30px;
    }

    .custom-pagination .pagination {
        gap: 6px;
        flex-wrap: wrap;
        justify-content: center;
    }

    .custom-pagination .page-item:first-child .page-link,
    .custom-pagination .page-item:last-child .page-link {
        font-size: 14px;
        padding: 6px 8px;
    }
}

@media (max-width: 400px) {
    .suggested-products-grid {
        grid-template-columns: 1fr;
    }
}
</style>
@endpush
