@extends('layouts.app')

@section('title', '404 - Không tìm thấy trang')

@section('content')
<div class="error-page py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6 text-center">
                <div class="error-content">
                    <!-- 404 Icon -->
                    <div class="error-icon mb-4">
                        <i class="fas fa-exclamation-triangle text-warning" style="font-size: 5rem;"></i>
                    </div>

                    <!-- Error Message -->
                    <h1 class="error-title mb-3">404</h1>
                    <h2 class="error-subtitle mb-4">Không tìm thấy trang</h2>

                    <p class="error-description mb-5">
                        Trang bạn đang tìm kiếm không tồn tại hoặc đã được di chuyển.
                        Vui lòng kiểm tra lại đường dẫn hoặc quay về trang chủ.
                    </p>

                    <!-- Action Buttons -->
                    <div class="error-actions">
                        <a href="{{ route('home') }}" class="btn btn-primary btn-lg me-3">
                            <i class="fas fa-home me-2"></i>Về trang chủ
                        </a>
                        <a href="{{ route('products.index') }}" class="btn btn-outline-primary btn-lg me-3">
                            <i class="fas fa-shopping-bag me-2"></i>Xem sản phẩm
                        </a>
                        <button onclick="history.back()" class="btn btn-outline-secondary btn-lg">
                            <i class="fas fa-arrow-left me-2"></i>Quay lại
                        </button>
                    </div>

                    <!-- Search Box -->
                    <div class="search-box mt-5">
                        <h5 class="mb-3">Tìm kiếm sản phẩm</h5>
                        <form action="{{ route('search') }}" method="GET" class="d-flex justify-content-center">
                            <div class="input-group" style="max-width: 400px;">
                                <input type="text" name="q" class="form-control" placeholder="Nhập tên sản phẩm..." value="{{ request('q') }}">
                                <button class="btn btn-primary" type="submit">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </form>
                    </div>

                    <!-- Popular Categories -->
                    <div class="popular-categories mt-5">
                        <h5 class="mb-3">Danh mục phổ biến</h5>
                        <div class="row g-3">
                            <div class="col-6 col-md-3">
                                <a href="{{ route('categories.show', 'may-bom-nuoc') }}" class="category-link">
                                    <div class="category-card">
                                        <i class="fas fa-tint text-primary mb-2"></i>
                                        <span>Máy bơm nước</span>
                                    </div>
                                </a>
                            </div>
                            <div class="col-6 col-md-3">
                                <a href="{{ route('categories.show', 'quat-cong-nghiep') }}" class="category-link">
                                    <div class="category-card">
                                        <i class="fas fa-fan text-primary mb-2"></i>
                                        <span>Quạt công nghiệp</span>
                                    </div>
                                </a>
                            </div>
                            <div class="col-6 col-md-3">
                                <a href="{{ route('categories.show', 'quat-thong-gio') }}" class="category-link">
                                    <div class="category-card">
                                        <i class="fas fa-wind text-primary mb-2"></i>
                                        <span>Quạt thông gió</span>
                                    </div>
                                </a>
                            </div>
                            <div class="col-6 col-md-3">
                                <a href="{{ route('products.featured') }}" class="category-link">
                                    <div class="category-card">
                                        <i class="fas fa-star text-primary mb-2"></i>
                                        <span>Sản phẩm nổi bật</span>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.error-page {
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    min-height: 70vh;
    display: flex;
    align-items: center;
}

.error-content {
    background: white;
    border-radius: 20px;
    padding: 60px 40px;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
}

.error-icon {
    animation: bounce 2s infinite;
}

@keyframes bounce {
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

.error-title {
    font-size: 4rem;
    font-weight: bold;
    color: #dc3545;
    margin: 0;
    text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.1);
}

.error-subtitle {
    font-size: 1.5rem;
    color: #6c757d;
    font-weight: 600;
}

.error-description {
    font-size: 1.1rem;
    color: #6c757d;
    line-height: 1.6;
}

.error-actions {
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
    gap: 15px;
}

.error-actions .btn {
    border-radius: 10px;
    padding: 12px 24px;
    font-weight: 600;
    transition: all 0.3s ease;
}

.error-actions .btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
}

.search-box {
    padding: 30px;
    background: #f8f9fa;
    border-radius: 15px;
    margin-top: 40px;
}

.search-box h5 {
    color: #495057;
    font-weight: 600;
}

.search-box .input-group {
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    border-radius: 10px;
    overflow: hidden;
}

.search-box .form-control {
    border: none;
    padding: 15px 20px;
    font-size: 1rem;
}

.search-box .form-control:focus {
    box-shadow: none;
}

.search-box .btn {
    padding: 15px 20px;
    border: none;
    background: #007bff;
    color: white;
}

.popular-categories {
    margin-top: 40px;
}

.popular-categories h5 {
    color: #495057;
    font-weight: 600;
}

.category-link {
    text-decoration: none;
    color: inherit;
}

.category-card {
    background: white;
    border: 2px solid #e9ecef;
    border-radius: 12px;
    padding: 20px 15px;
    text-align: center;
    transition: all 0.3s ease;
    height: 100%;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
}

.category-card:hover {
    border-color: #007bff;
    transform: translateY(-5px);
    box-shadow: 0 8px 25px rgba(0, 123, 255, 0.15);
}

.category-card i {
    font-size: 2rem;
    margin-bottom: 10px;
}

.category-card span {
    font-weight: 600;
    color: #495057;
    font-size: 0.9rem;
}

/* Responsive */
@media (max-width: 768px) {
    .error-content {
        padding: 40px 20px;
    }

    .error-title {
        font-size: 3rem;
    }

    .error-subtitle {
        font-size: 1.2rem;
    }

    .error-actions {
        flex-direction: column;
        align-items: center;
    }

    .error-actions .btn {
        width: 100%;
        max-width: 300px;
    }

    .search-box {
        padding: 20px;
    }

    .popular-categories .row {
        margin: 0 -5px;
    }

    .popular-categories .col-6,
    .popular-categories .col-md-3 {
        padding: 0 5px;
    }
}
</style>
@endsection
