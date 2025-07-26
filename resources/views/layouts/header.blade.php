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
    <nav class="navbar navbar-expand-lg">
        <div class="container d-flex align-items-center justify-content-between flex-nowrap">
            <!-- Group hamburger + logo -->
            <div class="d-flex align-items-center flex-row flex-nowrap">
                <button class="navbar-toggler d-lg-none order-1 order-lg-0" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasMenu" aria-controls="offcanvasMenu" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <a class="navbar-brand flex-shrink-0 order-2 order-lg-1" href="{{ route('home') }}">
                    <img src="{{ asset('image/logo.png') }}" alt="SuperWin Logo" class="logo-responsive" style="height: 65px; margin-left:20px;">
                </a>
            </div>
            
            <!-- Search container -->
            <div class="search-container flex-grow-1 mx-1 ms-3 ps-0 position-relative" style="min-width:90px;">
                <span class="search-icon">
                    <i class="fas fa-search"></i>
                </span>
                <form action="{{ route('search') }}" method="GET">
                    <input type="text" name="q" class="form-control search-input main-search-input" id="mainSearchInput" placeholder="Tìm kiếm" value="{{ request('q') }}">
                </form>

                <!-- Desktop Search Overlay -->
                <div id="desktopSearchOverlay" class="desktop-search-overlay">
                    <div class="desktop-search-box">
                        <div class="desktop-search-suggestions">
                            <div class="suggest-title">Từ khóa HOT</div>
                            <div class="suggest-tags">
                                @if(isset($hotKeywords))
                                    @foreach($hotKeywords as $keyword)
                                        <span class="suggest-tag">{{ $keyword }}</span>
                                    @endforeach
                                @else
                                    <span class="suggest-tag">Máy bơm nước</span>
                                    <span class="suggest-tag">Máy bơm chìm</span>
                                    <span class="suggest-tag">Quạt công nghiệp</span>
                                    <span class="suggest-tag">Máy bơm</span>
                                    <span class="suggest-tag">SuperWin</span>
                                @endif
                            </div>
                            <div class="suggest-title mt-3">Gợi ý nổi bật</div>
                            <div class="suggest-campaign">
                                <div class="suggest-campaign-item">Deal sốc hôm nay!</div>
                                <div class="suggest-campaign-item">Miễn phí vận chuyển toàn quốc</div>
                            </div>
                            <div class="suggest-title mt-3">Thương hiệu</div>
                            <div class="suggest-brands">
                                <div class="brand-logo" style="background: #f8f9fa; display: flex; align-items: center; justify-content: center; font-size: 0.7rem; color: #666;">
                                    <img src="{{ asset('image/logo.png') }}" alt="Logo SuperWin" style="height: 28px;">
                                </div>
                                <div class="brand-logo" style="background: #f8f9fa; display: flex; align-items: center; justify-content: center; font-size: 0.7rem; color: #666;">
                                    <img src="{{ asset('image/logothc.png') }}" alt="Logo SP1" style="height: 28px;">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Desktop menu -->
            <ul class="navbar-nav me-4 d-none d-lg-flex flex-shrink-1">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">Trang chủ</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('products.*') ? 'active' : '' }}" href="{{ route('products.index') }}">Sản phẩm</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('support') ? 'active' : '' }}" href="{{ route('support') }}">Hỗ trợ</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('contact') ? 'active' : '' }}" href="{{ route('contact') }}">Liên hệ</a>
                </li>
            </ul>
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

    <!-- Offcanvas menu for mobile/tablet -->
    <div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasMenu" aria-labelledby="offcanvasMenuLabel">
        <div class="offcanvas-header">
            <a href="{{ route('home') }}">
                <h5 class="offcanvas-title w-100 text-center" id="offcanvasMenuLabel" style="margin:0; padding:0;">
                    <img src="{{ asset('image/logo.png') }}" alt="SuperWin Logo" style="height: 50px; vertical-align: middle; display: inline-block; margin: 0 auto;">
                </h5>
            </a>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body p-0">
            <!-- Main Menu -->

            <!-- Danh Mục Sản Phẩm Section -->
            <div class="border-bottom">
                <button class="mobile-section-header" type="button" data-bs-toggle="collapse" data-bs-target="#productCategories" aria-expanded="false" aria-controls="productCategories">
                    <span>Danh Mục Sản Phẩm</span>
                    <i class="fas fa-chevron-down"></i>
                </button>
                <div class="collapse" id="productCategories">
                    <div class="mobile-section-content">
                        <!-- Featured Products -->
                        <div class="mobile-category-item">
                            <a href="{{ route('products.featured') }}" class="mobile-category-toggle text-decoration-none">
                                <span>Sản phẩm nổi bật</span>
                            </a>
                        </div>

                        <!-- Water Pumps -->
                        <div class="mobile-category-item">
                            <button class="mobile-category-toggle" type="button" data-bs-toggle="collapse" data-bs-target="#waterPumps" aria-expanded="false" aria-controls="waterPumps">
                                <span>Máy Bơm Nước</span>
                                <i class="fas fa-chevron-down"></i>
                            </button>
                            <div class="collapse" id="waterPumps">
                                <div class="mobile-sub-category">
                                    <a href="{{ route('products.brand', 'super-win') }}">Máy bơm nước Super Win</a>
                                    <a href="{{ route('products.brand', 'vina-pump') }}">Máy bơm nước Vina Pump</a>
                                    <a href="{{ route('products.brand', 'abc') }}">Máy bơm nước ABC</a>
                                    <a href="{{ route('products.category', 'may-bom-nuoc-bien') }}">Máy bơm nước biển</a>
                                    <a href="{{ route('products.category', 'may-bom-ho-boi') }}">Máy bơm hồ bơi</a>
                                    <a href="{{ route('products.category', 'may-bom-nhap-khau') }}">Máy bơm nhập khẩu</a>
                                </div>
                            </div>
                        </div>

                        <!-- Industrial Fans -->
                        <div class="mobile-category-item">
                            <button class="mobile-category-toggle" type="button" data-bs-toggle="collapse" data-bs-target="#industrialFans" aria-expanded="false" aria-controls="industrialFans">
                                <span>Quạt công nghiệp</span>
                                <i class="fas fa-chevron-down"></i>
                            </button>
                            <div class="collapse" id="industrialFans">
                                <div class="mobile-sub-category">
                                    <a href="{{ route('products.brand', 'super-win-fan') }}">Quạt Super Win</a>
                                    <a href="{{ route('products.brand', 'deton') }}">Quạt Deton</a>
                                    <a href="{{ route('products.brand', 'sthc') }}">Quạt STHC</a>
                                    <a href="{{ route('products.brand', 'inverter') }}">Quạt Inverter</a>
                                </div>
                            </div>
                        </div>

                        <!-- Ventilation Fans -->
                        <div class="mobile-category-item">
                            <button class="mobile-category-toggle" type="button" data-bs-toggle="collapse" data-bs-target="#ventilationFans" aria-expanded="false" aria-controls="ventilationFans">
                                <span>Quạt thông gió</span>
                                <i class="fas fa-chevron-down"></i>
                            </button>
                            <div class="collapse" id="ventilationFans">
                                <div class="mobile-sub-category">
                                    <a href="{{ route('products.category', 'quat-thong-gio-vuong-super-win') }}">Quạt thông gió vuông Super Win</a>
                                    <a href="{{ route('products.category', 'quat-thong-gio-vuong-deton') }}">Quạt thông gió vuông Deton</a>
                                    <a href="{{ route('products.category', 'quat-thong-gio-tron') }}">Quạt thông gió tròn</a>
                                </div>
                            </div>
                        </div>

                        <!-- Special Fans -->
                        <div class="mobile-category-item">
                            <button class="mobile-category-toggle" type="button" data-bs-toggle="collapse" data-bs-target="#specialFans" aria-expanded="false" aria-controls="specialFans">
                                <span>Quạt đặc biệt</span>
                                <i class="fas fa-chevron-down"></i>
                            </button>
                            <div class="collapse" id="specialFans">
                                <div class="mobile-sub-category">
                                    <a href="{{ route('products.category', 'quat-huong-truc-noi-ong') }}">Quạt hướng trục nổi ống</a>
                                    <a href="{{ route('products.category', 'quat-san-cong-nghiep') }}">Quạt sàn công nghiệp</a>
                                    <a href="{{ route('products.category', 'quat-tran-cong-nghiep') }}">Quạt trần công nghiệp</a>
                                    <a href="{{ route('products.category', 'quat-chong-chay-no') }}">Quạt chống cháy nổ</a>
                                    <a href="{{ route('products.category', 'quat-vuong') }}">Quạt vuông (trực tiếp/gián tiếp)</a>
                                    <a href="{{ route('products.category', 'quat-composite') }}">Quạt Composite</a>
                                </div>
                            </div>
                        </div>

                        <!-- Cooling Panels -->
                        <div class="mobile-category-item">
                            <a href="{{ route('categories.show', 'tam-lam-mat') }}" class="mobile-category-toggle text-decoration-none">
                                <span>Tấm làm mát</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Links Section -->
            <div class="border-bottom">
                <button class="mobile-section-header" type="button" data-bs-toggle="collapse" data-bs-target="#quickLinks" aria-expanded="false" aria-controls="quickLinks">
                    <span>Liên Kết Nhanh</span>
                    <i class="fas fa-chevron-down"></i>
                </button>
                <div class="collapse" id="quickLinks">
                    <div class="mobile-section-content">
                        <div class="mobile-category-item">
                            <a href="{{ route('deals') }}" class="mobile-category-toggle text-decoration-none">
                                <span>Hot Deals</span>
                            </a>
                        </div>
                        <div class="mobile-category-item">
                            <a href="{{ route('brands') }}" class="mobile-category-toggle text-decoration-none">
                                <span>Thương hiệu</span>
                            </a>
                        </div>
                        <div class="mobile-category-item">
                            <a href="{{ route('bestsellers') }}" class="mobile-category-toggle text-decoration-none">
                                <span>Bán chạy</span>
                            </a>
                        </div>
                        <div class="mobile-category-item">
                            <a href="{{ route('trending') }}" class="mobile-category-toggle text-decoration-none">
                                <span>Top tìm kiếm</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Information Section -->
            <div class="border-bottom">
                <button class="mobile-section-header" type="button" data-bs-toggle="collapse" data-bs-target="#information" aria-expanded="false" aria-controls="information">
                    <span>Thông Tin</span>
                    <i class="fas fa-chevron-down"></i>
                </button>
                <div class="collapse" id="information">
                    <div class="mobile-section-content">
                        <div class="mobile-category-item">
                            <a href="{{ route('news') }}" class="mobile-category-toggle text-decoration-none">
                                <span>Tin tức - Sự kiện</span>
                            </a>
                        </div>
                        <div class="mobile-category-item">
                            <a href="{{ route('blog') }}" class="mobile-category-toggle text-decoration-none">
                                <span>Bài viết</span>
                            </a>
                        </div>
                        <div class="mobile-category-item">
                            <a href="{{ route('warranty') }}" class="mobile-category-toggle text-decoration-none">
                                <span>Chính sách bảo hành</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
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