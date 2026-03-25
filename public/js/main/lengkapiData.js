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

function toggleRoleFields() {
    const role = document.getElementById('role').value;
    const nisnField = document.getElementById('nisn-field');
    const childField = document.getElementById('child-field');
    const identifierLabel = document.getElementById('identifier-label');
    const identifierHint = document.getElementById('identifier-hint');
    const nisnInput = document.getElementById('nisn');
    const childInput = document.getElementById('child_name');

    // Reset all fields
    nisnField.classList.add('hidden');
    childField.classList.add('hidden');
    nisnInput.removeAttribute('required');
    childInput.removeAttribute('required');

    if (role === 'Murid') {
        nisnField.classList.remove('hidden');
        nisnInput.setAttribute('required', 'required');
        identifierLabel.textContent = 'NIS (Nomor Induk Siswa)';
        identifierHint.textContent = 'Masukkan Nomor Induk Siswa';
    } else if (role === 'Guru') {
        identifierLabel.textContent = 'NIP (Nomor Induk Pegawai)';
        identifierHint.textContent = 'Masukkan Nomor Induk Pegawai';
    } else if (role === 'Orang Tua') {
        childField.classList.remove('hidden');
        childInput.setAttribute('required', 'required');
        identifierLabel.textContent = 'ID Orang Tua';
        identifierHint.textContent = 'Masukkan ID Orang Tua';
    } else {
        identifierLabel.textContent = 'Nomor Identitas';
        identifierHint.textContent =
            'NIS untuk siswa, NIP untuk guru, atau ID untuk orang tua';
    }
}

// Initialize on page load
document.addEventListener('DOMContentLoaded', toggleRoleFields);
