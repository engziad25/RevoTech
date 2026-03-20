class CartManager {
    constructor() {
        this.cart = null;
        this.init();
    }

    init() {
        this.setupEventListeners();
        this.updateCartCount();
    }

    setupEventListeners() {
        // Add to cart buttons
        document.querySelectorAll('.add-to-cart').forEach(button => {
            button.addEventListener('click', (e) => {
                e.preventDefault();
                const productId = button.dataset.productId;
                const quantity = button.dataset.quantity || 1;
                this.addToCart(productId, quantity);
            });
        });

        // Quantity updates
        document.querySelectorAll('.cart-quantity-input').forEach(input => {
            input.addEventListener('change', (e) => {
                const itemId = input.dataset.itemId;
                this.updateQuantity(itemId, input.value);
            });
        });

        // Remove items
        document.querySelectorAll('.remove-cart-item').forEach(button => {
            button.addEventListener('click', (e) => {
                e.preventDefault();
                const itemId = button.dataset.itemId;
                this.removeItem(itemId);
            });
        });
    }

    async addToCart(productId, quantity = 1) {
        try {
            const response = await fetch(`/cart/add/${productId}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({ quantity })
            });

            const data = await response.json();

            if (data.success) {
                this.showNotification('Product added to cart!', 'success');
                this.updateCartCount(data.cart_count);
                this.updateCartTotal(data.cart_total);
            }
        } catch (error) {
            this.showNotification('Error adding product to cart', 'error');
        }
    }

    async updateQuantity(itemId, quantity) {
        try {
            const response = await fetch(`/cart/update/${itemId}`, {
                method: 'PATCH',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({ quantity })
            });

            const data = await response.json();

            if (data.success) {
                this.updateCartItem(itemId, data.item_total);
                this.updateCartTotal(data.cart_total);
                this.showNotification('Cart updated', 'success');
            }
        } catch (error) {
            this.showNotification('Error updating cart', 'error');
        }
    }

    async removeItem(itemId) {
        if (!confirm('Remove this item from cart?')) return;

        try {
            const response = await fetch(`/cart/remove/${itemId}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            });

            const data = await response.json();

            if (data.success) {
                document.getElementById(`cart-item-${itemId}`)?.remove();
                this.updateCartCount(data.cart_count);
                this.updateCartTotal(data.cart_total);
                this.showNotification('Item removed from cart', 'success');
                
                if (data.cart_count === 0) {
                    this.showEmptyCart();
                }
            }
        } catch (error) {
            this.showNotification('Error removing item', 'error');
        }
    }

    async updateCartCount(count = null) {
        if (count === null) {
            try {
                const response = await fetch('/cart/count');
                const data = await response.json();
                count = data.count;
            } catch (error) {
                return;
            }
        }

        const badges = document.querySelectorAll('.cart-count');
        badges.forEach(badge => {
            badge.textContent = count;
            badge.classList.toggle('hidden', count === 0);
        });
    }

    updateCartTotal(total) {
        const totalElements = document.querySelectorAll('.cart-total');
        totalElements.forEach(el => {
            el.textContent = `$${parseFloat(total).toFixed(2)}`;
        });
    }

    updateCartItem(itemId, subtotal) {
        const itemSubtotal = document.getElementById(`item-subtotal-${itemId}`);
        if (itemSubtotal) {
            itemSubtotal.textContent = `$${parseFloat(subtotal).toFixed(2)}`;
        }
    }

    showEmptyCart() {
        const cartContainer = document.getElementById('cart-items-container');
        if (cartContainer) {
            cartContainer.innerHTML = `
                <div class="text-center py-12">
                    <i class="fas fa-shopping-cart text-6xl text-gray-300 mb-4"></i>
                    <h3 class="text-xl font-medium mb-2">Your cart is empty</h3>
                    <p class="text-gray-500 mb-4">Looks like you haven't added anything yet</p>
                    <a href="/products" class="inline-block px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                        Continue Shopping
                    </a>
                </div>
            `;
        }
    }

    showNotification(message, type = 'success') {
        const notification = document.createElement('div');
        notification.className = `fixed top-4 right-4 px-6 py-3 rounded-lg shadow-lg z-50 animate-slide-up ${
            type === 'success' ? 'bg-green-500' : 'bg-red-500'
        } text-white`;
        notification.textContent = message;

        document.body.appendChild(notification);

        setTimeout(() => {
            notification.remove();
        }, 3000);
    }
}

// Initialize cart
document.addEventListener('DOMContentLoaded', () => {
    window.cartManager = new CartManager();
});