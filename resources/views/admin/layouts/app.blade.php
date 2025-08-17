<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin Panel') - SuperWin</title>
    
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="/favicon.png">
    <link rel="shortcut icon" type="image/png" href="/favicon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon.png">
    <link rel="apple-touch-icon" href="/favicon.png">
    
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    
    <!-- Select2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <!-- Select2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    
    <!-- Custom Select2 Styling -->
    <style>
        /* Select2 Container */
        .select2-container {
            width: 100% !important;
        }
        
        /* Select2 Selection */
        .select2-container--default .select2-selection--multiple {
            background-color: white;
            border: 2px solid #d1d5db !important;
            border-radius: 8px !important;
            padding: 8px 12px !important;
            min-height: 48px !important;
            font-size: 14px;
            line-height: 1.5;
            transition: all 0.2s ease-in-out;
        }
        
        .select2-container--default .select2-selection--multiple:focus,
        .select2-container--default.select2-container--focus .select2-selection--multiple {
            border-color: #3b82f6 !important;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1) !important;
            outline: none !important;
        }
        
        /* Selected Items (Tags) */
        .select2-container--default .select2-selection--multiple .select2-selection__choice {
            background-color: #3b82f6 !important;
            border: 1px solid #3b82f6 !important;
            border-radius: 6px !important;
            color: white !important;
            font-size: 13px !important;
            font-weight: 500 !important;
            padding: 4px 8px !important;
            margin: 2px 4px 2px 0 !important;
            line-height: 1.4 !important;
        }
        
        .select2-container--default .select2-selection--multiple .select2-selection__choice__remove {
            color: white !important;
            font-size: 16px !important;
            font-weight: bold !important;
            margin-right: 6px !important;
            border-right: 1px solid rgba(255,255,255,0.3) !important;
            padding-right: 6px !important;
        }
        
        .select2-container--default .select2-selection--multiple .select2-selection__choice__remove:hover {
            background-color: rgba(255,255,255,0.2) !important;
            color: white !important;
        }
        
        /* Dropdown */
        .select2-container--default .select2-dropdown {
            border: 2px solid #d1d5db !important;
            border-radius: 8px !important;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1) !important;
            margin-top: 4px;
        }
        
        .select2-container--default .select2-search--dropdown .select2-search__field {
            border: 1px solid #e5e7eb !important;
            border-radius: 6px !important;
            padding: 8px 12px !important;
            font-size: 14px;
            margin: 8px !important;
            width: calc(100% - 16px) !important;
        }
        
        .select2-container--default .select2-search--dropdown .select2-search__field:focus {
            border-color: #3b82f6 !important;
            box-shadow: 0 0 0 2px rgba(59, 130, 246, 0.1) !important;
            outline: none !important;
        }
        
        /* Dropdown Results */
        .select2-container--default .select2-results__option {
            padding: 12px 16px !important;
            font-size: 14px;
            line-height: 1.5;
            transition: all 0.2s ease-in-out;
        }
        
        .select2-container--default .select2-results__option--highlighted[aria-selected] {
            background-color: #3b82f6 !important;
            color: white !important;
        }
        
        .select2-container--default .select2-results__option[aria-selected=true] {
            background-color: #eff6ff !important;
            color: #1e40af !important;
            font-weight: 500;
        }
        
        /* Placeholder */
        .select2-container--default .select2-selection--multiple .select2-selection__placeholder {
            color: #9ca3af !important;
            font-size: 14px;
            margin-top: 8px;
        }
        
        /* Clear button */
        .select2-container--default .select2-selection__clear {
            color: #6b7280 !important;
            font-size: 18px !important;
            font-weight: bold !important;
            margin-right: 8px !important;
        }
        
        .select2-container--default .select2-selection__clear:hover {
            color: #ef4444 !important;
        }
        
        /* No results */
        .select2-container--default .select2-results__option--noResults {
            color: #6b7280 !important;
            font-style: italic;
            text-align: center;
            padding: 20px !important;
        }
        
        /* Loading */
        .select2-container--default .select2-results__option--loading {
            color: #3b82f6 !important;
            text-align: center;
            padding: 20px !important;
        }
        
        /* Responsive adjustments */
        @media (max-width: 640px) {
            .select2-container--default .select2-selection--multiple {
                min-height: 44px !important;
                padding: 6px 10px !important;
            }
            
            .select2-container--default .select2-selection--multiple .select2-selection__choice {
                font-size: 12px !important;
                padding: 3px 6px !important;
            }
        }
    </style>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#3B82F6',
                        secondary: '#64748B',
                        success: '#10B981',
                        warning: '#F59E0B',
                        danger: '#EF4444',
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-gray-50">
    <div class="min-h-screen flex">
        <!-- Sidebar -->
        <div class="bg-gray-900 text-white w-64 min-h-screen">
            <div class="p-4">
                <h1 class="text-2xl font-bold">SuperWin Admin</h1>
            </div>
            
            <nav class="mt-8">
                <div class="px-4 space-y-2">
                    <a href="{{ route('admin.dashboard') }}" 
                       class="flex items-center px-4 py-2 text-gray-300 hover:bg-gray-800 hover:text-white rounded-lg transition-colors {{ request()->routeIs('admin.dashboard') ? 'bg-primary text-white' : '' }}">
                        <i class="fas fa-tachometer-alt mr-3"></i>
                        Dashboard
                    </a>
                    
                    <a href="{{ route('admin.products.index') }}" 
                       class="flex items-center px-4 py-2 text-gray-300 hover:bg-gray-800 hover:text-white rounded-lg transition-colors {{ request()->routeIs('admin.products.*') ? 'bg-primary text-white' : '' }}">
                        <i class="fas fa-box mr-3"></i>
                        Sản phẩm
                    </a>
                    
                    <a href="{{ route('admin.categories.index') }}" 
                       class="flex items-center px-4 py-2 text-gray-300 hover:bg-gray-800 hover:text-white rounded-lg transition-colors {{ request()->routeIs('admin.categories.*') ? 'bg-primary text-white' : '' }}">
                        <i class="fas fa-tags mr-3"></i>
                        Danh mục
                    </a>
                    
                    <a href="{{ route('admin.brands.index') }}" 
                       class="flex items-center px-4 py-2 text-gray-300 hover:bg-gray-800 hover:text-white rounded-lg transition-colors {{ request()->routeIs('admin.brands.*') ? 'bg-primary text-white' : '' }}">
                        <i class="fas fa-copyright mr-3"></i>
                        Thương hiệu
                    </a>
                    
                    <a href="{{ route('admin.product-attributes.index') }}" 
                       class="flex items-center px-4 py-2 text-gray-300 hover:bg-gray-800 hover:text-white rounded-lg transition-colors {{ request()->routeIs('admin.product-attributes.*') ? 'bg-primary text-white' : '' }}">
                        <i class="fas fa-cogs mr-3"></i>
                        Thuộc tính SP
                    </a>
                    
                    <a href="{{ route('admin.orders.index') }}" 
                       class="flex items-center px-4 py-2 text-gray-300 hover:bg-gray-800 hover:text-white rounded-lg transition-colors {{ request()->routeIs('admin.orders.*') ? 'bg-primary text-white' : '' }}">
                        <i class="fas fa-shopping-cart mr-3"></i>
                        Đơn hàng
                    </a>
                    <a href="{{ route('admin.customers.index') }}" 
                       class="flex items-center px-4 py-2 text-gray-300 hover:bg-gray-800 hover:text-white rounded-lg transition-colors {{ request()->routeIs('admin.customers.*') ? 'bg-primary text-white' : '' }}">
                        <i class="fas fa-users mr-3"></i>
                        Khách hàng
                    </a>
                    @if(auth()->user()->hasPermission('revenue.view'))
                    <a href="{{ route('admin.revenue.index') }}" 
                       class="flex items-center justify-between px-4 py-2 text-gray-300 hover:bg-gray-800 hover:text-white rounded-lg transition-colors {{ request()->routeIs('admin.revenue.*') ? 'bg-primary text-white' : '' }}">
                        <div class="flex items-center">
                            <i class="fas fa-chart-bar mr-3"></i>
                            Báo cáo Doanh thu
                        </div>
                        <!-- <span class="bg-green-600 text-white text-xs px-2 py-1 rounded-full">
                            <i class="fas fa-chart-line"></i>
                        </span> -->
                    </a>
                    @endif
                    
                    @if(auth()->user()->hasPermission('hot_searches.view'))
                    <a href="{{ route('admin.hot-searches.index') }}" 
                       class="flex items-center justify-between px-4 py-2 text-gray-300 hover:bg-gray-800 hover:text-white rounded-lg transition-colors {{ request()->routeIs('admin.hot-searches.*') ? 'bg-primary text-white' : '' }}">
                        <div class="flex items-center">
                            <i class="fas fa-fire mr-3"></i>
                            Hot Search
                        </div>
                        <span class="bg-red-600 text-white text-xs px-2 py-1 rounded-full">
                            {{ \App\Models\HotSearch::where('is_active', true)->count() }}
                        </span>
                    </a>
                    @endif
                    
                    <!-- System Management Dropdown -->
                    <div class="relative group">
                        <button class="w-full flex items-center justify-between px-4 py-2 text-gray-300 hover:bg-gray-800 hover:text-white rounded-lg transition-colors {{ request()->routeIs('admin.users.*') || request()->routeIs('admin.permissions.*') ? 'bg-primary text-white' : '' }}" 
                                onclick="toggleDropdown('systemDropdown')">
                            <div class="flex items-center">
                                <i class="fas fa-cog mr-3"></i>
                                Quản lý Hệ thống
                            </div>
                            <i class="fas fa-chevron-down text-xs transition-transform duration-200" id="systemDropdownIcon"></i>
                        </button>
                        
                        <div id="systemDropdown" class="hidden mt-2 ml-4 space-y-1">
                            <a href="{{ route('admin.users.index') }}" 
                               class="flex items-center justify-between px-4 py-2 text-gray-400 hover:bg-gray-800 hover:text-white rounded-lg transition-colors text-sm {{ request()->routeIs('admin.users.*') ? 'bg-gray-800 text-white' : '' }}">
                                <div class="flex items-center">
                                    <i class="fas fa-user-shield mr-3 text-xs"></i>
                                    User Admin
                                </div>
                                <span class="bg-green-600 text-white text-xs px-2 py-1 rounded-full">
                                    {{ \App\Models\User::where('is_active', true)->count() }}
                                </span>
                            </a>
                            
                            @if(auth()->user()->hasPermission('users.permissions'))
                            <a href="{{ route('admin.permissions.index') }}" 
                               class="flex items-center justify-between px-4 py-2 text-gray-400 hover:bg-gray-800 hover:text-white rounded-lg transition-colors text-sm {{ request()->routeIs('admin.permissions.*') ? 'bg-gray-800 text-white' : '' }}">
                                <div class="flex items-center">
                                    <i class="fas fa-key mr-3 text-xs"></i>
                                    Quản lý Quyền
                                </div>
                                <span class="bg-blue-600 text-white text-xs px-2 py-1 rounded-full">
                                    {{ \App\Models\Permission::count() }}
                                </span>
                            </a>
                            @endif
                        </div>
                    </div>
                </div>
            </nav>
        </div>

        <!-- Main Content -->
        <div class="flex-1">
            <!-- Header -->
            <header class="bg-white shadow-sm border-b">
                <div class="flex justify-between items-center px-6 py-4">
                    <h2 class="text-xl font-semibold text-gray-800">@yield('page-title', 'Dashboard')</h2>
                    
                    <div class="flex items-center space-x-4">
                        <div class="relative">
                            <button class="flex items-center text-gray-700 hover:text-gray-900">
                                <i class="fas fa-bell mr-2"></i>
                                <span class="bg-red-500 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center">3</span>
                            </button>
                        </div>
                        
                        <div class="relative">
                            <button class="flex items-center text-gray-700 hover:text-gray-900">
                                <img class="h-8 w-8 rounded-full" src="https://ui-avatars.com/api/?name=Admin&background=3B82F6&color=fff" alt="Admin">
                                <span class="ml-2">{{ Auth::user()->name ?? 'Admin' }}</span>
                                <i class="fas fa-chevron-down ml-2"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Page Content -->
            <main class="p-6">
                @if(session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                        {{ session('success') }}
                    </div>
                @endif

                @if(session('error'))
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                        {{ session('error') }}
                    </div>
                @endif

                @if($errors->any())
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                        <ul class="list-disc list-inside">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>

    <script>
        // Toggle mobile menu
        function toggleMobileMenu() {
            const sidebar = document.querySelector('.bg-gray-900');
            sidebar.classList.toggle('hidden');
        }

        // Toggle dropdown menu
        function toggleDropdown(dropdownId) {
            const dropdown = document.getElementById(dropdownId);
            const icon = document.getElementById(dropdownId + 'Icon');
            
            dropdown.classList.toggle('hidden');
            
            if (dropdown.classList.contains('hidden')) {
                icon.classList.remove('rotate-180');
            } else {
                icon.classList.add('rotate-180');
            }
        }

        // Auto-expand dropdown if current page is in dropdown
        document.addEventListener('DOMContentLoaded', function() {
            // Check if current route is users.* or permissions.*
            const currentPath = window.location.pathname;
            if (currentPath.includes('/admin/users') || currentPath.includes('/admin/permissions')) {
                const systemDropdown = document.getElementById('systemDropdown');
                const systemIcon = document.getElementById('systemDropdownIcon');
                
                if (systemDropdown && systemIcon) {
                    systemDropdown.classList.remove('hidden');
                    systemIcon.classList.add('rotate-180');
                }
            }
        });

        // Close dropdowns when clicking outside
        document.addEventListener('click', function(event) {
            const dropdowns = document.querySelectorAll('[id$="Dropdown"]');
            dropdowns.forEach(dropdown => {
                if (!dropdown.closest('.relative').contains(event.target)) {
                    dropdown.classList.add('hidden');
                    const icon = document.getElementById(dropdown.id + 'Icon');
                    if (icon) {
                        icon.classList.remove('rotate-180');
                    }
                }
            });
        });
    </script>
</body>
</html> 