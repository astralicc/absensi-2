// Wali-Kelas Sidebar & Theme Controls
// Mobile sidebar toggle
document.addEventListener('DOMContentLoaded', function() {
    const mobileMenuBtn = document.getElementById('mobileMenuBtn');
    const sidebar = document.getElementById('sidebar');
    const sidebarOverlay = document.getElementById('sidebarOverlay');
    
    if (mobileMenuBtn && sidebar && sidebarOverlay) {
        mobileMenuBtn.onclick = () => {
            sidebar.classList.toggle('-translate-x-full');
            sidebarOverlay.classList.toggle('hidden');
        };
    }
});

function closeSidebar() {
    const sidebar = document.getElementById('sidebar');
    const sidebarOverlay = document.getElementById('sidebarOverlay');
    if (sidebar) sidebar.classList.add('-translate-x-full');
    if (sidebarOverlay) sidebarOverlay.classList.add('hidden');
}

// Dark mode toggle
function toggleDark() {
    document.documentElement.classList.toggle('dark');
    localStorage.theme = document.documentElement.classList.contains('dark') ? 'dark' : 'light';
    updateDarkIcon();
}

// Update dark mode icon
function updateDarkIcon() {
    const darkIcon = document.getElementById('darkIcon');
    if (darkIcon) {
        if (document.documentElement.classList.contains('dark')) {
            darkIcon.textContent = '☀️';
        } else {
            darkIcon.textContent = '🌙';
        }
    }
}

// Enhanced theme initialization with icon sync
if (typeof updateDarkIcon !== 'function') {
    function updateDarkIcon() {
        const darkIcon = document.getElementById('darkIcon');
        if (darkIcon) {
            if (document.documentElement.classList.contains('dark')) {
                darkIcon.textContent = '☀️';
            } else {
                darkIcon.textContent = '🌙';
            }
        }
    }
}

// Load theme on page load
document.addEventListener('DOMContentLoaded', function() {
    if (localStorage.theme === 'dark' || (!localStorage.theme && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
        document.documentElement.classList.add('dark');
        updateDarkIcon();
    } else {
        updateDarkIcon();
    }
});
</xai:function_call





<xai:function_call name="edit_file">
<parameter name="path">c:/Users/Reza/Documents/project absensi/absensi-2/resources/views/wali-kelas/index.blade.php
