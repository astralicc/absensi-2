<!DOCTYPE html>
<html lang="id" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporkan Absensi - Absensi SMKN 12 Jakarta</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css"
        integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="icon" href="/logo.png">
    <link rel="stylesheet" href="{{ asset('css/students/laporanSiswa.css') }}">
</head>

<body class="text-gray-800 dark:text-gray-200 bg-gray-100 dark:bg-gray-950 min-h-screen">

    <!-- Sidebar & Main Content Wrapper -->
    <div class="flex h-screen overflow-hidden">

        <!-- Sidebar -->
        <aside id="sidebar"
            class="fixed inset-y-0 left-0 z-50 w-64 bg-white dark:bg-gray-900 border-r border-gray-200 dark:border-gray-700 transform -translate-x-full md:translate-x-0 transition-transform duration-300 ease-in-out">
            <!-- Logo -->
            <div class="flex items-center justify-center h-16 border-b border-gray-200 dark:border-gray-700">
                <img src="/assets/logo.png" alt="Logo" class="h-8 w-auto">
                <span class="ml-2 font-bold text-sm text-gray-900 dark:text-white">Absensi SMKN 12 Jakarta</span>
            </div>

            <!-- Navigation -->
            <nav class="mt-6 px-4 space-y-2">
                <a href="{{ route('dashboard') }}"
                    class="flex items-center px-4 py-3 text-gray-600 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-800 rounded-lg transition">
                    <i class="fa-solid fa-house w-6 mr-3"></i>
                    <span class="font-medium">Dashboard</span>
                </a>

                <a href="{{ route('attendance.history') }}"
                    class="flex items-center px-4 py-3 text-gray-600 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-800 rounded-lg transition">
                    <i class="fa-solid fa-calendar-check w-6 mr-3"></i>
                    <span>Riwayat Absensi</span>
                </a>

                <a href="{{ route('schedule.index') }}"
                    class="flex items-center px-4 py-3 text-gray-600 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-800 rounded-lg transition">
                    <i class="fa-solid fa-book w-6 mr-3"></i>
                    <span>Jadwal Pelajaran</span>
                </a>

                <a href="{{ route('attendance.report') }}"
                    class="flex items-center px-4 py-3 text-gray-700 dark:text-gray-300 bg-blue-50 dark:bg-blue-900/20 rounded-lg border-l-4 border-blue-500">
                    <i class="fa-solid fa-triangle-exclamation w-6 mr-3"></i>
                    <span>Laporkan Absensi</span>
                </a>


                <a href="{{ route('announcements.index') }}"
                    class="flex items-center px-4 py-3 text-gray-600 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-800 rounded-lg transition">
                    <i class="fa-solid fa-bullhorn w-6 mr-3"></i>
                    <span>Pengumuman</span>
                    @if ($unreadCount > 0)
                        <span
                            class="ml-auto bg-red-500 text-white text-xs font-bold px-2 py-1 rounded-full">{{ $unreadCount }}</span>
                    @endif
                </a>

            </nav>

            <!-- Bottom Actions -->
            <div class="absolute bottom-0 w-full p-4 border-t border-gray-200 dark:border-gray-700">
                <form action="{{ route('logout') }}" method="POST" class="w-full">
                    @csrf
                    <button type="submit"
                        class="flex items-center w-full px-4 py-3 text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20 rounded-lg transition">
                        <i class="fa-solid fa-right-from-bracket w-6 mr-3"></i>
                        <span class="font-medium">Logout</span>
                    </button>
                </form>
            </div>
        </aside>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col md:ml-64">

            <!-- Top Header -->
            <header
                class="glass sticky top-0 z-40 h-16 border-b border-gray-200 dark:border-gray-700 px-6 flex items-center justify-between">
                <!-- Mobile Menu Button -->
                <button id="mobileMenuBtn"
                    class="md:hidden p-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-800 transition">
                    <i class="fa-solid fa-bars text-xl"></i>
                </button>

                <!-- Page Title -->
                <h1 class="text-xl font-semibold text-gray-900 dark:text-white hidden md:block">
                    Laporkan Absensi Tidak Sesuai
                </h1>

                <!-- Right Actions -->
                <div class="flex items-center gap-4">
                    <!-- Dark Mode Toggle -->
                    <button onclick="toggleDark()" id="darkBtn"
                        class="p-2 rounded-lg bg-gray-200 dark:bg-gray-700 transition-all duration-300 ease-in-out transform hover:scale-110 active:scale-95 hover:shadow-lg dark:hover:shadow-gray-700/50 relative overflow-hidden">
                        <span id="darkIcon" class="block transition-transform duration-500 ease-in-out">🌙</span>
                    </button>

                    <!-- User Profile -->
                    <div class="flex items-center gap-3 pl-4 border-l border-gray-200 dark:border-gray-700">
                        <div class="text-right hidden sm:block">
                            <p class="text-sm font-medium text-gray-900 dark:text-white">{{ auth()->user()->name }}</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400">Siswa</p>
                        </div>
                        <div
                            class="h-10 w-10 rounded-full bg-blue-500 flex items-center justify-center text-white font-bold">
                            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                        </div>
                    </div>
                </div>
            </header>

            <!-- Page Content -->
            <main class="flex-1 overflow-y-auto p-6">

                <!-- Back Button -->
                <div class="mb-6">
                    <a href="{{ route('dashboard') }}"
                        class="inline-flex items-center text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white transition">
                        <i class="fa-solid fa-arrow-left mr-2"></i>
                        Kembali ke Dashboard
                    </a>
                </div>

                <!-- Welcome Card -->
                <div class="mb-8 p-6 bg-gradient-to-r from-blue-500 to-blue-600 rounded-2xl shadow-lg text-white">
                    <h2 class="text-2xl font-bold mb-2">Laporkan Absensi Tidak Sesuai 📋</h2>
                    <p class="text-blue-100">
                        Gunakan fitur ini untuk melaporkan ketidaksesuaian data absensi Anda.
                        Laporan akan dikirim ke admin melalui WhatsApp atau Email.
                    </p>
                </div>


                <!-- Report Form -->
                <div
                    class="max-w-2xl mx-auto bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
                    <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                        <h2 class="text-xl font-bold text-gray-900 dark:text-white">Form Laporan</h2>
                        <p class="text-gray-600 dark:text-gray-400 mt-1">Isi detail ketidaksesuaian absensi Anda</p>
                    </div>

                    <form id="reportForm" class="p-6 space-y-6">
                        @csrf

                        <!-- Student Info (Read-only) -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Nama Siswa
                                </label>
                                <input type="text" value="{{ auth()->user()->name }}" readonly
                                    class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-400 cursor-not-allowed">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    NISN
                                </label>
                                <input type="text" value="{{ auth()->user()->nisn ?? '-' }}" readonly
                                    class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-400 cursor-not-allowed">
                            </div>
                        </div>

                        <!-- Date -->
                        <div>
                            <label for="report_date"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Tanggal Absensi Bermasalah <span class="text-red-500">*</span>
                            </label>
                            <input type="date" id="report_date" name="report_date" required
                                class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        </div>

                        <!-- Issue Type -->
                        <div>
                            <label for="issue_type"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Jenis Masalah <span class="text-red-500">*</span>
                            </label>
                            <select id="issue_type" name="issue_type" required
                                class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent">

                                <option value="">Pilih Jenis Masalah</option>
                                <option value="sudah_hadir_dicatat_absen">Sudah hadir tapi dicatat absen</option>
                                <option value="sudah_absen_dicatat_hadir">Sudah izin tapi dicatat absen</option>
                                <option value="waktu_tidak_sesuai">Waktu absensi tidak sesuai</option>
                                <option value="double_absensi">Absensi tercatat double</option>
                                <option value="tidak_absen_dicatat_hadir">Tidak absen tapi dicatat hadir</option>
                                <option value="lainnya">Lainnya</option>
                            </select>
                        </div>

                        <!-- Description -->
                        <div>
                            <label for="description"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Keterangan Detail <span class="text-red-500">*</span>
                            </label>
                            <textarea id="description" name="description" rows="4" required
                                class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                placeholder="Jelaskan detail masalah yang Anda alami..."></textarea>
                        </div>


                        <!-- Contact Method -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-3">
                                Pilih Cara Pelaporan <span class="text-red-500">*</span>
                            </label>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <label
                                    class="flex items-center p-4 border border-gray-300 dark:border-gray-600 rounded-lg cursor-pointer hover:bg-green-50 dark:hover:bg-green-900/20 transition">
                                    <input type="radio" name="contact_method" value="whatsapp" checked
                                        class="w-4 h-4 text-green-600 focus:ring-green-500">
                                    <div class="ml-3 flex items-center gap-2">
                                        <i class="fa-brands fa-whatsapp text-green-600 text-xl"></i>
                                        <span class="font-medium text-gray-700 dark:text-gray-300">WhatsApp</span>
                                    </div>
                                </label>
                                <label
                                    class="flex items-center p-4 border border-gray-300 dark:border-gray-600 rounded-lg cursor-pointer hover:bg-blue-50 dark:hover:bg-blue-900/20 transition">
                                    <input type="radio" name="contact_method" value="email"
                                        class="w-4 h-4 text-blue-600 focus:ring-blue-500">
                                    <div class="ml-3 flex items-center gap-2">
                                        <i class="fa-solid fa-envelope text-blue-600 text-xl"></i>
                                        <span class="font-medium text-gray-700 dark:text-gray-300">Email</span>
                                    </div>
                                </label>
                            </div>
                        </div>

                        <!-- Submit Buttons -->
                        <div
                            class="flex items-center justify-end gap-4 pt-4 border-t border-gray-200 dark:border-gray-700">
                            <a href="{{ route('dashboard') }}"
                                class="px-6 py-2 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                                Batal
                            </a>
                            <button type="submit"
                                class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition flex items-center gap-2">
                                <i class="fa-solid fa-paper-plane"></i>
                                Kirim Laporan
                            </button>

                        </div>
                    </form>
                </div>

            </main>
        </div>
    </div>

    <!-- Mobile Sidebar Overlay -->
    <div id="sidebarOverlay" class="fixed inset-0 bg-black/50 z-40 hidden md:hidden" onclick="closeSidebar()"></div>

</body>
<script src="{{ asset('js/students/laporanSiswa.js') }}"></script>
</html>
