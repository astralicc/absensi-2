<!DOCTYPE html>
<html lang="id" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Absensi SMKN 12 Jakarta</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
     
    </script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css"
        integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="icon" href="/logo.png">
    <link rel="stylesheet" href="{{ asset('css/min/dashboard.css') }}">
    <link rel="stylesheet" href="{{ asset('css/min/kelolaSiswa.css') }}">
    <link rel="stylesheet" href="{{ asset('css/min/kelolaWali.css') }}">
</head>

<body class="text-gray-800 dark:text-gray-200 bg-gray-100 dark:bg-gray-950 min-h-screen">
    
    <div class="flex h-screen overflow-hidden">
        @include('admin.layouts.sidebar')

        <!-- Main Content -->
        <div class="flex-1 flex flex-col md:ml-64 min-w-0">
            @include('admin.layouts.header', ['title' => 'Admin Dashboard'])
            
            <!-- Dashboard Content -->
            <main class="flex-1 min-h-0 overflow-y-auto p-4 sm:p-6">
                <div class="relative overflow-hidden rounded-2xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 mb-8 shadow-sm">
                    <div class="absolute inset-0 bg-gradient-to-br from-indigo-500/10 via-violet-500/5 to-transparent pointer-events-none"></div>
                    <div class="relative p-6 sm:p-8 flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6">
                        <div>
                            <p class="text-xs font-semibold uppercase tracking-wider text-indigo-600 dark:text-indigo-400">Panel administrator</p>
                            <h2 class="text-2xl sm:text-3xl font-bold text-gray-900 dark:text-white mt-1 break-words">Selamat datang, {{ auth()->user()->name }}</h2>
                            <p class="text-gray-600 dark:text-gray-400 mt-2 max-w-xl">Kontrol sistem absensi SMKN 12 Jakarta — ringkasan pengguna dan aksi cepat.</p>
                        </div>
                    </div>
                </div>



        <!-- Stats Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6 mb-8">
            <!-- Total Users -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-200 dark:border-gray-700 shadow-sm p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Total Pengguna</p>
                        <p class="text-2xl font-bold">{{ $totalUsers ?? 0 }}</p>
                    </div>
                    <div class="w-12 h-12 bg-blue-100 dark:bg-blue-900 rounded-full flex items-center justify-center">
                        <i class="fa-solid fa-users text-blue-600 dark:text-blue-400 text-xl"></i>
                    </div>
                </div>
            </div>

            <!-- Total Students -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-200 dark:border-gray-700 shadow-sm p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Total Murid</p>
                        <p class="text-2xl font-bold">{{ $totalStudents ?? 0 }}</p>
                    </div>
                    <div class="w-12 h-12 bg-green-100 dark:bg-green-900 rounded-full flex items-center justify-center">
                        <i class="fa-solid fa-user-graduate text-green-600 dark:text-green-400 text-xl"></i>
                    </div>
                </div>
            </div>

            <!-- Total Teachers -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-200 dark:border-gray-700 shadow-sm p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Total Guru</p>
                        <p class="text-2xl font-bold">{{ $totalTeachers ?? 0 }}</p>
                    </div>
                    <div class="w-12 h-12 bg-purple-100 dark:bg-purple-900 rounded-full flex items-center justify-center">
                        <i class="fa-solid fa-chalkboard-user text-purple-600 dark:text-purple-400 text-xl"></i>
                    </div>
                </div>
            </div>

            <!-- Total Parents -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-200 dark:border-gray-700 shadow-sm p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Total Orang Tua</p>
                        <p class="text-2xl font-bold">{{ $totalParents ?? 0 }}</p>
                    </div>
                    <div class="w-12 h-12 bg-orange-100 dark:bg-orange-900 rounded-full flex items-center justify-center">
                        <i class="fa-solid fa-people-roof text-orange-600 dark:text-orange-400 text-xl"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-200 dark:border-gray-700 p-6 mb-8">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Aksi cepat</h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <a href="{{ route('admin.users.quick') }}"
                    class="flex items-center p-4 rounded-xl border border-gray-200 dark:border-gray-600 hover:border-indigo-300 dark:hover:border-indigo-600 hover:bg-indigo-50/50 dark:hover:bg-indigo-900/20 transition">
                    <div class="p-3 bg-indigo-100 dark:bg-indigo-900/40 rounded-xl mr-3">
                        <i class="fa-solid fa-user-plus text-indigo-600 dark:text-indigo-400 text-xl"></i>
                    </div>
                    <span class="font-medium text-gray-700 dark:text-gray-300">Tambah Pengguna</span>
                </a>
                <a href="{{ route('admin.dashboard.export') }}"
                    class="flex items-center p-4 rounded-xl border border-gray-200 dark:border-gray-600 hover:border-indigo-300 dark:hover:border-indigo-600 hover:bg-indigo-50/50 dark:hover:bg-indigo-900/20 transition">
                    <div class="p-3 bg-indigo-100 dark:bg-indigo-900/40 rounded-xl mr-3">
                        <i class="fa-solid fa-file-export text-indigo-600 dark:text-indigo-400 text-xl"></i>
                    </div>
                    <span class="font-medium text-gray-700 dark:text-gray-300">Export Laporan</span>
                </a>
                <a href="{{ route('admin.announcements.create') }}"
                    class="flex items-center p-4 rounded-xl border border-gray-200 dark:border-gray-600 hover:border-indigo-300 dark:hover:border-indigo-600 hover:bg-indigo-50/50 dark:hover:bg-indigo-900/20 transition">
                    <div class="p-3 bg-indigo-100 dark:bg-indigo-900/40 rounded-xl mr-3">
                        <i class="fa-solid fa-bullhorn text-indigo-600 dark:text-indigo-400 text-xl"></i>
                    </div>
                    <span class="font-medium text-gray-700 dark:text-gray-300">Buat Pengumuman</span>
                </a>
            </div>
        </div>


        <!-- System Info -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Informasi Sistem</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                <div class="p-3 bg-gray-50 dark:bg-gray-700/50 rounded-lg">
                    <p class="text-gray-500 dark:text-gray-400 mb-1">Versi Aplikasi</p>
                    <p class="font-medium text-gray-900 dark:text-white">1.0.0</p>
                </div>
                <div class="p-3 bg-gray-50 dark:bg-gray-700/50 rounded-lg">
                    <p class="text-gray-500 dark:text-gray-400 mb-1">Laravel Version</p>
                    <p class="font-medium text-gray-900 dark:text-white">{{ app()->version() }}</p>
                </div>
                <div class="p-3 bg-gray-50 dark:bg-gray-700/50 rounded-lg">
                    <p class="text-gray-500 dark:text-gray-400 mb-1">PHP Version</p>
                    <p class="font-medium text-gray-900 dark:text-white">{{ phpversion() }}</p>
                </div>
                <div class="p-3 bg-gray-50 dark:bg-gray-700/50 rounded-lg">
                    <p class="text-gray-500 dark:text-gray-400 mb-1">Environment</p>
                    <p class="font-medium text-gray-900 dark:text-white">{{ config('app.env') }}</p>
                </div>
            </div>
        </div>
            </main>
        </div>
    </div>
    
    <!-- Mobile Sidebar Overlay -->
    <div id="sidebarOverlay" class="fixed inset-0 bg-black/50 z-40 hidden md:hidden" onclick="closeSidebar()"></div>
    <script src="{{ asset('js/min/dashboard.js') }}"></script>
</body>
</html>
