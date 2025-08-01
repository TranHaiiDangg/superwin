<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $query = Order::with(['customer', 'orderDetails.product']);

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('order_number', 'like', "%{$search}%")
                  ->orWhere('customer_name', 'like', "%{$search}%")
                  ->orWhere('customer_email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%")
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

        // Payment method filter
        if ($request->filled('payment_method')) {
            $query->where('payment_method', $request->payment_method);
        }

        $orders = $query->latest()->paginate(20);

        // Statistics
        $stats = [
            'total' => Order::count(),
            'pending' => Order::where('status', 'pending')->count(),
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
            'order_number' => 'required|string|max:255',
            'status' => 'required|in:pending,processing,shipped,delivered,cancelled',
            'payment_method' => 'nullable|string',
            'customer_name' => 'nullable|string|max:255',
            'customer_email' => 'nullable|email',
            'phone' => 'nullable|string|max:20',
            'shipping_address' => 'nullable|string',
            'subtotal' => 'nullable|numeric|min:0',
            'discount_amount' => 'nullable|numeric|min:0',
            'shipping_fee' => 'nullable|numeric|min:0',
            'total_amount' => 'required|numeric|min:0',
            'admin_note' => 'nullable|string',
        ]);

        $order->update($validated);

        return redirect()->route('admin.orders.index')
            ->with('success', 'Đơn hàng đã được cập nhật thành công!');
    }

    public function updateStatus(Request $request, Order $order)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,processing,shipped,delivered,cancelled',
            'admin_note' => 'nullable|string',
        ]);

        $oldStatus = $order->status;
        $order->update($validated);

        // Log status change
        $statusNames = [
            'pending' => 'Chờ xử lý',
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
        // Export functionality can be implemented here
        // For now, just redirect back
        return redirect()->route('admin.orders.index')
            ->with('info', 'Chức năng xuất dữ liệu đang được phát triển');
    }
} 