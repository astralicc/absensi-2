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

// Dropdown toggle
function toggleDropdown(dropdownId) {
    const dropdown = document.getElementById(dropdownId);
    const icon = document.getElementById(dropdownId + 'Icon');

    if (dropdown.classList.contains('open')) {
        dropdown.classList.remove('open');
        icon.style.transform = 'rotate(0deg)';
    } else {
        dropdown.classList.add('open');
        icon.style.transform = 'rotate(180deg)';
    }
}
