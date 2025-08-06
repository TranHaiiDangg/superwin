@extends('admin.layouts.app')

@section('title', 'Quản lý Doanh thu')

@section('content')
<div class="container mx-auto px-4 py-6">
    <!-- Header -->
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Báo cáo Doanh thu</h1>
            <p class="text-gray-600">Phân tích doanh thu từ các đơn hàng thành công</p>
        </div>
        
        <div class="flex space-x-3">
            <!-- Year Filter -->
            <select id="yearFilter" onchange="changeYear()" 
                    class="px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                @foreach($available_years as $year)
                    <option value="{{ $year }}" {{ $year == $current_year ? 'selected' : '' }}>
                        Năm {{ $year }}
                    </option>
                @endforeach
            </select>
            
            <!-- Export Button -->
            <button onclick="exportExcel()" 
                    class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg flex items-center">
                <i class="fas fa-file-excel mr-2"></i>
                Xuất Excel
            </button>
        </div>
    </div>

    <!-- Overview Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Total Revenue -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-blue-100 text-blue-600">
                    <i class="fas fa-dollar-sign text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Tổng doanh thu {{ $current_year }}</p>
                    <p class="text-2xl font-bold text-gray-900">
                        {{ number_format($overview['current_year']['total_revenue']) }} VNĐ
                    </p>
                    <p class="text-sm {{ $overview['growth']['revenue_growth'] >= 0 ? 'text-green-600' : 'text-red-600' }}">
                        <i class="fas fa-arrow-{{ $overview['growth']['revenue_growth'] >= 0 ? 'up' : 'down' }}"></i>
                        {{ abs($overview['growth']['revenue_growth']) }}% so với năm trước
                    </p>
                </div>
            </div>
        </div>

        <!-- Total Orders -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-green-100 text-green-600">
                    <i class="fas fa-shopping-cart text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Tổng đơn hàng {{ $current_year }}</p>
                    <p class="text-2xl font-bold text-gray-900">
                        {{ number_format($overview['current_year']['total_orders']) }}
                    </p>
                    <p class="text-sm {{ $overview['growth']['orders_growth'] >= 0 ? 'text-green-600' : 'text-red-600' }}">
                        <i class="fas fa-arrow-{{ $overview['growth']['orders_growth'] >= 0 ? 'up' : 'down' }}"></i>
                        {{ abs($overview['growth']['orders_growth']) }}% so với năm trước
                    </p>
                </div>
            </div>
        </div>

        <!-- Average Order Value -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-yellow-100 text-yellow-600">
                    <i class="fas fa-chart-line text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Giá trị TB/đơn</p>
                    <p class="text-2xl font-bold text-gray-900">
                        {{ number_format($overview['current_year']['avg_order_value']) }} VNĐ
                    </p>
                    <p class="text-sm text-gray-500">Trung bình mỗi đơn hàng</p>
                </div>
            </div>
        </div>

        <!-- Current Month -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-purple-100 text-purple-600">
                    <i class="fas fa-calendar-alt text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Doanh thu tháng này</p>
                    <p class="text-2xl font-bold text-gray-900">
                        {{ number_format($overview['current_month']['total_revenue']) }} VNĐ
                    </p>
                    <p class="text-sm text-gray-500">
                        {{ number_format($overview['current_month']['total_orders']) }} đơn hàng
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Row -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
        <!-- Monthly Revenue Chart -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-semibold text-gray-900">Doanh thu theo tháng</h3>
                <div class="flex space-x-2">
                    <button onclick="toggleChartType('revenue')" id="revenueChartToggle"
                            class="text-sm px-3 py-1 bg-blue-100 text-blue-600 rounded">
                        Biểu đồ cột
                    </button>
                </div>
            </div>
            <div class="h-80">
                <canvas id="monthlyRevenueChart"></canvas>
            </div>
        </div>

        <!-- Orders Chart -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-semibold text-gray-900">Đơn hàng theo tháng</h3>
                <div class="flex space-x-2">
                    <button onclick="toggleChartType('orders')" id="ordersChartToggle"
                            class="text-sm px-3 py-1 bg-green-100 text-green-600 rounded">
                        Biểu đồ đường
                    </button>
                </div>
            </div>
            <div class="h-80">
                <canvas id="monthlyOrdersChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Data Tables Row -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Monthly Data Table -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Chi tiết theo tháng</h3>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Tháng
                            </th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Đơn hàng
                            </th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Doanh thu
                            </th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                TB/đơn
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($monthly as $month)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-3 whitespace-nowrap text-sm font-medium text-gray-900">
                                {{ $month['month_full_name'] }}
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900">
                                {{ number_format($month['total_orders']) }}
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900">
                                {{ number_format($month['total_revenue']) }} VNĐ
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900">
                                {{ number_format($month['avg_order_value']) }} VNĐ
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Top Products -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Top sản phẩm bán chạy</h3>
            <div class="space-y-4">
                @forelse($top_products as $index => $product)
                <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                    <div class="flex items-center">
                        <div class="flex items-center">
                            @if($product->image)
                                <img src="{{ $product->image }}" alt="{{ $product->name }}" 
                                     class="w-10 h-10 rounded-lg object-cover mr-3">
                            @else
                                <div class="w-10 h-10 bg-gray-200 rounded-lg flex items-center justify-center mr-3">
                                    <i class="fas fa-image text-gray-400"></i>
                                </div>
                            @endif
                            <div class="w-8 h-8 bg-blue-100 text-blue-600 rounded-full flex items-center justify-center text-sm font-bold">
                                {{ $index + 1 }}
                            </div>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-gray-900">{{ $product->name }}</p>
                            <div class="flex items-center space-x-2">
                                <p class="text-xs text-gray-500">{{ number_format($product->total_quantity) }} đã bán</p>
                                @if($product->sku)
                                    <span class="text-xs text-blue-600 bg-blue-100 px-2 py-1 rounded">{{ $product->sku }}</span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="text-right">
                        <p class="text-sm font-semibold text-gray-900">
                            {{ number_format($product->total_revenue) }} VNĐ
                        </p>
                        <p class="text-xs text-gray-500">
                            {{ number_format($product->avg_price) }} VNĐ/sp
                        </p>
                    </div>
                </div>
                @empty
                <div class="text-center py-8 text-gray-500">
                    <i class="fas fa-box-open text-4xl mb-4"></i>
                    <p>Chưa có dữ liệu sản phẩm</p>
                </div>
                @endforelse
            </div>
        </div>
    </div>
</div>

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
// Data from PHP
const monthlyData = @json($monthly);
const currentYear = {{ $current_year }};

// Validate and sanitize data
const sanitizedData = Array.isArray(monthlyData) ? monthlyData.map(item => {
    if (!item || typeof item !== 'object') {
        return {
            month_name: '',
            total_revenue: 0,
            total_orders: 0
        };
    }
    
    return {
        month_name: String(item.month_name || '').trim(),
        total_revenue: parseFloat(item.total_revenue) || 0,
        total_orders: parseInt(item.total_orders) || 0
    };
}) : [];

// Chart instances
let monthlyRevenueChart = null;
let monthlyOrdersChart = null;

// Chart types
let revenueChartType = 'bar';
let ordersChartType = 'line';

// Initialize charts
document.addEventListener('DOMContentLoaded', function() {
    console.log('Monthly data received:', monthlyData);
    console.log('Sanitized data:', sanitizedData);
    
    if (sanitizedData && sanitizedData.length > 0) {
        initializeCharts();
    } else {
        console.warn('No revenue data available for charts');
        // Show empty state message
        const revenueChart = document.getElementById('monthlyRevenueChart');
        const ordersChart = document.getElementById('monthlyOrdersChart');
        if (revenueChart) revenueChart.style.display = 'none';
        if (ordersChart) ordersChart.style.display = 'none';
    }
});

function initializeCharts() {
    createRevenueChart();
    createOrdersChart();
}

function createRevenueChart() {
    // Monthly Revenue Chart
    const revenueCtx = document.getElementById('monthlyRevenueChart').getContext('2d');
    monthlyRevenueChart = new Chart(revenueCtx, {
        type: revenueChartType,
        data: {
            labels: sanitizedData.map(item => item.month_name),
            datasets: [{
                label: 'Doanh thu (VNĐ)',
                data: sanitizedData.map(item => item.total_revenue),
                backgroundColor: 'rgba(59, 130, 246, 0.8)',
                borderColor: 'rgb(59, 130, 246)',
                borderWidth: 2,
                tension: 0.4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return new Intl.NumberFormat('vi-VN').format(value) + ' VNĐ';
                        }
                    }
                }
            }
        }
    });
}

function createOrdersChart() {
    // Monthly Orders Chart
    const ordersCtx = document.getElementById('monthlyOrdersChart').getContext('2d');
    monthlyOrdersChart = new Chart(ordersCtx, {
        type: ordersChartType,
        data: {
            labels: sanitizedData.map(item => item.month_name),
            datasets: [{
                label: 'Số đơn hàng',
                data: sanitizedData.map(item => item.total_orders),
                backgroundColor: 'rgba(16, 185, 129, 0.8)',
                borderColor: 'rgb(16, 185, 129)',
                borderWidth: 2,
                tension: 0.4,
                fill: false
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return new Intl.NumberFormat('vi-VN').format(value);
                        }
                    }
                }
            }
        }
    });
}

function toggleChartType(chartName) {
    try {
        if (chartName === 'revenue' && monthlyRevenueChart) {
            revenueChartType = revenueChartType === 'bar' ? 'line' : 'bar';
            const button = document.getElementById('revenueChartToggle');
            if (button) {
                button.textContent = revenueChartType === 'bar' ? 'Biểu đồ cột' : 'Biểu đồ đường';
            }
            
            monthlyRevenueChart.destroy();
            createRevenueChart();
        } else if (chartName === 'orders' && monthlyOrdersChart) {
            ordersChartType = ordersChartType === 'line' ? 'bar' : 'line';
            const button = document.getElementById('ordersChartToggle');
            if (button) {
                button.textContent = ordersChartType === 'line' ? 'Biểu đồ đường' : 'Biểu đồ cột';
            }
            
            monthlyOrdersChart.destroy();
            createOrdersChart();
        }
    } catch (error) {
        console.error('Error toggling chart type:', error);
        // Reinitialize charts if there's an error
        if (sanitizedData && sanitizedData.length > 0) {
            initializeCharts();
        }
    }
}

function changeYear() {
    const year = document.getElementById('yearFilter').value;
    window.location.href = `{{ route('admin.revenue.index') }}?year=${year}`;
}

function exportExcel() {
    const year = document.getElementById('yearFilter').value;
    window.location.href = `{{ route('admin.revenue.export') }}?year=${year}`;
}
</script>
@endsection