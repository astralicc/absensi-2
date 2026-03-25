<!DOCTYPE html>
<html lang="id" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Anak - Absensi SMKN 12 Jakarta</title>
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
    <link rel="stylesheet" href="{{ asset('css/parents/dataAnak.css') }}">
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
                <a href="{{ route('dashboard.orangtua') }}"
                    class="flex items-center px-4 py-3 text-gray-600 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-800 rounded-lg transition">

                    <i class="fa-solid fa-house w-6 mr-3"></i>
                    <span>Dashboard</span>
                </a>
                <a href="{{ route('children.data') }}"
                    class="flex items-center px-4 py-3 text-gray-700 dark:text-gray-300 bg-blue-50 dark:bg-blue-900/20 rounded-lg border-l-4 border-blue-500">
                    <i class="fa-solid fa-child w-6 mr-3"></i>
                    <span class="font-medium">Data Anak</span>
                </a>
                <a href="{{ route('children.attendance') }}"
                    class="flex items-center px-4 py-3 text-gray-600 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-800 rounded-lg transition">
                    <i class="fa-solid fa-calendar-check w-6 mr-3"></i>
                    <span>Absensi Anak</span>
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
                <h1 class="text-xl font-semibold text-gray-900 dark:text-white">Data Anak</h1>

                <!-- Right Actions -->
                <div class="flex items-center gap-4">
                    <button onclick="toggleDark()" id="darkBtn"
                        class="p-2 rounded-lg bg-gray-200 dark:bg-gray-700 transition-all duration-300 ease-in-out transform hover:scale-110 active:scale-95 hover:shadow-lg dark:hover:shadow-gray-700/50 relative overflow-hidden">
                        <span id="darkIcon" class="block transition-transform duration-500 ease-in-out">🌙</span>
                    </button>


                    <div class="flex items-center gap-3 pl-4 border-l border-gray-200 dark:border-gray-700">
                        <div class="text-right hidden sm:block">
                            <p class="text-sm font-medium text-gray-900 dark:text-white">{{ $user->name }}</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400">Orang Tua</p>
                        </div>
                        <div
                            class="h-10 w-10 rounded-full bg-blue-500 flex items-center justify-center text-white font-bold">
                            {{ strtoupper(substr($user->name, 0, 1)) }}
                        </div>
                    </div>
                </div>
            </header>

            <!-- Content -->
            <main class="flex-1 overflow-y-auto p-6">

                @if ($children->count() > 0)
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach ($children as $child)
                            @php
                                $stats = $childrenStats[$child->id];
                                $rate = $stats['attendanceRate'];
                                $statusColor = $rate >= 80 ? 'green' : ($rate >= 60 ? 'yellow' : 'red');
                            @endphp
                            <div
                                class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden hover:shadow-md transition">
                                <div class="p-6">
                                    <div class="flex items-center gap-4 mb-4">
                                        <div
                                            class="h-16 w-16 rounded-2xl bg-gradient-to-br from-blue-400 to-blue-600 flex items-center justify-center text-white text-2xl font-bold">
                                            {{ strtoupper(substr($child->name, 0, 1)) }}
                                        </div>
                                        <div>
                                            <h3 class="text-lg font-bold text-gray-900 dark:text-white">
                                                {{ $child->name }}</h3>
                                            <p class="text-sm text-gray-500 dark:text-gray-400">NIS:
                                                {{ $child->id }}</p>
                                        </div>
                                    </div>

                                    <div class="space-y-3 mb-4">
                                        <div class="flex justify-between items-center">
                                            <span class="text-sm text-gray-500 dark:text-gray-400">Kehadiran Bulan
                                                Ini</span>
                                            <span
                                                class="text-sm font-bold text-{{ $statusColor }}-600">{{ $rate }}%</span>
                                        </div>
                                        <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2">
                                            <div class="bg-{{ $statusColor }}-500 h-2 rounded-full"
                                                style="width: {{ $rate }}%"></div>
                                        </div>
                                        <p class="text-xs text-gray-500 dark:text-gray-400">
                                            {{ $stats['presentDays'] }}/{{ $stats['totalDays'] }} hari hadir</p>
                                    </div>

                                    <div class="grid grid-cols-2 gap-3 mb-4">
                                        <div class="p-3 bg-gray-50 dark:bg-gray-700/50 rounded-xl text-center">
                                            <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">Terlambat</p>
                                            <p class="text-lg font-bold text-yellow-600">{{ $stats['lateDays'] }}</p>
                                        </div>
                                        <div class="p-3 bg-gray-50 dark:bg-gray-700/50 rounded-xl text-center">
                                            <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">Status Hari Ini</p>
                                            <p
                                                class="text-sm font-bold {{ $stats['todayStatus'] == 'Hadir' ? 'text-green-600' : ($stats['todayStatus'] == 'Tidak Hadir' ? 'text-red-600' : 'text-gray-500') }}">
                                                {{ $stats['todayStatus'] }}
                                            </p>
                                            @if ($stats['todayCheckIn'])
                                                <p class="text-xs text-gray-500">{{ $stats['todayCheckIn'] }}</p>
                                            @endif
                                        </div>
                                    </div>

                                    <a href="{{ route('children.show', $child->id) }}"
                                        class="block w-full py-3 bg-blue-50 dark:bg-blue-900/20 text-blue-600 dark:text-blue-400 rounded-xl text-center font-medium hover:bg-blue-100 dark:hover:bg-blue-900/30 transition">
                                        <i class="fa-solid fa-eye mr-2"></i> Lihat Detail
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div
                        class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-200 dark:border-gray-700 p-12 text-center">
                        <div
                            class="h-20 w-20 mx-auto mb-4 rounded-full bg-gray-100 dark:bg-gray-700 flex items-center justify-center">
                            <i class="fa-solid fa-child text-3xl text-gray-400"></i>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">Belum Ada Data Anak</h3>
                        <p class="text-gray-500 dark:text-gray-400">Silakan hubungi admin untuk menghubungkan akun
                            dengan data anak Anda.</p>
                    </div>
                @endif
            </main>
        </div>
    </div>

    <!-- Mobile Sidebar Overlay -->
    <div id="sidebarOverlay" class="fixed inset-0 bg-black/50 z-40 hidden md:hidden" onclick="closeSidebar()"></div>

</body>
<script src="{{ asset('js/child/dataAnak.js') }}"></script>

</html>
