@extends('layouts.app')

@section('title', 'SuperWin - Máy bơm nước & Quạt công nghiệp')

@section('content')
<!-- Hero Section -->
<section class="hero-section bg-gradient-primary text-white py-5">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <h1 class="display-4 fw-bold mb-3">Máy bơm nước & Quạt công nghiệp</h1>
                <p class="lead mb-4">Chuyên cung cấp thiết bị chất lượng cao, giao hàng toàn quốc, bảo hành chính hãng</p>
                <div class="d-flex gap-3">
                    <a href="{{ route('products.index') }}" class="btn btn-light btn-lg">
                        <i class="fas fa-shopping-cart me-2"></i>Mua ngay
                    </a>
                    <a href="{{ route('contact') }}" class="btn btn-outline-light btn-lg">
                        <i class="fas fa-phone me-2"></i>Tư vấn
                    </a>
                </div>
            </div>
            <div class="col-lg-6">
                <img src="/image/banner1.png" alt="SuperWin Products" class="img-fluid rounded">
            </div>
        </div>
    </div>
</section>

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

@push('styles')
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
</style>
@endpush