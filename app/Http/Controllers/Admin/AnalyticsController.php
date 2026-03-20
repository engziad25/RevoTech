<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AnalyticsController extends Controller
{
    public function index()
    {
        $totalSales = Order::where('status', 'delivered')->sum('total');
        $ordersCount = Order::count();
        $productsSold = Order::where('status', 'delivered')->with('items')->get()->sum(function($order) {
            return $order->items->sum('quantity');
        });

        $monthlySales = Order::select(
            DB::raw('MONTH(created_at) as month'),
            DB::raw('SUM(total) as total')
        )
        ->where('status', 'delivered')
        ->whereYear('created_at', date('Y'))
        ->groupBy('month')
        ->orderBy('month')
        ->get();

        return view('admin.analytics', compact('totalSales', 'ordersCount', 'productsSold', 'monthlySales'));
    }
}