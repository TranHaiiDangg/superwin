@extends('layouts.app')

@section('title', $category->name . ' - SuperWin')

@section('content')
<div class="container py-5">
    <div class="row">
        <!-- Sidebar -->
        <div class="col-lg-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <h5 class="card-title mb-3">Danh mục</h5>
                    
                    @if($category->children->count() > 0)
                    <div class="list-group list-group-flush">
                        @foreach($category->children as $child)
                        <a href="{{ route('categories.show', $child->slug) }}" 
                           class="list-group-item list-group-item-action">
                            {{ $child->name }}
                        </a>
                        @endforeach
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Products -->
        <div class="col-lg-9">
            <!-- Header -->
            <div class="mb-4">
                <h2 class="fw-bold">{{ $category->name }}</h2>
                <p class="text-muted">{{ $category->description }}</p>
                <p class="text-muted">{{ $products->total() }} sản phẩm</p>
            </div>

            <!-- Products Grid -->
            @if($products->count() > 0)
            <div class="row g-4">
                @foreach($products as $product)
                <div class="col-md-6 col-lg-4">
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

            <!-- Pagination -->
            <div class="d-flex justify-content-center mt-5">
                {{ $products->links() }}
            </div>
            @else
            <div class="text-center py-5">
                <i class="fas fa-box-open fa-3x text-muted mb-3"></i>
                <h5>Không có sản phẩm nào</h5>
                <p class="text-muted">Danh mục này chưa có sản phẩm</p>
                <a href="{{ route('products.index') }}" class="btn btn-primary">Xem tất cả sản phẩm</a>
            </div>
            @endif
        </div>
    </div>
</div>

@push('styles')
<style>
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
@endsection 