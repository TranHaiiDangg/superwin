<?php

namespace App\Services;

use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class RevenueService
{
    /**
     * Các trạng thái đơn hàng được tính doanh thu
     */
    public const SUCCESS_STATUSES = [
        'delivered',    // Đã giao hàng
        'completed',    // Hoàn thành
        'paid',         // Đã thanh toán
        'success'       // Thành công
    ];

    /**
     * Lấy doanh thu theo tháng trong năm
     */
    public function getMonthlyRevenue(int $year = null): array
    {
        $year = $year ?? Carbon::now()->year;

        $monthlyData = Order::selectRaw('
                MONTH(created_at) as month,
                COUNT(*) as total_orders,
                SUM(total_amount) as total_revenue,
                AVG(total_amount) as avg_order_value
            ')
            ->whereYear('created_at', $year)
            ->whereIn('status', self::SUCCESS_STATUSES)
            ->groupBy('month')
            ->orderBy('month')
            ->get()
            ->keyBy('month');

        // Tạo data đầy đủ 12 tháng
        $result = [];
        for ($month = 1; $month <= 12; $month++) {
            $data = $monthlyData->get($month);
            $result[] = [
                'month' => $month,
                'month_name' => Carbon::create()->month($month)->format('M'),
                'month_full_name' => Carbon::create()->month($month)->format('F'),
                'total_orders' => $data ? (int)$data->total_orders : 0,
                'total_revenue' => $data ? (float)$data->total_revenue : 0,
                'avg_order_value' => $data ? (float)$data->avg_order_value : 0,
            ];
        }

        return $result;
    }

    /**
     * Lấy doanh thu theo quý
     */
    public function getQuarterlyRevenue(int $year = null): array
    {
        $year = $year ?? Carbon::now()->year;

        $quarterlyData = Order::selectRaw('
                QUARTER(created_at) as quarter,
                COUNT(*) as total_orders,
                SUM(total_amount) as total_revenue,
                AVG(total_amount) as avg_order_value
            ')
            ->whereYear('created_at', $year)
            ->whereIn('status', self::SUCCESS_STATUSES)
            ->groupBy('quarter')
            ->orderBy('quarter')
            ->get()
            ->keyBy('quarter');

        $result = [];
        for ($quarter = 1; $quarter <= 4; $quarter++) {
            $data = $quarterlyData->get($quarter);
            $result[] = [
                'quarter' => $quarter,
                'quarter_name' => "Q{$quarter}",
                'total_orders' => $data ? (int)$data->total_orders : 0,
                'total_revenue' => $data ? (float)$data->total_revenue : 0,
                'avg_order_value' => $data ? (float)$data->avg_order_value : 0,
            ];
        }

        return $result;
    }

    /**
     * Lấy top sản phẩm bán chạy
     */
    public function getTopProducts(int $year = null, int $limit = 10): array
    {
        $year = $year ?? Carbon::now()->year;

        $topProducts = DB::table('order_details')
            ->join('orders', 'order_details.order_id', '=', 'orders.id')
            ->join('products', 'order_details.product_id', '=', 'products.id')
            ->selectRaw('
                products.id,
                products.name,
                products.sku,
                SUM(order_details.quantity) as total_quantity,
                SUM(order_details.total_price) as total_revenue,
                AVG(order_details.unit_price) as avg_price
            ')
            ->whereYear('orders.created_at', $year)
            ->whereIn('orders.status', self::SUCCESS_STATUSES)
            ->groupBy('products.id', 'products.name', 'products.sku')
            ->orderByDesc('total_revenue')
            ->limit($limit)
            ->get();

        // Lấy thêm thông tin hình ảnh từ relationship (tối ưu để tránh N+1 query)
        $productIds = $topProducts->pluck('id')->toArray();
        $productsWithImages = \App\Models\Product::with(['primaryImage', 'baseImage', 'images'])
            ->whereIn('id', $productIds)
            ->get()
            ->keyBy('id');

        $result = [];
        foreach ($topProducts as $product) {
            $productModel = $productsWithImages->get($product->id);

            // Lấy hình ảnh theo thứ tự ưu tiên: primaryImage -> baseImage -> first image -> null
            $image = null;
            if ($productModel) {
                if ($productModel->primaryImage) {
                    $image = $productModel->primaryImage->url;
                } elseif ($productModel->baseImage) {
                    $image = $productModel->baseImage->url;
                } elseif ($productModel->images->count() > 0) {
                    $image = $productModel->images->first()->url;
                }
            }

            $result[] = (object)[
                'id' => $product->id,
                'name' => $product->name,
                'sku' => $product->sku,
                'image' => $image,
                'total_quantity' => (int)$product->total_quantity,
                'total_revenue' => (float)$product->total_revenue,
                'avg_price' => (float)$product->avg_price,
            ];
        }

        return $result;
    }

    /**
     * Lấy thống kê tổng quan
     */
    public function getOverviewStats(int $year = null): array
    {
        $year = $year ?? Carbon::now()->year;
        $currentMonth = Carbon::now()->month;
        $previousYear = $year - 1;

        // Thống kê năm hiện tại
        $currentYearStats = Order::selectRaw('
                COUNT(*) as total_orders,
                SUM(total_amount) as total_revenue,
                AVG(total_amount) as avg_order_value
            ')
            ->whereYear('created_at', $year)
            ->whereIn('status', self::SUCCESS_STATUSES)
            ->first();

        // Thống kê năm trước
        $previousYearStats = Order::selectRaw('
                COUNT(*) as total_orders,
                SUM(total_amount) as total_revenue,
                AVG(total_amount) as avg_order_value
            ')
            ->whereYear('created_at', $previousYear)
            ->whereIn('status', self::SUCCESS_STATUSES)
            ->first();

        // Thống kê tháng hiện tại
        $currentMonthStats = Order::selectRaw('
                COUNT(*) as total_orders,
                SUM(total_amount) as total_revenue
            ')
            ->whereYear('created_at', $year)
            ->whereMonth('created_at', $currentMonth)
            ->whereIn('status', self::SUCCESS_STATUSES)
            ->first();

        // Tính tỷ lệ tăng trưởng
        $revenueGrowth = $previousYearStats && $previousYearStats->total_revenue > 0
            ? (($currentYearStats->total_revenue - $previousYearStats->total_revenue) / $previousYearStats->total_revenue) * 100
            : 0;

        $ordersGrowth = $previousYearStats && $previousYearStats->total_orders > 0
            ? (($currentYearStats->total_orders - $previousYearStats->total_orders) / $previousYearStats->total_orders) * 100
            : 0;

        return [
            'current_year' => [
                'total_orders' => (int)$currentYearStats->total_orders,
                'total_revenue' => (float)$currentYearStats->total_revenue,
                'avg_order_value' => (float)$currentYearStats->avg_order_value,
            ],
            'previous_year' => [
                'total_orders' => $previousYearStats ? (int)$previousYearStats->total_orders : 0,
                'total_revenue' => $previousYearStats ? (float)$previousYearStats->total_revenue : 0,
                'avg_order_value' => $previousYearStats ? (float)$previousYearStats->avg_order_value : 0,
            ],
            'current_month' => [
                'total_orders' => (int)$currentMonthStats->total_orders,
                'total_revenue' => (float)$currentMonthStats->total_revenue,
            ],
            'growth' => [
                'revenue_growth' => round($revenueGrowth, 2),
                'orders_growth' => round($ordersGrowth, 2),
            ],
            'year' => $year,
        ];
    }

    /**
     * Lấy doanh thu theo khoảng thời gian tùy chỉnh
     */
    public function getRevenueByDateRange(string $startDate, string $endDate): array
    {
        $start = Carbon::parse($startDate);
        $end = Carbon::parse($endDate);

        $data = Order::selectRaw('
                DATE(created_at) as date,
                COUNT(*) as total_orders,
                SUM(total_amount) as total_revenue,
                AVG(total_amount) as avg_order_value
            ')
            ->whereBetween('created_at', [$start, $end])
            ->whereIn('status', self::SUCCESS_STATUSES)
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        return [
            'data' => $data->toArray(),
            'summary' => [
                'total_orders' => $data->sum('total_orders'),
                'total_revenue' => $data->sum('total_revenue'),
                'avg_order_value' => $data->avg('avg_order_value'),
                'period' => [
                    'start' => $start->format('Y-m-d'),
                    'end' => $end->format('Y-m-d'),
                    'days' => $start->diffInDays($end) + 1,
                ]
            ]
        ];
    }

    /**
     * Lấy danh sách các năm có dữ liệu
     */
    public function getAvailableYears(): array
    {
        return Order::selectRaw('DISTINCT YEAR(created_at) as year')
            ->whereIn('status', self::SUCCESS_STATUSES)
            ->orderByDesc('year')
            ->pluck('year')
            ->toArray();
    }

        /**
     * Export data cho Excel theo năm
     */
    public function getExportData(int $year = null): array
    {
        $year = $year ?? Carbon::now()->year;

        return [
            'overview' => $this->getOverviewStats($year),
            'monthly' => $this->getMonthlyRevenue($year),
            'quarterly' => $this->getQuarterlyRevenue($year),
            'top_products' => $this->getTopProducts($year, 20),
            'export_info' => [
                'year' => $year,
                'exported_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'exported_by' => auth()->user()->name ?? 'System',
            ]
        ];
    }

    /**
     * Export data cho Excel theo khoảng thời gian
     */
    public function getExportDataByDateRange(string $startDate, string $endDate): array
    {
        $start = Carbon::parse($startDate);
        $end = Carbon::parse($endDate);

        // Lấy dữ liệu theo ngày
        $dailyData = $this->getRevenueByDateRange($startDate, $endDate);

        // Lấy top sản phẩm trong khoảng thời gian
        $topProducts = $this->getTopProductsByDateRange($startDate, $endDate, 20);

        // Thống kê tổng quan
        $overviewStats = Order::selectRaw('
                COUNT(*) as total_orders,
                SUM(total_amount) as total_revenue,
                AVG(total_amount) as avg_order_value,
                MIN(total_amount) as min_order_value,
                MAX(total_amount) as max_order_value
            ')
            ->whereBetween('created_at', [$start, $end])
            ->whereIn('status', self::SUCCESS_STATUSES)
            ->first();

        return [
            'daily_data' => $dailyData['data'],
            'summary' => $dailyData['summary'],
            'overview' => $overviewStats,
            'top_products' => $topProducts,
            'export_info' => [
                'start_date' => $start->format('Y-m-d'),
                'end_date' => $end->format('Y-m-d'),
                'period_text' => $start->format('d/m/Y') . ' - ' . $end->format('d/m/Y'),
                'exported_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'exported_by' => auth()->user()->name ?? 'System',
            ]
        ];
    }

    /**
     * Lấy top sản phẩm theo khoảng thời gian
     */
    private function getTopProductsByDateRange(string $startDate, string $endDate, int $limit = 10): array
    {
        $start = Carbon::parse($startDate);
        $end = Carbon::parse($endDate);

        return DB::table('order_details')
            ->join('orders', 'order_details.order_id', '=', 'orders.id')
            ->join('products', 'order_details.product_id', '=', 'products.id')
            ->select(
                'products.name',
                'products.sku',
                DB::raw('SUM(order_details.quantity) as total_quantity'),
                DB::raw('SUM(order_details.total_price) as total_revenue'),
                DB::raw('AVG(order_details.unit_price) as avg_price')
            )
            ->whereBetween('orders.created_at', [$start, $end])
            ->whereIn('orders.status', self::SUCCESS_STATUSES)
            ->groupBy('products.id', 'products.name', 'products.sku')
            ->orderByDesc('total_revenue')
            ->limit($limit)
            ->get()
            ->toArray();
    }
}
