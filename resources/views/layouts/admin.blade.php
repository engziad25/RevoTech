<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="{{ $theme ?? 'light' }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title') - Admin RevoTech</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    @vite('resources/css/app.css')
</head>
<body class="bg-gray-100 dark:bg-dark-bg">
    <div class="min-h-screen flex">
        <!-- Sidebar -->
        <div class="w-64 bg-white dark:bg-dark-surface shadow-lg">
            <div class="p-4">
                <a href="{{ route('admin.dashboard') }}" class="text-2xl font-bold bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent">
                    RevoTech Admin
                </a>
            </div>
            <nav class="mt-4">
                <a href="{{ route('admin.dashboard') }}" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-800 {{ request()->routeIs('admin.dashboard') ? 'bg-gray-100 dark:bg-gray-800' : '' }}">
                    <i class="fas fa-tachometer-alt w-6 inline-block"></i> Dashboard
                </a>
                <a href="{{ route('admin.products.index') }}" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-800 {{ request()->routeIs('admin.products.*') ? 'bg-gray-100 dark:bg-gray-800' : '' }}">
                    <i class="fas fa-box w-6 inline-block"></i> Products
                </a>
                <a href="{{ route('admin.orders.index') }}" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-800 {{ request()->routeIs('admin.orders.*') ? 'bg-gray-100 dark:bg-gray-800' : '' }}">
                    <i class="fas fa-shopping-cart w-6 inline-block"></i> Orders
                </a>
                <a href="{{ route('admin.analytics') }}" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-800 {{ request()->routeIs('admin.analytics') ? 'bg-gray-100 dark:bg-gray-800' : '' }}">
                    <i class="fas fa-chart-line w-6 inline-block"></i> Analytics
                </a>
                <a href="{{ route('home') }}" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-800">
                    <i class="fas fa-arrow-left w-6 inline-block"></i> Back to Site
                </a>
            </nav>
        </div>

        <!-- Main Content -->
        <div class="flex-1">
            <!-- Top Bar -->
            <div class="bg-white dark:bg-dark-surface shadow-sm">
                <div class="px-4 py-3 flex justify-between items-center">
                    <h2 class="text-xl font-semibold">@yield('title')</h2>
                    <div class="flex items-center space-x-4">
                        <button id="theme-toggle" class="p-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-800">
                            <i id="theme-icon" class="fas {{ $theme === 'dark' ? 'fa-sun' : 'fa-moon' }}"></i>
                        </button>
                        <span>{{ auth()->user()->name }}</span>
                    </div>
                </div>
            </div>

            <!-- Page Content -->
            <div class="p-6">
                @if(session('success'))
                    <div class="mb-4 p-4 bg-green-100 text-green-700 rounded">
                        {{ session('success') }}
                    </div>
                @endif
                @yield('content')
            </div>
        </div>
    </div>

    <script src="{{ asset('js/theme.js') }}"></script>
</body>
</html>