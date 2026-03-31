
<header class="glass sticky top-0 z-40 min-h-14 sm:h-16 border-b border-gray-200 dark:border-gray-700 px-3 sm:px-6 flex items-center gap-2 sm:gap-4 min-w-0 max-w-full">
    <!-- Mobile Menu Button -->
    <button type="button" id="mobileMenuBtn" class="md:hidden shrink-0 p-2.5 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-800 transition touch-manipulation" aria-label="Buka menu navigasi">
        <i class="fa-solid fa-bars text-xl"></i>
    </button>
    
    <!-- Page Title: visible on all breakpoints (truncated on narrow screens) -->
    <h1 class="flex-1 min-w-0 text-base sm:text-xl font-semibold text-gray-900 dark:text-white truncate leading-tight">
        {{ $title ?? 'Admin Dashboard' }}
    </h1>
    
    <!-- Right Actions -->
    <div class="flex items-center gap-2 sm:gap-4 shrink-0">
        <!-- Dark Mode Toggle -->
        <button type="button" onclick="toggleDark()" id="darkBtn" class="p-2 sm:p-2.5 rounded-lg bg-gray-200 dark:bg-gray-700 transition-all duration-300 ease-in-out transform hover:scale-110 active:scale-95 hover:shadow-lg dark:hover:shadow-gray-700/50 relative overflow-hidden touch-manipulation" aria-label="Ganti mode terang atau gelap">
            <span id="darkIcon" class="block transition-transform duration-500 ease-in-out text-base sm:text-lg leading-none">🌙</span>
        </button>
        
        <!-- User Profile -->
        <div class="flex items-center gap-2 sm:gap-3 sm:pl-4 sm:border-l border-gray-200 dark:border-gray-700">
            <div class="text-right hidden sm:block max-w-[10rem] lg:max-w-none">

                <p class="text-sm font-medium text-gray-900 dark:text-white truncate">{{ Auth::user()?->name ?? 'Admin' }}</p>
                <p class="text-xs text-gray-500 dark:text-gray-400">Administrator</p>

            </div>
            <div class="h-9 w-9 sm:h-10 sm:w-10 rounded-full bg-purple-500 flex items-center justify-center text-white font-bold text-sm shrink-0">
                {{ strtoupper(substr(Auth::user()?->name ?? 'Admin', 0, 1)) }}
            </div>
        </div>
    </div>
</header>

