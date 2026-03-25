<!DOCTYPE html>
<html lang="id" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kalender Absensi - {{ $selectedChild->name ?? 'Anak' }} - Absensi SMKN 12 Jakarta</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css"
        integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="icon" href="/logo.png">
    <link rel="stylesheet" href="{{ asset('css/parents/kalenderAbsen.css') }}">
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
                <h1 class="text-xl font-semibold text-gray-900 dark:text-white">Kalender Absensi</h1>

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

                <!-- Back Button -->
                <a href="{{ route('children.attendance', ['child_id' => $filters['child_id'], 'month' => $filters['month'], 'year' => $filters['year']]) }}"
                    class="inline-flex items-center gap-2 text-gray-500 hover:text-gray-700 dark:hover:text-gray-300 mb-6 transition">
                    <i class="fa-solid fa-arrow-left"></i> Kembali ke Absensi
                </a>

                @if ($selectedChild)
                    <!-- Filter Card -->
                    <div
                        class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-200 dark:border-gray-700 p-6 mb-6">
                        <form action="{{ route('children.calendar') }}" method="GET"
                            class="flex flex-wrap gap-4 items-center">
                            @if ($children->count() > 1)
                                <div class="relative">
                                    <select name="child_id"
                                        class="w-full px-4 py-3 pr-10 rounded-xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 focus:ring-2 focus:ring-blue-500 outline-none transition appearance-none">
                                        @foreach ($children as $child)
                                            <option value="{{ $child->id }}"
                                                {{ $filters['child_id'] == $child->id ? 'selected' : '' }}>
                                                {{ $child->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <i
                                        class="fa-solid fa-chevron-down absolute right-2 top-1/2 -translate-y-1/2 text-gray-500 dark:text-white text-xs pointer-events-none"></i>
                                </div>
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
                                <i class="fa-solid fa-filter mr-2"></i>Tampilkan
                            </button>
                            <div class="ml-auto">
                                <h2 class="text-xl font-bold text-gray-900 dark:text-white">{{ $selectedChild->name }}
                                </h2>
                                <p class="text-sm text-gray-500 dark:text-gray-400">
                                    {{ \Carbon\Carbon::create()->month((int) $filters['month'])->format('F') }}
                                    {{ $filters['year'] }}</p>
                            </div>

                        </form>
                    </div>

                    <!-- Calendar Card -->
                    <div
                        class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
                        <div class="p-6">
                            <!-- Calendar Grid -->
                            <div class="grid grid-cols-7 gap-2 mb-2">
                                <div class="text-center py-2 font-semibold text-gray-700 dark:text-gray-300">Sen</div>
                                <div class="text-center py-2 font-semibold text-gray-700 dark:text-gray-300">Sel</div>
                                <div class="text-center py-2 font-semibold text-gray-700 dark:text-gray-300">Rab</div>
                                <div class="text-center py-2 font-semibold text-gray-700 dark:text-gray-300">Kam</div>
                                <div class="text-center py-2 font-semibold text-gray-700 dark:text-gray-300">Jum</div>
                                <div class="text-center py-2 font-semibold text-gray-700 dark:text-gray-300">Sab</div>
                                <div class="text-center py-2 font-semibold text-red-500">Min</div>
                            </div>

                            <div class="grid grid-cols-7 gap-2">
                                @php
                                    $firstDay = $calendar['firstDayOfMonth'];
                                    $daysInMonth = $calendar['daysInMonth'];
                                    $dayCount = 1;
                                @endphp

                                {{-- Empty cells for days before the 1st --}}
                                @for ($i = 1; $i < $firstDay; $i++)
                                    <div class="aspect-square"></div>
                                @endfor

                                {{-- Days of the month --}}
                                @for ($day = 1; $day <= $daysInMonth; $day++)
                                    @php
                                        $dateKey = sprintf('%04d-%02d-%02d', $filters['year'], $filters['month'], $day);
                                        $attendance = $attendances->get($dateKey);
                                        $isToday = $dateKey == now()->format('Y-m-d');
                                        $isSunday = ($firstDay + $day - 1) % 7 == 0;
                                    @endphp

                                    <div
                                        class="aspect-square p-2 rounded-xl border {{ $isToday ? 'border-blue-500 ring-2 ring-blue-500/20' : 'border-gray-200 dark:border-gray-700' }} {{ $isSunday ? 'bg-red-50 dark:bg-red-900/10' : 'bg-gray-50 dark:bg-gray-700/30' }} flex flex-col items-center justify-center relative">
                                        <span
                                            class="text-sm font-medium {{ $isSunday ? 'text-red-500' : 'text-gray-700 dark:text-gray-300' }}">{{ $day }}</span>

                                        @if ($attendance)
                                            @if ($attendance->check_in)
                                                <div class="mt-1 w-6 h-6 rounded-full bg-green-500 flex items-center justify-center"
                                                    title="Hadir - {{ $attendance->check_in->format('H:i') }}">
                                                    <i class="fa-solid fa-check text-white text-xs"></i>
                                                </div>
                                                @if ($attendance->check_in->format('H:i') > '07:30')
                                                    <div class="absolute -top-1 -right-1 w-3 h-3 bg-yellow-500 rounded-full"
                                                        title="Terlambat"></div>
                                                @endif
                                            @else
                                                <div class="mt-1 w-6 h-6 rounded-full bg-red-500 flex items-center justify-center"
                                                    title="Tidak Hadir">
                                                    <i class="fa-solid fa-times text-white text-xs"></i>
                                                </div>
                                            @endif
                                        @else
                                            <div class="mt-1 w-6 h-6 rounded-full bg-gray-300 dark:bg-gray-600 flex items-center justify-center"
                                                title="Belum ada data">
                                                <i class="fa-solid fa-minus text-white text-xs"></i>
                                            </div>
                                        @endif
                                    </div>
                                @endfor
                            </div>

                            <!-- Legend -->
                            <div class="mt-6 flex flex-wrap gap-4 justify-center">
                                <div class="flex items-center gap-2">
                                    <div class="w-4 h-4 rounded-full bg-green-500"></div>
                                    <span class="text-sm text-gray-600 dark:text-gray-400">Hadir Tepat Waktu</span>
                                </div>
                                <div class="flex items-center gap-2">
                                    <div class="w-4 h-4 rounded-full bg-green-500 relative">
                                        <div class="absolute -top-1 -right-1 w-2 h-2 bg-yellow-500 rounded-full"></div>
                                    </div>
                                    <span class="text-sm text-gray-600 dark:text-gray-400">Hadir Terlambat</span>
                                </div>
                                <div class="flex items-center gap-2">
                                    <div class="w-4 h-4 rounded-full bg-red-500"></div>
                                    <span class="text-sm text-gray-600 dark:text-gray-400">Tidak Hadir</span>
                                </div>
                                <div class="flex items-center gap-2">
                                    <div class="w-4 h-4 rounded-full bg-gray-300 dark:bg-gray-600"></div>
                                    <span class="text-sm text-gray-600 dark:text-gray-400">Belum Ada Data</span>
                                </div>
                            </div>
                        </div>
                    </div>
                @else
                    <div
                        class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-200 dark:border-gray-700 p-12 text-center">
                        <div
                            class="h-20 w-20 mx-auto mb-4 rounded-full bg-gray-100 dark:bg-gray-700 flex items-center justify-center">
                            <i class="fa-solid fa-child text-3xl text-gray-400"></i>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">Anak Tidak Ditemukan</h3>
                        <p class="text-gray-500 dark:text-gray-400">Silakan pilih anak dari daftar.</p>
                    </div>
                @endif
            </main>
        </div>
    </div>

    <!-- Mobile Sidebar Overlay -->
    <div id="sidebarOverlay" class="fixed inset-0 bg-black/50 z-40 hidden md:hidden" onclick="closeSidebar()"></div>

</body>
<script src="{{ asset('js/schedule/calenderAbsen.js') }}"></script>

</html>
