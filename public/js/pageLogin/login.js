tailwind.config = {
    darkMode: 'class',
};

// Initialize dark mode on page load
if (
    localStorage.getItem('theme') === 'dark' ||
    (!('theme' in localStorage) &&
        window.matchMedia('(prefers-color-scheme: dark)').matches)
) {
    document.documentElement.classList.add('dark');
}

/* DARK MODE */
const darkBtn = document.getElementById('darkBtn');
const darkIcon = document.getElementById('darkIcon');
if (darkBtn) {
    // Initialize button state based on saved preference or system preference
    if (
        localStorage.getItem('theme') === 'dark' ||
        (!localStorage.getItem('theme') &&
            window.matchMedia('(prefers-color-scheme: dark)').matches)
    ) {
        document.documentElement.classList.add('dark');
        if (darkIcon) {
            darkIcon.textContent = '☀️';
        } else {
            darkBtn.innerHTML = '☀️';
        }
    } else {
        if (darkIcon) {
            darkIcon.textContent = '🌙';
        } else {
            darkBtn.innerHTML = '🌙';
        }
    }

    function toggleDark() {
        const darkIcon = document.getElementById('darkIcon');
        
        // Add animation classes
        darkBtn.classList.add('dark-toggle', 'animate');
        if (darkIcon) {
            darkIcon.style.transform = 'rotate(360deg) scale(0.8)';
        }
        
        setTimeout(() => {
            document.documentElement.classList.toggle('dark');
            
            if (document.documentElement.classList.contains('dark')) {
                localStorage.setItem('theme', 'dark');
                if (darkIcon) darkIcon.textContent = '☀️';
            } else {
                localStorage.setItem('theme', 'light');
                if (darkIcon) darkIcon.textContent = '🌙';
            }
            
            // Reset animation
            setTimeout(() => {
                if (darkIcon) {
                    darkIcon.style.transform = 'rotate(0deg) scale(1)';
                }
                darkBtn.classList.remove('dark-toggle', 'animate');
            }, 250);
        }, 200);
    }
}

/* LOADER */
window.addEventListener('load', () => {
    const loader = document.getElementById('loader');
    if (loader) {
        setTimeout(() => {
            loader.classList.add('hidden');
        }, 800);
    }
});

const btn = document.getElementById('dropdownBtn');
const menu = document.getElementById('dropdownMenu');
const items = document.querySelectorAll('.role-item');
const selected = document.getElementById('selectedRole');
const arrow = document.getElementById('arrowIcon');

// toggle dropdown
if (btn) {
    btn.onclick = () => {
        menu.classList.toggle('opacity-0');
        menu.classList.toggle('scale-95');
        menu.classList.toggle('-translate-y-2');
        menu.classList.toggle('pointer-events-none');

        arrow.classList.toggle('rotate-180');
    };
}

// pilih item
items.forEach((item) => {
    item.onclick = () => {
        selected.innerHTML = item.innerHTML;

        menu.classList.add(
            'opacity-0',
            'scale-95',
            '-translate-y-2',
            'pointer-events-none',
        );
        arrow.classList.remove('rotate-180');
    };
});

// klik luar auto close
document.addEventListener('click', (e) => {
    const dropdown = document.getElementById('roleDropdown');
    if (dropdown && !dropdown.contains(e.target)) {
        menu.classList.add(
            'opacity-0',
            'scale-95',
            '-translate-y-2',
            'pointer-events-none',
        );
        arrow.classList.remove('rotate-180');
    }
});

// PASSWORD TOGGLE
const passwordInput = document.getElementById('passwordInput');
const togglePasswordBtn = document.getElementById('togglePassword');
const eyeIcon = document.getElementById('eyeIcon');

if (togglePasswordBtn && passwordInput) {
    togglePasswordBtn.addEventListener('click', () => {
        const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
        passwordInput.setAttribute('type', type);
        
        // Toggle eye icon
        if (type === 'text') {
            eyeIcon.classList.remove('fa-eye');
            eyeIcon.classList.add('fa-eye-slash');
        } else {
            eyeIcon.classList.remove('fa-eye-slash');
            eyeIcon.classList.add('fa-eye');
        }
    });
}

// ROLE SELECT
const label = document.getElementById('dynamicLabel');
const input = document.getElementById('dynamicInput');
const childField = document.getElementById('childNameField');
const roleInput = document.getElementById('roleInput');
const nisnField = document.getElementById('nisnField');
const nisnInput = document.getElementById('nisnInput');
const muridKelasJurusan = document.getElementById('muridKelasJurusan');

document.addEventListener('DOMContentLoaded', () => {
    items.forEach((item) => {
        item.addEventListener('click', () => {
            selected.innerHTML = item.innerHTML;

            const roleText = item.textContent.trim();

            // Update hidden role input
            if (roleInput) {
                roleInput.value = roleText;
            }

            // animasi smooth untuk label dan input (khusus login page)
            if (label) label.classList.add('opacity-0');
            if (input) input.classList.add('opacity-0');

            setTimeout(() => {
                if (roleText.includes('Murid')) {
                    if (label) {
                        label.textContent = 'NISN';
                    }
                    if (input) {
                        input.placeholder = 'Masukkan NISN';
                        input.classList.remove('hidden');
                    }
                    if (childField) childField.classList.add('hidden');
                    // Show NISN field for Murid (signup page)
                    if (nisnField) nisnField.classList.remove('hidden');
                    if (muridKelasJurusan) muridKelasJurusan.classList.remove('hidden');
                } else if (roleText.includes('Guru')) {
                    if (label) {
                        label.textContent = 'NIP';
                    }
                    if (input) {
                        input.placeholder = 'Masukkan NIP';
                        input.classList.remove('hidden');
                    }
                    if (childField) childField.classList.add('hidden');
                    // Hide NISN field for Guru
                    if (nisnField) nisnField.classList.add('hidden');
                    if (muridKelasJurusan) muridKelasJurusan.classList.add('hidden');
                } else if (roleText.includes('Orang Tua')) {
                    if (label) {
                        label.textContent = 'ID Orang Tua';
                    }
                    if (input) {
                        input.placeholder = 'Masukkan ID Orang Tua';
                        input.classList.remove('hidden');
                    }
                    if (childField) childField.classList.remove('hidden');
                    // Hide NISN field for Orang Tua
                    if (nisnField) nisnField.classList.add('hidden');
                    if (muridKelasJurusan) muridKelasJurusan.classList.add('hidden');
                }

                if (label) label.classList.remove('opacity-0');
                if (input) input.classList.remove('opacity-0');
            }, 150);

            // tutup dropdown
            menu.classList.add(
                'opacity-0',
                'scale-95',
                '-translate-y-2',
                'pointer-events-none',
            );
            arrow.classList.remove('rotate-180');
        });
    });
    
    // Initialize field visibility and labels on page load
    const selectedRole = document.getElementById('selectedRole');
    if (selectedRole) {
        const currentRole = selectedRole.textContent.trim();
        
        // Initialize NISN field visibility (signup page)
        if (nisnField) {
            if (currentRole.includes('Murid')) {
                nisnField.classList.remove('hidden');
            } else {
                nisnField.classList.add('hidden');
            }
        }
        if (muridKelasJurusan) {
            if (currentRole.includes('Murid')) {
                muridKelasJurusan.classList.remove('hidden');
            } else {
                muridKelasJurusan.classList.add('hidden');
            }
        }
        
        // Initialize label and input for login page
        if (label && input) {
            if (currentRole.includes('Murid')) {
                label.textContent = 'NISN';
                input.placeholder = 'Masukkan NISN';
            } else if (currentRole.includes('Guru')) {
                label.textContent = 'NIP';
                input.placeholder = 'Masukkan NIP';
            } else if (currentRole.includes('Orang Tua')) {
                label.textContent = 'ID Orang Tua';
                input.placeholder = 'Masukkan ID Orang Tua';
            }
        }
    }
    
    // Handle Google Signup Data Auto-fill
    const googleIdField = document.getElementById('googleId');
    const nisnFromGoogle = document.getElementById('nisnFromGoogle');
    const nameInput = document.getElementById('nameInput');
    const emailInput = document.getElementById('emailInput');
    
    if (googleIdField && googleIdField.value) {
        // This is a Google signup flow
        console.log('Google signup data detected');
        
        // Auto-fill NISN if available from Google
        if (nisnFromGoogle && nisnFromGoogle.value && nisnInput) {
            nisnInput.value = nisnFromGoogle.value;
            // Add visual indicator that NISN is auto-filled
            nisnInput.classList.add('bg-green-50', 'dark:bg-green-900/20', 'border-green-300', 'dark:border-green-600');
        }
    }
});
