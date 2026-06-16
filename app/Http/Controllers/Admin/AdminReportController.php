<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class AdminReportController extends Controller
{
    public function index()
    {
        $period = request('period', 'daily');

        $today    = now()->toDateString();
        $week_ago = now()->subDays(6)->toDateString();
        $month_ago = now()->subDays(29)->toDateString();

        // --- Summary stats for the selected period ---
        [$from, $label] = match ($period) {
            'weekly'  => [$week_ago,  'Last 7 Days'],
            'monthly' => [$month_ago, 'Last 30 Days'],
            default   => [$today,     'Today'],
        };

        $summary = [
            'orders'  => Order::whereDate('created_at', '>=', $from)->whereNotIn('status', ['cancelled'])->count(),
            'revenue' => Order::whereDate('created_at', '>=', $from)->whereNotIn('status', ['cancelled'])->sum('total'),
            'avg_order' => Order::whereDate('created_at', '>=', $from)->whereNotIn('status', ['cancelled'])->avg('total') ?? 0,
            'cancelled' => Order::whereDate('created_at', '>=', $from)->where('status', 'cancelled')->count(),
        ];

        // --- Chart data: daily revenue for period ---
        $days = match ($period) {
            'weekly'  => 7,
            'monthly' => 30,
            default   => 1,
        };
        $chart = [];
        for ($i = $days - 1; $i >= 0; $i--) {
            $date = now()->subDays($i)->toDateString();
            $chart[] = [
                'label'   => now()->subDays($i)->format($days > 7 ? 'd M' : 'D'),
                'orders'  => Order::whereDate('created_at', $date)->whereNotIn('status', ['cancelled'])->count(),
                'revenue' => (float) Order::whereDate('created_at', $date)->whereNotIn('status', ['cancelled'])->sum('total'),
            ];
        }

        // --- Top-selling products in period ---
        $top_products = OrderItem::select('product_id', DB::raw('SUM(quantity) as total_qty'), DB::raw('SUM(quantity * price) as total_revenue'))
            ->whereHas('order', fn ($q) => $q->whereDate('created_at', '>=', $from)->whereNotIn('status', ['cancelled']))
            ->with('product')
            ->groupBy('product_id')
            ->orderByDesc('total_qty')
            ->take(8)
            ->get();

        // --- Order status breakdown ---
        $status_counts = Order::whereDate('created_at', '>=', $from)
            ->select('status', DB::raw('count(*) as count'))
            ->groupBy('status')
            ->pluck('count', 'status');

        return view('admin.reports.index', compact(
            'period', 'label', 'summary', 'chart', 'top_products', 'status_counts'
        ));
    }
}
