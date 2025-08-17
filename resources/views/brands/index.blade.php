@extends('layouts.app')

@section('title', 'Thương Hiệu - SuperWin')

@section('content')
<div class="container-fluid">
    <div class="row">
        <!-- Header -->
        <div class="col-12">
            <div class="brands-header">
                <div class="text-center">
                    <h2 class="brands-main-title">Thương Hiệu Nổi Bật</h2>
                    <!-- <p class="brands-subtitle">Khám phá các thương hiệu uy tín hàng đầu về máy bơm nước và quạt thông gió</p> -->
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

    .container-fluid{
        margin: 10px auto;
        width: 1320px;
    }
/* Brands Index Page Styles */
.brands-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-radius: 16px;
    padding: 15px 30px;
    color: white;
    margin-bottom: 40px;
    text-align: center;
    box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
}

.brands-main-title {
    font-size: 2.5rem;
    font-weight: 700;
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
    grid-template-columns: repeat(auto-fill, minmax(235px, 1fr));
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
/* Responsive styles for Mobile and Tablet */

/* Large Desktop (1200px and up) */
@media (min-width: 1200px) {
    .brands-grid {
        grid-template-columns: repeat(auto-fill, minmax(235px, 1fr));
        gap: 30px;
    }
}

/* Desktop (992px to 1199px) */
@media (max-width: 1199px) and (min-width: 992px) {
    .container-fluid {
        width: 100%;
        max-width: 1140px;
        padding: 0 15px;
    }
    
    .brands-grid {
        grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
        gap: 25px;
    }
    
    .brands-main-title {
        font-size: 2.2rem;
    }
}

/* Tablet Landscape (768px to 991px) */
@media (max-width: 991px) and (min-width: 768px) {
    .container-fluid {
        width: 100%;
        max-width: 960px;
        padding: 0 15px;
        margin: 10px auto;
    }
    
    .brands-grid {
        grid-template-columns: repeat(2, 1fr); /* 2 sản phẩm trên 1 hàng */
        gap: 20px;
        margin-bottom: 35px;
    }
    
    .brands-header {
        padding: 35px 20px;
        margin: 35px;
        border-radius: 14px;
    }
    
    .brands-main-title {
        font-size: 2rem;
    }
    
    .brands-subtitle {
        font-size: 1rem;
    }
    
    .brand-image {
        height: 160px;
    }
    
    .brand-content {
        padding: 20px;
    }
    
    .brand-name {
        font-size: 1.3rem;
        margin-bottom: 12px;
    }
    
    .brand-description {
        font-size: 0.9rem;
        margin-bottom: 18px;
        min-height: 2.7em;
    }
    
    .brand-stats {
        margin-bottom: 18px;
        padding: 12px;
    }
    
    .stat-item strong {
        font-size: 1.4rem;
    }
    
    .view-products-btn {
        padding: 10px 20px;
        font-size: 0.9rem;
    }
}

/* Tablet Portrait (576px to 767px) */
@media (max-width: 767px) and (min-width: 576px) {
    .container-fluid {
        width: 100%;
        max-width: 720px;
        padding: 0 15px;
        margin: 10px auto;
    }
    
    .brands-grid {
        grid-template-columns: repeat(2, 1fr); /* 2 sản phẩm trên 1 hàng */
        gap: 15px;
        margin-bottom: 30px;
    }
    
    .brands-header {
        padding: 30px 15px;
        margin: 30px;
        border-radius: 12px;
    }
    
    .brands-main-title {
        font-size: 1.8rem;
        line-height: 1.3;
    }
    
    .brands-subtitle {
        font-size: 0.95rem;
        line-height: 1.5;
    }
    
    .brand-image {
        height: 140px;
    }
    
    .brand-image img {
        max-width: 65%;
        max-height: 65%;
    }
    
    .brand-placeholder {
        width: 60px;
        height: 60px;
        font-size: 1.5rem;
    }
    
    .brand-content {
        padding: 18px 15px;
    }
    
    .brand-name {
        font-size: 1.2rem;
        margin-bottom: 10px;
    }
    
    .brand-description {
        font-size: 0.85rem;
        margin-bottom: 15px;
        min-height: 2.5em;
        -webkit-line-clamp: 2;
    }
    
    .brand-stats {
        margin-bottom: 15px;
        padding: 10px;
        border-radius: 10px;
    }
    
    .stat-item strong {
        font-size: 1.3rem;
    }
    
    .stat-item span {
        font-size: 0.85rem;
    }
    
    .view-products-btn {
        padding: 9px 18px;
        font-size: 0.85rem;
        border-radius: 20px;
    }
    
    .custom-pagination .page-link {
        padding: 8px 12px;
        font-size: 14px;
        min-width: 38px;
    }
}

/* Mobile Large (480px to 575px) */
@media (max-width: 575px) and (min-width: 480px) {
    .container-fluid {
        width: 100%;
        padding: 0 15px;
        margin: 8px auto;
    }
    
    .brands-grid {
        grid-template-columns: repeat(2, 1fr); /* 2 sản phẩm trên 1 hàng */
        gap: 12px;
        margin-bottom: 25px;
    }
    
    .brands-header {
        padding: 25px 15px;
        margin: 25px;
        border-radius: 10px;
    }
    
    .brands-main-title {
        font-size: 1.6rem;
        line-height: 1.2;
    }
    
    .brands-subtitle {
        font-size: 0.9rem;
        line-height: 1.4;
    }
    
    .brand-card {
        border-radius: 12px;
    }
    
    .brand-image {
        height: 120px;
    }
    
    .brand-image img {
        max-width: 60%;
        max-height: 60%;
    }
    
    .brand-placeholder {
        width: 50px;
        height: 50px;
        font-size: 1.3rem;
    }
    
    .brand-content {
        padding: 15px 12px;
    }
    
    .brand-name {
        font-size: 1.1rem;
        margin-bottom: 8px;
        line-height: 1.2;
    }
    
    .brand-description {
        font-size: 0.8rem;
        margin-bottom: 12px;
        min-height: 2.4em;
        -webkit-line-clamp: 2;
        line-height: 1.4;
    }
    
    .brand-stats {
        margin-bottom: 12px;
        padding: 8px;
        border-radius: 8px;
    }
    
    .stat-item strong {
        font-size: 1.2rem;
        margin-bottom: 1px;
    }
    
    .stat-item span {
        font-size: 0.8rem;
    }
    
    .view-products-btn {
        padding: 8px 15px;
        font-size: 0.8rem;
        border-radius: 18px;
    }
    
    .empty-state {
        padding: 60px 15px;
    }
    
    .empty-state i {
        font-size: 4rem;
        margin-bottom: 20px;
    }
    
    .empty-state h5 {
        font-size: 1.3rem;
        margin-bottom: 12px;
    }
    
    .empty-state p {
        font-size: 1rem;
        margin-bottom: 25px;
    }
    
    .pagination-wrapper {
        margin-top: 40px;
    }
    
    .custom-pagination .pagination {
        gap: 5px;
        flex-wrap: wrap;
        justify-content: center;
    }
    
    .custom-pagination .page-link {
        padding: 7px 10px;
        font-size: 13px;
        min-width: 35px;
    }
}

/* Mobile Small (320px to 479px) */
@media (max-width: 479px) {
    .container-fluid {
        width: 100%;
        padding: 0 12px;
        margin: 5px auto;
    }
    
    .brands-grid {
        grid-template-columns: repeat(2, 1fr); /* 2 sản phẩm trên 1 hàng */
        gap: 10px;
        margin-bottom: 20px;
    }
    
    .brands-header {
        padding: 20px 12px;
        margin: 20px;
        border-radius: 8px;
    }
    
    .brands-main-title {
        font-size: 1.4rem;
        line-height: 1.1;
    }
    
    .brands-subtitle {
        font-size: 0.85rem;
        line-height: 1.3;
    }
    
    .brand-card {
        border-radius: 10px;
    }
    
    .brand-image {
        height: 100px;
    }
    
    .brand-image img {
        max-width: 55%;
        max-height: 55%;
    }
    
    .brand-placeholder {
        width: 40px;
        height: 40px;
        font-size: 1.1rem;
    }
    
    .brand-content {
        padding: 12px 8px;
    }
    
    .brand-name {
        font-size: 1rem;
        margin-bottom: 6px;
        line-height: 1.1;
    }
    
    .brand-description {
        font-size: 0.75rem;
        margin-bottom: 10px;
        min-height: 2.2em;
        -webkit-line-clamp: 2;
        line-height: 1.3;
    }
    
    .brand-stats {
        margin-bottom: 10px;
        padding: 6px;
        border-radius: 6px;
    }
    
    .stat-item strong {
        font-size: 1.1rem;
        margin-bottom: 0;
    }
    
    .stat-item span {
        font-size: 0.75rem;
    }
    
    .view-products-btn {
        padding: 6px 12px;
        font-size: 0.75rem;
        border-radius: 15px;
    }
    
    .brand-card:hover {
        transform: translateY(-4px);
    }
    
    .empty-state {
        padding: 50px 12px;
    }
    
    .empty-state i {
        font-size: 3.5rem;
        margin-bottom: 15px;
    }
    
    .empty-state h5 {
        font-size: 1.2rem;
        margin-bottom: 10px;
    }
    
    .empty-state p {
        font-size: 0.95rem;
        margin-bottom: 20px;
    }
    
    .pagination-wrapper {
        margin-top: 30px;
    }
    
    .custom-pagination .pagination {
        gap: 3px;
        flex-wrap: wrap;
        justify-content: center;
    }
    
    .custom-pagination .page-link {
        padding: 6px 8px;
        font-size: 12px;
        min-width: 32px;
    }
}

/* Extra responsive adjustments */
@media (max-width: 360px) {
    .brands-grid {
        gap: 8px;
    }
    
    .brand-content {
        padding: 10px 6px;
    }
    
    .brand-name {
        font-size: 0.95rem;
    }
    
    .brand-description {
        font-size: 0.7rem;
    }
    
    .view-products-btn {
        padding: 5px 10px;
        font-size: 0.7rem;
    }
}
</style>
@endpush
