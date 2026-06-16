<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\NewsletterSubscriber;
use App\Models\Order;
use App\Models\OrderReturn;
use App\Models\Product;
use App\Models\User;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_orders'    => Order::count(),
            'total_revenue'   => Order::whereNotIn('status', ['cancelled'])->sum('total'),
            'total_products'  => Product::count(),
            'total_users'     => User::where('is_admin', false)->count(),
            'pending_orders'  => Order::where('status', 'pending')->count(),
            'low_stock'       => Product::where('stock', '<', 5)->count(),
            'subscribers'     => NewsletterSubscriber::where('active', true)->count(),
            'pending_returns' => OrderReturn::where('status', 'pending')->count(),
        ];
        $recent_orders  = Order::with('user')->latest()->take(8)->get();
        $top_products   = Product::withCount('orderItems')->orderByDesc('order_items_count')->take(5)->get();
        $low_stock_list = Product::where('stock', '<', 5)->with('category')->orderBy('stock')->take(10)->get();

        $revenue_days = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i)->toDateString();
            $revenue_days[] = [
                'label' => now()->subDays($i)->format('D'),
                'total' => (float) Order::whereDate('created_at', $date)->whereNotIn('status', ['cancelled'])->sum('total'),
            ];
        }

        return view('admin.dashboard', compact('stats', 'recent_orders', 'top_products', 'revenue_days', 'low_stock_list'));
    }
}
