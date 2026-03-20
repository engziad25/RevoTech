@extends('layouts.admin')

@section('title', 'Admin Dashboard')

@section('content')
<div class="py-6">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-2xl font-semibold">Dashboard</h1>

        <!-- Stats Cards -->
        <div class="mt-6 grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-3">
            <div class="bg-white dark:bg-dark-surface overflow-hidden shadow rounded-lg">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <i class="fas fa-shopping-cart text-2xl text-blue-600"></i>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 truncate">Total Orders</dt>
                                <dd class="text-lg font-semibold">{{ $totalOrders }}</dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-dark-surface overflow-hidden shadow rounded-lg">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <i class="fas fa-boxes text-2xl text-green-600"></i>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 truncate">Total Products</dt>
                                <dd class="text-lg font-semibold">{{ $totalProducts }}</dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-dark-surface overflow-hidden shadow rounded-lg">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <i class="fas fa-users text-2xl text-purple-600"></i>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 truncate">Total Users</dt>
                                <dd class="text-lg font-semibold">{{ $totalUsers }}</dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Orders -->
        <div class="mt-8">
            <h2 class="text-lg font-medium">Recent Orders</h2>
            <div class="mt-4 bg-white dark:bg-dark-surface shadow overflow-hidden sm:rounded-md">
                <ul class="divide-y divide-gray-200 dark:divide-gray-700">
                    @foreach($recentOrders as $order)
                    <li>
                        <a href="{{ route('admin.orders.show', $order) }}" class="block hover:bg-gray-50 dark:hover:bg-gray-800">
                            <div class="px-4 py-4 sm:px-6">
                                <div class="flex items-center justify-between">
                                    <p class="text-sm font-medium text-blue-600 truncate">Order #{{ $order->order_number }}</p>
                                    <div class="ml-2 flex-shrink-0 flex">
                                        <p class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                            @if($order->status == 'delivered') bg-green-100 text-green-800
                                            @elseif($order->status == 'processing') bg-blue-100 text-blue-800
                                            @elseif($order->status == 'shipped') bg-purple-100 text-purple-800
                                            @elseif($order->status == 'cancelled') bg-red-100 text-red-800
                                            @else bg-yellow-100 text-yellow-800 @endif">
                                            {{ ucfirst($order->status) }}
                                        </p>
                                    </div>
                                </div>
                                <div class="mt-2 sm:flex sm:justify-between">
                                    <div class="sm:flex">
                                        <p class="flex items-center text-sm text-gray-500 dark:text-gray-400">
                                            <i class="fas fa-user flex-shrink-0 mr-1.5"></i>
                                            {{ $order->user->name }}
                                        </p>
                                        <p class="mt-2 flex items-center text-sm text-gray-500 dark:text-gray-400 sm:mt-0 sm:ml-6">
                                            <i class="fas fa-dollar-sign flex-shrink-0 mr-1.5"></i>
                                            ${{ number_format($order->total, 2) }}
                                        </p>
                                    </div>
                                    <div class="mt-2 flex items-center text-sm text-gray-500 dark:text-gray-400 sm:mt-0">
                                        <i class="fas fa-calendar flex-shrink-0 mr-1.5"></i>
                                        <p>{{ $order->created_at->format('M d, Y') }}</p>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection