<!DOCTYPE html>
<html lang="id" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Pengumuman - Admin Panel</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
       
    </script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css"
        integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="icon" href="/logo.png">
    <link rel="stylesheet" href="{{ asset('css/min/kelolaPengum.css') }}">
    <link rel="stylesheet" href="{{ asset('css/min/kelolaWali.css') }}">
    <link rel="stylesheet" href="{{ asset('css/min/kelolaSiswa.css') }}">
</head>

<body class="text-gray-800 dark:text-gray-200 bg-gray-100 dark:bg-gray-950 min-h-screen">
    <div class="flex h-screen overflow-hidden">
        @include('admin.layouts.sidebar')

        <div class="flex-1 flex flex-col md:ml-64 min-w-0">
            @include('admin.layouts.header', ['title' => 'Kelola Pengumuman'])
            
            <main class="flex-1 min-h-0 overflow-y-auto p-4 sm:p-6">
                <div class="relative overflow-hidden rounded-2xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 mb-6 shadow-sm">
                    <div class="absolute inset-0 bg-gradient-to-br from-indigo-500/10 via-violet-500/5 to-transparent pointer-events-none"></div>
                    <div class="relative p-6 sm:p-8 flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6">
                        <div>
                            <p class="text-xs font-semibold uppercase tracking-wider text-indigo-600 dark:text-indigo-400">Konten sekolah</p>
                            <h2 class="text-2xl sm:text-3xl font-bold text-gray-900 dark:text-white mt-1">Daftar pengumuman</h2>
                            <p class="text-gray-600 dark:text-gray-400 mt-2 max-w-xl">Kelola semua pengumuman yang tampil untuk siswa dan guru.</p>
                        </div>
                        <a href="{{ route('admin.announcements.create') }}" class="inline-flex w-full sm:w-auto items-center justify-center gap-2 px-6 py-3 min-h-[44px] rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white font-semibold shadow-lg shadow-indigo-500/25 transition shrink-0 touch-manipulation">
                            <i class="fa-solid fa-plus"></i>
                            Buat pengumuman
                        </a>
                    </div>
                </div>

                @if(session('success'))
                    <div class="bg-green-100 dark:bg-green-900/30 border border-green-400 dark:border-green-700 text-green-800 dark:text-green-200 px-4 py-3 rounded-xl mb-6 text-sm">{{ session('success') }}</div>
                @endif

                <div class="mb-6 bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-200 dark:border-gray-700 p-4 sm:p-6">
                    <form action="{{ route('admin.announcements.index') }}" method="GET" class="flex flex-col md:flex-row gap-4 items-stretch md:items-end">
                        <div class="flex-1">
                            <div class="relative">
                                <i class="fa-solid fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                                <input type="text" name="search" value="{{ $search }}" placeholder="Cari pengumuman..." 
                                    class="w-full pl-10 pr-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-xl bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                            </div>
                        </div>
                        <div class="w-full md:w-48">
                            <select name="category" onchange="this.form.submit()" 
                                class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-xl bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                                <option value="all" {{ $category === 'all' ? 'selected' : '' }}>Semua Kategori</option>
                                <option value="akademik" {{ $category === 'akademik' ? 'selected' : '' }}>Akademik</option>
                                <option value="umum" {{ $category === 'umum' ? 'selected' : '' }}>Umum</option>
                                <option value="kegiatan" {{ $category === 'kegiatan' ? 'selected' : '' }}>Kegiatan</option>
                            </select>
                        </div>
                        <button type="submit" class="px-6 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl font-medium transition">
                            <i class="fa-solid fa-filter mr-2"></i>Filter
                        </button>
                        @if($search || $category !== 'all')
                            <a href="{{ route('admin.announcements.index') }}" class="px-6 py-2.5 border border-gray-300 dark:border-gray-600 rounded-xl text-center font-medium hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                                <i class="fa-solid fa-times mr-2"></i>Reset
                            </a>
                        @endif
                    </form>
                </div>

                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
                    <div class="px-4 sm:px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Pengumuman</h3>
                        <p class="text-xs text-gray-500 dark:text-gray-400">{{ $announcements->total() }} entri</p>
                    </div>

                    <div class="space-y-3 p-4 md:hidden">
                        @forelse($announcements as $announcement)
                            <div class="rounded-xl border border-gray-200 dark:border-gray-700 p-4 bg-gray-50/50 dark:bg-gray-900/30">
                                <p class="font-semibold text-gray-900 dark:text-white">{{ $announcement->title }}</p>
                                <p class="text-xs text-gray-500 mt-1 line-clamp-2">{{ \Illuminate\Support\Str::limit($announcement->content, 80) }}</p>
                                <p class="text-xs text-gray-500 mt-2">{{ $announcement->date->format('d M Y') }} · {{ ucfirst($announcement->category) }}</p>
                                <div class="flex flex-wrap gap-2 mt-3">
                                    <a href="{{ route('admin.announcements.edit', $announcement->id) }}" class="px-3 py-2 bg-indigo-600 text-white text-xs rounded-lg">Edit</a>
                                    <form action="{{ route('admin.announcements.destroy', $announcement->id) }}" method="POST" class="inline" onsubmit="return confirm('Hapus pengumuman ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="px-3 py-2 bg-red-600 text-white text-xs rounded-lg">Hapus</button>
                                    </form>
                                </div>
                            </div>
                        @empty
                            <p class="text-center text-gray-500 py-8">Belum ada pengumuman.</p>
                        @endforelse
                    </div>

                    <div class="hidden md:block overflow-x-auto">
                        <table class="w-full">
                            <thead class="bg-gray-50 dark:bg-gray-700/50">
                                <tr>
                                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Judul</th>
                                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Kategori</th>
                                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Prioritas</th>
                                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Tanggal</th>
                                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Status</th>
                                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                                @forelse($announcements as $announcement)
                                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition">
                                        <td class="px-6 py-4">
                                            <div class="flex items-center">
                                                <div class="flex-shrink-0 h-10 w-10 rounded-full bg-red-100 dark:bg-red-900/30 flex items-center justify-center">
                                                    <i class="fa-solid fa-bullhorn text-red-600 dark:text-red-400"></i>
                                                </div>
                                                <div class="ml-4">
                                                    <div class="text-sm font-medium text-gray-900 dark:text-white">{{ $announcement->title }}</div>
                                                    <div class="text-sm text-gray-500 dark:text-gray-400">{{ \Illuminate\Support\Str::limit($announcement->content, 50) }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4">
                                            <span class="px-2 py-1 text-xs font-medium rounded-full 
                                                {{ $announcement->category === 'akademik' ? 'bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-400' : '' }}
                                                {{ $announcement->category === 'umum' ? 'bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-400' : '' }}
                                                {{ $announcement->category === 'kegiatan' ? 'bg-purple-100 dark:bg-purple-900/30 text-purple-700 dark:text-purple-400' : '' }}">
                                                {{ ucfirst($announcement->category) }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4">
                                            <span class="px-2 py-1 text-xs font-medium rounded-full 
                                                {{ $announcement->priority === 'high' ? 'bg-red-100 dark:bg-red-900/30 text-red-700 dark:text-red-400' : '' }}
                                                {{ $announcement->priority === 'medium' ? 'bg-yellow-100 dark:bg-yellow-900/30 text-yellow-700 dark:text-yellow-400' : '' }}
                                                {{ $announcement->priority === 'low' ? 'bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-400' : '' }}">
                                                {{ $announcement->priority === 'high' ? 'Penting' : ($announcement->priority === 'medium' ? 'Informasi' : 'Umum') }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-500 dark:text-gray-400">
                                            {{ $announcement->date->format('d M Y') }}
                                        </td>
                                        <td class="px-6 py-4">
                                            <span class="px-2 py-1 text-xs font-medium rounded-full 
                                                {{ $announcement->is_active ? 'bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-400' : 'bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-400' }}">
                                                {{ $announcement->is_active ? 'Aktif' : 'Nonaktif' }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="flex items-center gap-2">
                                                <a href="{{ route('announcements.show', $announcement->id) }}" target="_blank" 
                                                    class="p-2 text-blue-600 dark:text-blue-400 hover:bg-blue-50 dark:hover:bg-blue-900/20 rounded-lg transition" title="Lihat">
                                                    <i class="fa-solid fa-eye"></i>
                                                </a>
                                                <a href="{{ route('admin.announcements.edit', $announcement->id) }}" 
                                                    class="p-2 text-yellow-600 dark:text-yellow-400 hover:bg-yellow-50 dark:hover:bg-yellow-900/20 rounded-lg transition" title="Edit">
                                                    <i class="fa-solid fa-pen"></i>
                                                </a>
                                                <form action="{{ route('admin.announcements.destroy', $announcement->id) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus pengumuman ini?')">
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
                                        <td colspan="6" class="px-6 py-12 text-center">
                                            <i class="fa-solid fa-bullhorn text-4xl text-gray-300 dark:text-gray-600 mb-4"></i>
                                            <p class="text-gray-500 dark:text-gray-400">Belum ada pengumuman</p>
                                            <a href="{{ route('admin.announcements.create') }}" class="mt-2 inline-block text-indigo-600 dark:text-indigo-400 hover:underline">
                                                Buat pengumuman pertama
                                            </a>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    
                    <!-- Pagination -->
                    @if($announcements->hasPages())
                        <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-700">
                            {{ $announcements->links() }}
                        </div>
                    @endif
                </div>

            </main>
        </div>
    </div>
    
    <!-- Mobile Sidebar Overlay -->
    <div id="sidebarOverlay" class="fixed inset-0 bg-black/50 z-40 hidden md:hidden" onclick="closeSidebar()"></div>
    
    
</body>
<script src="{{ asset('js/min/kelolaPengum.js') }}"></script>
</html>
