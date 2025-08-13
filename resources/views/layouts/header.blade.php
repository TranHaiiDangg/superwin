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
                <span class="search-icon">
                    <i class="fas fa-search"></i>
                </span>
                <input type="text" class="form-control search-input main-search-input" id="mainSearchInput" placeholder="Tìm kiếm sản phẩm...">

                <!-- Desktop Search Overlay -->
                <div id="desktopSearchOverlay" class="desktop-search-overlay">
                    <div class="desktop-search-box">
                        <div class="desktop-search-suggestions">
                            <div class="suggest-title">Từ khóa HOT</div>
                            <div class="suggest-tags">
                                <span class="suggest-tag">Máy bơm nước</span>
                                <span class="suggest-tag">Máy bơm chìm</span>
                                <span class="suggest-tag">Quạt công nghiệp</span>
                                <span class="suggest-tag">Máy bơm</span>
                                <span class="suggest-tag">SuperWin</span>
                            </div>
                            <div class="suggest-title mt-3">Gợi ý nổi bật</div>
                            <div class="suggest-campaign">
                                <div class="suggest-campaign-item">Deal sốc hôm nay!</div>
                                <div class="suggest-campaign-item">Miễn phí vận chuyển toàn quốc</div>
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
                                @if(isset($mainCategories) && $mainCategories->count() > 0)
                                    @foreach($mainCategories as $category)
                                        <li>
                                            <a href="{{ route('categories.show', $category->slug ?? $category->id) }}">
                                                <span> {{ $category->name }}</span>
                                                @if($category->children->count() > 0)
                                                    <i class="fas fa-chevron-right"></i>
                                                @endif
                                            </a>
                                            @if($category->children->count() > 0)
                                                <ul class="sub-category">
                                                    @foreach($category->children as $child)
                                                        <li>
                                                            <a href="{{ route('categories.show', $child->slug ?? $child->id) }}">
                                                                {{ $child->name }}
                                                            </a>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            @endif
                                        </li>
                                    @endforeach
                                @else
                                    <!-- Fallback categories if database is empty -->
                                    <li>
                                        <a href="{{ route('products.featured') }}">
                                            <span>⭐ Sản phẩm nổi bật</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">
                                            <span>💧 Máy Bơm Nước</span>
                                            <i class="fas fa-chevron-right"></i>
                                        </a>
                                        <ul class="sub-category">
                                            <li><a href="#">Máy bơm nước Super Win</a></li>
                                            <li><a href="#">Máy bơm nước Vina Pump</a></li>
                                            <li><a href="#">Máy bơm nước ABC</a></li>
                                        </ul>
                                    </li>
                                    <li>
                                        <a href="#">
                                            <span>🌪️ Quạt công nghiệp</span>
                                            <i class="fas fa-chevron-right"></i>
                                        </a>
                                        <ul class="sub-category">
                                            <li><a href="#">Quạt Super Win</a></li>
                                            <li><a href="#">Quạt Deton</a></li>
                                            <li><a href="#">Quạt STHC</a></li>
                                        </ul>
                                    </li>
                                @endif
                            </ul>
                        </div>
                    </div>

                    <a href="{{ route('deals') }}">🔥 Hot Deals</a>
                    <a href="{{ route('brands') }}">🏷️ Thương hiệu</a>
                    <a href="{{ route('bestsellers') }}">📈 Bán chạy</a>
                    <a href="{{ route('trending') }}">🔍 Top tìm kiếm</a>
                </div>

                <div class="right-links">
                    <a href="{{ route('news') }}"> <i class="fas fa-phone"></i> Đặt hàng: 097.168.7711 </a>
                    <span>|</span>
                    <a href="{{ route('blog') }}"> <i class="fas fa-phone"></i> Hỗ trợ: 028.6269.7382</a>
                    <!-- <span>|</span> -->
                    <!-- <a href="{{ route('warranty') }}"><b>🛡️ Chính sách bảo hành</b></a> -->
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
                <div class="section-title">Danh Mục</div>
                <div class="category-grid">
                    @if(isset($mainCategories) && $mainCategories->count() > 0)
                        @foreach($mainCategories->take(6) as $category)
                            <div class="category-item">
                                <a href="{{ route('categories.show', $category->slug ?? $category->id) }}">
                                    {{ $category->name }}
                                </a>
                            </div>
                        @endforeach
                    @else
                        <div class="category-item">Máy bơm nước</div>
                        <div class="category-item">Quạt công nghiệp</div>
                        <div class="category-item">Quạt thông gió</div>
                        <div class="category-item">Tấm làm mát</div>
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
});
</script>
@endpush
