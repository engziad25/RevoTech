// Theme Toggle with Smooth Transition
class ThemeManager {
    constructor() {
        this.theme = localStorage.getItem('theme') || 'light';
        this.init();
    }

    init() {
        document.documentElement.classList.toggle('dark', this.theme === 'dark');
        this.updateThemeIcon();
        this.setupListeners();
    }

    setupListeners() {
        document.getElementById('theme-toggle')?.addEventListener('click', () => {
            this.toggle();
        });
    }

    toggle() {
        this.theme = this.theme === 'light' ? 'dark' : 'light';
        localStorage.setItem('theme', this.theme);
        
        // Smooth transition
        document.documentElement.classList.add('theme-transition');
        document.documentElement.classList.toggle('dark', this.theme === 'dark');
        
        setTimeout(() => {
            document.documentElement.classList.remove('theme-transition');
        }, 300);

        this.updateThemeIcon();
        this.updateMetaThemeColor();
    }

    updateThemeIcon() {
        const icon = document.getElementById('theme-icon');
        if (icon) {
            icon.className = this.theme === 'light' ? 'fas fa-moon' : 'fas fa-sun';
        }
    }

    updateMetaThemeColor() {
        const meta = document.querySelector('meta[name="theme-color"]');
        if (meta) {
            meta.content = this.theme === 'light' ? '#ffffff' : '#0a0a0f';
        }
    }
}

// Initialize theme
new ThemeManager();