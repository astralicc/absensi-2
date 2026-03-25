<!DOCTYPE html>
<html lang="id" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Siswa - Absensi SMKN 12 Jakarta</title>
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
    <link rel="stylesheet" href="{{ asset('css/students/daftarSiswa.css') }}">
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
                    class="flex items-center px-4 py-3 text-green-700 dark:text-green-300 bg-green-50 dark:bg-green-900/20 rounded-lg border-l-4 border-green-500 font-medium">
                    <i class="fa-solid fa-users w-6 mr-3"></i>
                    <span class="font-medium">Daftar Siswa</span>
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
                <h1 class="text-xl font-semibold text-gray-900 dark:text-white">Daftar Siswa</h1>

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
                            class="h-10 w-10 rounded-full bg-blue-500 flex items-center justify-center text-white font-bold">
                            {{ strtoupper(substr($user->name, 0, 1)) }}
                        </div>
                    </div>
                </div>
            </header>

            <!-- Content -->
            <main class="flex-1 overflow-y-auto p-6">

                <!-- Search & Filter Card -->
                <div
                    class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-200 dark:border-gray-700 p-6 mb-6">
                    <form action="{{ route('students.index') }}" method="GET" class="flex flex-wrap gap-4">
                        <div class="flex-1 min-w-50">
                            <input type="text" name="search" value="{{ $filters['search'] }}"
                                placeholder="Cari nama atau NISN..."
                                class="w-full px-4 py-3 rounded-xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 focus:ring-2 focus:ring-blue-500 outline-none transition">
                        </div>
                        <div class="relative">
                            <select name="sort_by"
                                class="w-full px-4 py-3 pr-10 rounded-xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 focus:ring-2 focus:ring-blue-500 outline-none transition appearance-none">
                                <option value="name" {{ $filters['sort_by'] == 'name' ? 'selected' : '' }}>Nama
                                </option>
                                <option value="nisn" {{ $filters['sort_by'] == 'nisn' ? 'selected' : '' }}>NISN
                                </option>
                            </select>
                            <i
                                class="fa-solid fa-chevron-down absolute right-2 top-1/2 -translate-y-1/2 text-gray-500 dark:text-white text-xs pointer-events-none"></i>
                        </div>
                        <div class="relative">
                            <select name="sort_order"
                                class="w-full px-4 py-3 pr-10 rounded-xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 focus:ring-2 focus:ring-blue-500 outline-none transition appearance-none">
                                <option value="asc" {{ $filters['sort_order'] == 'asc' ? 'selected' : '' }}>A-Z
                                </option>
                                <option value="desc" {{ $filters['sort_order'] == 'desc' ? 'selected' : '' }}>Z-A
                                </option>
                            </select>
                            <i
                                class="fa-solid fa-chevron-down absolute right-2 top-1/2 -translate-y-1/2 text-gray-500 dark:text-white text-xs pointer-events-none"></i>
                        </div>

                        <button type="submit"
                            class="px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-xl font-medium shadow transition">
                            <i class="fa-solid fa-search mr-2"></i>Cari
                        </button>
                    </form>
                </div>

                <!-- Students Table Card -->
                <div
                    class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Data Siswa</h3>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead class="bg-gray-50 dark:bg-gray-700/50">
                                <tr>
                                    <th
                                        class="px-6 py-4 text-left text-sm font-semibold text-gray-700 dark:text-gray-300">
                                        NISN</th>
                                    <th
                                        class="px-6 py-4 text-left text-sm font-semibold text-gray-700 dark:text-gray-300">
                                        Nama</th>
                                    <th
                                        class="px-6 py-4 text-left text-sm font-semibold text-gray-700 dark:text-gray-300">
                                        Kehadiran Bulan Ini</th>
                                    <th
                                        class="px-6 py-4 text-left text-sm font-semibold text-gray-700 dark:text-gray-300">
                                        Status</th>
                                    <th
                                        class="px-6 py-4 text-left text-sm font-semibold text-gray-700 dark:text-gray-300">
                                        Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                                @forelse($students as $student)
                                    @php
                                        $stats = $studentStats[$student->id];
                                        $rate = $stats['attendanceRate'];
                                        $statusColor = $rate >= 80 ? 'green' : ($rate >= 60 ? 'yellow' : 'red');
                                        $statusText = $rate >= 80 ? 'Baik' : ($rate >= 60 ? 'Cukup' : 'Kurang');
                                    @endphp
                                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/30 transition">
                                        <td class="px-6 py-4 text-sm text-gray-900 dark:text-white font-medium">
                                            {{ $student->nisn ?? '-' }}</td>
                                        <td class="px-6 py-4">
                                            <div class="flex items-center gap-3">
                                                <div
                                                    class="h-10 w-10 rounded-full bg-linear-to-br from-blue-400 to-blue-600 flex items-center justify-center text-white font-bold">
                                                    {{ strtoupper(substr($student->name, 0, 1)) }}
                                                </div>
                                                <span
                                                    class="font-medium text-gray-900 dark:text-white">{{ $student->name }}</span>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="flex items-center gap-3">
                                                <div class="w-24 bg-gray-200 dark:bg-gray-700 rounded-full h-2.5">
                                                    <div class="bg-{{ $statusColor }}-500 h-2.5 rounded-full transition-all"
                                                        style="width: {{ $rate }}%"></div>
                                                </div>
                                                <span
                                                    class="text-sm font-medium text-gray-700 dark:text-gray-300">{{ $rate }}%</span>
                                            </div>
                                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                                                {{ $stats['presentDays'] }}/{{ $stats['totalDays'] }} hari hadir</p>
                                        </td>
                                        <td class="px-6 py-4">
                                            <span
                                                class="px-3 py-1 text-xs font-medium rounded-full bg-{{ $statusColor }}-100 dark:bg-{{ $statusColor }}-900/30 text-{{ $statusColor }}-600 dark:text-{{ $statusColor }}-400">
                                                {{ $statusText }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4">
                                            <a href="{{ route('students.show', $student->id) }}"
                                                class="inline-flex items-center px-4 py-2 bg-blue-50 dark:bg-blue-900/20 text-blue-600 dark:text-blue-400 rounded-lg hover:bg-blue-100 dark:hover:bg-blue-900/30 transition">
                                                <i class="fa-solid fa-eye mr-2"></i> Detail
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5"
                                            class="px-6 py-12 text-center text-gray-500 dark:text-gray-400">
                                            <i class="fa-solid fa-inbox text-4xl mb-3"></i>
                                            <p>Tidak ada data siswa</p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-700">
                        {{ $students->links() }}
                    </div>
                </div>
            </main>
        </div>
    </div>

    <!-- Mobile Sidebar Overlay -->
    <div id="sidebarOverlay" class="fixed inset-0 bg-black/50 z-40 hidden md:hidden" onclick="closeSidebar()"></div>

</body>
<script src="{{ asset('js/students/daftarSiswa.js') }}"></script>

</html>
