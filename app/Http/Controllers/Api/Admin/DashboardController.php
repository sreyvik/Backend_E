<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use App\Models\Category;
use Illuminate\Http\JsonResponse;

class DashboardController extends Controller
{
    public function index(): JsonResponse
    {
        $totalProducts = Product::count();
        $totalCategories = Category::count();
        $totalOrders = Order::count();
        $pendingOrders = Order::where('status', 'pending')->count();
        $totalUsers = User::where('is_admin', false)->count();
        $totalRevenue = Order::whereIn('status', ['processing', 'shipped', 'delivered'])->sum('total_amount');

        $recentOrders = Order::with('user')->latest()->take(5)->get();
        $recentUsers = User::where('is_admin', false)->latest()->take(5)->get();
        $lowStockProducts = Product::where('stock', '<=', 5)->take(5)->get();

        return response()->json([
            'success' => true,
            'data' => [
                'stats' => [
                    'total_products' => $totalProducts,
                    'total_categories' => $totalCategories,
                    'total_orders' => $totalOrders,
                    'pending_orders' => $pendingOrders,
                    'total_users' => $totalUsers,
                    'total_revenue' => (float) $totalRevenue,
                ],
                'recent_orders' => $recentOrders,
                'recent_users' => $recentUsers,
                'low_stock_products' => $lowStockProducts,
            ],
        ]);
    }
}
