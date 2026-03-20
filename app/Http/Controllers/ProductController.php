<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use Illuminate\Http\Request;


class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::active()->with(['category', 'brand']);

        // Apply filters
        if ($request->filled('category')) {
            $query->byCategory($request->category);
        }

        if ($request->filled('brand')) {
            $query->byBrand($request->brand);
        }

        if ($request->filled('min_price') && $request->filled('max_price')) {
            $query->priceRange($request->min_price, $request->max_price);
        }

        if ($request->filled('search')) {
            $query->search($request->search);
        }

        // Apply sorting
        switch ($request->get('sort', 'latest')) {
            case 'price_low':
                $query->orderBy('price', 'asc');
                break;
            case 'price_high':
                $query->orderBy('price', 'desc');
                break;
            case 'name_asc':
                $query->orderBy('name', 'asc');
                break;
            case 'name_desc':
                $query->orderBy('name', 'desc');
                break;
            case 'rating':
                $query->orderBy('rating', 'desc');
                break;
            default:
                $query->latest();
                break;
        }

        $products = $query->paginate(12)->withQueryString();
        
        $categories = Category::active()->ordered()->get();
        $brands = Brand::active()->get();

        return view('products.index', compact('products', 'categories', 'brands'));
    }

    public function show(Product $product)
    {
        if (!$product->is_active) {
            abort(404);
        }

        // Increment views
        $product->increment('views');

        // Get related products (same category, similar price range)
        $relatedProducts = Product::active()
            ->where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->whereBetween('price', [$product->price * 0.7, $product->price * 1.3])
            ->inRandomOrder()
            ->limit(4)
            ->get();

        return view('products.show', compact('product', 'relatedProducts'));
    }
}