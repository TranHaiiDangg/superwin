<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\RevenueService;
use Illuminate\Http\Request;
use Carbon\Carbon;

class RevenueController extends Controller
{
    private RevenueService $revenueService;

    public function __construct(RevenueService $revenueService)
    {
        $this->revenueService = $revenueService;
    }

    /**
     * Dashboard doanh thu
     */
    public function index(Request $request)
    {
        $year = $request->get('year', Carbon::now()->year);
        
        $data = [
            'overview' => $this->revenueService->getOverviewStats($year),
            'monthly' => $this->revenueService->getMonthlyRevenue($year),
            'quarterly' => $this->revenueService->getQuarterlyRevenue($year),
            'top_products' => $this->revenueService->getTopProducts($year, 10),
            'available_years' => $this->revenueService->getAvailableYears(),
            'current_year' => $year,
        ];

        return view('admin.revenue.index', $data);
    }

    /**
     * API lấy dữ liệu doanh thu theo tháng
     */
    public function getMonthlyData(Request $request)
    {
        $year = $request->get('year', Carbon::now()->year);
        
        try {
            $data = $this->revenueService->getMonthlyRevenue($year);
            
            return response()->json([
                'success' => true,
                'data' => $data,
                'year' => $year
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Lỗi lấy dữ liệu: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * API lấy dữ liệu theo khoảng thời gian
     */
    public function getDateRangeData(Request $request)
    {
        $validated = $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        try {
            $data = $this->revenueService->getRevenueByDateRange(
                $validated['start_date'],
                $validated['end_date']
            );
            
            return response()->json([
                'success' => true,
                'data' => $data
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Lỗi lấy dữ liệu: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Xuất Excel
     */
    public function exportExcel(Request $request)
    {
        $year = $request->get('year', Carbon::now()->year);
        
        try {
            $data = $this->revenueService->getExportData($year);
            
            // Tạo filename
            $filename = "doanh_thu_{$year}_" . Carbon::now()->format('Y_m_d_H_i_s') . '.xlsx';
            
            return $this->generateExcel($data, $filename);
            
        } catch (\Exception $e) {
            return back()->with('error', 'Lỗi xuất Excel: ' . $e->getMessage());
        }
    }

    /**
     * Tạo file Excel
     */
    private function generateExcel(array $data, string $filename)
    {
        // Tạo spreadsheet đơn giản bằng HTML table
        $html = $this->generateExcelHTML($data);
        
        return response($html)
            ->header('Content-Type', 'application/vnd.ms-excel; charset=UTF-8')
            ->header('Content-Disposition', "attachment; filename=\"{$filename}\"")
            ->header('Pragma', 'no-cache')
            ->header('Cache-Control', 'must-revalidate, post-check=0, pre-check=0')
            ->header('Expires', '0');
    }

    /**
     * Tạo HTML cho Excel
     */
    private function generateExcelHTML(array $data): string
    {
        $year = $data['export_info']['year'];
        $exportedAt = $data['export_info']['exported_at'];
        $exportedBy = $data['export_info']['exported_by'];

        $html = '
        <html>
        <head>
            <meta charset="UTF-8">
            <title>Báo cáo Doanh thu ' . $year . '</title>
        </head>
        <body>
            <h1>BÁO CÁO DOANH THU NĂM ' . $year . '</h1>
            <p><strong>Xuất lúc:</strong> ' . $exportedAt . '</p>
            <p><strong>Người xuất:</strong> ' . $exportedBy . '</p>
            <br>
            
            <h2>1. TỔNG QUAN</h2>
            <table border="1" cellpadding="5" cellspacing="0">
                <tr>
                    <th>Chỉ số</th>
                    <th>Năm ' . $year . '</th>
                    <th>Năm ' . ($year - 1) . '</th>
                    <th>Tăng trưởng (%)</th>
                </tr>
                <tr>
                    <td>Tổng đơn hàng</td>
                    <td>' . number_format($data['overview']['current_year']['total_orders']) . '</td>
                    <td>' . number_format($data['overview']['previous_year']['total_orders']) . '</td>
                    <td>' . $data['overview']['growth']['orders_growth'] . '%</td>
                </tr>
                <tr>
                    <td>Tổng doanh thu (VNĐ)</td>
                    <td>' . number_format($data['overview']['current_year']['total_revenue']) . '</td>
                    <td>' . number_format($data['overview']['previous_year']['total_revenue']) . '</td>
                    <td>' . $data['overview']['growth']['revenue_growth'] . '%</td>
                </tr>
                <tr>
                    <td>Giá trị đơn hàng TB (VNĐ)</td>
                    <td>' . number_format($data['overview']['current_year']['avg_order_value']) . '</td>
                    <td>' . number_format($data['overview']['previous_year']['avg_order_value']) . '</td>
                    <td>-</td>
                </tr>
            </table>
            <br>
            
            <h2>2. DOANH THU THEO THÁNG</h2>
            <table border="1" cellpadding="5" cellspacing="0">
                <tr>
                    <th>Tháng</th>
                    <th>Số đơn hàng</th>
                    <th>Doanh thu (VNĐ)</th>
                    <th>Giá trị TB/đơn (VNĐ)</th>
                </tr>';

        foreach ($data['monthly'] as $month) {
            $html .= '<tr>
                <td>' . $month['month_full_name'] . '</td>
                <td>' . number_format($month['total_orders']) . '</td>
                <td>' . number_format($month['total_revenue']) . '</td>
                <td>' . number_format($month['avg_order_value']) . '</td>
            </tr>';
        }

        $html .= '</table><br>
            
            <h2>3. DOANH THU THEO QUÝ</h2>
            <table border="1" cellpadding="5" cellspacing="0">
                <tr>
                    <th>Quý</th>
                    <th>Số đơn hàng</th>
                    <th>Doanh thu (VNĐ)</th>
                    <th>Giá trị TB/đơn (VNĐ)</th>
                </tr>';

        foreach ($data['quarterly'] as $quarter) {
            $html .= '<tr>
                <td>' . $quarter['quarter_name'] . '</td>
                <td>' . number_format($quarter['total_orders']) . '</td>
                <td>' . number_format($quarter['total_revenue']) . '</td>
                <td>' . number_format($quarter['avg_order_value']) . '</td>
            </tr>';
        }

        $html .= '</table><br>
            
            <h2>4. TOP SẢN PHẨM BÁN CHẠY</h2>
            <table border="1" cellpadding="5" cellspacing="0">
                <tr>
                    <th>STT</th>
                    <th>Tên sản phẩm</th>
                    <th>Số lượng bán</th>
                    <th>Doanh thu (VNĐ)</th>
                    <th>Giá TB (VNĐ)</th>
                </tr>';

        $index = 1;
        foreach ($data['top_products'] as $product) {
            $html .= '<tr>
                <td>' . $index++ . '</td>
                <td>' . htmlspecialchars($product->name) . '</td>
                <td>' . number_format($product->total_quantity) . '</td>
                <td>' . number_format($product->total_revenue) . '</td>
                <td>' . number_format($product->avg_price) . '</td>
            </tr>';
        }

        $html .= '</table>
        </body>
        </html>';

        return $html;
    }
}
