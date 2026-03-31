<!DOCTYPE html>
<html lang="id" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Absensi - Absensi SMKN 12 Jakarta</title>
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
    <link rel="stylesheet" href="{{ asset('css/dashboard/style.css') }}">
    <style>
        body { --nav-hover-color: #22c55e; }
    </style>
    <script src="{{ asset('js/wali-kelas-sidebar.js') }}"></script>
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
                <a href="{{ route('dashboard.guru') }}"
                    class="flex items-center px-4 py-3 text-gray-600 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-800 rounded-lg transition">
                    <i class="fa-solid fa-house w-6 mr-3"></i>
                    <span>Dashboard</span>
                </a>
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
                    class="flex items-center px-4 py-3 text-green-700 dark:text-green-300 bg-green-50 dark:bg-green-900/20 rounded-lg border-l-4 border-green-500">
                    <i class="fa-solid fa-chart-line w-6 mr-3"></i>
                    <span class="font-medium">Laporan</span>
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
                <h1 class="text-xl font-semibold text-gray-900 dark:text-white">Laporan Absensi</h1>

                <!-- Right Actions -->
                <div class="flex items-center gap-4">
                    <button onclick="toggleDark()" id="darkBtn"
                        class="p-2 rounded-lg bg-gray-200 dark:bg-gray-700 transition-all duration-300 ease-in-out transform hover:scale-110 active:scale-95 hover:shadow-lg dark:hover:shadow-gray-700/50 relative overflow-hidden">
                        <span id="darkIcon" class="block transition-transform duration-500 ease-in-out">🌙</span>
                    </button>

                    <div class="flex items-center gap-3 pl-4 border-l border-gray-200 dark:border-gray-700">
                        <div class="text-right hidden sm:block">
                            <p class="text-sm font-medium text-gray-900 dark:text-white">{{ $user->name }}</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400">Guru</p>
                        </div>
                        <div
                            class="h-10 w-10 rounded-full bg-purple-500 flex items-center justify-center text-white font-bold">
                            {{ strtoupper(substr($user->name, 0, 1)) }}
                        </div>
                    </div>
                </div>
            </header>

            <!-- Content -->
            <main class="flex-1 overflow-y-auto p-6">

                <!-- Filter Card -->
                <div
                    class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-200 dark:border-gray-700 p-6 mb-6">
                    <form action="{{ route('reports.index') }}" method="GET" class="flex flex-wrap gap-4">
                        <div class="relative">
                            <select name="month"
                                class="w-full px-4 py-3 pr-10 rounded-xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 focus:ring-2 focus:ring-purple-500 outline-none transition appearance-none">
                                @for ($i = 1; $i <= 12; $i++)
                                    <option value="{{ $i }}"
                                        {{ $filters['month'] == $i ? 'selected' : '' }}>
                                        {{ \Carbon\Carbon::create()->month($i)->format('F') }}
                                    </option>
                                @endfor
                            </select>
                            <i
                                class="fa-solid fa-chevron-down absolute right-2 top-1/2 -translate-y-1/2 text-gray-500 dark:text-white text-xs pointer-events-none"></i>
                        </div>
                        <div class="relative">
                            <select name="year"
                                class="w-full px-4 py-3 pr-10 rounded-xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 focus:ring-2 focus:ring-purple-500 outline-none transition appearance-none">
                                @for ($i = now()->year; $i >= now()->year - 2; $i--)
                                    <option value="{{ $i }}"
                                        {{ $filters['year'] == $i ? 'selected' : '' }}>{{ $i }}</option>
                                @endfor
                            </select>
                            <i
                                class="fa-solid fa-chevron-down absolute right-2 top-1/2 -translate-y-1/2 text-gray-500 dark:text-white text-xs pointer-events-none"></i>
                        </div>

                        <button type="submit"
                            class="px-6 py-3 bg-purple-600 hover:bg-purple-700 text-white rounded-xl font-medium shadow transition">
                            <i class="fa-solid fa-filter mr-2"></i>Filter
                        </button>
                        <a href="{{ route('reports.export', ['month' => $filters['month'], 'year' => $filters['year']]) }}"
                            class="px-6 py-3 bg-green-600 hover:bg-green-700 text-white rounded-xl font-medium shadow transition ml-auto">
                            <i class="fa-solid fa-download mr-2"></i>Export Excel
                        </a>
                    </form>
                </div>

                <!-- Overall Stats Cards -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
                    <div
                        class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-sm border border-gray-200 dark:border-gray-700">
                        <div class="flex items-center justify-between mb-4">
                            <div class="p-3 bg-purple-100 dark:bg-purple-900/30 rounded-xl">
                                <i class="fa-solid fa-users text-purple-600 dark:text-purple-400 text-xl"></i>
                            </div>
                            <span class="text-sm text-gray-500 dark:text-gray-400">Total Siswa</span>
                        </div>
                        <h3 class="text-3xl font-bold text-gray-900 dark:text-white">
                            {{ $overallStats['totalStudents'] }}</h3>
                    </div>

                    <div
                        class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-sm border border-gray-200 dark:border-gray-700">
                        <div class="flex items-center justify-between mb-4">
                            <div class="p-3 bg-purple-100 dark:bg-purple-900/30 rounded-xl">
                                <i
                                    class="fa-solid fa-clipboard-check text-purple-600 dark:text-purple-400 text-xl"></i>
                            </div>
                            <span class="text-sm text-gray-500 dark:text-gray-400">Total Kehadiran</span>
                        </div>
                        <h3 class="text-3xl font-bold text-gray-900 dark:text-white">
                            {{ $overallStats['totalAttendanceRecords'] }}</h3>
                    </div>

                    <div
                        class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-sm border border-gray-200 dark:border-gray-700">
                        <div class="flex items-center justify-between mb-4">
                            <div class="p-3 bg-green-100 dark:bg-green-900/30 rounded-xl">
                                <i class="fa-solid fa-check-circle text-green-600 dark:text-green-400 text-xl"></i>
                            </div>
                            <span class="text-sm text-gray-500 dark:text-gray-400">Total Hadir</span>
                        </div>
                        <h3 class="text-3xl font-bold text-green-600 dark:text-green-400">
                            {{ $overallStats['totalPresentRecords'] }}</h3>
                    </div>

                    <div
                        class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-sm border border-gray-200 dark:border-gray-700">
                        <div class="flex items-center justify-between mb-4">
                            <div class="p-3 bg-yellow-100 dark:bg-yellow-900/30 rounded-xl">
                                <i class="fa-solid fa-percentage text-yellow-600 dark:text-yellow-400 text-xl"></i>
                            </div>
                            <span class="text-sm text-gray-500 dark:text-gray-400">Tingkat Kehadiran</span>
                        </div>
                        <h3
                            class="text-3xl font-bold {{ $overallStats['overallAttendanceRate'] >= 80 ? 'text-green-600 dark:text-green-400' : ($overallStats['overallAttendanceRate'] >= 60 ? 'text-yellow-600 dark:text-yellow-400' : 'text-red-600 dark:text-red-400') }}">
                            {{ $overallStats['overallAttendanceRate'] }}%
                        </h3>
                    </div>
                </div>

                <!-- Student Reports Table Card -->
                <div
                    class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden mb-6">
                    <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Laporan per Siswa</h3>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead class="bg-gray-50 dark:bg-gray-700/50">
                                <tr>
                                    <th
                                        class="px-6 py-4 text-left text-sm font-semibold text-gray-700 dark:text-gray-300">
                                        Ranking</th>
                                    <th
                                        class="px-6 py-4 text-left text-sm font-semibold text-gray-700 dark:text-gray-300">
                                        Nama</th>
                                    <th
                                        class="px-6 py-4 text-left text-sm font-semibold text-gray-700 dark:text-gray-300">
                                        Hadir</th>
                                    <th
                                        class="px-6 py-4 text-left text-sm font-semibold text-gray-700 dark:text-gray-300">
                                        Tidak Hadir</th>
                                    <th
                                        class="px-6 py-4 text-left text-sm font-semibold text-gray-700 dark:text-gray-300">
                                        Persentase</th>
                                    <th
                                        class="px-6 py-4 text-left text-sm font-semibold text-gray-700 dark:text-gray-300">
                                        Status</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                                @foreach ($studentReports as $index => $report)
                                    @php
                                        $rate = $report['attendanceRate'];
                                        $statusColor = $rate >= 80 ? 'green' : ($rate >= 60 ? 'yellow' : 'red');
                                        $statusText = $rate >= 80 ? 'Baik' : ($rate >= 60 ? 'Cukup' : 'Kurang');
                                    @endphp
                                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/30 transition">
                                        <td class="px-6 py-4 text-sm text-gray-900 dark:text-white font-medium">
                                            {{ $index + 1 }}</td>
                                        <td class="px-6 py-4 font-medium text-gray-900 dark:text-white">
                                            {{ $report['student']->name }}</td>
                                        <td class="px-6 py-4 text-sm text-green-600 dark:text-green-400 font-medium">
                                            {{ $report['presentDays'] }}</td>
                                        <td class="px-6 py-4 text-sm text-red-600 dark:text-red-400 font-medium">
                                            {{ $report['absentDays'] }}</td>
                                        <td class="px-6 py-4">
                                            <div class="flex items-center gap-3">
                                                <div class="w-24 bg-gray-200 dark:bg-gray-700 rounded-full h-2.5">
                                                    <div class="bg-{{ $statusColor }}-500 h-2.5 rounded-full transition-all"
                                                        style="width: {{ $rate }}%"></div>
                                                </div>
                                                <span
                                                    class="text-sm font-medium text-gray-700 dark:text-gray-300">{{ $rate }}%</span>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4">
                                            <span
                                                class="px-3 py-1 text-xs font-medium rounded-full bg-{{ $statusColor }}-100 dark:bg-{{ $statusColor }}-900/30 text-{{ $statusColor }}-600 dark:text-{{ $statusColor }}-400">
                                                {{ $statusText }}
                                            </span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Daily Stats Card -->
                <div
                    class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Statistik Harian</h3>
                    </div>
                    <div class="p-6">
                        <div class="grid grid-cols-7 gap-2">
                            @foreach ($dailyStats as $day => $stats)
                                @php
                                    $rate = $stats['rate'];
                                    $color = $rate >= 80 ? 'green' : ($rate >= 60 ? 'yellow' : 'red');
                                @endphp
                                <div
                                    class="text-center p-3 rounded-xl bg-gray-50 dark:bg-gray-700/30 border border-gray-200 dark:border-gray-700">
                                    <p class="text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">
                                        {{ $day }}</p>
                                    <div
                                        class="w-8 h-8 mx-auto rounded-full bg-{{ $color }}-100 dark:bg-{{ $color }}-900/30 flex items-center justify-center mb-1">
                                        <span
                                            class="text-xs font-bold text-{{ $color }}-600 dark:text-{{ $color }}-400">{{ $stats['present'] }}</span>
                                    </div>
                                    <p class="text-[10px] text-gray-400 dark:text-gray-500">{{ $rate }}%</p>
                                </div>
                            @endforeach
                        </div>

                        <!-- Legend -->
                        <div class="mt-4 flex flex-wrap gap-4 justify-center text-xs">
                            <div class="flex items-center gap-1">
                                <div class="w-3 h-3 rounded-full bg-green-500"></div>
                                <span class="text-gray-600 dark:text-gray-400">Baik (≥80%)</span>
                            </div>
                            <div class="flex items-center gap-1">
                                <div class="w-3 h-3 rounded-full bg-yellow-500"></div>
                                <span class="text-gray-600 dark:text-gray-400">Cukup (60-79%)</span>
                            </div>
                            <div class="flex items-center gap-1">
                                <div class="w-3 h-3 rounded-full bg-red-500"></div>
                                <span class="text-gray-600 dark:text-gray-400">Kurang (<60%)< /span>
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
<script src="{{ asset('js/main/laporanGuru.js') }}"></script>

</html>
