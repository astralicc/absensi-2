<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rekap Absensi - Admin</title>
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
            @include('admin.layouts.header', ['title' => 'Rekap Absensi'])

            <main class="flex-1 min-h-0 overflow-y-auto p-4 sm:p-6 min-w-0">
                <div class="relative overflow-hidden rounded-2xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 mb-6 shadow-sm">
                    <div class="absolute inset-0 bg-gradient-to-br from-indigo-500/10 via-violet-500/5 to-transparent pointer-events-none"></div>
                    <div class="relative p-6 sm:p-8 flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6">
                        <div>
                            <p class="text-xs font-semibold uppercase tracking-wider text-indigo-600 dark:text-indigo-400">Laporan absensi</p>
                            <h2 class="text-2xl sm:text-3xl font-bold text-gray-900 dark:text-white mt-1">Rekap absensi murid</h2>
                            <p class="text-gray-600 dark:text-gray-400 mt-2 max-w-xl text-sm">Data dari tabel absensi; filter per rentang tanggal, kelas, dan jurusan.</p>
                        </div>
                        <a href="{{ route('admin.rekap.export', request()->query()) }}" class="inline-flex w-full sm:w-auto items-center justify-center gap-2 px-6 py-3 min-h-[44px] rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-semibold shadow-lg shadow-emerald-500/20 transition shrink-0 touch-manipulation">
                            <i class="fa-solid fa-file-excel"></i>Export Excel
                        </a>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6">
                    <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-200 dark:border-gray-700 p-5 shadow-sm">
                        <p class="text-xs text-gray-500 dark:text-gray-400 uppercase tracking-wide">Hadir</p>
                        <p class="text-2xl font-bold text-green-600 dark:text-green-400 tabular-nums mt-1">{{ $totalHadir }}</p>
                    </div>
                    <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-200 dark:border-gray-700 p-5 shadow-sm">
                        <p class="text-xs text-gray-500 dark:text-gray-400 uppercase tracking-wide">Tanpa check-in</p>
                        <p class="text-2xl font-bold text-amber-600 dark:text-amber-400 tabular-nums mt-1">{{ $totalAlpha }}</p>
                    </div>
                    <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-200 dark:border-gray-700 p-5 shadow-sm">
                        <p class="text-xs text-gray-500 dark:text-gray-400 uppercase tracking-wide">Total baris (filter)</p>
                        <p class="text-2xl font-bold text-gray-900 dark:text-white tabular-nums mt-1">{{ $totalRecords }}</p>
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-200 dark:border-gray-700 p-4 sm:p-6 mb-6 shadow-sm">
                    <form method="GET" action="{{ route('admin.rekap.index') }}" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4 items-end">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Dari</label>
                            <input type="date" name="date_from" value="{{ $dateFrom ?? '' }}" class="w-full rounded-xl border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white px-3 py-2.5 text-sm focus:ring-2 focus:ring-indigo-500">

                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Sampai</label>
                            <input type="date" name="date_to" value="{{ $dateTo }}" class="w-full rounded-xl border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white px-3 py-2.5 text-sm focus:ring-2 focus:ring-indigo-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Kelas</label>
                            <select name="class" class="w-full rounded-xl border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white px-3 py-2.5 text-sm focus:ring-2 focus:ring-indigo-500">
                                <option value="">Semua</option>
                                @foreach($kelasList as $k)
                                    <option value="{{ $k }}" {{ ($class ?? '') === $k ? 'selected' : '' }}>{{ $k }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Jurusan</label>
                            <select name="jurusan" class="w-full rounded-xl border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white px-3 py-2.5 text-sm focus:ring-2 focus:ring-indigo-500">
                                <option value="">Semua</option>
                                @foreach($jurusanList as $j)
                                    <option value="{{ $j }}" {{ ($jurusan ?? '') === $j ? 'selected' : '' }}>{{ $j }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="flex flex-col sm:flex-row gap-2 w-full min-w-0">
                            <button type="submit" class="flex-1 px-4 py-3 min-h-[44px] bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl text-sm font-medium touch-manipulation">Terapkan</button>
                            <a href="{{ route('admin.rekap.index') }}" class="px-4 py-3 min-h-[44px] sm:min-w-[5rem] flex items-center justify-center border border-gray-300 dark:border-gray-600 rounded-xl text-sm font-medium hover:bg-gray-50 dark:hover:bg-gray-700 touch-manipulation">Reset</a>
                        </div>
                    </form>
                </div>

                <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-200 dark:border-gray-700 shadow-sm overflow-hidden">
                    <div class="px-4 sm:px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Detail rekap</h3>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">{{ $rekaps->total() }} baris</p>
                    </div>

                    <div class="space-y-3 p-4 md:hidden">
                        @forelse($rekaps as $row)
                            @php $u = $row->user; @endphp
                            <div class="rounded-xl border border-gray-200 dark:border-gray-700 p-4 bg-gray-50/50 dark:bg-gray-900/30 text-sm">
                                <p class="font-semibold text-gray-900 dark:text-white">{{ $u?->name ?? '-' }}</p>
                                <p class="text-xs text-gray-500 truncate">{{ $u?->email ?? '' }}</p>
                                <p class="text-xs text-gray-600 dark:text-gray-300 mt-2">{{ $row->date->format('d M Y') }} · {{ $row->check_in ? $row->check_in->format('H:i') : '—' }}</p>
                                <p class="text-xs mt-1">{{ ($u ? $u->getAttribute('class') : null) ?: '—' }} {{ $u?->jurusan ?? '' }}</p>
                                <div class="mt-2">
                                    @if($row->check_in)
                                        <span class="px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900/40 dark:text-green-300">Hadir</span>
                                    @else
                                        <span class="px-2 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-700 dark:bg-gray-600 dark:text-gray-200">Tidak hadir</span>
                                    @endif
                                </div>
                            </div>
                        @empty
                            <p class="text-center text-gray-500 py-8">Tidak ada data untuk filter ini.</p>
                        @endforelse
                    </div>

                    <div class="hidden md:block overflow-x-auto">
                        <table class="min-w-[640px] w-full text-sm">
                            <thead class="bg-gray-50 dark:bg-gray-700/80 text-left">
                                <tr>
                                    <th class="px-4 py-3 font-semibold text-gray-600 dark:text-gray-300">Murid</th>
                                    <th class="px-4 py-3 font-semibold text-gray-600 dark:text-gray-300">Kelas</th>
                                    <th class="px-4 py-3 font-semibold text-gray-600 dark:text-gray-300">Tanggal</th>
                                    <th class="px-4 py-3 font-semibold text-gray-600 dark:text-gray-300">Masuk</th>
                                    <th class="px-4 py-3 font-semibold text-gray-600 dark:text-gray-300">Status</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                                @forelse($rekaps as $row)
                                    @php $u = $row->user; @endphp
                                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50">
                                        <td class="px-4 py-3">
                                            <span class="font-medium text-gray-900 dark:text-white">{{ $u?->name ?? '-' }}</span>
                                            <span class="block text-xs text-gray-500">{{ $u?->email ?? '' }}</span>
                                        </td>
                                        <td class="px-4 py-3 text-gray-700 dark:text-gray-300">{{ ($u ? $u->getAttribute('class') : null) ?: '—' }} {{ $u?->jurusan ?? '' }}</td>
                                        <td class="px-4 py-3 text-gray-700 dark:text-gray-300">{{ $row->date->format('d M Y') }}</td>
                                        <td class="px-4 py-3 text-gray-700 dark:text-gray-300">{{ $row->check_in ? $row->check_in->format('H:i') : '—' }}</td>
                                        <td class="px-4 py-3">
                                            @if($row->check_in)
                                                <span class="px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900/40 dark:text-green-300">Hadir</span>
                                            @else
                                                <span class="px-2 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-700 dark:bg-gray-600 dark:text-gray-200">Tidak hadir</span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-4 py-12 text-center text-gray-500 dark:text-gray-400">Tidak ada data untuk filter ini.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    @if($rekaps->hasPages())
                        <div class="px-4 py-3 border-t border-gray-200 dark:border-gray-700">{{ $rekaps->links() }}</div>
                    @endif
                </div>
            </main>
        </div>
    </div>

    <div id="sidebarOverlay" class="fixed inset-0 bg-black/50 z-40 hidden md:hidden" onclick="closeSidebar()"></div>
    <script src="{{ asset('js/min/kelolaWali.js') }}"></script>
</body>
</html>
