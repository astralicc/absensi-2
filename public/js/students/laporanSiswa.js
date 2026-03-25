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

// Form submission
document.getElementById('reportForm').addEventListener('submit', function (e) {
    e.preventDefault();

    const formData = new FormData(this);
    const studentName = '{{ auth()->user()->name }}';
    const nisn = '{{ auth()->user()->nisn ?? ' - ' }}';
    const date = formData.get('report_date');
    const issueType = formData.get('issue_type');
    const description = formData.get('description');
    const contactMethod = formData.get('contact_method');

    const issueLabels = {
        sudah_hadir_dicatat_absen: 'Sudah hadir tapi dicatat absen',
        sudah_absen_dicatat_hadir: 'Sudah izin tapi dicatat absen',
        waktu_tidak_sesuai: 'Waktu absensi tidak sesuai',
        double_absensi: 'Absensi tercatat double',
        tidak_absen_dicatat_hadir: 'Tidak absen tapi dicatat hadir',
        lainnya: 'Lainnya',
    };

    const message =
        `*LAPORAN ABSENSI TIDAK SESUAI*%0A%0A` +
        `*Data Siswa:*%0A` +
        `Nama: ${studentName}%0A` +
        `NISN: ${nisn}%0A%0A` +
        `*Detail Laporan:*%0A` +
        `Tanggal: ${date}%0A` +
        `Jenis Masalah: ${issueLabels[issueType]}%0A` +
        `Keterangan: ${description}%0A%0A` +
        `Mohon untuk ditindaklanjuti. Terima kasih.`;

    if (contactMethod === 'whatsapp') {
        // Get admin WhatsApp from settings (default number)
        const adminWhatsapp = '{{ $adminWhatsapp ?? "081234567890" }}';
        const whatsappUrl = `https://wa.me/${adminWhatsapp}?text=${message}`;
        window.open(whatsappUrl, '_blank');
    } else {
        // Email
        const adminEmail = '{{ $adminEmail ?? "admin@smkn12jakarta.sch.id" }}';
        const subject = `Laporan Absensi Tidak Sesuai - ${studentName} (${nisn})`;
        const body = message.replace(/%0A/g, '\n').replace(/%0A/g, '\n');
        const mailtoUrl = `mailto:${adminEmail}?subject=${encodeURIComponent(subject)}&body=${encodeURIComponent(body)}`;
        window.location.href = mailtoUrl;
    }
});
