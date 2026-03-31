<!DOCTYPE html>
<html lang="id" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $announcement->title }} - Absensi SMKN 12 Jakarta</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
        };
    </script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css"
        integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="icon" href="/logo.png">
    <link rel="stylesheet" href="{{ asset('css/dashboard/uiAnnoun.css') }}">
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


                @if (Auth::guard('guru')->check())
                    <a href="{{ route('attendance.manage') }}"
                        class="flex items-center px-4 py-3 text-gray-600 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-800 rounded-lg transition">
                        <i class="fa-solid fa-clipboard-list w-6 mr-3"></i>
                        <span>Kelola Absensi</span>
                    </a>
                    <a href="{{ route('students.index') }}"
                        class="flex items-center px-4 py-3 text-gray-600 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-800 rounded-lg transition">
                        <i class="fa-solid fa-users w-6 mr-3"></i>
                        <span>Daftar Siswa</span>
                    </a>
                    <a href="{{ route('schedule.manage') }}"
                        class="flex items-center px-4 py-3 text-gray-600 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-800 rounded-lg transition">
                        <i class="fa-solid fa-calendar-days w-6 mr-3"></i>
                        <span>Kelola Jadwal</span>
                    </a>
                    <a href="{{ route('reports.index') }}"
                        class="flex items-center px-4 py-3 text-gray-600 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-800 rounded-lg transition">
                        <i class="fa-solid fa-chart-line w-6 mr-3"></i>
                        <span>Laporan</span>
                    </a>
                @elseif(Auth::guard('ortu')->check())
                    <a href="{{ route('children.data') }}"
                        class="flex items-center px-4 py-3 text-gray-600 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-800 rounded-lg transition">
                        <i class="fa-solid fa-child w-6 mr-3"></i>
                        <span>Data Anak</span>
                    </a>
                    <a href="{{ route('children.attendance') }}"
                        class="flex items-center px-4 py-3 text-gray-600 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-800 rounded-lg transition">
                        <i class="fa-solid fa-calendar-check w-6 mr-3"></i>
                        <span>Absensi Anak</span>
                    </a>
                @else
                    {{-- Default menu for Murid (Siswa) and users with null/undefined role --}}
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
                        class="flex items-center px-4 py-3 text-gray-600 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-800 rounded-lg transition">
                        <i class="fa-solid fa-triangle-exclamation w-6 mr-3"></i>
                        <span>Laporkan Absensi</span>
                    </a>
                @endif

                <a href="{{ route('announcements.index') }}"
                    class="flex items-center px-4 py-3 text-gray-700 dark:text-gray-300 bg-blue-50 dark:bg-blue-900/20 rounded-lg border-l-4 border-blue-500">
                    <i class="fa-solid fa-bullhorn w-6 mr-3"></i>
                    <span>Pengumuman</span>
                    @if (isset($unreadCount) && $unreadCount > 0)
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
                    Detail Pengumuman
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
                            <p class="text-sm font-medium text-gray-900 dark:text-white">{{ $user->name }}</p>
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
                            class="h-10 w-10 rounded-full bg-blue-500 flex items-center justify-center text-white font-bold">
                            {{ strtoupper(substr($user->name, 0, 1)) }}
                        </div>
                    </div>
                </div>
            </header>

            <!-- Page Content -->
            <main class="flex-1 overflow-y-auto p-6">

                <!-- Back Button -->
                <a href="{{ route('announcements.index') }}"
                    class="inline-flex items-center text-gray-600 dark:text-gray-400 hover:text-blue-600 dark:hover:text-blue-400 mb-6 transition">
                    <i class="fa-solid fa-arrow-left mr-2"></i>
                    Kembali ke Pengumuman
                </a>

                <!-- Announcement Detail Card -->
                <div
                    class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
                    <!-- Header -->
                    <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                        <div class="flex items-center gap-3 mb-4">
                            <!-- Priority Badge -->
                            @if ($announcement->priority === 'high')
                                <span
                                    class="px-3 py-1 bg-red-100 dark:bg-red-900/30 text-red-700 dark:text-red-400 text-sm font-medium rounded-full">
                                    <i class="fa-solid fa-exclamation-circle mr-1"></i>Penting
                                </span>
                            @elseif($announcement->priority === 'medium')
                                <span
                                    class="px-3 py-1 bg-yellow-100 dark:bg-yellow-900/30 text-yellow-700 dark:text-yellow-400 text-sm font-medium rounded-full">
                                    <i class="fa-solid fa-info-circle mr-1"></i>Informasi
                                </span>
                            @else
                                <span
                                    class="px-3 py-1 bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-400 text-sm font-medium rounded-full">
                                    <i class="fa-solid fa-bell mr-1"></i>Umum
                                </span>
                            @endif

                            <!-- Category Badge -->
                            <span
                                class="px-3 py-1 bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-400 text-sm font-medium rounded-full">
                                {{ ucfirst($announcement->category) }}
                            </span>
                        </div>

                        <h1 class="text-2xl md:text-3xl font-bold text-gray-900 dark:text-white mb-4">
                            {{ $announcement->title }}
                        </h1>

                        <div class="flex flex-wrap items-center gap-4 text-sm text-gray-500 dark:text-gray-400">
                            <span class="flex items-center">
                                <i class="fa-regular fa-calendar mr-2"></i>
                                {{ $announcement->date->format('d M Y') }}
                            </span>
                            <span class="flex items-center">
                                <i class="fa-solid fa-user mr-2"></i>
                                {{ $announcement->author }}
                            </span>
                        </div>
                    </div>

                    <!-- Content -->
                    <div class="p-6">
                        <div class="prose dark:prose-invert max-w-none">
                            <p class="text-gray-700 dark:text-gray-300 leading-relaxed whitespace-pre-line">
                                {{ $announcement->content }}
                            </p>
                        </div>
                    </div>

                    <!-- Footer -->
                    <div class="p-6 bg-gray-50 dark:bg-gray-700/50 border-t border-gray-200 dark:border-gray-700">
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-500 dark:text-gray-400">
                                Diterbitkan pada {{ $announcement->date->format('d M Y') }}
                            </span>

                            <div class="flex gap-3">
                                <button onclick="shareAnnouncement()"
                                    class="px-4 py-2 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-lg text-sm font-medium hover:bg-gray-200 dark:hover:bg-gray-600 transition">
                                    <i class="fa-solid fa-share-nodes mr-2"></i>Bagikan
                                </button>
                                <button onclick="printAnnouncement()"
                                    class="px-4 py-2 bg-blue-600 text-white rounded-lg text-sm font-medium hover:bg-blue-700 transition">
                                    <i class="fa-solid fa-print mr-2"></i>Cetak
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

            </main>
        </div>
    </div>

    <!-- Mobile Sidebar Overlay -->
    <div id="sidebarOverlay" class="fixed inset-0 bg-black/50 z-40 hidden md:hidden" onclick="closeSidebar()"></div>

</body>
<script src="{{ asset('js/main/uiAnnoun.js') }}"></script>
<html>
