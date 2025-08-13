@extends('layouts.app')

@section('title', 'Thương Hiệu - SuperWin')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <!-- Header -->
        <div class="col-12">
            <div class="brands-header">
                <div class="text-center mb-5">
                    <h2 class="brands-main-title">Thương Hiệu Nổi Bật</h2>
                    <p class="brands-subtitle">Khám phá các thương hiệu uy tín hàng đầu về máy bơm nước và quạt thông gió</p>
                </div>
            </div>
        </div>

        <!-- Brands Grid -->
        <div class="col-12">
            @if($brands->count() > 0)
            <div class="brands-grid">
                @foreach($brands as $brand)
                <div class="brand-item">
                    <div class="brand-card">
                        <a href="{{ route('brands.show', $brand->id) }}" class="brand-link">
                            <div class="brand-image">
                                @if($brand->image)
                                <img src="{{ asset($brand->image) }}" alt="{{ $brand->name }}" class="img-fluid">
                                @else
                                <div class="brand-placeholder">
                                    <i class="fas fa-building"></i>
                                </div>
                                @endif
                            </div>
                            
                            <div class="brand-content">
                                <h4 class="brand-name">{{ $brand->name }}</h4>
                                
                                @if($brand->description)
                                <p class="brand-description">{{ Str::limit($brand->description, 100) }}</p>
                                @endif
                                
                                <div class="brand-stats">
                                    <div class="stat-item">
                                        <strong>{{ $brand->products_count }}</strong>
                                        <span>sản phẩm</span>
                                    </div>
                                </div>
                                
                                <div class="brand-action">
                                    <span class="view-products-btn">
                                        Xem sản phẩm
                                        <i class="fas fa-arrow-right ms-2"></i>
                                    </span>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Pagination -->
            @if($brands->hasPages())
            <div class="pagination-wrapper">
                <nav class="custom-pagination">
                    <ul class="pagination">
                        {{-- Previous Page Link --}}
                        @if ($brands->onFirstPage())
                            <li class="page-item disabled">
                                <span class="page-link">‹</span>
                            </li>
                        @else
                            <li class="page-item">
                                <a class="page-link" href="{{ $brands->previousPageUrl() }}" rel="prev">‹</a>
                            </li>
                        @endif

                        {{-- Pagination Elements --}}
                        @php
                            $start = max(1, $brands->currentPage() - 2);
                            $end = min($brands->lastPage(), $brands->currentPage() + 2);
                        @endphp

                        @if($start > 1)
                            <li class="page-item">
                                <a class="page-link" href="{{ $brands->url(1) }}">1</a>
                            </li>
                            @if($start > 2)
                                <li class="page-item disabled">
                                    <span class="page-link">...</span>
                                </li>
                            @endif
                        @endif

                        @for($page = $start; $page <= $end; $page++)
                            @if ($page == $brands->currentPage())
                                <li class="page-item active">
                                    <span class="page-link">{{ $page }}</span>
                                </li>
                            @else
                                <li class="page-item">
                                    <a class="page-link" href="{{ $brands->url($page) }}">{{ $page }}</a>
                                </li>
                            @endif
                        @endfor

                        @if($end < $brands->lastPage())
                            @if($end < $brands->lastPage() - 1)
                                <li class="page-item disabled">
                                    <span class="page-link">...</span>
                                </li>
                            @endif
                            <li class="page-item">
                                <a class="page-link" href="{{ $brands->url($brands->lastPage()) }}">{{ $brands->lastPage() }}</a>
                            </li>
                        @endif

                        {{-- Next Page Link --}}
                        @if ($brands->hasMorePages())
                            <li class="page-item">
                                <a class="page-link" href="{{ $brands->nextPageUrl() }}" rel="next">›</a>
                            </li>
                        @else
                            <li class="page-item disabled">
                                <span class="page-link">›</span>
                            </li>
                        @endif
                    </ul>
                </nav>
            </div>
            @endif
            @else
            <div class="empty-state">
                <i class="fas fa-building"></i>
                <h5>Chưa có thương hiệu nào</h5>
                <p>Hiện tại chưa có thương hiệu nào được hiển thị</p>
                <a href="{{ route('home') }}" class="btn btn-primary">Về trang chủ</a>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
/* Brands Index Page Styles */
.brands-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-radius: 16px;
    padding: 60px 30px;
    color: white;
    margin-bottom: 40px;
    text-align: center;
    box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
}

.brands-main-title {
    font-size: 2.5rem;
    font-weight: 700;
    margin-bottom: 15px;
    text-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
}

.brands-subtitle {
    font-size: 1.1rem;
    opacity: 0.9;
    margin: 0;
    max-width: 600px;
    margin: 0 auto;
    line-height: 1.6;
}

.brands-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
    gap: 30px;
    margin-bottom: 40px;
}

.brand-item {
    position: relative;
}

.brand-card {
    background: white;
    border-radius: 16px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    overflow: hidden;
    transition: all 0.3s ease;
    height: 100%;
    border: 1px solid rgba(0, 0, 0, 0.05);
}

.brand-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 12px 40px rgba(0, 0, 0, 0.15);
}

.brand-link {
    text-decoration: none;
    color: inherit;
    display: block;
    height: 100%;
}

.brand-image {
    height: 180px;
    background: linear-gradient(135deg, #f8f9fa, #e9ecef);
    display: flex;
    align-items: center;
    justify-content: center;
    position: relative;
    overflow: hidden;
}

.brand-image img {
    max-width: 70%;
    max-height: 70%;
    object-fit: contain;
    transition: transform 0.3s ease;
}

.brand-card:hover .brand-image img {
    transform: scale(1.1);
}

.brand-placeholder {
    width: 80px;
    height: 80px;
    background: rgba(52, 152, 219, 0.1);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #3498db;
    font-size: 2rem;
}

.brand-content {
    padding: 25px;
    text-align: center;
}

.brand-name {
    color: #2c3e50;
    font-weight: 700;
    font-size: 1.4rem;
    margin-bottom: 15px;
    line-height: 1.3;
}

.brand-description {
    color: #7f8c8d;
    font-size: 0.95rem;
    line-height: 1.6;
    margin-bottom: 20px;
    min-height: 3em;
    display: -webkit-box;
    -webkit-line-clamp: 3;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.brand-stats {
    margin-bottom: 20px;
    padding: 15px;
    background: linear-gradient(135deg, #f8f9fa, #e9ecef);
    border-radius: 12px;
    border: 1px solid rgba(0, 0, 0, 0.05);
}

.stat-item {
    display: inline-block;
}

.stat-item strong {
    display: block;
    font-size: 1.5rem;
    font-weight: 700;
    color: #3498db;
    margin-bottom: 2px;
}

.stat-item span {
    font-size: 0.9rem;
    color: #7f8c8d;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    font-weight: 500;
}

.brand-action {
    margin-top: auto;
}

.view-products-btn {
    background: linear-gradient(135deg, #3498db, #2980b9);
    color: white;
    padding: 12px 24px;
    border-radius: 25px;
    font-size: 0.95rem;
    font-weight: 600;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    transition: all 0.3s ease;
    box-shadow: 0 4px 15px rgba(52, 152, 219, 0.3);
}

.brand-card:hover .view-products-btn {
    background: linear-gradient(135deg, #2980b9, #1f5f88);
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(52, 152, 219, 0.4);
}

.empty-state {
    text-align: center;
    padding: 80px 20px;
    color: #7f8c8d;
}

.empty-state i {
    font-size: 5rem;
    margin-bottom: 25px;
    color: #bdc3c7;
}

.empty-state h5 {
    font-size: 1.5rem;
    margin-bottom: 15px;
    color: #5a6c7d;
}

.empty-state p {
    font-size: 1.1rem;
    margin-bottom: 30px;
    max-width: 400px;
    margin-left: auto;
    margin-right: auto;
}

.pagination-wrapper {
    display: flex;
    justify-content: center;
    margin-top: 50px;
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
    border-radius: 8px;
    padding: 12px 16px;
    color: #666;
    text-decoration: none;
    margin: 0;
    transition: all 0.2s ease;
    font-weight: 500;
    background: white;
    min-width: 45px;
    text-align: center;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    font-size: 15px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
}

.custom-pagination .page-link:hover {
    background: linear-gradient(135deg, #f8f9fa, #e9ecef);
    color: #333;
    text-decoration: none;
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
}

.custom-pagination .page-item.active .page-link {
    background: linear-gradient(135deg, #3498db, #2980b9);
    color: white;
    font-weight: 600;
    box-shadow: 0 4px 15px rgba(52, 152, 219, 0.3);
}

.custom-pagination .page-item.disabled .page-link {
    background: #f8f9fa;
    color: #ccc;
    cursor: not-allowed;
    box-shadow: none;
}

.custom-pagination .page-item.disabled .page-link:hover {
    background: #f8f9fa;
    color: #ccc;
    transform: none;
    box-shadow: none;
}

/* Previous and Next buttons */
.custom-pagination .page-item:first-child .page-link,
.custom-pagination .page-item:last-child .page-link {
    font-size: 18px;
    padding: 12px 14px;
}

/* Responsive */
@media (max-width: 1200px) {
    .brands-grid {
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        gap: 25px;
    }
}

@media (max-width: 992px) {
    .brands-grid {
        grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
        gap: 20px;
    }
    
    .brands-header {
        padding: 40px 20px;
    }
    
    .brands-main-title {
        font-size: 2rem;
    }
    
    .brands-subtitle {
        font-size: 1rem;
    }
}

@media (max-width: 768px) {
    .brands-grid {
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        gap: 20px;
    }
    
    .brands-header {
        padding: 30px 15px;
        margin-bottom: 30px;
    }
    
    .brands-main-title {
        font-size: 1.8rem;
    }
    
    .brand-content {
        padding: 20px;
    }
    
    .custom-pagination .page-link {
        padding: 10px 12px;
        font-size: 14px;
        min-width: 40px;
    }
}

@media (max-width: 576px) {
    .brands-grid {
        grid-template-columns: 1fr;
        gap: 20px;
    }
    
    .brands-header {
        padding: 25px 15px;
        border-radius: 12px;
    }
    
    .brands-main-title {
        font-size: 1.6rem;
    }
    
    .brands-subtitle {
        font-size: 0.95rem;
    }
    
    .brand-image {
        height: 160px;
    }
    
    .brand-content {
        padding: 18px;
    }
    
    .brand-name {
        font-size: 1.2rem;
    }
    
    .custom-pagination .pagination {
        gap: 6px;
        flex-wrap: wrap;
        justify-content: center;
    }
    
    .custom-pagination .page-link {
        padding: 8px 10px;
        font-size: 13px;
        min-width: 35px;
    }
}
</style>
@endpush
