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
    const darkBtn = document.getElementById('darkBtn');
    const darkIcon = document.getElementById('darkIcon');

    const apply = () => {
        document.documentElement.classList.toggle('dark');
        const isDark = document.documentElement.classList.contains('dark');
        localStorage.setItem('theme', isDark ? 'dark' : 'light');
        if (darkIcon) {
            darkIcon.innerHTML = isDark ? '☀️' : '🌙';
            darkIcon.style.transform = 'rotate(0deg) scale(1)';
        } else if (darkBtn) {
            darkBtn.innerHTML = isDark ? '☀️' : '🌙';
        }
    };

    if (!darkBtn || !darkIcon) {
        apply();
        return;
    }

    darkIcon.style.transform = 'rotate(360deg) scale(0.8)';
    darkBtn.classList.add(
        'ring-2',
        'ring-blue-400',
        'ring-offset-2',
        'dark:ring-offset-gray-900',
    );

    setTimeout(() => {
        apply();
        setTimeout(() => {
            darkBtn.classList.remove(
                'ring-2',
                'ring-blue-400',
                'ring-offset-2',
                'dark:ring-offset-gray-900',
            );
        }, 250);
    }, 200);
}

(function () {
    const darkBtn = document.getElementById('darkBtn');
    const darkIcon = document.getElementById('darkIcon');
    const isDark = document.documentElement.classList.contains('dark');
    if (darkIcon) {
        darkIcon.innerHTML = isDark ? '☀️' : '🌙';
    } else if (darkBtn) {
        darkBtn.innerHTML = isDark ? '☀️' : '🌙';
    }
})();

const sidebar = document.getElementById('sidebar');
const sidebarOverlay = document.getElementById('sidebarOverlay');
const mobileMenuBtn = document.getElementById('mobileMenuBtn');

if (mobileMenuBtn && sidebar && sidebarOverlay) {
    mobileMenuBtn.addEventListener('click', () => {
        sidebar.classList.remove('-translate-x-full');
        sidebarOverlay.classList.remove('hidden');
    });
}

function closeSidebar() {
    if (sidebar) {
        sidebar.classList.add('-translate-x-full');
    }
    if (sidebarOverlay) {
        sidebarOverlay.classList.add('hidden');
    }
}

function toggleDropdown(dropdownId) {
    const dropdown = document.getElementById(dropdownId);
    const icon = document.getElementById(dropdownId + 'Icon');
    if (!dropdown || !icon) {
        return;
    }

    if (dropdown.classList.contains('open')) {
        dropdown.classList.remove('open');
        icon.style.transform = 'rotate(0deg)';
    } else {
        dropdown.classList.add('open');
        icon.style.transform = 'rotate(180deg)';
    }
}
