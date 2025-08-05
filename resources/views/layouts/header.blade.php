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
                <a href="{{ route('cart.index') }}" class="btn btn-outline-primary me-2 position-relative">
                    <i class="fas fa-shopping-cart"></i>
                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger cart-count">
                        {{ Session::has('cart') ? collect(Session::get('cart'))->sum('quantity') : '0' }}
                    </span>
                </a>

                <!-- User menu -->
                @auth('customer')
                    <div class="dropdown">
                        <button class="btn btn-outline-primary dropdown-toggle" type="button" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-user me-1"></i>
                            {{ Auth::guard('customer')->user()->name }}
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="userDropdown">
                        <li><a class="dropdown-item" href="{{ route('profile') }}"><i class="fas fa-file-alt me-2"></i>Tài khoản của bạn</a></li>
                        <li><a class="dropdown-item" href="#"><i class="fas fa-list me-2"></i>Quản lý đơn hàng</a></li>
                        <li><a class="dropdown-item" href="#"><i class="fas fa-heart me-2"></i>Sản phẩm yêu thích</a></li>
                        <li><a class="dropdown-item" href="#"><i class="fas fa-map-marker-alt me-2"></i>Địa chỉ giao hàng</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form action="{{ route('logout') }}" method="POST" class="d-inline">
                                    @csrf
                                <button type="submit" class="dropdown-item text-danger logout-btn">
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
                                    <a href="{{ route('categories.show', 'may-bom-nuoc') }}">
                                        <span>💧 Máy Bơm Nước</span>
                                        <i class="fas fa-chevron-right"></i>
                                    </a>
                                    <ul class="sub-category">
                                        <li><a href="{{ route('products.brand', 'super-win') }}">Máy bơm nước Super Win</a></li>
                                        <li><a href="{{ route('products.brand', 'vina-pump') }}">Máy bơm nước Vina Pump</a></li>
                                        <li><a href="{{ route('products.brand', 'abc') }}">Máy bơm nước ABC</a></li>
                                        <li><a href="{{ route('products.category', 'may-bom-nuoc-bien') }}">Máy bơm nước biển</a></li>
                                        <li><a href="{{ route('products.category', 'may-bom-ho-boi') }}">Máy bơm hồ bơi</a></li>
                                        <li><a href="{{ route('products.category', 'may-bom-nhap-khau') }}">Máy bơm nhập khẩu</a></li>
                                    </ul>
                                </li>
                                <li>
                                    <a href="{{ route('categories.show', 'quat-cong-nghiep') }}">
                                        <span>🌪️ Quạt công nghiệp</span>
                                        <i class="fas fa-chevron-right"></i>
                                    </a>
                                    <ul class="sub-category">
                                        <li><a href="{{ route('products.brand', 'super-win-fan') }}">Quạt Super Win</a></li>
                                        <li><a href="{{ route('products.brand', 'deton') }}">Quạt Deton</a></li>
                                        <li><a href="{{ route('products.brand', 'sthc') }}">Quạt STHC</a></li>
                                        <li><a href="{{ route('products.brand', 'inverter') }}">Quạt Inverter</a></li>
                                    </ul>
                                </li>
                                <li>
                                    <a href="{{ route('categories.show', 'quat-thong-gio') }}">
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
                                    <a href="{{ route('categories.show', 'quat-dac-biet') }}">
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
                                    <a href="{{ route('categories.show', 'tam-lam-mat') }}">
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
                    <button type="submit" class="btn btn-outline-danger btn-sm logout-btn">Thoát</button>
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
</style>
@endpush

@push('scripts')
<script>
// Hàm cập nhật giỏ hàng toàn cục
window.updateCartCount = function(count) {
    const cartCountElement = document.querySelector('.cart-count');
    if (cartCountElement) {
        cartCountElement.textContent = count;

        // Thêm hiệu ứng nhấp nháy khi cập nhật
        cartCountElement.classList.add('cart-update');
        setTimeout(() => {
            cartCountElement.classList.remove('cart-update');
        }, 300);
    }
};
// Cải thiện trải nghiệm đăng xuất và dropdown
document.addEventListener('DOMContentLoaded', function() {
    // Kiểm tra và khởi tạo dropdown
    const userDropdown = document.getElementById('userDropdown');
    const dropdownMenu = document.querySelector('.dropdown-menu');

    if (userDropdown && dropdownMenu) {
        console.log('Dropdown elements found');

        // Thêm event listener cho dropdown
        userDropdown.addEventListener('click', function(e) {
            e.preventDefault();
            const isExpanded = this.getAttribute('aria-expanded') === 'true';
            this.setAttribute('aria-expanded', !isExpanded);

            if (isExpanded) {
                dropdownMenu.classList.remove('show');
            } else {
                dropdownMenu.classList.add('show');
            }
        });

        // Đóng dropdown khi click bên ngoài
        document.addEventListener('click', function(e) {
            if (!userDropdown.contains(e.target) && !dropdownMenu.contains(e.target)) {
                dropdownMenu.classList.remove('show');
                userDropdown.setAttribute('aria-expanded', 'false');
            }
        });
    } else {
        console.log('Dropdown elements not found');
    }

    // Tìm tất cả các form đăng xuất
    const logoutForms = document.querySelectorAll('form[action*="logout"]');

    logoutForms.forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();

            // Hiển thị dialog xác nhận
            if (confirm('Bạn có chắc chắn muốn thoát?')) {
                // Nếu người dùng xác nhận, submit form
                this.submit();
            }
        });
    });

    // Thêm hiệu ứng hover cho nút đăng xuất
    const logoutButtons = document.querySelectorAll('.logout-btn');

    logoutButtons.forEach(button => {
        button.addEventListener('mouseenter', function() {
            this.style.transform = 'translateX(5px)';
        });

        button.addEventListener('mouseleave', function() {
            this.style.transform = 'translateX(0)';
        });
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
});
</script>
@endpush
