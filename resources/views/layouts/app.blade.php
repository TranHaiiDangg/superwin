<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'SuperWin - Máy bơm nước & Quạt công nghiệp')</title>

    <!-- Meta tags -->
    <meta name="description" content="@yield('description', 'SuperWin - Chuyên cung cấp máy bơm nước, quạt công nghiệp chất lượng cao. Giao hàng toàn quốc, bảo hành chính hãng.')">
    <meta name="keywords" content="@yield('keywords', 'máy bơm nước, quạt công nghiệp, superwin, máy bơm chìm, quạt thông gió')">
    <meta name="author" content="SuperWin">

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="/favicon.png">
    <link rel="shortcut icon" type="image/png" href="/favicon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon.png">
    <link rel="apple-touch-icon" href="/favicon.png">

    <!-- CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="/css/trang_chu/header.css">
    <link rel="stylesheet" href="/css/trang_chu/footer.css">
    <link rel="stylesheet" href="/css/trang_chu/product.css">

    @stack('styles')

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
            line-height: 1.6;
            color: #212529;
            background-color: #ffffff;
            overflow-x: hidden;
            font-size: 0.93rem;
            padding-top: 60px;
        }

        .alert {
            border-radius: 8px;
            border: none;
            padding: 12px 16px;
            margin-bottom: 20px;
        }

        .alert-success {
            background-color: #d1edff;
            color: #0c5460;
        }

        .alert-danger {
            background-color: #f8d7da;
            color: #721c24;
        }

        .btn {
            border-radius: 8px;
            padding: 10px 20px;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .btn-primary {
            background-color: #4facfe;
            border-color: #4facfe;
        }

        .btn-primary:hover {
            background-color: #3a8bfd;
            border-color: #3a8bfd;
        }

        .form-control {
            border-radius: 8px;
            border: 1px solid #e1e5e9;
            padding: 12px 16px;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            border-color: #4facfe;
            box-shadow: 0 0 0 0.2rem rgba(79, 172, 254, 0.25);
        }

        /* CSS cho search form - Enhanced Beautiful Design */
        .search-container {
            max-width: 500px;
            position: relative;
        }

        .search-icon {
            left: 16px;
            top: 50%;
            transform: translateY(-50%);
            color: #38bdf8;
            z-index: 10;
            pointer-events: none;
            font-size: 18px;
            transition: color 0.3s ease, filter 0.3s ease;
            filter: drop-shadow(0 2px 4px rgba(56, 189, 248, 0.2));
            position: absolute;
        }

        .search-input {
            border-radius: 30px !important;
            border: 2px solid rgba(56, 189, 248, 0.2) !important;
            background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%) !important;
            box-shadow: 0 6px 20px rgba(56, 189, 248, 0.1), inset 0 1px 3px rgba(255, 255, 255, 0.9) !important;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            height: 52px !important;
            font-weight: 600;
            position: relative;
        }

        .search-input:focus {
            border: 2px solid #38bdf8 !important;
            background: linear-gradient(135deg, #ffffff 0%, #f0f9ff 100%) !important;
            box-shadow: 0 10px 35px rgba(56, 189, 248, 0.2), 0 0 0 4px rgba(56, 189, 248, 0.1) !important;
            outline: none;
            transform: translateY(-2px) scale(1.01);
        }

        .search-input:focus {
            /* Focus styles handled above */
        }

        .search-input:focus + .search-icon,
        .search-input:focus ~ .search-icon {
            color: #0ea5e9;
            filter: drop-shadow(0 3px 6px rgba(14, 165, 233, 0.3));
        }

        /* Loại bỏ hover effect cho icon để tránh lỗi */

        .search-input::placeholder {
            color: #94a3b8;
            font-size: 14px;
            font-weight: 400;
        }

        /* Main Search Suggestions Styles - Beautiful Glass Effect */
        .main-search-suggestions {
            position: absolute;
            top: 100%;
            left: 0;
            right: 0;
            background: rgba(255, 255, 255, 0.98);
            backdrop-filter: blur(25px);
            border: 1px solid rgba(56, 189, 248, 0.12);
            border-radius: 24px;
            box-shadow: 0 20px 60px rgba(56, 189, 248, 0.15), 0 8px 25px rgba(0, 0, 0, 0.08);
            z-index: 1050;
            max-height: 450px;
            overflow-y: auto;
            margin-top: 12px;
            width: 100%;
            min-width: 320px;
            animation: slideDown 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            border-top: 3px solid #38bdf8;
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-10px) scale(0.98);
            }
            to {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }

        .main-search-suggestions .suggestions-content {
            padding: 8px 0;
        }

        .main-search-suggestions .suggestion-item {
            padding: 12px 20px;
            cursor: pointer;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            display: flex;
            align-items: center;
            border-radius: 12px;
            margin: 4px 12px;
            position: relative;
            overflow: hidden;
        }

        .main-search-suggestions .suggestion-item::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            width: 0;
            height: 100%;
            background: linear-gradient(90deg, rgba(56, 189, 248, 0.12), rgba(56, 189, 248, 0.06));
            transition: width 0.3s ease;
            z-index: -1;
        }

        .main-search-suggestions .suggestion-item:hover {
            background: linear-gradient(135deg, rgba(56, 189, 248, 0.08) 0%, rgba(125, 211, 252, 0.05) 100%);
            transform: translateX(6px);
            box-shadow: 0 4px 15px rgba(56, 189, 248, 0.12);
        }

        .main-search-suggestions .suggestion-item:hover::before {
            width: 4px;
        }

        .main-search-suggestions .keyword-item {
            background: linear-gradient(135deg, #38bdf8 0%, #0ea5e9 100%);
            color: white;
            font-weight: 700;
            font-size: 15px;
            padding: 14px 24px;
            margin: 12px 16px;
            border-radius: 25px;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: 0 4px 15px rgba(56, 189, 248, 0.25);
            position: relative;
            overflow: hidden;
            text-transform: uppercase;
            letter-spacing: 0.3px;
        }

        .main-search-suggestions .keyword-item::before {
            /* content: '🔍'; */
            margin-right: 10px;
            font-size: 18px;
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.15); }
        }

        .main-search-suggestions .keyword-item:hover {
            background: linear-gradient(135deg, #0ea5e9 0%, #0284c7 100%);
            transform: translateY(-2px) scale(1.02);
            box-shadow: 0 8px 25px rgba(56, 189, 248, 0.35);
        }

        .main-search-suggestions .product-suggestion {
            display: flex;
            align-items: center;
            gap: 16px;
            padding: 16px 20px;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            border-radius: 16px;
            margin: 6px 12px;
            position: relative;
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.8) 0%, rgba(248, 250, 252, 0.9) 100%);
            border: 1px solid rgba(139, 92, 246, 0.05);
        }

        .main-search-suggestions .product-suggestion::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(135deg, rgba(139, 92, 246, 0.05) 0%, rgba(168, 85, 247, 0.02) 100%);
            border-radius: 16px;
            opacity: 0;
            transition: opacity 0.3s ease;
            pointer-events: none;
        }

        .main-search-suggestions .product-suggestion:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 30px rgba(139, 92, 246, 0.12);
            border-color: rgba(139, 92, 246, 0.15);
        }

        .main-search-suggestions .product-suggestion:hover::after {
            opacity: 1;
        }

        .main-search-suggestions .product-suggestion img {
            width: 48px;
            height: 48px;
            object-fit: cover;
            border-radius: 12px;
            flex-shrink: 0;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
            border: 2px solid rgba(255, 255, 255, 0.8);
        }

        .main-search-suggestions .product-suggestion:hover img {
            transform: scale(1.05);
            box-shadow: 0 6px 20px rgba(139, 92, 246, 0.15);
        }

        .main-search-suggestions .product-info {
            flex: 1;
            min-width: 0;
        }

        .main-search-suggestions .product-name {
            font-size: 15px;
            font-weight: 700;
            color: #1e293b;
            margin: 0 0 6px 0;
            line-height: 1.4;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
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
            color: #38bdf8;
            background: linear-gradient(135deg, rgba(56, 189, 248, 0.1) 0%, rgba(125, 211, 252, 0.06) 100%);
            padding: 4px 12px;
            border-radius: 20px;
            font-weight: 600;
            border: 1px solid rgba(56, 189, 248, 0.15);
            text-transform: uppercase;
            letter-spacing: 0.5px;
            box-shadow: 0 2px 8px rgba(56, 189, 248, 0.1);
        }

        .main-search-suggestions .product-price {
            font-size: 16px;
            font-weight: 800;
            background: linear-gradient(135deg, #f59e0b 0%, #ef4444 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            text-shadow: 0 2px 4px rgba(245, 158, 11, 0.3);
            position: relative;
        }

        .main-search-suggestions .product-price::before {
            content: '💰';
            position: absolute;
            left: -20px;
            top: 0;
            font-size: 14px;
            opacity: 0.7;
        }

        .main-search-suggestions .suggestion-loading,
        .main-search-suggestions .suggestion-no-results {
            color: #38bdf8;
            font-size: 14px;
            padding: 24px;
            text-align: center;
            font-weight: 600;
            background: linear-gradient(135deg, rgba(56, 189, 248, 0.06) 0%, rgba(125, 211, 252, 0.03) 100%);
            margin: 10px 14px;
            border-radius: 16px;
            border: 1px dashed rgba(56, 189, 248, 0.2);
        }

        .main-search-suggestions .suggestion-loading i {
            color: #38bdf8;
            margin-right: 8px;
            animation: spin 1s linear infinite;
            font-size: 14px;
        }

        @keyframes spin {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
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

        /* Responsive for main search */
        @media (max-width: 768px) {
            .search-container {
                max-width: none;
                position: relative;
            }

            /* Enhanced mobile search input */
            .search-input {
                height: 54px !important;
                font-size: 16px !important;
                font-weight: 600 !important;
                border: 3px solid rgba(56, 189, 248, 0.25) !important;
                background: linear-gradient(135deg, #ffffff 0%, #f0f9ff 100%) !important;
                box-shadow: 0 8px 25px rgba(56, 189, 248, 0.15), inset 0 2px 4px rgba(255, 255, 255, 0.9) !important;
                border-radius: 32px !important;
            }

            .search-input:focus {
                border: 3px solid #38bdf8 !important;
                background: linear-gradient(135deg, #ffffff 0%, #f0f9ff 100%) !important;
                box-shadow: 0 12px 40px rgba(56, 189, 248, 0.25), 0 0 0 6px rgba(56, 189, 248, 0.15) !important;
                transform: translateY(-2px) scale(1.02);
            }

            .search-icon {
                font-size: 18px;
                left: 18px;
                color: #38bdf8;
                filter: drop-shadow(0 2px 4px rgba(56, 189, 248, 0.3));
            }

            .search-input::placeholder {
                font-size: 15px;
                font-weight: 500;
                color: #38bdf8;
                opacity: 0.8;
            }
            
            .main-search-suggestions {
                left: -15px;
                right: -15px;
                border-radius: 20px;
                max-height: 350px;
                box-shadow: 0 15px 50px rgba(56, 189, 248, 0.2), 0 6px 20px rgba(0, 0, 0, 0.08);
                border-top: 4px solid #38bdf8;
            }
            
            .main-search-suggestions .product-suggestion {
                padding: 12px 16px;
                gap: 12px;
            }
            
            .main-search-suggestions .product-suggestion img {
                width: 40px;
                height: 40px;
            }
            
            .main-search-suggestions .product-name {
                font-size: 13px;
                -webkit-line-clamp: 1;
            }
            
            .main-search-suggestions .product-price {
                font-size: 13px;
            }
            
            .main-search-suggestions .product-brand {
                font-size: 9px;
                padding: 2px 8px;
            }
            
            .main-search-suggestions .keyword-item {
                font-size: 14px;
                padding: 12px 20px;
                margin: 10px 16px;
                border-radius: 25px;
                box-shadow: 0 6px 20px rgba(56, 189, 248, 0.3);
            }
        }
        
        /* Hot Search Suggestions Styles */
        .suggestions-section {
            margin-bottom: 15px;
        }
        
        .suggestions-section:last-child {
            margin-bottom: 0;
        }
        
        .section-header {
            display: flex;
            align-items: center;
            padding: 8px 20px;
            background: linear-gradient(135deg, #f8f9fa, #e9ecef);
            border-bottom: 2px solid #dee2e6;
            font-weight: 600;
            font-size: 13px;
            color: #495057;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        .section-header i {
            color: #007bff;
            margin-right: 8px;
        }
        
        .suggestions-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 10px;
            padding: 15px 20px;
        }
        
        .suggestions-keywords {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
            padding: 15px 20px;
        }
        
        /* Hot Category Items */
        .hot-category-item,
        .hot-brand-item {
            display: flex;
            align-items: center;
            padding: 12px;
            border-radius: 12px;
            background: linear-gradient(135deg, #fff, #f8f9fa);
            border: 1px solid #e9ecef;
            transition: all 0.3s ease;
            cursor: pointer;
        }
        
        .hot-category-item:hover,
        .hot-brand-item:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(0, 123, 255, 0.15);
            border-color: #007bff;
        }
        
        .hot-category-item img,
        .hot-brand-item img {
            width: 40px;
            height: 40px;
            border-radius: 8px;
            object-fit: cover;
            margin-right: 12px;
        }
        
        .item-info {
            flex: 1;
        }
        
        .item-name {
            font-weight: 600;
            font-size: 14px;
            color: #212529;
            margin-bottom: 2px;
        }
        
        .item-type {
            font-size: 11px;
            color: #6c757d;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        /* Hot Product Items */
        .hot-product-item {
            display: flex;
            align-items: center;
            padding: 12px 20px;
            border-bottom: 1px solid #f0f0f0;
            transition: all 0.3s ease;
            cursor: pointer;
        }
        
        .hot-product-item:last-child {
            border-bottom: none;
        }
        
        .hot-product-item:hover {
            background: linear-gradient(135deg, #fff5f5, #fff0f0);
            transform: translateX(5px);
        }
        
        .hot-product-item img {
            width: 50px;
            height: 50px;
            border-radius: 8px;
            object-fit: cover;
            margin-right: 15px;
        }
        
        .hot-badge {
            background: linear-gradient(135deg, #ff6b6b, #ff8e53);
            color: white;
            padding: 2px 8px;
            border-radius: 12px;
            font-size: 10px;
            font-weight: 600;
            margin-right: 8px;
        }
        
        .product-price-sale {
            color: #dc3545;
            font-weight: 600;
            margin-right: 5px;
        }
        
        .product-price-old {
            color: #6c757d;
            text-decoration: line-through;
            font-size: 12px;
        }
        
        /* Hot Keyword Items */
        .hot-keyword-item {
            display: flex;
            align-items: center;
            padding: 8px 16px;
            background: linear-gradient(135deg, #e3f2fd, #f3e5f5);
            border: 1px solid #bbdefb;
            border-radius: 20px;
            transition: all 0.3s ease;
            cursor: pointer;
            margin-bottom: 5px;
        }
        
        .hot-keyword-item:hover {
            background: linear-gradient(135deg, #2196f3, #9c27b0);
            color: white;
            transform: scale(1.05);
        }
        
        .keyword-icon {
            width: 24px;
            height: 24px;
            border-radius: 50%;
            background: rgba(33, 150, 243, 0.1);
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 10px;
        }
        
        .keyword-icon i {
            font-size: 10px;
            color: #2196f3;
        }
        
        .hot-keyword-item:hover .keyword-icon {
            background: rgba(255, 255, 255, 0.2);
        }
        
        .hot-keyword-item:hover .keyword-icon i {
            color: white;
        }
        
        .keyword-info {
            flex: 1;
        }
        
        .keyword-text {
            font-weight: 500;
            font-size: 13px;
            margin-bottom: 1px;
        }
        
        .keyword-type {
            font-size: 10px;
            opacity: 0.7;
        }
        
        /* Block Loading Styles */
        .block-loading {
            padding: 20px;
            text-align: center;
            background: linear-gradient(135deg, #f8f9fa, #e9ecef);
            border-radius: 8px;
            margin: 10px 20px;
        }
        
        .loading-content {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            color: #6c757d;
            font-size: 13px;
        }
        
        .loading-content i {
            color: #007bff;
            font-size: 16px;
        }
        
        .block-loading {
            animation: fadeInOut 1.5s ease-in-out infinite alternate;
        }
        
        @keyframes fadeInOut {
            0% { opacity: 0.6; }
            100% { opacity: 1; }
        }
        
        /* Shimmer effect for loading */
        .block-loading::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.4), transparent);
            animation: shimmer 2s infinite;
        }
        
        .block-loading {
            position: relative;
            overflow: hidden;
        }
        
        @keyframes shimmer {
            0% { left: -100%; }
            100% { left: 100%; }
        }
        
        /* Mobile Responsive */
        @media (max-width: 768px) {
            .suggestions-grid {
                grid-template-columns: 1fr;
                gap: 8px;
                padding: 10px 15px;
            }
            
            .section-header {
                padding: 6px 15px;
                font-size: 12px;
            }
            
            .hot-category-item,
            .hot-brand-item {
                padding: 10px;
            }
            
            .hot-product-item {
                padding: 10px 15px;
            }
            
            .suggestions-keywords {
                padding: 10px 15px;
            }
            
            .hot-keyword-item {
                font-size: 12px;
                padding: 6px 12px;
            }
            
            .block-loading {
                margin: 8px 15px;
                padding: 15px;
            }
            
            .loading-content {
                font-size: 12px;
                gap: 8px;
            }
        }
    </style>
</head>
<body>
    <!-- Header -->
    @include('layouts.header')

    <!-- Main Content -->
    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    @include('layouts.footer')

    <!-- Scripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="/js/cart-manager.js"></script>

    <!-- Initialize cart count on page load -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize cart count from localStorage
            const cartCountElement = document.querySelector('.cart-count');
            if (cartCountElement) {
                const storedCount = localStorage.getItem('cartCount');
                if (storedCount) {
                    cartCountElement.textContent = storedCount;
                    cartCountElement.style.display = parseInt(storedCount) > 0 ? 'inline-block' : 'none';
                }
            }

            // Check if cartManager is available
            // if (typeof cartManager === 'undefined') {
            //     console.error('CartManager not loaded properly');
            // } else {
            //     console.log('CartManager loaded successfully');
            // }
        });
    </script>

    @stack('scripts')
</body>
</html>
