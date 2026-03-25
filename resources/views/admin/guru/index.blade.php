<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Data Guru - Absensi SMKN 12 Jakarta</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css">
    <link rel="icon" href="/logo.png">
    <link rel="stylesheet" href="{{ asset('css/min/kelolaSiswa.css') }}">
    <link rel="stylesheet" href="{{ asset('css/min/kelolaWali.css') }}">
</head>
<body class="text-gray-800 dark:text-gray-200 bg-gray-100 dark:bg-gray-950 min-h-screen">
    <div class="flex h-screen overflow-hidden">
        @include('admin.layouts.sidebar')

        <div class="flex-1 flex flex-col md:ml-64 min-w-0">
            @include('admin.layouts.header', ['title' => 'Kelola Data Guru'])

            <main class="flex-1 min-h-0 overflow-y-auto p-4 sm:p-6">
                <div class="relative overflow-hidden rounded-2xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 mb-6 shadow-sm">
                    <div class="absolute inset-0 bg-gradient-to-br from-indigo-500/10 via-violet-500/5 to-transparent pointer-events-none"></div>
                    <div class="relative p-6 sm:p-8 flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6">
                        <div>
                            <p class="text-xs font-semibold uppercase tracking-wider text-indigo-600 dark:text-indigo-400">Manajemen guru</p>
                            <h1 class="text-2xl sm:text-3xl font-bold text-gray-900 dark:text-white mt-1">Kelola Data Guru</h1>
                            <p class="text-gray-600 dark:text-gray-400 mt-2 max-w-xl">Tambah, ubah, atau hapus akun guru. Data tersimpan di basis data pengguna.</p>
                        </div>
                        <a href="{{ route('admin.guru.create') }}" class="inline-flex w-full sm:w-auto items-center justify-center gap-2 px-6 py-3 min-h-[44px] rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white font-semibold shadow-lg shadow-indigo-500/25 transition shrink-0 touch-manipulation">
                            <i class="fa-solid fa-plus"></i>
                            Tambah Guru
                        </a>
                    </div>
                </div>

                @if(session('success'))
                    <div class="bg-green-100 dark:bg-green-900/30 border border-green-400 dark:border-green-700 text-green-800 dark:text-green-200 px-4 py-3 rounded-xl mb-6 text-sm">{{ session('success') }}</div>
                @endif
                @if(session('error'))
                    <div class="bg-red-100 dark:bg-red-900/30 border border-red-400 dark:border-red-700 text-red-800 dark:text-red-200 px-4 py-3 rounded-xl mb-6 text-sm">{{ session('error') }}</div>
                @endif

                <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-200 dark:border-gray-700 p-4 sm:p-6 mb-6 shadow-sm">
                    <form method="GET" action="{{ route('admin.guru.index') }}" class="flex flex-col sm:flex-row gap-4 items-stretch sm:items-end">
                        <div class="flex-1 min-w-0">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Cari</label>
                            <div class="relative">
                                <input type="text" name="search" value="{{ $search ?? '' }}" placeholder="Nama, email, telepon…"
                                    class="w-full px-4 py-2.5 pr-11 border border-gray-300 dark:border-gray-600 rounded-xl dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-indigo-500">
                                <i class="fa-solid fa-magnifying-glass absolute right-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
                            </div>
                        </div>
                        <button type="submit" class="px-6 py-2.5 rounded-xl bg-indigo-600 text-white font-medium hover:bg-indigo-700 transition">Cari</button>
                        <a href="{{ route('admin.guru.index') }}" class="px-6 py-2.5 rounded-xl border border-gray-300 dark:border-gray-600 text-center font-medium hover:bg-gray-50 dark:hover:bg-gray-700 transition">Reset</a>
                    </form>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-8">
                    <div class="rounded-2xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 p-5 shadow-sm">
                        <div class="flex items-center gap-3">
                            <span class="flex h-11 w-11 items-center justify-center rounded-xl bg-indigo-100 dark:bg-indigo-900/40 text-indigo-600 dark:text-indigo-300"><i class="fa-solid fa-chalkboard-user"></i></span>
                            <div>
                                <p class="text-xs text-gray-500 dark:text-gray-400 uppercase tracking-wide">Total guru</p>
                                <p class="text-2xl font-bold text-gray-900 dark:text-white tabular-nums">{{ $totalGurus }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="rounded-2xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 p-5 shadow-sm">
                        <div class="flex items-center gap-3">
                            <span class="flex h-11 w-11 items-center justify-center rounded-xl bg-emerald-100 dark:bg-emerald-900/40 text-emerald-600 dark:text-emerald-300"><i class="fa-solid fa-users-rectangle"></i></span>
                            <div>
                                <p class="text-xs text-gray-500 dark:text-gray-400 uppercase tracking-wide">Wali kelas</p>
                                <p class="text-2xl font-bold text-gray-900 dark:text-white tabular-nums">{{ $waliKelasCount }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="rounded-2xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 p-5 shadow-sm">
                        <div class="flex items-center gap-3">
                            <span class="flex h-11 w-11 items-center justify-center rounded-xl bg-violet-100 dark:bg-violet-900/40 text-violet-600 dark:text-violet-300"><i class="fa-solid fa-phone"></i></span>
                            <div>
                                <p class="text-xs text-gray-500 dark:text-gray-400 uppercase tracking-wide">Ada nomor HP</p>
                                <p class="text-2xl font-bold text-gray-900 dark:text-white tabular-nums">{{ $guruWithPhoneCount }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-200 dark:border-gray-700 shadow-sm overflow-hidden">
                    <div class="px-4 sm:px-6 py-4 border-b border-gray-200 dark:border-gray-700 flex items-center justify-between">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Daftar Guru</h3>
                        <span class="text-xs text-gray-500 dark:text-gray-400">{{ $gurus->total() }} data</span>
                    </div>

                    <div class="space-y-3 p-4 md:hidden">
                        @forelse($gurus as $guru)
                            <div class="rounded-xl border border-gray-200 dark:border-gray-700 p-4 bg-gray-50/50 dark:bg-gray-900/30">
                                <div class="flex items-center gap-3 mb-3">
                                    <div class="h-11 w-11 rounded-full bg-gradient-to-br from-indigo-500 to-blue-600 flex items-center justify-center text-white font-bold text-sm">{{ strtoupper(substr($guru->name, 0, 1)) }}</div>
                                    <div class="min-w-0">
                                        <p class="font-semibold text-gray-900 dark:text-white truncate">{{ $guru->name }}</p>
                                        <p class="text-xs text-gray-500 truncate">{{ $guru->email }}</p>
                                    </div>
                                </div>
                                <p class="text-xs text-gray-500 mb-1">Wali: @if($guru->kelas_wali)<span class="font-medium text-gray-800 dark:text-gray-200">{{ $guru->kelas_wali }} {{ $guru->jurusan_wali }}</span>@else — @endif</p>
                                <div class="flex flex-wrap gap-2 mt-3">
                                    <a href="{{ route('admin.guru.edit', $guru) }}" class="px-3 py-2 bg-indigo-600 text-white text-xs rounded-lg">Edit</a>
                                    <form action="{{ route('admin.guru.destroy', $guru) }}" method="POST" class="inline" onsubmit="return confirm('Hapus {{ $guru->name }}?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="px-3 py-2 bg-red-600 text-white text-xs rounded-lg">Hapus</button>
                                    </form>
                                </div>
                            </div>
                        @empty
                            <p class="text-center text-gray-500 py-8">Belum ada data guru.</p>
                        @endforelse
                    </div>

                    <div class="hidden md:block overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700 text-sm">
                            <thead class="bg-gray-50 dark:bg-gray-700/80">
                                <tr>
                                    <th class="px-6 py-3 text-left font-semibold text-gray-600 dark:text-gray-300">Nama</th>
                                    <th class="px-6 py-3 text-left font-semibold text-gray-600 dark:text-gray-300">Email</th>
                                    <th class="px-6 py-3 text-left font-semibold text-gray-600 dark:text-gray-300">Telepon</th>
                                    <th class="px-6 py-3 text-left font-semibold text-gray-600 dark:text-gray-300">Wali</th>
                                    <th class="px-6 py-3 text-right font-semibold text-gray-600 dark:text-gray-300">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                                @forelse($gurus as $guru)
                                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50">
                                        <td class="px-6 py-4">
                                            <div class="flex items-center gap-3">
                                                <div class="h-10 w-10 rounded-full bg-gradient-to-br from-indigo-500 to-blue-600 flex items-center justify-center text-white font-bold text-xs">{{ strtoupper(substr($guru->name, 0, 1)) }}</div>
                                                <div>
                                                    <p class="font-medium text-gray-900 dark:text-white">{{ $guru->name }}</p>
                                                    <p class="text-xs text-gray-500">{{ $guru->gender == 'L' ? 'Laki-laki' : 'Perempuan' }}</p>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 text-gray-700 dark:text-gray-300 font-mono text-xs">{{ $guru->email }}</td>
                                        <td class="px-6 py-4 text-gray-700 dark:text-gray-300">{{ $guru->phone ?: '—' }}</td>
                                        <td class="px-6 py-4">
                                            @if($guru->kelas_wali)
                                                <span class="px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900/40 dark:text-blue-200">{{ $guru->kelas_wali }} {{ $guru->jurusan_wali }}</span>
                                            @else
                                                <span class="text-gray-400">—</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 text-right space-x-2">
                                            <a href="{{ route('admin.guru.edit', $guru) }}" class="inline-flex items-center px-3 py-1.5 bg-indigo-600 text-white text-xs rounded-lg hover:bg-indigo-700">Edit</a>
                                            <form action="{{ route('admin.guru.destroy', $guru) }}" method="POST" class="inline" onsubmit="return confirm('Hapus {{ $guru->name }}?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="px-3 py-1.5 bg-red-600 text-white text-xs rounded-lg hover:bg-red-700">Hapus</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-6 py-12 text-center text-gray-500">Belum ada data guru.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="px-4 sm:px-6 py-4 bg-gray-50 dark:bg-gray-900 border-t border-gray-200 dark:border-gray-700">
                        {{ $gurus->appends(request()->query())->links() }}
                    </div>
                </div>
            </main>
        </div>
    </div>

    <div id="sidebarOverlay" class="fixed inset-0 bg-black/50 z-40 hidden md:hidden" onclick="closeSidebar()"></div>
    <script src="{{ asset('js/min/kelolaWali.js') }}"></script>
</body>
</html>
