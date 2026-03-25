<!DOCTYPE html>
<html lang="id" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Wali Kelas - Absensi SMKN 12 Jakarta</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
      
    </script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css"
        integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="icon" href="/logo.png">
    <link rel="stylesheet" href="{{ asset('css/min/kelolaWali.css') }}">
    <link rel="stylesheet" href="{{ asset('css/min/kelolaSiswa.css') }}">
</head>

<body class="text-gray-800 dark:text-gray-200 bg-gray-100 dark:bg-gray-950 min-h-screen">
    
    <div class="flex h-screen overflow-hidden">
        @include('admin.layouts.sidebar')

        <!-- Main Content -->
        <div class="flex-1 flex flex-col md:ml-64 min-w-0">
            @include('admin.layouts.header', ['title' => 'Kelola Wali Kelas'])
            
            <main class="flex-1 min-h-0 overflow-y-auto p-4 sm:p-6 min-w-0">
                <div class="relative overflow-hidden rounded-2xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 mb-6 shadow-sm">
                    <div class="absolute inset-0 bg-gradient-to-br from-indigo-500/10 via-violet-500/5 to-transparent pointer-events-none"></div>
                    <div class="relative p-6 sm:p-8">
                        <p class="text-xs font-semibold uppercase tracking-wider text-indigo-600 dark:text-indigo-400">Manajemen wali kelas</p>
                        <h1 class="text-2xl sm:text-3xl font-bold text-gray-900 dark:text-white mt-1">Kelola Wali Kelas</h1>
                        <p class="text-gray-600 dark:text-gray-400 mt-2 max-w-2xl">Atur guru yang menjadi wali kelas untuk setiap kelas dan jurusan.</p>
                    </div>
                </div>

                @if(session('success'))
                    <div class="bg-green-100 dark:bg-green-900/30 border border-green-400 dark:border-green-700 text-green-800 dark:text-green-200 px-4 py-3 rounded-xl mb-6 text-sm">{{ session('success') }}</div>
                @endif

                @if(session('error'))
                    <div class="bg-red-100 dark:bg-red-900/30 border border-red-400 dark:border-red-700 text-red-800 dark:text-red-200 px-4 py-3 rounded-xl mb-6 text-sm">{{ session('error') }}</div>
                @endif

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
    {{-- Ringkasan: bento / light card --}}
    <div class="relative overflow-hidden rounded-2xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 shadow-lg">
        <div class="absolute inset-0 bg-gradient-to-br from-sky-500/10 via-transparent to-indigo-500/10 pointer-events-none"></div>
        <div class="relative p-6 sm:p-8">
            <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-4 mb-6">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-wider text-sky-600 dark:text-sky-400">Overview</p>
                    <h3 class="text-2xl font-bold text-gray-900 dark:text-white mt-1">Ringkasan Wali Kelas</h3>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Penugasan wali dan jumlah siswa di sistem</p>
                </div>
                <div class="flex h-14 w-14 shrink-0 items-center justify-center rounded-2xl bg-sky-100 dark:bg-sky-900/40 text-sky-600 dark:text-sky-300">
                    <i class="fa-solid fa-chart-pie text-2xl"></i>
                </div>
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div class="rounded-xl bg-gray-50 dark:bg-gray-900/60 border border-gray-100 dark:border-gray-700 p-5">
                    <p class="text-sm text-gray-500 dark:text-gray-400">Wali kelas aktif</p>
                    <p class="text-3xl font-bold text-gray-900 dark:text-white mt-1 tabular-nums">{{ $gurus->whereNotNull('kelas_wali')->count() }}</p>
                </div>
                <div class="rounded-xl bg-gray-50 dark:bg-gray-900/60 border border-gray-100 dark:border-gray-700 p-5">
                    <p class="text-sm text-gray-500 dark:text-gray-400">Total siswa</p>
                    <p class="text-3xl font-bold text-gray-900 dark:text-white mt-1 tabular-nums">{{ $totalStudents }}</p>
                </div>
            </div>
        </div>
    </div>

    {{-- Quick Stats: segmented bar + legend --}}
    @php
        $distX = $gurus->where('kelas_wali', 'X')->count();
        $distXI = $gurus->where('kelas_wali', 'XI')->count();
        $distXII = $gurus->where('kelas_wali', 'XII')->count();
        $distTotal = $distX + $distXI + $distXII;
        $pctX = $distTotal > 0 ? round(($distX / $distTotal) * 100) : 0;
        $pctXI = $distTotal > 0 ? round(($distXI / $distTotal) * 100) : 0;
        $pctXII = $distTotal > 0 ? round(($distXII / $distTotal) * 100) : 0;
    @endphp
    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-200 dark:border-gray-700 p-6 sm:p-8 overflow-hidden">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-5">
            <div>
                <h4 class="text-lg font-semibold text-gray-900 dark:text-white">Distribusi Wali Kelas</h4>
                <p class="text-sm text-gray-500 dark:text-gray-400 mt-0.5">Proporsi penugasan per tingkat</p>
            </div>
            <div class="text-sm font-medium text-gray-700 dark:text-gray-300 tabular-nums">
                Total <span class="text-gray-900 dark:text-white">{{ $distTotal }}</span> wali
            </div>
        </div>

        @if($distTotal > 0)
            <div class="flex h-5 sm:h-6 rounded-full overflow-hidden ring-1 ring-inset ring-gray-200 dark:ring-gray-600 shadow-inner bg-gray-100 dark:bg-gray-900/50">
                @if($pctX > 0)
                    <div class="bg-blue-500 dark:bg-blue-600 first:rounded-l-full last:rounded-r-full min-w-[4px] transition-all" style="width: {{ $pctX }}%" title="X: {{ $distX }}"></div>
                @endif
                @if($pctXI > 0)
                    <div class="bg-emerald-500 dark:bg-emerald-600 first:rounded-l-full last:rounded-r-full min-w-[4px] transition-all" style="width: {{ $pctXI }}%" title="XI: {{ $distXI }}"></div>
                @endif
                @if($pctXII > 0)
                    <div class="bg-violet-500 dark:bg-violet-600 first:rounded-l-full last:rounded-r-full min-w-[4px] transition-all" style="width: {{ $pctXII }}%" title="XII: {{ $distXII }}"></div>
                @endif
            </div>
            <div class="mt-2 flex flex-wrap gap-x-4 gap-y-1 text-xs text-gray-500 dark:text-gray-400">
                <span><span class="inline-block w-2 h-2 rounded-full bg-blue-500 align-middle mr-1"></span>X {{ $pctX }}%</span>
                <span><span class="inline-block w-2 h-2 rounded-full bg-emerald-500 align-middle mr-1"></span>XI {{ $pctXI }}%</span>
                <span><span class="inline-block w-2 h-2 rounded-full bg-violet-500 align-middle mr-1"></span>XII {{ $pctXII }}%</span>
            </div>
        @else
            <div class="rounded-xl border border-dashed border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-900/40 py-8 text-center text-sm text-gray-500 dark:text-gray-400">
                Belum ada wali kelas yang ditugaskan
            </div>
        @endif

        <div class="mt-6 grid grid-cols-1 sm:grid-cols-3 gap-3">
            <div class="rounded-xl bg-gradient-to-b from-blue-500/10 to-transparent dark:from-blue-500/20 border border-blue-100 dark:border-blue-900/50 p-4 text-center">
                <i class="fa-solid fa-book-open-reader text-blue-600 dark:text-blue-400 text-lg mb-2"></i>
                <p class="text-2xl font-bold text-gray-900 dark:text-white tabular-nums">{{ $distX }}</p>
                <p class="text-xs font-medium text-blue-700 dark:text-blue-300 uppercase tracking-wide">Kelas X</p>
            </div>
            <div class="rounded-xl bg-gradient-to-b from-emerald-500/10 to-transparent dark:from-emerald-500/20 border border-emerald-100 dark:border-emerald-900/50 p-4 text-center">
                <i class="fa-solid fa-book-open-reader text-emerald-600 dark:text-emerald-400 text-lg mb-2"></i>
                <p class="text-2xl font-bold text-gray-900 dark:text-white tabular-nums">{{ $distXI }}</p>
                <p class="text-xs font-medium text-emerald-700 dark:text-emerald-300 uppercase tracking-wide">Kelas XI</p>
            </div>
            <div class="rounded-xl bg-gradient-to-b from-violet-500/10 to-transparent dark:from-violet-500/20 border border-violet-100 dark:border-violet-900/50 p-4 text-center">
                <i class="fa-solid fa-book-open-reader text-violet-600 dark:text-violet-400 text-lg mb-2"></i>
                <p class="text-2xl font-bold text-gray-900 dark:text-white tabular-nums">{{ $distXII }}</p>
                <p class="text-xs font-medium text-violet-700 dark:text-violet-300 uppercase tracking-wide">Kelas XII</p>
            </div>
        </div>
    </div>
</div>

<div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-200 dark:border-gray-700 shadow-sm overflow-hidden min-w-0">
    <div class="p-4 sm:p-6 min-w-0">
        <!-- Mobile cards -->
        <div class="space-y-4 md:hidden">
            @forelse($gurus as $guru)
                <div class="rounded-xl border border-gray-200 dark:border-gray-700 p-4 bg-gray-50/50 dark:bg-gray-900/30">
                    <div class="flex items-center gap-3 mb-3">
                        <div class="h-10 w-10 bg-gradient-to-r from-blue-500 to-indigo-600 rounded-full flex items-center justify-center text-white font-bold text-sm">
                            {{ strtoupper(substr($guru->name, 0, 1)) }}
                        </div>
                        <div class="min-w-0">
                            <p class="text-sm font-semibold text-gray-900 dark:text-white truncate">{{ $guru->name }}</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400 truncate">{{ $guru->email }}</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-3 text-xs mb-4">
                        <div>
                            <p class="text-gray-500 dark:text-gray-400">Kelas Wali</p>
                            <p class="mt-1 font-semibold text-gray-900 dark:text-white">{{ $guru->kelas_wali ?? '-' }}</p>
                        </div>
                        <div>
                            <p class="text-gray-500 dark:text-gray-400">Jurusan</p>
                            <p class="mt-1 font-semibold text-gray-900 dark:text-white">{{ $guru->jurusan_wali ?? '-' }}</p>
                        </div>
                    </div>

                    <div class="flex flex-wrap items-center gap-2">
                        <button type="button" onclick="openModal({{ $guru->id }}, '{{ addslashes($guru->name) }}', '{{ $guru->kelas_wali ?? '' }}', '{{ $guru->jurusan_wali ?? '' }}')"
                            class="px-3 py-2 bg-indigo-600 text-white text-xs rounded-md hover:bg-indigo-700 transition">
                            Edit
                        </button>
                        @if($guru->kelas_wali)
                            <form action="{{ route('admin.wali-kelas.destroy', $guru->id) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="px-3 py-2 bg-red-600 text-white text-xs rounded-md hover:bg-red-700 transition" onclick="return confirm('Hapus {{ $guru->name }} sebagai wali kelas?')">
                                    Hapus
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            @empty
                <div class="py-10 text-center text-gray-500 dark:text-gray-400">
                    <i class="fa-solid fa-users text-4xl mb-4 opacity-50"></i>
                    <p>Belum ada guru yang ditugaskan sebagai wali kelas</p>
                    <p class="text-sm mt-1">Gunakan tombol edit untuk menugaskan guru</p>
                </div>
            @endforelse
        </div>

        <!-- Desktop table -->
        <div class="hidden md:block overflow-x-auto">
            <table class="min-w-[720px] w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead class="bg-gray-50 dark:bg-gray-700">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Nama Guru</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Email</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Kelas Wali</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Jurusan Wali</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Jml Siswa</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                    @forelse($gurus as $guru)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="h-10 w-10 bg-gradient-to-r from-blue-500 to-indigo-600 rounded-full flex items-center justify-center text-white font-bold text-sm">
                                        {{ strtoupper(substr($guru->name, 0, 1)) }}
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-900 dark:text-white">{{ $guru->name }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-500 dark:text-gray-400">{{ $guru->email }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($guru->kelas_wali)
                                    <span class="px-3 py-1 inline-flex text-xs leading-4 font-semibold rounded-full bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200">
                                        {{ $guru->kelas_wali }}
                                    </span>
                                @else
                                    <span class="px-2 py-1 inline-flex text-xs leading-4 font-semibold rounded-full bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300">
                                        -
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($guru->jurusan_wali)
                                    <span class="px-3 py-1 inline-flex text-xs leading-4 font-semibold rounded-full bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-200">
                                        {{ $guru->jurusan_wali }}
                                    </span>
                                @else
                                    <span class="px-2 py-1 inline-flex text-xs leading-4 font-semibold rounded-full bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300">
                                        -
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-white">
                                @if($guru->kelas_wali)
                                    {{ $gurus->where('kelas_wali', $guru->kelas_wali)->count() }}
                                @else
                                    0
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">

                                <div class="text-sm font-medium">
                                    <a href="{{ route('admin.wali-kelas.edit', $guru->id) }}" class="inline-flex items-center px-3 py-1.5 bg-indigo-600 text-white text-xs rounded-lg hover:bg-indigo-700">Edit</a>
                                    @if($guru->kelas_wali)
                                        <form action="{{ route('admin.wali-kelas.destroy', $guru->id) }}" method="POST" class="inline" onsubmit="return confirm('Hapus {{ $guru->name }} sebagai wali kelas?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="inline-flex items-center px-3 py-1.5 bg-red-600 text-white text-xs rounded-lg hover:bg-red-700">Hapus</button>
                                        </form>
                                    @endif
                                </div>

                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center text-gray-500 dark:text-gray-400">
                                <i class="fa-solid fa-users text-4xl mb-4 opacity-50"></i>
                                <p>Belum ada guru yang ditugaskan sebagai wali kelas</p>
                                <p class="text-sm mt-1">Gunakan tombol edit untuk menugaskan guru</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
            </main>
        </div>
    </div>

    <!-- Modal for editing wali kelas -->
    <div id="waliKelasModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden overflow-y-auto h-full w-full z-50">
        <div class="relative top-6 sm:top-20 mx-auto p-5 border w-[92%] max-w-md shadow-lg rounded-md bg-white dark:bg-gray-800">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-medium text-gray-900 dark:text-white">Edit Wali Kelas</h3>
                <button onclick="closeModal()" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            
<form id="waliKelasForm" method="POST" action="">
    @csrf
    @method('PUT')

                
<input type="hidden" name="guru_id" id="guruIdInput">
    <p id="guruName" class="text-sm text-gray-600 dark:text-gray-400 mb-4 font-medium"></p>
                
                <div class="mb-4">
                    <label for="kelas_wali" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Kelas</label>
                    <select id="kelas_wali" name="kelas_wali" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white">
                        <option value="">Pilih Kelas</option>
                        <option value="X">X</option>
                        <option value="XI">XI</option>
                        <option value="XII">XII</option>
                    </select>
                </div>
                
                <div class="mb-4">
                    <label for="jurusan_wali" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Jurusan</label>
                    <select id="jurusan_wali" name="jurusan_wali" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white">
                        <option value="">Pilih Jurusan</option>
                        <option value="RPL">RPL</option>
                        <option value="BR">BR</option>
                        <option value="AKL">AKL</option>
                        <option value="MP">MP</option>
                    </select>
                </div>
                
                <div class="flex justify-end gap-2">
                    <button type="button" onclick="closeModal()" class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400 dark:bg-gray-600 dark:text-gray-300">
                        Batal
                    </button>
                    <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Mobile Sidebar Overlay -->
    <div id="sidebarOverlay" class="fixed inset-0 bg-black/50 z-40 hidden md:hidden" onclick="closeSidebar()"></div>
    
    
</body>
<script src="{{ asset('js/min/kelolaWali.js') }}"></script>
</html>
