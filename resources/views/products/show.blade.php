@extends('layouts.app')

@section('title', $product->name . ' - RevoTech')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Breadcrumb -->
    <nav class="flex mb-8" aria-label="Breadcrumb">
        <ol class="inline-flex items-center space-x-1 md:space-x-3">
            <li class="inline-flex items-center">
                <a href="{{ route('home') }}" class="text-gray-700 dark:text-gray-300 hover:text-blue-600">Home</a>
            </li>
            <li>
                <div class="flex items-center">
                    <i class="fas fa-chevron-right text-gray-400 mx-2 text-sm"></i>
                    <a href="{{ route('products.index', ['category' => $product->category_id]) }}" class="text-gray-700 dark:text-gray-300 hover:text-blue-600">{{ $product->category->name }}</a>
                </div>
            </li>
            <li aria-current="page">
                <div class="flex items-center">
                    <i class="fas fa-chevron-right text-gray-400 mx-2 text-sm"></i>
                    <span class="text-gray-500 dark:text-gray-400">{{ $product->name }}</span>
                </div>
            </li>
        </ol>
    </nav>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
        <!-- Product Images -->@foreach($products as $product)
         @php 
         $images = json_decode($product->images);
         @endphp;
        <div>
            <div class="bg-white dark:bg-dark-surface rounded-2xl p-8 mb-4">
                <img src="{{ $product->main_image ?? 'https://via.placeholder.com/600' }}" 
                     alt="{{ $product->name }}"
                     id="main-image"
                     class="w-full h-auto object-contain max-h-96">
            </div>
            
            <!-- Thumbnails (if multiple images) -->
            @if(is_array($product->images) && count($product->images) > 1)
            <div class="grid grid-cols-4 gap-4">
                @foreach($product->images as $index => $image)
                <button onclick="changeImage('{{ $image }}')" class="bg-white dark:bg-dark-surface rounded-lg p-2 hover:opacity-75 transition">
                    <img src="{{ $image }}" alt="Thumbnail {{ $index + 1 }}" class="w-full h-20 object-contain">
                </button>
                @endforeach
            </div>
            @endif
        </div>
@en
        <!-- Product Info -->
        <div>
            <!-- Badges -->
            <div class="flex space-x-2 mb-4">
                @if($product->discount_percentage > 0)
                <span class="px-3 py-1 bg-red-500 text-white text-sm font-semibold rounded-full">
                    -{{ $product->discount_percentage }}% OFF
                </span>
                @endif
                
                @if($product->is_featured)
                <span class="px-3 py-1 bg-yellow-500 text-white text-sm font-semibold rounded-full">
                    Featured
                </span>
                @endif

                <span class="px-3 py-1 {{ $product->stock_quantity > 0 ? 'bg-green-500' : 'bg-red-500' }} text-white text-sm font-semibold rounded-full">
                    {{ $product->stock_quantity > 0 ? 'In Stock' : 'Out of Stock' }}
                </span>
            </div>

            <h1 class="text-3xl font-bold mb-4">{{ $product->name }}</h1>

            <!-- Rating -->
            <div class="flex items-center mb-6">
                <div class="flex text-yellow-400">
                    @for($i = 1; $i <= 5; $i++)
                        @if($i <= round($product->rating))
                        <i class="fas fa-star"></i>
                        @else
                        <i class="far fa-star"></i>
                        @endif
                    @endfor
                </div>
                <span class="text-gray-500 dark:text-gray-400 ml-2">
                    ({{ $product->review_count }} reviews)
                </span>
            </div>

            <!-- Price -->
            <div class="mb-6">
                @if($product->compare_price)
                <span class="text-3xl font-bold text-blue-600 dark:text-cyan-400">{{ $product->formatted_price }}</span>
                <span class="text-xl text-gray-400 line-through ml-3">{{ $product->formatted_compare_price }}</span>
                @else
                <span class="text-3xl font-bold">{{ $product->formatted_price }}</span>
                @endif
            </div>

            <!-- Short Description -->
            <p class="text-gray-600 dark:text-gray-400 mb-6">{{ $product->short_description }}</p>

            <!-- Add to Cart -->
            @if($product->stock_quantity > 0)
            <div class="flex items-center space-x-4 mb-8">
                <div class="flex items-center border border-gray-300 dark:border-gray-600 rounded-lg">
                    <button onclick="decrementQuantity()" class="px-4 py-3 hover:bg-gray-100 dark:hover:bg-gray-800 transition">
                        <i class="fas fa-minus"></i>
                    </button>
                    <input type="number" id="quantity" value="1" min="1" max="{{ $product->stock_quantity }}" 
                           class="w-16 text-center border-x border-gray-300 dark:border-gray-600 py-3 bg-transparent focus:outline-none">
                    <button onclick="incrementQuantity()" class="px-4 py-3 hover:bg-gray-100 dark:hover:bg-gray-800 transition">
                        <i class="fas fa-plus"></i>
                    </button>
                </div>
                
                <button onclick="addToCart({{ $product->id }})" class="flex-1 px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition transform hover:scale-105">
                    <i class="fas fa-shopping-cart mr-2"></i> Add to Cart
                </button>

                @auth
                <button onclick="toggleWishlist({{ $product->id }})" class="px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-800 transition">
                    <i class="far fa-heart text-xl"></i>
                </button>
                @endauth
            </div>
            @else
            <div class="mb-8 p-4 bg-red-100 text-red-700 rounded-lg">
                <i class="fas fa-exclamation-circle mr-2"></i> This product is currently out of stock.
            </div>
            @endif

            <!-- Product Details Tabs -->
            <div class="border-t border-gray-200 dark:border-gray-700 pt-8">
                <div class="flex space-x-8 mb-6">
                    <button onclick="showTab('description')" id="tab-description-btn" class="tab-btn active font-semibold text-blue-600 dark:text-cyan-400 border-b-2 border-blue-600 pb-2">Description</button>
                    <button onclick="showTab('specifications')" id="tab-specifications-btn" class="tab-btn text-gray-500 hover:text-gray-700 dark:text-gray-400 pb-2">Specifications</button>
                    <button onclick="showTab('reviews')" id="tab-reviews-btn" class="tab-btn text-gray-500 hover:text-gray-700 dark:text-gray-400 pb-2">Reviews ({{ $product->review_count }})</button>
                </div>

                <div id="tab-description" class="tab-content">
                    <div class="prose dark:prose-invert max-w-none">
                        {!! nl2br(e($product->description)) !!}
                    </div>
                </div>

                <div id="tab-specifications" class="tab-content hidden">
                    @if($product->specifications)
                    <table class="w-full">
                        @foreach($product->specifications as $key => $value)
                        <tr class="border-b border-gray-200 dark:border-gray-700">
                            <td class="py-3 font-semibold">{{ $key }}</td>
                            <td class="py-3 text-gray-600 dark:text-gray-400">{{ $value }}</td>
                        </tr>
                        @endforeach
                    </table>
                    @else
                    <p class="text-gray-500">No specifications available.</p>
                    @endif
                </div>

                <div id="tab-reviews" class="tab-content hidden">
                    @if($product->reviews->count() > 0)
                        @foreach($product->reviews as $review)
                        <div class="border-b border-gray-200 dark:border-gray-700 py-4">
                            <div class="flex items-center mb-2">
                                <div class="flex text-yellow-400 mr-3">
                                    @for($i = 1; $i <= 5; $i++)
                                        @if($i <= $review->rating)
                                        <i class="fas fa-star text-sm"></i>
                                        @else
                                        <i class="far fa-star text-sm"></i>
                                        @endif
                                    @endfor
                                </div>
                                <span class="font-semibold">{{ $review->user->name }}</span>
                                <span class="text-gray-400 text-sm ml-3">{{ $review->created_at->diffForHumans() }}</span>
                            </div>
                            <p class="text-gray-600 dark:text-gray-400">{{ $review->comment }}</p>
                        </div>
                        @endforeach
                    @else
                    <p class="text-gray-500">No reviews yet.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Related Products -->
    @if(isset($relatedProducts) && $relatedProducts->count() > 0)
    <div class="mt-16">
        <h2 class="text-2xl font-bold mb-8">You May Also Like</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach($relatedProducts as $related)
            <x-product-card :product="$related" />
            @endforeach
        </div>
    </div>
    @endif
</div>

@push('scripts')
<script>
    function changeImage(imageUrl) {
        document.getElementById('main-image').src = imageUrl;
    }

    function incrementQuantity() {
        const input = document.getElementById('quantity');
        const max = parseInt(input.getAttribute('max'));
        const currentValue = parseInt(input.value);
        if (currentValue < max) {
            input.value = currentValue + 1;
        }
    }

    function decrementQuantity() {
        const input = document.getElementById('quantity');
        const currentValue = parseInt(input.value);
        if (currentValue > 1) {
            input.value = currentValue - 1;
        }
    }

    function addToCart(productId) {
        const quantity = document.getElementById('quantity').value;
        
        fetch(`/cart/add/${productId}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({ quantity: quantity })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showNotification('Product added to cart!', 'success');
                updateCartCount(data.cart_count);
            }
        })
        .catch(error => {
            showNotification('Error adding product to cart', 'error');
        });
    }

    function toggleWishlist(productId) {
        fetch(`/wishlist/toggle/${productId}`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showNotification(data.message, 'success');
            }
        });
    }

    function showTab(tabName) {
        // Hide all tabs
        document.querySelectorAll('.tab-content').forEach(tab => {
            tab.classList.add('hidden');
        });
        
        // Remove active class from all buttons
        document.querySelectorAll('.tab-btn').forEach(btn => {
            btn.classList.remove('active', 'font-semibold', 'text-blue-600', 'dark:text-cyan-400', 'border-b-2', 'border-blue-600');
            btn.classList.add('text-gray-500');
        });
        
        // Show selected tab
        document.getElementById(`tab-${tabName}`).classList.remove('hidden');
        
        // Activate button
        const btn = document.getElementById(`tab-${tabName}-btn`);
        btn.classList.add('active', 'font-semibold', 'text-blue-600', 'dark:text-cyan-400', 'border-b-2', 'border-blue-600');
        btn.classList.remove('text-gray-500');
    }

    function showNotification(message, type) {
        // Create notification element
        const notification = document.createElement('div');
        notification.className = `fixed top-20 right-4 px-6 py-3 rounded-lg shadow-lg z-50 animate-slide-up ${
            type === 'success' ? 'bg-green-500' : 'bg-red-500'
        } text-white`;
        notification.textContent = message;
        
        document.body.appendChild(notification);
        
        setTimeout(() => {
            notification.remove();
        }, 3000);
    }

    function updateCartCount(count) {
        document.querySelectorAll('.cart-count').forEach(el => {
            el.textContent = count;
            el.classList.remove('hidden');
        });
    }
</script>
@endpush
@endsection