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
            <form action="{{ route('search') }}" method="GET" id="searchForm">
                <div class="input-group">
                    <input type="text" class="form-control search-input" placeholder="Tìm kiếm sản phẩm..." id="searchInput" name="q" autocomplete="off">
                    <button class="btn btn-primary search-btn" type="submit" id="searchBtn">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </form>
            
            <!-- Search Suggestions Dropdown -->
            <div class="search-suggestions" id="searchSuggestions" style="display: none;">
                <div class="suggestions-content">
                    <!-- Search keyword section -->
                    <div class="suggestion-keyword" id="suggestionKeyword" style="display: none;">
                        <div class="suggestion-item keyword-item">
                            <i class="fas fa-search me-2"></i>
                            <span class="keyword-text"></span>
                        </div>
                    </div>
                    
                    <!-- Products suggestions -->
                    <div class="suggestions-products" id="suggestionsProducts">
                        <!-- Dynamic content will be loaded here -->
                    </div>
                    
                    <!-- Loading state -->
                    <div class="suggestion-loading" id="suggestionLoading" style="display: none;">
                        <div class="text-center py-3">
                            <i class="fas fa-spinner fa-spin me-2"></i>
                            <span>Đang tìm kiếm...</span>
                        </div>
                    </div>
                    
                    <!-- No results -->
                    <div class="suggestion-no-results" id="suggestionNoResults" style="display: none;">
                        <div class="text-center py-3 text-muted">
                            <i class="fas fa-search me-2"></i>
                            <span>Không tìm thấy sản phẩm nào</span>
                        </div>
                    </div>
                </div>
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
                <a class="nav-link" href="{{ route('categories.index') }}">Danh mục</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('brands.index') }}">Thương hiệu</a>
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
                            <div class="category-item">{{ $category->name }}</div>
                        @endforeach
                    @else
                        <div class="category-item">Máy bơm nước</div>
                        <div class="category-item">Quạt công nghiệp</div>
                        <div class="category-item">Phụ kiện</div>
                        <div class="category-item">Linh kiện</div>
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
    </div>
    <div class="search-blur-bg"></div>
</div>

<style>
/* Search Suggestions Styles */
.search-suggestions {
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

.suggestions-content {
    padding: 4px 0;
}

.suggestion-item {
    padding: 8px 12px;
    cursor: pointer;
    transition: all 0.2s ease;
    display: flex;
    align-items: center;
    border-radius: 8px;
    margin: 2px 8px;
}

.suggestion-item:hover {
    background-color: #f8f9fa;
    transform: translateX(4px);
}

.keyword-item {
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

.keyword-item::before {
    content: '🔍';
    margin-right: 8px;
    font-size: 16px;
}

.keyword-item:hover {
    background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 100%);
    transform: translateY(-2px) scale(1.02);
    box-shadow: 0 12px 35px rgba(79, 70, 229, 0.4);
}

.product-suggestion {
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

.product-suggestion::before {
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

.product-suggestion:hover {
    background: linear-gradient(135deg, #ffffff 0%, #fef3c7 100%);
    transform: translateY(-4px);
    box-shadow: 0 12px 40px rgba(0, 0, 0, 0.15);
    border-color: rgba(245, 158, 11, 0.3);
}

.product-suggestion:hover::before {
    transform: scaleY(1);
}

.product-suggestion img {
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

.product-suggestion:hover img {
    transform: scale(1.05);
    box-shadow: 0 12px 35px rgba(0, 0, 0, 0.2);
}

.product-info {
    flex: 1;
    min-width: 0;
    overflow: hidden;
    display: flex;
    flex-direction: column;
    gap: 6px;
}

.product-name {
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

.product-details {
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 12px;
}

.product-brand {
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

.product-price {
    font-size: 16px;
    font-weight: 800;
    background: linear-gradient(135deg, #f59e0b, #ef4444);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    white-space: nowrap;
    text-shadow: 0 2px 4px rgba(245, 158, 11, 0.3);
}

.suggestion-loading,
.suggestion-no-results {
    color: #666;
    font-size: 13px;
    padding: 16px;
    text-align: center;
}

/* Responsive */
@media (max-width: 768px) {
    .search-suggestions {
        left: -15px;
        right: -15px;
        border-radius: 8px;
    }
    
    .search-suggestions {
        margin: 4px -8px;
        border-radius: 16px;
        max-height: 280px;
    }
    
    .product-suggestion {
        padding: 12px;
        margin: 4px 8px;
        gap: 10px;
    }
    
    .product-suggestion img {
        width: 40px;
        height: 40px;
        max-width: 40px;
        max-height: 40px;
        border-radius: 10px;
    }
    
    .product-name {
        font-size: 13px;
        -webkit-line-clamp: 1;
    }
    
    .product-price {
        font-size: 14px;
    }
    
    .product-brand {
        font-size: 9px;
        padding: 2px 8px;
    }
    
    .keyword-item {
        font-size: 13px;
        padding: 10px 16px;
        margin: 6px 8px;
    }
    
    .product-details {
        font-size: 10px;
    }
    
    .product-brand {
        font-size: 9px;
        padding: 1px 3px;
    }
    
    .product-price {
        font-size: 11px;
    }
    
    .keyword-item {
        font-size: 12px;
        padding: 6px 10px;
        padding-left: 10px;
        border-left-width: 2px;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('searchInput');
    const searchSuggestions = document.getElementById('searchSuggestions');
    const suggestionKeyword = document.getElementById('suggestionKeyword');
    const suggestionsProducts = document.getElementById('suggestionsProducts');
    const suggestionLoading = document.getElementById('suggestionLoading');
    const suggestionNoResults = document.getElementById('suggestionNoResults');
    const searchForm = document.getElementById('searchForm');
    
    let searchTimeout;
    let currentQuery = '';
    
    // Search input event listener
    searchInput.addEventListener('input', function() {
        const query = this.value.trim();
        currentQuery = query;
        
        // Clear previous timeout
        clearTimeout(searchTimeout);
        
        if (query.length < 2) {
            hideSuggestions();
            return;
        }
        
        // Show loading state
        showLoading();
        
        // Debounce search requests
        searchTimeout = setTimeout(() => {
            fetchSuggestions(query);
        }, 300);
    });
    
    // Hide suggestions when clicking outside
    document.addEventListener('click', function(e) {
        if (!e.target.closest('.search-container')) {
            hideSuggestions();
        }
    });
    
    // Show suggestions when focusing on input (if there's content)
    searchInput.addEventListener('focus', function() {
        if (this.value.trim().length >= 2) {
            searchSuggestions.style.display = 'block';
        }
    });
    
    // Handle keyboard navigation
    searchInput.addEventListener('keydown', function(e) {
        const suggestions = searchSuggestions.querySelectorAll('.suggestion-item');
        const activeItem = searchSuggestions.querySelector('.suggestion-item.active');
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
                hideSuggestions();
                break;
        }
    });
    
    function fetchSuggestions(query) {
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
            if (query === currentQuery) {
                displaySuggestions(data);
            }
        })
        .catch(error => {
            console.error('Search suggestions error:', error);
            hideSuggestions();
        });
    }
    
    function displaySuggestions(data) {
        hideLoading();
        
        // Clear previous suggestions
        suggestionsProducts.innerHTML = '';
        
        // Show keyword suggestion
        if (data.keyword && data.keyword.length >= 2) {
            suggestionKeyword.querySelector('.keyword-text').textContent = `Tìm kiếm "${data.keyword}"`;
            suggestionKeyword.style.display = 'block';
            
            // Add click handler for keyword
            const keywordItem = suggestionKeyword.querySelector('.keyword-item');
            keywordItem.onclick = function(e) {
                e.preventDefault();
                e.stopPropagation();
                window.location.href = data.search_url;
            };
        } else {
            suggestionKeyword.style.display = 'none';
        }
        
        // Show product suggestions
        if (data.products && data.products.length > 0) {
            data.products.forEach(product => {
                const productElement = createProductSuggestion(product);
                suggestionsProducts.appendChild(productElement);
            });
            
            suggestionNoResults.style.display = 'none';
            searchSuggestions.style.display = 'block';
        } else if (data.keyword && data.keyword.length >= 2) {
            // Show no results if we have a keyword but no products
            suggestionNoResults.style.display = 'block';
            searchSuggestions.style.display = 'block';
        } else {
            hideSuggestions();
        }
    }
    
    function createProductSuggestion(product) {
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
        
        div.onclick = function(e) {
            e.preventDefault();
            e.stopPropagation();
            window.location.href = product.url;
        };
        
        return div;
    }
    
    function showLoading() {
        suggestionLoading.style.display = 'block';
        suggestionNoResults.style.display = 'none';
        suggestionKeyword.style.display = 'none';
        suggestionsProducts.innerHTML = '';
        searchSuggestions.style.display = 'block';
    }
    
    function hideLoading() {
        suggestionLoading.style.display = 'none';
    }
    
    function hideSuggestions() {
        searchSuggestions.style.display = 'none';
        // Remove active states
        const activeItems = searchSuggestions.querySelectorAll('.suggestion-item.active');
        activeItems.forEach(item => item.classList.remove('active'));
    }
});
</script>