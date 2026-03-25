<aside id="sidebar" class="fixed inset-y-0 left-0 z-50 w-64 max-w-[min(16rem,calc(100vw-1rem))] bg-white dark:bg-gray-900 border-r border-gray-200 dark:border-gray-700 transform -translate-x-full md:translate-x-0 transition-transform duration-300 ease-in-out flex flex-col shadow-xl md:shadow-none">
    <div class="flex items-center justify-center gap-2 h-16 px-3 border-b border-gray-200 dark:border-gray-700 shrink-0 min-w-0">
        <img src="/assets/logo.png" alt="Logo" class="h-8 w-auto shrink-0">
        <span class="font-bold text-xs sm:text-sm text-gray-900 dark:text-white truncate min-w-0">Admin Panel</span>
    </div>

    <nav class="mt-4 sm:mt-6 px-3 sm:px-4 space-y-2 overflow-y-auto flex-1 min-h-0 pb-2">
        <a href="{{ route('admin.dashboard') }}" class="flex items-center px-4 py-3 text-gray-600 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-800 rounded-lg transition {{ request()->routeIs('admin.dashboard') ? 'bg-red-50 dark:bg-red-900/20 text-red-700 dark:text-red-300 border-r-4 border-red-500' : '' }}">
            <i class="fa-solid fa-shield-halved w-6 mr-3"></i>
            <span class="font-medium">Dashboard</span>
        </a>

        <div class="relative">
            <button type="button" onclick="toggleDropdown('guruDropdown')" class="flex items-center w-full px-4 py-3 text-gray-600 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-800 rounded-lg transition">
                <i class="fa-solid fa-chalkboard-user w-6 mr-3"></i>
                <span class="flex-1 text-left">Kelola Guru</span>
                <i id="guruDropdownIcon" class="fa-solid fa-chevron-down text-xs transition-transform duration-200"></i>
            </button>
            <div id="guruDropdown" class="dropdown-menu ml-4 mt-1 space-y-1 {{ request()->routeIs('admin.guru.*') || request()->routeIs('admin.wali-kelas.*') ? 'open' : '' }}">
                <a href="{{ route('admin.wali-kelas.index') }}" class="flex items-center px-4 py-2 text-sm text-gray-600 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-800 rounded-lg transition {{ request()->routeIs('admin.wali-kelas.*') ? 'text-red-700 dark:text-red-300 bg-red-50 dark:bg-red-900/20 border-l-4 border-red-500 font-semibold' : '' }}">
                    <i class="fa-solid fa-users-rectangle w-5 mr-2"></i>
                    <span>Kelola Wali Kelas</span>
                </a>
                <a href="{{ route('admin.guru.index') }}" class="flex items-center px-4 py-2 text-sm text-gray-600 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-800 rounded-lg transition {{ request()->routeIs('admin.guru.*') ? 'text-red-700 dark:text-red-300 bg-red-50 dark:bg-red-900/20 border-l-4 border-red-500 font-semibold' : '' }}">
                    <i class="fa-solid fa-user-pen w-5 mr-2"></i>
                    <span>Input/Edit Data Guru</span>
                </a>
            </div>
        </div>

        <a href="{{ route('admin.rekap.index') }}" class="flex items-center px-4 py-3 text-gray-600 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-800 rounded-lg transition {{ request()->routeIs('admin.rekap.*') ? 'bg-red-50 dark:bg-red-900/20 text-red-700 dark:text-red-300 border-r-4 border-red-500' : '' }}">
            <i class="fa-solid fa-clipboard-list w-6 mr-3"></i>
            <span>Rekap Absensi</span>
        </a>

        <a href="{{ route('admin.students.index') }}" class="flex items-center px-4 py-3 text-gray-600 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-800 rounded-lg transition {{ request()->routeIs('admin.students.*') ? 'bg-red-50 dark:bg-red-900/20 text-red-700 dark:text-red-300 border-r-4 border-red-500' : '' }}">
            <i class="fa-solid fa-user-graduate w-6 mr-3"></i>
            <span>Kelola Data Siswa</span>
        </a>

        <a href="{{ route('admin.announcements.index') }}" class="flex items-center px-4 py-3 text-gray-600 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-800 rounded-lg transition {{ request()->routeIs('admin.announcements.*') ? 'bg-red-50 dark:bg-red-900/20 text-red-700 dark:text-red-300 border-r-4 border-red-500' : '' }}">
            <i class="fa-solid fa-bullhorn w-6 mr-3"></i>
            <span>Kelola Pengumuman</span>
        </a>

        <a href="{{ route('admin.settings.index') }}" class="flex items-center px-4 py-3 text-gray-600 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-800 rounded-lg transition {{ request()->routeIs('admin.settings.*') ? 'bg-red-50 text-red-700 dark:bg-red-900/20 dark:text-red-300 border-r-2 border-red-500' : '' }}">
            <i class="fa-solid fa-gear w-6 mr-3"></i>
            <span>Website Settings</span>
        </a>
    </nav>

    <div class="shrink-0 w-full p-3 sm:p-4 border-t border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900">
        <form action="{{ route('logout') }}" method="POST" class="w-full">
            @csrf
            <button type="submit" class="flex items-center w-full px-4 py-3 text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20 rounded-lg transition touch-manipulation text-sm sm:text-base">
                <i class="fa-solid fa-right-from-bracket w-6 mr-3 shrink-0"></i>
                <span class="font-medium">Logout</span>
            </button>
        </form>
    </div>
</aside>
