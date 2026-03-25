<!DOCTYPE html>
<html lang="id" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Absensi - Absensi SMKN 12 Jakarta</title>
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
    <link rel="stylesheet" href="{{ asset('css/dashboard/kelola.css') }}">
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


                @if (auth()->user()->isMurid())
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
                @elseif(auth()->user()->isGuru())
                    <a href="{{ route('attendance.manage') }}"

                        class="flex items-center px-4 py-3 text-green-700 dark:text-green-300 bg-green-50 dark:bg-green-900/20 rounded-lg border-l-4 border-green-500">
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
                @elseif(auth()->user()->isOrangTua())
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
                    Kelola Absensi
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
                            <p class="text-xs text-gray-500 dark:text-gray-400">Guru</p>
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

                <!-- Statistics Cards -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                    <div
                        class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-sm border border-gray-200 dark:border-gray-700">
                        <div class="flex items-center justify-between mb-4">
                            <div class="p-3 bg-blue-100 dark:bg-blue-900/30 rounded-lg">
                                <i class="fa-solid fa-users text-blue-600 dark:text-blue-400 text-xl"></i>
                            </div>
                            <span class="text-sm text-gray-500 dark:text-gray-400">Total Siswa</span>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900 dark:text-white">{{ $stats['totalStudents'] }}</h3>
                        <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Siswa terdaftar</p>
                    </div>

                    <div
                        class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-sm border border-gray-200 dark:border-gray-700">
                        <div class="flex items-center justify-between mb-4">
                            <div class="p-3 bg-green-100 dark:bg-green-900/30 rounded-lg">
                                <i class="fa-solid fa-check-circle text-green-600 dark:text-green-400 text-xl"></i>
                            </div>
                            <span class="text-sm text-gray-500 dark:text-gray-400">Hadir</span>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900 dark:text-white">{{ $stats['presentCount'] }}</h3>
                        <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Siswa hadir</p>
                    </div>

                    <div
                        class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-sm border border-gray-200 dark:border-gray-700">
                        <div class="flex items-center justify-between mb-4">
                            <div class="p-3 bg-red-100 dark:bg-red-900/30 rounded-lg">
                                <i class="fa-solid fa-times-circle text-red-600 dark:text-red-400 text-xl"></i>
                            </div>
                            <span class="text-sm text-gray-500 dark:text-gray-400">Absen</span>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900 dark:text-white">{{ $stats['absentCount'] }}</h3>
                        <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Siswa tidak hadir</p>
                    </div>
                </div>

                <!-- Date Filter -->
                <div
                    class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-sm border border-gray-200 dark:border-gray-700 mb-6">
                    <form action="{{ route('attendance.manage') }}" method="GET"
                        class="flex flex-wrap gap-4 items-end">
                        <div>
                            <label
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Tanggal</label>
                            <input type="date" name="date" value="{{ $date }}"
                                class="px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500">
                        </div>
                        <button type="submit"
                            class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-medium transition">
                            <i class="fa-solid fa-filter mr-2"></i>Tampilkan
                        </button>
                    </form>
                </div>

                <!-- Attendance Management Table -->
                <div
                    class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
                    <div
                        class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 flex items-center justify-between">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Daftar Kehadiran -
                            {{ date('d M Y', strtotime($date)) }}</h3>
                        <div class="flex gap-2">
                            <button onclick="markAllPresent()"
                                class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg text-sm font-medium transition">
                                <i class="fa-solid fa-check mr-2"></i>Hadir Semua
                            </button>
                            <button onclick="markAllAbsent()"
                                class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg text-sm font-medium transition">
                                <i class="fa-solid fa-times mr-2"></i>Absen Semua
                            </button>
                        </div>
                    </div>
                    <div class="overflow-x-auto">
                        <form id="bulkAttendanceForm" action="{{ route('attendance.bulk-mark') }}" method="POST">
                            @csrf
                            <input type="hidden" name="date" value="{{ $date }}">
                            <table class="w-full">
                                <thead class="bg-gray-50 dark:bg-gray-700/50">
                                    <tr>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                            No</th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                            NISN</th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                            Nama Siswa</th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                            Status</th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                            Jam Masuk</th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                            Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                                    @forelse($students as $index => $student)
                                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition">
                                            <td
                                                class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">
                                                {{ $index + 1 }}
                                            </td>
                                            <td
                                                class="px-6 py-4 whitespace-nowrap text-sm text-gray-600 dark:text-gray-400">
                                                {{ $student->nisn ?? '-' }}
                                            </td>
                                            <td
                                                class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-white">
                                                {{ $student->name }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                @if (isset($attendances[$student->id]))
                                                    <span
                                                        class="px-3 py-1 text-xs font-medium bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-400 rounded-full">
                                                        Hadir
                                                    </span>
                                                @else
                                                    <span
                                                        class="px-3 py-1 text-xs font-medium bg-red-100 dark:bg-red-900/30 text-red-700 dark:text-red-400 rounded-full">
                                                        Tidak Hadir
                                                    </span>
                                                @endif
                                            </td>
                                            <td
                                                class="px-6 py-4 whitespace-nowrap text-sm text-gray-600 dark:text-gray-400">
                                                @if (isset($attendances[$student->id]))
                                                    {{ date('H:i', strtotime($attendances[$student->id])) }} WIB
                                                @else
                                                    -
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                                <div class="flex gap-2">
                                                    @if (isset($attendances[$student->id]))
                                                        <form action="{{ route('attendance.mark') }}" method="POST"
                                                            class="inline">
                                                            @csrf
                                                            <input type="hidden" name="user_id"
                                                                value="{{ $student->id }}">
                                                            <input type="hidden" name="date"
                                                                value="{{ $date }}">
                                                            <input type="hidden" name="status" value="absent">
                                                            <button type="submit"
                                                                class="px-3 py-1 bg-red-100 dark:bg-red-900/30 text-red-700 dark:text-red-400 rounded-lg text-xs font-medium hover:bg-red-200 dark:hover:bg-red-900/50 transition">
                                                                <i class="fa-solid fa-times mr-1"></i>Absen
                                                            </button>
                                                        </form>
                                                    @else
                                                        <form action="{{ route('attendance.mark') }}" method="POST"
                                                            class="inline">
                                                            @csrf
                                                            <input type="hidden" name="user_id"
                                                                value="{{ $student->id }}">
                                                            <input type="hidden" name="date"
                                                                value="{{ $date }}">
                                                            <input type="hidden" name="status" value="present">
                                                            <button type="submit"
                                                                class="px-3 py-1 bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-400 rounded-lg text-xs font-medium hover:bg-green-200 dark:hover:bg-green-900/50 transition">
                                                                <i class="fa-solid fa-check mr-1"></i>Hadir
                                                            </button>
                                                        </form>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                        <input type="hidden" name="attendances[{{ $student->id }}]"
                                            value="{{ isset($attendances[$student->id]) ? 'present' : 'absent' }}"
                                            id="attendance_{{ $student->id }}">
                                    @empty
                                        <tr>
                                            <td colspan="6"
                                                class="px-6 py-8 text-center text-gray-500 dark:text-gray-400">
                                                <i class="fa-solid fa-inbox text-4xl mb-4"></i>
                                                <p>Belum ada data siswa</p>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </form>
                    </div>
                </div>

            </main>
        </div>
    </div>

    <!-- Mobile Sidebar Overlay -->
    <div id="sidebarOverlay" class="fixed inset-0 bg-black/50 z-40 hidden md:hidden" onclick="closeSidebar()"></div>

</body>
<script src="{{ asset('js/main/kelola.js') }}"></script>
</html>
