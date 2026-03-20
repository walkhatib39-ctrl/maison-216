<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CatalogCollection;
use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use App\Models\ProductType;
use App\Models\Room;
use Illuminate\Http\Request;

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
        $roomsCount = Room::count();
        $productTypesCount = ProductType::count();
        $collectionsCount = CatalogCollection::count();
        
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
            'roomsCount' => $roomsCount,
            'productTypesCount' => $productTypesCount,
            'collectionsCount' => $collectionsCount,
            'recentOrders' => $recentOrders,
        ]);
    }
}
