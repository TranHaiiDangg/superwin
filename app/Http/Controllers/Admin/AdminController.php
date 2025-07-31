<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminController extends Controller
{

    public function dashboard()
    {
        $stats = [
            'total_products' => \App\Models\Product::count(),
            'total_orders' => \App\Models\Order::count(),
            'total_users' => \App\Models\User::count(),
            'total_revenue' => \App\Models\Order::where('status', 'delivered')->sum('total_amount'),
        ];

        $recent_orders = \App\Models\Order::with('user')
            ->latest()
            ->take(5)
            ->get();

        $low_stock_products = \App\Models\Product::where('stock_quantity', '<=', 'min_stock_level')
            ->take(5)
            ->get();

        return view('admin.dashboard', compact('stats', 'recent_orders', 'low_stock_products'));
    }
} 