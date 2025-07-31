@extends('layouts.app')

@section('title', 'Sản phẩm - SuperWin')

@section('content')
<div class="container py-5">
    <div class="row">
        <!-- Sidebar Filters -->
        <div class="col-lg-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <h5 class="card-title mb-3">Bộ lọc</h5>
                    
                    <!-- Search -->
                    <div class="mb-4">
                        <label class="form-label">Tìm kiếm</label>
                        <form action="{{ route('products.index') }}" method="GET">
                            <div class="input-group">
                                <input type="text" class="form-control" name="search" value="{{ request('search') }}" placeholder="Tìm sản phẩm...">
                                <button class="btn btn-outline-primary" type="submit">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </form>
                    </div>

                    <!-- Categories -->
                    @if($categories->count() > 0)
                    <div class="mb-4">
                        <label class="form-label">Danh mục</label>
                        <div class="list-group list-group-flush">
                            @foreach($categories as $category)
                            <a href="{{ route('products.index', ['category' => $category->slug]) }}" 
                               class="list-group-item list-group-item-action {{ request('category') == $category->slug ? 'active' : '' }}">
                                {{ $category->name }}
                            </a>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    <!-- Brands -->
                    @if($brands->count() > 0)
                    <div class="mb-4">
                        <label class="form-label">Thương hiệu</label>
                        <div class="list-group list-group-flush">
                            @foreach($brands as $brand)
                            <a href="{{ route('products.index', ['brand' => $brand->slug]) }}" 
                               class="list-group-item list-group-item-action {{ request('brand') == $brand->slug ? 'active' : '' }}">
                                {{ $brand->name }}
                            </a>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    <!-- Price Range -->
                    <div class="mb-4">
                        <label class="form-label">Khoảng giá</label>
                        <form action="{{ route('products.index') }}" method="GET">
                            <div class="row g-2">
                                <div class="col-6">
                                    <input type="number" class="form-control" name="min_price" value="{{ request('min_price') }}" placeholder="Từ">
                                </div>
                                <div class="col-6">
                                    <input type="number" class="form-control" name="max_price" value="{{ request('max_price') }}" placeholder="Đến">
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary btn-sm w-100 mt-2">Lọc</button>
                        </form>
                    </div>

                    <!-- Sort -->
                    <div class="mb-4">
                        <label class="form-label">Sắp xếp</label>
                        <form action="{{ route('products.index') }}" method="GET" id="sortForm">
                            <select class="form-select" name="sort" onchange="this.form.submit()">
                                <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>Mới nhất</option>
                                <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Giá tăng dần</option>
                                <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Giá giảm dần</option>
                                <option value="name_asc" {{ request('sort') == 'name_asc' ? 'selected' : '' }}>Tên A-Z</option>
                                <option value="name_desc" {{ request('sort') == 'name_desc' ? 'selected' : '' }}>Tên Z-A</option>
                                <option value="popular" {{ request('sort') == 'popular' ? 'selected' : '' }}>Phổ biến</option>
                            </select>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Products Grid -->
        <div class="col-lg-9">
            <!-- Header -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h4 class="mb-0">Sản phẩm</h4>
                <span class="text-muted">{{ $products->total() }} sản phẩm</span>
            </div>

            <!-- Products -->
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
                <i class="fas fa-search fa-3x text-muted mb-3"></i>
                <h5>Không tìm thấy sản phẩm</h5>
                <p class="text-muted">Thử thay đổi bộ lọc hoặc từ khóa tìm kiếm</p>
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

.list-group-item.active {
    background-color: #4facfe;
    border-color: #4facfe;
}

.badge {
    font-size: 0.75rem;
}
</style>
@endpush
@endsection 