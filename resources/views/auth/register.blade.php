@extends('layouts.app')

@section('title', 'Register - RevoTech')

@section('content')
<div class="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8">
        <div>
            <h2 class="mt-6 text-center text-3xl font-extrabold">Create your account</h2>
            <p class="mt-2 text-center text-sm text-gray-600 dark:text-gray-400">
                Or
                <a href="{{ route('login') }}" class="font-medium text-blue-600 hover:text-blue-500">
                    sign in to existing account
                </a>
            </p>
        </div>

        <form class="mt-8 space-y-6" method="POST" action="{{ route('register') }}">
            @csrf

            <!-- Name -->
            <div>
                <label for="name" class="block text-sm font-medium mb-2">Full Name</label>
                <input id="name" 
                       name="name" 
                       type="text" 
                       required 
                       value="{{ old('name') }}"
                       class="appearance-none relative block w-full px-3 py-3 border border-gray-300 dark:border-gray-600 placeholder-gray-500 text-gray-900 dark:text-white dark:bg-dark-surface rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 focus:z-10 sm:text-sm @error('name') border-red-500 @enderror"
                       placeholder="John Doe">
                @error('name')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Email -->
            <div>
                <label for="email" class="block text-sm font-medium mb-2">Email Address</label>
                <input id="email" 
                       name="email" 
                       type="email" 
                       required 
                       value="{{ old('email') }}"
                       class="appearance-none relative block w-full px-3 py-3 border border-gray-300 dark:border-gray-600 placeholder-gray-500 text-gray-900 dark:text-white dark:bg-dark-surface rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 focus:z-10 sm:text-sm @error('email') border-red-500 @enderror"
                       placeholder="you@example.com">
                @error('email')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Password -->
            <div>
                <label for="password" class="block text-sm font-medium mb-2">Password</label>
                <input id="password" 
                       name="password" 
                       type="password" 
                       required 
                       class="appearance-none relative block w-full px-3 py-3 border border-gray-300 dark:border-gray-600 placeholder-gray-500 text-gray-900 dark:text-white dark:bg-dark-surface rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 focus:z-10 sm:text-sm @error('password') border-red-500 @enderror"
                       placeholder="••••••••">
                @error('password')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Confirm Password -->
            <div>
                <label for="password_confirmation" class="block text-sm font-medium mb-2">Confirm Password</label>
                <input id="password_confirmation" 
                       name="password_confirmation" 
                       type="password" 
                       required 
                       class="appearance-none relative block w-full px-3 py-3 border border-gray-300 dark:border-gray-600 placeholder-gray-500 text-gray-900 dark:text-white dark:bg-dark-surface rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 focus:z-10 sm:text-sm"
                       placeholder="••••••••">
            </div>

            <!-- Terms and Conditions -->
            <div class="flex items-center">
                <input id="terms" name="terms" type="checkbox" required class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                <label for="terms" class="ml-2 block text-sm text-gray-900 dark:text-gray-300">
                    I agree to the 
                    <a href="#" class="font-medium text-blue-600 hover:text-blue-500">Terms of Service</a> 
                    and 
                    <a href="#" class="font-medium text-blue-600 hover:text-blue-500">Privacy Policy</a>
                </label>
            </div>

            <!-- Submit Button -->
            <div>
                <button type="submit" 
                        class="group relative w-full flex justify-center py-3 px-4 border border-transparent text-sm font-medium rounded-lg text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition transform hover:scale-105">
                    <span class="absolute left-0 inset-y-0 flex items-center pl-3">
                        <i class="fas fa-user-plus text-blue-500 group-hover:text-blue-400"></i>
                    </span>
                    Create Account
                </button>
            </div>
        </form>

        <!-- Social Login (Optional) -->
        <div class="mt-6">
            <div class="relative">
                <div class="absolute inset-0 flex items-center">
                    <div class="w-full border-t border-gray-300 dark:border-gray-600"></div>
                </div>
                <div class="relative flex justify-center text-sm">
                    <span class="px-2 bg-light-bg dark:bg-dark-bg text-gray-500">Or continue with</span>
                </div>
            </div>

            <div class="mt-6 grid grid-cols-2 gap-3">
                <button class="w-full inline-flex justify-center py-2 px-4 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm bg-white dark:bg-dark-surface text-sm font-medium text-gray-500 hover:bg-gray-50 dark:hover:bg-gray-800 transition">
                    <i class="fab fa-google mr-2"></i> Google
                </button>
                <button class="w-full inline-flex justify-center py-2 px-4 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm bg-white dark:bg-dark-surface text-sm font-medium text-gray-500 hover:bg-gray-50 dark:hover:bg-gray-800 transition">
                    <i class="fab fa-facebook mr-2"></i> Facebook
                </button>
            </div>
        </div>
    </div>
</div>
@endsection