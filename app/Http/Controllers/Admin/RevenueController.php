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
        try {
            // Kiểm tra loại export
            $exportType = $request->get('export_type', 'year');
            
            if ($exportType === 'date_range') {
                return $this->exportByDateRange($request);
            } else {
                return $this->exportByYear($request);
            }
        } catch (\Exception $e) {
            return back()->with('error', 'Lỗi xuất Excel: ' . $e->getMessage());
        }
    }

    /**
     * Xuất Excel theo năm
     */
    private function exportByYear(Request $request)
    {
        $year = $request->get('year', Carbon::now()->year);
        $data = $this->revenueService->getExportData($year);
        $filename = "doanh_thu_{$year}_" . Carbon::now()->format('Y_m_d_H_i_s') . '.xls';
        
        return $this->generateExcel($data, $filename, 'year');
    }

    /**
     * Xuất Excel theo khoảng thời gian
     */
    private function exportByDateRange(Request $request)
    {
        $validated = $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        $data = $this->revenueService->getExportDataByDateRange(
            $validated['start_date'],
            $validated['end_date']
        );

        $startDate = Carbon::parse($validated['start_date'])->format('Y_m_d');
        $endDate = Carbon::parse($validated['end_date'])->format('Y_m_d');
        $filename = "doanh_thu_{$startDate}_den_{$endDate}_" . Carbon::now()->format('Y_m_d_H_i_s') . '.xls';

        return $this->generateExcel($data, $filename, 'date_range');
    }

    /**
     * Tạo file Excel với HTML formatting
     */
    private function generateExcel(array $data, string $filename, string $type = 'year')
    {
        // Đổi extension thành .xls để Excel nhận diện
        $filename = str_replace('.csv', '.xls', $filename);
        
        // Tạo HTML content
        $html = $this->generateExcelHTML($data, $type);
        
        return response($html)
            ->header('Content-Type', 'application/vnd.ms-excel; charset=UTF-8')
            ->header('Content-Disposition', 'attachment; filename="' . $filename . '"')
            ->header('Pragma', 'no-cache')
            ->header('Cache-Control', 'must-revalidate, post-check=0, pre-check=0')
            ->header('Expires', '0');
    }

    /**
     * Tạo HTML content cho Excel với styling đẹp
     */
    private function generateExcelHTML(array $data, string $type = 'year'): string
    {
        $styles = $this->getExcelStyles();
        
        if ($type === 'date_range') {
            return $this->generateDateRangeHTML($data, $styles);
        } else {
            return $this->generateYearlyHTML($data, $styles);
        }
    }

    /**
     * CSS Styles cho Excel
     */
    private function getExcelStyles(): string
    {
        return '
        <style>
            body { 
                font-family: Arial, sans-serif; 
                font-size: 12px; 
                margin: 20px;
                background-color: #f8f9fa;
            }
            .header { 
                background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                color: white; 
                padding: 20px; 
                text-align: center; 
                border-radius: 8px;
                margin-bottom: 20px;
                box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            }
            .header h1 { 
                margin: 0; 
                font-size: 24px; 
                font-weight: bold;
            }
            .header p { 
                margin: 5px 0 0 0; 
                opacity: 0.9;
            }
            .section { 
                background: white; 
                margin: 20px 0; 
                border-radius: 8px;
                box-shadow: 0 2px 4px rgba(0,0,0,0.1);
                overflow: hidden;
            }
            .section-title { 
                background: #4f46e5; 
                color: white; 
                padding: 15px 20px; 
                margin: 0; 
                font-size: 16px; 
                font-weight: bold;
            }
            table { 
                width: 100%; 
                border-collapse: collapse; 
                margin: 0;
            }
            th { 
                background: #f1f5f9; 
                color: #1e293b; 
                padding: 12px 15px; 
                text-align: left; 
                font-weight: bold;
                border-bottom: 2px solid #e2e8f0;
            }
            td { 
                padding: 10px 15px; 
                border-bottom: 1px solid #f1f5f9;
            }
            tr:nth-child(even) { 
                background-color: #f8fafc; 
            }
            tr:hover { 
                background-color: #e2e8f0; 
            }
            .number { 
                text-align: right; 
                font-weight: 500;
            }
            .growth-positive { 
                color: #059669; 
                font-weight: bold;
            }
            .growth-negative { 
                color: #dc2626; 
                font-weight: bold;
            }
            .summary-card {
                background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
                color: white;
                padding: 15px;
                border-radius: 8px;
                margin: 10px 0;
            }
            .rank-1 { background-color: #fef3c7; }
            .rank-2 { background-color: #e0e7ff; }
            .rank-3 { background-color: #fce7f3; }
        </style>';
    }

    /**
     * Generate HTML cho export theo năm
     */
    private function generateYearlyHTML(array $data, string $styles): string
    {
        $year = $data['export_info']['year'];
        $exportedAt = $data['export_info']['exported_at'];
        $exportedBy = $data['export_info']['exported_by'];

        $html = '<!DOCTYPE html>
        <html>
        <head>
            <meta charset="UTF-8">
            <title>Báo cáo Doanh thu ' . $year . '</title>
            ' . $styles . '
        </head>
        <body>
            <div class="header">
                <h1>📊 BÁO CÁO DOANH THU NĂM ' . $year . '</h1>
                <p><strong>📅 Xuất lúc:</strong> ' . $exportedAt . '</p>
                <p><strong>👤 Người xuất:</strong> ' . $exportedBy . '</p>
            </div>

            <div class="section">
                <h2 class="section-title">📈 TỔNG QUAN DOANH THU</h2>
                <table>
                    <thead>
                        <tr>
                            <th>Chỉ số</th>
                            <th class="number">Năm ' . $year . '</th>
                            <th class="number">Năm ' . ($year - 1) . '</th>
                            <th class="number">Tăng trưởng</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><strong>🛍️ Tổng đơn hàng</strong></td>
                            <td class="number">' . number_format($data['overview']['current_year']['total_orders']) . '</td>
                            <td class="number">' . number_format($data['overview']['previous_year']['total_orders']) . '</td>
                            <td class="number ' . ($data['overview']['growth']['orders_growth'] >= 0 ? 'growth-positive' : 'growth-negative') . '">
                                ' . ($data['overview']['growth']['orders_growth'] >= 0 ? '↗️' : '↘️') . ' ' . abs($data['overview']['growth']['orders_growth']) . '%
                            </td>
                        </tr>
                        <tr>
                            <td><strong>💰 Tổng doanh thu</strong></td>
                            <td class="number">' . number_format($data['overview']['current_year']['total_revenue']) . ' VNĐ</td>
                            <td class="number">' . number_format($data['overview']['previous_year']['total_revenue']) . ' VNĐ</td>
                            <td class="number ' . ($data['overview']['growth']['revenue_growth'] >= 0 ? 'growth-positive' : 'growth-negative') . '">
                                ' . ($data['overview']['growth']['revenue_growth'] >= 0 ? '↗️' : '↘️') . ' ' . abs($data['overview']['growth']['revenue_growth']) . '%
                            </td>
                        </tr>
                        <tr>
                            <td><strong>📊 Giá trị đơn hàng TB</strong></td>
                            <td class="number">' . number_format($data['overview']['current_year']['avg_order_value']) . ' VNĐ</td>
                            <td class="number">' . number_format($data['overview']['previous_year']['avg_order_value']) . ' VNĐ</td>
                            <td class="number">-</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="section">
                <h2 class="section-title">📅 DOANH THU THEO THÁNG</h2>
                <table>
                    <thead>
                        <tr>
                            <th>Tháng</th>
                            <th class="number">Số đơn hàng</th>
                            <th class="number">Doanh thu (VNĐ)</th>
                            <th class="number">Giá trị TB/đơn (VNĐ)</th>
                        </tr>
                    </thead>
                    <tbody>';

        foreach ($data['monthly'] as $month) {
            $html .= '<tr>
                <td><strong>' . $month['month_full_name'] . '</strong></td>
                <td class="number">' . number_format($month['total_orders']) . '</td>
                <td class="number">' . number_format($month['total_revenue']) . '</td>
                <td class="number">' . number_format($month['avg_order_value']) . '</td>
            </tr>';
        }

        $html .= '</tbody>
                </table>
            </div>

            <div class="section">
                <h2 class="section-title">🏆 TOP SẢN PHẨM BÁN CHẠY</h2>
                <table>
                    <thead>
                        <tr>
                            <th>Hạng</th>
                            <th>Tên sản phẩm</th>
                            <th class="number">Số lượng bán</th>
                            <th class="number">Doanh thu (VNĐ)</th>
                            <th class="number">Giá TB (VNĐ)</th>
                        </tr>
                    </thead>
                    <tbody>';

        $index = 1;
        foreach ($data['top_products'] as $product) {
            $rankClass = '';
            $rankIcon = '';
            if ($index == 1) { $rankClass = 'rank-1'; $rankIcon = '🥇'; }
            elseif ($index == 2) { $rankClass = 'rank-2'; $rankIcon = '🥈'; }
            elseif ($index == 3) { $rankClass = 'rank-3'; $rankIcon = '🥉'; }
            else { $rankIcon = '#' . $index; }

            $html .= '<tr class="' . $rankClass . '">
                <td><strong>' . $rankIcon . '</strong></td>
                <td>' . htmlspecialchars($product->name) . '</td>
                <td class="number">' . number_format($product->total_quantity) . '</td>
                <td class="number">' . number_format($product->total_revenue) . '</td>
                <td class="number">' . number_format($product->avg_price) . '</td>
            </tr>';
            $index++;
        }

        $html .= '</tbody>
                </table>
            </div>
        </body>
        </html>';

        return $html;
    }

    /**
     * Generate HTML cho export theo khoảng thời gian
     */
    private function generateDateRangeHTML(array $data, string $styles): string
    {
        $periodText = $data['export_info']['period_text'];
        $exportedAt = $data['export_info']['exported_at'];
        $exportedBy = $data['export_info']['exported_by'];

        $html = '<!DOCTYPE html>
        <html>
        <head>
            <meta charset="UTF-8">
            <title>Báo cáo Doanh thu ' . $periodText . '</title>
            ' . $styles . '
        </head>
        <body>
            <div class="header">
                <h1>📊 BÁO CÁO DOANH THU THEO THỜI GIAN</h1>
                <p><strong>📅 Khoảng thời gian:</strong> ' . $periodText . '</p>
                <p><strong>⏰ Xuất lúc:</strong> ' . $exportedAt . '</p>
                <p><strong>👤 Người xuất:</strong> ' . $exportedBy . '</p>
            </div>

            <div class="section">
                <h2 class="section-title">📈 TỔNG QUAN</h2>
                <table>
                    <thead>
                        <tr>
                            <th>Chỉ số</th>
                            <th class="number">Giá trị</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><strong>🛍️ Tổng đơn hàng</strong></td>
                            <td class="number">' . number_format($data['overview']->total_orders ?? 0) . '</td>
                        </tr>
                        <tr>
                            <td><strong>💰 Tổng doanh thu</strong></td>
                            <td class="number">' . number_format($data['overview']->total_revenue ?? 0) . ' VNĐ</td>
                        </tr>
                        <tr>
                            <td><strong>📊 Giá trị đơn hàng TB</strong></td>
                            <td class="number">' . number_format($data['overview']->avg_order_value ?? 0) . ' VNĐ</td>
                        </tr>
                        <tr>
                            <td><strong>📉 Đơn hàng thấp nhất</strong></td>
                            <td class="number">' . number_format($data['overview']->min_order_value ?? 0) . ' VNĐ</td>
                        </tr>
                        <tr>
                            <td><strong>📈 Đơn hàng cao nhất</strong></td>
                            <td class="number">' . number_format($data['overview']->max_order_value ?? 0) . ' VNĐ</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="section">
                <h2 class="section-title">📅 DOANH THU THEO NGÀY</h2>
                <table>
                    <thead>
                        <tr>
                            <th>Ngày</th>
                            <th class="number">Số đơn hàng</th>
                            <th class="number">Doanh thu (VNĐ)</th>
                            <th class="number">Giá trị TB/đơn (VNĐ)</th>
                        </tr>
                    </thead>
                    <tbody>';

        foreach ($data['daily_data'] as $day) {
            $html .= '<tr>
                <td><strong>' . Carbon::parse($day['date'])->format('d/m/Y') . '</strong></td>
                <td class="number">' . number_format($day['total_orders']) . '</td>
                <td class="number">' . number_format($day['total_revenue']) . '</td>
                <td class="number">' . number_format($day['avg_order_value']) . '</td>
            </tr>';
        }

        $html .= '</tbody>
                </table>
            </div>

            <div class="section">
                <h2 class="section-title">🏆 TOP SẢN PHẨM BÁN CHẠY</h2>
                <table>
                    <thead>
                        <tr>
                            <th>Hạng</th>
                            <th>Tên sản phẩm</th>
                            <th>SKU</th>
                            <th class="number">Số lượng bán</th>
                            <th class="number">Doanh thu (VNĐ)</th>
                            <th class="number">Giá TB (VNĐ)</th>
                        </tr>
                    </thead>
                    <tbody>';

        $index = 1;
        foreach ($data['top_products'] as $product) {
            $rankClass = '';
            $rankIcon = '';
            if ($index == 1) { $rankClass = 'rank-1'; $rankIcon = '🥇'; }
            elseif ($index == 2) { $rankClass = 'rank-2'; $rankIcon = '🥈'; }
            elseif ($index == 3) { $rankClass = 'rank-3'; $rankIcon = '🥉'; }
            else { $rankIcon = '#' . $index; }

            $html .= '<tr class="' . $rankClass . '">
                <td><strong>' . $rankIcon . '</strong></td>
                <td>' . htmlspecialchars($product['name']) . '</td>
                <td>' . htmlspecialchars($product['sku']) . '</td>
                <td class="number">' . number_format($product['total_quantity']) . '</td>
                <td class="number">' . number_format($product['total_revenue']) . '</td>
                <td class="number">' . number_format($product['avg_price']) . '</td>
            </tr>';
            $index++;
        }

        $html .= '</tbody>
                </table>
            </div>
        </body>
        </html>';

        return $html;
    }
}
