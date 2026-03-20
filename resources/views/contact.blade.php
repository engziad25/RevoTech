@extends('layouts.app')

@section('title', 'Contact Us - RevoTech')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="max-w-3xl mx-auto">
        <h1 class="text-4xl font-bold text-center mb-8">Contact Us</h1>
        <p class="text-center text-gray-600 dark:text-gray-400 mb-12">Have questions? We'd love to hear from you. Send us a message and we'll respond as soon as possible.</p>

        <form action="#" method="POST" class="space-y-6">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="name" class="block text-sm font-medium mb-2">Your Name</label>
                    <input type="text" id="name" name="name" required class="w-full px-4 py-3 border border-gray-300 dark:border-gray-700 rounded-lg focus:ring-2 focus:ring-blue-500 dark:bg-dark-surface">
                </div>
                <div>
                    <label for="email" class="block text-sm font-medium mb-2">Email Address</label>
                    <input type="email" id="email" name="email" required class="w-full px-4 py-3 border border-gray-300 dark:border-gray-700 rounded-lg focus:ring-2 focus:ring-blue-500 dark:bg-dark-surface">
                </div>
            </div>
            <div>
                <label for="subject" class="block text-sm font-medium mb-2">Subject</label>
                <input type="text" id="subject" name="subject" required class="w-full px-4 py-3 border border-gray-300 dark:border-gray-700 rounded-lg focus:ring-2 focus:ring-blue-500 dark:bg-dark-surface">
            </div>
            <div>
                <label for="message" class="block text-sm font-medium mb-2">Message</label>
                <textarea id="message" name="message" rows="6" required class="w-full px-4 py-3 border border-gray-300 dark:border-gray-700 rounded-lg focus:ring-2 focus:ring-blue-500 dark:bg-dark-surface"></textarea>
            </div>
            <div class="text-center">
                <button type="submit" class="px-8 py-4 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                    Send Message
                </button>
            </div>
        </form>

        <!-- Contact Info -->
        <div class="mt-16 grid grid-cols-1 md:grid-cols-3 gap-8 text-center">
            <div>
                <i class="fas fa-map-marker-alt text-3xl text-blue-600 mb-4"></i>
                <h3 class="font-semibold mb-2">Visit Us</h3>
                <p class="text-gray-600 dark:text-gray-400">123 Tech Street<br>Silicon Valley, CA 94000</p>
            </div>
            <div>
                <i class="fas fa-phone text-3xl text-blue-600 mb-4"></i>
                <h3 class="font-semibold mb-2">Call Us</h3>
                <p class="text-gray-600 dark:text-gray-400">+1 (555) 123-4567<br>Mon-Fri 9am-6pm</p>
            </div>
            <div>
                <i class="fas fa-envelope text-3xl text-blue-600 mb-4"></i>
                <h3 class="font-semibold mb-2">Email Us</h3>
                <p class="text-gray-600 dark:text-gray-400">support@revotech.com<br>info@revotech.com</p>
            </div>
        </div>
    </div>
</div>
@endsection