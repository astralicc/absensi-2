<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Guru - Admin Panel</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="icon" href="/logo.png">
    <link rel="stylesheet" href="{{ asset('css/min/editSiswa.css') }}">
    <link rel="stylesheet" href="{{ asset('css/min/kelolaWali.css') }}">
</head>
<body class="bg-gray-50 dark:bg-gray-900">
    <div class="flex h-screen overflow-hidden">
    @include('admin.layouts.sidebar')

    <div class="flex-1 flex flex-col md:ml-64 min-w-0 min-h-0">
        <!-- Header -->
        @include('admin.layouts.header', ['title' => 'Tambah Data Guru'])

        <main class="flex-1 min-h-0 overflow-y-auto p-4 sm:p-6">
            <div class="max-w-2xl w-full mx-auto px-1 sm:px-0">
                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl border border-gray-200 dark:border-gray-700">
                    <div class="p-5 sm:p-8">
                        <h1 class="text-2xl sm:text-3xl font-bold text-gray-900 dark:text-white mb-2">Tambah Guru Baru</h1>
                        <p class="text-gray-600 dark:text-gray-400 mb-8">Isi data lengkap guru baru</p>

                        @if($errors->any())
                            <div class="mb-6 p-4 bg-red-100 dark:bg-red-900/30 border border-red-200 dark:border-red-800 rounded-xl">
                                <h3 class="font-semibold text-red-800 dark:text-red-200 mb-2">Ada kesalahan:</h3>
                                <ul class="list-disc list-inside space-y-1 text-sm">
                                    @foreach($errors->all() as $error)
                                        <li class="text-red-700 dark:text-red-300">{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="{{ route('admin.guru.store') }}" method="POST">
                            @csrf
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- Name -->
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                        Nama Lengkap <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" name="name" value="{{ old('name') }}" required
                                        class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white transition">
                                </div>

                                <!-- Email -->
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                        Email <span class="text-red-500">*</span>
                                    </label>
                                    <input type="email" name="email" value="{{ old('email') }}" required
                                        class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white transition">
                                </div>

                                <!-- Phone -->
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                        Nomor Telepon
                                    </label>
                                    <input type="tel" name="phone" value="{{ old('phone') }}"
                                        class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white transition">
                                </div>

                                <!-- Gender -->
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                        Jenis Kelamin
                                    </label>
                                    <select name="gender" class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white">
                                        <option value="">Pilih</option>
                                        <option value="L" {{ old('gender') == 'L' ? 'selected' : '' }}>Laki-laki</option>
                                        <option value="P" {{ old('gender') == 'P' ? 'selected' : '' }}>Perempuan</option>
                                    </select>
                                </div>

                                <!-- Kelas Wali -->
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                        Kelas Wali (Opsional)
                                    </label>
                                    <select name="kelas_wali" class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white">
                                        <option value="">Tidak ditugaskan</option>
                                        <option value="X" {{ old('kelas_wali') == 'X' ? 'selected' : '' }}>Kelas X</option>
                                        <option value="XI" {{ old('kelas_wali') == 'XI' ? 'selected' : '' }}>Kelas XI</option>
                                        <option value="XII" {{ old('kelas_wali') == 'XII' ? 'selected' : '' }}>Kelas XII</option>
                                    </select>
                                </div>

                                <!-- Jurusan Wali -->
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                        Jurusan Wali (Opsional)
                                    </label>
                                    <select name="jurusan_wali" class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white">
                                        <option value="">Tidak ditugaskan</option>
                                        <option value="RPL" {{ old('jurusan_wali') == 'RPL' ? 'selected' : '' }}>RPL</option>
                                        <option value="BR" {{ old('jurusan_wali') == 'BR' ? 'selected' : '' }}>BR</option>
                                        <option value="AKL" {{ old('jurusan_wali') == 'AKL' ? 'selected' : '' }}>AKL</option>
                                        <option value="MP" {{ old('jurusan_wali') == 'MP' ? 'selected' : '' }}>MP</option>
                                    </select>
                                </div>

                                <!-- Password -->
                                <div class="md:col-span-2">
                                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                        Password <span class="text-red-500">*</span>
                                    </label>
                                    <input type="password" name="password" required minlength="8"
                                        class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white transition">
                                </div>

                                <!-- Confirm Password -->
                                <div class="md:col-span-2">
                                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                        Konfirmasi Password <span class="text-red-500">*</span>
                                    </label>
                                    <input type="password" name="password_confirmation" required
                                        class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white transition">
                                </div>
                            </div>

                            <div class="flex justify-end gap-4 mt-10">
                                <a href="{{ route('admin.guru.index') }}" class="px-8 py-3 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 rounded-xl transition font-medium">
                                    <i class="fa-solid fa-arrow-left mr-2"></i>Batal
                                </a>
                                <button type="submit" class="px-8 py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold rounded-xl transition shadow-lg">
                                    <i class="fa-solid fa-save mr-2"></i>Simpan Guru
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </main>
    </div>
    </div>

    <!-- Mobile Sidebar Overlay -->
    <div id="sidebarOverlay" class="fixed inset-0 bg-black/50 z-40 hidden md:hidden" onclick="closeSidebar()"></div>
    
    <script src="{{ asset('js/min/kelolaWali.js') }}"></script>
</body>
</html>
