
document.addEventListener('DOMContentLoaded', function () {
    const searchInput = document.getElementById('searchInput');
    const desktopSearchOverlay = document.getElementById('desktopSearchOverlay');

    if (searchInput && desktopSearchOverlay) {
        searchInput.addEventListener('focus', function () {
            desktopSearchOverlay.style.display = 'block';
        });

        searchInput.addEventListener('blur', function () {
            setTimeout(() => {
                desktopSearchOverlay.style.display = 'none';
            }, 200);
        });

        searchInput.addEventListener('keypress', function (e) {
            if (e.key === 'Enter') {
                const searchTerm = this.value.trim();
                if (searchTerm) {
                    alert('Tìm kiếm: ' + searchTerm);
                }
            }
        });
    }

    document.querySelectorAll('.suggest-tag').forEach(tag => {
        tag.addEventListener('click', function () {
            if (searchInput && desktopSearchOverlay) {
                searchInput.value = this.textContent;
                desktopSearchOverlay.style.display = 'none';
            }
        });
    });

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

    document.querySelectorAll('.offcanvas-body a:not([data-bs-toggle])').forEach(link => {
        link.addEventListener('click', function () {
            const offcanvas = bootstrap.Offcanvas.getInstance(document.getElementById('offcanvasMenu'));
            if (offcanvas) {
                offcanvas.hide();
            }
        });
    });

    const navbarToggler = document.querySelector('.navbar-toggler');
    if (navbarToggler) {
        navbarToggler.innerHTML = '<i class="fas fa-bars"></i>';
    }
});

document.addEventListener('DOMContentLoaded', () => {
    // === Khai báo với kiểm tra an toàn ===
    const searchOverlay = document.getElementById('searchOverlay');
    const searchInput = document.getElementById('searchInput');
    const mainSearchInput = document.querySelector('.main-search-input');
    const clearBtn = document.getElementById('clearBtn');
    const cancelBtn = document.getElementById('cancelBtn');
    const desktopOverlay = document.getElementById('desktopSearchOverlay');

    // Kiểm tra elements tồn tại
    if (!searchOverlay || !searchInput || !mainSearchInput || !clearBtn || !cancelBtn) {
        console.warn('Some required elements are missing');
        return;
    }

    // === Helper function ===
    function isMobile() {
        return window.innerWidth < 992;
    }

    // === Mở overlay ===
    function openSearchOverlay() {
        searchInput.value = mainSearchInput.value;
        clearBtn.style.display = searchInput.value.trim() ? 'block' : 'none';
        searchOverlay.classList.add('active');
        document.body.style.overflow = 'hidden';
        setTimeout(() => { 
            searchInput.focus(); 
        }, 300);
    }

    // === Đóng overlay ===
    function closeSearchOverlay() {
        searchOverlay.classList.remove('active');
        document.body.style.overflow = '';
        clearBtn.style.display = searchInput.value.trim() ? 'block' : 'none';
    }

    // === Đóng desktop overlay ===
    function closeDesktopOverlay() {
        if (desktopOverlay) {
            desktopOverlay.style.display = 'none';
        }
    }

    // === Gõ trong overlay → update input ngoài (real-time) ===
    searchInput.addEventListener('input', () => {
        if (mainSearchInput) {
            mainSearchInput.value = searchInput.value;
        }
        clearBtn.style.display = searchInput.value.trim() ? 'block' : 'none';
    });

    // === Enter key handling ===
    searchInput.addEventListener('keypress', (e) => {
        if (e.key === 'Enter') {
            e.preventDefault();
            // Thực hiện search logic ở đây
            closeSearchOverlay();
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
    });

    // === Main search input focus ===
    mainSearchInput.addEventListener('focus', function() {
        if (isMobile()) {
            // Mobile: mở Hasaki overlay
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
});
    