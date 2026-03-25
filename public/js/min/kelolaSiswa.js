tailwind.config = {
    darkMode: 'class',
};

(function () {
    const theme = localStorage.getItem('theme');
    const systemDark = window.matchMedia(
        '(prefers-color-scheme: dark)',
    ).matches;
    if (theme === 'dark' || (!theme && systemDark)) {
        document.documentElement.classList.add('dark');
    }
})();

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
