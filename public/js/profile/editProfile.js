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

// Profile Dropdown
let dropdownOpen = false;

function toggleProfileDropdown() {
    dropdownOpen = !dropdownOpen;
    const dropdownMenu = document.getElementById('dropdownMenu');
    const dropdownArrow = document.getElementById('dropdownArrow');

    if (dropdownOpen) {
        dropdownMenu.classList.remove('hidden');
        dropdownArrow.style.transform = 'rotate(180deg)';
    } else {
        dropdownMenu.classList.add('hidden');
        dropdownArrow.style.transform = 'rotate(0deg)';
    }
}

// Close dropdown when clicking outside
document.addEventListener('click', function (event) {
    const profileDropdown = document.getElementById('profileDropdown');
    if (!profileDropdown.contains(event.target) && dropdownOpen) {
        toggleProfileDropdown();
    }
});

// Edit Profile Modal
function openEditProfileModal() {
    if (dropdownOpen) {
        toggleProfileDropdown();
    }

    fetch(window.profileEditUrl)
        .then((response) => response.json())
        .then((data) => {
            if (data.success) {
                const user = data.user;
                document.getElementById('edit_nisn').value = user.nisn || '';
                document.getElementById('edit_phone').value = user.phone || '';
                document.getElementById('edit_class').value = user.class || '';
                document.getElementById('edit_jurusan').value =
                    user.jurusan || '';
                document.getElementById('edit_gender').value =
                    user.gender || '';
                document.getElementById('edit_birth_date').value =
                    user.birth_date || '';
                document.getElementById('edit_address').value =
                    user.address || '';
            }
        });

    document.getElementById('editProfileModal').classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}

function closeEditProfileModal() {
    document.getElementById('editProfileModal').classList.add('hidden');
    document.body.style.overflow = '';

    // Reset form and messages
    document.getElementById('editProfileForm').reset();
    document.getElementById('profileSuccessMessage').classList.add('hidden');
    document.getElementById('profileErrorMessage').classList.add('hidden');
}

// Close modal when clicking outside
document
    .getElementById('editProfileModal')
    .addEventListener('click', function (e) {
        if (e.target === this) {
            closeEditProfileModal();
        }
    });

// Handle form submission
document
    .getElementById('editProfileForm')
    .addEventListener('submit', function (e) {
        e.preventDefault();

        const formData = new FormData(this);
        const saveBtn = document.getElementById('saveProfileBtn');
        const originalBtnContent = saveBtn.innerHTML;

        // Show loading state
        saveBtn.disabled = true;
        saveBtn.innerHTML =
            '<i class="fa-solid fa-spinner fa-spin"></i> Menyimpan...';

        // Hide previous messages
        document
            .getElementById('profileSuccessMessage')
            .classList.add('hidden');
        document.getElementById('profileErrorMessage').classList.add('hidden');

        formData.append('_method', 'PUT');

        fetch(window.profileUpdateUrl, {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('input[name="_token"]')
                    .value,
                Accept: 'application/json',
                'X-Requested-With': 'XMLHttpRequest',
            },
        })
            .then(async (response) => {
                const data = await response.json();
                if (!response.ok) {
                    throw new Error(data.message || 'Gagal menyimpan data');
                }
                return data;
            })
            .then((data) => {
                if (data.success) {
                    const user = data.user;

                    document.getElementById('edit_nisn').value =
                        user.nisn || '';
                    document.getElementById('edit_phone').value =
                        user.phone || '';
                    document.getElementById('edit_class').value =
                        user.class || '';
                    document.getElementById('edit_jurusan').value =
                        user.jurusan || '';
                    document.getElementById('edit_gender').value =
                        user.gender || '';
                    document.getElementById('edit_birth_date').value =
                        user.birth_date || '';
                    document.getElementById('edit_address').value =
                        user.address || '';
                    document
                        .getElementById('profileErrorMessage')
                        .classList.add('hidden');
                    document
                        .getElementById('profileSuccessMessage')
                        .classList.remove('hidden');
                } else {
                    throw new Error(data.message || 'Update gagal');
                }
            })
            .catch((error) => {
                // 🔥 Sembunyikan success dulu
                document
                    .getElementById('profileSuccessMessage')
                    .classList.add('hidden');

                // Tampilkan error
                document.getElementById('errorMessageText').textContent =
                    error.message;
                document
                    .getElementById('profileErrorMessage')
                    .classList.remove('hidden');
            })
            .finally(() => {
                saveBtn.disabled = false;
                saveBtn.innerHTML = originalBtnContent;
            });
    });
