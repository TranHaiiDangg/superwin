<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'SuperWin')</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    {{-- CSS Files --}}
    <link rel="stylesheet" href="{{ asset('css/trang_chu/header.css') }}">
    <link rel="stylesheet" href="{{ asset('css/trang_chu/banner_silder.css') }}">
    <link rel="stylesheet" href="{{ asset('css/trang_chu/container-menu.css') }}">
    <link rel="stylesheet" href="{{ asset('css/trang_chu/flass_deal.css') }}">
    <link rel="stylesheet" href="{{ asset('css/trang_chu/image-row.css') }}">
    <link rel="stylesheet" href="{{ asset('css/trang_chu/top_sales.css') }}">
    <link rel="stylesheet" href="{{ asset('css/trang_chu/top_search.css') }}">
    <link rel="stylesheet" href="{{ asset('css/trang_chu/product.css') }}">
    <link rel="stylesheet" href="{{ asset('css/trang_chu/footer.css') }}">
    <link rel="stylesheet" href="{{ asset('css/chat/chat.css') }}">
    <link rel="stylesheet" href="{{ asset('css/chat/main.css') }}">
    
    <meta name="theme-color" content="#4facfe">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        /* ===== MOBILE-FIRST BASE STYLES ===== */
        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
            line-height: 1.6;
            color: #212529;
            background-color: #ffffff;
            overflow-x: hidden;
            font-size: 0.93rem;
            padding-top: 60px; /* Mobile default */
        }
    </style>

    @stack('styles')
</head>

<body>
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
                <a href="#" class="btn btn-outline-primary me-2 position-relative">
                    <i class="fas fa-shopping-cart"></i>
                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                        0
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
                            <li><a class="dropdown-item" href="#"><i class="fas fa-user me-2"></i>Tài khoản</a></li>
                            <li><a class="dropdown-item" href="#"><i class="fas fa-shopping-bag me-2"></i>Đơn hàng</a></li>
                            <li><a class="dropdown-item" href="#"><i class="fas fa-heart me-2"></i>Yêu thích</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form action="{{ route('logout') }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="dropdown-item">
                                        <i class="fas fa-sign-out-alt me-2"></i>Đăng xuất
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
                    <a href="#" class="btn btn-outline-primary btn-sm me-2">Tài khoản</a>
                    <form action="{{ route('logout') }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-outline-danger btn-sm">Đăng xuất</button>
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

    <!-- Main Content -->
    <main>
        @yield('content')
    </main>

    <!-- Scripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('js/trang_chu/search-and-menu.js') }}"></script>
<script src="{{ asset('js/trang_chu/banner_slider.js') }}"></script>
<script src="{{ asset('js/trang_chu/flass_deal.js') }}"></script>
<script src="{{ asset('js/trang_chu/top_sales.js') }}"></script>
<script src="{{ asset('js/trang_chu/product.js') }}"></script>

<script src="{{ asset('js/chat/main.js') }}"></script>
<script src="{{ asset('js/chat/chat.js') }}"></script>

    @stack('scripts')
</body>
</html>