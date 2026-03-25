// Initialize dark mode immediately to prevent flash
(function () {
    const theme = localStorage.getItem('theme');
    const systemDark = window.matchMedia(
        '(prefers-color-scheme: dark)',
    ).matches;
    if (theme === 'dark' || (!theme && systemDark)) {
        document.documentElement.classList.add('dark');
    }
})();

// Dark mode toggle with smooth animation
function toggleDark() {
    const darkBtn = document.getElementById('darkBtn');
    const darkIcon = document.getElementById('darkIcon');

    // Add spin animation
    darkIcon.style.transform = 'rotate(360deg) scale(0.8)';
    darkBtn.classList.add(
        'ring-2',
        'ring-blue-400',
        'ring-offset-2',
        'dark:ring-offset-gray-900',
    );

    setTimeout(() => {
        document.documentElement.classList.toggle('dark');

        if (document.documentElement.classList.contains('dark')) {
            localStorage.setItem('theme', 'dark');
            darkIcon.innerHTML = '☀️';
        } else {
            localStorage.setItem('theme', 'light');
            darkIcon.innerHTML = '🌙';
        }

        // Reset animation
        setTimeout(() => {
            darkIcon.style.transform = 'rotate(0deg) scale(1)';
            darkBtn.classList.remove(
                'ring-2',
                'ring-blue-400',
                'ring-offset-2',
                'dark:ring-offset-gray-900',
            );
        }, 250);
    }, 200);
}

// Initialize button state with animation
(function () {
    const darkBtn = document.getElementById('darkBtn');
    const darkIcon = document.getElementById('darkIcon');
    if (darkBtn && darkIcon) {
        if (document.documentElement.classList.contains('dark')) {
            darkIcon.innerHTML = '☀️';
        } else {
            darkIcon.innerHTML = '🌙';
        }
    }
})();

// Mobile sidebar toggle
const sidebar = document.getElementById('sidebar');
const sidebarOverlay = document.getElementById('sidebarOverlay');
const mobileMenuBtn = document.getElementById('mobileMenuBtn');

mobileMenuBtn.addEventListener('click', () => {
    sidebar.classList.remove('-translate-x-full');
    sidebarOverlay.classList.remove('hidden');
});

function closeSidebar() {
    sidebar.classList.add('-translate-x-full');
    sidebarOverlay.classList.add('hidden');
}

// Filter announcements function with smooth animation
function filterAnnouncements(category, clickedBtn) {
    // Add click animation to the button
    clickedBtn.style.transform = 'scale(0.95)';

    // Show loading overlay with fade in
    const loadingOverlay = document.getElementById('loadingOverlay');
    const loadingContent = document.getElementById('loadingContent');

    setTimeout(() => {
        loadingOverlay.classList.remove('hidden');
        loadingOverlay.classList.add('flex');

        // Trigger reflow for animation
        void loadingOverlay.offsetWidth;

        loadingOverlay.classList.remove('opacity-0');
        loadingContent.classList.remove('scale-95');
        loadingContent.classList.add('scale-100');

        // Update URL with category parameter after short delay for animation
        setTimeout(() => {
            const url = new URL(window.location.href);
            if (category === 'all') {
                url.searchParams.delete('category');
            } else {
                url.searchParams.set('category', category);
            }
            window.location.href = url.toString();
        }, 400);
    }, 150);
}

// Update button styles based on current category with smooth transition
function updateFilterButtons() {
    const currentCategory = '{{ $currentCategory }}'.toLowerCase();
    const buttons = document.querySelectorAll('.filter-btn');

    buttons.forEach((button, index) => {
        const btnCategory = button.getAttribute('data-category');

        // Add staggered animation delay
        setTimeout(() => {
            if (
                btnCategory === currentCategory ||
                (currentCategory === 'all' && btnCategory === 'all')
            ) {
                // Active state with shadow
                button.classList.remove(
                    'bg-white',
                    'dark:bg-gray-800',
                    'text-gray-700',
                    'dark:text-gray-300',
                    'border',
                    'border-gray-300',
                    'dark:border-gray-600',
                    'hover:bg-gray-50',
                    'dark:hover:bg-gray-700',
                    'hover:shadow-md',
                );
                button.classList.add(
                    'bg-blue-600',
                    'text-white',
                    'shadow-lg',
                    'shadow-blue-500/30',
                );
            } else {
                // Inactive state
                button.classList.remove(
                    'bg-blue-600',
                    'text-white',
                    'shadow-lg',
                    'shadow-blue-500/30',
                );
                button.classList.add(
                    'bg-white',
                    'dark:bg-gray-800',
                    'text-gray-700',
                    'dark:text-gray-300',
                    'border',
                    'border-gray-300',
                    'dark:border-gray-600',
                    'hover:bg-gray-50',
                    'dark:hover:bg-gray-700',
                    'hover:shadow-md',
                );
            }
        }, index * 50); // Staggered animation
    });
}

// Initialize filter buttons on page load
document.addEventListener('DOMContentLoaded', updateFilterButtons);
