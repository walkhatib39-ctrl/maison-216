<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Product;
use App\Models\Category;

class DashboardController extends Controller
{
    public function index()
    {
        $ordersToday = Order::whereDate('created_at', now()->toDateString())->count();
        $ordersTotal = Order::count();
        $revenueTotalMillimes = (int) (Order::sum('total_millimes') ?? 0);
        $revenueTotalDT = $revenueTotalMillimes / 1000;

        $productsCount = Product::count();
        $categoriesCount = Category::count();
        
        // Recent orders for dashboard
        $recentOrders = Order::with(['items.product'])
            ->latest()
            ->limit(10)
            ->get()
            ->map(function ($order) {
                $order->total_display = number_format((int) floor(($order->total_millimes ?? 0) / 1000)) . ' DT';
                return $order;
            });

        return view('admin.dashboard', [
            'ordersToday' => $ordersToday,
            'ordersTotal' => $ordersTotal,
            'revenueTotalDT' => $revenueTotalDT,
            'productsCount' => $productsCount,
            'categoriesCount' => $categoriesCount,
            'recentOrders' => $recentOrders,
        ]);
    }
}
