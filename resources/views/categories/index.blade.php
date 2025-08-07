@extends('layouts.app')

@section('title', 'Danh mục sản phẩm - SuperWin')
@section('description', 'Khám phá các danh mục sản phẩm máy bơm nước, quạt công nghiệp chất lượng cao tại SuperWin.')

@section('content')
<div class="container py-5">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Trang chủ</a></li>
            <li class="breadcrumb-item active" aria-current="page">Danh mục sản phẩm</li>
        </ol>
    </nav>

    <!-- Page Header -->
    <div class="text-center mb-5">
        <h1 class="display-5 fw-bold mb-3">Danh mục sản phẩm</h1>
        <p class="lead text-muted">Khám phá các sản phẩm chất lượng cao của chúng tôi</p>
    </div>

    <!-- Categories Grid -->
    @if($categories->count() > 0)
        <div class="row g-4">
            @foreach($categories as $category)
            <div class="col-lg-4 col-md-6">
                <div class="card h-100 border-0 shadow-sm category-card">
                    <div class="card-body p-4">
                        <!-- Category Image -->
                        <div class="text-center mb-3">
                            @if($category->image)
                                <img src="{{ $category->image }}" alt="{{ $category->name }}" class="img-fluid rounded" style="max-height: 120px; object-fit: cover;">
                            @else
                                <div class="category-icon bg-primary bg-gradient rounded-3 d-inline-flex align-items-center justify-content-center" style="width: 80px; height: 80px;">
                                    <i class="fas fa-cog text-white fa-2x"></i>
                                </div>
                            @endif
                        </div>

                        <!-- Category Info -->
                        <div class="text-center">
                            <h5 class="card-title fw-bold mb-2">{{ $category->name }}</h5>
                            
                            @if($category->description)
                                <p class="card-text text-muted mb-3">{{ Str::limit($category->description, 100) }}</p>
                            @endif

                            <!-- Stats -->
                            <div class="d-flex justify-content-center gap-3 mb-3">
                                <small class="text-muted">
                                    <i class="fas fa-box me-1"></i>
                                    {{ $category->products_count }} sản phẩm
                                </small>
                                @if($category->children_count > 0)
                                    <small class="text-muted">
                                        <i class="fas fa-sitemap me-1"></i>
                                        {{ $category->children_count }} danh mục con
                                    </small>
                                @endif
                            </div>

                            <!-- Action Button -->
                            <a href="{{ route('categories.show', $category->slug) }}" class="btn btn-primary btn-sm">
                                <i class="fas fa-eye me-1"></i>Xem sản phẩm
                            </a>
                        </div>

                        <!-- Sub-categories -->
                        @if($category->children->count() > 0)
                            <hr class="my-3">
                            <div class="subcategories">
                                <h6 class="text-muted mb-2 small">Danh mục con:</h6>
                                <div class="d-flex flex-wrap gap-1">
                                    @foreach($category->children->take(3) as $child)
                                        <a href="{{ route('categories.show', $child->slug) }}" class="badge bg-light text-dark text-decoration-none">
                                            {{ $child->name }}
                                        </a>
                                    @endforeach
                                    @if($category->children->count() > 3)
                                        <span class="badge bg-secondary">+{{ $category->children->count() - 3 }} khác</span>
                                    @endif
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Pagination -->
        @if($categories->hasPages())
            <div class="d-flex justify-content-center mt-5">
                {{ $categories->links() }}
            </div>
        @endif
    @else
        <!-- Empty State -->
        <div class="text-center py-5">
            <div class="mb-4">
                <i class="fas fa-folder-open fa-5x text-muted"></i>
            </div>
            <h3 class="text-muted mb-3">Chưa có danh mục nào</h3>
            <p class="text-muted mb-4">Hiện tại chưa có danh mục sản phẩm nào được hiển thị.</p>
            <a href="{{ route('home') }}" class="btn btn-primary">
                <i class="fas fa-home me-1"></i>Về trang chủ
            </a>
        </div>
    @endif
</div>
@endsection

@push('styles')
<style>
.category-card {
    transition: all 0.3s ease;
    border-radius: 12px;
}

.category-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 25px rgba(0,0,0,0.15) !important;
}

.category-icon {
    transition: transform 0.3s ease;
}

.category-card:hover .category-icon {
    transform: scale(1.1);
}

.subcategories .badge {
    font-size: 0.7rem;
    padding: 4px 8px;
}

.breadcrumb-item + .breadcrumb-item::before {
    content: "›";
    color: #6c757d;
}

.breadcrumb a {
    color: #4facfe;
    text-decoration: none;
}

.breadcrumb a:hover {
    color: #3a8bfd;
}
</style>
@endpush