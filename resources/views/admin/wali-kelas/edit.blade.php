<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Wali Kelas - Absensi SMKN 12 Jakarta</title>
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
            @include('admin.layouts.header', ['title' => 'Edit Wali Kelas'])

            <main class="flex-1 min-h-0 overflow-y-auto p-4 sm:p-6">
                <div class="max-w-2xl mx-auto">
                    <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-200 dark:border-gray-700 shadow-sm p-8">
                        <div class="mb-8">
                            <a href="{{ route('admin.wali-kelas.index') }}" class="inline-flex items-center text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white">
                                <i class="fa-solid fa-arrow-left mr-2"></i>
                                Kembali ke Daftar Wali Kelas
                            </a>
                        </div>

                        <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">Edit Penugasan Wali Kelas</h2>

                        <div class="bg-gradient-to-r from-indigo-500 to-blue-600 text-white p-6 rounded-xl mb-8">
                            <div class="flex items-center gap-4">
                                <div class="h-16 w-16 bg-white/20 backdrop-blur-sm rounded-2xl flex items-center justify-center font-bold text-xl shadow-lg">
                                    {{ strtoupper(substr($guru->name, 0, 1)) }}
                                </div>
                                <div>
                                    <h3 class="text-xl font-bold mb-1">{{ $guru->name }}</h3>
                                    <p class="opacity-90 text-sm">{{ $guru->email }}</p>
                                </div>
                            </div>
                        </div>

                        <form method="POST" action="{{ route('admin.wali-kelas.update', $guru) }}">
                            @csrf
                            @method('PUT')

                            <div class="space-y-6">
                                <div>
                                    <label for="kelas_wali" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        Kelas Wali
                                    </label>
                                    <select id="kelas_wali" name="kelas_wali" class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-xl bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition">
                                        <option value="">Tidak ditugaskan</option>
                                        <option value="X" {{ old('kelas_wali', $guru->kelas_wali) == 'X' ? 'selected' : '' }}>X</option>
                                        <option value="XI" {{ old('kelas_wali', $guru->kelas_wali) == 'XI' ? 'selected' : '' }}>XI</option>
                                        <option value="XII" {{ old('kelas_wali', $guru->kelas_wali) == 'XII' ? 'selected' : '' }}>XII</option>
                                    </select>
                                    @error('kelas_wali')
                                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="jurusan_wali" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        Jurusan Wali
                                    </label>
                                    <select id="jurusan_wali" name="jurusan_wali" class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-xl bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition">
                                        <option value="">Tidak ditugaskan</option>
                                        <option value="RPL" {{ old('jurusan_wali', $guru->jurusan_wali) == 'RPL' ? 'selected' : '' }}>RPL</option>
                                        <option value="BR" {{ old('jurusan_wali', $guru->jurusan_wali) == 'BR' ? 'selected' : '' }}>BR</option>
                                        <option value="AKL" {{ old('jurusan_wali', $guru->jurusan_wali) == 'AKL' ? 'selected' : '' }}>AKL</option>
                                        <option value="MP" {{ old('jurusan_wali', $guru->jurusan_wali) == 'MP' ? 'selected' : '' }}>MP</option>
                                    </select>
                                    @error('jurusan_wali')
                                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="flex gap-4 mt-10 pt-8 border-t border-gray-200 dark:border-gray-700">
                                <a href="{{ route('admin.wali-kelas.index') }}" class="flex-1 text-center py-3 px-8 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 rounded-xl hover:bg-gray-50 dark:hover:bg-gray-700 transition font-medium">
                                    <i class="fa-solid fa-arrow-left mr-2"></i>
                                    Kembali
                                </a>
                                <button type="submit" class="flex-1 py-3 px-8 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl transition font-medium shadow-sm hover:shadow-md flex items-center justify-center gap-2">
                                    <i class="fa-solid fa-save"></i>
                                    Simpan Perubahan
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <div id="sidebarOverlay" class="fixed inset-0 bg-black/50 z-40 hidden md:hidden" onclick="closeSidebar()"></div>
    <script src="{{ asset('js/min/kelolaWali.js') }}"></script>
</body>
</html>
