@extends('layouts.app')

@section('title', 'Shopping Cart - RevoTech')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <h1 class="text-3xl font-bold mb-8">Shopping Cart</h1>

    <div id="cart-items-container">
        @if(isset($cart) && $cart->items->count() > 0)
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Cart Items -->
            <div class="lg:col-span-2">
                <div class="bg-white dark:bg-dark-surface rounded-lg shadow-lg overflow-hidden">
                    @foreach($cart->items as $item)
                    <div id="cart-item-{{ $item->id }}" class="flex items-center p-6 border-b border-gray-200 dark:border-gray-700">
                        <!-- Product Image -->
                        <div class="w-24 h-24 flex-shrink-0">
                            <img src="{{ $item->product->main_image ?? 'https://via.placeholder.com/100' }}" 
                                 alt="{{ $item->product->name }}"
                                 class="w-full h-full object-contain">
                        </div>

                        <!-- Product Details -->
                        <div class="ml-6 flex-1">
                            <h3 class="text-lg font-semibold mb-1">
                                <a href="{{ route('products.show', $item->product) }}" class="hover:text-blue-600">
                                    {{ $item->product->name }}
                                </a>
                            </h3>
                            <p class="text-sm text-gray-500 dark:text-gray-400 mb-2">
                                SKU: {{ $item->product->sku }}
                            </p>
                            
                            <!-- Quantity Controls -->
                            <div class="flex items-center">
                                <div class="flex items-center border border-gray-300 dark:border-gray-600 rounded-lg">
                                    <button onclick="updateQuantity({{ $item->id }}, 'decrease')" class="px-3 py-1 hover:bg-gray-100 dark:hover:bg-gray-800 transition">
                                        <i class="fas fa-minus text-sm"></i>
                                    </button>
                                    <input type="number" 
                                           id="quantity-{{ $item->id }}"
                                           value="{{ $item->quantity }}" 
                                           min="1" 
                                           max="{{ $item->product->stock_quantity }}"
                                           onchange="updateQuantity({{ $item->id }}, 'set', this.value)"
                                           class="w-16 text-center border-x border-gray-300 dark:border-gray-600 py-1 bg-transparent focus:outline-none">
                                    <button onclick="updateQuantity({{ $item->id }}, 'increase')" class="px-3 py-1 hover:bg-gray-100 dark:hover:bg-gray-800 transition">
                                        <i class="fas fa-plus text-sm"></i>
                                    </button>
                                </div>
                                
                                <!-- Remove Button -->
                                <button onclick="removeItem({{ $item->id }})" class="ml-4 text-red-500 hover:text-red-700 transition">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </div>
                        </div>

                        <!-- Price -->
                        <div class="ml-6 text-right">
                            <div class="text-lg font-bold">${{ number_format($item->price, 2) }}</div>
                            <div class="text-sm text-gray-500">each</div>
                            <div id="item-subtotal-{{ $item->id }}" class="text-sm font-semibold mt-1">
                                Subtotal: ${{ number_format($item->subtotal, 2) }}
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- Cart Summary -->
            <div class="lg:col-span-1">
                <div class="bg-white dark:bg-dark-surface rounded-lg shadow-lg p-6 sticky top-24">
                    <h2 class="text-xl font-semibold mb-4">Order Summary</h2>
                    
                    <div class="space-y-3 mb-6">
                        <div class="flex justify-between">
                            <span class="text-gray-600 dark:text-gray-400">Subtotal</span>
                            <span class="font-semibold" id="cart-subtotal">${{ number_format($cart->total, 2) }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600 dark:text-gray-400">Shipping</span>
                            <span class="font-semibold">$10.00</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600 dark:text-gray-400">Tax (10%)</span>
                            <span class="font-semibold" id="cart-tax">${{ number_format($cart->total * 0.1, 2) }}</span>
                        </div>
                        <div class="border-t border-gray-200 dark:border-gray-700 pt-3">
                            <div class="flex justify-between font-bold text-lg">
                                <span>Total</span>
                                <span id="cart-total">${{ number_format($cart->total * 1.1 + 10, 2) }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Promo Code -->
                    <div class="mb-6">
                        <label class="block text-sm font-medium mb-2">Promo Code</label>
                        <div class="flex">
                            <input type="text" 
                                   placeholder="Enter code" 
                                   id="promo-code"
                                   class="flex-1 px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-l-lg focus:ring-2 focus:ring-blue-500 dark:bg-dark-surface">
                            <button onclick="applyPromo()" class="px-4 py-2 bg-gray-200 dark:bg-gray-700 rounded-r-lg hover:bg-gray-300 dark:hover:bg-gray-600 transition">
                                Apply
                            </button>
                        </div>
                    </div>

                    <!-- Checkout Button -->
                    <a href="{{ route('checkout.index') }}" 
                       class="block w-full px-6 py-3 bg-blue-600 text-white text-center rounded-lg hover:bg-blue-700 transition transform hover:scale-105 mb-3">
                        Proceed to Checkout
                    </a>
                    
                    <a href="{{ route('products.index') }}" 
                       class="block w-full px-6 py-3 border-2 border-blue-600 text-blue-600 dark:text-cyan-400 text-center rounded-lg hover:bg-blue-600 hover:text-white transition">
                        Continue Shopping
                    </a>

                    <!-- Clear Cart -->
                    <button onclick="clearCart()" class="w-full mt-4 text-sm text-red-500 hover:text-red-700 transition">
                        <i class="fas fa-trash-alt mr-1"></i> Clear Cart
                    </button>
                </div>
            </div>
        </div>
        @else
        <!-- Empty Cart -->
        <div class="text-center py-16">
            <i class="fas fa-shopping-cart text-6xl text-gray-300 dark:text-gray-600 mb-4"></i>
            <h2 class="text-2xl font-semibold mb-2">Your cart is empty</h2>
            <p class="text-gray-500 dark:text-gray-400 mb-8">Looks like you haven't added anything to your cart yet.</p>
            <a href="{{ route('products.index') }}" 
               class="inline-block px-8 py-4 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition transform hover:scale-105">
                Start Shopping
            </a>
        </div>
        @endif
    </div>
</div>

@push('scripts')
<script>
    function updateQuantity(itemId, action, value = null) {
        let quantity;
        const input = document.getElementById(`quantity-${itemId}`);
        
        if (action === 'increase') {
            quantity = parseInt(input.value) + 1;
            if (quantity > parseInt(input.max)) quantity = parseInt(input.max);
        } else if (action === 'decrease') {
            quantity = parseInt(input.value) - 1;
            if (quantity < 1) quantity = 1;
        } else {
            quantity = parseInt(value);
            if (quantity < 1) quantity = 1;
            if (quantity > parseInt(input.max)) quantity = parseInt(input.max);
        }
        
        input.value = quantity;
        
        fetch(`/cart/update/${itemId}`, {
            method: 'PATCH',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({ quantity: quantity })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                document.getElementById(`item-subtotal-${itemId}`).innerHTML = `Subtotal: $${data.item_total.toFixed(2)}`;
                updateCartSummary(data.cart_total);
                showNotification('Cart updated', 'success');
            }
        });
    }

    function removeItem(itemId) {
        if (!confirm('Remove this item from cart?')) return;
        
        fetch(`/cart/remove/${itemId}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                document.getElementById(`cart-item-${itemId}`).remove();
                updateCartSummary(data.cart_total);
                updateCartCount(data.cart_count);
                showNotification('Item removed from cart', 'success');
                
                // Check if cart is empty
                if (data.cart_count === 0) {
                    location.reload(); // Reload to show empty cart message
                }
            }
        });
    }

    function clearCart() {
        if (!confirm('Are you sure you want to clear your cart?')) return;
        
        fetch('/cart/clear', {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload(); // Reload to show empty cart
                showNotification('Cart cleared', 'success');
                updateCartCount(0);
            }
        });
    }

    function updateCartSummary(cartTotal) {
        const subtotal = parseFloat(cartTotal);
        const tax = subtotal * 0.1;
        const shipping = 10;
        const total = subtotal + tax + shipping;
        
        document.getElementById('cart-subtotal').innerHTML = `$${subtotal.toFixed(2)}`;
        document.getElementById('cart-tax').innerHTML = `$${tax.toFixed(2)}`;
        document.getElementById('cart-total').innerHTML = `$${total.toFixed(2)}`;
    }

    function updateCartCount(count) {
        document.querySelectorAll('.cart-count').forEach(el => {
            el.textContent = count;
            if (count > 0) {
                el.classList.remove('hidden');
            } else {
                el.classList.add('hidden');
            }
        });
    }

    function applyPromo() {
        const code = document.getElementById('promo-code').value;
        if (!code) {
            showNotification('Please enter a promo code', 'error');
            return;
        }
        
        // Mock promo code logic
        if (code.toUpperCase() === 'SAVE10') {
            showNotification('Promo applied! 10% discount', 'success');
        } else {
            showNotification('Invalid promo code', 'error');
        }
    }

    function showNotification(message, type) {
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
</script>
@endpush
@endsection