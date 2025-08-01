<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hóa đơn #{{ $order->order_number }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'DejaVu Sans', Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            background: white;
        }
        
        .invoice-container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }
        
        .header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 30px;
            border-bottom: 2px solid #007bff;
            padding-bottom: 20px;
        }
        
        .company-info h1 {
            color: #007bff;
            font-size: 24px;
            margin-bottom: 10px;
        }
        
        .company-info p {
            margin: 5px 0;
            color: #666;
        }
        
        .invoice-info {
            text-align: right;
        }
        
        .invoice-info h2 {
            color: #333;
            font-size: 20px;
            margin-bottom: 10px;
        }
        
        .invoice-details {
            display: flex;
            justify-content: space-between;
            margin: 30px 0;
        }
        
        .bill-to, .invoice-meta {
            width: 48%;
        }
        
        .bill-to h3, .invoice-meta h3 {
            color: #007bff;
            margin-bottom: 15px;
            font-size: 16px;
            border-bottom: 1px solid #eee;
            padding-bottom: 5px;
        }
        
        .bill-to p, .invoice-meta p {
            margin: 8px 0;
        }
        
        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin: 30px 0;
        }
        
        .items-table th {
            background-color: #007bff;
            color: white;
            padding: 12px;
            text-align: left;
            font-weight: bold;
        }
        
        .items-table td {
            padding: 12px;
            border-bottom: 1px solid #eee;
        }
        
        .items-table tr:nth-child(even) {
            background-color: #f8f9fa;
        }
        
        .text-right {
            text-align: right;
        }
        
        .text-center {
            text-align: center;
        }
        
        .totals {
            margin-top: 20px;
            text-align: right;
        }
        
        .totals table {
            margin-left: auto;
            width: 300px;
        }
        
        .totals td {
            padding: 8px 15px;
            border-bottom: 1px solid #eee;
        }
        
        .totals .total-row {
            font-weight: bold;
            font-size: 18px;
            background-color: #007bff;
            color: white;
        }
        
        .footer {
            margin-top: 50px;
            padding-top: 20px;
            border-top: 1px solid #eee;
            text-align: center;
            color: #666;
            font-size: 14px;
        }
        
        .status-badge {
            display: inline-block;
            padding: 5px 10px;
            border-radius: 15px;
            font-size: 12px;
            font-weight: bold;
            text-transform: uppercase;
        }
        
        .status-pending { background-color: #fff3cd; color: #856404; }
        .status-processing { background-color: #d1ecf1; color: #0c5460; }
        .status-shipped { background-color: #e2e3f1; color: #383d41; }
        .status-delivered { background-color: #d4edda; color: #155724; }
        .status-cancelled { background-color: #f8d7da; color: #721c24; }
        
        @media print {
            body { -webkit-print-color-adjust: exact; }
            .no-print { display: none; }
        }
    </style>
</head>
<body>
    <div class="invoice-container">
        <!-- Print Button -->
        <div class="no-print" style="text-align: right; margin-bottom: 20px;">
            <button onclick="window.print()" style="background: #007bff; color: white; padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer;">
                In hóa đơn
            </button>
        </div>

        <!-- Header -->
        <div class="header">
            <div class="company-info">
                <h1>SUPERWIN</h1>
                <p><strong>Địa chỉ:</strong> 123 Đường ABC, Quận XYZ, TP. Hồ Chí Minh</p>
                <p><strong>Điện thoại:</strong> (028) 1234 5678</p>
                <p><strong>Email:</strong> info@superwin.vn</p>
                <p><strong>Website:</strong> www.superwin.vn</p>
            </div>
            <div class="invoice-info">
                <h2>HÓA ĐƠN</h2>
                <p><strong>Số:</strong> #{{ $order->order_number }}</p>
                <p><strong>Ngày:</strong> {{ $order->created_at->format('d/m/Y') }}</p>
                <div class="status-badge status-{{ $order->status }}">
                    @switch($order->status)
                        @case('pending') Chờ xử lý @break
                        @case('processing') Đang xử lý @break
                        @case('shipped') Đã gửi hàng @break
                        @case('delivered') Đã giao hàng @break
                        @case('cancelled') Đã hủy @break
                        @default {{ $order->status }}
                    @endswitch
                </div>
            </div>
        </div>

        <!-- Invoice Details -->
        <div class="invoice-details">
            <div class="bill-to">
                <h3>THÔNG TIN KHÁCH HÀNG</h3>
                <p><strong>Tên:</strong> {{ $order->customer->name ?? $order->customer_name ?? 'N/A' }}</p>
                <p><strong>Email:</strong> {{ $order->customer->email ?? $order->customer_email ?? 'N/A' }}</p>
                <p><strong>Điện thoại:</strong> {{ $order->phone ?? 'N/A' }}</p>
                <p><strong>Địa chỉ giao hàng:</strong></p>
                <p>{{ $order->shipping_address ?? 'N/A' }}</p>
            </div>
            <div class="invoice-meta">
                <h3>THÔNG TIN ĐỚN HÀNG</h3>
                <p><strong>Mã đơn hàng:</strong> #{{ $order->order_number }}</p>
                <p><strong>Ngày đặt:</strong> {{ $order->created_at->format('d/m/Y H:i') }}</p>
                <p><strong>Phương thức thanh toán:</strong> {{ $order->payment_method ?? 'N/A' }}</p>
                <p><strong>Số lượng sản phẩm:</strong> {{ $order->orderDetails->sum('quantity') }}</p>
                @if($order->admin_note)
                <p><strong>Ghi chú:</strong> {{ $order->admin_note }}</p>
                @endif
            </div>
        </div>

        <!-- Items Table -->
        <table class="items-table">
            <thead>
                <tr>
                    <th>STT</th>
                    <th>Sản phẩm</th>
                    <th>SKU</th>
                    <th class="text-center">Số lượng</th>
                    <th class="text-right">Đơn giá</th>
                    <th class="text-right">Thành tiền</th>
                </tr>
            </thead>
            <tbody>
                @foreach($order->orderDetails as $index => $detail)
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td>
                        <strong>{{ $detail->product_name }}</strong>
                        @if($detail->product && $detail->product->category)
                            <br><small style="color: #666;">{{ $detail->product->category->name }}</small>
                        @endif
                    </td>
                    <td>{{ $detail->product->sku ?? 'N/A' }}</td>
                    <td class="text-center">{{ $detail->quantity }}</td>
                    <td class="text-right">{{ number_format($detail->unit_price) }} VNĐ</td>
                    <td class="text-right">{{ number_format($detail->total_price) }} VNĐ</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Totals -->
        <div class="totals">
            <table>
                <tr>
                    <td>Tạm tính:</td>
                    <td class="text-right">{{ number_format($order->subtotal ?? $order->orderDetails->sum('total_price')) }} VNĐ</td>
                </tr>
                @if($order->discount_amount > 0)
                <tr>
                    <td>Giảm giá:</td>
                    <td class="text-right" style="color: #28a745;">-{{ number_format($order->discount_amount) }} VNĐ</td>
                </tr>
                @endif
                @if($order->shipping_fee > 0)
                <tr>
                    <td>Phí vận chuyển:</td>
                    <td class="text-right">{{ number_format($order->shipping_fee) }} VNĐ</td>
                </tr>
                @endif
                <tr class="total-row">
                    <td>TỔNG CỘNG:</td>
                    <td class="text-right">{{ number_format($order->total_amount) }} VNĐ</td>
                </tr>
            </table>
        </div>

        <!-- Footer -->
        <div class="footer">
            <p>Cảm ơn quý khách đã tin tưởng và sử dụng sản phẩm của SUPERWIN!</p>
            <p>Mọi thắc mắc xin liên hệ: (028) 1234 5678 hoặc info@superwin.vn</p>
            <p style="margin-top: 20px; font-size: 12px;">
                Hóa đơn được in lúc: {{ now()->format('d/m/Y H:i:s') }}
            </p>
        </div>
    </div>

    <script>
        // Auto print when page loads (optional)
        // window.onload = function() { window.print(); }
    </script>
</body>
</html> 