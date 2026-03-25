<!DOCTYPE html>
<html lang="id" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Siswa - {{ $student->name }} - Absensi SMKN 12 Jakarta</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css"
        integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="icon" href="/logo.png">
    <link rel="stylesheet" href="{{ asset('css/students/detailSiswa.css') }}">
</head>

<body class="text-gray-800 dark:text-gray-200 bg-gray-100 dark:bg-gray-950 min-h-screen">
    
    <!-- Sidebar & Main Content Wrapper -->
    <div class="flex h-screen overflow-hidden">
        
        <!-- Sidebar -->
        <aside id="sidebar" class="fixed inset-y-0 left-0 z-50 w-64 bg-white dark:bg-gray-900 border-r border-gray-200 dark:border-gray-700 transform -translate-x-full md:translate-x-0 transition-transform duration-300 ease-in-out">
            <!-- Logo -->
            <div class="flex items-center justify-center h-16 border-b border-gray-200 dark:border-gray-700">
                <img src="/assets/logo.png" alt="Logo" class="h-8 w-auto">
                <span class="ml-2 font-bold text-sm text-gray-900 dark:text-white">Absensi SMKN 12 Jakarta</span>
            </div>
            
            <!-- Navigation -->
            <nav class="mt-6 px-4 space-y-2">
                <a href="{{ route('dashboard.guru') }}" class="flex items-center px-4 py-3 text-gray-600 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-800 rounded-lg transition">
                    <i class="fa-solid fa-house w-6 mr-3"></i>
                    <span>Dashboard</span>
                </a>
                <a href="{{ route('attendance.manage') }}" class="flex items-center px-4 py-3 text-gray-600 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-800 rounded-lg transition">
                    <i class="fa-solid fa-clipboard-list w-6 mr-3"></i>
                    <span>Kelola Absensi</span>
                </a>
                <a href="{{ route('students.index') }}" class="flex items-center px-4 py-3 text-gray-700 dark:text-gray-300 bg-blue-50 dark:bg-blue-900/20 rounded-lg border-l-4 border-blue-500">
                    <i class="fa-solid fa-users w-6 mr-3"></i>
                    <span class="font-medium">Daftar Siswa</span>
                </a>
                <a href="{{ route('schedule.manage') }}" class="flex items-center px-4 py-3 text-gray-600 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-800 rounded-lg transition">
                    <i class="fa-solid fa-calendar-days w-6 mr-3"></i>
                    <span>Kelola Jadwal</span>
                </a>
                <a href="{{ route('reports.index') }}" class="flex items-center px-4 py-3 text-gray-600 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-800 rounded-lg transition">
                    <i class="fa-solid fa-chart-line w-6 mr-3"></i>
                    <span>Laporan</span>
                </a>
                <a href="{{ route('announcements.index') }}" class="flex items-center px-4 py-3 text-gray-600 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-800 rounded-lg transition">
                    <i class="fa-solid fa-bullhorn w-6 mr-3"></i>
                    <span>Pengumuman</span>
                    @if($unreadCount > 0)
                        <span class="ml-auto bg-red-500 text-white text-xs font-bold px-2 py-1 rounded-full">{{ $unreadCount }}</span>
                    @endif
                </a>
            </nav>
            
            <!-- Bottom Actions -->
            <div class="absolute bottom-0 w-full p-4 border-t border-gray-200 dark:border-gray-700">
                <form action="{{ route('logout') }}" method="POST" class="w-full">
                    @csrf
                    <button type="submit" class="flex items-center w-full px-4 py-3 text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20 rounded-lg transition">
                        <i class="fa-solid fa-right-from-bracket w-6 mr-3"></i>
                        <span class="font-medium">Logout</span>
                    </button>
                </form>
            </div>
        </aside>
        
        <!-- Main Content -->
        <div class="flex-1 flex flex-col md:ml-64">
            
            <!-- Top Header -->
            <header class="glass sticky top-0 z-40 h-16 border-b border-gray-200 dark:border-gray-700 px-6 flex items-center justify-between">
                <!-- Mobile Menu Button -->
                <button id="mobileMenuBtn" class="md:hidden p-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-800 transition">
                    <i class="fa-solid fa-bars text-xl"></i>
                </button>
                
                <!-- Page Title -->
                <h1 class="text-xl font-semibold text-gray-900 dark:text-white">Detail Siswa</h1>
                
                <!-- Right Actions -->
                <div class="flex items-center gap-4">
                    <button onclick="toggleDark()" id="darkBtn" class="p-2 rounded-lg bg-gray-200 dark:bg-gray-700 transition-all duration-300">
                        🌙
                    </button>
                    
                    <div class="flex items-center gap-3 pl-4 border-l border-gray-200 dark:border-gray-700">
                        <div class="text-right hidden sm:block">
                            <p class="text-sm font-medium text-gray-900 dark:text-white">{{ $user->name }}</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400">Guru</p>
                        </div>
                        <div class="h-10 w-10 rounded-full bg-blue-500 flex items-center justify-center text-white font-bold">
                            {{ strtoupper(substr($user->name, 0, 1)) }}
                        </div>
                    </div>
                </div>
            </header>
            
            <!-- Content -->
            <main class="flex-1 overflow-y-auto p-6">
                
                <!-- Back Button -->
                <a href="{{ route('students.index') }}" class="inline-flex items-center gap-2 text-gray-500 hover:text-gray-700 dark:hover:text-gray-300 mb-6 transition">
                    <i class="fa-solid fa-arrow-left"></i> Kembali ke Daftar Siswa
                </a>    

                <!-- Student Info Card -->
                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-200 dark:border-gray-700 p-6 mb-6">
                    <div class="flex items-start gap-6">
                        <div class="h-24 w-24 rounded-2xl bg-gradient-to-br from-blue-400 to-blue-600 flex items-center justify-center text-white text-4xl font-bold shadow-lg">
                            {{ strtoupper(substr($student->name, 0, 1)) }}
                        </div>
                        <div class="flex-1">
                            <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-1">{{ $student->name }}</h2>
                            <p class="text-gray-500 dark:text-gray-400 mb-2">NIS: {{ $student->id }}</p>
                            <p class="text-gray-500 dark:text-gray-400">{{ $student->email }}</p>
                        </div>
                    </div>
                </div>

                <!-- Monthly Statistics Card -->
                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-200 dark:border-gray-700 p-6 mb-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Statistik Kehadiran Tahun {{ date('Y') }}</h3>
                    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                        @php
                            $monthNames = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
                        @endphp
                        @foreach($monthlyStats as $month => $stats)
                            @php
                                $rate = $stats['attendanceRate'];
                                $color = $rate >= 80 ? 'green' : ($rate >= 60 ? 'yellow' : 'red');
                            @endphp
                            <div class="p-4 rounded-xl bg-gray-50 dark:bg-gray-700/50 border border-gray-200 dark:border-gray-700">
                                <p class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-2">{{ $monthNames[$month - 1] }}</p>
                                <p class="text-3xl font-bold text-{{ $color }}-600 dark:text-{{ $color }}-400 mb-1">{{ $rate }}%</p>
                                <p class="text-xs text-gray-500 dark:text-gray-400">{{ $stats['presentDays'] }}/{{ $stats['totalDays'] }} hari</p>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Recent Attendance Card -->
                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Riwayat Kehadiran Terakhir</h3>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead class="bg-gray-50 dark:bg-gray-700/50">
                                <tr>
                                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700 dark:text-gray-300">Tanggal</th>
                                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700 dark:text-gray-300">Jam Masuk</th>
                                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700 dark:text-gray-300">Jam Pulang</th>
                                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700 dark:text-gray-300">Status</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                                @forelse($attendances as $attendance)
                                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/30 transition">
                                        <td class="px-6 py-4 text-sm text-gray-900 dark:text-white font-medium">
                                            {{ \Carbon\Carbon::parse($attendance->date)->format('d M Y') }}
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-700 dark:text-gray-300">
                                            @if($attendance->check_in)
                                                {{ \Carbon\Carbon::parse($attendance->check_in)->format('H:i') }} WIB
                                            @else
                                                <span class="text-gray-400">-</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-700 dark:text-gray-300">
                                            @if($attendance->check_out)
                                                {{ \Carbon\Carbon::parse($attendance->check_out)->format('H:i') }} WIB
                                            @else
                                                <span class="text-gray-400">-</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4">
                                            @if($attendance->check_in)
                                                <span class="px-3 py-1 text-xs font-medium rounded-full bg-green-100 dark:bg-green-900/30 text-green-600 dark:text-green-400">
                                                    <i class="fa-solid fa-check mr-1"></i> Hadir
                                                </span>
                                            @else
                                                <span class="px-3 py-1 text-xs font-medium rounded-full bg-red-100 dark:bg-red-900/30 text-red-600 dark:text-red-400">
                                                    <i class="fa-solid fa-times mr-1"></i> Tidak Hadir
                                                </span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="px-6 py-12 text-center text-gray-500 dark:text-gray-400">
                                            <i class="fa-solid fa-inbox text-4xl mb-3"></i>
                                            <p>Tidak ada data kehadiran</p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </main>
        </div>
    </div>
    
    <!-- Mobile Sidebar Overlay -->
    <div id="sidebarOverlay" class="fixed inset-0 bg-black/50 z-40 hidden md:hidden" onclick="closeSidebar()"></div>
    
</body>
<script src="{{ asset("js/students/detailSIswa.js") }}"> </script>
</html>
