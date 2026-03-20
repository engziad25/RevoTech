@extends('layouts.app')

@section('title', 'RevoTech - Premium Electronics')

@section('content')
    <!-- Hero Section -->
    <section class="relative bg-gradient-to-br from-blue-50 to-purple-50 dark:from-dark-surface dark:to-dark-bg overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20">
            <div class="text-center">
                <h1 class="text-5xl md:text-6xl font-bold mb-6 bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent animate-fade-in">
                    Welcome to RevoTech
                </h1>
                <p class="text-xl text-gray-600 dark:text-gray-400 mb-10 max-w-2xl mx-auto animate-slide-up">
                    Discover the latest in cutting-edge technology. From smartphones to laptops, we've got you covered.
                </p>
                <div class="flex justify-center space-x-4 animate-slide-up">
                    <a href="{{ route('products.index') }}" class="px-8 py-4 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition transform hover:scale-105">
                        Shop Now
                    </a>
                    <a href="#featured" class="px-8 py-4 border-2 border-blue-600 text-blue-600 dark:text-cyan-400 dark:border-cyan-400 rounded-lg hover:bg-blue-600 hover:text-white transition">
                        Explore
                    </a>
                </div>
            </div>
        </div>
        
        <!-- Decorative elements -->
        <div class="absolute top-0 left-0 w-64 h-64 bg-blue-400 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-pulse"></div>
        <div class="absolute bottom-0 right-0 w-64 h-64 bg-purple-400 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-pulse"></div>
    </section>

    <!-- Categories -->
    <section class="py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-3xl font-bold text-center mb-12">Shop by Category</h2>
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-6">
                @foreach($categories as $category)
                <a href="{{ route('products.index', ['category' => $category->id]) }}" 
                   class="group relative overflow-hidden rounded-2xl bg-white dark:bg-dark-surface shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                    <div class="aspect-square p-6">
                        @if($category->image)
                        <img src="{{ asset($category->image) }}" alt="{{ $category->name }}" class="w-full h-full object-contain group-hover:scale-110 transition duration-300">
                        @else
                        <div class="w-full h-full bg-gradient-to-br from-blue-400 to-purple-400 rounded-lg flex items-center justify-center">
                            <i class="fas fa-tag text-4xl text-white"></i>
                        </div>
                        @endif
                    </div>
                    <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-end justify-center pb-4">
                        <span class="text-white font-medium">{{ $category->name }}</span>
                    </div>
                </a>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Featured Products -->
    <section id="featured" class="py-16 bg-gray-50 dark:bg-dark-surface">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-3xl font-bold text-center mb-4">Featured Products</h2>
            <p class="text-center text-gray-600 dark:text-gray-400 mb-12">Hand-picked just for you</p>
            
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
                @foreach($featuredProducts as $product)
                <x-product-card :product="$product" />
                @endforeach
            </div>
        </div>
    </section>

    <!-- New Arrivals -->
    <section class="py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-3xl font-bold text-center mb-4">New Arrivals</h2>
            <p class="text-center text-gray-600 dark:text-gray-400 mb-12">The latest tech, just landed</p>
            
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
                @foreach($newArrivals as $product)
                <x-product-card :product="$product" />
                @endforeach
            </div>
            
            <div class="text-center mt-12">
                <a href="{{ route('products.index') }}" class="inline-block px-8 py-3 border-2 border-blue-600 text-blue-600 dark:text-cyan-400 dark:border-cyan-400 rounded-lg hover:bg-blue-600 hover:text-white transition">
                    View All Products
                </a>
            </div>
        </div>
    </section>

    <!-- Newsletter -->
    <section class="py-16 bg-gradient-to-r from-blue-600 to-purple-600 text-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-3xl font-bold mb-4">Stay Updated</h2>
            <p class="text-xl mb-8 opacity-90">Subscribe to get the latest deals and product updates</p>
            <form class="max-w-md mx-auto flex">
                <input type="email" 
                       placeholder="Enter your email" 
                       class="flex-1 px-4 py-3 rounded-l-lg text-gray-900 focus:outline-none">
                <button type="submit" class="px-6 py-3 bg-white text-blue-600 rounded-r-lg font-semibold hover:bg-gray-100 transition">
                    Subscribe
                </button>
            </form>
        </div>
    </section>
@endsection