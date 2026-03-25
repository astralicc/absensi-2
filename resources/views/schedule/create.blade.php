<!DOCTYPE html>
<html lang="id" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Jadwal - Absensi SMKN 12 Jakarta</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css"
        integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="icon" href="/logo.png">
    <link rel="stylesheet" href="{{ asset('css/teacher/tambahJadwal.css') }}">
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
                <span class="ml-2 font-bold text-sm text-gray-900 dark:text-white">Absensi SMKN 12
                    Jakarta</span>
            </div>

            <!-- Navigation -->
            <nav class="mt-6 px-4 space-y-2">
                <a href="{{ route('dashboard') }}"
                    class="flex items-center px-4 py-3 text-gray-600 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-800 rounded-lg transition">
                    <i class="fa-solid fa-house w-6 mr-3"></i>
                    <span class="font-medium">Dashboard</span>
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
                    class="flex items-center px-4 py-3 text-gray-700 dark:text-gray-300 bg-purple-50 dark:bg-purple-900/20 rounded-lg border-l-4 border-purple-500">
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
                    Tambah Jadwal Pelajaran
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
                            <p class="text-sm font-medium text-gray-900 dark:text-white">
                                {{ auth()->user()->name }}</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400">Guru</p>
                        </div>
                        <div
                            class="h-10 w-10 rounded-full bg-purple-500 flex items-center justify-center text-white font-bold">
                            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                        </div>
                    </div>
                </div>
            </header>

            <!-- Page Content -->
            <main class="flex-1 overflow-y-auto p-6">

                <!-- Back Button -->
                <div class="mb-6">
                    <a href="{{ route('schedule.manage') }}"
                        class="inline-flex items-center text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white transition">
                        <i class="fa-solid fa-arrow-left mr-2"></i>
                        Kembali ke Kelola Jadwal
                    </a>
                </div>

                <!-- Form Card -->
                <div
                    class="max-w-2xl mx-auto bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
                    <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                        <h2 class="text-xl font-bold text-gray-900 dark:text-white">Tambah Jadwal Baru</h2>
                        <p class="text-gray-600 dark:text-gray-400 mt-1">Isi form di bawah untuk menambahkan
                            jadwal pelajaran</p>
                    </div>

                    <form action="{{ route('schedule.store') }}" method="POST" class="p-6 space-y-6">
                        @csrf

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Day -->
                            <div>
                                <label for="day"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Hari <span class="text-red-500">*</span>
                                </label>
                                <select id="day" name="day" required
                                    class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('day') border-red-500 @enderror">
                                    <option value="">Pilih Hari</option>
                                    <option value="Senin" {{ old('day') === 'Senin' ? 'selected' : '' }}>Senin
                                    </option>
                                    <option value="Selasa" {{ old('day') === 'Selasa' ? 'selected' : '' }}>
                                        Selasa</option>
                                    <option value="Rabu" {{ old('day') === 'Rabu' ? 'selected' : '' }}>Rabu
                                    </option>
                                    <option value="Kamis" {{ old('day') === 'Kamis' ? 'selected' : '' }}>Kamis
                                    </option>
                                    <option value="Jumat" {{ old('day') === 'Jumat' ? 'selected' : '' }}>Jumat
                                    </option>
                                </select>
                                @error('day')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Class -->
                            <div>
                                <label for="class"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Kelas
                                </label>
                                <input type="text" id="class" name="class" value="{{ old('class') }}"
                                    class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('class') border-red-500 @enderror"
                                    placeholder="Contoh: 10 RPL 1">
                                @error('class')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Start Time -->
                            <div>
                                <label for="start_time"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Jam Mulai <span class="text-red-500">*</span>
                                </label>
                                <input type="time" id="start_time" name="start_time"
                                    value="{{ old('start_time') }}" required
                                    class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('start_time') border-red-500 @enderror">
                                @error('start_time')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- End Time -->
                            <div>
                                <label for="end_time"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Jam Selesai <span class="text-red-500">*</span>
                                </label>
                                <input type="time" id="end_time" name="end_time" value="{{ old('end_time') }}"
                                    required
                                    class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('end_time') border-red-500 @enderror">
                                @error('end_time')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Subject -->
                        <div>
                            <label for="subject"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Mata Pelajaran <span class="text-red-500">*</span>
                            </label>
                            <input type="text" id="subject" name="subject" value="{{ old('subject') }}"
                                required
                                class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('subject') border-red-500 @enderror"
                                placeholder="Masukkan nama mata pelajaran">
                            @error('subject')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Teacher -->
                        <div>
                            <label for="teacher"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Guru Pengajar <span class="text-red-500">*</span>
                            </label>
                            <input type="text" id="teacher" name="teacher"
                                value="{{ old('teacher', auth()->user()->name) }}" required
                                class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('teacher') border-red-500 @enderror"
                                placeholder="Masukkan nama guru">
                            @error('teacher')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Room -->
                        <div>
                            <label for="room"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Ruang Kelas <span class="text-red-500">*</span>
                            </label>
                            <input type="text" id="room" name="room" value="{{ old('room') }}"
                                required
                                class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('room') border-red-500 @enderror"
                                placeholder="Contoh: Lab Komputer 1">
                            @error('room')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Submit Buttons -->
                        <div
                            class="flex items-center justify-end gap-4 pt-4 border-t border-gray-200 dark:border-gray-700">
                            <a href="{{ route('schedule.manage') }}"
                                class="px-6 py-2 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                                Batal
                            </a>
                            <button type="submit"
                                class="px-6 py-2 bg-purple-600 hover:bg-purple-700 text-white font-medium rounded-lg transition">
                                Simpan Jadwal
                            </button>
</body>
<script src="{{ asset('js/main/tambahJadwal.js') }}"></script>

</html>
