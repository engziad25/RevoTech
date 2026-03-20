<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="{{ $theme ?? 'light' }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="theme-color" content="{{ $theme === 'dark' ? '#0a0a0f' : '#ffffff' }}">

    <title>@yield('title', 'RevoTech') - Premium Electronics</title>

    <!-- Fonts & Icons -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    @vite('resources/css/app.css')
</head>
<body class="bg-light-bg dark:bg-dark-bg text-light-text dark:text-dark-text antialiased">
    <!-- Navbar -->
    <nav class="sticky top-0 z-50 bg-white/80 dark:bg-dark-surface/80 backdrop-blur-md border-b border-gray-200 dark:border-gray-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <!-- Logo -->
                <div class="flex-shrink-0">
                    <a href="{{ route('home') }}" class="text-2xl font-bold bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent">
                        RevoTech
                    </a>
                </div>

                <!-- Desktop Navigation Links -->
                <div class="hidden md:flex items-center space-x-8">
                    <a href="{{ route('home') }}" class="hover:text-blue-600 dark:hover:text-cyan-400 transition {{ request()->routeIs('home') ? 'text-blue-600 dark:text-cyan-400' : '' }}">Home</a>
                    <a href="{{ route('products.index') }}" class="hover:text-blue-600 dark:hover:text-cyan-400 transition {{ request()->routeIs('products.*') ? 'text-blue-600 dark:text-cyan-400' : '' }}">Products</a>
                    <a href="{{ route('about') }}" class="hover:text-blue-600 dark:hover:text-cyan-400 transition {{ request()->routeIs('about') ? 'text-blue-600 dark:text-cyan-400' : '' }}">About</a>
                    <a href="{{ route('contact') }}" class="hover:text-blue-600 dark:hover:text-cyan-400 transition {{ request()->routeIs('contact') ? 'text-blue-600 dark:text-cyan-400' : '' }}">Contact</a>
                </div>

                <!-- Desktop Right Icons -->
                <div class="hidden md:flex items-center space-x-4">
                    <!-- Search (optional) -->
                    <button id="search-toggle" class="p-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-800 transition">
                        <i class="fas fa-search text-xl"></i>
                    </button>

                    <!-- Cart -->
                    <a href="{{ route('cart.index') }}" class="relative p-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-800 transition">
                        <i class="fas fa-shopping-cart text-xl"></i>
                        <span class="cart-count absolute -top-1 -right-1 bg-blue-600 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center hidden">0</span>
                    </a>

                    <!-- Wishlist (auth) -->
                    @auth
                    <a href="{{ route('wishlist.index') }}" class="relative p-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-800 transition">
                        <i class="far fa-heart text-xl"></i>
                    </a>
                    @endauth

                    <!-- Theme Toggle -->
                    <button id="theme-toggle" class="p-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-800 transition">
                        <i id="theme-icon" class="fas {{ $theme === 'dark' ? 'fa-sun' : 'fa-moon' }} text-xl"></i>
                    </button>

                    <!-- User Menu -->
                    @auth
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open" class="flex items-center space-x-2 p-1 rounded-full hover:bg-gray-100 dark:hover:bg-gray-800 transition">
                            <img src="{{ auth()->user()->avatar ?? 'https://ui-avatars.com/api/?name='.urlencode(auth()->user()->name) }}" alt="Avatar" class="w-8 h-8 rounded-full">
                        </button>
                        <div x-show="open" @click.away="open = false" class="absolute right-0 mt-2 w-48 bg-white dark:bg-dark-surface rounded-lg shadow-xl border border-gray-200 dark:border-gray-700 py-1 z-50">
                            <a href="#" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-800">Profile</a>
                            <a href="#" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-800">Orders</a>
                            @if(auth()->user()->is_admin)
                            <a href="{{ route('admin.dashboard') }}" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-800">Admin</a>
                            @endif
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="block w-full text-left px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-800">Logout</button>
                            </form>
                        </div>
                    </div>
                    @else
                    <a href="{{ route('login') }}" class="px-4 py-2 rounded-lg bg-blue-600 text-white hover:bg-blue-700 transition">Sign In</a>
                    @endauth
                </div>

                <!-- Mobile menu button -->
                <div class="flex md:hidden items-center space-x-2">
                    <button id="mobile-menu-button" class="p-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-800 transition">
                        <i class="fas fa-bars text-xl"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile menu (hidden by default) -->
        <div id="mobile-menu" class="hidden md:hidden bg-white dark:bg-dark-surface border-t border-gray-200 dark:border-gray-800">
            <div class="px-4 pt-2 pb-3 space-y-1">
                <a href="{{ route('home') }}" class="block px-3 py-2 rounded-md hover:bg-gray-100 dark:hover:bg-gray-800 {{ request()->routeIs('home') ? 'bg-gray-100 dark:bg-gray-800' : '' }}">Home</a>
                <a href="{{ route('products.index') }}" class="block px-3 py-2 rounded-md hover:bg-gray-100 dark:hover:bg-gray-800 {{ request()->routeIs('products.*') ? 'bg-gray-100 dark:bg-gray-800' : '' }}">Products</a>
                <a href="{{ route('about') }}" class="block px-3 py-2 rounded-md hover:bg-gray-100 dark:hover:bg-gray-800 {{ request()->routeIs('about') ? 'bg-gray-100 dark:bg-gray-800' : '' }}">About</a>
                <a href="{{ route('contact') }}" class="block px-3 py-2 rounded-md hover:bg-gray-100 dark:hover:bg-gray-800 {{ request()->routeIs('contact') ? 'bg-gray-100 dark:bg-gray-800' : '' }}">Contact</a>
                <div class="border-t border-gray-200 dark:border-gray-700 my-2"></div>
                <a href="{{ route('cart.index') }}" class="block px-3 py-2 rounded-md hover:bg-gray-100 dark:hover:bg-gray-800">
                    <i class="fas fa-shopping-cart mr-2"></i> Cart <span class="cart-count ml-1 inline-block bg-blue-600 text-white text-xs rounded-full px-2 py-0.5 hidden">0</span>
                </a>
                @auth
                <a href="{{ route('wishlist.index') }}" class="block px-3 py-2 rounded-md hover:bg-gray-100 dark:hover:bg-gray-800">
                    <i class="far fa-heart mr-2"></i> Wishlist
                </a>
                @endauth
                <div class="border-t border-gray-200 dark:border-gray-700 my-2"></div>
                @auth
                <div class="px-3 py-2">
                    <div class="flex items-center space-x-2">
                        <img src="{{ auth()->user()->avatar ?? 'https://ui-avatars.com/api/?name='.urlencode(auth()->user()->name) }}" alt="Avatar" class="w-8 h-8 rounded-full">
                        <span>{{ auth()->user()->name }}</span>
                    </div>
                    <div class="mt-2 space-y-1">
                        <a href="#" class="block px-3 py-2 rounded-md hover:bg-gray-100 dark:hover:bg-gray-800">Profile</a>
                        <a href="#" class="block px-3 py-2 rounded-md hover:bg-gray-100 dark:hover:bg-gray-800">Orders</a>
                        @if(auth()->user()->is_admin)
                        <a href="{{ route('admin.dashboard') }}" class="block px-3 py-2 rounded-md hover:bg-gray-100 dark:hover:bg-gray-800">Admin</a>
                        @endif
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="block w-full text-left px-3 py-2 rounded-md hover:bg-gray-100 dark:hover:bg-gray-800">Logout</button>
                        </form>
                    </div>
                </div>
                @else
                <a href="{{ route('login') }}" class="block px-3 py-2 rounded-md bg-blue-600 text-white hover:bg-blue-700 text-center">Sign In</a>
                <a href="{{ route('register') }}" class="block px-3 py-2 rounded-md text-center">Register</a>
                @endauth
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="min-h-screen">
        @yield('content')
    </main>

    <!-- Footer (as before) -->
    <!-- ... -->
<script>
    document.getElementById('theme-toggle')?.addEventListener('click', function() {
        const html = document.documentElement;
        const isDark = html.classList.contains('dark');
        html.classList.toggle('dark', !isDark);
        localStorage.setItem('theme', !isDark ? 'dark' : 'light');
        document.getElementById('theme-icon').className = !isDark ? 'fas fa-sun' : 'fas fa-moon';
    });

    // تطبيق الثيم المحفوظ
    const savedTheme = localStorage.getItem('theme') || 'light';
    document.documentElement.classList.toggle('dark', savedTheme === 'dark');
    document.getElementById('theme-icon').className = savedTheme === 'dark' ? 'fas fa-sun' : 'fas fa-moon';
</script>
    <!-- Scripts -->
    <script>
        // Mobile menu toggle
        document.getElementById('mobile-menu-button')?.addEventListener('click', function() {
            const menu = document.getElementById('mobile-menu');
            menu.classList.toggle('hidden');
        });
    </script>
    <script src="{{ asset('js/theme.js') }}"></script>
    <script src="{{ asset('js/cart.js') }}"></script>
    <script src="{{ asset('js/search.js') }}"></script>
    @stack('scripts')
    @vite('resources/js/app.js')
</body>
</html>