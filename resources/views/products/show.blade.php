@extends('layouts.app')

@section('title', $product->name . ' - SuperWin')

@section('content')
<!-- Breadcrumb -->
<nav aria-label="breadcrumb" class="py-3">
    <div class="container">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Trang chủ</a></li>
            @if($product->category)
                <li class="breadcrumb-item"><a href="{{ route('categories.show', $product->category->slug ?? $product->category->id) }}">{{ $product->category->name }}</a></li>
            @endif
            <li class="breadcrumb-item active" aria-current="page">{{ $product->name }}</li>
        </ol>
    </div>
</nav>

<!-- Product Detail Section -->
<section class="product-detail-section py-5">
    <div class="container">
        <div class="row">
            <!-- Product Images -->
            <div class="col-lg-5 mb-4">
                <div class="product-gallery d-flex">
                    <!-- Thumbnail Images -->
                    @if($product->images && $product->images->count() > 0)
                    <div class="thumbnail-container me-3">
                        <div class="thumbnail-wrapper d-flex flex-column">
                            @foreach($product->images->where('isbase', false)->take(5) as $index => $image)
                            <div class="thumbnail-item mb-2 {{ $index === 0 ? 'active' : '' }}"
                                 onclick="changeMainImage('{{ $image->url }}', this)">
                                <img src="{{ $image->url }}" alt="{{ $product->name }}" class="thumbnail-image">
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    <!-- Main Image -->
                    <div class="main-image-container">
                        <img id="mainImage" src="{{ $product->baseImage ? $product->baseImage->url : '/image/sp1.png' }}"
                             alt="{{ $product->name }}" class="main-image">

                        @if($product->is_featured)
                            <div class="featured-badge">
                                <i class="fas fa-star"></i> Nổi bật
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Product Info -->
            <div class="col-lg-7">
                <div class="product-info">
                    <div class="row">
                        <div class="col-md-8">
                            <h1 class="product-title">{{ $product->name }}</h1>
                            @if($product->sku)
                                <p class="product-sku">Mã sản phẩm: {{ $product->sku }}</p>
                            @endif
                             <!-- Rating -->
                    <div class="product-rating mb-3">
                        <div class="stars">
                            @for($i = 1; $i <= 5; $i++)
                                <i class="fas fa-star {{ $i <= ($product->average_rating ?? 0) ? 'text-warning' : 'text-muted' }}"></i>
                            @endfor
                        </div>
                        <span class="rating-text">
                            {{ number_format($product->average_rating ?? 0, 1) }}
                            ({{ $product->reviews->count() }} đánh giá)
                        </span>
                        @if($product->sold_count)
                            <span class="sold-count">• Đã bán {{ $product->sold_count }}</span>
                        @endif
                    </div>

                    <!-- Price -->
                    <div class="product-price mb-4">
                        @if($product->isOnSale)
                            <div class="current-price">{{ number_format($product->sale_price) }}₫</div>
                            <div class="original-price">{{ number_format($product->price) }}₫</div>
                            <div class="discount-badge">-{{ $product->discount_percentage }}%</div>
                        @else
                            <div class="current-price">{{ number_format($product->price) }}₫</div>
                        @endif
                    </div>

                    <!-- Power Attribute -->
                    @if($product->attributes && $product->attributes->where('attribute_key', 'power')->first())
                        <div class="power-attribute mb-4">
                            <div class="power-info">
                                <i class="fas fa-bolt text-warning"></i>
                                <span>Công suất: {{ $product->attributes->where('attribute_key', 'power')->first()->attribute_value }} {{ $product->attributes->where('attribute_key', 'power')->first()->attribute_unit }}</span>
                            </div>
                        </div>
                    @endif

                        <!-- Quantity -->
                        <div class="quantity-section mb-4">
                            <label class="quantity-label">Số lượng:</label>
                            <div class="quantity-controls">
                                <button class="quantity-btn" onclick="changeQuantity(-1)">-</button>
                                <input type="number" id="quantity" value="1" min="1" max="{{ $product->stock_quantity ?? 999 }}" class="quantity-input">
                                <button class="quantity-btn" onclick="changeQuantity(1)">+</button>
                            </div>
                            <span class="stock-info">
                                Còn {{ $product->stock_quantity ?? 'nhiều' }} sản phẩm
                            </span>
                        </div>

                                            <!-- Action Buttons -->
                        <div class="action-buttons mb-4">
                            <div class="d-grid gap-2 d-md-flex">
                                                            <button class="btn btn-primary btn-lg flex-fill me-md-2" onclick="addToCart({{ $product->id }})">
                                <i class="fas fa-shopping-cart me-2"></i>Thêm vào giỏ
                            </button>
                                <button class="btn btn-outline-primary btn-lg flex-fill me-md-2" onclick="buyNow()">
                                    <i class="fas fa-bolt me-2"></i>Mua ngay
                                </button>
                                <button class="btn btn-outline-danger btn-lg" style="width: 60px;" onclick="toggleWishlist()">
                                    <i class="fas fa-heart"></i>
                                </button>
                            </div>
                        </div>

                        </div>
                        <div class="col-md-4">
                            <div class="delivery-info">
                                <div class="delivery-list">
                                    <div class="delivery-item">
                                        <i class="fas fa-shipping-fast"></i>
                                        <div class="delivery-text">
                                            <strong>Giao hàng nhanh</strong>
                                            <span>24-48h</span>
                                        </div>
                                    </div>
                                    <div class="delivery-item">
                                        <i class="fas fa-shield-alt"></i>
                                        <div class="delivery-text">
                                            <strong>Bảo hành</strong>
                                            <span>Chính hãng</span>
                                        </div>
                                    </div>
                                    <div class="delivery-item">
                                        <i class="fas fa-undo"></i>
                                        <div class="delivery-text">
                                            <strong>Đổi trả</strong>
                                            <span>30 ngày</span>
                                        </div>
                                    </div>
                                </div>
                                @if($product->brand)
                                <div class="brand-info mt-3">
                                    <div class="brand-item">
                                        <i class="fas fa-trademark"></i>
                                        <div class="brand-text">
                                            <strong>Thương hiệu</strong>
                                            <span>{{ $product->brand->name }}</span>
                                        </div>
                                    </div>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>



                </div>
            </div>
        </div>
    </div>
</section>

<!-- Product Tabs -->
<section class="product-tabs-section py-5 bg-light">
    <div class="container">
        <div class="product-tabs">
            <ul class="nav nav-tabs" id="productTabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="description-tab" data-bs-toggle="tab" data-bs-target="#description" type="button" role="tab">
                        Mô tả sản phẩm
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="specifications-tab" data-bs-toggle="tab" data-bs-target="#specifications" type="button" role="tab">
                        Thông số kỹ thuật
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="reviews-tab" data-bs-toggle="tab" data-bs-target="#reviews" type="button" role="tab">
                        Đánh giá ({{ $product->reviews->count() }})
                    </button>
                </li>
            </ul>

            <div class="tab-content" id="productTabsContent">
                <!-- Description Tab -->
                <div class="tab-pane fade show active" id="description" role="tabpanel">
                    <div class="tab-content-wrapper">
                        <div class="product-description">
                            {!! $product->description !!}
                        </div>
                    </div>
                </div>

                <!-- Specifications Tab -->
                <div class="tab-pane fade" id="specifications" role="tabpanel">
                    <div class="tab-content-wrapper">
                        <div class="specifications-table">
                            @if($product->attributes && $product->attributes->count() > 0)
                                <div class="basic-specs">
                                    @php
                                        $basicKeys = ['brand', 'origin', 'type', 'power', 'function'];
                                        $displayNames = [
                                            'brand' => 'Hãng sản xuất',
                                            'origin' => 'Xuất xứ',
                                            'type' => 'Loại quạt',
                                            'power' => 'Công suất',
                                            'function' => 'Chức năng',
                                            // Thêm các mapping khác nếu cần
                                        ];
                                        $hasMoreSpecs = false;
                                        $count = 0;
                                    @endphp
                                    @foreach($product->attributes as $attribute)
                                        @if(in_array($attribute->attribute_key, $basicKeys) && $count < 5)
                                            <div class="spec-row">
                                                <div class="spec-label">{{ $displayNames[$attribute->attribute_key] ?? $attribute->attribute_key }}</div>
                                                <div class="spec-value">
                                                    {{ $attribute->attribute_value }}
                                                    @if($attribute->attribute_unit)
                                                        {{ $attribute->attribute_unit }}
                                                    @endif
                                                </div>
                                            </div>
                                            @php $count++; @endphp
                                        @else
                                            @php $hasMoreSpecs = true; @endphp
                                        @endif
                                    @endforeach
                                </div>

                                @if($hasMoreSpecs)
                                    <div class="full-specs" style="display: none;">
                                        @foreach($product->attributes as $attribute)
                                            @if(!in_array($attribute->attribute_key, $basicKeys) || $count >= 5)
                                                <div class="spec-row">
                                                    <div class="spec-label">{{ $displayNames[$attribute->attribute_key] ?? $attribute->attribute_key }}</div>
                                                    <div class="spec-value">
                                                        {{ $attribute->attribute_value }}
                                                        @if($attribute->attribute_unit)
                                                            {{ $attribute->attribute_unit }}
                                                        @endif
                                                    </div>
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>
                                    <div class="text-center mt-3">
                                        <button class="btn btn-outline-primary btn-sm" onclick="toggleSpecifications()">
                                            <span class="show-more">Xem chi tiết thông số kỹ thuật <i class="fas fa-chevron-down"></i></span>
                                            <span class="show-less" style="display: none;">Thu gọn <i class="fas fa-chevron-up"></i></span>
                                        </button>
                                    </div>
                                @endif
                            @else
                                <p class="text-muted">Chưa có thông số kỹ thuật</p>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Reviews Tab -->
                <div class="tab-pane fade" id="reviews" role="tabpanel">
                    <div class="tab-content-wrapper">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="rating-summary text-center">
                                    <h3 class="rating-title">Đánh giá trung bình</h3>
                                    <div class="average-rating">
                                        <span class="rating-number">{{ number_format($product->average_rating ?? 0, 1) }}</span>
                                        <div class="rating-stars">
                                            @for($i = 1; $i <= 5; $i++)
                                                <i class="fas fa-star {{ $i <= ($product->average_rating ?? 0) ? 'text-warning' : 'text-muted' }}"></i>
                                            @endfor
                                        </div>
                                        <div class="total-reviews">{{ $product->reviews->count() }} nhận xét</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="rating-bars">
                                    @php
                                        $totalReviews = $product->reviews->count();
                                        $ratingCounts = [
                                            5 => $product->reviews->where('rating', 5)->count(),
                                            4 => $product->reviews->where('rating', 4)->count(),
                                            3 => $product->reviews->where('rating', 3)->count(),
                                            2 => $product->reviews->where('rating', 2)->count(),
                                            1 => $product->reviews->where('rating', 1)->count(),
                                        ];
                                    @endphp
                                    @foreach($ratingCounts as $stars => $count)
                                        <div class="rating-bar-row">
                                            <span class="stars-count">{{ $stars }} sao</span>
                                            <div class="progress">
                                                <div class="progress-bar bg-warning"
                                                     role="progressbar"
                                                     style="width: {{ $totalReviews > 0 ? ($count / $totalReviews * 100) : 0 }}%"
                                                     aria-valuenow="{{ $count }}"
                                                     aria-valuemin="0"
                                                     aria-valuemax="{{ $totalReviews }}">
                                                </div>
                                            </div>
                                            <span class="rating-count">{{ $count }} {{ $stars == 5 ? 'Hài lòng' : ($stars == 4 ? 'Khá hài lòng' : ($stars == 3 ? 'Bình thường' : ($stars == 2 ? 'Không hài lòng' : 'Rất tệ'))) }}</span>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="review-action text-center">
                                    <p>Chia sẻ nhận xét của bạn về sản phẩm này</p>
                                    <button class="btn btn-primary" onclick="openReviewForm()">
                                        Viết Bình luận
                                    </button>
                                </div>
                            </div>
                        </div>

                        @if($product->reviews->count() > 0)
                            <div class="reviews-section mt-4">
                                <h4 class="mb-3">{{ $product->reviews->count() }} bình luận cho sản phẩm này</h4>
                                @foreach($product->reviews as $review)
                                <div class="review-item">
                                    <div class="review-header">
                                        <div class="reviewer-info">
                                            <div class="reviewer-name">{{ $review->customer_name }}</div>
                                            <div class="review-date">{{ $review->created_at->format('d/m/Y') }}</div>
                                        </div>
                                        <div class="review-rating">
                                            @for($i = 1; $i <= 5; $i++)
                                                <i class="fas fa-star {{ $i <= $review->rating ? 'text-warning' : 'text-muted' }}"></i>
                                            @endfor
                                        </div>
                                    </div>
                                    <div class="review-content">
                                        {{ $review->comment }}
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Related Products -->
@if($relatedProducts->count() > 0)
<section class="suggested-products-section py-5">
    <div class="container">
        <h2 class="section-title">GỢI Ý DÀNH RIÊNG CHO BẠN</h2>
        <div class="product-slider">
            @php
                $suggestedProducts = $relatedProducts
                    ->where('id', '!=', $product->id)
                    ->take(6)
                    ->map(function($product) {
                        return [
                            'id' => $product->id,
                            'slug' => $product->slug,
                            'name' => $product->name,
                            'image' => $product->baseImage ? $product->baseImage->url : '/image/sp1.png',
                            'price' => $product->price,
                            'sale_price' => $product->sale_price,
                            'is_on_sale' => $product->isOnSale,
                            'discount_percentage' => $product->discount_percentage,
                            'rating' => number_format($product->average_rating ?? 0, 1),
                            'review_count' => $product->reviews->count(),
                            'sold_count' => $product->sold_count,
                            'coupon' => $product->coupon
                        ];
                    });
            @endphp

            @foreach($suggestedProducts as $product)
            <div class="product-card">
                <a href="{{ route('products.show', $product['slug'] ?? $product['id']) }}" class="product-link">
                    <div class="product-image">
                        <img src="{{ $product['image'] }}" alt="{{ $product['name'] }}" class="card-img-top">
                        @if($product['is_on_sale'])
                            <div class="discount-tag">-{{ $product['discount_percentage'] }}%</div>
                        @endif
                    </div>

                    <div class="product-info">
                        <h3 class="product-name">{{ $product['name'] }}</h3>

                        <div class="product-rating">
                            <div class="stars">
                                <span class="rating-score">{{ $product['rating'] }}</span>
                                @for($i = 1; $i <= 5; $i++)
                                    <i class="fas fa-star {{ $i <= $product['rating'] ? 'text-warning' : 'text-muted' }}"></i>
                                @endfor
                                <span class="rating-count">({{ $product['review_count'] }})</span>
                            </div>
                            @if($product['sold_count'])
                                <div class="sold-count">{{ $product['sold_count'] }} đã bán</div>
                            @endif
                        </div>

                        <div class="product-price">
                            @if($product['is_on_sale'])
                                <span class="sale-price">{{ number_format($product['sale_price']) }}đ</span>
                                <span class="original-price">{{ number_format($product['price']) }}đ</span>
                                <span class="discount-percent">{{ $product['discount_percentage'] }}%</span>
                            @else
                                <span class="sale-price">{{ number_format($product['price']) }}đ</span>
                            @endif
                        </div>

                        @if($product['coupon'])
                            <div class="coupon-tag">
                                <i class="fas fa-ticket-alt"></i> {{ $product['coupon'] }}
                            </div>
                        @endif
                    </div>
                </a>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif
@endsection

@push('styles')
<style>
/* Product Detail Styles */
.product-detail-section {
    background: white;
}

.breadcrumb {
    background: transparent;
    padding: 0;
    margin: 0;
}

.breadcrumb-item a {
    color: #007bff;
    text-decoration: none;
}

.breadcrumb-item.active {
    color: #6c757d;
}

/* Product Gallery */
.product-gallery {
    position: relative;
}

.main-image-container {
    position: relative;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
}

.main-image {
    width: 100%;
    height: 400px;
    object-fit: cover;
    transition: transform 0.3s ease;
}

.main-image:hover {
    transform: scale(1.05);
}

.sale-badge, .featured-badge {
    position: absolute;
    padding: 8px 12px;
    border-radius: 6px;
    font-weight: bold;
    font-size: 0.8rem;
}

.sale-badge {
    top: 15px;
    right: 15px;
    background: #dc3545;
    color: white;
}

.featured-badge {
    top: 15px;
    left: 15px;
    background: #ffc107;
    color: #212529;
}

.thumbnail-container {
    width: 100px;
    margin-right: 15px;
}

.thumbnail-wrapper {
    display: flex;
    flex-direction: column;
    gap: 10px;
    max-height: 400px;
    overflow-y: auto;
}

.thumbnail-item {
    width: 80px;
    height: 80px;
    border-radius: 8px;
    overflow: hidden;
    cursor: pointer;
    border: 2px solid transparent;
    transition: all 0.3s ease;
}

.thumbnail-item.active {
    border-color: #007bff;
}

.thumbnail-image {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

/* Custom scrollbar for thumbnail wrapper */
.thumbnail-wrapper::-webkit-scrollbar {
    width: 6px;
}

.thumbnail-wrapper::-webkit-scrollbar-track {
    background: #f1f1f1;
    border-radius: 3px;
}

.thumbnail-wrapper::-webkit-scrollbar-thumb {
    background: #888;
    border-radius: 3px;
}

.thumbnail-wrapper::-webkit-scrollbar-thumb:hover {
    background: #555;
}

/* Product Info */
.product-info {
    padding: 20px;
}

.product-title {
    font-size: 1.5rem;
    font-weight: bold;
    color: #2c3e50;
    margin-bottom: 10px;
}


.product-sku {
    color: #6c757d;
    font-size: 0.9rem;
    margin-bottom: 15px;
}

.product-rating {
    display: flex;
    align-items: center;
    gap: 10px;
}

.stars {
    display: flex;
    gap: 2px;
}

.rating-text, .sold-count {
    color: #6c757d;
    font-size: 0.9rem;
}

.product-price {
    display: flex;
    align-items: center;
    gap: 15px;
}

.current-price {
    font-size: 1.5rem;
    font-weight: bold;
    color: #dc3545;
}

.original-price {
    font-size: 1.2rem;
    color: #6c757d;
    text-decoration: line-through;
}

.discount-badge {
    background: #dc3545;
    color: white;
    padding: 4px 8px;
    border-radius: 4px;
    font-size: 0.8rem;
    font-weight: bold;
}

/* Product Options */
.option-group {
    margin-bottom: 20px;
}

.option-label {
    display: block;
    font-weight: 600;
    margin-bottom: 10px;
    color: #2c3e50;
}

.option-buttons {
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
}

.option-btn {
    padding: 8px 16px;
    border: 2px solid #e9ecef;
    background: white;
    border-radius: 6px;
    cursor: pointer;
    transition: all 0.3s ease;
    font-size: 0.9rem;
}

.option-btn:hover, .option-btn.active {
    border-color: #007bff;
    background: #007bff;
    color: white;
}

/* Quantity Controls */
.quantity-section {
    display: flex;
    align-items: center;
    gap: 15px;
}

.quantity-label {
    font-weight: 600;
    color: #2c3e50;
}

.quantity-controls {
    display: flex;
    align-items: center;
    border: 1px solid #dee2e6;
    border-radius: 6px;
    overflow: hidden;
}

.quantity-btn {
    padding: 8px 12px;
    border: none;
    background: #f8f9fa;
    cursor: pointer;
    transition: background 0.3s ease;
}

.quantity-btn:hover {
    background: #e9ecef;
}

.quantity-input {
    width: 60px;
    text-align: center;
    border: none;
    padding: 8px;
    font-size: 1rem;
}

.stock-info {
    color: #28a745;
    font-size: 0.9rem;
}

/* Action Buttons */
.action-buttons {
    display: flex;
    gap: 15px;
    flex-wrap: wrap;
}

.btn-lg {
    padding: 12px 24px;
    font-size: 1rem;
}

/* Action Buttons */
.action-buttons .btn-lg {
    padding: 15px 25px;
    font-size: 1rem;
    border-radius: 8px;
}

.action-buttons .btn-primary {
    background: #ff6b00;
    border-color: #ff6b00;
}

.action-buttons .btn-primary:hover {
    background: #e66000;
    border-color: #e66000;
}

.action-buttons .btn-outline-primary {
    color: #ff6b00;
    border-color: #ff6b00;
}

.action-buttons .btn-outline-primary:hover {
    background: #ff6b00;
    border-color: #ff6b00;
}

/* Delivery Info */
.delivery-info {
    background: #f8f9fa;
    border-radius: 8px;
    padding: 15px;
    height: 100%;
}

.delivery-list {
    display: flex;
    flex-direction: column;
    gap: 15px;
}

.delivery-item, .brand-item {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 10px;
    background: #fff;
    border-radius: 8px;
    transition: all 0.3s ease;
}

.delivery-item:hover, .brand-item:hover {
    transform: translateX(5px);
    box-shadow: 0 2px 8px rgba(0,0,0,0.05);
}

.delivery-item i, .brand-item i {
    font-size: 20px;
    color: #ff6b00;
    width: 36px;
    height: 36px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: rgba(255, 107, 0, 0.1);
    border-radius: 50%;
}

.delivery-text, .brand-text {
    display: flex;
    flex-direction: column;
}

.delivery-text strong, .brand-text strong {
    color: #333;
    font-size: 0.9rem;
    margin-bottom: 2px;
}

.delivery-text span, .brand-text span {
    color: #666;
    font-size: 0.85rem;
}

.brand-info {
    border-top: 1px solid #dee2e6;
    padding-top: 15px;
}

.brand-item {
    background: #fff;
}

/* Product Tabs */
.product-tabs-section {
    background: #f8f9fa;
}

.nav-tabs {
    border-bottom: 2px solid #dee2e6;
}

.nav-tabs .nav-link {
    border: none;
    color: #6c757d;
    font-weight: 600;
    padding: 15px 25px;
    border-radius: 0;
    transition: all 0.3s ease;
}

.nav-tabs .nav-link.active {
    color: #007bff;
    background: white;
    border-bottom: 2px solid #007bff;
}

.tab-content-wrapper {
    background: white;
    padding: 30px;
    border-radius: 0 0 12px 12px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
}

/* Specifications */
.specifications-table {
    display: flex;
    flex-direction: column;
    gap: 15px;
}

.basic-specs, .full-specs {
    display: flex;
    flex-direction: column;
    gap: 15px;
}

.spec-row {
    display: flex;
    border-bottom: 1px solid #f0f0f0;
    background: #fff;
    transition: background-color 0.3s ease;
}

.spec-row:nth-child(odd) {
    background: #fafafa;
}

.spec-label {
    font-weight: 500;
    color: #666;
    width: 200px;
    flex-shrink: 0;
    padding: 12px 15px;
}

.spec-value {
    color: #333;
    flex: 1;
    padding: 12px 15px;
    border-left: 1px solid #f0f0f0;
}

.full-specs {
    margin-top: 1px;
}

.basic-specs, .full-specs {
    display: flex;
    flex-direction: column;
    gap: 1px;
    background: #f0f0f0;
    border-radius: 4px;
    overflow: hidden;
}

.btn-outline-primary.btn-sm {
    padding: 8px 20px;
    font-size: 0.9rem;
    border-radius: 20px;
    transition: all 0.3s ease;
}

.btn-outline-primary.btn-sm:hover {
    transform: translateY(-2px);
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
}

/* Reviews */
.rating-summary {
    padding: 20px;
}

.rating-title {
    font-size: 1.1rem;
    color: #666;
    margin-bottom: 15px;
}

.average-rating {
    text-align: center;
}

.rating-number {
    font-size: 4rem;
    font-weight: bold;
    color: #ff6b00;
    line-height: 1;
    display: block;
    margin-bottom: 10px;
}

.rating-stars {
    font-size: 1.2rem;
    margin-bottom: 10px;
}

.total-reviews {
    color: #666;
    font-size: 0.9rem;
}

.rating-bars {
    padding: 20px;
}

.rating-bar-row {
    display: flex;
    align-items: center;
    margin-bottom: 12px;
    gap: 10px;
}

.stars-count {
    width: 60px;
    text-align: right;
    color: #666;
    font-size: 0.9rem;
}

.progress {
    flex: 1;
    height: 8px;
    background-color: #f0f0f0;
    border-radius: 4px;
    overflow: hidden;
}

.progress-bar {
    background-color: #ff6b00 !important;
    transition: width 0.3s ease;
}

.rating-count {
    width: 100px;
    color: #666;
    font-size: 0.9rem;
}

.review-action {
    padding: 20px;
    background: #f8f9fa;
    border-radius: 8px;
    margin: 20px 0;
}

.review-action p {
    color: #666;
    margin-bottom: 15px;
}

.review-action .btn-primary {
    background: #ff6b00;
    border-color: #ff6b00;
    padding: 10px 30px;
    font-weight: 500;
}

.review-action .btn-primary:hover {
    background: #e66000;
    border-color: #e66000;
}

.reviews-section {
    margin-top: 30px;
    display: flex;
    flex-direction: column;
    gap: 20px;
}

.review-item {
    border: 1px solid #e9ecef;
    border-radius: 8px;
    padding: 20px;
    background: #fff;
}

.review-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 10px;
}

.reviewer-name {
    font-weight: 600;
    color: #2c3e50;
}

.review-date {
    color: #6c757d;
    font-size: 0.9rem;
}

.review-rating {
    display: flex;
    gap: 2px;
}

.review-content {
    color: #495057;
    line-height: 1.6;
}

/* Suggested Products */
.suggested-products-section {
    background: #f8f9fa;
    padding: 40px 0;
}

.section-title {
    font-size: 1.25rem;
    font-weight: bold;
    color: #333;
    text-transform: uppercase;
    margin-bottom: 30px;
}

.product-slider {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
    gap: 20px;
    margin: 0 -10px;
}

.product-card {
    background: white;
    border-radius: 8px;
    overflow: hidden;
    box-shadow: 0 1px 3px rgba(0,0,0,0.1);
    transition: transform 0.3s ease;
}

.product-card:hover {
    transform: translateY(-5px);
}

.product-link {
    text-decoration: none;
    color: inherit;
    display: block;
}

.product-image {
    position: relative;
    padding-top: 100%;
    overflow: hidden;
}

.product-image img {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.discount-tag {
    position: absolute;
    top: 10px;
    right: 10px;
    background: #ff6b00;
    color: white;
    padding: 4px 8px;
    border-radius: 4px;
    font-weight: 500;
    font-size: 0.85rem;
}

.product-info {
    padding: 15px;
}

.product-name {
    font-size: 0.95rem;
    color: #333;
    margin-bottom: 10px;
    line-height: 1.4;
    height: 2.8em;
    overflow: hidden;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
}

.product-rating {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 10px;
    font-size: 0.85rem;
}

.stars {
    display: flex;
    align-items: center;
    gap: 4px;
}

.rating-score {
    font-weight: 500;
    margin-right: 4px;
}

.rating-count {
    color: #666;
    margin-left: 4px;
}

.sold-count {
    color: #666;
}

.product-price {
    display: flex;
    align-items: center;
    gap: 8px;
    margin-bottom: 10px;
}

.sale-price {
    font-size: 1.1rem;
    font-weight: bold;
    color: #ff6b00;
}

.original-price {
    font-size: 0.9rem;
    color: #999;
    text-decoration: line-through;
}

.discount-percent {
    color: #ff6b00;
    font-size: 0.85rem;
}

.coupon-tag {
    display: inline-flex;
    align-items: center;
    gap: 4px;
    padding: 4px 8px;
    background: #fff0e6;
    color: #ff6b00;
    border-radius: 4px;
    font-size: 0.85rem;
}

.coupon-tag i {
    font-size: 0.9rem;
}

/* Responsive */
/* Power Attribute */
.power-attribute {
    margin-top: 10px;
}

.power-info {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 8px 12px;
    background: #fff8e5;
    border-radius: 6px;
    font-size: 0.95rem;
    color: #333;
}

.power-info i {
    font-size: 1.1rem;
}

@media (max-width: 768px) {
    .product-title {
        font-size: 1.5rem;
    }

    .current-price {
        font-size: 1.5rem;
    }

    .action-buttons {
        flex-direction: column;
    }

    .btn-lg {
        width: 100%;
    }

    .spec-row {
        flex-direction: column;
        gap: 5px;
    }

    .spec-label {
        width: 100%;
    }
}
</style>
@endpush

@push('scripts')
<script>
// Product Detail JavaScript
document.addEventListener('DOMContentLoaded', function() {
    // Initialize product detail functionality
    initializeProductDetail();
});

function initializeProductDetail() {
    // Image gallery functionality
    setupImageGallery();

    // Product options functionality
    setupProductOptions();

    // Quantity controls
    setupQuantityControls();
}

function setupImageGallery() {
    // Main image zoom effect
    const mainImage = document.getElementById('mainImage');
    if (mainImage) {
        mainImage.addEventListener('mouseenter', function() {
            this.style.transform = 'scale(1.1)';
        });

        mainImage.addEventListener('mouseleave', function() {
            this.style.transform = 'scale(1)';
        });
    }
}

function toggleSpecifications() {
    const fullSpecs = document.querySelector('.full-specs');
    const showMore = document.querySelector('.show-more');
    const showLess = document.querySelector('.show-less');

    if (fullSpecs.style.display === 'none') {
        fullSpecs.style.display = 'flex';
        showMore.style.display = 'none';
        showLess.style.display = 'inline';

        // Scroll to full specs
        fullSpecs.scrollIntoView({ behavior: 'smooth', block: 'start' });
    } else {
        fullSpecs.style.display = 'none';
        showMore.style.display = 'inline';
        showLess.style.display = 'none';

        // Scroll back to basic specs
        document.querySelector('.basic-specs').scrollIntoView({ behavior: 'smooth', block: 'start' });
    }
}

function changeMainImage(imageSrc, thumbnailElement) {
    const mainImage = document.getElementById('mainImage');
    if (mainImage) {
        mainImage.src = imageSrc;

        // Update active thumbnail
        document.querySelectorAll('.thumbnail-item').forEach(item => {
            item.classList.remove('active');
        });
        thumbnailElement.classList.add('active');
    }
}

function setupProductOptions() {
    // Option button functionality
    document.querySelectorAll('.option-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            // Remove active class from siblings
            const parent = this.parentElement;
            parent.querySelectorAll('.option-btn').forEach(b => b.classList.remove('active'));

            // Add active class to clicked button
            this.classList.add('active');

            // Update product price if needed
            updateProductPrice();
        });
    });
}

function setupQuantityControls() {
    const quantityInput = document.getElementById('quantity');
    if (quantityInput) {
        quantityInput.addEventListener('change', function() {
            const value = parseInt(this.value);
            const min = parseInt(this.min);
            const max = parseInt(this.max);

            if (value < min) this.value = min;
            if (value > max) this.value = max;
        });
    }
}

function changeQuantity(delta) {
    const quantityInput = document.getElementById('quantity');
    if (quantityInput) {
        const currentValue = parseInt(quantityInput.value);
        const newValue = currentValue + delta;
        const min = parseInt(quantityInput.min);
        const max = parseInt(quantityInput.max);

        if (newValue >= min && newValue <= max) {
            quantityInput.value = newValue;
        }
    }
}

function updateProductPrice() {
    // This function can be used to update price based on selected options
    // For now, it's a placeholder
    console.log('Price updated based on selected options');
}

function addToCart(productId) {
    @auth('customer')
        const quantity = document.getElementById('quantity') ? document.getElementById('quantity').value : 1;
        const attributes = {}; // Có thể thêm các thuộc tính sản phẩm nếu cần

        // Show loading state
        showNotification('Đang thêm vào giỏ hàng...', 'info');

        // Gọi API thêm vào giỏ
        fetch(`/cart/add/${productId}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({ quantity, attributes })
        })
        .then(response => response.json())
        .then(data => {
            showNotification('Đã thêm vào giỏ hàng thành công!', 'success');

            // Cập nhật số lượng giỏ hàng trong header
            if (typeof window.updateCartCount === 'function') {
                window.updateCartCount(data.cartCount);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showNotification('Có lỗi xảy ra khi thêm vào giỏ hàng', 'error');
        });
    @else
        // Redirect to login page
        window.location.href = '{{ route('login') }}?redirect=' + encodeURIComponent(window.location.href);
    @endauth
}

function buyNow(productId = null) {
    const targetProductId = productId || '{{ $product->id ?? "" }}';
    const quantity = document.getElementById('quantity') ? document.getElementById('quantity').value : 1;

    // Redirect to checkout page
    window.location.href = `/checkout?product=${targetProductId}&quantity=${quantity}`;
}

function toggleWishlist() {
    const button = event.target.closest('button');
    const icon = button.querySelector('i');

    if (icon.classList.contains('fas')) {
        icon.classList.remove('fas');
        icon.classList.add('far');
        showNotification('Đã xóa khỏi danh sách yêu thích', 'info');
    } else {
        icon.classList.remove('far');
        icon.classList.add('fas');
        showNotification('Đã thêm vào danh sách yêu thích', 'success');
    }
}

function showNotification(message, type = 'info') {
    // Create notification element
    const notification = document.createElement('div');
    notification.className = `alert alert-${type} alert-dismissible fade show`;
    notification.style.cssText = 'position: fixed; top: 20px; right: 20px; z-index: 9999; min-width: 300px;';

    notification.innerHTML = `
        <i class="fas fa-${type === 'success' ? 'check-circle' : 'info-circle'} me-2"></i>
        ${message}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    `;

    document.body.appendChild(notification);

    // Auto remove after 3 seconds
    setTimeout(() => {
        notification.remove();
    }, 3000);
}
</script>
@endpush
