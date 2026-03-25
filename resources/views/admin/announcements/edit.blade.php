<!DOCTYPE html>
<html lang="id" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Pengumuman - Admin Panel</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
    
    </script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css"
        integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="icon" href="/logo.png">
    <link rel="stylesheet" href="{{ asset('css/min/editPengum.css') }}">
    <link rel="stylesheet" href="{{ asset('css/min/kelolaWali.css') }}">
    <link rel="stylesheet" href="{{ asset('css/min/kelolaSiswa.css') }}">
</head>

<body class="text-gray-800 dark:text-gray-200 bg-gray-100 dark:bg-gray-950 min-h-screen">
    <div class="flex h-screen overflow-hidden">
        @include('admin.layouts.sidebar')

        <div class="flex-1 flex flex-col md:ml-64 min-w-0">
            @include('admin.layouts.header', ['title' => 'Edit Pengumuman'])

            <main class="flex-1 min-h-0 overflow-y-auto p-4 sm:p-6">
                <div class="mb-4 sm:mb-6">
                    <a href="{{ route('admin.announcements.index') }}"
                        class="inline-flex items-center text-sm sm:text-base text-gray-600 dark:text-gray-400 hover:text-indigo-600 dark:hover:text-indigo-400 transition break-all">
                        <i class="fa-solid fa-arrow-left mr-2 shrink-0"></i>
                        <span class="min-w-0">Kembali ke daftar pengumuman</span>
                    </a>
                </div>

                <div
                    class="max-w-3xl w-full mx-auto bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
                    <div class="p-4 sm:p-6 border-b border-gray-200 dark:border-gray-700">
                        <h2 class="text-lg sm:text-xl font-bold text-gray-900 dark:text-white break-words">Edit pengumuman</h2>
                        <p class="text-gray-600 dark:text-gray-400 mt-1 text-sm sm:text-base">Perbarui informasi pengumuman</p>
                    </div>

                    <form action="{{ route('admin.announcements.update', $announcement->id) }}" method="POST"
                        class="p-4 sm:p-6 space-y-5 sm:space-y-6">
                        @csrf
                        @method('PUT')

                        <!-- Title -->
                        <div>
                            <label for="title"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Judul Pengumuman <span class="text-red-500">*</span>
                            </label>
                            <input type="text" id="title" name="title"
                                value="{{ old('title', $announcement->title) }}" required
                                class="w-full px-4 py-2 border border-red-500 dark:border-red-500 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-red-500 focus:border-transparent @error('title') border-red-500 @enderror"
                                placeholder="Masukkan judul pengumuman">
                            @error('title')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Content -->
                        <div>
                            <label for="content"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Isi Pengumuman <span class="text-red-500">*</span>
                            </label>
                            <textarea id="content" name="content" rows="8" required
                                class="w-full px-4 py-2 border border-red-500 dark:border-red-500 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-red-500 focus:border-transparent @error('content') border-red-500 @enderror"
                                placeholder="Masukkan isi pengumuman lengkap">{{ old('content', $announcement->content) }}</textarea>
                            @error('content')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Category -->
                            <div>
                                <label for="category"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Kategori <span class="text-red-500">*</span>
                                </label>
                                <select id="category" name="category" required
                                    class="w-full px-4 py-2 border border-red-500 dark:border-red-500 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-red-500 focus:border-transparent @error('category') border-red-500 @enderror">
                                    <option value="">Pilih Kategori</option>
                                    <option value="akademik"
                                        {{ old('category', $announcement->category) === 'akademik' ? 'selected' : '' }}>
                                        Akademik</option>
                                    <option value="umum"
                                        {{ old('category', $announcement->category) === 'umum' ? 'selected' : '' }}>
                                        Umum</option>
                                    <option value="kegiatan"
                                        {{ old('category', $announcement->category) === 'kegiatan' ? 'selected' : '' }}>
                                        Kegiatan</option>
                                </select>
                                @error('category')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Priority -->
                            <div>
                                <label for="priority"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Prioritas <span class="text-red-500">*</span>
                                </label>
                                <select id="priority" name="priority" required
                                    class="w-full px-4 py-2 border border-red-500 dark:border-red-500 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-red-500 focus:border-transparent @error('priority') border-red-500 @enderror">
                                    <option value="">Pilih Prioritas</option>
                                    <option value="high"
                                        {{ old('priority', $announcement->priority) === 'high' ? 'selected' : '' }}>
                                        Penting (High)</option>
                                    <option value="medium"
                                        {{ old('priority', $announcement->priority) === 'medium' ? 'selected' : '' }}>
                                        Informasi (Medium)</option>
                                    <option value="low"
                                        {{ old('priority', $announcement->priority) === 'low' ? 'selected' : '' }}>Umum
                                        (Low)</option>
                                </select>
                                @error('priority')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Author -->
                            <div>
                                <label for="author"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Penulis <span class="text-red-500">*</span>
                                </label>
                                <input type="text" id="author" name="author"
                                    value="{{ old('author', $announcement->author) }}" required
                                    class="w-full px-4 py-2 border border-red-500 dark:border-red-500 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-red-500 focus:border-transparent @error('author') border-red-500 @enderror"
                                    placeholder="Nama penulis pengumuman">
                                @error('author')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Date -->
                            <div>
                                <label for="date"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Tanggal <span class="text-red-500">*</span>
                                </label>
                                <input type="date" id="date" name="date"
                                    value="{{ old('date', $announcement->date->format('Y-m-d')) }}" required
                                    class="w-full px-4 py-2 border border-red-500 dark:border-red-500 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-red-500 focus:border-transparent @error('date') border-red-500 @enderror">
                                @error('date')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Is Active -->
                        <div>
                            <label class="flex items-center">
                                <input type="checkbox" name="is_active" value="1"
                                    {{ old('is_active', $announcement->is_active) ? 'checked' : '' }}
                                    class="w-4 h-4 text-red-600 border-red-500 rounded focus:ring-red-500">
                                <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">Aktifkan pengumuman
                                    (tampilkan ke pengguna)</span>
                            </label>
                        </div>

                        <!-- Submit Buttons -->
                        <div
                            class="flex items-center justify-end gap-4 pt-4 border-t border-gray-200 dark:border-gray-700">
                            <a href="{{ route('admin.announcements.index') }}"
                                class="px-6 py-2 border border-red-500 dark:border-red-500 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                                Batal
                            </a>
                            <button type="submit"
                                class="px-6 py-2 bg-red-600 hover:bg-red-700 text-white font-medium rounded-lg transition">
                                <i class="fa-solid fa-save mr-2"></i>
                                Perbarui Pengumuman
                            </button>
                        </div>
                    </form>
                </div>

            </main>
        </div>
    </div>

    <!-- Mobile Sidebar Overlay -->
    <div id="sidebarOverlay" class="fixed inset-0 bg-black/50 z-40 hidden md:hidden" onclick="closeSidebar()"></div>

    @if (session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: '{{ session('success') }}'
            });
        </script>
    @endif
    <script src="{{ asset('js/min/editPengum.js') }}"></script>
</body>
</html>
