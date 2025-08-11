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
                <form action="{{ route('search') }}" method="GET" id="mainSearchForm">
                <span class="search-icon">
                    <i class="fas fa-search"></i>
                </span>
                    <input type="text" class="form-control search-input main-search-input" id="mainSearchInput" name="q" placeholder="Tìm kiếm sản phẩm..." autocomplete="off">
                </form>

                <!-- AJAX Search Suggestions Dropdown -->
                <div class="main-search-suggestions" id="mainSearchSuggestions" style="display: none;">
                    <div class="suggestions-content">
                        <!-- Search keyword section -->
                        <div class="suggestion-keyword" id="mainSuggestionKeyword" style="display: none;">
                            <div class="suggestion-item keyword-item">
                                <i class="fas fa-search me-2"></i>
                                <span class="keyword-text"></span>
                            </div>
                        </div>
                        
                        <!-- Products suggestions -->
                        <div class="suggestions-products" id="mainSuggestionsProducts">
                            <!-- Dynamic content will be loaded here -->
                        </div>
                        
                        <!-- Loading state -->
                        <div class="suggestion-loading" id="mainSuggestionLoading" style="display: none;">
                            <div class="text-center py-3">
                                <i class="fas fa-spinner fa-spin me-2"></i>
                                <span>Đang tìm kiếm...</span>
                            </div>
                        </div>
                        
                        <!-- No results -->
                        <div class="suggestion-no-results" id="mainSuggestionNoResults" style="display: none;">
                            <div class="text-center py-3 text-muted">
                                <i class="fas fa-search me-2"></i>
                                <span>Không tìm thấy sản phẩm nào</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Desktop Search Overlay (Static for click) -->
                <div id="desktopSearchOverlay" class="desktop-search-overlay">
                    <div class="desktop-search-box">
                        <div class="desktop-search-suggestions">
                            <div class="suggest-title">Từ khóa HOT</div>
                            <div class="suggest-tags" id="hotKeywordTags">
                                <span class="suggest-tag" onclick="searchKeyword('Máy bơm nước')">Máy bơm nước</span>
                                <span class="suggest-tag" onclick="searchKeyword('Máy bơm chìm')">Máy bơm chìm</span>
                                <span class="suggest-tag" onclick="searchKeyword('Quạt công nghiệp')">Quạt công nghiệp</span>
                                <span class="suggest-tag" onclick="searchKeyword('Máy bơm')">Máy bơm</span>
                                <span class="suggest-tag" onclick="searchKeyword('SuperWin')">SuperWin</span>
                            </div>
                            <div class="suggest-title mt-3">Gợi ý nổi bật</div>
                            <div class="suggest-campaign">
                                <div class="suggest-campaign-item" onclick="window.location.href='{{ route('deals') }}'">Deal sốc hôm nay!</div>
                                <div class="suggest-campaign-item" onclick="window.location.href='{{ route('products.featured') }}'">Miễn phí vận chuyển toàn quốc</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Desktop menu -->
            <ul class="navbar-nav me-4 d-none d-lg-flex flex-shrink-1">
                <li class="nav-item"><a class="nav-link" href="{{ route('home') }}">Trang chủ</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('products.index') }}">Sản phẩm</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('support') }}">Hỗ trợ</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('contact') }}">Liên hệ</a></li>
            </ul>

            <!-- User actions -->
            <div class="d-flex align-items-center flex-shrink-0">
                <!-- Cart -->
                <a href="{{ route('cart.index') }}" class="btn btn-outline-primary me-2 position-relative cart-link">
                    <i class="fas fa-shopping-cart cart-icon"></i>
                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger cart-count"
                          style="display: none;">
                        0
                    </span>
                </a>

                <!-- User menu -->
                @auth('customer')
                    <div class="dropdown">
                        <button class="btn btn-outline-primary dropdown-toggle" type="button" id="userDropdown" data-bs-toggle="dropdown" data-bs-auto-close="true" aria-expanded="false">
                            <i class="fas fa-user me-1"></i>
                            {{ Auth::guard('customer')->user()->name }}
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                            <li><a class="dropdown-item" href="{{ route('profile') }}"><i class="fas fa-file-alt me-2"></i>Tài khoản của bạn</a></li>
                            <li><a class="dropdown-item" href="{{ route('orders.index') }}"><i class="fas fa-list me-2"></i>Quản lý đơn hàng</a></li>
                            <li><a class="dropdown-item" href="#"><i class="fas fa-heart me-2"></i>Sản phẩm yêu thích</a></li>
                            <li><a class="dropdown-item" href="#"><i class="fas fa-map-marker-alt me-2"></i>Địa chỉ giao hàng</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form action="{{ route('logout') }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="button" class="dropdown-item text-danger logout-btn">
                                        <i class="fas fa-sign-out-alt me-2"></i>Thoát
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>
                @else
                    <div class="d-flex">
                        <a href="{{ route('login') }}" class="btn btn-outline-primary me-2">Đăng nhập</a>
                        <a href="{{ route('register') }}" class="btn btn-primary">Đăng ký</a>
                    </div>
                @endauth
            </div>
        </div>
    </nav>

    <!-- Bottom Navigation (Desktop only) -->
    <div class="nav-bottom d-none d-lg-block" style="margin-top: 32px;">
        <div class="container">
            <div class="d-flex align-items-center justify-content-between" style="height: 50px;">
                <div class="d-flex align-items-center gap-4">
                    <!-- Dropdown Danh Mục -->
                    <div class="dropdown-custom">
                        <a href="#">
                            <i class="fas fa-bars"></i>
                            Danh Mục
                        </a>
                        <div class="dropdown-content">
                            <ul class="main-category">
                                <li>
                                    <a href="{{ route('products.featured') }}">
                                        <span>⭐ Sản phẩm nổi bật</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('categories.show', 1) }}">
                                        <span>💧 Máy Bơm Nước</span>
                                        <i class="fas fa-chevron-right"></i>
                                    </a>
                                    <ul class="sub-category">
                                        <li><a href="{{ route('products.brand', ['slug' => 'super-win']) }}">Máy bơm nước Super Win</a></li>
                                        <li><a href="{{ route('products.brand', ['slug' => 'vina-pump']) }}">Máy bơm nước Vina Pump</a></li>
                                        <li><a href="{{ route('products.brand', ['slug' => 'abc']) }}">Máy bơm nước ABC</a></li>
                                        <li><a href="{{ route('products.category', 'may-bom-nuoc-bien') }}">Máy bơm nước biển</a></li>
                                        <li><a href="{{ route('products.category', 'may-bom-ho-boi') }}">Máy bơm hồ bơi</a></li>
                                        <li><a href="{{ route('products.category', 'may-bom-nhap-khau') }}">Máy bơm nhập khẩu</a></li>
                                    </ul>
                                </li>
                                <li>
                                    <a href="{{ route('categories.show', 2) }}">
                                        <span>🌪️ Quạt công nghiệp</span>
                                        <i class="fas fa-chevron-right"></i>
                                    </a>
                                    <ul class="sub-category">
                                        <li><a href="{{ route('products.brand', ['slug' => 'super-win-fan']) }}">Quạt Super Win</a></li>
                                        <li><a href="{{ route('products.brand', ['slug' => 'deton']) }}">Quạt Deton</a></li>
                                        <li><a href="{{ route('products.brand', ['slug' => 'sthc']) }}">Quạt STHC</a></li>
                                        <li><a href="{{ route('products.brand', ['slug' => 'inverter']) }}">Quạt Inverter</a></li>
                                    </ul>
                                </li>
                                <li>
                                    <a href="{{ route('categories.show', 5) }}">
                                        <span>💨 Quạt thông gió</span>
                                        <i class="fas fa-chevron-right"></i>
                                    </a>
                                    <ul class="sub-category">
                                        <li><a href="{{ route('products.category', 'quat-thong-gio-vuong-super-win') }}">Quạt thông gió vuông Super Win</a></li>
                                        <li><a href="{{ route('products.category', 'quat-thong-gio-vuong-deton') }}">Quạt thông gió vuông Deton</a></li>
                                        <li><a href="{{ route('products.category', 'quat-thong-gio-tron') }}">Quạt thông gió tròn</a></li>
                                    </ul>
                                </li>
                                <li>
                                    <a href="{{ route('categories.show', 3) }}">
                                        <span>⚡ Quạt đặc biệt</span>
                                        <i class="fas fa-chevron-right"></i>
                                    </a>
                                    <ul class="sub-category">
                                        <li><a href="{{ route('products.category', 'quat-huong-truc-noi-ong') }}">Quạt hướng trục nổi ống</a></li>
                                        <li><a href="{{ route('products.category', 'quat-san-cong-nghiep') }}">Quạt sàn công nghiệp</a></li>
                                        <li><a href="{{ route('products.category', 'quat-tran-cong-nghiep') }}">Quạt trần công nghiệp</a></li>
                                        <li><a href="{{ route('products.category', 'quat-chong-chay-no') }}">Quạt chống cháy nổ</a></li>
                                        <li><a href="{{ route('products.category', 'quat-vuong') }}">Quạt vuông (trực tiếp/gián tiếp)</a></li>
                                        <li><a href="{{ route('products.category', 'quat-composite') }}">Quạt Composite</a></li>
                                    </ul>
                                </li>
                                <li>
                                    <a href="{{ route('categories.show', 4) }}">
                                        <span>❄️ Tấm làm mát</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <a href="{{ route('deals') }}">🔥 Hot Deals</a>
                    <a href="{{ route('brands') }}">🏷️ Thương hiệu</a>
                    <a href="{{ route('bestsellers') }}">📈 Bán chạy</a>
                    <a href="{{ route('trending') }}">🔍 Top tìm kiếm</a>
                </div>

                <div class="right-links">
                    <a href="{{ route('news') }}">📰 Tin tức - Sự kiện</a>
                    <span>|</span>
                    <a href="{{ route('blog') }}">📝 Bài viết</a>
                    <span>|</span>
                    <a href="{{ route('warranty') }}"><b>🛡️ Chính sách bảo hành</b></a>
                </div>
            </div>
        </div>
    </div>

    <!-- Mobile Offcanvas Menu -->
    <div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasMenu" aria-labelledby="offcanvasMenuLabel">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="offcanvasMenuLabel">Menu</h5>
            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <ul class="navbar-nav">
                <li class="nav-item"><a class="nav-link" href="{{ route('home') }}">Trang chủ</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('products.index') }}">Sản phẩm</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('support') }}">Hỗ trợ</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('contact') }}">Liên hệ</a></li>
            </ul>

            <hr>

            @auth('customer')
                <div class="mb-3">
                    <p class="text-muted mb-2">Xin chào, {{ Auth::guard('customer')->user()->name }}</p>
                    <a href="{{ route('profile') }}" class="btn btn-outline-primary btn-sm me-2">Tài khoản</a>
                    <form action="{{ route('logout') }}" method="POST" class="d-inline">
                        @csrf
                        <button type="button" class="btn btn-outline-danger btn-sm logout-btn">
                            <i class="fas fa-sign-out-alt me-1"></i>Thoát
                        </button>
                    </form>
                </div>
            @else
                <div class="d-grid gap-2">
                    <a href="{{ route('login') }}" class="btn btn-outline-primary">Đăng nhập</a>
                    <a href="{{ route('register') }}" class="btn btn-primary">Đăng ký</a>
                </div>
            @endauth
        </div>
    </div>

    <!-- Search Overlay -->
    <div class="search-overlay" id="searchOverlay">
        <div class="search-header">
            <div class="search-input-container">
                <form action="{{ route('search') }}" method="GET">
                    <input type="text" name="q" class="search-input" placeholder="Tìm kiếm sản phẩm, thương hiệu..." id="searchInput" value="{{ request('q') }}">
                </form>
                <button class="search-clear" id="clearBtn"></button>
                <button class="cancel-btn" id="cancelBtn">&times;</button>
            </div>
        </div>
        <div class="search-content">
            <div class="search-section">
                <div class="section-title">Từ Khóa HOT</div>
                <div class="hot-keywords">
                    @if(isset($hotKeywords))
                        @foreach($hotKeywords as $keyword)
                            <div class="keyword-tag">{{ $keyword }}</div>
                        @endforeach
                    @else
                        <div class="keyword-tag">SuperWin</div>
                        <div class="keyword-tag">Bơm nước 1HP</div>
                        <div class="keyword-tag">Quạt công nghiệp</div>
                        <div class="keyword-tag">Bơm chìm</div>
                        <div class="keyword-tag">Bơm Inox 304</div>
                        <div class="keyword-tag">Bơm ABC</div>
                        <div class="keyword-tag">Quạt Thông Gió</div>
                        <div class="keyword-tag">Quạt Vuông</div>
                        <div class="keyword-tag">Bơm Thả Chìm DC</div>
                    @endif
                </div>
            </div>
            <div class="search-section">
                <div class="section-title">Thương Hiệu</div>
                <div class="brand-grid">
                    @if(isset($brands))
                        @foreach($brands as $brand)
                            <div class="brand-item">{{ $brand->name }}</div>
                        @endforeach
                    @else
                        <div class="brand-item">SuperWin</div>
                        <div class="brand-item">VinaPump</div>
                        <div class="brand-item">Deton</div>
                        <div class="brand-item">Quạt Inverter</div>
                        <div class="brand-item">STHC</div>
                    @endif
                </div>
            </div>
        </div>
        <div class="search-blur-bg"></div>
    </div>

<!-- Flash Messages -->
@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert" style="position: fixed; top: 80px; right: 20px; z-index: 9999; min-width: 300px;">
        <i class="fas fa-check-circle me-2"></i>
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert" style="position: fixed; top: 80px; right: 20px; z-index: 9999; min-width: 300px;">
        <i class="fas fa-exclamation-circle me-2"></i>
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@if(session('warning'))
    <div class="alert alert-warning alert-dismissible fade show" role="alert" style="position: fixed; top: 80px; right: 20px; z-index: 9999; min-width: 300px;">
        <i class="fas fa-exclamation-triangle me-2"></i>
        {{ session('warning') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@if(session('info'))
    <div class="alert alert-info alert-dismissible fade show" role="alert" style="position: fixed; top: 80px; right: 20px; z-index: 9999; min-width: 300px;">
        <i class="fas fa-info-circle me-2"></i>
        {{ session('info') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@push('styles')
<style>
/* CSS cho giỏ hàng */
.cart-count {
    transition: all 0.3s ease;
}

.cart-update {
    animation: cartBounce 0.3s ease;
    background-color: #28a745 !important;
}

@keyframes cartBounce {
    0%, 100% { transform: scale(1) translate(50%, -50%); }
    50% { transform: scale(1.2) translate(50%, -50%); }
}
/* CSS cho dropdown menu user */
.dropdown-menu {
    border: none;
    border-radius: 12px;
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
    padding: 8px 0;
    min-width: 220px;
    display: none;
    position: absolute;
    top: 100%;
    right: 0;
    z-index: 1000;
    background: white;
}

.dropdown-menu.show {
    display: block;
    animation: fadeInDown 0.3s ease-out;
}

@keyframes fadeInDown {
    from {
        opacity: 0;
        transform: translateY(-10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.dropdown-item {
    padding: 10px 16px;
    font-size: 0.9rem;
    transition: all 0.3s ease;
    border-radius: 8px;
    margin: 2px 8px;
}

.dropdown-item:hover {
    background-color: #f8f9fa;
    transform: translateX(5px);
}

.dropdown-item i {
    width: 16px;
    text-align: center;
}

/* CSS cho nút đăng xuất */
.logout-btn {
    transition: all 0.3s ease;
    margin-top: 4px;
}

.logout-btn:hover {
    transform: translateX(5px);
    background-color: #dc3545 !important;
    color: white !important;
    box-shadow: 0 2px 8px rgba(220, 53, 69, 0.3);
}

.dropdown-item.logout-btn:hover {
    background-color: #dc3545 !important;
    color: white !important;
}

.btn-outline-danger.logout-btn:hover {
    background-color: #dc3545;
    border-color: #dc3545;
    color: white;
}

/* CSS cho dropdown container */
.dropdown {
    position: relative;
}

/* CSS cho dropdown toggle button */
#userDropdown {
    border-radius: 8px;
    padding: 8px 16px;
    font-size: 0.9rem;
    transition: all 0.3s ease;
}

#userDropdown:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 15px rgba(13, 110, 253, 0.3);
}

/* CSS cho Flash Messages */
.alert {
    border: none;
    border-radius: 12px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
    animation: slideInRight 0.5s ease-out;
}

.alert-success {
    background: linear-gradient(135deg, #28a745, #20c997);
    color: white;
}

.alert-danger {
    background: linear-gradient(135deg, #dc3545, #fd7e14);
    color: white;
}

.alert-warning {
    background: linear-gradient(135deg, #ffc107, #fd7e14);
    color: white;
}

.alert-info {
    background: linear-gradient(135deg, #17a2b8, #6f42c1);
    color: white;
}

.alert .btn-close {
    filter: invert(1);
    opacity: 0.8;
}

.alert .btn-close:hover {
    opacity: 1;
}

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

.alert.fade-out {
    animation: slideOutRight 0.5s ease-in forwards;
}

/* Main Search Suggestions Styles */
.main-search-suggestions {
    position: absolute;
    top: 100%;
    left: 0;
    right: 0;
    background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);
    border: none;
    border-radius: 20px;
    box-shadow: 0 20px 60px rgba(0, 0, 0, 0.15), 0 4px 20px rgba(0, 0, 0, 0.1);
    z-index: 1050;
    max-height: 320px;
    overflow-y: auto;
    margin-top: 8px;
    border: 2px solid rgba(59, 130, 246, 0.1);
    width: 100%;
    box-sizing: border-box;
    backdrop-filter: blur(10px);
}

.main-search-suggestions .suggestions-content {
    padding: 4px 0;
}

.main-search-suggestions .suggestion-item {
    padding: 8px 12px;
    cursor: pointer;
    transition: all 0.2s ease;
    display: flex;
    align-items: center;
    border-radius: 8px;
    margin: 2px 8px;
}

.main-search-suggestions .suggestion-item:hover {
    background-color: #f8f9fa;
    transform: translateX(4px);
}

.main-search-suggestions .keyword-item {
    background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%);
    font-weight: 700;
    font-size: 14px;
    color: white;
    padding: 12px 20px;
    margin: 8px 12px;
    border-radius: 50px;
    box-shadow: 0 8px 25px rgba(79, 70, 229, 0.3);
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    position: relative;
    overflow: hidden;
}

.main-search-suggestions .keyword-item::before {
    content: '🔍';
    margin-right: 8px;
    font-size: 16px;
}

.main-search-suggestions .keyword-item:hover {
    background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 100%);
    transform: translateY(-2px) scale(1.02);
    box-shadow: 0 12px 35px rgba(79, 70, 229, 0.4);
}

.main-search-suggestions .product-suggestion {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 16px;
    margin: 8px 12px;
    background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);
    border-radius: 16px;
    border: 1px solid rgba(148, 163, 184, 0.1);
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.06);
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    position: relative;
    overflow: hidden;
}

.main-search-suggestions .product-suggestion::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 4px;
    height: 100%;
    background: linear-gradient(135deg, #f59e0b, #ef4444);
    transform: scaleY(0);
    transition: transform 0.3s ease;
}

.main-search-suggestions .product-suggestion:hover {
    background: linear-gradient(135deg, #ffffff 0%, #fef3c7 100%);
    transform: translateY(-4px);
    box-shadow: 0 12px 40px rgba(0, 0, 0, 0.15);
    border-color: rgba(245, 158, 11, 0.3);
}

.main-search-suggestions .product-suggestion:hover::before {
    transform: scaleY(1);
}

.main-search-suggestions .product-suggestion img {
    width: 50px;
    height: 50px;
    object-fit: cover;
    border-radius: 12px;
    flex-shrink: 0;
    border: 2px solid rgba(255, 255, 255, 0.8);
    max-width: 50px;
    max-height: 50px;
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
    transition: all 0.3s ease;
}

.main-search-suggestions .product-suggestion:hover img {
    transform: scale(1.05);
    box-shadow: 0 12px 35px rgba(0, 0, 0, 0.2);
}

.main-search-suggestions .product-info {
    flex: 1;
    min-width: 0;
    overflow: hidden;
    display: flex;
    flex-direction: column;
    gap: 6px;
}

.main-search-suggestions .product-name {
    font-size: 15px;
    font-weight: 700;
    color: #1e293b;
    margin: 0;
    line-height: 1.4;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
    text-overflow: ellipsis;
    text-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
}

.main-search-suggestions .product-details {
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 12px;
}

.main-search-suggestions .product-brand {
    font-size: 11px;
    color: #6366f1;
    background: linear-gradient(135deg, #e0e7ff, #c7d2fe);
    padding: 4px 12px;
    border-radius: 20px;
    white-space: nowrap;
    font-weight: 600;
    border: 1px solid rgba(99, 102, 241, 0.2);
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.main-search-suggestions .product-price {
    font-size: 16px;
    font-weight: 800;
    background: linear-gradient(135deg, #f59e0b, #ef4444);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    white-space: nowrap;
    text-shadow: 0 2px 4px rgba(245, 158, 11, 0.3);
}

.main-search-suggestions .suggestion-loading,
.main-search-suggestions .suggestion-no-results {
    color: #666;
    font-size: 13px;
    padding: 16px;
    text-align: center;
}

/* Responsive for main search */
@media (max-width: 768px) {
    .main-search-suggestions {
        left: -15px;
        right: -15px;
        border-radius: 8px;
    }
    
    .main-search-suggestions .product-suggestion {
        padding: 6px 8px;
        gap: 6px;
    }
    
    .main-search-suggestions .product-suggestion img {
        width: 28px;
        height: 28px;
        max-width: 28px;
        max-height: 28px;
    }
    
    .main-search-suggestions .product-name {
        font-size: 11px;
        -webkit-line-clamp: 1;
    }
    
    .main-search-suggestions .product-price {
        font-size: 11px;
    }
    
    .main-search-suggestions .product-brand {
        font-size: 8px;
        padding: 1px 4px;
    }
    
    .main-search-suggestions .keyword-item {
        font-size: 12px;
        padding: 6px 10px;
        margin: 2px 4px;
    }
    
    .main-search-suggestions .product-details {
        font-size: 10px;
    }
    
    .main-search-suggestions .product-brand {
        font-size: 9px;
        padding: 1px 3px;
    }
    
    .main-search-suggestions .product-price {
        font-size: 11px;
    }
    
    .main-search-suggestions .keyword-item {
        font-size: 12px;
        padding: 6px 10px;
        padding-left: 10px;
        border-left-width: 2px;
    }
}
</style>
@endpush

@push('scripts')
<script>
// Hàm cập nhật giỏ hàng toàn cục
window.updateCartCount = function(count) {
    const cartCountElement = document.querySelector('.cart-count');
    if (cartCountElement) {
        cartCountElement.textContent = count;
        cartCountElement.style.display = 'inline-block'; // Ensure it's visible

        // Thêm hiệu ứng nhấp nháy khi cập nhật
        cartCountElement.classList.add('cart-update');
        setTimeout(() => {
            cartCountElement.classList.remove('cart-update');
        }, 300);
    }
};

// Cập nhật giỏ hàng từ localStorage
function updateCartFromLocalStorage() {
    const cartCountElement = document.querySelector('.cart-count');
    if (cartCountElement) {
        const cartCount = localStorage.getItem('cartCount');
        if (cartCount) {
            cartCountElement.textContent = cartCount;
            cartCountElement.style.display = 'inline-block';
        } else {
            cartCountElement.textContent = '0';
            cartCountElement.style.display = 'none';
        }
    }
}

// Cải thiện trải nghiệm đăng xuất và dropdown
document.addEventListener('DOMContentLoaded', function() {
    // Sử dụng Bootstrap 5 Dropdown
    const dropdownElementList = document.querySelectorAll('.dropdown-toggle');
    const dropdownList = [...dropdownElementList].map(dropdownToggleEl => new bootstrap.Dropdown(dropdownToggleEl));

    // Đóng dropdown khi click item
    document.querySelectorAll('.dropdown-item').forEach(item => {
        item.addEventListener('click', () => {
            const dropdown = bootstrap.Dropdown.getInstance(item.closest('.dropdown').querySelector('.dropdown-toggle'));
            if (dropdown) {
                dropdown.hide();
            }
        });
    });

    // Xử lý đăng xuất
    document.addEventListener('click', function(e) {
        if (e.target.closest('.logout-btn')) {
            e.preventDefault();
            e.target.closest('form').submit();
        }
    });

    // Tự động ẩn flash messages sau 5 giây
    const alerts = document.querySelectorAll('.alert');
    alerts.forEach(alert => {
        setTimeout(() => {
            alert.classList.add('fade-out');
            setTimeout(() => {
                alert.remove();
            }, 500);
        }, 5000);
    });

    // Thêm hiệu ứng click để đóng alert
    const closeButtons = document.querySelectorAll('.alert .btn-close');
    closeButtons.forEach(button => {
        button.addEventListener('click', function() {
            const alert = this.closest('.alert');
            alert.classList.add('fade-out');
            setTimeout(() => {
                alert.remove();
            }, 500);
        });
    });

    // Cập nhật giỏ hàng khi trang được tải
    updateCartFromLocalStorage();
    
    // Initialize main search AJAX
    initMainSearchAjax();
});

// Main Search AJAX functionality
function initMainSearchAjax() {
    const mainSearchInput = document.getElementById('mainSearchInput');
    const mainSearchSuggestions = document.getElementById('mainSearchSuggestions');
    const mainSuggestionKeyword = document.getElementById('mainSuggestionKeyword');
    const mainSuggestionsProducts = document.getElementById('mainSuggestionsProducts');
    const mainSuggestionLoading = document.getElementById('mainSuggestionLoading');
    const mainSuggestionNoResults = document.getElementById('mainSuggestionNoResults');
    const mainSearchForm = document.getElementById('mainSearchForm');
    
    if (!mainSearchInput) return; // Exit if elements don't exist
    
    let mainSearchTimeout;
    let currentMainQuery = '';
    
    // Search input event listener
    mainSearchInput.addEventListener('input', function() {
        const query = this.value.trim();
        currentMainQuery = query;
        
        // Clear previous timeout
        clearTimeout(mainSearchTimeout);
        
        if (query.length < 2) {
            hideMainSuggestions();
            return;
        }
        
        // Show loading state
        showMainLoading();
        
        // Debounce search requests
        mainSearchTimeout = setTimeout(() => {
            fetchMainSuggestions(query);
        }, 300);
    });
    
    // Hide suggestions when clicking outside
    document.addEventListener('click', function(e) {
        if (!e.target.closest('.search-container')) {
            hideMainSuggestions();
        }
    });
    
    // Show suggestions when focusing on input (if there's content)
    mainSearchInput.addEventListener('focus', function() {
        if (this.value.trim().length >= 2) {
            mainSearchSuggestions.style.display = 'block';
        }
    });
    
    // Handle keyboard navigation
    mainSearchInput.addEventListener('keydown', function(e) {
        const suggestions = mainSearchSuggestions.querySelectorAll('.suggestion-item');
        const activeItem = mainSearchSuggestions.querySelector('.suggestion-item.active');
        let activeIndex = -1;
        
        if (activeItem) {
            activeIndex = Array.from(suggestions).indexOf(activeItem);
        }
        
        switch(e.key) {
            case 'ArrowDown':
                e.preventDefault();
                if (activeIndex < suggestions.length - 1) {
                    if (activeItem) activeItem.classList.remove('active');
                    suggestions[activeIndex + 1].classList.add('active');
                }
                break;
                
            case 'ArrowUp':
                e.preventDefault();
                if (activeIndex > 0) {
                    if (activeItem) activeItem.classList.remove('active');
                    suggestions[activeIndex - 1].classList.add('active');
                }
                break;
                
            case 'Enter':
                if (activeItem) {
                    e.preventDefault();
                    activeItem.click();
                }
                break;
                
            case 'Escape':
                hideMainSuggestions();
                break;
        }
    });
    
    function fetchMainSuggestions(query) {
        fetch(`/api/search/suggestions?q=${encodeURIComponent(query)}`, {
            method: 'GET',
            headers: {
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.json())
        .then(data => {
            // Only update if this is still the current query
            if (query === currentMainQuery) {
                displayMainSuggestions(data);
            }
        })
        .catch(error => {
            console.error('Main search suggestions error:', error);
            hideMainSuggestions();
        });
    }
    
    function displayMainSuggestions(data) {
        hideMainLoading();
        
        // Clear previous suggestions
        mainSuggestionsProducts.innerHTML = '';
        
        // Show keyword suggestion
        if (data.keyword && data.keyword.length >= 2) {
            mainSuggestionKeyword.querySelector('.keyword-text').textContent = `Tìm kiếm "${data.keyword}"`;
            mainSuggestionKeyword.style.display = 'block';
            
            // Add click handler for keyword
            const keywordItem = mainSuggestionKeyword.querySelector('.keyword-item');
            keywordItem.onclick = function() {
                window.location.href = data.search_url;
            };
        } else {
            mainSuggestionKeyword.style.display = 'none';
        }
        
        // Show product suggestions
        if (data.products && data.products.length > 0) {
            data.products.forEach(product => {
                const productElement = createMainProductSuggestion(product);
                mainSuggestionsProducts.appendChild(productElement);
            });
            
            mainSuggestionNoResults.style.display = 'none';
            mainSearchSuggestions.style.display = 'block';
        } else if (data.keyword && data.keyword.length >= 2) {
            // Show no results if we have a keyword but no products
            mainSuggestionNoResults.style.display = 'block';
            mainSearchSuggestions.style.display = 'block';
        } else {
            hideMainSuggestions();
        }
    }
    
    function createMainProductSuggestion(product) {
        const div = document.createElement('div');
        div.className = 'suggestion-item product-suggestion';
        div.innerHTML = `
            <img src="${product.image}" alt="${product.name}" onerror="this.src='/image/sp1.png'">
            <div class="product-info">
                <div class="product-name">${product.name}</div>
                <div class="product-details">
                    <span class="product-brand">${product.brand}</span>
                    <span class="product-price">${product.formatted_price}</span>
                </div>
            </div>
        `;
        
        div.onclick = function() {
            window.location.href = product.url;
        };
        
        return div;
    }
    
    function showMainLoading() {
        mainSuggestionLoading.style.display = 'block';
        mainSuggestionNoResults.style.display = 'none';
        mainSuggestionKeyword.style.display = 'none';
        mainSuggestionsProducts.innerHTML = '';
        mainSearchSuggestions.style.display = 'block';
    }
    
    function hideMainLoading() {
        mainSuggestionLoading.style.display = 'none';
    }
    
    function hideMainSuggestions() {
        mainSearchSuggestions.style.display = 'none';
        // Remove active states
        const activeItems = mainSearchSuggestions.querySelectorAll('.suggestion-item.active');
        activeItems.forEach(item => item.classList.remove('active'));
    }
}

// Function to search by keyword (for hot keyword tags)
function searchKeyword(keyword) {
    window.location.href = `/search?q=${encodeURIComponent(keyword)}`;
}
</script>
@endpush
