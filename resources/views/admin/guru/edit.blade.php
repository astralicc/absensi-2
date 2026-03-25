<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit {{ $guru->name }} - Absensi SMKN 12 Jakarta</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css">
    <link rel="icon" href="/logo.png">
    <link rel="stylesheet" href="{{ asset('css/min/editSiswa.css') }}">
    <link rel="stylesheet" href="{{ asset('css/min/kelolaWali.css') }}">
</head>
<body class="bg-gray-50 dark:bg-gray-900">
    <div class="flex h-screen overflow-hidden">
    @include('admin.layouts.sidebar')

    <div class="flex-1 flex flex-col md:ml-64 min-w-0 min-h-0">
        <!-- Header -->
        @include('admin.layouts.header', ['title' => 'Edit Data Guru'])

        <main class="flex-1 min-h-0 overflow-y-auto p-4 sm:p-6">
            <div class="max-w-2xl w-full mx-auto px-1 sm:px-0">
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg border border-gray-200 dark:border-gray-700 overflow-hidden">
                    <div class="p-5 sm:p-8">
                        <div class="text-center mb-6 sm:mb-8">
                            <div class="w-16 h-16 sm:w-20 sm:h-20 bg-gradient-to-r from-indigo-500 to-blue-600 rounded-2xl flex items-center justify-center mx-auto mb-4 shadow-lg text-xl sm:text-2xl font-bold text-white">
                                {{ strtoupper(substr($guru->name, 0, 1)) }}
                            </div>
                            <h1 class="text-xl sm:text-3xl font-bold text-gray-900 dark:text-white mb-2 break-words px-1">Edit {{ $guru->name }}</h1>
                            <p class="text-gray-600 dark:text-gray-400">Perbarui informasi guru</p>
                        </div>

                        @if ($errors->any())
                            <div class="bg-red-50 border border-red-200 text-red-700 px-6 py-4 rounded-xl mb-8">
                                <ul class="list-disc list-inside space-y-1">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form method="POST" action="{{ route('admin.guru.update', $guru) }}" class="space-y-6">
                            @csrf
                            @method('PUT')
                            
                            <!-- Basic Info -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Nama Lengkap *</label>
                                    <input type="text" name="name" value="{{ old('name', $guru->name) }}" required 
                                           class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white transition">
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Jenis Kelamin</label>
                                    <select name="gender" class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white">
                                        <option value="">Pilih</option>
                                        <option value="L" {{ old('gender', $guru->gender) == 'L' ? 'selected' : '' }}>Laki-laki</option>
                                        <option value="P" {{ old('gender', $guru->gender) == 'P' ? 'selected' : '' }}>Perempuan</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Contact Info -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Email *</label>
                                    <input type="email" name="email" value="{{ old('email', $guru->email) }}" required 
                                           class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white transition">
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">No. Telepon</label>
                                    <input type="tel" name="phone" value="{{ old('phone', $guru->phone) }}" 
                                           class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white transition">
                                </div>
                            </div>

                            <!-- Password (Optional) -->
                            <div class="bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-200 dark:border-yellow-800 rounded-xl p-6">
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Ubah Password (Opsional)</h3>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 opacity-75">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Password Baru</label>
                                        <input type="password" name="password" 
                                               class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 dark:bg-gray-700 dark:text-white transition"
                                               placeholder="Kosongkan jika tidak diubah">
                                        <p class="text-xs text-gray-500 mt-1">Min. 8 karakter</p>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Konfirmasi Password</label>
                                        <input type="password" name="password_confirmation" 
                                               class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 dark:bg-gray-700 dark:text-white transition"
                                               placeholder="Ulangi password baru">
                                    </div>
                                </div>
                            </div>

                            <!-- Wali Kelas -->
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-4">Tugas Wali Kelas</label>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Kelas Wali</label>
                                        <select name="kelas_wali" class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white">
                                            <option value="">Tidak ditugaskan</option>
                                            <option value="X" {{ old('kelas_wali', $guru->kelas_wali) == 'X' ? 'selected' : '' }}>X</option>
                                            <option value="XI" {{ old('kelas_wali', $guru->kelas_wali) == 'XI' ? 'selected' : '' }}>XI</option>
                                            <option value="XII" {{ old('kelas_wali', $guru->kelas_wali) == 'XII' ? 'selected' : '' }}>XII</option>
                                        </select>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Jurusan Wali</label>
                                        <select name="jurusan_wali" class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white">
                                            <option value="">Tidak ditugaskan</option>
                                            <option value="RPL" {{ old('jurusan_wali', $guru->jurusan_wali) == 'RPL' ? 'selected' : '' }}>RPL</option>
                                            <option value="BR" {{ old('jurusan_wali', $guru->jurusan_wali) == 'BR' ? 'selected' : '' }}>BR</option>
                                            <option value="AKL" {{ old('jurusan_wali', $guru->jurusan_wali) == 'AKL' ? 'selected' : '' }}>AKL</option>
                                            <option value="MP" {{ old('jurusan_wali', $guru->jurusan_wali) == 'MP' ? 'selected' : '' }}>MP</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <!-- Actions -->
                            <div class="flex flex-col sm:flex-row gap-4 pt-6 border-t border-gray-200 dark:border-gray-700">
                                <a href="{{ route('admin.guru.index') }}" class="flex-1 sm:flex-none bg-gray-500 text-white py-3 px-6 rounded-xl hover:bg-gray-600 transition font-medium text-center">
                                    <i class="fa-solid fa-arrow-left mr-2"></i>Kembali ke Daftar
                                </a>
                                <button type="submit" class="flex-1 sm:flex-none bg-emerald-600 text-white py-3 px-6 rounded-xl hover:bg-emerald-700 transition font-semibold text-center shadow-lg">
                                    <i class="fa-solid fa-save mr-2"></i>Perbarui Data Guru
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </main>
    </div>
    </div>

    <div id="sidebarOverlay" class="fixed inset-0 bg-black/50 z-40 hidden md:hidden" onclick="closeSidebar()"></div>
    <script src="{{ asset('js/min/kelolaWali.js') }}"></script>
</body>
</html>
