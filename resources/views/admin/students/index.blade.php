<!DOCTYPE html>
<html lang="id" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Siswa - Admin Panel</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css"
        integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="icon" href="/logo.png">
    <link rel="stylesheet" href="{{ asset('css/min/kelolaSiswa.css') }}">
    <link rel="stylesheet" href="{{ asset('css/min/kelolaWali.css') }}">
</head>

<body class="text-gray-800 dark:text-gray-200 bg-gray-100 dark:bg-gray-950 min-h-screen">
    <div class="flex h-screen overflow-hidden">
        @include('admin.layouts.sidebar')

        <div class="flex-1 flex flex-col md:ml-64 min-w-0">
            @include('admin.layouts.header', ['title' => 'Kelola Data Siswa'])

            <main class="flex-1 min-h-0 overflow-y-auto p-4 sm:p-6">
                <div class="relative overflow-hidden rounded-2xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 mb-6 shadow-sm">
                    <div class="absolute inset-0 bg-gradient-to-br from-indigo-500/10 via-violet-500/5 to-transparent pointer-events-none"></div>
                    <div class="relative p-6 sm:p-8 flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6">
                        <div>
                            <p class="text-xs font-semibold uppercase tracking-wider text-indigo-600 dark:text-indigo-400">Manajemen siswa</p>
                            <h1 class="text-2xl sm:text-3xl font-bold text-gray-900 dark:text-white mt-1">Daftar Siswa</h1>
                            <p class="text-gray-600 dark:text-gray-400 mt-2 max-w-xl">Tambah, ubah, atau hapus data murid. Total {{ $totalStudents }} siswa terdaftar.</p>
                        </div>
                        <a href="{{ route('admin.students.create') }}" class="inline-flex w-full sm:w-auto items-center justify-center gap-2 px-6 py-3 min-h-[44px] rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white font-semibold shadow-lg shadow-indigo-500/25 transition shrink-0 touch-manipulation">
                            <i class="fa-solid fa-plus"></i>
                            Tambah Siswa
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
                    <form action="{{ route('admin.students.index') }}" method="GET" class="flex flex-col md:flex-row gap-4 items-stretch md:items-end">
                        <div class="flex-1 min-w-0">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Cari</label>
                            <div class="relative">
                                <i class="fa-solid fa-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
                                <input type="text" name="search" value="{{ $filters['search'] }}" placeholder="Nama, NIS, email, NISN…"
                                    class="w-full pl-10 pr-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-xl bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-indigo-500">
                            </div>
                        </div>
                        <div class="w-full md:w-48">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Urutkan</label>
                            <select name="sort_by"
                                class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-xl bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-indigo-500">
                                <option value="name" {{ $filters['sort_by'] == 'name' ? 'selected' : '' }}>Nama</option>
                                <option value="id" {{ $filters['sort_by'] == 'id' ? 'selected' : '' }}>NIS</option>
                                <option value="class" {{ $filters['sort_by'] == 'class' ? 'selected' : '' }}>Kelas</option>
                                <option value="jurusan" {{ $filters['sort_by'] == 'jurusan' ? 'selected' : '' }}>Jurusan</option>
                            </select>
                        </div>
                        <div class="w-full md:w-36">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Arah</label>
                            <select name="sort_order"
                                class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-xl bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-indigo-500">
                                <option value="asc" {{ $filters['sort_order'] == 'asc' ? 'selected' : '' }}>A–Z</option>
                                <option value="desc" {{ $filters['sort_order'] == 'desc' ? 'selected' : '' }}>Z–A</option>
                            </select>
                        </div>
                        <button type="submit" class="px-6 py-2.5 rounded-xl bg-indigo-600 text-white font-medium hover:bg-indigo-700 transition">Terapkan</button>
                        @if($filters['search'])
                            <a href="{{ route('admin.students.index') }}" class="px-6 py-2.5 rounded-xl border border-gray-300 dark:border-gray-600 text-center font-medium hover:bg-gray-50 dark:hover:bg-gray-700 transition">Reset</a>
                        @endif
                    </form>
                </div>

                <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-200 dark:border-gray-700 shadow-sm overflow-hidden">
                    <div class="px-4 sm:px-6 py-4 border-b border-gray-200 dark:border-gray-700 flex items-center justify-between">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Data siswa</h3>
                        <span class="text-xs text-gray-500 dark:text-gray-400">{{ $students->total() }} data</span>
                    </div>

                    <div class="space-y-3 p-4 md:hidden">
                        @forelse($students as $student)
                            <div class="rounded-xl border border-gray-200 dark:border-gray-700 p-4 bg-gray-50/50 dark:bg-gray-900/30">
                                <div class="flex items-center gap-3 mb-3">
                                    <div class="h-11 w-11 rounded-full bg-gradient-to-br from-indigo-500 to-blue-600 flex items-center justify-center text-white font-bold text-sm">
                                        {{ strtoupper(substr($student->name, 0, 1)) }}
                                    </div>
                                    <div class="min-w-0">
                                        <p class="font-semibold text-gray-900 dark:text-white truncate">{{ $student->name }}</p>
                                        <p class="text-xs text-gray-500 truncate">{{ $student->email }}</p>
                                    </div>
                                </div>
                                <p class="text-xs text-gray-500">NIS: <span class="font-medium text-gray-800 dark:text-gray-200">{{ $student->id }}</span></p>
                                <p class="text-xs text-gray-500 mt-1">Kelas / Jurusan: <span class="font-medium">{{ $student->getAttribute('class') ?: '—' }} · {{ $student->jurusan ?: '—' }}</span></p>
                                <div class="flex flex-wrap gap-2 mt-3">
                                    <a href="{{ route('admin.students.edit', $student->id) }}" class="px-3 py-2 bg-indigo-600 text-white text-xs rounded-lg">Edit</a>
                                    <form action="{{ route('admin.students.destroy', $student->id) }}" method="POST" class="inline" onsubmit="return confirm('Hapus data siswa ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="px-3 py-2 bg-red-600 text-white text-xs rounded-lg">Hapus</button>
                                    </form>
                                </div>
                            </div>
                        @empty
                            <p class="text-center text-gray-500 py-8">Belum ada data siswa.</p>
                        @endforelse
                    </div>

                    <div class="hidden md:block overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700 text-sm">
                            <thead class="bg-gray-50 dark:bg-gray-700/80">
                                <tr>
                                    <th class="px-6 py-3 text-left font-semibold text-gray-600 dark:text-gray-300">NIS</th>
                                    <th class="px-6 py-3 text-left font-semibold text-gray-600 dark:text-gray-300">Nama</th>
                                    <th class="px-6 py-3 text-left font-semibold text-gray-600 dark:text-gray-300">Email</th>
                                    <th class="px-6 py-3 text-left font-semibold text-gray-600 dark:text-gray-300">NISN</th>
                                    <th class="px-6 py-3 text-left font-semibold text-gray-600 dark:text-gray-300">Kelas</th>
                                    <th class="px-6 py-3 text-left font-semibold text-gray-600 dark:text-gray-300">Jurusan</th>
                                    <th class="px-6 py-3 text-left font-semibold text-gray-600 dark:text-gray-300">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                                @forelse($students as $student)
                                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50">
                                        <td class="px-6 py-4 font-medium text-gray-900 dark:text-white">{{ $student->id }}</td>
                                        <td class="px-6 py-4">
                                            <div class="flex items-center gap-3">
                                                <div class="h-10 w-10 rounded-full bg-gradient-to-br from-indigo-500 to-blue-600 flex items-center justify-center text-white font-bold text-xs">
                                                    {{ strtoupper(substr($student->name, 0, 1)) }}
                                                </div>
                                                <span class="font-medium text-gray-900 dark:text-white">{{ $student->name }}</span>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 text-gray-600 dark:text-gray-300">{{ $student->email }}</td>
                                        <td class="px-6 py-4 text-gray-600 dark:text-gray-300">{{ $student->nisn ?? '—' }}</td>
                                        <td class="px-6 py-4">
                                            <span class="px-2 py-1 text-xs font-medium rounded-full bg-indigo-100 dark:bg-indigo-900/40 text-indigo-800 dark:text-indigo-200">
                                                {{ $student->getAttribute('class') ?: '—' }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4">
                                            <span class="px-2 py-1 text-xs font-medium rounded-full bg-violet-100 dark:bg-violet-900/40 text-violet-800 dark:text-violet-200">
                                                {{ $student->jurusan ?: '—' }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="flex items-center gap-2">
                                                <a href="{{ route('admin.students.edit', $student->id) }}" class="p-2 text-indigo-600 dark:text-indigo-400 hover:bg-indigo-50 dark:hover:bg-indigo-900/20 rounded-lg transition" title="Edit">
                                                    <i class="fa-solid fa-pen"></i>
                                                </a>
                                                <form action="{{ route('admin.students.destroy', $student->id) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data siswa ini?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="p-2 text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20 rounded-lg transition" title="Hapus">
                                                        <i class="fa-solid fa-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="px-6 py-12 text-center text-gray-500">
                                            Belum ada data siswa.
                                            <a href="{{ route('admin.students.create') }}" class="block mt-2 text-indigo-600 dark:text-indigo-400 hover:underline">Tambah siswa pertama</a>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    @if($students->hasPages())
                        <div class="px-4 sm:px-6 py-4 border-t border-gray-200 dark:border-gray-700">
                            {{ $students->links() }}
                        </div>
                    @endif
                </div>
            </main>
        </div>
    </div>

    <div id="sidebarOverlay" class="fixed inset-0 bg-black/50 z-40 hidden md:hidden" onclick="closeSidebar()"></div>
    <script src="{{ asset('js/min/kelolaWali.js') }}"></script>
</body>
</html>
