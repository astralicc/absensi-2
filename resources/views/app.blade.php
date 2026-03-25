<!DOCTYPE html>
<html lang="id" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Absensi 12 Jakarta</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css"
        integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="{{ asset('css/dashboard/style.css') }}">
    <link rel="icon" href="logo.png">
</head>

<body class="text-gray-800 dark:text-gray-200">

    <!-- LOADER -->
    <div id="loader">
        <div class="loader-circle"></div>
    </div>

    <!-- NAVBAR -->
    <nav id="navbar" class="fixed w-full z-50 transition-all duration-300
                            ease-out bg-transparent">
            <div class="max-w-7xl mx-auto px-6 py-4 flex justify-between items-center">

                <!-- LOGO -->
                <img src="/assets/logo.png" alt="Logo" class="h-9 md:h-10 w-auto object-contain">

                <!-- MENU DESKTOP -->
                <div class="hidden md:flex items-center gap-10 text-sm font-medium">
                    <a href="#home"
                        class="relative text-gray-700 dark:text-gray-300 after:absolute after:left-0
                    after:-bottom-1 after:h-0.5 after:w-0 after:bg-blue-500 after:transition-all hover:after:w-full
                    dark:hover:text-blue-400 hover:text-blue-600">Home</a>
                    <a href="#carakerja"
                        class="relative text-gray-700 dark:text-gray-300 after:absolute after:left-0
                    after:-bottom-1 after:h-0.5 after:w-0 after:bg-blue-500 after:transition-all hover:after:w-full
                    dark:hover:text-blue-400 hover:text-blue-600">Cara
                        Kerja</a>
                    <a href="#pengumuman"
                        class="relative text-gray-700 dark:text-gray-300 after:absolute after:left-0
                    after:-bottom-1 after:h-0.5 after:w-0 after:bg-blue-500 after:transition-all hover:after:w-full
                    dark:hover:text-blue-400 hover:text-blue-600">Pengumuman</a>
                    <a href="#faq"
                        class="relative text-gray-700 dark:text-gray-300        
                    after:absolute after:left-0 after:-bottom-1 after:h-0.5 after:w-0
                    after:bg-blue-500 after:transition-all hover:after:w-full
                    dark:hover:text-blue-400 hover:text-blue-600">FAQ</a>
                </div>

                <!-- RIGHT -->
                <div class="flex items-center gap-3">
                    <!-- DARK -->
                    <button onclick="toggleDark()" id="darkBtn"
                        class="p-2 rounded-lg bg-gray-200 dark:bg-gray-700 transition-all duration-300 ease-in-out transform hover:scale-110 active:scale-95 hover:shadow-lg dark:hover:shadow-gray-700/50 relative overflow-hidden">
                        <span id="darkIcon" class="block transition-transform duration-500 ease-in-out">🌙</span>
                    </button>

                    <!-- LOGIN -->
                    <a href="/login" id="loginBtn"
                        class="p-2 rounded-lg transition-all duration-300 ease-in-out transform hover:scale-110 active:scale-95 hover:shadow-lg dark:hover:shadow-gray-700/50 relative overflow-hidden bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-full text-sm shadow hidden md:inline-block">
                        Login
                    </a>

                    <!-- HAMBURGER -->
                    <button id="menuBtn"
                        class="md:hidden relative w-8 h-8 flex flex-col justify-center items-center gap-1">
                        <span class="bar"></span>
                        <span class="bar"></span>
                        <span class="bar"></span>
                    </button>
                </div>
            </div>

            <!-- MOBILE MENU -->
            <div id="mobileMenu"
                class="md:hidden absolute top-full left-0 w-full
        bg-white/90 dark:bg-[#020617]/90 backdrop-blur-xl
        border-b border-gray-200 dark:border-gray-800
        -translate-y-5 opacity-0 pointer-events-none
        transition-all duration-300">

                <div class="flex flex-col px-6 py-6 gap-4 text-sm font-medium">
                    <a href="#home" class="mobile-link">Home</a>
                    <a href="#carakerja" class="mobile-link">Cara Kerja</a>
                    <a href="#pengumuman" class="mobile-link">Pengumuman</a>
                    <a href="#faq" class="mobile-link">FAQ</a>

                    <a href="/login" class="bg-blue-600 text-white px-4 py-2 rounded-lg text-center">
                        Login
                    </a>
                </div>
            </div>
    </nav>

    <!-- HERO -->
    <section id="home" class="pt-56 md:pt-64 pb-32 text-center reveal">
        <div class="max-w-4xl mx-auto px-6">

            <h1 class="text-4xl md:text-6xl font-bold leading-tight md:leading-[1.2]tracking-tight mb-6">
                <span class="hero-main block py-3">
                    Selamat Datang di
                </span>
                <span
                    class="hero-sub block mt-2 py-1 bg-linear-to-r from-blue-400 to-blue-600 bg-clip-text text-transparent">
                    Absensi SMKN 12 Jakarta
                </span>
            </h1>

            <p class="text-lg text-gray-600 dark:text-gray-400 max-w-2xl mx-auto mb-12">
                🔮 Setiap langkah di sekolah adalah langkah menuju cita-cita 🪄
            </p>

            <button class="ripple bg-blue-600 text-white px-8 py-3 rounded-xl shadow-md">
                <a href="/login">Mulai Absensi</a>
            </button>
        </div>
    </section>

    <!-- ================= STATS ELEGANT ================= -->
    <section class="relative py-28 overflow-hidden reveal">

        <!-- Soft Background -->
        <div class="absolute inset-0 -z-10 bg-transparent">
        </div>

        <div class="max-w-6xl mx-auto px-6">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-8">
                <!-- CARD -->
                <div
                    class="reveal rounded-2xl p-8 text-center
                bg-white/60 dark:bg-white/5
                backdrop-blur-md
                border border-gray-200 dark:border-gray-800
                shadow-sm
                hover:shadow-md
                hover:-translate-y-1
                transition-all duration-300" style="transition-delay:0.1s">
                    <div class="text-2xl text-gray-900 dark:text-white mb-3"><i
                            class="fa-solid fa-person-chalkboard"></i></div>
                    <h3 class="text-3xl font-semibold text-gray-900 dark:text-white counter" data-target="100">0</h3>
                    <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">
                        Guru Aktif
                    </p>
                </div>

                <!-- CARD -->
                <div
                    class="reveal rounded-2xl p-8 text-center
                bg-white/60 dark:bg-white/5
                backdrop-blur-md
                border border-gray-200 dark:border-gray-800
                shadow-sm
                hover:shadow-md
                hover:-translate-y-1
                transition-all duration-300" style="transition-delay:0.2s">
                    <div class="text-2xl text-gray-900 dark:text-white mb-3"><i class="fa-solid fa-user-graduate"></i>
                    </div>
                    <h3 class="text-3xl font-semibold text-gray-900 dark:text-white counter" data-target="600">0
                    </h3>
                    <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">
                        Siswa Aktif
                    </p>
                </div>

                <!-- CARD -->
                <div
                    class="reveal rounded-2xl p-8 text-center
                bg-white/60 dark:bg-white/5
                backdrop-blur-md
                border border-gray-200 dark:border-gray-800
                shadow-sm
                hover:shadow-md
                hover:-translate-y-1
                transition-all duration-300" style="transition-delay:0.3s">
                    <div class="text-2xl text-gray-900 dark:text-white mb-3"><i class="fa-solid fa-trophy"></i></div>
                    <h3 class="text-3xl font-semibold text-gray-900 dark:text-white counter" data-target="A">0</h3>
                    <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">
                        Akreditas
                    </p>
                </div>

                <!-- CARD -->
                <div
                    class="reveal rounded-2xl p-8 text-center
                bg-white/60 dark:bg-white/5
                backdrop-blur-md
                border border-gray-200 dark:border-gray-800
                shadow-sm
                hover:shadow-md
                hover:-translate-y-1
                transition-all duration-300" style="transition-delay:0.4s">
                    <div class="text-2xl text-gray-900 dark:text-white mb-3"><i class="fa-solid fa-address-card"></i>
                    </div>
                    <h3 class="text-3xl font-semibold text-gray-900 dark:text-white counter" data-target="4">0</h3>
                    <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">
                        Jurusan
                    </p>
                </div>
            </div>
        </div>
    </section>


    <!-- CARA KERJA -->
    <section class="reveal py-32 relative overflow-hidden reveal" id="carakerja">
        <div class="max-w-6xl mx-auto px-6">
            <!-- OUTER GRADIENT FRAME -->
            <div
                class="relative rounded-[40px] p-0.75 
                    bg-linear-to-r from-blue-500 via-cyan-400 to-indigo-500 
                    shadow-[0_30px_80px_rgba(37,99,235,0.35)]">

                <!-- INNER WHITE CARD -->
                <div
                    class="relative rounded-[36px] 
                        bg-white dark:bg-gray-900 
                        px-8 md:px-16 py-14 md:py-20">

                    <!-- Browser Top Bar -->
                    <div class="flex items-center gap-3 mb-12">
                        <div class="w-3.5 h-3.5 bg-red-400 rounded-full"></div>
                        <div class="w-3.5 h-3.5 bg-yellow-400 rounded-full"></div>
                        <div class="w-3.5 h-3.5 bg-green-400 rounded-full"></div>
                    </div>

                    <!-- CENTER CONTENT -->
                    <div class="text-center max-w-3xl mx-auto">

                        <h2
                            class="text-3xl md:text-5xl font-bold mb-6 
                            text-gray-900 dark:text-white">
                            Cara Kerja Sistem Absensi
                        </h2>

                        <p class="text-gray-600 dark:text-gray-400 mb-16 text-lg">
                            Proses absensi di SMKN 12 Jakarta dirancang cepat,
                            efisien, dan mudah digunakan oleh seluruh siswa.
                        </p>

                        <!-- STEPS -->
                        <div class="grid md:grid-cols-3 gap-10">
                            <div
                                class="group p-8 rounded-2xl 
                                    bg-gray-50 dark:bg-gray-800
                                    transition-all duration-500
                                    hover:-translate-y-3
                                    hover:shadow-[0_20px_50px_rgba(0,0,0,0.08)]">

                                <div class="text-blue-600 text-4xl font-bold mb-4">
                                    01
                                </div>

                                <h3 class="font-semibold mb-3 text-lg">
                                    Login Akun
                                </h3>

                                <p class="text-sm text-gray-600 dark:text-gray-400">
                                    Masuk menggunakan akun resmi siswa yang sudah terdaftar.
                                </p>
                            </div>

                            <div
                                class="group p-8 rounded-2xl 
                                    bg-gray-50 dark:bg-gray-800
                                    transition-all duration-500
                                    hover:-translate-y-3
                                    hover:shadow-[0_20px_50px_rgba(0,0,0,0.08)]">

                                <div class="text-blue-600 text-4xl font-bold mb-4">
                                    02
                                </div>

                                <h3 class="font-semibold mb-3 text-lg">
                                    Pilih Jadwal
                                </h3>

                                <p class="text-sm text-gray-600 dark:text-gray-400">
                                    Pilih kelas dan jadwal pelajaran sesuai hari berjalan.
                                </p>
                            </div>

                            <div
                                class="group p-8 rounded-2xl 
                                    bg-gray-50 dark:bg-gray-800
                                    transition-all duration-500
                                    hover:-translate-y-3
                                    hover:shadow-[0_20px_50px_rgba(0,0,0,0.08)]">

                                <div class="text-blue-600 text-4xl font-bold mb-4">
                                    03
                                </div>

                                <h3 class="font-semibold mb-3 text-lg">
                                    Jadwal Kehadiran
                                </h3>

                                <p class="text-sm text-gray-600 dark:text-gray-400">
                                    Klik jadwal absen kehadiran untuk melihat proses absensi.
                                </p>
                            </div>
                        </div>

                        <!-- CTA -->
                        <div class="mt-16">
                            <a href="/login"
                                class="inline-block bg-blue-600 hover:bg-blue-700
                                transition-all duration-300
                                text-white px-10 py-4 rounded-xl shadow-lg
                                hover:shadow-[0_15px_40px_rgba(37,99,235,0.4)]">
                                Mulai Sekarang
                            </a>
                        </div>
                    </div>
                </div>

                <!-- SUBTLE GLOW BOTTOM -->
                <div
                    class="absolute -bottom-10 left-1/2 -translate-x-1/2 
                        w-[70%] h-24 bg-blue-500/30 blur-3xl 
                        rounded-full bg-transparent ">
                </div>
            </div>
        </div>
    </section>

    {{-- PENGUMUMAN --}}
    <section id="pengumuman" class="bg-transparent py-24 transition-colors duration-500 reveal">
        <div class="max-w-5xl mx-auto px-6">

            <h2 class="text-3xl font-bold text-center mb-12 
        text-gray-900 dark:text-white">
                Pengumuman Sekolah
            </h2>

            <div class="space-y-6">
                @forelse($announcements as $announcement)
                    <div
                        class="reveal p-8 
                    bg-gray-50 dark:bg-gray-800 
                    border border-gray-200 dark:border-gray-700
                    rounded-2xl 
                    shadow-sm 
                    hover:shadow-lg
                    transition-all duration-300 cursor-pointer"
                        onclick="window.location.href='{{ route('announcements.show', $announcement->id) }}'">

                        <div class="flex items-start justify-between mb-3">
                            <h4 class="font-semibold text-blue-600 dark:text-blue-400">
                                {{ $announcement->title }}
                            </h4>
                            @if($announcement->priority === 'high')
                                <span class="px-2 py-1 bg-red-100 dark:bg-red-900/30 text-red-700 dark:text-red-400 text-xs font-medium rounded-full">
                                    Penting
                                </span>
                            @elseif($announcement->priority === 'medium')
                                <span class="px-2 py-1 bg-yellow-100 dark:bg-yellow-900/30 text-yellow-700 dark:text-yellow-400 text-xs font-medium rounded-full">
                                    Sedang
                                </span>
                            @else
                                <span class="px-2 py-1 bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-400 text-xs font-medium rounded-full">
                                    Info
                                </span>
                            @endif
                        </div>

                        <p class="text-sm text-gray-600 dark:text-gray-400 mt-3 line-clamp-2">
                            {{ $announcement->content }}
                        </p>

                        <div class="flex items-center justify-between mt-4 pt-4 border-t border-gray-200 dark:border-gray-700">
                            <div class="flex items-center text-xs text-gray-500 dark:text-gray-400">
                                <i class="fa-solid fa-calendar-days mr-1 text-gray-500 dark:text-gray-400"></i>
                                {{ $announcement->date->format('d M Y') }}
                            </div>
                            <div class="flex items-center text-xs text-gray-500 dark:text-gray-400">
                                <i class="fa-solid fa-user mr-1"></i>
                                {{ $announcement->author }}
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-12">
                        <div class="text-5xl mb-4">📢</div>
                        <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">Belum Ada Pengumuman</h3>
                        <p class="text-gray-500 dark:text-gray-400">Nantikan pengumuman terbaru dari sekolah</p>
                    </div>
                @endforelse
            </div>

            @if($announcements->count() > 0)
                <div class="text-center mt-8">
                    <a href="{{ route('announcements.index') }}"
                        class="inline-flex items-center text-blue-600 dark:text-blue-400 hover:text-blue-700 dark:hover:text-blue-300 transition">
                        Lihat Semua Pengumuman
                        <i class="fa-solid fa-arrow-right ml-2"></i>
                    </a>
                </div>
            @endif
        </div>
    </section>

    {{-- FAQ --}}
    <section class="min-h-screen py-24 px-6 bg-transparent reveal" id="faq">
        <div class="max-w-3xl mx-auto">

            <!-- HEADER -->
            <div
                class="bg-white/70 dark:bg-white/5 backdrop-blur-xl 
        text-dark rounded-2xl p-6 text-center shadow mb-8
        border border-white/30 dark:border-white/10">
                <h1 class="text-2xl font-semibold">❓Pusat Bantuan</h1>
                <p class="text-sm opacity-80">SMKN 12 - Sistem Absensi Online</p>
            </div>

            <!-- FAQ CARD -->
            <div
                class="bg-white/70 dark:bg-white/5 backdrop-blur-xl
                        rounded-2xl shadow p-6
                        border border-gray-200 dark:border-white/10">

                <h2 class="font-semibold mb-4 text-gray-800 dark:text-white">
                    Masalah yang Sering Ditemui
                </h2>

                <div class="space-y-3">
                    <!-- ITEM -->
                    <div class="faq border border-gray-200 dark:border-white/10 rounded-xl">
                        <button
                            class="faq-btn w-full flex justify-between items-center p-4 text-left 
                    text-gray-700 dark:text-gray-200">
                            🔑 Lupa Password / Password Tidak Bekerja
                            <span class="opacity-60 transition-transform duration-300">⌄</span>
                        </button>
                        <div
                            class="faq-content px-4 pb-4 text-sm 
                    text-gray-600 dark:text-gray-400 hidden">
                            Gunakan fitur reset password atau hubungi admin sekolah.
                        </div>
                    </div>

                    <div class="faq border border-gray-200 dark:border-white/10 rounded-xl">
                        <button
                            class="faq-btn w-full flex justify-between items-center p-4 text-left text-gray-700 dark:text-gray-200">
                            👤 NIS Tidak Terdaftar / Akun Tidak Ditemukan
                            <span class="opacity-60 transition-transform duration-300">⌄</span>
                        </button>
                        <div class="faq-content px-4 pb-4 text-sm text-gray-600 dark:text-gray-400 hidden">
                            Pastikan NIS benar atau hubungi admin untuk aktivasi akun.
                        </div>
                    </div>

                    <div class="faq border border-gray-200 dark:border-white/10 rounded-xl">
                        <button
                            class="faq-btn w-full flex justify-between items-center p-4 text-left text-gray-700 dark:text-gray-200">
                            🌐 Tidak Bisa Login / Koneksi Error
                            <span class="opacity-60 transition-transform duration-300">⌄</span>
                        </button>
                        <div class="faq-content px-4 pb-4 text-sm text-gray-600 dark:text-gray-400 hidden">
                            Periksa koneksi internet atau refresh halaman.
                        </div>
                    </div>

                    <div class="faq border border-gray-200 dark:border-white/10 rounded-xl">
                        <button
                            class="faq-btn w-full flex justify-between items-center p-4 text-left text-gray-700 dark:text-gray-200">
                            📱 Halaman Tidak Tampil dengan Benar di HP
                            <span class="opacity-60 transition-transform duration-300">⌄</span>
                        </button>
                        <div class="faq-content px-4 pb-4 text-sm text-gray-600 dark:text-gray-400 hidden">
                            Gunakan browser Chrome terbaru atau bersihkan cache.
                        </div>
                    </div>
                </div>
            </div>

            <!-- CONTACT -->
            <div
                class="bg-white/70 dark:bg-white/5 backdrop-blur-xl
        rounded-2xl shadow p-6 mt-8 text-center
        border border-gray-200 dark:border-white/10">

                <h3 class="font-semibold text-gray-800 dark:text-white">
                    🎧 Masih Butuh Bantuan?
                </h3>

                <p class="text-sm text-gray-500 dark:text-gray-400 mb-4">
                    Jika masalah belum terpecahkan, hubungi admin kami:
                </p>

                <div class="flex gap-4 justify-center">
                    <a href="#"
                        class="bg-green-500 hover:bg-green-600 text-white px-6 py-3 rounded-xl shadow transition">
                        WhatsApp
                    </a>
                    <a href="#"
                        class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-xl shadow transition">
                        Email
                    </a>
                </div>
            </div>
        </div>
    </section>

    <footer class="bg-gray-50 dark:bg-[#020617] border-t border-gray-200 dark:border-gray-800">
        <div class="max-w-6xl mx-auto px-6 py-16">
            <!-- GRID -->
            <div class="grid md:grid-cols-4 gap-10">
                <!-- BRAND -->
                <div>
                    <!-- HEADING WRAPPER -->
                    <div class="h-14 flex items-center gap-3 mb-4">
                        <img src="/assets/logo.png" alt="Logo SMKN 12 Jakarta" class="h-8 w-auto object-contain">
                        <h3 class="font-semibold text-gray-900 dark:text-white">
                            SMKN 12 Jakarta
                        </h3>
                    </div>

                    <p class="text-sm text-gray-600 dark:text-gray-400 leading-relaxed">
                        Jl. Kb. Bawang XV B No.15 B, RT.19/RW.7, Kb. Bawang, Kec. Tj. Priok, Jkt Utara,<br>
                        Daerah Khusus Ibukota Jakarta 14320
                    </p>

                    <div class="flex gap-4 mt-5 text-lg">
                        <a href="https://www.instagram.com/smkn12_jkt/" class="hover:scale-110 transition"><i
                                class="fa-brands fa-instagram"></i></a>
                        <a href="https://www.youtube.com/@smkn12jakarta" class="hover:scale-110 transition"><i class="fa-brands fa-youtube"></i></a>
                        <a href="https://www.tiktok.com/@dubes_kreasi" class="hover:scale-110 transition"><i class="fa-brands fa-tiktok"></i></a>
                    </div>
                </div>

                <!-- COMPANY -->
                <div>
                    <div class="h-14 flex items-center mb-4">
                        <h3 class="font-semibold text-gray-900 dark:text-white">Company</h3>
                    </div>

                    <ul class="space-y-2 text-sm text-gray-600 dark:text-gray-400">
                        <li><a href="#" class="hover:text-blue-600">Tentang Kami</a></li>
                        <li><a href="#" class="hover:text-blue-600">Hubungi Kami</a></li>
                        <li><a href="#" class="hover:text-blue-600">Blog</a></li>
                        <li><a href="#faq" class="hover:text-blue-600">FAQ</a></li>
                    </ul>
                </div>

                <!-- PROGRAM -->
                <div>
                    <div class="h-14 flex items-center mb-4">
                        <h3 class="font-semibold text-gray-900 dark:text-white">Program</h3>
                    </div>
                    <ul class="space-y-2 text-sm text-gray-600 dark:text-gray-400">
                        <li><a href="#" class="hover:text-blue-600">Jurusan</a></li>
                        <li><a href="#" class="hover:text-blue-600">Ekstrakurikuler</a></li>
                        <li><a href="#" class="hover:text-blue-600">Prestasi</a></li>
                    </ul>
                </div>

                <!-- LAINNYA -->
                <div>
                    <div class="h-14 flex items-center mb-4">
                        <h3 class="font-semibold text-gray-900 dark:text-white">Lainnya</h3>
                    </div>

                    <ul class="space-y-2 text-sm text-gray-600 dark:text-gray-400">
                        <li><a href="#" class="hover:text-blue-600">Kebijakan</a></li>
                        <li><a href="#" class="hover:text-blue-600">Privacy</a></li>
                        <li><a href="#" class="hover:text-blue-600">Syarat</a></li>
                    </ul>
                </div>
            </div>
    </footer>

</body>
<script src="{{ asset('js/main/scirpt.js') }}"></script>
</html>
