<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Wali Kelas - Absensi SMKN 12 Jakarta</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css">
    <link rel="icon" href="/logo.png">
    <link rel="stylesheet" href="{{ asset('css/dashboard/style.css') }}">
    <style>
        body { --nav-hover-color: #22c55e; }
    </style>
</head>
<body class="text-gray-800 dark:text-gray-200 bg-gray-100 dark:bg-gray-950 min-h-screen">

<div class="flex h-screen overflow-hidden">
    <!-- Sidebar (reuse dashboard sidebar logic) -->
@include('dashboard.sidebar-wali', ['unreadCount' => $unreadCount])



    <!-- Main Content -->
    <div class="flex-1 flex flex-col md:ml-64">
        <!-- Header -->
        <header class="sticky top-0 z-40 h-16 border-b border-gray-200 dark:border-gray-700 px-6 flex items-center justify-between bg-white dark:bg-gray-900">
            <button id="mobileMenuBtn" class="md:hidden p-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-800">
                <i class="fa-solid fa-bars text-xl"></i>
            </button>
            <h1 class="text-xl font-semibold text-gray-900 dark:text-white hidden md:block">
                Dashboard Wali Kelas {{ $user->kelas_wali }} {{ $user->jurusan_wali ?? '' }}
            </h1>
            <!-- Profile dropdown (simplified) -->
            <div class="flex items-center gap-3">
                <button onclick="toggleDark()" id="darkBtn" class="p-2 rounded-lg bg-gray-200 dark:bg-gray-700 hover:scale-110">
                    <span id="darkIcon">🌙</span>
                </button>
                <div class="flex items-center gap-2 p-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-800">
                    <div class="h-8 w-8 bg-green-500 rounded-full flex items-center justify-center text-white font-bold text-sm">
                        {{ strtoupper(substr($user->name, 0, 1)) }}
                    </div>
                    <span class="font-medium text-sm hidden sm:block">{{ $user->name }}</span>
                </div>
            </div>
        </header>

        <main class="flex-1 overflow-y-auto p-6">
            <!-- Welcome Banner -->
            <div class="bg-gradient-to-r from-green-500 to-emerald-600 text-white p-8 rounded-2xl mb-8 shadow-xl">
                <div class="flex items-center gap-4">
                    <i class="fa-solid fa-users-rectangle text-4xl"></i>
                    <div>
                        <h1 class="text-3xl font-bold mb-2">Selamat Datang Wali Kelas!</h1>
                        <p class="text-xl opacity-90">Kelas {{ $user->kelas_wali }} {{ $user->jurusan_wali ?? '' }} | Total {{ $totalStudents }} siswa</p>
                    </div>
                </div>
            </div>

            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-sm border">
                    <div class="flex items-center justify-between mb-4">
                        <div class="p-3 bg-green-100 dark:bg-green-900/30 rounded-xl">
                            <i class="fa-solid fa-users text-green-600 dark:text-green-400 text-2xl"></i>
                        </div>
                        <span class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Siswa</span>
                    </div>
                    <h2 class="text-3xl font-bold text-gray-900 dark:text-white">{{ $totalStudents }}</h2>
                </div>

                <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-sm border">
                    <div class="flex items-center justify-between mb-4">
                        <div class="p-3 bg-emerald-100 dark:bg-emerald-900/30 rounded-xl">
                            <i class="fa-solid fa-check-circle text-emerald-600 dark:text-emerald-400 text-2xl"></i>
                        </div>
                        <span class="text-sm font-medium text-gray-500 dark:text-gray-400">Hadir Hari Ini</span>
                    </div>
                    <h2 class="text-3xl font-bold text-gray-900 dark:text-white">{{ $presentToday }}</h2>
                </div>

                <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-sm border">
                    <div class="flex items-center justify-between mb-4">
                        <div class="p-3 bg-red-100 dark:bg-red-900/30 rounded-xl">
                            <i class="fa-solid fa-times-circle text-red-600 dark:text-red-400 text-2xl"></i>
                        </div>
                        <span class="text-sm font-medium text-gray-500 dark:text-gray-400">Absen Hari Ini</span>
                    </div>
                    <h2 class="text-3xl font-bold text-gray-900 dark:text-white">{{ $absentToday }}</h2>
                </div>

                <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-sm border">
                    <div class="flex items-center justify-between mb-4">
                        <div class="p-3 bg-blue-100 dark:bg-blue-900/30 rounded-xl">
                            <i class="fa-solid fa-chart-simple text-blue-600 dark:text-blue-400 text-2xl"></i>
                        </div>
                        <span class="text-sm font-medium text-gray-500 dark:text-gray-400">Tingkat Kehadiran</span>
                    </div>
                    <h2 class="text-3xl font-bold text-gray-900 dark:text-white">{{ number_format(($totalStudents > 0 ? ($presentToday / $totalStudents) * 100 : 0), 1) }}%</h2>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
                <a href="{{ route('attendance.manage') }}" class="group bg-gradient-to-br from-green-500 to-teal-600 hover:from-green-600 hover:to-teal-700 text-white p-8 rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 hover:-translate-y-2 text-center">
                    <i class="fa-solid fa-clipboard-check text-3xl mb-4 block mx-auto"></i>
                    <h3 class="font-bold text-xl mb-2">Kelola Absensi</h3>
                    <p class="opacity-90">Tandai kehadiran siswa kelas Anda hari ini</p>
                </a>
                    <a href="{{ route('students.index') }}" class="group bg-gradient-to-br from-blue-500 to-indigo-600 hover:from-blue-600 hover:to-indigo-700 text-white p-8 rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 hover:-translate-y-2 text-center">

                    <i class="fa-solid fa-users text-3xl mb-4 block mx-auto"></i>
                    <h3 class="font-bold text-xl mb-2">Daftar Siswa</h3>
                    <p class="opacity-90">Lihat detail dan statistik semua siswa kelas</p>
                </a>
                <a href="{{ route('reports.index') }}?kelas={{ $user->kelas_wali }}&jurusan={{ $user->jurusan_wali ?? '' }}" class="group bg-gradient-to-br from-purple-500 to-violet-600 hover:from-purple-600 hover:to-violet-700 text-white p-8 rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 hover:-translate-y-2 text-center">
                    <i class="fa-solid fa-file-export text-3xl mb-4 block mx-auto"></i>
                    <h3 class="font-bold text-xl mb-2">Laporan Kelas</h3>
                    <p class="opacity-90">Download laporan lengkap kehadiran kelas</p>
                </a>
            </div>

            <!-- Today's Absent Students -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border p-6">
                <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-6 flex items-center gap-3">
                    <i class="fa-solid fa-clock text-orange-500"></i>
                    Siswa Absen Hari Ini ({{ $absentToday }})
                </h3>
                <div class="space-y-3">
                    @php $absentStudents = $todayAttendances->whereNull('check_in')->values(); @endphp
                    @forelse ($absentStudents as $attendance)
                        <div class="flex items-center justify-between p-4 bg-orange-50 dark:bg-orange-900/20 border border-orange-200 dark:border-orange-800 rounded-xl">
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 bg-orange-100 dark:bg-orange-900/30 rounded-full flex items-center justify-center">
                                    <i class="fa-solid fa-user-slash text-orange-600 dark:text-orange-400 text-lg"></i>
                                </div>
                                <div>
                                    <p class="font-semibold text-gray-900 dark:text-white">{{ $attendance->user->name }}</p>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">{{ $attendance->user->class }} {{ $attendance->user->jurusan ?? '' }}</p>
                                </div>
                            </div>
                            <span class="px-4 py-2 bg-orange-100 dark:bg-orange-900/50 text-orange-800 dark:text-orange-200 font-semibold rounded-lg text-sm">
                                Absen
                            </span>
                        </div>
                    @empty
                        <div class="text-center py-12">
                            <i class="fa-solid fa-check-double text-green-500 text-4xl mb-4 block"></i>
                            <h4 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">Semua Siswa Hadir!</h4>
                            <p class="text-gray-500 dark:text-gray-400">Hari ini kehadiran kelas Anda 100% ✅</p>
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Recent Students List -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border mt-8 p-6">
                <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-6">Siswa Kelas Anda</h3>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead>
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 dark:text-gray-300 uppercase tracking-wider">Nama</th>
                                <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 dark:text-gray-300 uppercase tracking-wider">NIS</th>
                                <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 dark:text-gray-300 uppercase tracking-wider">Kehadiran Hari Ini</th>
                                <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 dark:text-gray-300 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                            @forelse ($students->take(10) as $student)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="h-10 w-10 bg-green-100 dark:bg-green-900/30 rounded-full flex items-center justify-center text-green-600 dark:text-green-400 font-semibold text-sm">
                                                {{ strtoupper(substr($student->name, 0, 1)) }}
                                            </div>
                                            <div class="ml-4">
                                                <div class="text-sm font-medium text-gray-900 dark:text-white">{{ $student->name }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">{{ $student->id }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @php $todayAtt = $todayAttendances->firstWhere('user_id', $student->id); @endphp
                                        <span class="px-3 py-1 rounded-full text-xs font-medium {{ $todayAtt && $todayAtt->check_in ? 'bg-green-100 dark:bg-green-900/30 text-green-800 dark:text-green-200' : 'bg-red-100 dark:bg-red-900/30 text-red-800 dark:text-red-200' }}">
                                            {{ $todayAtt && $todayAtt->check_in ? 'Hadir' : 'Absen' }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm">
                                        <a href="{{ route('students.show', $student->id) }}" class="text-green-600 hover:text-green-900 font-medium">Detail</a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-12 text-center text-gray-500 dark:text-gray-400">
                                        <i class="fa-solid fa-users text-4xl mb-4 opacity-50"></i>
                                        <p>Belum ada data siswa</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="mt-6 pt-6 border-t border-gray-200 dark:border-gray-700">
                    <a href="{{ route('wali-kelas.students') }}" class="text-green-600 hover:text-green-900 font-medium inline-flex items-center gap-2">
                        <i class="fa-solid fa-arrow-right"></i>
                        Daftar Siswa Kelas ({{ $totalStudents }})

                    </a>
                </div>
            </div>
        </main>
    </div>
</div>

<!-- Overlay -->
<div id="sidebarOverlay" class="fixed inset-0 bg-black/50 z-40 hidden md:hidden" onclick="closeSidebar()"></div>

<script>
    // Mobile sidebar toggle
    document.getElementById('mobileMenuBtn').onclick = () => {
        document.getElementById('sidebar').classList.toggle('-translate-x-full');
        document.getElementById('sidebarOverlay').classList.toggle('hidden');
    };

    function closeSidebar() {
        document.getElementById('sidebar').classList.add('-translate-x-full');
        document.getElementById('sidebarOverlay').classList.add('hidden');
    }

    // Dark mode toggle
    function toggleDark() {
        document.documentElement.classList.toggle('dark');
        localStorage.theme = document.documentElement.classList.contains('dark') ? 'dark' : 'light';
    }

    // Load theme
    if (localStorage.theme === 'dark' || (!localStorage.theme && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
        document.documentElement.classList.add('dark');
    }
</script>

</body>
</html>
