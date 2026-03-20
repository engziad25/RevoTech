<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with(['category', 'brand'])->latest()->paginate(15);
        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        $categories = Category::all();
        $brands = Brand::all();
        return view('admin.products.create', compact('categories', 'brands'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|unique:products|max:255',
            'description' => 'required|string',
            'short_description' => 'nullable|string|max:500',
            'price' => 'required|numeric|min:0',
            'compare_price' => 'nullable|numeric|min:0',
            'stock_quantity' => 'required|integer|min:0',
            'sku' => 'required|string|unique:products|max:50',
            'category_id' => 'required|exists:categories,id',
            'brand_id' => 'required|exists:brands,id',
            'is_featured' => 'boolean',
            'is_active' => 'boolean',
        ]);

        // إنشاء slug تلقائي إذا لم يقدم
        if (empty($data['slug'])) {
            $data['slug'] = Str::slug($data['name']);
        }

        $data['images'] = json_encode([]); // مصفوفة صور فارغة
        $product = Product::create($data);

        return redirect()->route('admin.products.index')
            ->with('success', 'Product created successfully.');
    }

    public function edit(Product $product)
    {
        $categories = Category::all();
        $brands = Brand::all();
        return view('admin.products.edit', compact('product', 'categories', 'brands'));
    }

    public function update(Request $request, Product $product)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:products,slug,' . $product->id,
            'description' => 'required|string',
            'short_description' => 'nullable|string|max:500',
            'price' => 'required|numeric|min:0',
            'compare_price' => 'nullable|numeric|min:0',
            'stock_quantity' => 'required|integer|min:0',
            'sku' => 'required|string|max:50|unique:products,sku,' . $product->id,
            'category_id' => 'required|exists:categories,id',
            'brand_id' => 'required|exists:brands,id',
            'is_featured' => 'boolean',
            'is_active' => 'boolean',
        ]);

        if (empty($data['slug'])) {
            $data['slug'] = Str::slug($data['name']);
        }

        $product->update($data);

        return redirect()->route('admin.products.index')
            ->with('success', 'Product updated successfully.');
    }

    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('admin.products.index')
            ->with('success', 'Product deleted successfully.');
    }

    public function uploadImages(Request $request, Product $product)
    {
        $request->validate([
            'images' => 'required|array',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $uploadedImages = [];
        foreach ($request->file('images') as $image) {
            $path = $image->store('products', 'public');
            $uploadedImages[] = '/storage/' . $path;
        }

        $existingImages = json_decode($product->images, true) ?? [];
        $product->images = json_encode(array_merge($existingImages, $uploadedImages));
        $product->save();

        return response()->json(['success' => true, 'images' => $uploadedImages]);
    }

    public function deleteImage(Product $product, $index)
    {
        $images = json_decode($product->images, true) ?? [];
        if (isset($images[$index])) {
            // حذف الملف من التخزين (اختياري)
            // Storage::disk('public')->delete(str_replace('/storage/', '', $images[$index]));
            unset($images[$index]);
            $product->images = json_encode(array_values($images));
            $product->save();
        }

        return response()->json(['success' => true]);
    }
}