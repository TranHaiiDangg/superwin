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
<section class="product-detail-section">
    <div class="container">
        <div class="row">
            <!-- Product Images -->
            <div class="col-lg-5 mb-4">
                <div class="product-gallery d-flex">
                    <!-- Thumbnail Images -->
                    @if($product->images && $product->images->count() > 0)
                    <div class="thumbnail-container me-3">
                        <!-- Slider Navigation Arrows (Mobile Only) -->
                        <button class="slider-nav prev d-md-none" onclick="slideThumbnails('prev')">
                            <i class="fas fa-chevron-left"></i>
                        </button>
                        <button class="slider-nav next d-md-none" onclick="slideThumbnails('next')">
                            <i class="fas fa-chevron-right"></i>
                        </button>

                        <div class="thumbnail-wrapper d-flex flex-column" id="thumbnailWrapper">
                            @foreach($product->images->where('isbase', false)->take(5) as $index => $image)
                            <div class="thumbnail-item mb-2 {{ $index === 0 ? 'active' : '' }}"
                                onclick="changeMainImage('{{ $image->url }}', this)">
                                <img src="{{ $image->url }}" alt="{{ $product->name }}" class="thumbnail-image">
                            </div>
                            @endforeach
                        </div>

                        <!-- Slider Dots (Mobile Only) -->
                        <div class="slider-dots d-md-none" id="sliderDots">
                            @foreach($product->images->where('isbase', false)->take(5) as $index => $image)
                            <div class="slider-dot {{ $index === 0 ? 'active' : '' }}" onclick="slideToThumbnail({{ $index }})"></div>
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

                <!-- Customer Photos Gallery -->
                <div class="customer-photos-section mt-4" id="customerPhotosSection" style="display: none;">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <h6 class="mb-0">
                            <i class="fas fa-camera me-2 text-primary"></i>
                            Ảnh từ khách hàng (<span id="customerPhotosCount">0</span>)
                        </h6>
                        <button class="btn btn-sm btn-outline-primary" onclick="toggleCustomerPhotos()">
                            <span id="togglePhotosText">Xem tất cả</span>
                            <i class="fas fa-chevron-down ms-1" id="togglePhotosIcon"></i>
                        </button>
                    </div>
                    <div class="customer-photos-grid" id="customerPhotosGrid">
                        <!-- Photos will be loaded here -->
                    </div>
                </div>
            </div>

            <!-- Product Info -->
            <div class="col-lg-7">
                <div class="product-info"
                     data-product-id="{{ $product->id }}"
                     data-product-name="{{ $product->name }}"
                     data-product-model="{{ $product->sku ?? 'SW-' . $product->id }}"
                     data-product-price="{{ $product->sale_price ?? $product->price }}"
                     data-product-image="{{ $product->baseImage ? $product->baseImage->url : '/image/sp1.png' }}">
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
                                        <i class="fas fa-star {{ $i <= $product->average_rating ? 'text-warning' : 'text-muted' }}"></i>
                                        @endfor
                                </div>
                                <span class="rating-text">
                                    {{ number_format($product->average_rating, 1) }}
                                    ({{ $product->reviews_count }} đánh giá)
                                </span>
                                @if($product->sold_count)
                                <span class="sold-count">• Đã bán {{ $product->sold_count }}</span>
                                @endif
                            </div>

                            <!-- Price -->
                            <div class="product-price mb-4" style="text-align: left !important; width: 100%; justify-content: flex-start !important; align-items: flex-start !important;">
                                <div class="price-row" style="justify-content: flex-start !important; text-align: left !important;">
                                    @if($product->isOnSale)
                                    <span class="current-price">{{ number_format($product->sale_price) }}₫</span>
                                    <span class="original-price">{{ number_format($product->price) }}₫</span>
                                    <span class="discount-badge">-{{ $product->discount_percentage }}%</span>
                                    @else
                                    <span class="current-price">{{ number_format($product->price) }}₫</span>
                                    @endif
                                </div>
                                <div class="vat-notice" style="text-align: left !important;">
                                    <small class="text-muted">Giá chưa bao gồm thuế VAT 8%</small>
                                </div>
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

                            <!-- Product Variants -->
                            @if($product->activeVariants && $product->activeVariants->count() > 0)
                            <div class="variants-section mb-4">
                                <label class="variants-label">Phiên bản:</label>
                                <div class="variants-container">
                                    <!-- Option to deselect variants -->
                                    <div class="variant-item variant-none"
                                         data-variant-id="none"
                                         data-variant-price="{{ $product->sale_price ?? $product->price }}"
                                         data-variant-stock="{{ $product->stock_quantity ?? 999 }}"
                                         data-variant-name="{{ $product->name }}"
                                         data-variant-code="{{ $product->sku ?? '' }}">
                                        <input type="radio" name="selected_variant" id="variant_none" value="none" class="variant-radio" checked>
                                        <label for="variant_none" class="variant-label">
                                            <div class="variant-info">
                                                <div class="variant-name">
                                                    <i class="fas fa-home me-2"></i>{{ $product->name }}
                                                </div>
                                                <div class="variant-code">{{ $product->sku ?? 'Sản phẩm gốc' }}</div>
                                            </div>
                                        </label>
                                    </div>

                                    @foreach($product->activeVariants as $variant)
                                    <div class="variant-item"
                                         data-variant-id="{{ $variant->id }}"
                                         data-variant-price="{{ $variant->final_price }}"
                                         data-variant-stock="{{ $variant->quantity }}"
                                         data-variant-name="{{ $variant->name }}"
                                         data-variant-code="{{ $variant->code }}">
                                        <input type="radio" name="selected_variant" id="variant_{{ $variant->id }}" value="{{ $variant->id }}" class="variant-radio">
                                        <label for="variant_{{ $variant->id }}" class="variant-label">
                                            <div class="variant-info">
                                                <div class="variant-name">{{ $variant->name }}</div>
                                                <div class="variant-code">{{ $variant->code }}</div>
                                            </div>
                                        </label>
                                    </div>
                                    @endforeach
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

                                </div>
                            </div>

                        </div>
                        <div class="col-md-4 d-none d-lg-block">
                            <div class="delivery-info">
                                <aside id="text-2" class="widget widget_text">
                                    <div class="textwidget">
                                        <div class="icon-box featured-box icon-box-left text-left has-block">
                                            <div class="icon-box-img" style="width: 40px">
                                                <div class="icon">
                                                    <div class="icon-inner">
                                                        <img loading="lazy" width="45" height="34" src="https://superwin.vn/wp-content/uploads/2018/08/productdetail-icon5.png" class="attachment-medium size-medium" alt="Giao hàng nhanh" decoding="async">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="icon-box-text last-reset">
                                                <p><strong>Giao hàng nhanh chóng</strong><br>
                                                <span style="font-size: 85%;">chỉ trong vòng 24 giờ</span></p>
                                            </div>
                                        </div>

                                        <div class="gap-element" style="display:block; height:auto; padding-top:20px"></div>

                                        <div class="icon-box featured-box icon-box-left text-left">
                                            <div class="icon-box-img" style="width: 40px">
                                                <div class="icon">
                                                    <div class="icon-inner">
                                                        <img loading="lazy" width="33" height="34" src="https://superwin.vn/wp-content/uploads/2018/08/productdetail-icon4.png" class="attachment-medium size-medium" alt="Sản phẩm chính hãng" decoding="async">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="icon-box-text last-reset">
                                                <p><strong>Sản phẩm chính hãng</strong><br>
                                                <span style="font-size: 85%;">sản phẩm nhập khẩu 100%</span></p>
                                            </div>
                                        </div>

                                        <div class="gap-element" style="display:block; height:auto; padding-top:20px"></div>

                                        <div class="icon-box featured-box icon-box-left text-left">
                                            <div class="icon-box-img" style="width: 40px">
                                                <div class="icon">
                                                    <div class="icon-inner">
                                                        <img width="34" height="34" src="https://superwin.vn/wp-content/uploads/2018/08/productdetail-icon3.png" class="attachment-medium size-medium" alt="Mua hàng tiết kiệm" decoding="async" loading="lazy">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="icon-box-text last-reset">
                                                <p><strong>Mua hàng tiết kiệm</strong><br><span style="font-size: 85%;">rẻ hơn từ 10% – 20%</span></p>
                                            </div>
                                        </div>

                                        <div class="gap-element" style="display:block; height:auto; padding-top:20px"></div>

                                        <div class="icon-box featured-box icon-box-left text-left">
                                            <div class="icon-box-img" style="width: 40px">
                                                <div class="icon">
                                                    <div class="icon-inner">
                                                        <img width="37" height="34" src="https://superwin.vn/wp-content/uploads/2018/08/productdetail-icon1.png" class="attachment-medium size-medium" alt="Hotline mua hàng" decoding="async" loading="lazy">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="icon-box-text last-reset">
                                                <p><strong>Hotline mua hàng</strong><br><span style="font-size: 85%;">097 168 7711</span></p>
                                            </div>
                                        </div>
                                    </div>
                                </aside>
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


                            <!-- Sản phẩm cùng thương hiệu -->
                            <!-- @if($sameBrandProducts->count() > 0)
                            <div class="related-products mb-5 mt-5">
                                <div class="d-flex align-items-center justify-content-between mb-4">
                                    <h4 class="mb-0 text-center">Sản phẩm cùng thương hiệu {{ $product->brand ? $product->brand->name : '' }}</h4>
                                    @if($product->brand && $product->brand->slug)
                                    <a href="{{ route('products.brand', ['slug' => $product->brand->slug]) }}" class="btn btn-outline-primary btn-sm">Xem tất cả</a>
                                    @endif
                                </div>
                                <div class="row g-4">
                                    @foreach($sameBrandProducts as $brandProduct)
                                    <div class="col">
                                        <div class="card h-100 border-0 shadow-sm product-card">
                                            <div class="position-relative">
                                                <a href="{{ route('products.show', $brandProduct->slug ?? $brandProduct->id) }}" class="text-decoration-none">
                                                    @if($brandProduct->baseImage)
                                                    <img src="{{ $brandProduct->baseImage->url }}" class="card-img-top" alt="{{ $brandProduct->name }}" style="height: 150px; object-fit: cover;">
                                                    @else
                                                    <img src="/image/sp1.png" class="card-img-top" alt="{{ $brandProduct->name }}" style="height: 150px; object-fit: cover;">
                                                    @endif
                                                </a>

                                                @if($brandProduct->isOnSale)
                                                <span class="badge discount-tag position-absolute top-0 end-0 m-2">
                                                    -{{ $brandProduct->discount_percentage }}%
                                                </span>
                                                @endif
                                            </div>

                                            <div class="card-body d-flex flex-column p-3">
                                                <a href="{{ route('products.show', $brandProduct->slug ?? $brandProduct->id) }}" class="text-decoration-none text-dark">
                                                    <h6 class="card-title small mb-2">{{ Str::limit($brandProduct->name, 50) }}</h6>
                                                </a>

                                                <div class="mt-auto">
                                                    <div class="d-flex justify-content-between align-items-center">
                                                        @if($brandProduct->isOnSale)
                                                        <span class="sale-price fw-bold small">{{ number_format($brandProduct->sale_price) }}đ</span>
                                                        <span class="text-muted small ms-1 text-decoration-line-through">{{ number_format($brandProduct->price) }}đ</span>
                                                        @else
                                                        <span class="text-primary fw-bold small">{{ number_format($brandProduct->price) }}đ</span>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                            @endif -->

                            <!-- Sản phẩm cùng danh mục -->
                            <!-- @if($sameCategoryProducts->count() > 0)
                            <div class="related-products mb-5 mt-5">
                                <div class="d-flex align-items-center justify-content-between mb-4">
                                    <h4 class="mb-0 text-center">Sản phẩm cùng danh mục {{ $product->category ? $product->category->name : '' }}</h4>
                                    @if($product->category && $product->category->slug)
                                    <a href="{{ route('products.category', ['slug' => $product->category->slug]) }}" class="btn btn-outline-primary btn-sm">Xem tất cả</a>
                                    @endif
                                </div>
                                <div class="row g-4">
                                    @foreach($sameCategoryProducts as $categoryProduct)
                                    <div class="col">
                                        <div class="card h-100 border-0 shadow-sm product-card">
                                            <div class="position-relative">
                                                <a href="{{ route('products.show', $categoryProduct->slug ?? $categoryProduct->id) }}" class="text-decoration-none">
                                                    @if($categoryProduct->baseImage)
                                                    <img src="{{ $categoryProduct->baseImage->url }}" class="card-img-top" alt="{{ $categoryProduct->name }}" style="height: 150px; object-fit: cover;">
                                                    @else
                                                    <img src="/image/sp1.png" class="card-img-top" alt="{{ $categoryProduct->name }}" style="height: 150px; object-fit: cover;">
                                                    @endif
                                                </a>

                                                @if($categoryProduct->isOnSale)
                                                <span class="badge bg-danger position-absolute top-0 end-0 m-2">
                                                    -{{ $categoryProduct->discount_percentage }}%
                                                </span>
                                                @endif
                                            </div>

                                            <div class="card-body d-flex flex-column p-3">
                                                <a href="{{ route('products.show', $categoryProduct->slug ?? $categoryProduct->id) }}" class="text-decoration-none text-dark">
                                                    <h6 class="card-title small mb-2">{{ Str::limit($categoryProduct->name, 50) }}</h6>
                                                </a>

                                                <div class="mt-auto">
                                                    <div class="d-flex justify-content-between align-items-center">
                                                        @if($categoryProduct->isOnSale)
                                                        <span class="text-danger fw-bold small">{{ number_format($categoryProduct->sale_price) }}đ</span>
                                                        <span class="text-muted small text-decoration-line-through">{{ number_format($categoryProduct->price) }}đ</span>
                                                        @else
                                                        <span class="text-primary fw-bold small">{{ number_format($categoryProduct->price) }}đ</span>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                            @endif -->
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Product Tabs -->
        <div class="product-tabs-section py-3 bg-light">
            <div class="container">
                <div class="product-tabs">
                    <ul class="nav nav-tabs" id="productTabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="specifications-tab" data-bs-toggle="tab" data-bs-target="#specifications" type="button" role="tab">
                                Thông số kỹ thuật
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="description-tab" data-bs-toggle="tab" data-bs-target="#description" type="button" role="tab">
                                Mô tả sản phẩm
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="reviews-tab" data-bs-toggle="tab" data-bs-target="#reviews" type="button" role="tab">
                                Đánh giá ({{ $product->reviews_count }})
                            </button>
                        </li>
{{--                        @if($product->activeVariants && $product->activeVariants->count() > 0)--}}
{{--                        <li class="nav-item" role="presentation">--}}
{{--                            <button class="nav-link" id="variants-tab" data-bs-toggle="tab" data-bs-target="#variants" type="button" role="tab">--}}
{{--                                Phiên bản ({{ $product->activeVariants->count() }})--}}
{{--                            </button>--}}
{{--                        </li>--}}
{{--                        @endif--}}
                    </ul>

                    <div class="tab-content" id="productTabsContent">
                        <!-- Description Tab -->
                        <div class="tab-pane fade" id="description" role="tabpanel">
                            <div class="tab-content-wrapper">
                                <div class="product-description">
                                    {!! $product->description !!}
                                </div>
                            </div>
                        </div>

                        <!-- Specifications Tab -->
                        <div class="tab-pane fade show active" id="specifications" role="tabpanel">
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
        </div>

        <!-- Reviews Tab -->
        <div class="tab-pane fade" id="reviews" role="tabpanel">
            <div class="tab-content-wrapper" style="display: none;">
                <div class="row">
                    <div class="col-md-4">
                        <div class="rating-summary text-center">
                            <h3 class="rating-title">Đánh giá trung bình</h3>
                            <div class="average-rating">
                                <span class="rating-number">{{ number_format($product->average_rating, 1) }}</span>
                                <div class="rating-stars">
                                    @for($i = 1; $i <= 5; $i++)
                                        <i class="fas fa-star {{ $i <= $product->average_rating ? 'text-warning' : 'text-muted' }}"></i>
                                        @endfor
                                </div>
                                <div class="total-reviews">{{ $product->reviews_count }} nhận xét</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="rating-bars">
                            @php
                            $totalReviews = $product->reviews_count;
                            $approvedReviews = $product->reviews->where('is_approved', true);
                            $ratingCounts = [
                            5 => $approvedReviews->where('rating', 5)->count(),
                            4 => $approvedReviews->where('rating', 4)->count(),
                            3 => $approvedReviews->where('rating', 3)->count(),
                            2 => $approvedReviews->where('rating', 2)->count(),
                            1 => $approvedReviews->where('rating', 1)->count(),
                            ];
                            @endphp
                            @foreach($ratingCounts as $stars => $count)
                            <div class="rating-bar-row">
                                <span class="stars-count">{{ $stars }} sao</span>
                                <div class="progress">
                                    <div class="progress-bar bg-warning"
                                        role="progressbar"
                                        style="width: {{ $totalReviews > 0 ? round(($count / $totalReviews * 100), 1) : 0 }}%"
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
                            @auth('customer')
                            <button class="btn btn-primary" onclick="openReviewForm()">
                                <i class="fas fa-edit me-2"></i>Viết Bình luận
                            </button>
                            @else
                            <button class="btn btn-primary" onclick="redirectToLogin()">
                                <i class="fas fa-sign-in-alt me-2"></i>Đăng nhập để đánh giá
                            </button>
                            @endauth
                        </div>
                    </div>
                </div>

                @if($product->reviews_count > 0)
                <div class="reviews-section mt-4" id="reviewsList">
                    <h4 class="mb-3">{{ $product->reviews_count }} bình luận cho sản phẩm này</h4>
                    @foreach($product->reviews->where('is_approved', true) as $review)
                    <div class="review-item">
                        <div class="review-header">
                            <div class="reviewer-info">
                                <div class="reviewer-name">{{ $review->customer_name }}</div>
                                <div class="review-date">{{ $review->created_at->format('d/m/Y H:i') }}</div>
                            </div>
                            <div class="review-rating">
                                @for($i = 1; $i <= 5; $i++)
                                    <i class="fas fa-star {{ $i <= $review->rating ? 'text-warning' : 'text-muted' }}"></i>
                                @endfor
                            </div>
                        </div>
                        @if($review->title)
                        <div class="review-title">
                            <strong>{{ $review->title }}</strong>
                        </div>
                        @endif
                        <div class="review-content">
                            {{ $review->comment }}
                        </div>

                        <!-- Review Images -->
                        @if($review->images && count($review->images) > 0)
                        <div class="review-images mt-3">
                            <div class="review-images-grid">
                                @foreach($review->images as $image)
                                <div class="review-image-item">
                                    <img src="{{ $image['thumbnail'] ?? $image['original'] ?? $image }}"
                                         alt="Ảnh đánh giá"
                                         class="review-image-thumb"
                                         onclick="openImageModal('{{ $image['original'] ?? $image }}', '{{ $review->customer_name }}', '{{ $review->created_at->format('d/m/Y') }}')">
                                </div>
                                @endforeach
                            </div>
                        </div>
                        @endif
                    </div>
                    @endforeach
                </div>
                @else
                <div class="no-reviews text-center mt-4">
                    <p class="text-muted">Chưa có đánh giá nào cho sản phẩm này.</p>
                    <p class="text-muted">Hãy là người đầu tiên đánh giá!</p>
                </div>
                @endif
            </div>
        </div>

        <!-- Variants Tab -->
        @if($product->activeVariants && $product->activeVariants->count() > 0)
        <div class="tab-pane fade" id="variants" role="tabpanel">
            <div class="tab-content-wrapper">
                <div class="variants-detail-section">
                    <h4 class="mb-4">Chi tiết các phiên bản sản phẩm</h4>
                    <div class="variants-table">
                        <div class="variants-header">
                            <div class="variant-col-name">Tên phiên bản</div>
                            <div class="variant-col-code">Mã</div>
                            <div class="variant-col-price">Giá</div>
                            <div class="variant-col-stock">Tồn kho</div>
                            <div class="variant-col-status">Trạng thái</div>
                        </div>
                        @foreach($product->activeVariants as $variant)
                        <div class="variant-row">
                            <div class="variant-col-name">
                                <strong>{{ $variant->name }}</strong>
                            </div>
                            <div class="variant-col-code">
                                <span class="badge bg-secondary">{{ $variant->code }}</span>
                            </div>
                            <div class="variant-col-price">
                                @if($variant->isOnSale)
                                    <div class="price-info">
                                        <span class="sale-price">{{ number_format($variant->price_sale) }}₫</span>
                                        <span class="original-price">{{ number_format($variant->price) }}₫</span>
                                        <span class="discount-badge">-{{ $variant->discount_percentage }}%</span>
                                    </div>
                                @else
                                    <span class="normal-price">{{ number_format($variant->price) }}₫</span>
                                @endif
                                <div class="vat-notice-variant">
                                    <small class="text-muted">Chưa bao gồm VAT 8%</small>
                                </div>
                            </div>
                            <div class="variant-col-stock">
                                @if($variant->isInStock)
                                    <span class="stock-available">{{ $variant->quantity }} sản phẩm</span>
                                @else
                                    <span class="stock-unavailable">Hết hàng</span>
                                @endif
                            </div>
                            <div class="variant-col-status">
                                @if($variant->is_active)
                                    <span class="status-active">Đang bán</span>
                                @else
                                    <span class="status-inactive">Tạm ngưng</span>
                                @endif
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>
</div>
</section>






<!-- Related Products -->
@if($relatedProducts->count() > 0)
<section class="suggested-products-section py-5">
    <div class="container">
        <h2 class="section-title">GỢI Ý DÀNH RIÊNG CHO BẠN</h2>
        <!-- <div class="row"> -->
        <div class="row ">
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
            'rating' => number_format($product->average_rating, 1),
            'review_count' => $product->reviews_count,
            'sold_count' => $product->sold_count,
            'coupon' => $product->coupon
            ];
            });
            @endphp

                @foreach($suggestedProducts as $suggestedProduct)
                <div class="product-card col-6 col-lg-3 mx-0 mx-lg-3 mt-3">
                    <a href="{{ route('products.show', $suggestedProduct['slug'] ?? $suggestedProduct['id']) }}" class="product-link">
                        <div class="product-image">
                            <img src="{{ $suggestedProduct['image'] }}" alt="{{ $suggestedProduct['name'] }}" class="card-img-top">
                            @if($suggestedProduct['is_on_sale'])
                            <div class="discount-tag">-{{ $suggestedProduct['discount_percentage'] }}%</div>
                            @endif
                        </div>

                        <div class="product-info">
                            <h3 class="product-name">{{ $suggestedProduct['name'] }}</h3>

                            <div class="product-rating">
                                <div class="stars">
                                    <span class="rating-score">{{ $suggestedProduct['rating'] }}</span>
                                    @for($i = 1; $i <= 5; $i++)
                                        <i class="fas fa-star {{ $i <= $suggestedProduct['rating'] ? 'text-warning' : 'text-muted' }}"></i>
                                        @endfor
                                        <span class="rating-count">({{ $suggestedProduct['review_count'] }})</span>
                                </div>
                                @if($suggestedProduct['sold_count'])
                                <div class="sold-count">{{ $suggestedProduct['sold_count'] }} đã bán</div>
                                @endif
                            </div>

                            <div class="product-price text-center">
                                @if($suggestedProduct['is_on_sale'])
                                <span class="sale-price">{{ number_format($suggestedProduct['sale_price']) }}đ</span>
                                <span class="original-price">{{ number_format($suggestedProduct['price']) }}đ</span>
                                <!-- <span class="discount-percent">{{ $suggestedProduct['discount_percentage'] }}%</span> -->
                                @else
                                <span class="sale-price">{{ number_format($suggestedProduct['price']) }}đ</span>
                                @endif
                            </div>

                            @if($suggestedProduct['coupon'])
                            <div class="coupon-tag">
                                <i class="fas fa-ticket-alt"></i> {{ $suggestedProduct['coupon'] }}
                            </div>
                            @endif
                        </div>
                    </a>
                </div>
                @endforeach

        </div>
    </div>
    <!-- </div> -->
</section>
@endif

<!-- Review Modal -->
@auth('customer')
<div class="modal fade" id="reviewModal" tabindex="-1" aria-labelledby="reviewModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="reviewModalLabel">
                    <i class="fas fa-star text-warning me-2"></i>Đánh giá sản phẩm
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="reviewForm" action="{{ route('reviews.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="product_id" value="{{ $product->id }}">

                <div class="modal-body">
                    <!-- Product Info -->
                    <div class="product-review-info mb-4">
                        <div class="d-flex align-items-center">
                            @if($product->baseImage)
                            <img src="{{ asset($product->baseImage->url) }}" alt="{{ $product->name }}" class="review-product-image me-3">
                            @else
                            <img src="/image/sp1.png" alt="{{ $product->name }}" class="review-product-image me-3">
                            @endif
                            <div>
                                <h6 class="mb-1">{{ $product->name }}</h6>
                                <p class="text-muted mb-0">{{ $product->sku ?? 'SW-' . $product->id }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Rating -->
                    <div class="mb-4">
                        <label class="form-label fw-bold">
                            <i class="fas fa-star text-warning me-1"></i>Đánh giá của bạn <span class="text-danger">*</span>
                        </label>
                        <div class="rating-input d-flex align-items-center">
                            <div class="star-rating me-3">
                                @for($i = 1; $i <= 5; $i++)
                                <i class="fas fa-star star-item" data-rating="{{ $i }}"></i>
                                @endfor
                            </div>
                            <span class="rating-text text-muted">Chọn số sao</span>
                        </div>
                        <input type="hidden" name="rating" id="ratingInput" required>
                        <div class="invalid-feedback" id="ratingError"></div>
                    </div>

                    <!-- Title -->
                    <div class="mb-4">
                        <label for="reviewTitle" class="form-label fw-bold">
                            <i class="fas fa-heading me-1"></i>Tiêu đề (tùy chọn)
                        </label>
                        <input type="text" class="form-control" id="reviewTitle" name="title" placeholder="Nhập tiêu đề cho đánh giá của bạn..." maxlength="255">
                        <div class="form-text">Tối đa 255 ký tự</div>
                        <div class="invalid-feedback" id="titleError"></div>
                    </div>

                    <!-- Comment -->
                    <div class="mb-4">
                        <label for="reviewComment" class="form-label fw-bold">
                            <i class="fas fa-comment me-1"></i>Nội dung đánh giá <span class="text-danger">*</span>
                        </label>
                        <textarea class="form-control" id="reviewComment" name="comment" rows="5" placeholder="Chia sẻ trải nghiệm của bạn về sản phẩm này..." required minlength="10" maxlength="1000"></textarea>
                        <div class="form-text">
                            <span id="commentCount">0</span>/1000 ký tự (tối thiểu 10 ký tự)
                        </div>
                        <div class="invalid-feedback" id="commentError"></div>
                    </div>

                    <!-- Images Upload -->
                    <div class="mb-4">
                        <label for="reviewImages" class="form-label fw-bold">
                            <i class="fas fa-images me-1"></i>Hình ảnh (tùy chọn)
                        </label>
                        <div class="image-upload-container">
                            <div class="image-upload-dropzone" id="imageDropzone">
                                <div class="dropzone-content">
                                    <i class="fas fa-cloud-upload-alt fa-2x text-muted mb-2"></i>
                                    <p class="mb-2">Kéo thả ảnh vào đây hoặc</p>
                                    <button type="button" class="btn btn-outline-primary btn-sm" onclick="document.getElementById('reviewImages').click()">
                                        <i class="fas fa-plus me-1"></i>Chọn ảnh
                                    </button>
                                </div>
                                <input type="file" id="reviewImages" name="images[]" multiple accept="image/*" class="d-none">
                            </div>
                            <div class="form-text">
                                Tối đa 5 ảnh, mỗi ảnh không quá 5MB. Định dạng: JPG, PNG, GIF
                            </div>
                            <div class="invalid-feedback" id="imagesError"></div>
                        </div>

                        <!-- Preview Images -->
                        <div class="preview-images mt-3" id="previewImages" style="display: none;">
                            <div class="preview-images-grid"></div>
                        </div>
                    </div>

                    <!-- Review Guidelines -->
                    <div class="review-guidelines">
                        <h6 class="text-primary">
                            <i class="fas fa-info-circle me-1"></i>Hướng dẫn viết đánh giá
                        </h6>
                        <ul class="small text-muted mb-0">
                            <li>Chia sẻ trải nghiệm thực tế của bạn với sản phẩm</li>
                            <li>Tránh sử dụng ngôn ngữ không phù hợp</li>
                            <li>Đánh giá sẽ được duyệt trước khi hiển thị</li>
                            <li>Mỗi khách hàng chỉ có thể đánh giá một lần cho mỗi sản phẩm</li>
                        </ul>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times me-1"></i>Hủy
                    </button>
                    <button type="submit" class="btn btn-primary" id="submitReviewBtn">
                        <i class="fas fa-paper-plane me-1"></i>Gửi đánh giá
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endauth

<!-- Image Modal -->
<div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="imageModalLabel">
                    <i class="fas fa-image me-2"></i>Ảnh từ khách hàng
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                <img id="modalImage" src="" alt="Ảnh đánh giá" class="img-fluid">
                <div class="mt-3">
                    <div class="reviewer-info">
                        <strong id="modalReviewerName"></strong>
                        <small class="text-muted ms-2" id="modalReviewDate"></small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
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

    .sale-badge,
    .featured-badge {
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

    /* Mobile Responsive for Product Gallery */
    @media (max-width: 768px) {
        /* Product Gallery Layout */
        .product-gallery {
            flex-direction: column !important;
        }

        .thumbnail-container {
            width: 100% !important;
            margin-right: 0 !important;
            margin-bottom: 15px;
            order: 2;
            position: relative;
        }

        .thumbnail-wrapper {
            flex-direction: row !important;
            max-height: none !important;
            overflow-x: auto !important;
            overflow-y: hidden !important;
            gap: 8px;
            padding: 5px 0;
            justify-content: flex-start;
            scroll-behavior: smooth;
            -webkit-overflow-scrolling: touch;
        }

        .thumbnail-item {
            width: 60px;
            height: 60px;
            flex-shrink: 0;
            margin-bottom: 0 !important;
            cursor: pointer;
            transition: transform 0.2s ease;
        }

        .thumbnail-item:hover {
            transform: scale(1.05);
        }

        .main-image-container {
            order: 1;
            margin-bottom: 15px;
            width: 100%;
        }

        .main-image {
            height: 300px;
        }

        /* Custom scrollbar for horizontal thumbnail scroll */
        .thumbnail-wrapper::-webkit-scrollbar {
            height: 4px;
        }

        .thumbnail-wrapper::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 2px;
        }

        .thumbnail-wrapper::-webkit-scrollbar-thumb {
            background: #888;
            border-radius: 2px;
        }

        .thumbnail-wrapper::-webkit-scrollbar-thumb:hover {
            background: #555;
        }

        /* Hide scrollbar but keep functionality */
        .thumbnail-wrapper::-webkit-scrollbar {
            display: none;
        }

        .thumbnail-wrapper {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }

        /* Slider navigation dots */
        .slider-dots {
            display: flex;
            justify-content: center;
            gap: 8px;
            margin-top: 10px;
        }

        .slider-dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: #ddd;
            cursor: pointer;
            transition: background 0.3s ease;
        }

        .slider-dot.active {
            background: #007bff;
        }

        /* Slider navigation arrows */
        .slider-nav {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            background: rgba(255, 255, 255, 0.9);
            border: none;
            border-radius: 50%;
            width: 32px;
            height: 32px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            z-index: 10;
            transition: all 0.3s ease;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        .slider-nav:hover {
            background: rgba(255, 255, 255, 1);
            transform: translateY(-50%) scale(1.1);
        }

        .slider-nav.prev {
            left: 5px;
        }

        .slider-nav.next {
            right: 5px;
        }

        .slider-nav i {
            font-size: 14px;
            color: #333;
        }

        /* Product Info Layout */
        .product-info .row {
            flex-direction: column !important;
        }

        .product-info .col-md-8 {
            width: 100% !important;
            margin-bottom: 20px;
        }

        .product-info .col-md-4 {
            width: 100% !important;
        }

        /* Hide delivery info on mobile to save space */
        .delivery-info {
            display: none !important;
        }

        /* Adjust spacing for mobile */
        .product-detail-section {
            padding: 20px 0 !important;
        }

        .product-info {
            padding: 15px !important;
        }

        /* Product title responsive */
        .product-title {
            font-size: 1.3rem !important;
            line-height: 1.4 !important;
        }

        /* Price responsive */
        .current-price {
            font-size: 1.3rem !important;
        }

        .original-price {
            font-size: 1rem !important;
        }

        /* Action buttons responsive */
        .action-buttons .btn-lg {
            padding: 12px 20px !important;
            font-size: 0.95rem !important;
        }

        /* Quantity controls responsive */
        .quantity-section {
            flex-direction: column !important;
            align-items: flex-start !important;
            gap: 10px !important;
        }

        .quantity-controls {
            align-self: flex-start !important;
        }

        /* Variants responsive */
        .variants-container {
            gap: 8px !important;
        }

        .variant-label {
            padding: 12px !important;
        }

        .variant-info {
            flex-direction: column !important;
            align-items: flex-start !important;
            gap: 8px !important;
        }
    }

    @media (max-width: 576px) {
        /* Gallery responsive for small screens */
        .main-image {
            height: 250px;
        }

        .thumbnail-item {
            width: 50px;
            height: 50px;
        }

        .featured-badge {
            top: 10px;
            left: 10px;
            padding: 6px 10px;
            font-size: 0.7rem;
        }

        .sale-badge {
            top: 10px;
            right: 10px;
            padding: 6px 10px;
            font-size: 0.7rem;
        }

        /* Product info responsive for small screens */
        .product-title {
            font-size: 1.2rem !important;
        }

        .current-price {
            font-size: 1.2rem !important;
        }

        .action-buttons .btn-lg {
            padding: 10px 16px !important;
            font-size: 0.9rem !important;
        }

        .product-info {
            padding: 10px !important;
        }

        .product-detail-section {
            padding: 15px 0 !important;
        }

        /* Container padding for small screens */
        .container {
            padding-left: 10px !important;
            padding-right: 10px !important;
        }

        /* Breadcrumb responsive */
        .breadcrumb {
            font-size: 0.85rem;
        }

        .breadcrumb-item {
            margin-right: 5px;
        }
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
        transition: all 0.3s ease;
        min-height: 2.5rem;
        display: flex;
        align-items: center;
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

    .rating-text,
    .sold-count {
        color: #6c757d;
        font-size: 0.9rem;
    }

    .product-price {
        display: flex !important;
        flex-direction: column !important;
        align-items: center !important;
        gap: 8px;
        text-align: left !important;
        justify-content: center !important;
        width: 100% !important;
    }

    .price-row {
        display: flex !important;
        align-items: center !important;
        gap: 15px;
        flex-wrap: wrap;
        justify-content: flex-start !important;
        text-align: left !important;
        width: 100% !important;
    }

    .current-price {
        font-size: 1.5rem;
        font-weight: bold;
        color: #dc3545;
        display: inline-block;
        margin-right: 10px;
    }

    .original-price {
        font-size: 1.2rem;
        color: #6c757d;
        text-decoration: line-through;
        display: inline-block;
        margin-right: 10px;
    }

    .discount-badge {
        background: linear-gradient(135deg, #ff6b6b 0%, #ee5a52 100%);
        color: white;
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 0.85rem;
        font-weight: 700;
        box-shadow: 0 2px 8px rgba(238, 90, 82, 0.3);
        display: inline-block;
        position: relative;
        text-shadow: 0 1px 2px rgba(0, 0, 0, 0.1);
        vertical-align: middle;
    }

    .discount-badge::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(135deg, rgba(255, 255, 255, 0.2) 0%, transparent 100%);
        border-radius: 20px;
        pointer-events: none;
    }

    .vat-notice {
        margin-top: 5px;
        padding-left: 2px;
        text-align: left !important;
        width: 100% !important;
        justify-content: flex-start !important;
        align-items: flex-start !important;
    }

    .vat-notice small {
        font-style: italic;
        font-size: 0.82rem;
        color: #8e8e8e !important;
        font-weight: 400;
        letter-spacing: 0.2px;
    }

    .vat-notice-variant {
        margin-top: 3px;
    }

    .vat-notice-variant small {
        font-style: italic;
        font-size: 0.75rem;
        color: #6c757d !important;
        display: block;
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

    .option-btn:hover,
    .option-btn.active {
        border-color: #007bff;
        background: #007bff;
        color: white;
    }

    /* Product Variants */
    .variants-section {
        margin-bottom: 20px;
    }

    .variants-label {
        display: block;
        font-weight: 600;
        margin-bottom: 10px;
        color: #2c3e50;
    }

    .variants-container {
        display: flex;
        flex-direction: column;
        gap: 10px;
    }

    .variant-item {
        position: relative;
    }

    .variant-none .variant-label {
        border-color: #28a745;
        background: #f8fff9;
    }

    .variant-none .variant-label:hover {
        border-color: #28a745;
        background: #e8f5e8;
    }

    .variant-none .variant-radio:checked + .variant-label {
        border-color: #28a745;
        background: #d4edda;
        box-shadow: 0 2px 8px rgba(40, 167, 69, 0.1);
    }

    .variant-radio {
        display: none;
    }

    .variant-label {
        display: block;
        padding: 15px;
        border: 2px solid #e9ecef;
        border-radius: 8px;
        cursor: pointer;
        transition: all 0.3s ease;
        background: white;
    }

    .variant-label:hover {
        border-color: #007bff;
        background: #f8f9fa;
    }

    .variant-radio:checked + .variant-label {
        border-color: #007bff;
        background: #e3f2fd;
        box-shadow: 0 2px 8px rgba(0, 123, 255, 0.1);
    }

    .variant-info {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 10px;
    }

    .variant-name {
        font-weight: 600;
        color: #2c3e50;
        flex: 1;
        min-width: 120px;
    }

    .variant-code {
        color: #6c757d;
        font-size: 0.85rem;
        background: #f8f9fa;
        padding: 2px 6px;
        border-radius: 4px;
    }

    .variant-price-container {
        display: flex;
        align-items: center;
        gap: 8px;
        flex-wrap: wrap;
    }

    .variant-sale-price {
        font-weight: bold;
        color: #dc3545;
        font-size: 1.1rem;
    }

    .variant-original-price {
        color: #6c757d;
        text-decoration: line-through;
        font-size: 0.9rem;
    }

    .variant-discount {
        background: #dc3545;
        color: white;
        padding: 2px 6px;
        border-radius: 4px;
        font-size: 0.8rem;
        font-weight: bold;
    }

    .variant-price-normal {
        font-weight: bold;
        color: #007bff;
        font-size: 1.1rem;
    }

    .variant-stock {
        font-size: 0.85rem;
    }

    .in-stock {
        color: #28a745;
    }

    .out-of-stock {
        color: #dc3545;
        font-weight: 500;
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
        background: #007bff;
        border-color: #007bff;
    }

    .action-buttons .btn-primary:hover {
        /* background: #e66000; */
        border-color: #007bff;
    }

    .action-buttons .btn-outline-primary {
        color: #007bff;
        border-color: #007bff;
    }

    .action-buttons .btn-outline-primary:hover {
        /* background: #007bff; */
        border-color: #007bff;
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

    .delivery-item,
    .brand-item {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 10px;
        background: #fff;
        border-radius: 8px;
        transition: all 0.3s ease;
    }

    .delivery-item:hover,
    .brand-item:hover {
        transform: translateX(5px);
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
    }

    .delivery-item i,
    .brand-item i {
        font-size: 20px;
        color: #007bff;
        width: 36px;
        height: 36px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: rgba(255, 107, 0, 0.1);
        border-radius: 50%;
    }

    .delivery-text,
    .brand-text {
        display: flex;
        flex-direction: column;
    }

    .delivery-text strong,
    .brand-text strong {
        color: #333;
        font-size: 0.9rem;
        margin-bottom: 2px;
    }

    .delivery-text span,
    .brand-text span {
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
        clear: both;
        overflow: hidden;
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

    /* Reduce padding for variants tab specifically */
    #variants .tab-content-wrapper {
        padding: 10px 15px;
    }

    /* Fix tab content positioning */
    .tab-pane {
        clear: both;
        overflow: hidden;
    }

    /* Remove extra spacing in variants tab */
    #variants .variants-detail-section {
        margin: 0;
        padding: 0;
    }

    /* Ensure reviews tab doesn't affect variants tab */
    #reviews .row {
        margin: 0;
    }

    #reviews .row::after {
        clear: both;
        content: "";
        display: table;
    }

    /* Specifications */
    .specifications-table {
        display: flex;
        flex-direction: column;
        gap: 15px;
    }

    .basic-specs,
    .full-specs {
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

    .basic-specs,
    .full-specs {
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
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
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

    /* Variants Tab Styles */
    .variants-detail-section {
        padding: 0;
        clear: both;
        overflow: hidden;
    }

    .variants-detail-section h4 {
        margin-bottom: 15px !important;
        margin-top: 0 !important;
        font-weight: 600;
        color: #333;
    }

    .variants-table {
        border: 1px solid #e9ecef;
        border-radius: 8px;
        overflow: hidden;
        margin-top: 0;
        margin-bottom: 0;
        width: 100%;
        clear: both;
        max-width: 100%;
        table-layout: fixed;
    }

    .variants-header {
        display: grid;
        grid-template-columns: 2.5fr 1fr 1.8fr 1fr 1fr;
        gap: 5px;
        background: #f8f9fa;
        padding: 12px 8px;
        font-weight: 600;
        color: #495057;
        border-bottom: 1px solid #e9ecef;
    }

    .variant-row {
        display: grid;
        grid-template-columns: 2.5fr 1fr 1.8fr 1fr 1fr;
        gap: 5px;
        padding: 12px 8px;
        border-bottom: 1px solid #f0f0f0;
        align-items: center;
        transition: background-color 0.3s ease;
    }

    .variant-row:hover {
        background: #f8f9fa;
    }

    .variant-row:last-child {
        border-bottom: none;
    }

    .variant-col-name {
        font-weight: 500;
    }

    .variant-col-code .badge {
        font-size: 0.8rem;
        padding: 4px 8px;
    }

    .price-info {
        display: flex;
        flex-direction: column;
        gap: 2px;
    }

    .sale-price {
        font-weight: bold;
        color: #3498db;
        font-size: 1rem;
    }

    .original-price {
        color: #6c757d;
        text-decoration: line-through;
        font-size: 0.85rem;
    }

    .variant-col-price .discount-badge {
        background: linear-gradient(135deg, #ff6b6b 0%, #ee5a52 100%);
        color: white;
        padding: 3px 8px;
        border-radius: 12px;
        font-size: 0.7rem;
        font-weight: 600;
        align-self: flex-start;
        box-shadow: 0 1px 4px rgba(238, 90, 82, 0.25);
        text-shadow: 0 1px 1px rgba(0, 0, 0, 0.1);
    }

    .normal-price {
        font-weight: bold;
        color: #007bff;
        font-size: 1rem;
    }

    .stock-available {
        color: #28a745;
        font-weight: 500;
    }

    .stock-unavailable {
        color: #dc3545;
        font-weight: 500;
    }

    .status-active {
        color: #28a745;
        font-weight: 500;
    }

    .status-inactive {
        color: #6c757d;
        font-weight: 500;
    }

    @media (max-width: 768px) {
        .variants-header,
        .variant-row {
            grid-template-columns: 1fr;
            gap: 10px;
        }

        .variants-header {
            display: none;
        }

        .variant-row {
            border: 1px solid #e9ecef;
            border-radius: 8px;
            margin-bottom: 10px;
            padding: 15px;
        }

        .variant-col-name::before {
            content: "Tên phiên bản: ";
            font-weight: 600;
            color: #495057;
        }

        .variant-col-code::before {
            content: "Mã: ";
            font-weight: 600;
            color: #495057;
        }

        .variant-col-price::before {
            content: "Giá: ";
            font-weight: 600;
            color: #495057;
        }

        .variant-col-stock::before {
            content: "Tồn kho: ";
            font-weight: 600;
            color: #495057;
        }

        .variant-col-status::before {
            content: "Trạng thái: ";
            font-weight: 600;
            color: #495057;
        }
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
        /* margin: 0 -10px; */
    }

    .product-card {
        background: white;
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
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

    /* Review Styles */
    .review-title {
        margin-bottom: 8px;
        color: #2c3e50;
    }

    .review-title strong {
        font-size: 1rem;
    }

    .no-reviews {
        padding: 40px 20px;
        background: #f8f9fa;
        border-radius: 8px;
    }

    /* Review Modal Styles */
    .review-product-image {
        width: 60px;
        height: 60px;
        object-fit: cover;
        border-radius: 8px;
        border: 1px solid #dee2e6;
    }

    .star-rating {
        font-size: 1.5rem;
        cursor: pointer;
    }

    .star-rating .star-item {
        color: #e9ecef;
        transition: all 0.2s ease;
        margin-right: 4px;
    }

    .star-rating .star-item:hover,
    .star-rating .star-item.active {
        color: #ffc107;
        transform: scale(1.1);
    }

    .star-rating .star-item:hover ~ .star-item {
        color: #e9ecef;
        transform: scale(1);
    }

    .rating-input {
        padding: 15px;
        background: #f8f9fa;
        border-radius: 8px;
        border: 1px solid #dee2e6;
    }

    .rating-text {
        font-size: 0.9rem;
        font-weight: 500;
    }

    .review-guidelines {
        background: #e7f3ff;
        padding: 15px;
        border-radius: 8px;
        border-left: 4px solid #007bff;
    }

    .review-guidelines ul {
        padding-left: 20px;
    }

    .review-guidelines li {
        margin-bottom: 4px;
    }

    #commentCount {
        font-weight: 600;
        color: #007bff;
    }

    /* Form validation styles */
    .is-invalid {
        border-color: #dc3545;
    }

    .invalid-feedback {
        display: block;
        color: #dc3545;
        font-size: 0.875rem;
        margin-top: 0.25rem;
    }

    /* Loading state for submit button */
    .btn-loading {
        position: relative;
        pointer-events: none;
    }

    .btn-loading::after {
        content: '';
        position: absolute;
        top: 50%;
        left: 50%;
        width: 16px;
        height: 16px;
        margin: -8px 0 0 -8px;
        border: 2px solid transparent;
        border-top-color: #ffffff;
        border-radius: 50%;
        animation: spin 1s linear infinite;
    }

    /* Responsive */
    /* Power Attribute */
    .power-attribute {
        margin-top: 10px;
    }

    /* Bootstrap Override for Mobile */
    @media (max-width: 768px) {
        /* Override Bootstrap grid system for mobile */
        .col-lg-5 {
            width: 100% !important;
            margin-bottom: 20px;
        }

        .col-lg-7 {
            width: 100% !important;
        }

        /* Ensure proper spacing */
        .mb-4 {
            margin-bottom: 1rem !important;
        }

        /* Fix flexbox issues */
        .d-flex {
            display: flex !important;
        }

        /* Ensure proper text alignment */
        .text-center {
            text-align: center !important;
        }

        .text-left {
            text-align: left !important;
        }
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
            font-size: 1.3rem !important;
        }

        .current-price {
            font-size: 1.3rem !important;
        }

        .action-buttons {
            flex-direction: column !important;
        }

        .btn-lg {
            width: 100% !important;
        }

        .spec-row {
            flex-direction: column !important;
            gap: 5px;
        }

        .spec-label {
            width: 100% !important;
        }

        /* Product info responsive */
        .product-info .row {
            flex-direction: column !important;
        }

        .product-info .col-md-8 {
            width: 100% !important;
            margin-bottom: 20px;
        }

        .product-info .col-md-4 {
            width: 100% !important;
        }

        /* Hide delivery info on mobile to save space */
        .delivery-info {
            display: none !important;
        }

        /* Adjust spacing for mobile */
        .product-detail-section {
            padding: 20px 0 !important;
        }

        .product-info {
            padding: 15px !important;
        }

        /* Additional mobile fixes */
        .product-rating {
            flex-wrap: wrap !important;
            gap: 8px !important;
        }

        .stars {
            flex-wrap: nowrap !important;
        }

        .rating-text,
        .sold-count {
            font-size: 0.8rem !important;
        }

        /* Fix power attribute on mobile */
        .power-info {
            flex-direction: column !important;
            align-items: flex-start !important;
            gap: 5px !important;
        }

        /* Fix variants on mobile */
        .variant-item {
            margin-bottom: 8px !important;
        }

        .variant-label {
            padding: 10px !important;
        }

        .variant-name {
            font-size: 0.9rem !important;
        }

        .variant-code {
            font-size: 0.8rem !important;
        }

        /* Fix quantity controls on mobile */
        .quantity-section {
            flex-direction: column !important;
            align-items: flex-start !important;
            gap: 10px !important;
        }

        .quantity-controls {
            align-self: flex-start !important;
        }
    }

    /* Cart Animation */
    @keyframes cartBounce {
        0%, 20%, 50%, 80%, 100% {
            transform: translateY(0);
        }
        40% {
            transform: translateY(-10px);
        }
        60% {
            transform: translateY(-5px);
        }
    }

    .cart-bounce {
        animation: cartBounce 0.6s ease;
    }

    /* Button Loading State */
    .btn:disabled {
        opacity: 0.7;
        cursor: not-allowed;
    }

    .btn .fa-spinner {
        animation: spin 1s linear infinite;
    }

    @keyframes spin {
        from { transform: rotate(0deg); }
        to { transform: rotate(360deg); }
    }

    /* Notification Animations */
    @keyframes slideInRight {
        from {
            transform: translateX(100%);
            opacity: 0;
        }
        to {
            transform: translateX(0);
            opacity: 1;
        }
    }

    @keyframes slideOutRight {
        from {
            transform: translateX(0);
            opacity: 1;
        }
        to {
            transform: translateX(100%);
            opacity: 0;
        }
    }

    /* Custom notification styles */
    .custom-notification {
        font-family: 'Inter', sans-serif;
        border: none !important;
    }

    .custom-notification .btn-close {
        filter: brightness(0) invert(1);
    }

    /* Image Upload Styles */
    .image-upload-dropzone {
        border: 2px dashed #dee2e6;
        border-radius: 8px;
        padding: 30px;
        text-align: center;
        transition: all 0.3s ease;
        cursor: pointer;
        background: #f8f9fa;
    }

    .image-upload-dropzone:hover,
    .image-upload-dropzone.dragover {
        border-color: #007bff;
        background: #e3f2fd;
    }

    .dropzone-content {
        pointer-events: none;
    }

    .preview-images-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(100px, 1fr));
        gap: 10px;
        max-height: 200px;
        overflow-y: auto;
    }

    .preview-image-item {
        position: relative;
        aspect-ratio: 1;
        border-radius: 8px;
        overflow: hidden;
        border: 2px solid #dee2e6;
    }

    .preview-image-item img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .preview-image-remove {
        position: absolute;
        top: 5px;
        right: 5px;
        background: rgba(220, 53, 69, 0.8);
        color: white;
        border: none;
        border-radius: 50%;
        width: 24px;
        height: 24px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        font-size: 12px;
        transition: all 0.3s ease;
    }

    .preview-image-remove:hover {
        background: rgba(220, 53, 69, 1);
        transform: scale(1.1);
    }

    /* Review Images Styles */
    .review-images-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(80px, 1fr));
        gap: 8px;
        max-width: 400px;
    }

    .review-image-item {
        aspect-ratio: 1;
        border-radius: 6px;
        overflow: hidden;
        cursor: pointer;
        transition: transform 0.3s ease;
    }

    .review-image-item:hover {
        transform: scale(1.05);
    }

    .review-image-thumb {
        width: 100%;
        height: 100%;
        object-fit: cover;
        border: 1px solid #dee2e6;
    }

    /* Customer Photos Gallery */
    .customer-photos-section {
        background: #f8f9fa;
        border-radius: 8px;
        padding: 15px;
        border: 1px solid #e9ecef;
    }

    .customer-photos-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(100px, 1fr));
        gap: 10px;
        max-height: 0;
        overflow: hidden;
        transition: max-height 0.3s ease;
    }

    .customer-photos-grid.expanded {
        max-height: 400px;
        overflow-y: auto;
    }

    .customer-photo-item {
        position: relative;
        aspect-ratio: 1;
        border-radius: 8px;
        overflow: hidden;
        cursor: pointer;
        transition: transform 0.3s ease;
        border: 2px solid transparent;
    }

    .customer-photo-item:hover {
        transform: scale(1.05);
        border-color: #007bff;
    }

    .customer-photo-thumb {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .customer-photo-overlay {
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        background: linear-gradient(transparent, rgba(0, 0, 0, 0.7));
        color: white;
        padding: 5px 8px;
        font-size: 10px;
        opacity: 0;
        transition: opacity 0.3s ease;
    }

    .customer-photo-item:hover .customer-photo-overlay {
        opacity: 1;
    }

    /* Mobile Responsive for Image Features */
    @media (max-width: 768px) {
        .image-upload-dropzone {
            padding: 20px;
        }

        .preview-images-grid {
            grid-template-columns: repeat(auto-fill, minmax(80px, 1fr));
            gap: 8px;
        }

        .review-images-grid {
            grid-template-columns: repeat(auto-fill, minmax(60px, 1fr));
            gap: 6px;
        }

        .customer-photos-grid {
            grid-template-columns: repeat(auto-fill, minmax(80px, 1fr));
            gap: 8px;
        }

        .customer-photos-section {
            margin-left: -15px;
            margin-right: -15px;
            border-radius: 0;
        }

        .modal-dialog {
            margin: 10px;
        }
    }

    @media (max-width: 576px) {
        .preview-images-grid {
            grid-template-columns: repeat(auto-fill, minmax(70px, 1fr));
        }

        .review-images-grid {
            grid-template-columns: repeat(auto-fill, minmax(50px, 1fr));
        }

        .customer-photos-grid {
            grid-template-columns: repeat(auto-fill, minmax(70px, 1fr));
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

    // Handle window resize for mobile slider
    window.addEventListener('resize', function() {
        initializeMobileSlider();
    });

    function initializeProductDetail() {
        // Image gallery functionality
        setupImageGallery();

        // Product options functionality
        setupProductOptions();

        // Quantity controls
        setupQuantityControls();

        // Initialize mobile slider
        initializeMobileSlider();
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
            fullSpecs.scrollIntoView({
                behavior: 'smooth',
                block: 'start'
            });
        } else {
            fullSpecs.style.display = 'none';
            showMore.style.display = 'inline';
            showLess.style.display = 'none';

            // Scroll back to basic specs
            document.querySelector('.basic-specs').scrollIntoView({
                behavior: 'smooth',
                block: 'start'
            });
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

            // Update slider dots if on mobile
            updateSliderDots(thumbnailElement);
        }
    }

    // Slider functionality for mobile
    function slideThumbnails(direction) {
        const wrapper = document.getElementById('thumbnailWrapper');
        if (!wrapper) return;

        const scrollAmount = 200; // Adjust based on thumbnail width + gap
        const currentScroll = wrapper.scrollLeft;

        if (direction === 'prev') {
            wrapper.scrollTo({
                left: currentScroll - scrollAmount,
                behavior: 'smooth'
            });
        } else {
            wrapper.scrollTo({
                left: currentScroll + scrollAmount,
                behavior: 'smooth'
            });
        }
    }

    function slideToThumbnail(index) {
        const wrapper = document.getElementById('thumbnailWrapper');
        const thumbnails = wrapper.querySelectorAll('.thumbnail-item');

        if (thumbnails[index]) {
            // Click the thumbnail to change main image
            thumbnails[index].click();

            // Scroll to the thumbnail
            thumbnails[index].scrollIntoView({
                behavior: 'smooth',
                block: 'nearest',
                inline: 'center'
            });
        }
    }

    function updateSliderDots(activeThumbnail) {
        const dots = document.querySelectorAll('.slider-dot');
        const thumbnails = document.querySelectorAll('.thumbnail-item');

        // Find the index of the active thumbnail
        const activeIndex = Array.from(thumbnails).indexOf(activeThumbnail);

        // Update dots
        dots.forEach((dot, index) => {
            dot.classList.toggle('active', index === activeIndex);
        });
    }

    // Initialize slider on mobile
    function initializeMobileSlider() {
        if (window.innerWidth <= 768) {
            const wrapper = document.getElementById('thumbnailWrapper');
            if (wrapper) {
                // Add touch/swipe support
                let startX = 0;
                let scrollLeft = 0;

                wrapper.addEventListener('touchstart', (e) => {
                    startX = e.touches[0].pageX - wrapper.offsetLeft;
                    scrollLeft = wrapper.scrollLeft;
                });

                wrapper.addEventListener('touchmove', (e) => {
                    if (!startX) return;
                    const x = e.touches[0].pageX - wrapper.offsetLeft;
                    const walk = (x - startX) * 2;
                    wrapper.scrollLeft = scrollLeft - walk;
                });

                wrapper.addEventListener('touchend', () => {
                    startX = 0;
                });
            }
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

        // Variant selection functionality
        setupVariantSelection();
    }

    function setupVariantSelection() {
        const variantRadios = document.querySelectorAll('.variant-radio');
        if (variantRadios.length > 0) {
            variantRadios.forEach(radio => {
                radio.addEventListener('change', function() {
                    if (this.checked) {
                        updateProductPriceForVariant(this.value);
                        updateQuantityMaxForVariant(this.value);
                        updateProductTitle(); // Update product title when a variant is selected
                    }
                });
            });

            // Initialize product title with the first selected variant
            updateProductTitle();
        }
    }

    function updateProductPriceForVariant(variantId) {
        const variantItem = document.querySelector(`[data-variant-id="${variantId}"]`);
        if (variantItem) {
            const variantPrice = variantItem.dataset.variantPrice;
            const currentPriceElement = document.querySelector('.current-price');
            const originalPriceElement = document.querySelector('.original-price');
            const discountBadgeElement = document.querySelector('.discount-badge');

            if (currentPriceElement) {
                currentPriceElement.textContent = new Intl.NumberFormat('vi-VN').format(variantPrice) + '₫';
            }

            // Update product data for cart
            const productElement = document.querySelector('[data-product-id]');
            if (productElement) {
                productElement.dataset.productPrice = variantPrice;
            }
        }
    }

    function updateQuantityMaxForVariant(variantId) {
        const variantItem = document.querySelector(`[data-variant-id="${variantId}"]`);
        if (variantItem) {
            const variantStock = parseInt(variantItem.dataset.variantStock);
            const quantityInput = document.getElementById('quantity');
            const stockInfo = document.querySelector('.stock-info');

            if (quantityInput) {
                quantityInput.max = variantStock;
                if (parseInt(quantityInput.value) > variantStock) {
                    quantityInput.value = variantStock;
                }
            }

            if (stockInfo) {
                if (variantStock > 0) {
                    stockInfo.textContent = `Còn ${variantStock} sản phẩm`;
                    stockInfo.className = 'stock-info text-success';
                } else {
                    stockInfo.textContent = 'Hết hàng';
                    stockInfo.className = 'stock-info text-danger';
                }
            }
        }
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

    function updateProductTitle() {
        const selectedVariant = document.querySelector('input[name="selected_variant"]:checked');
        if (selectedVariant) {
            const variantItem = document.querySelector(`[data-variant-id="${selectedVariant.value}"]`);
            const productTitleElement = document.querySelector('.product-title');
            const productSkuElement = document.querySelector('.product-sku');

            if (variantItem && productTitleElement) {
                const variantName = variantItem.dataset.variantName || '';
                const variantCode = variantItem.dataset.variantCode || '';

                // Add a subtle highlight effect
                productTitleElement.style.backgroundColor = '#fff3cd';
                productTitleElement.style.padding = '5px 10px';
                productTitleElement.style.borderRadius = '5px';

                // Update product title with variant name
                productTitleElement.textContent = variantName;

                // Update SKU with variant code
                if (productSkuElement) {
                    if (variantCode && variantCode !== 'Sản phẩm gốc') {
                        productSkuElement.textContent = `Mã sản phẩm: ${variantCode}`;
                    } else {
                        // Show original product SKU or hide if none
                        const originalSku = '{{ $product->sku ?? "" }}';
                        if (originalSku) {
                            productSkuElement.textContent = `Mã sản phẩm: ${originalSku}`;
                        } else {
                            productSkuElement.textContent = '';
                        }
                    }
                }

                // Remove highlight effect after animation
                setTimeout(() => {
                    productTitleElement.style.backgroundColor = '';
                    productTitleElement.style.padding = '';
                    productTitleElement.style.borderRadius = '';
                }, 500);
            }
        }
    }

    function addToCart(productId) {
        const quantity = document.getElementById('quantity') ? parseInt(document.getElementById('quantity').value) : 1;

        // Validate quantity
        if (quantity < 1 || quantity > 99) {
            showNotification('Số lượng không hợp lệ', 'error');
            return;
        }

        // Get selected variant
        const selectedVariant = document.querySelector('input[name="selected_variant"]:checked');
        let variantId = null;
        let variantName = '';
        let variantCode = '';

        if (selectedVariant && selectedVariant.value !== 'none') {
            variantId = selectedVariant.value;
            const variantItem = document.querySelector(`[data-variant-id="${variantId}"]`);
            if (variantItem) {
                const variantNameElement = variantItem.querySelector('.variant-name');
                const variantCodeElement = variantItem.querySelector('.variant-code');
                variantName = variantNameElement ? variantNameElement.textContent : '';
                variantCode = variantCodeElement ? variantCodeElement.textContent : '';
            }
        }

        // Disable button during request
        const addButton = document.querySelector('.btn[onclick*="addToCart"]');
        if (addButton) {
            addButton.disabled = true;
            addButton.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Đang thêm...';
        }

        // Show loading notification
        // showNotification('Đang thêm vào giỏ hàng...', 'info');

        // Get product data from DOM or create default
        const productElement = document.querySelector(`[data-product-id="${productId}"]`);
        let product;

        // Get the current product title (which may have been updated by variant selection)
        const currentProductTitle = document.querySelector('.product-title');
        const currentProductName = currentProductTitle ? currentProductTitle.textContent.trim() : `Sản phẩm ${productId}`;

        if (productElement) {
            product = {
                id: parseInt(productId),
                name: currentProductName, // Use the current product title (may include variant name)
                model: productElement.dataset.productModel || `SW-${productId}`,
                price: parseInt(productElement.dataset.productPrice) || 1000000,
                quantity: quantity,
                image: productElement.dataset.productImage || '/image/sp1.png',
                variant_id: variantId,
                variant_name: variantName,
                variant_code: variantCode
            };
        } else {
            // Fallback to default product data
            product = {
                id: parseInt(productId),
                name: currentProductName, // Use the current product title
                model: `SW-${productId}`,
                price: 1000000,
                quantity: quantity,
                image: '/image/sp1.png',
                variant_id: variantId,
                variant_name: variantName,
                variant_code: variantCode
            };
        }

        // Use cartManager if available
        if (typeof cartManager !== 'undefined' && cartManager) {
            cartManager.addItem(product);
            // cartManager already shows notification, so we don't need to show another one
        } else {
            // Fallback to localStorage directly
            try {
                const cartKey = 'superwin_cart';
                const existingCart = JSON.parse(localStorage.getItem(cartKey) || '[]');

                // Create unique key for cart item (product + variant)
                const itemKey = variantId ? `${product.id}_${variantId}` : product.id.toString();

                const existingItem = existingCart.find(item => {
                    const existingKey = item.variant_id ? `${item.id}_${item.variant_id}` : item.id.toString();
                    return existingKey === itemKey;
                });

                if (existingItem) {
                    existingItem.quantity += quantity;
                } else {
                    existingCart.push(product);
                }

                localStorage.setItem(cartKey, JSON.stringify(existingCart));

                // Update cart count
                const totalCount = existingCart.reduce((sum, item) => sum + item.quantity, 0);
                updateCartCount(totalCount);

                // Show success notification only for localStorage fallback
                showNotification('Đã thêm vào giỏ hàng thành công!', 'success');
            } catch (error) {
                console.error('Error adding to cart:', error);
                showNotification('Có lỗi xảy ra khi thêm vào giỏ hàng', 'error');
                return; // Exit early if there's an error
            }
        }

        // Re-enable button
        if (addButton) {
            addButton.disabled = false;
            addButton.innerHTML = '<i class="fas fa-shopping-cart me-2"></i>Thêm vào giỏ';
        }
    }

    function updateCartCount(count) {
        const cartCountElements = document.querySelectorAll('.cart-count, .header-cart-count, .cart-badge');
        cartCountElements.forEach(element => {
            element.textContent = count;
            if (count > 0) {
                element.style.display = 'inline-block';
            }
        });
    }

    function animateCartIcon() {
        const cartIcon = document.querySelector('.cart-icon, .fa-shopping-cart');
        if (cartIcon) {
            cartIcon.classList.add('cart-bounce');
            setTimeout(() => {
                cartIcon.classList.remove('cart-bounce');
            }, 600);
        }
    }

    function buyNow(productId = null) {
        const targetProductId = productId || '{{ $product->id ?? "" }}';
        const quantity = document.getElementById('quantity') ? parseInt(document.getElementById('quantity').value) : 1;

        // Validate quantity
        if (quantity < 1 || quantity > 99) {
            showNotification('Số lượng không hợp lệ', 'error');
            return;
        }

        // Get selected variant
        const selectedVariant = document.querySelector('input[name="selected_variant"]:checked');
        let variantId = null;
        let variantName = '';
        let variantCode = '';
        let variantPrice = 0;

        if (selectedVariant && selectedVariant.value !== 'none') {
            variantId = selectedVariant.value;
            const variantItem = document.querySelector(`[data-variant-id="${variantId}"]`);
            if (variantItem) {
                variantName = variantItem.dataset.variantName || '';
                variantCode = variantItem.dataset.variantCode || '';
                variantPrice = parseInt(variantItem.dataset.variantPrice) || 0;
            }
        }

        // Debug: Log thông tin
        console.log('Buy Now Debug:', {
            productId: productId,
            targetProductId: targetProductId,
            quantity: quantity,
            variantId: variantId,
            variantName: variantName,
            variantCode: variantCode,
            variantPrice: variantPrice,
            productIdFromBlade: '{{ $product->id ?? "" }}'
        });

        // Kiểm tra nếu có product ID
        if (!targetProductId || targetProductId === '') {
            showNotification('Không tìm thấy thông tin sản phẩm!', 'error');
            return;
        }

        // Get product data from DOM
        const productElement = document.querySelector(`[data-product-id="${targetProductId}"]`);
        const currentProductTitle = document.querySelector('.product-title');
        const currentProductName = currentProductTitle ? currentProductTitle.textContent.trim() : `Sản phẩm ${targetProductId}`;

        // Lưu thông tin chi tiết vào sessionStorage để trang checkout có thể đọc
        const buyNowInfo = {
            productId: parseInt(targetProductId),
            productName: variantName || currentProductName,
            productModel: productElement ? productElement.dataset.productModel || `SW-${targetProductId}` : `SW-${targetProductId}`,
            productImage: productElement ? productElement.dataset.productImage || '/image/sp1.png' : '/image/sp1.png',
            quantity: quantity,
            variant_id: variantId,
            variant_name: variantName,
            variant_code: variantCode,
            variant_price: variantPrice,
            timestamp: Date.now()
        };

        sessionStorage.setItem('buyNowData', JSON.stringify(buyNowInfo));
        console.log('Buy now info saved to sessionStorage:', buyNowInfo);

        // Chuyển đến trang checkout
        const checkoutUrl = `/checkout?buy_now=1&product_id=${targetProductId}&quantity=${quantity}${variantId ? `&variant_id=${variantId}` : ''}`;
        console.log('Redirecting to:', checkoutUrl);
        window.location.href = checkoutUrl;
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
        // Remove existing notifications first
        document.querySelectorAll('.custom-notification').forEach(notif => notif.remove());

        // Create notification element
        const notification = document.createElement('div');
        notification.className = `custom-notification alert alert-${type} alert-dismissible fade show`;

        // Enhanced styling for better visibility
        const bgColors = {
            'success': 'linear-gradient(135deg, #28a745, #20c997)',
            'error': 'linear-gradient(135deg, #dc3545, #fd7e14)',
            'info': 'linear-gradient(135deg, #17a2b8, #6f42c1)',
            'warning': 'linear-gradient(135deg, #ffc107, #fd7e14)'
        };

        notification.style.cssText = `
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 99999;
            min-width: 350px;
            max-width: 500px;
            background: ${bgColors[type] || bgColors['info']};
            border: none;
            border-radius: 12px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3);
            color: white;
            font-weight: 600;
            padding: 16px 20px;
            backdrop-filter: blur(10px);
            animation: slideInRight 0.3s ease-out;
        `;

        const icons = {
            'success': 'check-circle',
            'error': 'exclamation-triangle',
            'info': 'info-circle',
            'warning': 'exclamation-circle'
        };

        notification.innerHTML = `
            <div style="display: flex; align-items: center; gap: 12px;">
                <i class="fas fa-${icons[type] || icons['info']}" style="font-size: 20px; flex-shrink: 0;"></i>
                <div style="flex: 1; line-height: 1.4;">${message}</div>
                <button type="button" class="btn-close btn-close-white" onclick="this.parentElement.parentElement.remove()"
                        style="margin: 0; padding: 8px; opacity: 0.8;" aria-label="Close">
                </button>
            </div>
        `;

        document.body.appendChild(notification);

        // Auto remove after 5 seconds for error, 3 for others
        const timeout = type === 'error' ? 5000 : 3000;
        setTimeout(() => {
            if (notification.parentNode) {
                notification.style.animation = 'slideOutRight 0.3s ease-in forwards';
                setTimeout(() => notification.remove(), 300);
            }
        }, timeout);
    }

    // ===== TAB EVENT HANDLERS =====

    // Handle reviews tab click to show content
    document.addEventListener('DOMContentLoaded', function() {
        const reviewsTab = document.getElementById('reviews-tab');
        const reviewsTabContent = document.querySelector('#reviews .tab-content-wrapper');
        const allTabs = document.querySelectorAll('#productTabs .nav-link');

        if (reviewsTab && reviewsTabContent && allTabs.length > 0) {
            // Function to hide reviews content
            function hideReviewsContent() {
                reviewsTabContent.style.opacity = '0';
                setTimeout(() => {
                    reviewsTabContent.style.display = 'none';
                }, 300); // Wait for opacity transition to complete
            }

            // Function to show reviews content
            function showReviewsContent() {
                reviewsTabContent.style.display = '';
                setTimeout(() => {
                    reviewsTabContent.style.opacity = '1';
                }, 50);
            }

            // Handle reviews tab click
            reviewsTab.addEventListener('click', function() {
                showReviewsContent();
            });

            // Handle other tabs click to hide reviews content
            allTabs.forEach(tab => {
                if (tab.id !== 'reviews-tab') {
                    tab.addEventListener('click', function() {
                        hideReviewsContent();
                    });
                }
            });

            // Set initial styles for smooth transition
            reviewsTabContent.style.opacity = '0';
            reviewsTabContent.style.transition = 'opacity 0.3s ease';
        }
    });

    // ===== REVIEW FUNCTIONS =====

    function redirectToLogin() {
        showNotification('Đang chuyển đến trang đăng nhập...', 'info');
        setTimeout(() => {
            window.location.href = '/login';
        }, 1000);
    }

    function openReviewForm() {
        const reviewModalElement = document.getElementById('reviewModal');
        if (!reviewModalElement) {
            console.warn('Review modal not found - user may not be logged in');
            return;
        }

        // Reset form
        resetReviewForm();

        // Show modal
        const reviewModal = new bootstrap.Modal(reviewModalElement);
        reviewModal.show();
    }

    function resetReviewForm() {
        const form = document.getElementById('reviewForm');
        if (!form) return;

        form.reset();

        // Reset rating
        const stars = document.querySelectorAll('.star-item');
        const ratingInput = document.getElementById('ratingInput');
        const ratingText = document.querySelector('.rating-text');

        if (stars.length) {
            stars.forEach(star => {
                star.classList.remove('active');
            });
        }

        if (ratingInput) {
            ratingInput.value = '';
        }

        if (ratingText) {
            ratingText.textContent = 'Chọn số sao';
        }

        // Reset comment count
        const commentCount = document.getElementById('commentCount');
        if (commentCount) {
            commentCount.textContent = '0';
        }

        // Clear validation errors
        clearValidationErrors();
    }

    function clearValidationErrors() {
        document.querySelectorAll('.is-invalid').forEach(element => {
            element.classList.remove('is-invalid');
        });
        document.querySelectorAll('.invalid-feedback').forEach(element => {
            element.textContent = '';
        });
    }

    // Initialize review functionality
    document.addEventListener('DOMContentLoaded', function() {
        // Only initialize if review modal exists (user is logged in)
        if (document.getElementById('reviewModal')) {
            initializeReviewForm();
        }
    });

    function initializeReviewForm() {
        // Star rating functionality
        const stars = document.querySelectorAll('.star-item');
        const ratingInput = document.getElementById('ratingInput');
        const ratingText = document.querySelector('.rating-text');

        // Check if elements exist before adding event listeners
        if (!stars.length || !ratingInput || !ratingText) {
            console.warn('Review form elements not found, skipping initialization');
            return;
        }

        stars.forEach((star, index) => {
            star.addEventListener('click', function() {
                const rating = parseInt(this.dataset.rating);

                // Update hidden input
                ratingInput.value = rating;

                // Update visual stars
                stars.forEach((s, i) => {
                    if (i < rating) {
                        s.classList.add('active');
                    } else {
                        s.classList.remove('active');
                    }
                });

                // Update rating text
                const ratingTexts = ['', 'Rất tệ', 'Tệ', 'Bình thường', 'Tốt', 'Rất tốt'];
                ratingText.textContent = ratingTexts[rating];

                // Clear rating error
                document.getElementById('ratingError').textContent = '';
                document.querySelector('.rating-input').classList.remove('is-invalid');
            });

            // Hover effect
            star.addEventListener('mouseenter', function() {
                const rating = parseInt(this.dataset.rating);
                stars.forEach((s, i) => {
                    if (i < rating) {
                        s.style.color = '#ffc107';
                    } else {
                        s.style.color = '#e9ecef';
                    }
                });
            });
        });

        // Reset hover effect when mouse leaves star container
        const starRatingContainer = document.querySelector('.star-rating');
        if (starRatingContainer) {
            starRatingContainer.addEventListener('mouseleave', function() {
                const currentRating = parseInt(ratingInput.value) || 0;
                stars.forEach((s, i) => {
                    if (i < currentRating) {
                        s.style.color = '#ffc107';
                    } else {
                        s.style.color = '#e9ecef';
                    }
                });
            });
        }

        // Comment character count
        const commentTextarea = document.getElementById('reviewComment');
        const commentCount = document.getElementById('commentCount');

        if (commentTextarea && commentCount) {
            commentTextarea.addEventListener('input', function() {
                const length = this.value.length;
                commentCount.textContent = length;

                // Color coding
                if (length < 10) {
                    commentCount.style.color = '#dc3545';
                } else if (length > 900) {
                    commentCount.style.color = '#ffc107';
                } else {
                    commentCount.style.color = '#007bff';
                }
            });
        }

        // Form submission
        const reviewForm = document.getElementById('reviewForm');
        if (reviewForm) {
            reviewForm.addEventListener('submit', function(e) {
                e.preventDefault();
                submitReview();
            });
        }
    }

    function submitReview() {
        const form = document.getElementById('reviewForm');
        const submitBtn = document.getElementById('submitReviewBtn');

        // Clear previous errors
        clearValidationErrors();

        // Validate form
        if (!validateReviewForm()) {
            return;
        }

        // Show loading state
        submitBtn.classList.add('btn-loading');
        submitBtn.innerHTML = '<span style="opacity: 0;">Đang gửi...</span>';

        // Get CSRF token
        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
        console.log('CSRF Token found:', csrfToken ? 'Yes' : 'No');
        console.log('CSRF Token value:', csrfToken);

        if (!csrfToken) {
            console.error('CSRF token not found in meta tag');
            showNotification('Lỗi bảo mật. Vui lòng tải lại trang và thử lại.', 'error');
            return;
        }

        // Prepare form data
        const formData = new FormData(form);
        formData.append('_token', csrfToken);

        // Debug: Log form data
        console.log('Form data being sent:');
        for (let pair of formData.entries()) {
            console.log(pair[0] + ': ' + pair[1]);
        }

        // Submit via AJAX
        fetch(form.action, {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json'
            }
        })
        .then(response => {
            console.log('Response status:', response.status);
            console.log('Response headers:', response.headers);

            if (!response.ok) {
                // Try to get error message from response
                return response.text().then(text => {
                    let errorMessage = `HTTP error! status: ${response.status}`;

                    // Try to parse JSON error message
                    try {
                        const errorData = JSON.parse(text);
                        console.log('Error response data:', errorData);

                        if (errorData.message) {
                            errorMessage = errorData.message;
                        }

                        // Handle validation errors specifically
                        if (errorData.errors && response.status === 422) {
                            const firstError = Object.values(errorData.errors)[0];
                            if (firstError && firstError[0]) {
                                errorMessage = firstError[0];
                            }
                        }
                    } catch (e) {
                        // If not JSON, use status-based message
                        if (response.status === 419) {
                            errorMessage = 'Phiên làm việc đã hết hạn. Vui lòng tải lại trang.';
                        } else if (response.status === 422) {
                            errorMessage = 'Dữ liệu không hợp lệ.';
                        } else if (response.status === 401) {
                            errorMessage = 'Bạn cần đăng nhập để thực hiện thao tác này.';
                        } else if (response.status === 500) {
                            errorMessage = 'Lỗi server. Vui lòng thử lại sau.';
                        }
                    }

                    throw new Error(errorMessage);
                });
            }

            return response.json();
        })
        .then(data => {
            console.log('Response data:', data);
            if (data.success) {
                // Close modal
                const reviewModal = bootstrap.Modal.getInstance(document.getElementById('reviewModal'));
                reviewModal.hide();

                // Show success message
                showNotification(data.message, 'success');

                // Add new review to the list
                if (data.review) {
                    addNewReviewToList(data.review);
                    // Update rating display if provided
                    if (data.updated_rating) {
                        updateRatingDisplay(data.updated_rating);
                    }
                }

                // Reset form
                resetReviewForm();

            } else {
                console.log('Review submission failed:', data);

                // Show error message
                let errorMessage = data.message || 'Có lỗi xảy ra khi gửi đánh giá';

                // If there are specific validation errors, show the first one
                if (data.errors && Object.keys(data.errors).length > 0) {
                    const firstErrorField = Object.keys(data.errors)[0];
                    const firstErrorMessage = data.errors[firstErrorField][0];
                    errorMessage = firstErrorMessage;

                    // Also show field-specific errors
                    showValidationErrors(data.errors);
                }

                showNotification(errorMessage, 'error');
            }
        })
        .catch(error => {
            console.error('Error submitting review:', error);

            // Use error message if available, otherwise default
            const errorMessage = error.message || 'Có lỗi xảy ra khi gửi đánh giá. Vui lòng thử lại.';
            showNotification(errorMessage, 'error');
        })
        .finally(() => {
            // Reset button state
            submitBtn.classList.remove('btn-loading');
            submitBtn.innerHTML = '<i class="fas fa-paper-plane me-1"></i>Gửi đánh giá';
        });
    }

    function validateReviewForm() {
        let isValid = true;

        // Validate rating
        const ratingInput = document.getElementById('ratingInput');
        const ratingContainer = document.querySelector('.rating-input');
        const ratingError = document.getElementById('ratingError');

        if (ratingInput) {
            const rating = ratingInput.value;
            if (!rating || rating < 1 || rating > 5) {
                if (ratingContainer) ratingContainer.classList.add('is-invalid');
                if (ratingError) ratingError.textContent = 'Vui lòng chọn số sao đánh giá.';
                isValid = false;
            }
        }

        // Validate comment
        const commentInput = document.getElementById('reviewComment');
        const commentError = document.getElementById('commentError');

        if (commentInput) {
            const comment = commentInput.value.trim();
            if (!comment) {
                commentInput.classList.add('is-invalid');
                if (commentError) commentError.textContent = 'Vui lòng nhập nội dung bình luận.';
                isValid = false;
            } else if (comment.length < 10) {
                commentInput.classList.add('is-invalid');
                if (commentError) commentError.textContent = 'Bình luận phải có ít nhất 10 ký tự.';
                isValid = false;
            } else if (comment.length > 1000) {
                commentInput.classList.add('is-invalid');
                if (commentError) commentError.textContent = 'Bình luận không được vượt quá 1000 ký tự.';
                isValid = false;
            }
        }

        return isValid;
    }

    function showValidationErrors(errors) {
        Object.keys(errors).forEach(field => {
            const errorElement = document.getElementById(field + 'Error');
            const inputElement = document.getElementById('review' + field.charAt(0).toUpperCase() + field.slice(1));

            if (errorElement && errors[field][0]) {
                errorElement.textContent = errors[field][0];
            }

            if (inputElement) {
                inputElement.classList.add('is-invalid');
            }

            // Special handling for rating
            if (field === 'rating') {
                document.querySelector('.rating-input').classList.add('is-invalid');
            }
        });
    }

    function addNewReviewToList(review) {
        const reviewsList = document.getElementById('reviewsList');
        const noReviews = document.querySelector('.no-reviews');

        // Hide no reviews message if exists
        if (noReviews) {
            noReviews.style.display = 'none';
        }

        // Create new review element
        const reviewElement = document.createElement('div');
        reviewElement.className = 'review-item';
        reviewElement.innerHTML = `
            <div class="review-header">
                <div class="reviewer-info">
                    <div class="reviewer-name">${review.customer_name}</div>
                    <div class="review-date">${review.created_at}</div>
                </div>
                <div class="review-rating">
                    ${generateStarRating(review.rating)}
                </div>
            </div>
            ${review.title ? `<div class="review-title"><strong>${review.title}</strong></div>` : ''}
            <div class="review-content">${review.comment}</div>
        `;

        // Add to top of reviews list
        if (reviewsList) {
            const firstReview = reviewsList.querySelector('.review-item');
            if (firstReview) {
                reviewsList.insertBefore(reviewElement, firstReview);
            } else {
                reviewsList.appendChild(reviewElement);
            }
        } else {
            // Create reviews section if it doesn't exist
            const reviewsTab = document.getElementById('reviews');
            const newReviewsSection = document.createElement('div');
            newReviewsSection.className = 'reviews-section mt-4';
            newReviewsSection.id = 'reviewsList';
            newReviewsSection.innerHTML = `
                <h4 class="mb-3">1 bình luận cho sản phẩm này</h4>
            `;
            newReviewsSection.appendChild(reviewElement);
            reviewsTab.querySelector('.tab-content-wrapper').appendChild(newReviewsSection);
        }

        // Update review count
        updateReviewCount();
    }

    function generateStarRating(rating) {
        let stars = '';
        for (let i = 1; i <= 5; i++) {
            if (i <= rating) {
                stars += '<i class="fas fa-star text-warning"></i>';
            } else {
                stars += '<i class="fas fa-star text-muted"></i>';
            }
        }
        return stars;
    }

    function updateReviewCount() {
        const reviewItems = document.querySelectorAll('.review-item').length;
        const reviewCountElement = document.querySelector('#reviewsList h4');
        if (reviewCountElement) {
            reviewCountElement.textContent = `${reviewItems} bình luận cho sản phẩm này`;
        }

        // Update tab title
        const reviewTab = document.querySelector('#reviews-tab');
        if (reviewTab) {
            reviewTab.textContent = `Đánh giá (${reviewItems})`;
        }
    }

    function updateRatingDisplay(ratingData) {
        // Update main product rating
        const mainRatingText = document.querySelector('.product-rating .rating-text');
        if (mainRatingText && ratingData.average && ratingData.count !== undefined) {
            mainRatingText.innerHTML = `
                ${parseFloat(ratingData.average).toFixed(1)}
                (${ratingData.count} đánh giá)
            `;
        }

        // Update main rating stars
        const mainStars = document.querySelectorAll('.product-rating .stars i');
        if (mainStars.length && ratingData.average) {
            const avgRating = parseFloat(ratingData.average);
            mainStars.forEach((star, index) => {
                if (index + 1 <= avgRating) {
                    star.classList.remove('text-muted');
                    star.classList.add('text-warning');
                } else {
                    star.classList.remove('text-warning');
                    star.classList.add('text-muted');
                }
            });
        }

        // Update reviews tab rating display
        const ratingNumber = document.querySelector('.rating-number');
        if (ratingNumber && ratingData.average) {
            ratingNumber.textContent = parseFloat(ratingData.average).toFixed(1);
        }

        const totalReviews = document.querySelector('.total-reviews');
        if (totalReviews && ratingData.count !== undefined) {
            totalReviews.textContent = `${ratingData.count} nhận xét`;
        }

        // Update reviews tab stars
        const tabStars = document.querySelectorAll('.rating-stars i');
        if (tabStars.length && ratingData.average) {
            const avgRating = parseFloat(ratingData.average);
            tabStars.forEach((star, index) => {
                if (index + 1 <= avgRating) {
                    star.classList.remove('text-muted');
                    star.classList.add('text-warning');
                } else {
                    star.classList.remove('text-warning');
                    star.classList.add('text-muted');
                }
            });
        }
    }

    // ===== IMAGE UPLOAD FUNCTIONS =====

    let selectedImages = [];
    const maxImages = 5;

    // Initialize image upload functionality
    document.addEventListener('DOMContentLoaded', function() {
        initializeImageUpload();
        loadCustomerPhotos();
    });

    function initializeImageUpload() {
        const dropzone = document.getElementById('imageDropzone');
        const fileInput = document.getElementById('reviewImages');

        if (!dropzone || !fileInput) return;

        // File input change event
        fileInput.addEventListener('change', function(e) {
            handleFileSelect(e.target.files);
        });

        // Drag and drop events
        dropzone.addEventListener('dragover', function(e) {
            e.preventDefault();
            dropzone.classList.add('dragover');
        });

        dropzone.addEventListener('dragleave', function(e) {
            e.preventDefault();
            dropzone.classList.remove('dragover');
        });

        dropzone.addEventListener('drop', function(e) {
            e.preventDefault();
            dropzone.classList.remove('dragover');
            handleFileSelect(e.dataTransfer.files);
        });

        // Click to select files
        dropzone.addEventListener('click', function() {
            fileInput.click();
        });
    }

    function handleFileSelect(files) {
        const fileArray = Array.from(files);

        // Check total count
        if (selectedImages.length + fileArray.length > maxImages) {
            showNotification(`Tối đa ${maxImages} ảnh được phép tải lên`, 'warning');
            return;
        }

        fileArray.forEach(file => {
            // Validate file type
            if (!file.type.startsWith('image/')) {
                showNotification(`File "${file.name}" không phải là ảnh`, 'error');
                return;
            }

            // Validate file size (5MB)
            if (file.size > 5 * 1024 * 1024) {
                showNotification(`Ảnh "${file.name}" vượt quá 5MB`, 'error');
                return;
            }

            // Create preview
            const reader = new FileReader();
            reader.onload = function(e) {
                selectedImages.push({
                    file: file,
                    preview: e.target.result
                });
                updateImagePreview();
            };
            reader.readAsDataURL(file);
        });
    }

    function updateImagePreview() {
        const previewContainer = document.getElementById('previewImages');
        const previewGrid = previewContainer.querySelector('.preview-images-grid');

        if (selectedImages.length === 0) {
            previewContainer.style.display = 'none';
            return;
        }

        previewContainer.style.display = 'block';
        previewGrid.innerHTML = '';

        selectedImages.forEach((imageData, index) => {
            const previewItem = document.createElement('div');
            previewItem.className = 'preview-image-item';
            previewItem.innerHTML = `
                <img src="${imageData.preview}" alt="Preview">
                <button type="button" class="preview-image-remove" onclick="removePreviewImage(${index})">
                    <i class="fas fa-times"></i>
                </button>
            `;
            previewGrid.appendChild(previewItem);
        });

        // Update file input
        updateFileInput();
    }

    function removePreviewImage(index) {
        selectedImages.splice(index, 1);
        updateImagePreview();
    }

    function updateFileInput() {
        const fileInput = document.getElementById('reviewImages');
        const dt = new DataTransfer();

        selectedImages.forEach(imageData => {
            dt.items.add(imageData.file);
        });

        fileInput.files = dt.files;
    }

    // Reset image upload when form is reset
    function resetImageUpload() {
        selectedImages = [];
        updateImagePreview();
        document.getElementById('reviewImages').value = '';
    }

    // ===== CUSTOMER PHOTOS GALLERY =====

    function loadCustomerPhotos() {
        const productId = document.querySelector('[data-product-id]')?.dataset.productId;
        if (!productId) return;

        fetch(`/products/${productId}/review-images`)
            .then(response => response.json())
            .then(data => {
                if (data.success && data.images.length > 0) {
                    displayCustomerPhotos(data.images);
                }
            })
            .catch(error => {
                console.error('Error loading customer photos:', error);
            });
    }

    function displayCustomerPhotos(images) {
        const section = document.getElementById('customerPhotosSection');
        const grid = document.getElementById('customerPhotosGrid');
        const count = document.getElementById('customerPhotosCount');

        if (!section || !grid || !count) return;

        count.textContent = images.length;
        section.style.display = 'block';

        grid.innerHTML = '';
        images.forEach(image => {
            const photoItem = document.createElement('div');
            photoItem.className = 'customer-photo-item';
            photoItem.innerHTML = `
                <img src="${image.thumbnail}" alt="Ảnh từ khách hàng" class="customer-photo-thumb"
                     onclick="openImageModal('${image.original}', '${image.customer_name}', '${image.created_at}')">
                <div class="customer-photo-overlay">
                    <div>${image.customer_name}</div>
                    <div>${image.created_at}</div>
                </div>
            `;
            grid.appendChild(photoItem);
        });
    }

    function toggleCustomerPhotos() {
        const grid = document.getElementById('customerPhotosGrid');
        const toggleText = document.getElementById('togglePhotosText');
        const toggleIcon = document.getElementById('togglePhotosIcon');

        if (!grid || !toggleText || !toggleIcon) return;

        const isExpanded = grid.classList.contains('expanded');

        if (isExpanded) {
            grid.classList.remove('expanded');
            toggleText.textContent = 'Xem tất cả';
            toggleIcon.classList.remove('fa-chevron-up');
            toggleIcon.classList.add('fa-chevron-down');
        } else {
            grid.classList.add('expanded');
            toggleText.textContent = 'Thu gọn';
            toggleIcon.classList.remove('fa-chevron-down');
            toggleIcon.classList.add('fa-chevron-up');
        }
    }

    // ===== IMAGE MODAL FUNCTIONS =====

    function openImageModal(imageSrc, customerName, reviewDate) {
        const modal = new bootstrap.Modal(document.getElementById('imageModal'));
        const modalImage = document.getElementById('modalImage');
        const modalReviewerName = document.getElementById('modalReviewerName');
        const modalReviewDate = document.getElementById('modalReviewDate');

        modalImage.src = imageSrc;
        modalReviewerName.textContent = customerName || 'Khách hàng';
        modalReviewDate.textContent = reviewDate || '';

        modal.show();
    }

    // ===== ENHANCED REVIEW FORM FUNCTIONS =====

    // Override existing resetReviewForm function
    function resetReviewForm() {
        const form = document.getElementById('reviewForm');
        if (!form) return;

        form.reset();

        // Reset rating
        const stars = document.querySelectorAll('.star-item');
        const ratingInput = document.getElementById('ratingInput');
        const ratingText = document.querySelector('.rating-text');

        if (stars.length) {
            stars.forEach(star => {
                star.classList.remove('active');
            });
        }

        if (ratingInput) {
            ratingInput.value = '';
        }

        if (ratingText) {
            ratingText.textContent = 'Chọn số sao';
        }

        // Reset comment count
        const commentCount = document.getElementById('commentCount');
        if (commentCount) {
            commentCount.textContent = '0';
        }

        // Reset image upload
        resetImageUpload();

        // Clear validation errors
        clearValidationErrors();
    }

    // Enhanced addNewReviewToList function to handle images
    function addNewReviewToList(review) {
        const reviewsList = document.getElementById('reviewsList');
        const noReviews = document.querySelector('.no-reviews');

        // Hide no reviews message if exists
        if (noReviews) {
            noReviews.style.display = 'none';
        }

        // Create new review element
        const reviewElement = document.createElement('div');
        reviewElement.className = 'review-item';

        let imagesHtml = '';
        if (review.images && review.images.length > 0) {
            imagesHtml = `
                <div class="review-images mt-3">
                    <div class="review-images-grid">
                        ${review.images.map(image => `
                            <div class="review-image-item">
                                <img src="${image.thumbnail || image.original || image}"
                                     alt="Ảnh đánh giá"
                                     class="review-image-thumb"
                                     onclick="openImageModal('${image.original || image}', '${review.customer_name}', '${review.created_at}')">
                            </div>
                        `).join('')}
                    </div>
                </div>
            `;
        }

        reviewElement.innerHTML = `
            <div class="review-header">
                <div class="reviewer-info">
                    <div class="reviewer-name">${review.customer_name}</div>
                    <div class="review-date">${review.created_at}</div>
                </div>
                <div class="review-rating">
                    ${generateStarRating(review.rating)}
                </div>
            </div>
            ${review.title ? `<div class="review-title"><strong>${review.title}</strong></div>` : ''}
            <div class="review-content">${review.comment}</div>
            ${imagesHtml}
        `;

        // Add to top of reviews list
        if (reviewsList) {
            const firstReview = reviewsList.querySelector('.review-item');
            if (firstReview) {
                reviewsList.insertBefore(reviewElement, firstReview);
            } else {
                reviewsList.appendChild(reviewElement);
            }
        } else {
            // Create reviews section if it doesn't exist
            const reviewsTab = document.getElementById('reviews');
            const newReviewsSection = document.createElement('div');
            newReviewsSection.className = 'reviews-section mt-4';
            newReviewsSection.id = 'reviewsList';
            newReviewsSection.innerHTML = `
                <h4 class="mb-3">1 bình luận cho sản phẩm này</h4>
            `;
            newReviewsSection.appendChild(reviewElement);
            reviewsTab.querySelector('.tab-content-wrapper').appendChild(newReviewsSection);
        }

        // Update review count
        updateReviewCount();

        // Reload customer photos if images were added
        if (review.images && review.images.length > 0) {
            setTimeout(() => {
                loadCustomerPhotos();
            }, 1000);
        }
    }
</script>
@endpush
