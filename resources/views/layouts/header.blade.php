    <!-- Main Navigation -->
    <nav class="navbar navbar-expand-lg fixed-top">
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
                <form action="{{ route('search') }}" method="GET" id="mainSearchForm" class="position-relative">
                    <span class="search-icon position-absolute">
                    <i class="fas fa-search"></i>
                </span>
                    <input type="text" class="form-control search-input main-search-input ps-5" id="mainSearchInput" name="q" placeholder="Tìm kiếm sản phẩm..." autocomplete="off">
                </form>

                <!-- AJAX Search Suggestions Dropdown -->
                <div class="main-search-suggestions" id="mainSearchSuggestions" style="display: none;">
                    <div class="suggestions-content">
                        <!-- Block 1: Search keyword section -->
                        <div class="suggestion-keyword" id="mainSuggestionKeyword" style="display: none;">
                            <div class="suggestion-item keyword-item">
                                <i class="fas fa-search me-2"></i>
                                <span class="keyword-text"></span>
                            </div>
                        </div>

                                                <!-- Block 2: Product suggestions from search -->
                        <div class="suggestions-section" id="searchProductsSection">
                            <div class="section-header">
                                <i class="fas fa-box me-2"></i>
                                <span>Sản phẩm</span>
                            </div>
                            <div class="suggestions-products" id="mainSuggestionsProducts">
                                <!-- Dynamic content will be loaded here -->
                            </div>
                            <div class="block-loading" id="searchProductsLoading" style="display: none;">
                                <div class="loading-content">
                                    <i class="fas fa-spinner fa-spin"></i>
                                    <span>Đang tải sản phẩm...</span>
                                </div>
                            </div>
                        </div>

                        <!-- Block 3: Hot Categories -->
                        <div class="suggestions-section" id="hotCategoriesSection">
                            <div class="section-header">
                                <i class="fas fa-tags me-2"></i>
                                <span>Danh mục nổi bật</span>
                            </div>
                            <div class="suggestions-grid" id="hotCategoriesGrid">
                                <!-- Dynamic content will be loaded here -->
                            </div>
                            <div class="block-loading" id="hotCategoriesLoading" style="display: none;">
                                <div class="loading-content">
                                    <i class="fas fa-spinner fa-spin"></i>
                                    <span>Đang tải danh mục...</span>
                                </div>
                            </div>
                        </div>

                        <!-- Block 4: Hot Brands -->
                        <div class="suggestions-section" id="hotBrandsSection">
                            <div class="section-header">
                                <i class="fas fa-star me-2"></i>
                                <span>Thương hiệu nổi bật</span>
                            </div>
                            <div class="suggestions-grid" id="hotBrandsGrid">
                                <!-- Dynamic content will be loaded here -->
                            </div>
                            <div class="block-loading" id="hotBrandsLoading" style="display: none;">
                                <div class="loading-content">
                                    <i class="fas fa-spinner fa-spin"></i>
                                    <span>Đang tải thương hiệu...</span>
                                </div>
                            </div>
                        </div>

                        <!-- Block 5: Hot Products -->
                        <div class="suggestions-section" id="hotProductsSection">
                            <div class="section-header">
                                <i class="fas fa-fire me-2"></i>
                                <span>Sản phẩm hot</span>
                            </div>
                            <div class="suggestions-products" id="hotProductsGrid">
                                <!-- Dynamic content will be loaded here -->
                            </div>
                            <div class="block-loading" id="hotProductsLoading" style="display: none;">
                                <div class="loading-content">
                                    <i class="fas fa-spinner fa-spin"></i>
                                    <span>Đang tải sản phẩm hot...</span>
                                </div>
                            </div>
                        </div>

                        <!-- Block 6: Hot Keywords -->
                        <div class="suggestions-section" id="hotKeywordsSection">
                            <div class="section-header">
                                <i class="fas fa-keyboard me-2"></i>
                                <span>Từ khóa hot</span>
                            </div>
                            <div class="suggestions-keywords" id="hotKeywordsGrid">
                                <!-- Dynamic content will be loaded here -->
                            </div>
                            <div class="block-loading" id="hotKeywordsLoading" style="display: none;">
                                <div class="loading-content">
                                    <i class="fas fa-spinner fa-spin"></i>
                                    <span>Đang tải từ khóa...</span>
                                </div>
                            </div>
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

                <!-- Desktop Search Overlay (Hidden for now) -->
                <div id="desktopSearchOverlay" class="desktop-search-overlay" style="display: none;">
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
                                <div class="suggest-campaign-item" onclick="window.location.href='/deals'">Deal sốc hôm nay!</div>
                                <div class="suggest-campaign-item" onclick="window.location.href='/products/featured'">Miễn phí vận chuyển toàn quốc</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Desktop menu -->
            <ul class="navbar-nav me-4 d-none d-lg-flex flex-shrink-1">
                <li class="nav-item"><a class="nav-link" href="{{ route('home') }}">Trang chủ</a></li>
                <!-- <li class="nav-item"><a class="nav-link" href="{{ route('products.index') }}">Sản phẩm</a></li> -->
                <li class="nav-item"><a class="nav-link" href="{{ route('support') }}">Hỗ trợ</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('contact') }}">Liên hệ</a></li>
            </ul>

            <!-- User actions -->
            <div class="d-none d-md-flex align-items-center flex-shrink-0">
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
{{--                            <li><a class="dropdown-item" href="#"><i class="fas fa-heart me-2"></i>Sản phẩm yêu thích</a></li>--}}
{{--                            <li><a class="dropdown-item" href="#"><i class="fas fa-map-marker-alt me-2"></i>Địa chỉ giao hàng</a></li>--}}
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
                            <i class="fas fa-bars" style="color: darkblue !important"></i>
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
                    <!-- <a href="{{ route('trending') }}">🔍 Top tìm kiếm</a> -->
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
                <!-- <li class="nav-item"><a class="nav-link" href="{{ route('products.index') }}">Sản phẩm</a></li> -->
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
                <input type="text" class="search-input" placeholder="Tìm kiếm sản phẩm, thương hiệu..." id="searchInput" value="{{ request('q') }}">
                <button class="search-clear" id="clearBtn">
                    <i class="fas fa-times"></i>
                </button>
                <button class="cancel-btn" id="cancelBtn">
                    <i class="fas fa-arrow-left"></i>
                </button>
            </div>
        </div>
        <div class="search-content">
            <!-- Search Results Section -->
            <div class="search-results-section" id="searchResultsSection" style="display: none;">
                <div class="section-title">Kết quả tìm kiếm</div>
                <div class="search-results" id="searchResults">
                    <!-- Dynamic search results will be loaded here -->
                </div>
            </div>

            <!-- Hot Keywords Section -->
            <div class="search-section" id="hotKeywordsSection">
                <div class="section-title">Từ Khóa HOT</div>
                <div class="hot-keywords">
                    @if(isset($hotKeywords))
                        @foreach($hotKeywords as $keyword)
                            <div class="keyword-tag" onclick="searchKeyword('{{ $keyword }}')">{{ $keyword }}</div>
                        @endforeach
                    @else
                        <div class="keyword-tag" onclick="searchKeyword('SuperWin')">SuperWin</div>
                        <div class="keyword-tag" onclick="searchKeyword('Bơm nước 1HP')">Bơm nước 1HP</div>
                        <div class="keyword-tag" onclick="searchKeyword('Quạt công nghiệp')">Quạt công nghiệp</div>
                        <div class="keyword-tag" onclick="searchKeyword('Bơm chìm')">Bơm chìm</div>
                        <div class="keyword-tag" onclick="searchKeyword('Bơm Inox 304')">Bơm Inox 304</div>
                        <div class="keyword-tag" onclick="searchKeyword('Bơm ABC')">Bơm ABC</div>
                        <div class="keyword-tag" onclick="searchKeyword('Quạt Thông Gió')">Quạt Thông Gió</div>
                        <div class="keyword-tag" onclick="searchKeyword('Quạt Vuông')">Quạt Vuông</div>
                        <div class="keyword-tag" onclick="searchKeyword('Bơm Thả Chìm DC')">Bơm Thả Chìm DC</div>
                    @endif
                </div>
            </div>

            <!-- Categories Section -->
            <div class="search-section" id="categoriesSection">
                <div class="section-title">Danh Mục</div>
                <div class="category-grid">
                    @if(isset($mainCategories) && $mainCategories->count() > 0)
                        @foreach($mainCategories->take(6) as $category)
                            <div class="category-item" data-href="{{ route('categories.show', $category->slug ?? $category->id) }}">
                                {{ $category->name }}
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

            <!-- Brands Section -->
            <div class="search-section" id="brandsSection">
                <div class="section-title">Thương Hiệu</div>
                <div class="brand-grid">
                    @if(isset($brands))
                        @foreach($brands as $brand)
                            <div class="brand-item" onclick="searchKeyword('{{ $brand->name }}')">{{ $brand->name }}</div>
                        @endforeach
                    @else
                        <div class="brand-item" onclick="searchKeyword('SuperWin')">SuperWin</div>
                        <div class="brand-item" onclick="searchKeyword('VinaPump')">VinaPump</div>
                        <div class="brand-item" onclick="searchKeyword('Deton')">Deton</div>
                        <div class="brand-item" onclick="searchKeyword('Quạt Inverter')">Quạt Inverter</div>
                        <div class="brand-item" onclick="searchKeyword('STHC')">STHC</div>
                    @endif
                </div>
            </div>
        </div>
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
/* Header Styling */
.navbar {
     background: #4facfe;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
    padding: 8px 0;
    transition: all 0.3s ease;
}

.navbar-brand img {
    filter: brightness(1.1) contrast(1.1);
    transition: transform 0.3s ease;
}

.navbar-brand:hover img {
    transform: scale(1.05);
}

/* Search Container Styling */
.search-container {
    max-width: 500px;
    margin: 0 auto;
}

.search-input:focus {
    box-shadow: 0 4px 25px rgba(0, 0, 0, 0.15) !important;
    transform: translateY(-2px) !important;
    background: white !important;
}

.search-icon {
    left: 15px !important;
    top: 50% !important;
    transform: translateY(-50%) !important;
    color: #6c757d !important;
    z-index: 10 !important;
}

/* Navigation Links */
.navbar-nav .nav-link {
    color: white !important;
    font-weight: 500 !important;
    padding: 8px 16px !important;
    border-radius: 20px !important;
    transition: all 0.3s ease !important;
    margin: 0 4px !important;
}

.navbar-nav .nav-link:hover {
    background: rgba(255, 255, 255, 0.2) !important;
    transform: translateY(-2px) !important;
    color: white !important;
}

/* User Actions Buttons */
.btn-outline-primary {
    border: 2px solid white !important;
    color: white !important;
    border-radius: 20px !important;
    font-weight: 500 !important;
    padding: 8px 16px !important;
    transition: all 0.3s ease !important;
}

.btn-outline-primary:hover {
    background: white !important;
    color: #4facfe !important;
    transform: translateY(-2px) !important;
    box-shadow: 0 4px 15px rgba(255, 255, 255, 0.3) !important;
}

.btn-primary {
    background: linear-gradient(135deg, #ff6b35, #f7931e) !important;
    border: none !important;
    border-radius: 20px !important;
    font-weight: 500 !important;
    padding: 8px 16px !important;
    transition: all 0.3s ease !important;
}

.btn-primary:hover {
    background: linear-gradient(135deg, #f7931e, #ff6b35) !important;
    transform: translateY(-2px) !important;
    box-shadow: 0 4px 15px rgba(255, 107, 53, 0.4) !important;
}

/* Cart Icon */
.cart-link {
    position: relative !important;
    color: white !important;
    border-color: white !important;
}

.cart-link:hover {
    color: #0d6efd !important;
    background-color: white !important;
    border-color: #0d6efd !important;
}

.cart-icon {
    font-size: 1.2rem !important;
}

.cart-count {
    font-size: 0.75rem !important;
    min-width: 20px !important;
    height: 20px !important;
    display: flex !important;
    align-items: center !important;
    justify-content: center !important;
}

/* Hamburger Menu */
.navbar-toggler {
    border: 2px solid white !important;
    border-radius: 8px !important;
    padding: 4px 8px !important;
}

.navbar-toggler:focus {
    box-shadow: none !important;
}

.navbar-toggler-icon {
    background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 30 30'%3e%3cpath stroke='rgba%28255, 255, 255, 1%29' stroke-linecap='round' stroke-miterlimit='10' stroke-width='2' d='M4 7h22M4 15h22M4 23h22'/%3e%3c/svg%3e") !important;
}

/* Bottom Navigation */
.nav-bottom {
    background: white !important;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1) !important;
    border-top: 1px solid #f0f0f0 !important;
}

.nav-bottom a {
    color: #495057 !important;
    text-decoration: none !important;
    font-weight: 500 !important;
    transition: all 0.3s ease !important;
    padding: 8px 12px !important;
    border-radius: 6px !important;
}

.nav-bottom a:hover {
    color: #4facfe !important;
    background: rgba(79, 172, 254, 0.1) !important;
}

/* Dropdown Custom */
.dropdown-custom {
    position: relative !important;
}

.dropdown-custom > a {
    display: flex !important;
    align-items: center !important;
    gap: 8px !important;
}

.dropdown-content {
    position: absolute !important;
    top: 100% !important;
    left: 0 !important;
    background: white !important;
    border-radius: 12px !important;
    box-shadow: 0 8px 30px rgba(0, 0, 0, 0.15) !important;
    padding: 15px 0 !important;
    min-width: 280px !important;
    z-index: 1000 !important;
    display: none !important;
}

.dropdown-custom:hover .dropdown-content {
    display: block !important;
    animation: fadeInUp 0.3s ease !important;
}

@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.main-category > li > a {
    padding: 10px 20px !important;
    display: flex !important;
    align-items: center !important;
    justify-content: space-between !important;
    color: #495057 !important;
    transition: all 0.3s ease !important;
}

.main-category > li > a:hover {
    background: #f8f9fa !important;
    color: #4facfe !important;
    padding-left: 25px !important;
}

/* Mobile Responsive */
@media (max-width: 991px) {
    .navbar {
        padding: 6px 0 !important;
    }

    .container {
        align-items: center !important;
    }

    .navbar-toggler {
        flex: 0 0 auto;
        margin-right: 15px;
        order: 1;
    }

    .navbar-brand {
        flex: 0 0 auto;
        margin-right: 15px !important;
        order: 2;
    }

    .search-container {
        flex: 1 1 auto;
        margin: 0 !important;
        min-width: 0;
        order: 3;
    }

    .search-input {
        padding: 10px 15px 10px 40px !important;
        font-size: 0.9rem !important;
    }

    .navbar-brand img {
        height: 50px !important;
        margin-left: 0 !important;
    }
}

@media (max-width: 576px) {
    .navbar-toggler {
        margin-right: 10px;
        padding: 4px 8px;
    }

    .navbar-brand {
        margin-right: 10px !important;
    }

    .search-input {
        padding: 8px 12px 8px 35px !important;
        font-size: 0.85rem !important;
    }

    .search-icon {
        left: 12px !important;
    }

    .navbar-brand img {
        height: 45px !important;
        margin-left: 0 !important;
    }
}

/* Search Suggestions Styling */
.main-search-suggestions {
    position: absolute !important;
    top: 100% !important;
    left: 0 !important;
    right: 0 !important;
    background: white !important;
    border-radius: 15px !important;
    box-shadow: 0 8px 30px rgba(0, 0, 0, 0.15) !important;
    z-index: 1050 !important;
    margin-top: 5px !important;
    max-height: 500px !important;
    overflow-y: auto !important;
    border: 1px solid rgba(0, 0, 0, 0.05) !important;
}

.suggestions-content {
    padding: 15px !important;
}

.suggestion-keyword {
    padding: 12px 15px !important;
    border-bottom: 1px solid #f0f0f0 !important;
    margin-bottom: 10px !important;
}

.keyword-item {
    display: flex !important;
    align-items: center !important;
    color: #495057 !important;
    font-weight: 500 !important;
    cursor: pointer !important;
    transition: all 0.3s ease !important;
    padding: 8px 0 !important;
}

.keyword-item:hover {
    color: #4facfe !important;
}

.suggestions-section {
    margin-bottom: 20px !important;
}

.section-header {
    display: flex !important;
    align-items: center !important;
    font-weight: 600 !important;
    color: #495057 !important;
    margin-bottom: 10px !important;
    font-size: 0.9rem !important;
    text-transform: uppercase !important;
    letter-spacing: 0.5px !important;
}

.suggestion-item {
    display: flex !important;
    align-items: center !important;
    padding: 10px 12px !important;
    border-radius: 8px !important;
    cursor: pointer !important;
    transition: all 0.3s ease !important;
    margin-bottom: 8px !important;
}

.suggestion-item:hover {
    background: #f8f9fa !important;
    transform: translateX(5px) !important;
}

.suggestion-item.active {
    background: #e3f2fd !important;
    border-left: 3px solid #4facfe !important;
}

.suggestion-item img {
    width: 40px !important;
    height: 40px !important;
    border-radius: 6px !important;
    margin-right: 12px !important;
    object-fit: cover !important;
}

.product-info,
.item-info,
.keyword-info {
    flex: 1 !important;
}

.product-name,
.item-name,
.keyword-text {
    font-weight: 500 !important;
    color: #495057 !important;
    font-size: 0.9rem !important;
    margin-bottom: 2px !important;
}

.product-details {
    display: flex !important;
    align-items: center !important;
    gap: 8px !important;
    font-size: 0.8rem !important;
}

.product-brand,
.item-type,
.keyword-type {
    color: #6c757d !important;
    font-size: 0.75rem !important;
}

.product-price,
.product-price-sale {
    color: #28a745 !important;
    font-weight: 600 !important;
}

.product-price-old {
    color: #6c757d !important;
    text-decoration: line-through !important;
    font-size: 0.75rem !important;
}

.hot-badge {
    background: linear-gradient(135deg, #ff6b35, #f7931e) !important;
    color: white !important;
    padding: 2px 6px !important;
    border-radius: 10px !important;
    font-size: 0.7rem !important;
    font-weight: 600 !important;
}

.keyword-icon {
    width: 40px !important;
    height: 40px !important;
    background: #f8f9fa !important;
    border-radius: 6px !important;
    display: flex !important;
    align-items: center !important;
    justify-content: center !important;
    margin-right: 12px !important;
    color: #6c757d !important;
}

.suggestions-grid {
    display: grid !important;
    grid-template-columns: 1fr 1fr !important;
    gap: 8px !important;
}

.suggestions-products {
    display: flex !important;
    flex-direction: column !important;
    gap: 8px !important;
}

.suggestions-keywords {
    display: flex !important;
    flex-wrap: wrap !important;
    gap: 8px !important;
}

.block-loading {
    text-align: center !important;
    padding: 20px !important;
    color: #6c757d !important;
}

.loading-content {
    display: flex !important;
    align-items: center !important;
    justify-content: center !important;
    gap: 8px !important;
}

.suggestion-loading,
.suggestion-no-results {
    text-align: center !important;
    padding: 20px !important;
    color: #6c757d !important;
}

/* Mobile Search Suggestions */
@media (max-width: 768px) {
    .main-search-suggestions {
        border-radius: 10px !important;
        margin-top: 5px !important;
        max-height: 400px !important;
    }

    .suggestions-content {
        padding: 10px !important;
    }

    .suggestion-item img {
        width: 35px !important;
        height: 35px !important;
    }

    .suggestions-grid {
        grid-template-columns: 1fr !important;
    }

    .product-name,
    .item-name,
    .keyword-text {
        font-size: 0.85rem !important;
    }
}

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
<script src="{{ asset('js/trang_chu/search-and-menu.js') }}"></script>
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
        // Use new hot suggestions API
        fetch(`/api/search/hot-suggestions?q=${encodeURIComponent(query)}`, {
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
                displayHotSuggestions(data);
            }
        })
        .catch(error => {
            console.error('Hot search suggestions error:', error);
            hideMainSuggestions();
        });
    }

    function displayHotSuggestions(data) {
        hideMainLoading();
        hideAllBlockLoading();

        // Clear previous suggestions
        document.getElementById('mainSuggestionsProducts').innerHTML = '';
        document.getElementById('hotCategoriesGrid').innerHTML = '';
        document.getElementById('hotBrandsGrid').innerHTML = '';
        document.getElementById('hotProductsGrid').innerHTML = '';
        document.getElementById('hotKeywordsGrid').innerHTML = '';

        // Block 1: Show keyword suggestion
        if (data.query && data.query.length >= 2) {
            mainSuggestionKeyword.querySelector('.keyword-text').textContent = `Tìm kiếm "${data.query}"`;
            mainSuggestionKeyword.style.display = 'block';

            // Add click handler for keyword
            const keywordItem = mainSuggestionKeyword.querySelector('.keyword-item');
            keywordItem.onclick = function(e) {
                e.preventDefault();
                e.stopPropagation();
                window.location.href = `/search?q=${encodeURIComponent(data.query)}`;
            };
        } else {
            mainSuggestionKeyword.style.display = 'none';
        }

        let hasAnyResults = false;

        // Block 2: Show product suggestions from search
        hideBlockLoading('searchProductsLoading');
        if (data.suggestions?.products && data.suggestions.products.length > 0) {
            data.suggestions.products.forEach(product => {
                const productElement = createMainProductSuggestion(product);
                document.getElementById('mainSuggestionsProducts').appendChild(productElement);
            });
            document.getElementById('searchProductsSection').style.display = 'block';
            hasAnyResults = true;
        } else {
            document.getElementById('searchProductsSection').style.display = 'none';
        }

        // Block 3: Show hot categories
        hideBlockLoading('hotCategoriesLoading');
        if (data.suggestions?.hot_categories && data.suggestions.hot_categories.length > 0) {
            data.suggestions.hot_categories.forEach(category => {
                const categoryElement = createHotCategoryItem(category);
                document.getElementById('hotCategoriesGrid').appendChild(categoryElement);
            });
            document.getElementById('hotCategoriesSection').style.display = 'block';
            hasAnyResults = true;
        } else {
            document.getElementById('hotCategoriesSection').style.display = 'none';
        }

        // Block 4: Show hot brands
        hideBlockLoading('hotBrandsLoading');
        if (data.suggestions?.hot_brands && data.suggestions.hot_brands.length > 0) {
            data.suggestions.hot_brands.forEach(brand => {
                const brandElement = createHotBrandItem(brand);
                document.getElementById('hotBrandsGrid').appendChild(brandElement);
            });
            document.getElementById('hotBrandsSection').style.display = 'block';
            hasAnyResults = true;
        } else {
            document.getElementById('hotBrandsSection').style.display = 'none';
        }

        // Block 5: Show hot products
        hideBlockLoading('hotProductsLoading');
        if (data.suggestions?.hot_products && data.suggestions.hot_products.length > 0) {
            data.suggestions.hot_products.forEach(product => {
                const productElement = createHotProductItem(product);
                document.getElementById('hotProductsGrid').appendChild(productElement);
            });
            document.getElementById('hotProductsSection').style.display = 'block';
            hasAnyResults = true;
        } else {
            document.getElementById('hotProductsSection').style.display = 'none';
        }

        // Block 6: Show hot keywords
        hideBlockLoading('hotKeywordsLoading');
        if (data.suggestions?.hot_keywords && data.suggestions.hot_keywords.length > 0) {
            data.suggestions.hot_keywords.forEach(keyword => {
                const keywordElement = createHotKeywordItem(keyword);
                document.getElementById('hotKeywordsGrid').appendChild(keywordElement);
            });
            document.getElementById('hotKeywordsSection').style.display = 'block';
            hasAnyResults = true;
        } else {
            document.getElementById('hotKeywordsSection').style.display = 'none';
        }

        // Show/hide suggestions dropdown
        if (hasAnyResults || (data.query && data.query.length >= 2)) {
            mainSuggestionNoResults.style.display = 'none';
            mainSearchSuggestions.style.display = 'block';
        } else {
            mainSuggestionNoResults.style.display = 'block';
            mainSearchSuggestions.style.display = 'block';
        }
    }

    function createMainProductSuggestion(product) {
        const div = document.createElement('div');
        div.className = 'suggestion-item product-suggestion';

        const priceDisplay = product.sale_price && product.sale_price < product.price
            ? `<span class="product-price-sale">${formatPrice(product.sale_price)}</span> <span class="product-price-old">${formatPrice(product.price)}</span>`
            : `<span class="product-price">${formatPrice(product.price)}</span>`;

        div.innerHTML = `
            <img src="${product.image}" alt="${product.name}" onerror="this.src='/image/sp1.png'">
            <div class="product-info">
                <div class="product-name">${product.name}</div>
                <div class="product-details">
                    <span class="product-brand">${product.brand || ''}</span>
                    ${priceDisplay}
                </div>
            </div>
        `;

        div.onclick = function(e) {
            e.preventDefault();
            e.stopPropagation();
            window.location.href = product.url;
        };

        return div;
    }

    function createHotCategoryItem(category) {
        const div = document.createElement('div');
        div.className = 'suggestion-item hot-category-item';
        div.innerHTML = `
            <img src="${category.image || '/image/sp1.png'}" alt="${category.name}" onerror="this.src='/image/sp1.png'">
            <div class="item-info">
                <div class="item-name">${category.name}</div>
                <div class="item-type">Danh mục</div>
            </div>
        `;

        div.onclick = function(e) {
            e.preventDefault();
            e.stopPropagation();
            window.location.href = category.url;
        };

        return div;
    }

    function createHotBrandItem(brand) {
        const div = document.createElement('div');
        div.className = 'suggestion-item hot-brand-item';
        div.innerHTML = `
            <img src="${brand.image || '/image/sp1.png'}" alt="${brand.name}" onerror="this.src='/image/sp1.png'">
            <div class="item-info">
                <div class="item-name">${brand.name}</div>
                <div class="item-type">Thương hiệu</div>
            </div>
        `;

        div.onclick = function(e) {
            e.preventDefault();
            e.stopPropagation();
            window.location.href = brand.url;
        };

        return div;
    }

    function createHotProductItem(product) {
        const div = document.createElement('div');
        div.className = 'suggestion-item hot-product-item';

        const priceDisplay = product.sale_price && product.sale_price < product.price
            ? `<span class="product-price-sale">${formatPrice(product.sale_price)}</span> <span class="product-price-old">${formatPrice(product.price)}</span>`
            : `<span class="product-price">${formatPrice(product.price)}</span>`;

        div.innerHTML = `
            <img src="${product.image || '/image/sp1.png'}" alt="${product.name}" onerror="this.src='/image/sp1.png'">
            <div class="product-info">
                <div class="product-name">${product.name}</div>
                <div class="product-details">
                    <span class="hot-badge">🔥 HOT</span>
                    ${priceDisplay}
                </div>
            </div>
        `;

        div.onclick = function(e) {
            e.preventDefault();
            e.stopPropagation();
            window.location.href = product.url;
        };

        return div;
    }

    function createHotKeywordItem(keyword) {
        const div = document.createElement('div');
        div.className = 'suggestion-item hot-keyword-item';
        div.innerHTML = `
            <div class="keyword-icon">
                <i class="fas fa-search"></i>
            </div>
            <div class="keyword-info">
                <div class="keyword-text">${keyword.title || keyword.keyword}</div>
                <div class="keyword-type">Từ khóa hot</div>
            </div>
        `;

        div.onclick = function(e) {
            e.preventDefault();
            e.stopPropagation();
            window.location.href = keyword.url;
        };

        return div;
    }

    function formatPrice(price) {
        return new Intl.NumberFormat('vi-VN').format(price) + 'đ';
    }

    function showMainLoading() {
        mainSuggestionLoading.style.display = 'block';
        mainSuggestionNoResults.style.display = 'none';
        mainSuggestionKeyword.style.display = 'none';

        // Clear content and show individual block loadings
        document.getElementById('mainSuggestionsProducts').innerHTML = '';
        document.getElementById('hotCategoriesGrid').innerHTML = '';
        document.getElementById('hotBrandsGrid').innerHTML = '';
        document.getElementById('hotProductsGrid').innerHTML = '';
        document.getElementById('hotKeywordsGrid').innerHTML = '';

        // Show individual block loadings with a slight delay for better UX
        setTimeout(() => showBlockLoading('searchProductsLoading'), 100);
        setTimeout(() => showBlockLoading('hotCategoriesLoading'), 200);
        setTimeout(() => showBlockLoading('hotBrandsLoading'), 300);
        setTimeout(() => showBlockLoading('hotProductsLoading'), 400);
        setTimeout(() => showBlockLoading('hotKeywordsLoading'), 500);

        // Show all sections
        document.getElementById('searchProductsSection').style.display = 'block';
        document.getElementById('hotCategoriesSection').style.display = 'block';
        document.getElementById('hotBrandsSection').style.display = 'block';
        document.getElementById('hotProductsSection').style.display = 'block';
        document.getElementById('hotKeywordsSection').style.display = 'block';

        mainSearchSuggestions.style.display = 'block';
    }

    function showBlockLoading(loadingId) {
        const loadingElement = document.getElementById(loadingId);
        if (loadingElement) {
            loadingElement.style.display = 'block';
        }
    }

    function hideBlockLoading(loadingId) {
        const loadingElement = document.getElementById(loadingId);
        if (loadingElement) {
            loadingElement.style.display = 'none';
        }
    }

    function hideAllBlockLoading() {
        hideBlockLoading('searchProductsLoading');
        hideBlockLoading('hotCategoriesLoading');
        hideBlockLoading('hotBrandsLoading');
        hideBlockLoading('hotProductsLoading');
        hideBlockLoading('hotKeywordsLoading');
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
