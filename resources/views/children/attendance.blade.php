<!DOCTYPE html>
<html lang="id" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Absensi Anak - Absensi SMKN 12 Jakarta</title>
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
    <link rel="stylesheet" href="{{ asset('css/parents/absenAnak.css') }}">
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
                    class="flex items-center px-4 py-3 text-gray-600 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-800 rounded-lg transition">
                    <i class="fa-solid fa-child w-6 mr-3"></i>
                    <span>Data Anak</span>
                </a>
                <a href="{{ route('children.attendance') }}"
                    class="flex items-center px-4 py-3 text-gray-700 dark:text-gray-300 bg-blue-50 dark:bg-blue-900/20 rounded-lg border-l-4 border-blue-500">
                    <i class="fa-solid fa-calendar-check w-6 mr-3"></i>
                    <span class="font-medium">Absensi Anak</span>
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
                <h1 class="text-xl font-semibold text-gray-900 dark:text-white">Absensi Anak</h1>

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
                    <!-- Filter Card -->
                    <div
                        class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-200 dark:border-gray-700 p-6 mb-6">
                        <form action="{{ route('children.attendance') }}" method="GET" class="flex flex-wrap gap-4">
                            @if ($children->count() > 1)
                                <select name="child_id"
                                    class="px-4 py-3 rounded-xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 focus:ring-2 focus:ring-blue-500 outline-none transition">
                                    @foreach ($children as $child)
                                        <option value="{{ $child->id }}"
                                            {{ $filters['child_id'] == $child->id ? 'selected' : '' }}>
                                            {{ $child->name }}
                                        </option>
                                    @endforeach
                                </select>
                            @endif
                            <div class="relative">
                                <select name="month"
                                    class="w-full px-4 py-3 pr-10 rounded-xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 focus:ring-2 focus:ring-blue-500 outline-none transition appearance-none">
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
                                    class="w-full px-4 py-3 pr-10 rounded-xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 focus:ring-2 focus:ring-blue-500 outline-none transition appearance-none">
                                    @for ($i = now()->year; $i >= now()->year - 2; $i--)
                                        <option value="{{ $i }}"
                                            {{ $filters['year'] == $i ? 'selected' : '' }}>{{ $i }}
                                        </option>
                                    @endfor
                                </select>
                                <i
                                    class="fa-solid fa-chevron-down absolute right-2 top-1/2 -translate-y-1/2 text-gray-500 dark:text-white text-xs pointer-events-none"></i>
                            </div>

                            <button type="submit"
                                class="px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-xl font-medium shadow transition">
                                <i class="fa-solid fa-filter mr-2"></i>Filter
                            </button>
                            <a href="{{ route('children.calendar', ['child_id' => $filters['child_id'], 'month' => $filters['month'], 'year' => $filters['year']]) }}"
                                class="px-6 py-3 bg-purple-600 hover:bg-purple-700 text-white rounded-xl font-medium shadow transition ml-auto">
                                <i class="fa-solid fa-calendar mr-2"></i>Kalender
                            </a>
                        </form>
                    </div>

                    @if ($selectedChild)
                        <!-- Statistics Cards -->
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
                            <div
                                class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-sm border border-gray-200 dark:border-gray-700">
                                <div class="flex items-center justify-between mb-4">
                                    <div class="p-3 bg-blue-100 dark:bg-blue-900/30 rounded-xl">
                                        <i class="fa-solid fa-user text-blue-600 dark:text-blue-400 text-xl"></i>
                                    </div>
                                    <span class="text-sm text-gray-500 dark:text-gray-400">Nama Anak</span>
                                </div>
                                <h3 class="text-lg font-bold text-gray-900 dark:text-white">{{ $selectedChild->name }}
                                </h3>
                            </div>

                            <div
                                class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-sm border border-gray-200 dark:border-gray-700">
                                <div class="flex items-center justify-between mb-4">
                                    <div class="p-3 bg-green-100 dark:bg-green-900/30 rounded-xl">
                                        <i
                                            class="fa-solid fa-check-circle text-green-600 dark:text-green-400 text-xl"></i>
                                    </div>
                                    <span class="text-sm text-gray-500 dark:text-gray-400">Hadir</span>
                                </div>
                                <h3 class="text-3xl font-bold text-green-600 dark:text-green-400">
                                    {{ $stats['presentDays'] }}</h3>
                                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">dari
                                    {{ $stats['totalDays'] }} hari</p>
                            </div>

                            <div
                                class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-sm border border-gray-200 dark:border-gray-700">
                                <div class="flex items-center justify-between mb-4">
                                    <div class="p-3 bg-red-100 dark:bg-red-900/30 rounded-xl">
                                        <i class="fa-solid fa-times-circle text-red-600 dark:text-red-400 text-xl"></i>
                                    </div>
                                    <span class="text-sm text-gray-500 dark:text-gray-400">Tidak Hadir</span>
                                </div>
                                <h3 class="text-3xl font-bold text-red-600 dark:text-red-400">
                                    {{ $stats['absentDays'] }}</h3>
                            </div>

                            <div
                                class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-sm border border-gray-200 dark:border-gray-700">
                                <div class="flex items-center justify-between mb-4">
                                    <div class="p-3 bg-yellow-100 dark:bg-yellow-900/30 rounded-xl">
                                        <i class="fa-solid fa-clock text-yellow-600 dark:text-yellow-400 text-xl"></i>
                                    </div>
                                    <span class="text-sm text-gray-500 dark:text-gray-400">Terlambat</span>
                                </div>
                                <h3 class="text-3xl font-bold text-yellow-600 dark:text-yellow-400">
                                    {{ $stats['lateDays'] }}</h3>
                            </div>
                        </div>

                        <!-- Attendance Rate Card -->
                        <div
                            class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-200 dark:border-gray-700 p-6 mb-6">
                            <div class="flex items-center justify-between mb-4">
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Tingkat Kehadiran</h3>
                                <span
                                    class="text-3xl font-bold {{ $stats['attendanceRate'] >= 80 ? 'text-green-600 dark:text-green-400' : ($stats['attendanceRate'] >= 60 ? 'text-yellow-600 dark:text-yellow-400' : 'text-red-600 dark:text-red-400') }}">
                                    {{ $stats['attendanceRate'] }}%
                                </span>
                            </div>
                            <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-4">
                                <div class="bg-{{ $stats['attendanceRate'] >= 80 ? 'green' : ($stats['attendanceRate'] >= 60 ? 'yellow' : 'red') }}-500 h-4 rounded-full transition-all"
                                    style="width: {{ $stats['attendanceRate'] }}%"></div>
                            </div>
                        </div>

                        <!-- Attendance Table -->
                        <div
                            class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
                            <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Detail Kehadiran</h3>
                            </div>
                            <div class="overflow-x-auto">
                                <table class="w-full">
                                    <thead class="bg-gray-50 dark:bg-gray-700/50">
                                        <tr>
                                            <th
                                                class="px-6 py-4 text-left text-sm font-semibold text-gray-700 dark:text-gray-300">
                                                Tanggal</th>
                                            <th
                                                class="px-6 py-4 text-left text-sm font-semibold text-gray-700 dark:text-gray-300">
                                                Hari</th>
                                            <th
                                                class="px-6 py-4 text-left text-sm font-semibold text-gray-700 dark:text-gray-300">
                                                Jam Masuk</th>
                                            <th
                                                class="px-6 py-4 text-left text-sm font-semibold text-gray-700 dark:text-gray-300">
                                                Jam Pulang</th>
                                            <th
                                                class="px-6 py-4 text-left text-sm font-semibold text-gray-700 dark:text-gray-300">
                                                Status</th>
                                            <th
                                                class="px-6 py-4 text-left text-sm font-semibold text-gray-700 dark:text-gray-300">
                                                Keterangan</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                                        @forelse($attendances as $attendance)
                                            @php
                                                $isLate =
                                                    $attendance->check_in &&
                                                    $attendance->check_in->format('H:i:s') > '07:30:00';
                                            @endphp
                                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/30 transition">
                                                <td
                                                    class="px-6 py-4 text-sm text-gray-900 dark:text-white font-medium">
                                                    {{ \Carbon\Carbon::parse($attendance->date)->format('d M Y') }}
                                                </td>
                                                <td class="px-6 py-4 text-sm text-gray-700 dark:text-gray-300">
                                                    {{ \Carbon\Carbon::parse($attendance->date)->format('l') }}
                                                </td>
                                                <td class="px-6 py-4 text-sm text-gray-700 dark:text-gray-300">
                                                    @if ($attendance->check_in)
                                                        <span
                                                            class="{{ $isLate ? 'text-yellow-600 dark:text-yellow-400' : 'text-green-600 dark:text-green-400' }}">
                                                            {{ $attendance->check_in->format('H:i') }} WIB
                                                        </span>
                                                    @else
                                                        <span class="text-gray-400">-</span>
                                                    @endif
                                                </td>
                                                <td class="px-6 py-4 text-sm text-gray-700 dark:text-gray-300">
                                                    @if ($attendance->check_out)
                                                        {{ $attendance->check_out->format('H:i') }} WIB
                                                    @else
                                                        <span class="text-gray-400">-</span>
                                                    @endif
                                                </td>
                                                <td class="px-6 py-4">
                                                    @if ($attendance->check_in)
                                                        <span
                                                            class="px-3 py-1 text-xs font-medium rounded-full bg-green-100 dark:bg-green-900/30 text-green-600 dark:text-green-400">
                                                            Hadir
                                                        </span>
                                                    @else
                                                        <span
                                                            class="px-3 py-1 text-xs font-medium rounded-full bg-red-100 dark:bg-red-900/30 text-red-600 dark:text-red-400">
                                                            Tidak Hadir
                                                        </span>
                                                    @endif
                                                </td>
                                                <td class="px-6 py-4 text-sm">
                                                    @if ($isLate)
                                                        <span class="text-yellow-600 dark:text-yellow-400">
                                                            <i class="fa-solid fa-clock mr-1"></i> Terlambat
                                                        </span>
                                                    @else
                                                        <span class="text-gray-400">-</span>
                                                    @endif
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="6"
                                                    class="px-6 py-12 text-center text-gray-500 dark:text-gray-400">
                                                    <i class="fa-solid fa-inbox text-4xl mb-3"></i>
                                                    <p>Tidak ada data kehadiran untuk periode ini</p>
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    @else
                        <div
                            class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-200 dark:border-gray-700 p-12 text-center">
                            <div
                                class="h-20 w-20 mx-auto mb-4 rounded-full bg-gray-100 dark:bg-gray-700 flex items-center justify-center">
                                <i class="fa-solid fa-child text-3xl text-gray-400"></i>
                            </div>
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">Anak Tidak Ditemukan
                            </h3>
                            <p class="text-gray-500 dark:text-gray-400">Silakan pilih anak dari daftar.</p>
                        </div>
                    @endif
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
<script src="{{ asset('js/child/absenAnak.js') }}"></script>
</html>
