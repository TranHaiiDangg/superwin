<!-- Main Navigation -->
<nav class="navbar navbar-expand-lg fixed-top bg-white shadow-sm">
    <div class="container d-flex align-items-center justify-content-between flex-nowrap">
        <!-- Group hamburger + logo -->
        <div class="d-flex align-items-center flex-row flex-nowrap">
            <button class="navbar-toggler d-lg-none order-1 order-lg-0" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasMenu" aria-controls="offcanvasMenu" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <a class="navbar-brand flex-shrink-0 order-2 order-lg-1" href="{{ route('home') }}">
                <img src="/image/logo.png" alt="SuperWin Logo" class="logo-responsive" style="height: 65px; margin-left:20px;">
            </a>
        </div>

        <!-- Search container -->
        <div class="search-container flex-grow-1 mx-1 ms-3 ps-0 position-relative" style="min-width:90px;">
            <div class="input-group">
                <input type="text" class="form-control search-input" placeholder="Tìm kiếm sản phẩm..." id="searchInput">
                <button class="btn btn-primary search-btn" type="button" id="searchBtn">
                    <i class="fas fa-search"></i>
                </button>
            </div>
        </div>

        <!-- Right side buttons -->
        <div class="d-flex align-items-center gap-2 flex-shrink-0">
            <!-- User Account -->
            <div class="dropdown">
                <button class="btn btn-link text-dark p-1" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fas fa-user fa-lg"></i>
                </button>
                <ul class="dropdown-menu dropdown-menu-end">
                    @auth('customer')
                        <li><a class="dropdown-item" href="#"><i class="fas fa-user me-2"></i>Tài khoản</a></li>
                        <li><a class="dropdown-item" href="#"><i class="fas fa-shopping-bag me-2"></i>Đơn hàng</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="dropdown-item">
                                    <i class="fas fa-sign-out-alt me-2"></i>Đăng xuất
                                </button>
                            </form>
                        </li>
                    @else
                        <li><a class="dropdown-item" href="{{ route('login') }}"><i class="fas fa-sign-in-alt me-2"></i>Đăng nhập</a></li>
                        <li><a class="dropdown-item" href="{{ route('register') }}"><i class="fas fa-user-plus me-2"></i>Đăng ký</a></li>
                    @endauth
                </ul>
            </div>

            <!-- Cart -->
            <button class="btn btn-link text-dark p-1 position-relative" type="button">
                <i class="fas fa-shopping-cart fa-lg"></i>
                <span class="badge bg-danger position-absolute top-0 start-100 translate-middle rounded-pill" style="font-size: 0.7rem;">3</span>
            </button>
        </div>
    </div>
</nav>

<!-- Mobile Offcanvas Menu -->
<div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasMenu" aria-labelledby="offcanvasMenuLabel">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="offcanvasMenuLabel">Menu</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" href="{{ route('home') }}">Trang chủ</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('products.index') }}">Sản phẩm</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('products.index') }}">Danh mục</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('brands') }}">Thương hiệu</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('support') }}">Hỗ trợ</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('contact') }}">Liên hệ</a>
            </li>
        </ul>
    </div>
</div>

<!-- Search Overlay -->
<div class="search-overlay" id="searchOverlay">
    <div class="search-content">
        <div class="search-header">
            <h5>Tìm kiếm sản phẩm</h5>
            <button class="btn-close-search" id="closeSearch">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div class="search-body">
            <div class="search-section">
                <div class="section-title">Danh Mục</div>
                <div class="category-grid">
                    @if(isset($mainCategories))
                        @foreach($mainCategories as $category)
                            <a href="{{ route('categories.show', $category->slug ?? $category->id) }}" class="category-item">{{ $category->name }}</a>
                        @endforeach
                    @else
                        <a href="#" class="category-item">Máy bơm nước</a>
                        <a href="#" class="category-item">Quạt công nghiệp</a>
                        <a href="#" class="category-item">Phụ kiện</a>
                        <a href="#" class="category-item">Linh kiện</a>
                    @endif
                </div>
            </div>
            <div class="search-section">
                <div class="section-title">Thương Hiệu</div>
                <div class="brand-grid">
                    @if(isset($brands))
                        @foreach($brands as $brand)
                            <a href="{{ route('products.brand', $brand->slug ?? $brand->id) }}" class="brand-item">{{ $brand->name }}</a>
                        @endforeach
                    @else
                        <a href="#" class="brand-item">SuperWin</a>
                        <a href="#" class="brand-item">VinaPump</a>
                        <a href="#" class="brand-item">Deton</a>
                        <a href="#" class="brand-item">Quạt Inverter</a>
                        <a href="#" class="brand-item">STHC</a>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <div class="search-blur-bg"></div>
</div>
