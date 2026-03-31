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
                    class="flex items-center px-4 py-3 text-gray-700 dark:text-gray-300 bg-green-50 dark:bg-green-900/20 border-l-4 border-green-500 rounded-lg">
                    <i class="fa-solid fa-house w-6 mr-3"></i>
                    <span class="font-medium">Dashboard</span>
                </a>

                <a href="{{ route('wali-kelas.index') }}" class="flex items-center px-4 py-3 text-green-700 dark:text-green-300 bg-green-50 dark:bg-green-900/20 border-l-4 border-green-500 font-medium rounded-lg">
                    <i class="fa-solid fa-users-rectangle w-6 mr-3"></i>
                    <span>Dashboard Wali Kelas</span>
                </a>

                <a href="{{ route('students.index') }}" class="flex items-center px-4 py-3 text-gray-600 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-800 rounded-lg transition">
                    <i class="fa-solid fa-users w-6 mr-3"></i>
                    <span>Daftar Siswa Kelas</span>
                </a>

                <a href="{{ route('attendance.manage') }}" class="flex items-center px-4 py-3 text-gray-600 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-800 rounded-lg transition">
                    <i class="fa-solid fa-clipboard-list w-6 mr-3"></i>
                    <span>Kelola Absensi</span>
                </a>

                <a href="{{ route('reports.index') }}?kelas={{ auth()->user()->kelas_wali }}" class="flex items-center px-4 py-3 text-gray-600 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-800 rounded-lg transition">
                    <i class="fa-solid fa-chart-line w-6 mr-3"></i>
                    <span>Laporan Kelas</span>
                </a>

                <a href="{{ route('announcements.index') }}" class="flex items-center px-4 py-3 text-gray-600 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-800 rounded-lg transition">
                    <i class="fa-solid fa-bullhorn w-6 mr-3"></i>
                    <span>Pengumuman</span>
                    @if (isset($unreadCount) && $unreadCount > 0)
                        <span class="ml-auto bg-red-500 text-white text-xs font-bold px-2 py-1 rounded-full">{{ $unreadCount }}</span>
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

