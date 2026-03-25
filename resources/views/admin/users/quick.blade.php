<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Pengguna - Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="icon" href="/logo.png">
    <link rel="stylesheet" href="{{ asset('css/min/kelolaWali.css') }}">
    <link rel="stylesheet" href="{{ asset('css/min/kelolaSiswa.css') }}">
</head>
<body class="text-gray-800 dark:text-gray-200 bg-gray-100 dark:bg-gray-950 min-h-screen">
    <div class="flex h-screen overflow-hidden">
        @include('admin.layouts.sidebar')

        <div class="flex-1 flex flex-col md:ml-64 min-w-0">
            @include('admin.layouts.header', ['title' => 'Tambah Pengguna'])

            <main class="flex-1 min-h-0 overflow-y-auto p-4 sm:p-6">
                <div class="relative overflow-hidden rounded-2xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 mb-6 shadow-sm">
                    <div class="absolute inset-0 bg-gradient-to-br from-indigo-500/10 via-violet-500/5 to-transparent pointer-events-none"></div>
                    <div class="relative p-5 sm:p-8">
                        <p class="text-xs font-semibold uppercase tracking-wider text-indigo-600 dark:text-indigo-400">Pengguna baru</p>
                        <h2 class="text-xl sm:text-2xl font-bold text-gray-900 dark:text-white mt-1">Tambah pengguna</h2>
                        <p class="text-gray-600 dark:text-gray-400 mt-2 text-sm sm:text-base max-w-2xl break-words">Pilih jenis pengguna. Data disimpan ke tabel <code class="text-xs bg-gray-200 dark:bg-gray-700 px-1.5 py-0.5 rounded break-all">users</code> sesuai peran.</p>
                    </div>
                </div>

                @if(session('success'))
                    <div class="mb-6 p-4 bg-green-100 dark:bg-green-900/30 border border-green-200 dark:border-green-800 rounded-xl text-green-800 dark:text-green-200 text-sm">
                        {{ session('success') }}
                    </div>
                @endif

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6 max-w-5xl w-full mx-auto">
                    <a href="{{ route('admin.students.create') }}" class="group block rounded-2xl border-2 border-blue-200 dark:border-blue-800 bg-white dark:bg-gray-800 p-5 sm:p-6 shadow-sm hover:shadow-md hover:border-blue-400 transition min-h-[160px] touch-manipulation">
                        <div class="h-12 w-12 rounded-xl bg-blue-100 dark:bg-blue-900/40 text-blue-600 dark:text-blue-300 flex items-center justify-center text-xl mb-4">
                            <i class="fa-solid fa-user-graduate"></i>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white group-hover:text-blue-600 dark:group-hover:text-blue-400">Murid</h3>
                        <p class="text-sm text-gray-500 dark:text-gray-400 mt-2">Tambah akun siswa (role murid).</p>
                    </a>

                    <a href="{{ route('admin.guru.create') }}" class="group block rounded-2xl border-2 border-indigo-200 dark:border-indigo-800 bg-white dark:bg-gray-800 p-5 sm:p-6 shadow-sm hover:shadow-md hover:border-indigo-400 transition min-h-[160px] touch-manipulation">
                        <div class="h-12 w-12 rounded-xl bg-indigo-100 dark:bg-indigo-900/40 text-indigo-600 dark:text-indigo-300 flex items-center justify-center text-xl mb-4">
                            <i class="fa-solid fa-chalkboard-user"></i>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white group-hover:text-indigo-600 dark:group-hover:text-indigo-400">Guru</h3>
                        <p class="text-sm text-gray-500 dark:text-gray-400 mt-2">Tambah akun guru (role guru).</p>
                    </a>

                    <a href="{{ route('admin.parents.create') }}" class="group block rounded-2xl border-2 border-orange-200 dark:border-orange-800 bg-white dark:bg-gray-800 p-5 sm:p-6 shadow-sm hover:shadow-md hover:border-orange-400 transition min-h-[160px] touch-manipulation">
                        <div class="h-12 w-12 rounded-xl bg-orange-100 dark:bg-orange-900/40 text-orange-600 dark:text-orange-300 flex items-center justify-center text-xl mb-4">
                            <i class="fa-solid fa-people-roof"></i>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white group-hover:text-orange-600 dark:group-hover:text-orange-400">Orang tua</h3>
                        <p class="text-sm text-gray-500 dark:text-gray-400 mt-2">Tambah akun orang tua (role orang_tua).</p>
                    </a>
                </div>

                <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center mt-8 text-sm text-gray-600 dark:text-gray-400 hover:text-red-600 dark:hover:text-red-400">
                    <i class="fa-solid fa-arrow-left mr-2"></i> Kembali ke dashboard
                </a>
            </main>
        </div>
    </div>

    <div id="sidebarOverlay" class="fixed inset-0 bg-black/50 z-40 hidden md:hidden" onclick="closeSidebar()"></div>
    <script src="{{ asset('js/min/kelolaWali.js') }}"></script>
</body>
</html>
