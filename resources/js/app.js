// Load bootstrap (axios, lodash, etc.)
import './bootstrap';

// Import Tailwind CSS
import '../css/app.css';

// Example JS: Live search or interactive UI
document.addEventListener('DOMContentLoaded', () => {
    console.log('App.js loaded successfully');

    // Example: toggle wishlist button
    const wishlistBtns = document.querySelectorAll('.wishlist-toggle');
    wishlistBtns.forEach(btn => {
        btn.addEventListener('click', () => {
            btn.classList.toggle('text-red-500');
        });
    });
});