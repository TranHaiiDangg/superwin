<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Carbon\Carbon;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $query = Order::with(['customer', 'orderDetails.product']);

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('order_code', 'like', "%{$search}%")
                  ->orWhere('customer_name', 'like', "%{$search}%")
                  ->orWhere('customer_email', 'like', "%{$search}%")
                  ->orWhere('customer_phone', 'like', "%{$search}%")
                  ->orWhereHas('customer', function ($customerQuery) use ($search) {
                      $customerQuery->where('name', 'like', "%{$search}%")
                                   ->orWhere('email', 'like', "%{$search}%")
                                   ->orWhere('phone', 'like', "%{$search}%");
                  });
            });
        }

        // Status filter
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Date range filter
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        // Payment method filter (chỉ COD hiện tại)
        if ($request->filled('payment_method')) {
            $query->where('payment_method', $request->payment_method);
        }

        $orders = $query->latest()->paginate(20);

        // Statistics
        $stats = [
            'total' => Order::count(),
            'pending' => Order::where('status', 'pending')->count(),
            'confirmed' => Order::where('status', 'confirmed')->count(),
            'processing' => Order::where('status', 'processing')->count(),
            'shipped' => Order::where('status', 'shipped')->count(),
            'delivered' => Order::where('status', 'delivered')->count(),
            'cancelled' => Order::where('status', 'cancelled')->count(),
            'today_revenue' => Order::whereDate('created_at', today())
                                   ->where('status', '!=', 'cancelled')
                                   ->sum('total_amount'),
            'month_revenue' => Order::whereMonth('created_at', now()->month)
                                   ->whereYear('created_at', now()->year)
                                   ->where('status', '!=', 'cancelled')
                                   ->sum('total_amount'),
        ];

        return view('admin.orders.index', compact('orders', 'stats'));
    }

    public function show(Order $order)
    {
        $order->load(['customer', 'orderDetails.product.images', 'payments']);
        
        return view('admin.orders.show', compact('order'));
    }

    public function edit(Order $order)
    {
        return view('admin.orders.edit', compact('order'));
    }

    public function update(Request $request, Order $order)
    {
        $validated = $request->validate([
            'order_code' => 'required|string|max:255',
            'status' => 'required|in:pending,confirmed,processing,shipped,delivered,cancelled',
            'payment_method' => 'nullable|in:cod',
            'customer_name' => 'nullable|string|max:255',
            'customer_email' => 'nullable|email',
            'customer_phone' => 'nullable|string|max:20',
            'shipping_address' => 'nullable|string',
            'subtotal' => 'nullable|numeric|min:0',
            'discount_amount' => 'nullable|numeric|min:0',
            'shipping_fee' => 'nullable|numeric|min:0',
            'total_amount' => 'required|numeric|min:0',
            'admin_note' => 'nullable|string',
        ]);

        $order->update($validated);

        // Refresh model để đảm bảo dữ liệu mới nhất
        $order->refresh();

        return redirect()->route('admin.orders.edit', $order)
            ->with('success', 'Đơn hàng đã được cập nhật thành công!');
    }

    public function updateStatus(Request $request, Order $order)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,confirmed,processing,shipped,delivered,cancelled',
            'admin_note' => 'nullable|string',
        ]);

        $oldStatus = $order->status;
        $order->update($validated);

        // Log status change
        $statusNames = [
            'pending' => 'Chờ xử lý',
            'confirmed' => 'Đã xác nhận',
            'processing' => 'Đang xử lý',
            'shipped' => 'Đã gửi hàng',
            'delivered' => 'Đã giao hàng',
            'cancelled' => 'Đã hủy'
        ];

        $message = "Trạng thái đơn hàng đã được cập nhật từ '{$statusNames[$oldStatus]}' thành '{$statusNames[$validated['status']]}'";

        return redirect()->route('admin.orders.show', $order)
            ->with('success', $message);
    }

    public function printInvoice(Order $order)
    {
        $order->load(['customer', 'orderDetails.product']);
        return view('admin.orders.invoice', compact('order'));
    }

    public function exportOrders(Request $request)
    {
        try {
            // Xác định loại export
            $exportType = $request->get('export_type', 'today');
            
            if ($exportType === 'date_range') {
                $validated = $request->validate([
                    'start_date' => 'required|date',
                    'end_date' => 'required|date|after_or_equal:start_date',
                ]);
                
                $startDate = Carbon::parse($validated['start_date']);
                $endDate = Carbon::parse($validated['end_date']);
                
                $orders = Order::whereBetween('created_at', [$startDate->startOfDay(), $endDate->endOfDay()])
                    ->orderBy('created_at', 'desc')
                    ->get();
                
                $fileName = 'don_hang_' . $startDate->format('Y_m_d') . '_den_' . $endDate->format('Y_m_d') . '.xls';
                $periodText = $startDate->format('d/m/Y') . ' - ' . $endDate->format('d/m/Y');
            } else {
                // Export hôm nay (mặc định)
                $today = now();
                $orders = Order::whereDate('created_at', $today)
                    ->orderBy('created_at', 'desc')
                    ->get();
                
                $fileName = 'don_hang_' . $today->format('Y_m_d') . '.xls';
                $periodText = 'Ngày ' . $today->format('d/m/Y');
            }

            // Tạo HTML content
            $html = $this->generateOrderExcelHTML($orders, $periodText);
            
            return response($html)
                ->header('Content-Type', 'application/vnd.ms-excel; charset=UTF-8')
                ->header('Content-Disposition', 'attachment; filename="' . $fileName . '"')
                ->header('Pragma', 'no-cache')
                ->header('Cache-Control', 'must-revalidate, post-check=0, pre-check=0')
                ->header('Expires', '0');
                
        } catch (\Exception $e) {
            return back()->with('error', 'Lỗi xuất Excel: ' . $e->getMessage());
        }
    }

    private function getStatusName($status)
    {
        $statusNames = [
            'pending' => 'Chờ xử lý',
            'confirmed' => 'Đã xác nhận', 
            'processing' => 'Đang xử lý',
            'shipped' => 'Đã gửi hàng',
            'delivered' => 'Đã giao hàng',
            'cancelled' => 'Đã hủy',
            'returned' => 'Đã trả hàng'
        ];

        return $statusNames[$status] ?? $status;
    }

    private function generateOrderExcelHTML($orders, $periodText)
    {
        $totalOrders = $orders->count();
        $totalAmount = $orders->sum('total_amount');
        $avgAmount = $totalOrders > 0 ? $totalAmount / $totalOrders : 0;
        
        // Thống kê theo trạng thái
        $statusStats = [];
        foreach ($orders->groupBy('status') as $status => $statusOrders) {
            $statusStats[$status] = [
                'count' => $statusOrders->count(),
                'amount' => $statusOrders->sum('total_amount')
            ];
        }

        $styles = '
        <style>
            body { 
                font-family: Arial, sans-serif; 
                font-size: 12px; 
                margin: 20px;
                background-color: #f8f9fa;
            }
            .header { 
                background: linear-gradient(135deg, #10b981 0%, #059669 100%);
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
                background: #059669; 
                color: white; 
                padding: 15px 20px; 
                margin: 0; 
                font-size: 16px; 
                font-weight: bold;
            }
            .stats-grid {
                display: grid;
                grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
                gap: 15px;
                padding: 20px;
                background: #f8fafc;
            }
            .stat-card {
                background: white;
                padding: 15px;
                border-radius: 8px;
                text-align: center;
                border: 1px solid #e2e8f0;
            }
            .stat-number {
                font-size: 24px;
                font-weight: bold;
                color: #059669;
            }
            .stat-label {
                color: #64748b;
                font-size: 12px;
                margin-top: 5px;
            }
            table { 
                width: 100%; 
                border-collapse: collapse; 
                margin: 0;
            }
            th { 
                background: #f1f5f9; 
                color: #1e293b; 
                padding: 12px 8px; 
                text-align: left; 
                font-weight: bold;
                border-bottom: 2px solid #e2e8f0;
                font-size: 11px;
            }
            td { 
                padding: 10px 8px; 
                border-bottom: 1px solid #f1f5f9;
                font-size: 11px;
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
            .status-pending { color: #f59e0b; font-weight: bold; }
            .status-confirmed { color: #3b82f6; font-weight: bold; }
            .status-processing { color: #8b5cf6; font-weight: bold; }
            .status-shipped { color: #06b6d4; font-weight: bold; }
            .status-delivered { color: #10b981; font-weight: bold; }
            .status-cancelled { color: #ef4444; font-weight: bold; }
            .status-returned { color: #f97316; font-weight: bold; }
            .order-code { font-weight: bold; color: #1e40af; }
        </style>';

        $html = '<!DOCTYPE html>
        <html>
        <head>
            <meta charset="UTF-8">
            <title>Báo cáo Đơn hàng - ' . $periodText . '</title>
            ' . $styles . '
        </head>
        <body>
            <div class="header">
                <h1>🛍️ BÁO CÁO ĐỚN HÀNG</h1>
                <p><strong>📅 Thời gian:</strong> ' . $periodText . '</p>
                <p><strong>⏰ Xuất lúc:</strong> ' . now()->format('d/m/Y H:i:s') . '</p>
                <p><strong>👤 Người xuất:</strong> ' . (auth()->user()->name ?? 'System') . '</p>
            </div>

            <div class="section">
                <h2 class="section-title">📊 TỔNG QUAN</h2>
                <div class="stats-grid">
                    <div class="stat-card">
                        <div class="stat-number">' . number_format($totalOrders) . '</div>
                        <div class="stat-label">Tổng đơn hàng</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-number">' . number_format($totalAmount) . '</div>
                        <div class="stat-label">Tổng doanh thu (VNĐ)</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-number">' . number_format($avgAmount) . '</div>
                        <div class="stat-label">Giá trị TB/đơn (VNĐ)</div>
                    </div>
                </div>
            </div>';

        if (!empty($statusStats)) {
            $html .= '<div class="section">
                <h2 class="section-title">📈 THỐNG KÊ THEO TRẠNG THÁI</h2>
                <table>
                    <thead>
                        <tr>
                            <th>Trạng thái</th>
                            <th class="number">Số lượng</th>
                            <th class="number">Doanh thu (VNĐ)</th>
                            <th class="number">Tỷ lệ (%)</th>
                        </tr>
                    </thead>
                    <tbody>';

            foreach ($statusStats as $status => $stats) {
                $percentage = $totalOrders > 0 ? round(($stats['count'] / $totalOrders) * 100, 1) : 0;
                $html .= '<tr>
                    <td><span class="status-' . $status . '">' . $this->getStatusName($status) . '</span></td>
                    <td class="number">' . number_format($stats['count']) . '</td>
                    <td class="number">' . number_format($stats['amount']) . '</td>
                    <td class="number">' . $percentage . '%</td>
                </tr>';
            }

            $html .= '</tbody></table></div>';
        }

        $html .= '<div class="section">
            <h2 class="section-title">📋 CHI TIẾT ĐỚN HÀNG</h2>
            <table>
                <thead>
                    <tr>
                        <th>Mã đơn hàng</th>
                        <th>Khách hàng</th>
                        <th>Số điện thoại</th>
                        <th>Email</th>
                        <th>Trạng thái</th>
                        <th>Phương thức TT</th>
                        <th class="number">Tổng tiền (VNĐ)</th>
                        <th>Ghi chú KH</th>
                        <th>Ghi chú Admin</th>
                        <th>Ngày tạo</th>
                    </tr>
                </thead>
                <tbody>';

        foreach ($orders as $order) {
            $html .= '<tr>
                <td class="order-code">' . htmlspecialchars($order->order_code) . '</td>
                <td>' . htmlspecialchars($order->customer_name) . '</td>
                <td>' . htmlspecialchars($order->customer_phone) . '</td>
                <td>' . htmlspecialchars($order->customer_email) . '</td>
                <td><span class="status-' . $order->status . '">' . $this->getStatusName($order->status) . '</span></td>
                <td>' . ($order->payment_method == 'cod' ? 'COD' : strtoupper($order->payment_method)) . '</td>
                <td class="number">' . number_format($order->total_amount) . '</td>
                <td>' . htmlspecialchars($order->customer_note ?? '') . '</td>
                <td>' . htmlspecialchars($order->admin_note ?? '') . '</td>
                <td>' . $order->created_at->format('d/m/Y H:i') . '</td>
            </tr>';
        }

        $html .= '</tbody>
            </table>
        </div>
        </body>
        </html>';

        return $html;
    }
} 