<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use App\Models\Category;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(): View
    {
        // Key metrics
        $totalRevenue   = Order::where('payment_status', 'paid')->sum('total_amount');
        $totalOrders    = Order::count();
        $totalProducts  = Product::count();
        $totalCustomers = User::where('role', 'customer')->count();

        // Orders by status
        $ordersByStatus = Order::select('status', DB::raw('count(*) as count'))
                               ->groupBy('status')
                               ->pluck('count', 'status');

        // Revenue last 7 days
        $revenueChart = Order::where('payment_status', 'paid')
                             ->where('created_at', '>=', now()->subDays(6))
                             ->select(
                                 DB::raw('DATE(created_at) as date'),
                                 DB::raw('SUM(total_amount) as revenue'),
                                 DB::raw('COUNT(*) as orders')
                             )
                             ->groupBy('date')
                             ->orderBy('date')
                             ->get()
                             ->keyBy('date');

        // Fill missing days with 0
        $labels  = [];
        $revenues = [];
        for ($i = 6; $i >= 0; $i--) {
            $date      = now()->subDays($i)->format('Y-m-d');
            $labels[]  = now()->subDays($i)->format('M d');
            $revenues[] = $revenueChart[$date]->revenue ?? 0;
        }

        // Recent orders
        $recentOrders = Order::with('user')
                             ->recent()
                             ->take(8)
                             ->get();

        // Low stock products
        $lowStockProducts = Product::where('stock_quantity', '<=', 5)
                                   ->where('is_active', true)
                                   ->with('category')
                                   ->orderBy('stock_quantity')
                                   ->take(5)
                                   ->get();

        // Top selling products
        $topProducts = DB::table('order_items')
                         ->select('product_name', DB::raw('SUM(quantity) as total_sold'), DB::raw('SUM(line_total) as total_revenue'))
                         ->groupBy('product_name')
                         ->orderByDesc('total_sold')
                         ->take(5)
                         ->get();

        return view('admin.dashboard', compact(
            'totalRevenue', 'totalOrders', 'totalProducts', 'totalCustomers',
            'ordersByStatus', 'labels', 'revenues',
            'recentOrders', 'lowStockProducts', 'topProducts'
        ));
    }
}
