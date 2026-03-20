@extends('layouts.app')

@section('title', 'Order Confirmed - RevoTech')

@section('content')
<div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
    <div class="text-center">
        <!-- Success Icon -->
        <div class="mb-8">
            <div class="inline-flex items-center justify-center w-24 h-24 bg-green-100 rounded-full">
                <i class="fas fa-check text-4xl text-green-600"></i>
            </div>
        </div>

        <h1 class="text-4xl font-bold mb-4">Thank You for Your Order!</h1>
        <p class="text-xl text-gray-600 dark:text-gray-400 mb-8">
            Your order has been placed successfully.
        </p>

        <!-- Order Details Card -->
        <div class="bg-white dark:bg-dark-surface rounded-lg shadow-lg p-8 mb-8 text-left">
            <h2 class="text-2xl font-semibold mb-6">Order Details</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mb-1">Order Number</p>
                    <p class="text-lg font-semibold">{{ $order->order_number }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mb-1">Order Date</p>
                    <p class="text-lg font-semibold">{{ $order->created_at->format('F j, Y') }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mb-1">Total Amount</p>
                    <p class="text-lg font-semibold text-blue-600">${{ number_format($order->total, 2) }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mb-1">Payment Method</p>
                    <p class="text-lg font-semibold">{{ ucfirst(str_replace('_', ' ', $order->payment_method)) }}</p>
                </div>
            </div>

            <!-- Order Items -->
            <h3 class="font-semibold mb-3">Order Items</h3>
            <div class="border-t border-gray-200 dark:border-gray-700 pt-4">
                @foreach($order->items as $item)
                <div class="flex justify-between items-center py-2">
                    <div>
                        <span class="font-medium">{{ $item->product_name }}</span>
                        <span class="text-sm text-gray-500 ml-2">x{{ $item->quantity }}</span>
                    </div>
                    <span>${{ number_format($item->subtotal, 2) }}</span>
                </div>
                @endforeach
            </div>

            <!-- Shipping Address -->
            <div class="mt-6 pt-6 border-t border-gray-200 dark:border-gray-700">
                <h3 class="font-semibold mb-3">Shipping Address</h3>
                @php
                    $address = json_decode($order->shipping_address);
                @endphp
                <p class="text-gray-600 dark:text-gray-400">
                    {{ $address->first_name }} {{ $address->last_name }}<br>
                    {{ $address->address_line1 }}<br>
                    @if($address->address_line2)
                        {{ $address->address_line2 }}<br>
                    @endif
                    {{ $address->city }}, {{ $address->state }} {{ $address->zip_code }}<br>
                    {{ $address->country }}
                </p>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <a href="{{ route('products.index') }}" 
               class="px-8 py-4 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition transform hover:scale-105">
                Continue Shopping
            </a>
            <a href="#" 
               class="px-8 py-4 border-2 border-blue-600 text-blue-600 dark:text-cyan-400 rounded-lg hover:bg-blue-600 hover:text-white transition">
                View Order History
            </a>
        </div>
    </div>
</div>
@endsection