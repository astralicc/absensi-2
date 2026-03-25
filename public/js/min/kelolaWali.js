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

    const apply = () => {
        document.documentElement.classList.toggle('dark');
        const isDark = document.documentElement.classList.contains('dark');
        localStorage.setItem('theme', isDark ? 'dark' : 'light');
        if (darkIcon) {
            darkIcon.innerHTML = isDark ? '☀️' : '🌙';
            darkIcon.style.transform = 'rotate(0deg) scale(1)';
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

// Initialize button state
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

if (mobileMenuBtn) {
    mobileMenuBtn.addEventListener('click', function() {
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

// Dropdown toggle (use CSS .dropdown-menu.open only — never Tailwind "hidden" or toggle breaks on settings)
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

// Modal functions
function openModal(id, name, kelas, jurusan) {
    document.getElementById('guruIdInput').value = id;
    document.getElementById('guruName').textContent = 'Guru: ' + name;
    document.getElementById('kelas_wali').value = kelas || '';
    document.getElementById('jurusan_wali').value = jurusan || '';
    document.getElementById('waliKelasForm').action = `/x-admin/wali-kelas/${id}`;
    document.getElementById('waliKelasModal').classList.remove('hidden');
}

function closeModal() {
    document.getElementById('waliKelasModal').classList.add('hidden');
}

// Close modal when clicking outside
const waliKelasModalEl = document.getElementById('waliKelasModal');
if (waliKelasModalEl) {
    waliKelasModalEl.addEventListener('click', function (e) {
        if (e.target === this) {
            closeModal();
        }
    });
}

// Form submission with fetch API for better UX
const waliKelasFormEl = document.getElementById('waliKelasForm');
if (waliKelasFormEl) {
waliKelasFormEl.addEventListener('submit', function(e) {
    e.preventDefault();
    
    const formData = new FormData(this);
    const submitBtn = this.querySelector('button[type="submit"]');
    const originalText = submitBtn.textContent;
    
    submitBtn.disabled = true;
    submitBtn.textContent = 'Menyimpan...';
    
    fetch(this.action, {
        method: 'POST',
        body: formData,
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json',
        }
    })
    .then(response => {
        if (!response.ok) {
            return response.json().then(err => { throw err; });
        }
        return response.json();
    })
    .then(data => {
        location.reload(); // Refresh page on success
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Terjadi kesalahan: ' + (error.message || 'Silakan coba lagi'));
    })
    .finally(() => {
        submitBtn.disabled = false;
        submitBtn.textContent = originalText;
    });
});
}

// Initialize dropdown states on page load to respect server-side 'open' class
document.addEventListener('DOMContentLoaded', function() {
    // Check all dropdowns
    document.querySelectorAll('.dropdown-menu').forEach(function(dropdown) {
        const dropdownId = dropdown.id;
        const icon = document.getElementById(dropdownId + 'Icon');
        
        if (dropdown.classList.contains('open')) {
            dropdown.classList.remove('hidden');
            if (icon) {
                icon.style.transform = 'rotate(180deg)';
            }
        }
    });
});
