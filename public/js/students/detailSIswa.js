tailwind.config = {
    darkMode: 'class',
};

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
// Dark mode toggle
function toggleDark() {
    document.documentElement.classList.toggle('dark');
    const darkBtn = document.getElementById('darkBtn');
    if (document.documentElement.classList.contains('dark')) {
        localStorage.setItem('theme', 'dark');
        darkBtn.innerHTML = '☀️';
    } else {
        localStorage.setItem('theme', 'light');
        darkBtn.innerHTML = '🌙';
    }
}

// Initialize button state
(function () {
    const darkBtn = document.getElementById('darkBtn');
    if (darkBtn) {
        if (document.documentElement.classList.contains('dark')) {
            darkBtn.innerHTML = '☀️';
        } else {
            darkBtn.innerHTML = '🌙';
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
