<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $totalProducts = Product::count();
        $recentProducts = Product::whereMonth('created_at', now()->month)->count();

        $totalOrders = Order::count();
        $pendingOrders = Order::where('status', 'pending')->count();

        $totalUsers = User::where('is_admin', false)->count();
        $newUsers = User::where('is_admin', false)->whereMonth('created_at', now()->month)->count();

        $totalRevenue = Order::whereIn('status', ['processing', 'shipped', 'delivered'])->sum('total_amount');

        $recentOrders = Order::with('user')->latest()->take(5)->get();
        $recentUsers = User::where('is_admin', false)->latest()->take(5)->get();

        return view('admin.dashboard', compact(
            'totalProducts',
            'recentProducts',
            'totalOrders',
            'pendingOrders',
            'totalUsers',
            'newUsers',
            'totalRevenue',
            'recentOrders',
            'recentUsers'
        ));
    }
}
