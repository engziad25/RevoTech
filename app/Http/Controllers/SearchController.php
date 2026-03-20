<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->get('q');
        
        if (strlen($query) < 2) {
            return redirect()->route('products.index');
        }

        $products = Product::active()
            ->search($query)
            ->paginate(12);

        return view('products.index', [
            'products' => $products,
            'searchQuery' => $query
        ]);
    }

    public function live(Request $request)
    {
        $query = $request->get('q');
        
        if (strlen($query) < 2) {
            return response()->json([]);
        }

        $products = Product::active()
            ->search($query)
            ->with(['category', 'brand'])
            ->limit(5)
            ->get()
            ->map(function ($product) {
                return [
                    'id' => $product->id,
                    'name' => $product->name,
                    'slug' => $product->slug,
                    'price' => $product->formatted_price,
                    'image' => $product->main_image,
                    'category' => $product->category->name,
                ];
            });

        return response()->json($products);
    }
}