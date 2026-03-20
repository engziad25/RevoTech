@props(['product'])


<div class="group relative bg-white dark:bg-dark-surface rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 overflow-hidden">
    <!-- Badge الخصم -->
    @if($product->discount_percentage > 0)
    <div class="absolute top-5 right-5 z-10">
        <span class="px-3 py-1 bg-red-500 text-white text-sm font-semibold rounded-full">
            -{{ $product->discount_percentage }}%
        </span>
    </div>
    @endif

    <!-- صورة المنتج -->
    <a href="{{ route('products.show', $product) }}" class="block aspect-square p-4">
        <img src="{{ $product->main_image ?? '/images/placeholder.jpg' }}" 
             alt="{{ $product->name }}"
             class="w-full h-full object-contain group-hover:scale-110 transition duration-300">
    </a>

    <!-- معلومات المنتج -->
    <div class="p-4">
        <a href="{{ route('products.show', $product) }}" class="block">
            <h3 class="text-lg font-semibold mb-1 hover:text-blue-600 dark:hover:text-cyan-400 transition line-clamp-2">
                {{ $product->name }}
            </h3>
        </a>

        <!-- التقييم -->
        <div class="flex items-center mb-2">
            <div class="flex text-yellow-400">
                @for($i = 1; $i <= 5; $i++)
                    <i class="{{ $i <= round($product->rating) ? 'fas' : 'far' }} fa-star text-sm"></i>
                @endfor
            </div>
            <span class="text-xs text-gray-500 dark:text-gray-400 ml-1">({{ $product->review_count }})</span>
        </div>

        <!-- السعر -->
        <div class="mb-3">
            <span class="text-xl font-bold">{{ $product->formatted_price }}</span>
            @if($product->compare_price)
            <span class="text-sm text-gray-400 line-through ml-2">{{ $product->formatted_compare_price }}</span>
            @endif
        </div>

        <!-- زر الإضافة إلى السلة -->
        @if($product->stock_quantity > 0)
        <button class="add-to-cart w-full px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition"
                data-product-id="{{ $product->id }}"
                data-quantity="1">
            <i class="fas fa-shopping-cart mr-2"></i> Add to Cart
        </button>
        @else
        <button class="w-full px-4 py-2 bg-gray-300 text-gray-600 rounded-lg cursor-not-allowed" disabled>
            Out of Stock
        </button>
        @endif
    </div>
</div>

