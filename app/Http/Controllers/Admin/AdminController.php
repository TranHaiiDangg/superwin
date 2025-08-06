<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminController extends Controller
{

    public function dashboard()
    {
        $user = auth()->user();
        $data = [];

        // Luôn hiển thị dashboard cơ bản
        $data['can_view_dashboard'] = true;

        // Thống kê chỉ hiển thị nếu có quyền dashboard.stats
        if ($user->hasPermission('dashboard.stats')) {
            $data['stats'] = [
                'total_products' => \App\Models\Product::count(),
                'total_orders' => \App\Models\Order::count(),
                'total_users' => \App\Models\User::count(),
                'total_revenue' => \App\Models\Order::where('status', 'delivered')->sum('total_amount'),
            ];
            $data['can_view_stats'] = true;
        } else {
            $data['can_view_stats'] = false;
        }

        // Recent orders chỉ hiển thị nếu có quyền orders.view
        if ($user->hasPermission('orders.view')) {
            $data['recent_orders'] = \App\Models\Order::with('customer')
                ->latest()
                ->take(5)
                ->get();
            $data['can_view_orders'] = true;
        } else {
            $data['can_view_orders'] = false;
        }

        // Low stock products chỉ hiển thị nếu có quyền products.view
        if ($user->hasPermission('products.view')) {
            $data['low_stock_products'] = \App\Models\Product::where('stock_quantity', '<=', 'min_stock_level')
                ->take(5)
                ->get();
            $data['can_view_products'] = true;
        } else {
            $data['can_view_products'] = false;
        }

        // Reports chỉ hiển thị nếu có quyền dashboard.reports
        $data['can_view_reports'] = $user->hasPermission('dashboard.reports');

        return view('admin.dashboard', $data);
    }

    public function salesReport()
    {
        // Chỉ cho phép user có quyền dashboard.reports
        if (!auth()->user()->hasPermission('dashboard.reports')) {
            return response()->view('admin.errors.403', [
                'message' => 'Bạn không có quyền xem báo cáo.'
            ], 403);
        }

        // Logic báo cáo bán hàng
        return view('admin.reports.sales');
    }

    public function inventoryReport()
    {
        // Chỉ cho phép user có quyền dashboard.reports
        if (!auth()->user()->hasPermission('dashboard.reports')) {
            return response()->view('admin.errors.403', [
                'message' => 'Bạn không có quyền xem báo cáo.'
            ], 403);
        }

        // Logic báo cáo tồn kho
        return view('admin.reports.inventory');
    }
} 