@extends('layouts.admin')

@section('title', 'Add New Product')

@section('content')
<div class="py-6">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-2xl font-semibold mb-6">Add New Product</h1>

        <form action="{{ route('admin.products.update', $product) }}" method="POST" enctype="multipart/form-data" class="bg-white dark:bg-dark-surface shadow-sm rounded-lg p-6">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium mb-2">Product Name *</label>
                    <input type="text" name="name" value="{{ old('name') }}" required class="w-full px-3 py-2 border rounded-lg dark:bg-dark-surface @error('name') border-red-500 @enderror">
                    @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium mb-2">Slug (optional)</label>
                    <input type="text" name="slug" value="{{ old('slug') }}" class="w-full px-3 py-2 border rounded-lg dark:bg-dark-surface">
                    <p class="text-xs text-gray-500 mt-1">Leave empty to auto-generate from name.</p>
                </div>

                <div>
                    <label class="block text-sm font-medium mb-2">SKU *</label>
                    <input type="text" name="sku" value="{{ old('sku') }}" required class="w-full px-3 py-2 border rounded-lg dark:bg-dark-surface @error('sku') border-red-500 @enderror">
                    @error('sku') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium mb-2">Price *</label>
                    <input type="number" step="0.01" name="price" value="{{ old('price') }}" required class="w-full px-3 py-2 border rounded-lg dark:bg-dark-surface">
                </div>

                <div>
                    <label class="block text-sm font-medium mb-2">Compare Price (optional)</label>
                    <input type="number" step="0.01" name="compare_price" value="{{ old('compare_price') }}" class="w-full px-3 py-2 border rounded-lg dark:bg-dark-surface">
                </div>

                <div>
                    <label class="block text-sm font-medium mb-2">Stock Quantity *</label>
                    <input type="number" name="stock_quantity" value="{{ old('stock_quantity', 0) }}" required class="w-full px-3 py-2 border rounded-lg dark:bg-dark-surface">
                </div>

                <div>
                    <label class="block text-sm font-medium mb-2">Category *</label>
                    <select name="category_id" required class="w-full px-3 py-2 border rounded-lg dark:bg-dark-surface">
                        <option value="">Select Category</option>
                        @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium mb-2">Brand *</label>
                    <select name="brand_id" required class="w-full px-3 py-2 border rounded-lg dark:bg-dark-surface">
                        <option value="">Select Brand</option>
                        @foreach($brands as $brand)
                        <option value="{{ $brand->id }}" {{ old('brand_id') == $brand->id ? 'selected' : '' }}>{{ $brand->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="md:col-span-2">
                    <label class="block text-sm font-medium mb-2">Short Description</label>
                    <textarea name="short_description" rows="2" class="w-full px-3 py-2 border rounded-lg dark:bg-dark-surface">{{ old('short_description') }}</textarea>
                </div>

                <div class="md:col-span-2">
                    <label class="block text-sm font-medium mb-2">Full Description *</label>
                    <textarea name="description" rows="5" required class="w-full px-3 py-2 border rounded-lg dark:bg-dark-surface">{{ old('description') }}</textarea>
                </div>

                <div>
                    <label class="flex items-center">
                        <input type="checkbox" name="is_featured" value="1" {{ old('is_featured') ? 'checked' : '' }} class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                        <span class="ml-2 text-sm">Featured Product</span>
                    </label>
                </div>

                <div>
                    <label class="flex items-center">
                        <input type="checkbox" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }} class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                        <span class="ml-2 text-sm">Active (visible in store)</span>
                    </label>
                </div>
            </div>

            <div class="mt-6 flex justify-end">
                <button type="submit" class="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                    Create Product
                </button>
            </div>
            @method('PUT')
        </form>
    </div>
</div>
@endsection