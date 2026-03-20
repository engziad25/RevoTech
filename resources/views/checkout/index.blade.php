@extends('layouts.app')

@section('title', 'Checkout - RevoTech')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <h1 class="text-3xl font-bold mb-8">Checkout</h1>

    @if(!isset($cart) || $cart->items->count() == 0)
    <div class="text-center py-16">
        <i class="fas fa-shopping-cart text-6xl text-gray-300 dark:text-gray-600 mb-4"></i>
        <h2 class="text-2xl font-semibold mb-2">Your cart is empty</h2>
        <p class="text-gray-500 dark:text-gray-400 mb-8">Add some products before checking out.</p>
        <a href="{{ route('products.index') }}" class="inline-block px-8 py-4 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
            Continue Shopping
        </a>
    </div>
    @else
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Checkout Form -->
        <div class="lg:col-span-2">
            <form id="checkout-form" action="{{ route('checkout.process') }}" method="POST">
                @csrf
                
                <!-- Contact Information -->
                <div class="bg-white dark:bg-dark-surface rounded-lg shadow-lg p-6 mb-6">
                    <h2 class="text-xl font-semibold mb-4">Contact Information</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium mb-2">First Name *</label>
                            <input type="text" 
                                   name="first_name" 
                                   value="{{ auth()->user()->name ?? '' }}"
                                   required
                                   class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 dark:bg-dark-surface">
                        </div>
                        <div>
                            <label class="block text-sm font-medium mb-2">Last Name *</label>
                            <input type="text" 
                                   name="last_name" 
                                   required
                                   class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 dark:bg-dark-surface">
                        </div>
                    </div>
                    
                    <div class="mt-4">
                        <label class="block text-sm font-medium mb-2">Email Address *</label>
                        <input type="email" 
                               name="email" 
                               value="{{ auth()->user()->email ?? '' }}"
                               required
                               class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 dark:bg-dark-surface">
                    </div>
                    
                    <div class="mt-4">
                        <label class="block text-sm font-medium mb-2">Phone Number *</label>
                        <input type="tel" 
                               name="phone" 
                               required
                               class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 dark:bg-dark-surface">
                    </div>
                </div>

                <!-- Shipping Address -->
                <div class="bg-white dark:bg-dark-surface rounded-lg shadow-lg p-6 mb-6">
                    <h2 class="text-xl font-semibold mb-4">Shipping Address</h2>
                    
                    <div class="mb-4">
                        <label class="block text-sm font-medium mb-2">Address Line 1 *</label>
                        <input type="text" 
                               name="address_line1" 
                               required
                               class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 dark:bg-dark-surface">
                    </div>
                    
                    <div class="mb-4">
                        <label class="block text-sm font-medium mb-2">Address Line 2 (Optional)</label>
                        <input type="text" 
                               name="address_line2" 
                               class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 dark:bg-dark-surface">
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <label class="block text-sm font-medium mb-2">City *</label>
                            <input type="text" 
                                   name="city" 
                                   required
                                   class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 dark:bg-dark-surface">
                        </div>
                        <div>
                            <label class="block text-sm font-medium mb-2">State/Province *</label>
                            <input type="text" 
                                   name="state" 
                                   required
                                   class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 dark:bg-dark-surface">
                        </div>
                        <div>
                            <label class="block text-sm font-medium mb-2">ZIP/Postal Code *</label>
                            <input type="text" 
                                   name="zip_code" 
                                   required
                                   class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 dark:bg-dark-surface">
                        </div>
                    </div>
                    
                    <div class="mt-4">
                        <label class="block text-sm font-medium mb-2">Country *</label>
                        <select name="country" 
                                required
                                class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 dark:bg-dark-surface">
                            <option value="">Select Country</option>
                            <option value="US">United States</option>
                            <option value="CA">Canada</option>
                            <option value="UK">United Kingdom</option>
                            <option value="AU">Australia</option>
                        </select>
                    </div>
                </div>

                <!-- Shipping Method -->
                <div class="bg-white dark:bg-dark-surface rounded-lg shadow-lg p-6 mb-6">
                    <h2 class="text-xl font-semibold mb-4">Shipping Method</h2>
                    
                    <div class="space-y-3">
                        <label class="flex items-center p-4 border border-gray-300 dark:border-gray-600 rounded-lg cursor-pointer hover:bg-gray-50 dark:hover:bg-gray-800">
                            <input type="radio" name="shipping_method" value="standard" checked class="mr-3">
                            <div class="flex-1">
                                <span class="font-semibold">Standard Shipping</span>
                                <p class="text-sm text-gray-500 dark:text-gray-400">5-7 business days</p>
                            </div>
                            <span class="font-semibold">$10.00</span>
                        </label>
                        
                        <label class="flex items-center p-4 border border-gray-300 dark:border-gray-600 rounded-lg cursor-pointer hover:bg-gray-50 dark:hover:bg-gray-800">
                            <input type="radio" name="shipping_method" value="express" class="mr-3">
                            <div class="flex-1">
                                <span class="font-semibold">Express Shipping</span>
                                <p class="text-sm text-gray-500 dark:text-gray-400">2-3 business days</p>
                            </div>
                            <span class="font-semibold">$20.00</span>
                        </label>
                        
                        <label class="flex items-center p-4 border border-gray-300 dark:border-gray-600 rounded-lg cursor-pointer hover:bg-gray-50 dark:hover:bg-gray-800">
                            <input type="radio" name="shipping_method" value="overnight" class="mr-3">
                            <div class="flex-1">
                                <span class="font-semibold">Overnight Shipping</span>
                                <p class="text-sm text-gray-500 dark:text-gray-400">Next business day</p>
                            </div>
                            <span class="font-semibold">$30.00</span>
                        </label>
                    </div>
                </div>

                <!-- Payment Method (Demo) -->
                <div class="bg-white dark:bg-dark-surface rounded-lg shadow-lg p-6 mb-6">
                    <h2 class="text-xl font-semibold mb-4">Payment Method</h2>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mb-4">This is a demo - no actual payment will be processed.</p>
                    
                    <div class="space-y-3">
                        <label class="flex items-center p-4 border border-gray-300 dark:border-gray-600 rounded-lg cursor-pointer hover:bg-gray-50 dark:hover:bg-gray-800">
                            <input type="radio" name="payment_method" value="credit_card" checked class="mr-3">
                            <div>
                                <span class="font-semibold">Credit Card (Demo)</span>
                            </div>
                        </label>
                        
                        <label class="flex items-center p-4 border border-gray-300 dark:border-gray-600 rounded-lg cursor-pointer hover:bg-gray-50 dark:hover:bg-gray-800">
                            <input type="radio" name="payment_method" value="paypal" class="mr-3">
                            <div>
                                <span class="font-semibold">PayPal (Demo)</span>
                            </div>
                        </label>
                    </div>
                </div>

                <!-- Order Notes -->
                <div class="bg-white dark:bg-dark-surface rounded-lg shadow-lg p-6 mb-6">
                    <h2 class="text-xl font-semibold mb-4">Order Notes (Optional)</h2>
                    <textarea name="notes" 
                              rows="3"
                              placeholder="Special instructions for delivery..."
                              class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 dark:bg-dark-surface"></textarea>
                </div>
            </form>
        </div>

        <!-- Order Summary -->
        <div class="lg:col-span-1">
            <div class="bg-white dark:bg-dark-surface rounded-lg shadow-lg p-6 sticky top-24">
                <h2 class="text-xl font-semibold mb-4">Order Summary</h2>
                
                <!-- Cart Items Preview -->
                <div class="max-h-64 overflow-y-auto mb-4">
                    @foreach($cart->items as $item)
                    <div class="flex items-center py-3 border-b border-gray-200 dark:border-gray-700">
                        <img src="{{ $item->product->main_image ?? 'https://via.placeholder.com/50' }}" 
                             alt="{{ $item->product->name }}"
                             class="w-12 h-12 object-contain mr-3">
                        <div class="flex-1">
                            <p class="text-sm font-semibold">{{ $item->product->name }}</p>
                            <p class="text-xs text-gray-500">Qty: {{ $item->quantity }}</p>
                        </div>
                        <span class="text-sm font-semibold">${{ number_format($item->subtotal, 2) }}</span>
                    </div>
                    @endforeach
                </div>

                <!-- Totals -->
                <div class="space-y-3 mb-6">
                    <div class="flex justify-between">
                        <span class="text-gray-600 dark:text-gray-400">Subtotal</span>
                        <span class="font-semibold">${{ number_format($cart->total, 2) }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600 dark:text-gray-400">Shipping</span>
                        <span class="font-semibold" id="checkout-shipping">$10.00</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600 dark:text-gray-400">Tax (10%)</span>
                        <span class="font-semibold" id="checkout-tax">${{ number_format($cart->total * 0.1, 2) }}</span>
                    </div>
                    <div class="border-t border-gray-200 dark:border-gray-700 pt-3">
                        <div class="flex justify-between font-bold text-lg">
                            <span>Total</span>
                            <span id="checkout-total">${{ number_format($cart->total * 1.1 + 10, 2) }}</span>
                        </div>
                    </div>
                </div>

                <!-- Place Order Button -->
                <button type="submit" 
                        form="checkout-form"
                        class="w-full px-6 py-4 bg-blue-600 text-white text-center rounded-lg hover:bg-blue-700 transition transform hover:scale-105 text-lg font-semibold">
                    Place Order
                </button>
                
                <p class="text-xs text-center text-gray-500 dark:text-gray-400 mt-4">
                    By placing your order, you agree to our 
                    <a href="#" class="text-blue-600 hover:underline">Terms of Service</a> and 
                    <a href="#" class="text-blue-600 hover:underline">Privacy Policy</a>.
                </p>
            </div>
        </div>
    </div>
    @endif
</div>

@push('scripts')
<script>
    // Update totals when shipping method changes
    document.querySelectorAll('input[name="shipping_method"]').forEach(radio => {
        radio.addEventListener('change', function() {
            const subtotal = {{ $cart->total ?? 0 }};
            const shipping = parseFloat(this.value === 'standard' ? 10 : (this.value === 'express' ? 20 : 30));
            const tax = subtotal * 0.1;
            const total = subtotal + tax + shipping;
            
            document.getElementById('checkout-shipping').textContent = `$${shipping.toFixed(2)}`;
            document.getElementById('checkout-tax').textContent = `$${tax.toFixed(2)}`;
            document.getElementById('checkout-total').textContent = `$${total.toFixed(2)}`;
        });
    });
</script>
@endpush
@endsection