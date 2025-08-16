
document.addEventListener('DOMContentLoaded', function () {
    // === Khai báo với kiểm tra an toàn ===
    const searchOverlay = document.getElementById('searchOverlay');
    const searchInput = document.getElementById('searchInput');
    const mainSearchInput = document.querySelector('.main-search-input');
    const clearBtn = document.getElementById('clearBtn');
    const cancelBtn = document.getElementById('cancelBtn');
    const desktopOverlay = document.getElementById('desktopSearchOverlay');
    const searchResultsSection = document.getElementById('searchResultsSection');
    const hotKeywordsSection = document.getElementById('hotKeywordsSection');
    const categoriesSection = document.getElementById('categoriesSection');
    const brandsSection = document.getElementById('brandsSection');

    // Kiểm tra elements tồn tại
    if (!searchOverlay || !searchInput || !mainSearchInput || !clearBtn || !cancelBtn) {
        console.warn('Some required elements are missing');
        return;
    }

    // === Helper function ===
    function isMobile() {
        return window.innerWidth < 992;
    }

    // === Global search function ===
    window.searchKeyword = function(keyword) {
        if (mainSearchInput) {
            mainSearchInput.value = keyword;
        }
        if (searchInput) {
            searchInput.value = keyword;
        }
        // Submit search
        window.location.href = `/search?q=${encodeURIComponent(keyword)}`;
    };

    // === Mở overlay ===
    function openSearchOverlay() {
        searchInput.value = mainSearchInput.value;
        clearBtn.style.display = searchInput.value.trim() ? 'block' : 'none';
        searchOverlay.classList.add('active');
        document.body.classList.add('search-overlay-active');
        document.body.style.overflow = 'hidden';
        setTimeout(() => {
            searchInput.focus();
        }, 300);
    }

    // === Đóng overlay ===
    function closeSearchOverlay() {
        searchOverlay.classList.remove('active');
        document.body.classList.remove('search-overlay-active');
        document.body.style.overflow = '';
        clearBtn.style.display = searchInput.value.trim() ? 'block' : 'none';

        // Reset search results
        if (searchResultsSection) {
            searchResultsSection.style.display = 'none';
        }
        if (hotKeywordsSection) {
            hotKeywordsSection.style.display = 'block';
        }
        if (categoriesSection) {
            categoriesSection.style.display = 'block';
        }
        if (brandsSection) {
            brandsSection.style.display = 'block';
        }
    }

    // === Đóng desktop overlay ===
    function closeDesktopOverlay() {
        if (desktopOverlay) {
            desktopOverlay.style.display = 'none';
        }
    }

    // === Search functionality ===
    let searchTimeout;
    searchInput.addEventListener('input', function() {
        const query = this.value.trim();

        // Sync with main search input
        if (mainSearchInput) {
            mainSearchInput.value = query;
        }

        // Show/hide clear button
        clearBtn.style.display = query ? 'block' : 'none';

        // Clear previous timeout
        clearTimeout(searchTimeout);

        if (query.length < 2) {
            // Show default sections
            if (searchResultsSection) searchResultsSection.style.display = 'none';
            if (hotKeywordsSection) hotKeywordsSection.style.display = 'block';
            if (categoriesSection) categoriesSection.style.display = 'block';
            if (brandsSection) brandsSection.style.display = 'block';
            return;
        }

        // Search after 300ms delay
        searchTimeout = setTimeout(() => {
            performSearch(query);
        }, 300);
    });

    // === Perform search ===
    function performSearch(query) {
        // Show loading state
        if (searchResultsSection) {
            searchResultsSection.style.display = 'block';
            searchResultsSection.innerHTML = '<div class="search-loading">Đang tìm kiếm...</div>';
        }
        if (hotKeywordsSection) hotKeywordsSection.style.display = 'none';
        if (categoriesSection) categoriesSection.style.display = 'none';
        if (brandsSection) brandsSection.style.display = 'none';

        // Fetch search results
        fetch(`/api/search/suggestions?q=${encodeURIComponent(query)}`)
            .then(response => response.json())
            .then(data => {
                displaySearchResults(data);
            })
            .catch(error => {
                console.error('Search error:', error);
                if (searchResultsSection) {
                    searchResultsSection.innerHTML = '<div class="search-error">Có lỗi xảy ra khi tìm kiếm</div>';
                }
            });
    }

    // === Display search results ===
    function displaySearchResults(data) {
        if (!searchResultsSection) return;

        let html = '';

        if (data.products && data.products.length > 0) {
            data.products.forEach(product => {
                html += `
                    <div class="search-result-item" onclick="window.location.href='${product.url}'">
                        <img src="${product.image}" alt="${product.name}" onerror="this.src='/image/sp1.png'">
                        <div class="search-result-info">
                            <div class="search-result-name">${product.name}</div>
                            <div class="search-result-price">${product.formatted_price}</div>
                        </div>
                    </div>
                `;
            });
        } else {
            html = '<div class="search-no-results">Không tìm thấy kết quả nào</div>';
        }

        searchResultsSection.innerHTML = html;
    }

    // === Enter key handling ===
    searchInput.addEventListener('keypress', (e) => {
        if (e.key === 'Enter') {
            e.preventDefault();
            const query = searchInput.value.trim();
            if (query) {
                window.location.href = `/search?q=${encodeURIComponent(query)}`;
            }
        }
    });

    // === Cancel ===
    cancelBtn.addEventListener('click', () => {
        closeSearchOverlay();
    });

    // === Clear ===
    clearBtn.addEventListener('click', () => {
        searchInput.value = '';
        searchInput.focus();
        clearBtn.style.display = 'none';
        if (mainSearchInput) {
            mainSearchInput.value = '';
        }

        // Reset to default view
        if (searchResultsSection) searchResultsSection.style.display = 'none';
        if (hotKeywordsSection) hotKeywordsSection.style.display = 'block';
        if (categoriesSection) categoriesSection.style.display = 'block';
        if (brandsSection) brandsSection.style.display = 'block';
    });

    // === Main search input focus ===
    mainSearchInput.addEventListener('focus', function() {
        if (isMobile()) {
            // Mobile: mở search overlay
            openSearchOverlay();
        } else {
            // Desktop: mở desktop overlay
            if (desktopOverlay) {
                desktopOverlay.style.display = 'block';
            }
        }
    });

    // === Main search input blur (chỉ desktop) ===
    let blurTimeout;
    mainSearchInput.addEventListener('blur', function() {
        if (!isMobile()) {
            // Clear timeout cũ nếu có
            if (blurTimeout) {
                clearTimeout(blurTimeout);
            }

            blurTimeout = setTimeout(() => {
                closeDesktopOverlay();
            }, 200);
        }
    });

    // === Xử lý resize window ===
    window.addEventListener('resize', () => {
        // Đóng overlay khi chuyển đổi mobile/desktop
        if (isMobile()) {
            closeDesktopOverlay();
        } else {
            closeSearchOverlay();
        }
    });

    // === Đóng overlay khi click outside ===
    searchOverlay.addEventListener('click', (e) => {
        if (e.target === searchOverlay) {
            closeSearchOverlay();
        }
    });

    // === ESC key để đóng overlay ===
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape') {
            if (searchOverlay.classList.contains('active')) {
                closeSearchOverlay();
            }
            if (desktopOverlay && desktopOverlay.style.display === 'block') {
                closeDesktopOverlay();
            }
        }
    });

    // === Desktop suggest tags handling ===
    document.querySelectorAll('.suggest-tag').forEach(tag => {
        tag.addEventListener('click', function () {
            if (mainSearchInput && desktopOverlay) {
                mainSearchInput.value = this.textContent;
                desktopOverlay.style.display = 'none';
            }
        });
    });

    // === Mobile category toggle handling ===
    document.querySelectorAll('.mobile-category-toggle').forEach(toggle => {
        toggle.addEventListener('click', function (e) {
            if (this.getAttribute('data-bs-toggle') === 'collapse') {
                setTimeout(() => {
                    this.scrollIntoView({
                        behavior: 'smooth',
                        block: 'nearest'
                    });
                }, 100);
            }
        });
    });

    // === Offcanvas menu handling ===
    document.querySelectorAll('.offcanvas-body a:not([data-bs-toggle])').forEach(link => {
        link.addEventListener('click', function () {
            const offcanvas = bootstrap.Offcanvas.getInstance(document.getElementById('offcanvasMenu'));
            if (offcanvas) {
                offcanvas.hide();
            }
        });
    });

    // === Category items handling ===
    document.querySelectorAll('.category-item').forEach(item => {
        item.addEventListener('click', function() {
            const href = this.getAttribute('data-href');
            if (href) {
                window.location.href = href;
            }
        });
    });

    // === Navbar toggler icon ===
    const navbarToggler = document.querySelector('.navbar-toggler');
    if (navbarToggler) {
        navbarToggler.innerHTML = '<i class="fas fa-bars"></i>';
    }
});
