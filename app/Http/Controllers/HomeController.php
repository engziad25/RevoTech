<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;

class HomeController extends Controller
{
    public function index()
    {
        // جلب التصنيفات
        $categories = Category::active()
            ->ordered()
            ->get();

        // Featured products
        $featuredProducts = Product::active()
            ->featured()
            ->with(['category', 'brand'])
            ->latest()
            ->limit(8)
            ->get();

        // New arrivals
        $newArrivals = Product::active()
            ->with(['category', 'brand'])
            ->latest()
            ->limit(8)
            ->get();

        // Best sellers (by sales count)
        $bestSellers = Product::active()
            ->with(['category', 'brand'])
            ->orderBy('sales_count', 'desc')
            ->limit(8)
            ->get();

        return view('home', compact(
            'categories',
            'featuredProducts',
            'newArrivals',
            'bestSellers'
        ));
    }
}