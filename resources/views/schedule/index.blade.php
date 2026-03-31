<!DOCTYPE html>
<html lang="id" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jadwal Pelajaran - Absensi SMKN 12 Jakarta</title>
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
    <link rel="stylesheet" href="{{ asset('css/dashboard/riwayatAbsen.css') }}">
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
                <a href="{{ route('dashboard') }}" class="flex items-center px-4 py-3 text-gray-600 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-800 rounded-lg transition">
                    <i class="fa-solid fa-house w-6 mr-3"></i>
                    <span class="font-medium">Dashboard</span>
                </a>

                
                @if(Auth::guard('guru')->check())
                    <a href="{{ route('attendance.manage') }}" class="flex items-center px-4 py-3 text-gray-600 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-800 rounded-lg transition">
                        <i class="fa-solid fa-clipboard-list w-6 mr-3"></i>
                        <span>Kelola Absensi</span>
                    </a>
                    <a href="{{ route('students.index') }}" class="flex items-center px-4 py-3 text-gray-600 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-800 rounded-lg transition">
                        <i class="fa-solid fa-users w-6 mr-3"></i>
                        <span>Daftar Siswa</span>
                    </a>
                    <a href="{{ route('schedule.manage') }}" class="flex items-center px-4 py-3 text-gray-600 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-800 rounded-lg transition">
                        <i class="fa-solid fa-calendar-days w-6 mr-3"></i>
                        <span>Kelola Jadwal</span>
                    </a>
                    <a href="{{ route('reports.index') }}" class="flex items-center px-4 py-3 text-gray-600 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-800 rounded-lg transition">
                        <i class="fa-solid fa-chart-line w-6 mr-3"></i>
                        <span>Laporan</span>
                    </a>

                @elseif(Auth::guard('ortu')->check())
                    <a href="{{ route('children.data') }}" class="flex items-center px-4 py-3 text-gray-600 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-800 rounded-lg transition">
                        <i class="fa-solid fa-child w-6 mr-3"></i>
                        <span>Data Anak</span>
                    </a>
                    <a href="{{ route('children.attendance') }}" class="flex items-center px-4 py-3 text-gray-600 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-800 rounded-lg transition">
                        <i class="fa-solid fa-calendar-check w-6 mr-3"></i>
                        <span>Absensi Anak</span>
                    </a>

                @else
                    {{-- Default menu for Murid (Siswa) and users with null/undefined role --}}
                    <a href="{{ route('attendance.history') }}" class="flex items-center px-4 py-3 text-gray-600 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-800 rounded-lg transition">
                        <i class="fa-solid fa-calendar-check w-6 mr-3"></i>
                        <span>Riwayat Absensi</span>
                    </a>
                    <a href="{{ route('schedule.index') }}" class="flex items-center px-4 py-3 text-gray-700 dark:text-gray-300 bg-purple-50 dark:bg-purple-900/20 rounded-lg border-l-4 border-purple-500">
                        <i class="fa-solid fa-book w-6 mr-3"></i>
                        <span>Jadwal Pelajaran</span>
                    </a>
                    <a href="{{ route('attendance.report') }}" class="flex items-center px-4 py-3 text-gray-600 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-800 rounded-lg transition">
                        <i class="fa-solid fa-triangle-exclamation w-6 mr-3"></i>
                        <span>Laporkan Absensi</span>
                    </a>
                @endif
                
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
                <h1 class="text-xl font-semibold text-gray-900 dark:text-white hidden md:block">
                    Jadwal Pelajaran
                </h1>
                
                <!-- Right Actions -->
                <div class="flex items-center gap-4">
                    <!-- Dark Mode Toggle -->
                    <button onclick="toggleDark()" id="darkBtn" class="p-2 rounded-lg bg-gray-200 dark:bg-gray-700 transition-all duration-300 ease-in-out transform hover:scale-110 active:scale-95 hover:shadow-lg dark:hover:shadow-gray-700/50 relative overflow-hidden">
                        <span id="darkIcon" class="block transition-transform duration-500 ease-in-out">🌙</span>
                    </button>
                    
                    <!-- User Profile -->
                    <div class="flex items-center gap-3 pl-4 border-l border-gray-200 dark:border-gray-700">
                        <div class="text-right hidden sm:block">
                            <p class="text-sm font-medium text-gray-900 dark:text-white">{{ $user->name }}</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400">Siswa</p>
                        </div>
                        <div class="h-10 w-10 rounded-full bg-purple-500 flex items-center justify-center text-white font-bold">
                            {{ strtoupper(substr($user->name, 0, 1)) }}
                        </div>
                    </div>
                </div>
            </header>
            
            <!-- Page Content -->
            <main class="flex-1 overflow-y-auto p-6">
                
                <!-- Today's Schedule Highlight -->
                <div class="mb-8 p-6 bg-gradient-to-r from-purple-500 to-purple-600 rounded-2xl shadow-lg text-white">
                    <div class="flex items-center justify-between">
                        <div>
                            <h2 class="text-2xl font-bold mb-2">Jadwal Hari {{ $today }}</h2>
                            <p class="text-purple-100">Berikut adalah jadwal pelajaran untuk hari ini. Jangan lupa untuk hadir tepat waktu!</p>
                        </div>
                        <div class="text-right">
                            <div class="text-4xl font-bold">{{ count($schedule[$today] ?? []) }}</div>
                            <div class="text-purple-200">Pelajaran</div>
                        </div>
                    </div>
                </div>

                <!-- Weekly Schedule -->
                <div class="grid grid-cols-1 lg:grid-cols-2 xl:grid-cols-3 gap-6">
                    @foreach($schedule as $day => $lessons)
                        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden {{ $day === $today ? 'ring-2 ring-purple-500' : '' }}">
                            <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 {{ $day === $today ? 'bg-purple-50 dark:bg-purple-900/20' : 'bg-gray-50 dark:bg-gray-700/50' }}">
                                <div class="flex items-center justify-between">
                                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white {{ $day === $today ? 'text-purple-700 dark:text-purple-400' : '' }}">
                                        {{ $day }}
                                    </h3>
                                    @if($day === $today)
                                        <span class="px-3 py-1 text-xs font-medium bg-purple-100 dark:bg-purple-900/30 text-purple-700 dark:text-purple-400 rounded-full">
                                            Hari Ini
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="p-4">
                                <div class="space-y-3">
                                    @foreach($lessons as $lesson)
                                        <div class="flex items-start gap-3 p-3 {{ $lesson['subject'] === 'Istirahat' ? 'bg-yellow-50 dark:bg-yellow-900/10 rounded-lg' : 'bg-gray-50 dark:bg-gray-700/30 rounded-lg' }}">
                                            <div class="shrink-0 w-12 text-center">
                                                <div class="text-xs font-medium text-gray-500 dark:text-gray-400">{{ explode(' - ', $lesson['time'])[0] }}</div>
                                            </div>
                                            <div class="flex-1 min-w-0">
                                                <div class="flex items-center justify-between">
                                                    <p class="text-sm font-medium text-gray-900 dark:text-white truncate">
                                                        {{ $lesson['subject'] }}
                                                    </p>
                                                </div>
                                                @if($lesson['subject'] !== 'Istirahat')
                                                    <div class="mt-1 flex items-center text-xs text-gray-500 dark:text-gray-400">
                                                        <i class="fa-solid fa-user-tie mr-1"></i>
                                                        {{ $lesson['teacher'] }}
                                                        <span class="mx-2">•</span>
                                                        <i class="fa-solid fa-door-open mr-1"></i>
                                                        {{ $lesson['room'] }}
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

            </main>
        </div>
    </div>
    
    <!-- Mobile Sidebar Overlay -->
    <div id="sidebarOverlay" class="fixed inset-0 bg-black/50 z-40 hidden md:hidden" onclick="closeSidebar()"></div>
    
    <script src="{{ asset('js/dashboard.js') }}"></script>
    <script src="{{ asset('js/schedule/kelolaJadwal.js') }}"></script>
</body>
</html>
