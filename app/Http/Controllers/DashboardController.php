<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $totalCustomers = Customer::count();
        $totalOrders = Order::count();
        $totalProducts = Product::count();

        $produkTertinggi = Product::withCount('orderItems')
            ->orderBy('order_items_count', 'desc')
            ->take(10)
            ->get(['name', 'order_items_count']);

        $produkTerendah = Product::withCount('orderItems')
            ->orderBy('order_items_count', 'asc')
            ->take(10)
            ->get(['name', 'order_items_count']);

        return view('dashboard', compact('totalCustomers', 'totalOrders', 'totalProducts', 'produkTertinggi', 'produkTerendah'));
    }
}
