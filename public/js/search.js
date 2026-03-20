class SearchManager {
    constructor() {
        this.searchInput = document.getElementById('search-input');
        this.searchResults = document.getElementById('search-results');
        this.searchOverlay = document.getElementById('search-overlay');
        this.debounceTimer = null;
        this.init();
    }

    init() {
        if (!this.searchInput) return;

        this.searchInput.addEventListener('input', () => {
            clearTimeout(this.debounceTimer);
            const query = this.searchInput.value.trim();

            if (query.length < 2) {
                this.hideResults();
                return;
            }

            this.debounceTimer = setTimeout(() => {
                this.performSearch(query);
            }, 300);
        });

        this.searchInput.addEventListener('focus', () => {
            if (this.searchInput.value.trim().length >= 2) {
                this.showResults();
            }
        });

        document.addEventListener('click', (e) => {
            if (!this.searchResults?.contains(e.target) && !this.searchInput?.contains(e.target)) {
                this.hideResults();
            }
        });
    }

    async performSearch(query) {
        try {
            const response = await fetch(`/search/live?q=${encodeURIComponent(query)}`);
            const products = await response.json();

            if (products.length > 0) {
                this.renderResults(products);
                this.showResults();
            } else {
                this.showNoResults();
            }
        } catch (error) {
            console.error('Search error:', error);
            this.showError();
        }
    }

    renderResults(products) {
        if (!this.searchResults) return;

        let html = '<div class="py-2">';

        products.forEach(product => {
            html += `
                <a href="/products/${product.slug}" class="flex items-center px-4 py-3 hover:bg-gray-100 dark:hover:bg-gray-800 transition">
                    <img src="${product.image || '/images/placeholder.jpg'}" alt="${product.name}" class="w-12 h-12 object-cover rounded">
                    <div class="ml-3 flex-1">
                        <div class="text-sm font-medium">${product.name}</div>
                        <div class="text-xs text-gray-500">${product.category}</div>
                    </div>
                    <div class="text-sm font-semibold">${product.price}</div>
                </a>
            `;
        });

        html += `
            <div class="border-t border-gray-200 dark:border-gray-700 mt-2 pt-2">
                <a href="/search?q=${encodeURIComponent(this.searchInput.value)}" class="block px-4 py-2 text-sm text-blue-600 hover:text-blue-700">
                    View all results →
                </a>
            </div>
        `;

        html += '</div>';
        this.searchResults.innerHTML = html;
    }

    showNoResults() {
        if (!this.searchResults) return;

        this.searchResults.innerHTML = `
            <div class="px-4 py-8 text-center">
                <i class="fas fa-search text-4xl text-gray-300 mb-3"></i>
                <p class="text-gray-500">No products found</p>
                <p class="text-sm text-gray-400 mt-1">Try different keywords</p>
            </div>
        `;
        this.showResults();
    }

    showError() {
        if (!this.searchResults) return;

        this.searchResults.innerHTML = `
            <div class="px-4 py-8 text-center">
                <i class="fas fa-exclamation-circle text-4xl text-red-300 mb-3"></i>
                <p class="text-red-500">Something went wrong</p>
                <p class="text-sm text-gray-400 mt-1">Please try again</p>
            </div>
        `;
        this.showResults();
    }

    showResults() {
        if (this.searchOverlay) {
            this.searchOverlay.classList.remove('hidden');
        }
        if (this.searchResults) {
            this.searchResults.classList.remove('hidden');
        }
    }

    hideResults() {
        if (this.searchOverlay) {
            this.searchOverlay.classList.add('hidden');
        }
        if (this.searchResults) {
            this.searchResults.classList.add('hidden');
        }
    }
}

// Initialize search
document.addEventListener('DOMContentLoaded', () => {
    new SearchManager();
});