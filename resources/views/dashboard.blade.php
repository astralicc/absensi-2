<!DOCTYPE html>
<html lang="id" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Absensi SMKN 12 Jakarta</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        window.profileEditUrl = "{{ route('profile.edit') }}";
        window.profileUpdateUrl = "{{ route('profile.update') }}";
    </script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css"
        integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="icon" href="/logo.png">
    <link rel="stylesheet" href="{{ asset('css/dashboard/style.css') }}">
    @if (Auth::guard('guru')->check())
    <script src="{{ asset('js/wali-kelas-sidebar.js') }}"></script>
    @endif
    <link rel="stylesheet" href="{{ asset('css/dashboard/editProfile.css') }}">
</head>

<body class="text-gray-800 dark:text-gray-200 bg-gray-100 dark:bg-gray-950 min-h-screen"
style="--nav-hover-color: {{ Auth::guard('guru')->check() ? '#22c55e' : (Auth::guard('ortu')->check() ? '#a855f7' : '#3b82f6') }};">

    <!-- Sidebar & Main Content Wrapper -->
    <div class="flex h-screen overflow-hidden">

        <!-- Sidebar -->
        @if (Auth::guard('guru')->check())
            @include('dashboard.sidebar-wali', ['unreadCount' => $unreadCount ?? 0])
        @else
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
                    class="flex items-center px-4 py-3 text-gray-700 dark:text-gray-300 {{ Auth::guard('guru')->check() ? 'bg-green-50 dark:bg-green-900/20 border-l-4 border-green-500' : (Auth::guard('ortu')->check() ? 'bg-purple-50 dark:bg-purple-900/20 border-l-4 border-purple-500' : 'bg-blue-50 dark:bg-blue-900/20 border-l-4 border-blue-500') }} rounded-lg">
                    <i class="fa-solid fa-house w-6 mr-3"></i>
                    <span class="font-medium">Dashboard</span>
                </a>

                @if(Auth::guard('ortu')->check())
                    <a href="{{ route('children.data') }}"
                        class="flex items-center px-4 py-3 text-gray-600 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-800 rounded-lg transition">
                        <i class="fa-solid fa-child w-6 mr-3"></i>
                        <span>Data Anak</span>
                    </a>
                    <a href="{{ route('children.attendance') }}"
                        class="flex items-center px-4 py-3 text-gray-600 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-800 rounded-lg transition">
                        <i class="fa-solid fa-calendar-check w-6 mr-3 text-gray-600 dark:text-gray-400"></i>
                        <span>Absensi Anak</span>
                    </a>
                @else
                    {{-- Default menu for Murid (Siswa) and users with null/undefined role --}}
                    <a href="{{ route('attendance.history') }}"
                        class="flex items-center px-4 py-3 text-gray-600 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-800 rounded-lg transition">
                        <i class="fa-solid fa-calendar-check w-6 mr-3 text-gray-600 dark:text-gray-400"></i>
                        <span>Riwayat Absensi</span>
                    </a>
                    <a href="{{ route('schedule.index') }}"
                        class="flex items-center px-4 py-3 text-gray-600 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-800 rounded-lg transition">
                        <i class="fa-solid fa-book w-6 mr-3"></i>
                        <span>Jadwal Pelajaran</span>
                    </a>
                    <a href="{{ route('attendance.report') }}"
                        class="flex items-center px-4 py-3 text-gray-600 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-800 rounded-lg transition">
                        <i class="fa-solid fa-triangle-exclamation w-6 mr-3"></i>
                        <span>Laporkan Absensi</span>
                    </a>
                @endif

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
        @endif

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
                    @if (Auth::guard('web')->check())
                        Dashboard Murid
                    @elseif(Auth::guard('guru')->check())
                        Dashboard Guru
                    @elseif(Auth::guard('ortu')->check())
                        Dashboard Orang Tua
                    @else
                        Dashboard
                    @endif
                </h1>

                <!-- Right Actions -->
                <div class="flex items-center gap-4">
                    <!-- Dark Mode Toggle -->
                    <button onclick="toggleDark()" id="darkBtn"
                        class="p-2 rounded-lg bg-gray-200 dark:bg-gray-700 transition-all duration-300 ease-in-out transform hover:scale-110 active:scale-95 hover:shadow-lg dark:hover:shadow-gray-700/50 relative overflow-hidden">
                        <span id="darkIcon" class="block transition-transform duration-500 ease-in-out">🌙</span>
                    </button>

                    <!-- User Profile Dropdown -->
                    <div class="relative" id="profileDropdown">
                        <button onclick="toggleProfileDropdown()"
                            class="flex items-center gap-3 pl-4 border-l border-gray-200 dark:border-gray-700 hover:opacity-80 transition cursor-pointer bg-transparent border-none">
                            <div class="text-right hidden sm:block">
                                <p class="text-sm font-medium text-gray-900 dark:text-white">{{ $user->name }}
                                </p>
                                <p class="text-xs text-gray-500 dark:text-gray-400">
                                    @if (Auth::guard('web')->check())
                                        Siswa
                                    @elseif(Auth::guard('guru')->check())
                                        Guru
                                    @elseif(Auth::guard('ortu')->check())
                                        Orang Tua
                                    @endif
                                </p>
                            </div>

<div
class="h-10 w-10 rounded-full {{ Auth::guard('guru')->check() ? 'bg-green-500' : (Auth::guard('ortu')->check() ? 'bg-purple-500' : 'bg-blue-500') }} flex items-center justify-center text-white font-bold">
                                {{ strtoupper(substr($user->name, 0, 1)) }}
                            </div>

                            <i class="fa-solid fa-chevron-down text-gray-400 text-xs transition-transform duration-200"
                                id="dropdownArrow"></i>
                        </button>

                        <!-- Dropdown Menu -->
                        <div id="dropdownMenu"
                            class="dropdown-menu hidden absolute right-0 mt-2 w-56 bg-white dark:bg-gray-800 rounded-xl shadow-lg border border-gray-200 dark:border-gray-700 py-2 z-50">
                            <div class="px-4 py-3 border-b border-gray-200 dark:border-gray-700">
                                <p class="text-sm font-medium text-gray-900 dark:text-white">{{ $user->name }}
                                </p>
                                <p class="text-xs text-gray-500 dark:text-gray-400 truncate">
                                    {{ $user->email }}</p>
                            </div>

                            @if (!Auth::guard('guru')->check())
                                <button onclick="openEditProfileModal()"
                                    class="w-full text-left px-4 py-3 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 transition flex items-center gap-3">
                                    <i class="fa-solid fa-user-edit text-purple-500 w-5"></i>
                                    Edit Profil
                                </button>
                            @endif

                            <div class="border-t border-gray-200 dark:border-gray-700 mt-2 pt-2">
                                <form action="{{ route('logout') }}" method="POST" class="w-full">
                                    @csrf
                                    <button type="submit"
                                        class="w-full text-left px-4 py-3 text-sm text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20 transition flex items-center gap-3">
                                        <i class="fa-solid fa-right-from-bracket w-5"></i>
                                        Logout
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Dashboard Content -->
            <main class="flex-1 overflow-y-auto p-6">

                <!-- Welcome Card -->
                <div class="relative overflow-hidden rounded-2xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 mb-8 shadow-sm">
                    <div
class="absolute inset-0 bg-gradient-to-br {{ Auth::guard('guru')->check() ? 'from-green-500/10 via-emerald-500/5 to-transparent' : (Auth::guard('ortu')->check() ? 'from-purple-500/10 via-violet-500/5 to-transparent' : 'from-blue-500/10 via-indigo-500/5 to-transparent') }} pointer-events-none">
                    </div>
                    <div class="relative p-6">
                        <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">
                            Selamat Datang, {{ $user->name }}! 👋
                        </h2>
                        <p class="text-gray-600 dark:text-gray-400 mt-2 max-w-xl">
                            @if (Auth::guard('web')->check())
                                Semoga harimu menyenangkan dan produktif. Jangan lupa untuk selalu absen tepat waktu ya!
                            @elseif(Auth::guard('guru')->check())
                                Selamat mengajar hari ini. Pantau kehadiran siswa dengan mudah melalui dashboard ini.
                            @elseif(Auth::guard('ortu')->check())
                                Pantau kehadiran dan perkembangan putra/putri Anda melalui dashboard ini.
                            @endif
                        </p>
                    </div>
                </div>

                <!-- Stats Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                    @if (Auth::guard('web')->check())
                        <div
                            class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-sm border border-gray-200 dark:border-gray-700">
                            <div class="flex items-center justify-between mb-4">
                                <div class="p-3 bg-green-100 dark:bg-green-900/30 rounded-lg">
                                    <i class="fa-solid fa-check-circle text-green-600 dark:text-green-400 text-xl"></i>
                                </div>
                                <span class="text-sm text-gray-500 dark:text-gray-400">Hadir</span>
                            </div>
                            <h3 class="text-2xl font-bold text-gray-900 dark:text-white">
                                {{ $stats['attendanceRate'] ?? 0 }}%</h3>
                            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Kehadiran bulan ini</p>
                        </div>

                        <div
                            class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-sm border border-gray-200 dark:border-gray-700">
                            <div class="flex items-center justify-between mb-4">
                                <div class="p-3 bg-red-100 dark:bg-red-900/30 rounded-lg">
                                    <i class="fa-solid fa-times-circle text-red-600 dark:text-red-400 text-xl"></i>
                                </div>
                                <span class="text-sm text-gray-500 dark:text-gray-400">Absen</span>
                            </div>
                            <h3 class="text-2xl font-bold text-gray-900 dark:text-white">
                                {{ ($stats['totalDays'] ?? 0) - ($stats['presentDays'] ?? 0) }}</h3>
                            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Kali tidak hadir</p>
                        </div>

                        <div
                            class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-sm border border-gray-200 dark:border-gray-700">
                            <div class="flex items-center justify-between mb-4">
                                <div class="p-3 bg-yellow-100 dark:bg-yellow-900/30 rounded-lg">
                                    <i class="fa-solid fa-clock text-yellow-600 dark:text-yellow-400 text-xl"></i>
                                </div>
                                <span class="text-sm text-gray-500 dark:text-gray-400">Terlambat</span>
                            </div>
                            <h3 class="text-2xl font-bold text-gray-900 dark:text-white">0</h3>
                            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Kali terlambat</p>
                        </div>

                        <div
                            class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-sm border border-gray-200 dark:border-gray-700">
                            <div class="flex items-center justify-between mb-4">
                                <div class="p-3 bg-blue-100 dark:bg-blue-900/30 rounded-lg">
                                    <i class="fa-solid fa-calendar text-blue-600 dark:text-blue-400 text-xl"></i>
                                </div>
                                <span class="text-sm text-gray-500 dark:text-gray-400">Total Hari</span>
                            </div>
                            <h3 class="text-2xl font-bold text-gray-900 dark:text-white">
                                {{ $stats['totalDays'] ?? 0 }}</h3>
                            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Hari sekolah</p>
                        </div>
@elseif(Auth::guard('guru')->check())

                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                                <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-sm border border-gray-200 dark:border-gray-700">
                                    <div class="flex items-center justify-between mb-4">
                                        <div class="p-3 bg-green-100 dark:bg-green-900/30 rounded-lg">
                                            <i class="fa-solid fa-users text-green-600 dark:text-green-400 text-xl"></i>
                                        </div>
                                        <span class="text-sm text-gray-500 dark:text-gray-400">Total Siswa Kelas</span>
                                    </div>
                                    <h3 class="text-2xl font-bold text-gray-900 dark:text-white">{{ $stats['totalStudents'] }}</h3>
                                </div>

                                <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-sm border border-gray-200 dark:border-gray-700">
                                    <div class="flex items-center justify-between mb-4">
                                        <div class="p-3 bg-green-100 dark:bg-green-900/30 rounded-lg">
                                            <i class="fa-solid fa-check-circle text-green-600 dark:text-green-400 text-xl"></i>
                                        </div>
                                        <span class="text-sm text-gray-500 dark:text-gray-400">Hadir Hari Ini</span>
                                    </div>
                                    <h3 class="text-2xl font-bold text-gray-900 dark:text-white">{{ $stats['presentToday'] }}</h3>
                                </div>

                                <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-sm border border-gray-200 dark:border-gray-700">
                                    <div class="flex items-center justify-between mb-4">
                                        <div class="p-3 bg-red-100 dark:bg-red-900/30 rounded-lg">
                                            <i class="fa-solid fa-times-circle text-red-600 dark:text-red-400 text-xl"></i>
                                        </div>
                                        <span class="text-sm text-gray-500 dark:text-gray-400">Absen Hari Ini</span>
                                    </div>
                                    <h3 class="text-2xl font-bold text-gray-900 dark:text-white">{{ $stats['absentToday'] }}</h3>
                                </div>

                                <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-sm border border-gray-200 dark:border-gray-700">
                                    <div class="flex items-center justify-between mb-4">
                                        <div class="p-3 bg-yellow-100 dark:bg-yellow-900/30 rounded-lg">
                                            <i class="fa-solid fa-chart-line text-yellow-600 dark:text-yellow-400 text-xl"></i>
                                        </div>
                                        <span class="text-sm text-gray-500 dark:text-gray-400">Rata-rata Bulan</span>
                                    </div>
                                    <h3 class="text-2xl font-bold text-gray-900 dark:text-white">{{ $stats['monthlyAverage'] }}%</h3>
                                </div>
                            </div>

                            {{-- Wali Kelas Quick Actions --}}
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                                <a href="{{ route('attendance.manage') }}" class="group bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-white p-6 rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                                    <i class="fa-solid fa-clipboard-check text-2xl mb-3 block"></i>
                                    <h4 class="font-bold text-lg mb-1">Kelola Absensi Kelas</h4>
                                    <p class="text-green-100">Tandai kehadiran siswa {{ $stats['kelasWali'] }}</p>
                                </a>
                                <a href="{{ route('students.index') }}" class="group bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-white p-6 rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                                    <i class="fa-solid fa-users text-2xl mb-3 block"></i>
                                    <h4 class="font-bold text-lg mb-1">Daftar Siswa Kelas</h4>
                                    <p class="text-green-100">Lihat semua siswa {{ $stats['kelasWali'] }}</p>
                                </a>
                                <a href="{{ route('reports.index') }}?kelas={{ $stats['kelasWali'] }}" class="group bg-gradient-to-r from-green-500 to-emerald-600 hover:from-green-600 hover:to-emerald-700 text-white p-6 rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                                    <i class="fa-solid fa-file-export text-2xl mb-3 block"></i>
                                    <h4 class="font-bold text-lg mb-1">Laporan Kelas</h4>
                                    <p class="text-green-100">Export laporan {{ $stats['kelasWali'] }}</p>
                                </a>
                            </div>


                            {{-- REGULAR GURU DASHBOARD --}}
                            <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-sm border border-gray-200 dark:border-gray-700">
                                <div class="flex items-center justify-between mb-4">
                                <div class="p-3 bg-green-100 dark:bg-green-900/30 rounded-lg">
                                    <i class="fa-solid fa-users text-green-600 dark:text-green-400 text-xl"></i>
                                    </div>
                                    <span class="text-sm text-gray-500 dark:text-gray-400">Total Siswa</span>
                                </div>
                                <h3 class="text-2xl font-bold text-gray-900 dark:text-white">
                                    {{ $stats['totalStudents'] ?? 0 }}</h3>
                                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Siswa terdaftar</p>
                            </div>

                            <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-sm border border-gray-200 dark:border-gray-700">
                                <div class="flex items-center justify-between mb-4">
                                    <div class="p-3 bg-green-100 dark:bg-green-900/30 rounded-lg">
                                        <i class="fa-solid fa-check-circle text-green-600 dark:text-green-400 text-xl"></i>
                                    </div>
                                    <span class="text-sm text-gray-500 dark:text-gray-400">Hadir Hari Ini</span>
                                </div>
                                <h3 class="text-2xl font-bold text-gray-900 dark:text-white">
                                    {{ $stats['presentToday'] ?? 0 }}</h3>
                                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Siswa hadir</p>
                            </div>

                            <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-sm border border-gray-200 dark:border-gray-700">
                                <div class="flex items-center justify-between mb-4">
                                    <div class="p-3 bg-red-100 dark:bg-red-900/30 rounded-lg">
                                        <i class="fa-solid fa-times-circle text-red-600 dark:text-red-400 text-xl"></i>
                                    </div>
                                    <span class="text-sm text-gray-500 dark:text-gray-400">Absen Hari Ini</span>
                                </div>
                                <h3 class="text-2xl font-bold text-gray-900 dark:text-white">
                                    {{ $stats['absentToday'] ?? 0 }}</h3>
                                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Siswa tidak hadir</p>
                            </div>

                            <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-sm border border-gray-200 dark:border-gray-700">
                                <div class="flex items-center justify-between mb-4">
                                <div class="p-3 bg-green-100 dark:bg-green-900/30 rounded-lg">
                                    <i class="fa-solid fa-chart-line text-green-600 dark:text-green-400 text-xl"></i>
                                    </div>
                                    <span class="text-sm text-gray-500 dark:text-gray-400">Rata-rata Bulan</span>
                                </div>
                                <h3 class="text-2xl font-bold text-gray-900 dark:text-white">
                                    {{ $stats['monthlyAverage'] ?? 0 }}%</h3>
                                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Tingkat kehadiran</p>
                            </div>
                        @endif
                    @elseif(Auth::guard('ortu')->check())
                        <div
                            class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-sm border border-gray-200 dark:border-gray-700">
                            <div class="flex items-center justify-between mb-4">
                                <div class="p-3 bg-purple-100 dark:bg-purple-900/30 rounded-lg">
                                    <i class="fa-solid fa-child text-purple-600 dark:text-purple-400 text-xl"></i>
                                </div>
                                <span class="text-sm text-gray-500 dark:text-gray-400">Nama Anak</span>
                            </div>
                            <h3 class="text-lg font-bold text-gray-900 dark:text-white">
                                {{ $child->name ?? 'Belum terhubung' }}</h3>
                            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">NIS: {{ $child->id ?? '-' }}</p>
                        </div>

                        <div
                            class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-sm border border-gray-200 dark:border-gray-700">
                            <div class="flex items-center justify-between mb-4">
                                <div class="p-3 bg-green-100 dark:bg-green-900/30 rounded-lg">
                                    <i class="fa-solid fa-check-circle text-green-600 dark:text-green-400 text-xl"></i>
                                </div>
                                <span class="text-sm text-gray-500 dark:text-gray-400">Kehadiran</span>
                            </div>
                            <h3 class="text-2xl font-bold text-gray-900 dark:text-white">
                                {{ $stats['attendanceRate'] ?? 0 }}%</h3>
                            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Tingkat kehadiran</p>
                        </div>

                        <div
                            class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-sm border border-gray-200 dark:border-gray-700">
                            <div class="flex items-center justify-between mb-4">
                                <div class="p-3 bg-yellow-100 dark:bg-yellow-900/30 rounded-lg">
                                    <i class="fa-solid fa-clock text-yellow-600 dark:text-yellow-400 text-xl"></i>
                                </div>
                                <span class="text-sm text-gray-500 dark:text-gray-400">Terlambat</span>
                            </div>
                            <h3 class="text-2xl font-bold text-gray-900 dark:text-white">{{ $stats['lateDays'] ?? 0 }}
                            </h3>
                            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Kali terlambat</p>
                        </div>

                        <div
                            class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-sm border border-gray-200 dark:border-gray-700">
                            <div class="flex items-center justify-between mb-4">
                                <div class="p-3 bg-purple-100 dark:bg-purple-900/30 rounded-lg">
                                    <i class="fa-solid fa-calendar text-purple-600 dark:text-purple-400 text-xl"></i>
                                </div>
                                <span class="text-sm text-gray-500 dark:text-gray-400">Total Hari</span>
                            </div>
                            <h3 class="text-2xl font-bold text-gray-900 dark:text-white">
                                {{ $stats['totalDays'] ?? 0 }}</h3>
                            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Hari sekolah</p>
                        </div>
                    @endif
                </div>

                <!-- Recent Activity -->
                <div
                    class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
                    <div
                        class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 flex items-center justify-between">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                            @if (Auth::guard('web')->check())
                                Riwayat Absensi Terbaru
                            @elseif(Auth::guard('guru')->check())
                                Absensi Hari Ini
                            @elseif(Auth::guard('ortu')->check())
                                Riwayat Kehadiran Anak
                            @endif
                        </h3>
                        @if (Auth::guard('web')->check())
                            <a href="{{ route('attendance.history') }}"
                                class="text-sm text-purple-600 hover:text-purple-700">Lihat Semua →</a>
                        @elseif(Auth::guard('guru')->check())
                            <a href="{{ route('attendance.manage') }}"
                                class="text-sm text-green-600 hover:text-green-700">Lihat Semua →</a>
                        @elseif(Auth::guard('ortu')->check())
                            <a href="{{ route('children.attendance') }}"
                                class="text-sm text-purple-600 hover:text-purple-700">Lihat Semua →</a>
                        @endif

                    </div>
                    <div class="p-6">
                        <div class="space-y-4">
                            @if (Auth::guard('web')->check() && isset($recentAttendances))
                                @forelse($recentAttendances as $attendance)
                                    <div
                                        class="flex items-center justify-between p-4 bg-gray-50 dark:bg-gray-700/50 rounded-xl">
                                        <div class="flex items-center gap-4">
                                            <div
                                                class="h-10 w-10 rounded-full {{ $attendance->check_in ? 'bg-green-100 dark:bg-green-900/30' : 'bg-red-100 dark:bg-red-900/30' }} flex items-center justify-center">
                                                <i
                                                    class="fa-solid {{ $attendance->check_in ? 'fa-check text-green-600 dark:text-green-400' : 'fa-times text-red-600 dark:text-red-400' }}"></i>
                                            </div>
                                            <div>
                                                <p class="font-medium text-gray-900 dark:text-white">
                                                    {{ $attendance->check_in ? 'Hadir' : 'Tidak Hadir' }} -
                                                    {{ ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'][$attendance->date->dayOfWeek] ?? '' }}
                                                </p>
                                                <p class="text-sm text-gray-500 dark:text-gray-400">
                                                    {{ $attendance->date->format('d M Y') }}
                                                    @if ($attendance->check_in)
                                                        • {{ $attendance->check_in->format('H:i') }} WIB
                                                    @endif
                                                </p>
                                            </div>
                                        </div>
                                        <span
                                            class="px-3 py-1 text-xs font-medium {{ $attendance->check_in ? 'bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-400' : 'bg-red-100 dark:bg-red-900/30 text-red-700 dark:text-red-400' }} rounded-full">
                                            {{ $attendance->check_in ? 'Hadir' : 'Absen' }}
                                        </span>
                                    </div>
                                @empty
                                    <div class="text-center py-8 text-gray-500 dark:text-gray-400">
                                        Belum ada data absensi
                                    </div>
                                @endforelse
                            @elseif(Auth::guard('guru')->check() && isset($todayAttendances))
                                @forelse($todayAttendances as $attendance)
                                    <div
                                        class="flex items-center justify-between p-4 bg-gray-50 dark:bg-gray-700/50 rounded-xl">
                                        <div class="flex items-center gap-4">
                                            <div
                                                class="h-10 w-10 rounded-full {{ $attendance->check_in ? 'bg-green-100 dark:bg-green-900/30' : 'bg-red-100 dark:bg-red-900/30' }} flex items-center justify-center">
                                                <i
                                                    class="fa-solid {{ $attendance->check_in ? 'fa-check text-green-600 dark:text-green-400' : 'fa-times text-red-600 dark:text-red-400' }}"></i>
                                            </div>
                                            <div>
                                                <p class="font-medium text-gray-900 dark:text-white">
                                                    {{ $attendance->user->name ?? 'Unknown' }} -
                                                    {{ $attendance->check_in ? 'Hadir' : 'Tidak Hadir' }}
                                                </p>
                                                <p class="text-sm text-gray-500 dark:text-gray-400">
                                                    {{ $attendance->date->format('d M Y') }}
                                                    @if ($attendance->check_in)
                                                        • {{ $attendance->check_in->format('H:i') }} WIB
                                                    @endif
                                                </p>
                                            </div>
                                        </div>
                                        <span
                                            class="px-3 py-1 text-xs font-medium {{ $attendance->check_in ? 'bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-400' : 'bg-red-100 dark:bg-red-900/30 text-red-700 dark:text-red-400' }} rounded-full">
                                            {{ $attendance->check_in ? 'Hadir' : 'Absen' }}
                                        </span>
                                    </div>
                                @empty
                                    <div class="text-center py-8 text-gray-500 dark:text-gray-400">
                                        Belum ada data absensi hari ini
                                    </div>
                                @endforelse
                            @elseif(Auth::guard('ortu')->check() && isset($childAttendances))
                                @forelse($childAttendances as $attendance)
                                    <div
                                        class="flex items-center justify-between p-4 bg-gray-50 dark:bg-gray-700/50 rounded-xl">
                                        <div class="flex items-center gap-4">
                                            <div
                                                class="h-10 w-10 rounded-full {{ $attendance->check_in ? 'bg-green-100 dark:bg-green-900/30' : 'bg-red-100 dark:bg-red-900/30' }} flex items-center justify-center">
                                                <i
                                                    class="fa-solid {{ $attendance->check_in ? 'fa-check text-green-600 dark:text-green-400' : 'fa-times text-red-600 dark:text-red-400' }}"></i>
                                            </div>
                                            <div>
                                                <p class="font-medium text-gray-900 dark:text-white">
                                                    {{ $attendance->user->name ?? 'Anak' }} -
                                                    {{ $attendance->check_in ? 'Hadir' : 'Tidak Hadir' }}
                                                </p>
                                                <p class="text-sm text-gray-500 dark:text-gray-400">
                                                    {{ $attendance->date->format('d M Y') }}
                                                    @if ($attendance->check_in)
                                                        • {{ $attendance->check_in->format('H:i') }} WIB
                                                    @endif
                                                </p>
                                            </div>
                                        </div>
                                        <span
                                            class="px-3 py-1 text-xs font-medium {{ $attendance->check_in ? 'bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-400' : 'bg-red-100 dark:bg-red-900/30 text-red-700 dark:text-red-400' }} rounded-full">
                                            {{ $attendance->check_in ? 'Hadir' : 'Absen' }}
                                        </span>
                                    </div>
                                @empty
                                    <div class="text-center py-8 text-gray-500 dark:text-gray-400">
                                        Belum ada data kehadiran anak
                                    </div>
                                @endforelse
                            @else
                                <div class="text-center py-8 text-gray-500 dark:text-gray-400">
                                    Data absensi tidak tersedia
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

            </main>
        </div>
    </div>

    <!-- Mobile Sidebar Overlay -->
    <div id="sidebarOverlay" class="fixed inset-0 bg-black/50 z-40 hidden md:hidden" onclick="closeSidebar()"></div>

    <!-- Edit Profile Modal -->
    <div id="editProfileModal" class="hidden fixed inset-0 bg-black/50 z-50 flex items-center justify-center p-4">
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl max-w-2xl w-full max-h-[90vh] overflow-y-auto">
            <!-- Modal Header -->
            <div
                class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 flex items-center justify-between sticky top-0 bg-white dark:bg-gray-800 rounded-t-2xl">
                <h3 class="text-xl font-bold text-gray-900 dark:text-white flex items-center gap-2">
                    <i class="fa-solid fa-user-edit text-purple-500"></i>
                    Edit Profil
                </h3>
                <button onclick="closeEditProfileModal()"
                    class="p-2 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-lg transition">
                    <i class="fa-solid fa-times text-gray-500 dark:text-gray-400"></i>
                </button>
            </div>

            <!-- Modal Body -->
            <div class="p-6">
                <!-- Success Message -->
                <div id="profileSuccessMessage"
                    class="hidden bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                    Profil berhasil diperbarui!
                </div>
                <!-- Error Message -->
                <div id="profileErrorMessage"
                    class="hidden bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                    <span id="errorMessageText"></span>
                </div>

                <form id="editProfileForm" class="space-y-4">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <!-- NISN -->
                        <div>
                            <label for="edit_nisn"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                NISN
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fa-solid fa-hashtag text-gray-400 text-sm"></i>
                                </div>
                                <input type="text" name="nisn" id="edit_nisn"
                                    class="w-full pl-9 pr-3 py-2 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition text-sm"
                                    placeholder="Masukkan NISN (10 digit)">
                            </div>
                        </div>

                        <!-- Nomor Telepon -->
                        <div>
                            <label for="edit_phone"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                Nomor Telepon
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fa-solid fa-phone text-gray-400 text-sm"></i>
                                </div>
                                <input type="tel" name="phone" id="edit_phone"
                                    class="w-full pl-9 pr-3 py-2 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition text-sm"
                                    placeholder="08xxxxxxxxxx">
                            </div>
                        </div>

                        <!-- Kelas -->
                        <div>
                            <label for="edit_class"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                Kelas
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fa-solid fa-user-graduate text-gray-400 sm"></i>
                                </div>
                                <select name="class" id="edit_class"
                                    class="w-full pl-9 pr-3 py-2 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition text-sm appearance-none">
                                    <option value="">Pilih Kelas</option>
                                    <option value="X">X</option>
                                    <option value="XI">XI</option>
                                    <option value="XII">XII</option>
                                </select>
                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                    <i class="fa-solid fa-chevron-down text-gray-400 text-xs"></i>
                                </div>
                            </div>
                        </div>

                        <!-- Jenis Kelamin -->
                        <div>
                            <label for="edit_gender"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                Jenis Kelamin
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fa-solid fa-venus-mars text-gray-400 text-sm"></i>
                                </div>
                                <select name="gender" id="edit_gender"
                                    class="w-full pl-9 pr-3 py-2 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition text-sm appearance-none">
                                    <option value="">Pilih Jenis Kelamin</option>
                                    <option value="L">Laki-laki</option>
                                    <option value="P">Perempuan</option>
                                </select>
                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                    <i class="fa-solid fa-chevron-down text-gray-400 text-xs"></i>
                                </div>
                            </div>
                        </div>


                        <!-- Jurusan -->
                        <div>
                            <label for="edit_gender"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                Jurusan
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fa-solid fa-graduation-cap text-gray-400 sm"></i>
                                </div>
                                <select name="jurusan" id="edit_jurusan"
                                    class="w-full pl-9 pr-3 py-2 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition text-sm appearance-none">
                                    <option value="">Pilih Jurusan</option>
                                    <option value="AK">AK</option>
                                    <option value="MP">MP</option>
                                    <option value="BR">BR</option>
                                    <option value="RPL">RPL</option>
                                </select>
                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                    <i class="fa-solid fa-chevron-down text-gray-400 text-xs"></i>
                                </div>
                            </div>
                        </div>


                        <!-- Tanggal Lahir -->
                        <div>
                            <label for="edit_birth_date"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                Tanggal Lahir
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fa-solid fa-calendar-alt text-gray-400 text-sm"></i>
                                </div>
                                <input type="date" name="birth_date" id="edit_birth_date"
                                    class="w-full pl-9 pr-3 py-2 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition text-sm">
                            </div>
                        </div>
                    </div>

                    <!-- Alamat -->
                    <div>
                        <label for="edit_address"
                            class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                            Alamat
                        </label>
                        <div class="relative">
                            <div class="absolute top-3 left-3 flex items-start pointer-events-none">
                                <i class="fa-solid fa-map-marker-alt text-gray-400 text-sm"></i>
                            </div>
                            <textarea name="address" id="edit_address" rows="3"
                                class="w-full pl-9 pr-3 py-2 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition text-sm resize-none"
                                placeholder="Masukkan alamat lengkap"></textarea>
                        </div>
                    </div>

                    <!-- Password Confirmation -->
                    <div class="border-t border-gray-200 dark:border-gray-700 pt-4 mt-4">
                        <label for="edit_password"
                            class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                            Konfirmasi Password <span class="text-red-500">*</span>
                        </label>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mb-2">Masukkan password Anda untuk menyimpan
                            perubahan</p>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fa-solid fa-lock text-gray-400 text-sm"></i>
                            </div>
                            <input type="password" name="current_password" id="edit_password" required
                                class="w-full pl-9 pr-3 py-2 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition text-sm"
                                placeholder="Masukkan password">
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="flex gap-3 pt-2">
                        <button type="button" onclick="closeEditProfileModal()"
                            class="flex-1 px-4 py-2 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition text-sm font-medium">
                            Batal
                        </button>
                        <button type="submit" id="saveProfileBtn"
                            class="flex-1 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition text-sm font-medium flex items-center justify-center gap-2">
                            <i class="fa-solid fa-save"></i>
                            <span>Simpan Perubahan</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>


</body>
<script src="{{ asset('js/profile/editProfile.js') }}"></script>
</html>
