<!DOCTYPE html>
<html lang="id" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Siswa - Admin Panel</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
       
    </script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css"
        integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="icon" href="/logo.png">
    <link rel="stylesheet" href="{{ asset('css/min/tambahSiswa.css') }}">
    <link rel="stylesheet" href="{{ asset('css/min/kelolaSiswa.css') }}">
    <link rel="stylesheet" href="{{ asset('css/min/kelolaWali.css') }}">
</head>

<body class="text-gray-800 dark:text-gray-200 bg-gray-100 dark:bg-gray-950 min-h-screen">
    <div class="flex h-screen overflow-hidden">
        @include('admin.layouts.sidebar')

        <div class="flex-1 flex flex-col md:ml-64 min-w-0">
            @include('admin.layouts.header', ['title' => 'Tambah Data Siswa'])
            
            <main class="flex-1 min-h-0 overflow-y-auto p-4 sm:p-6">
                <div class="relative overflow-hidden rounded-2xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 mb-6 shadow-sm">
                    <div class="absolute inset-0 bg-gradient-to-br from-indigo-500/10 via-violet-500/5 to-transparent pointer-events-none"></div>
                    <div class="relative p-6 sm:p-8 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                        <div>
                            <p class="text-xs font-semibold uppercase tracking-wider text-indigo-600 dark:text-indigo-400">Data murid</p>
                            <h1 class="text-xl sm:text-2xl font-bold text-gray-900 dark:text-white mt-1">Tambah siswa baru</h1>
                        </div>
                        <a href="{{ route('admin.students.index') }}" class="inline-flex items-center gap-2 text-sm text-gray-600 dark:text-gray-400 hover:text-indigo-600 dark:hover:text-indigo-400 transition shrink-0">
                            <i class="fa-solid fa-arrow-left"></i> Kembali ke daftar
                        </a>
                    </div>
                </div>

                @if($errors->any())
                    <div class="mb-6 p-4 bg-red-100 dark:bg-red-900/30 border border-red-200 dark:border-red-800 rounded-lg">
                        <ul class="list-disc list-inside text-red-800 dark:text-red-200">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                    <form action="{{ route('admin.students.store') }}" method="POST">
                        @csrf
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Name -->
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Nama Lengkap <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="name" id="name" value="{{ old('name') }}" required
                                    class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 outline-none transition">
                            </div>

                            <!-- Email -->
                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Email <span class="text-red-500">*</span>
                                </label>
                                <input type="email" name="email" id="email" value="{{ old('email') }}" required
                                    class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 outline-none transition">
                            </div>

                            <!-- NISN -->
                            <div>
                                <label for="nisn" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    NISN
                                </label>
                                <input type="text" name="nisn" id="nisn" value="{{ old('nisn') }}"
                                    class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 outline-none transition">
                            </div>

                            <!-- Password -->
                            <div>
                                <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Password <span class="text-red-500">*</span>
                                </label>
                                <input type="password" name="password" id="password" required
                                    class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 outline-none transition">
                            </div>

                            <!-- Confirm Password -->
                            <div>
                                <label for="password_confirmation" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Konfirmasi Password <span class="text-red-500">*</span>
                                </label>
                                <input type="password" name="password_confirmation" id="password_confirmation" required
                                    class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 outline-none transition">
                            </div>

                            <!-- Phone -->
                            <div>
                                <label for="phone" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    No. Telepon
                                </label>
                                <input type="text" name="phone" id="phone" value="{{ old('phone') }}"
                                    class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 outline-none transition">
                            </div>

                            <!-- Gender -->
                            <div>
                                <label for="gender" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Jenis Kelamin
                                </label>
                                <select name="gender" id="gender"
                                    class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 outline-none transition">
                                    <option value="">Pilih Jenis Kelamin</option>
                                    <option value="L" {{ old('gender') == 'L' ? 'selected' : '' }}>Laki-laki</option>
                                    <option value="P" {{ old('gender') == 'P' ? 'selected' : '' }}>Perempuan</option>
                                </select>
                            </div>

                            <!-- Birth Date -->
                            <div>
                                <label for="birth_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Tanggal Lahir
                                </label>
                                <input type="date" name="birth_date" id="birth_date" value="{{ old('birth_date') }}"
                                    class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 outline-none transition">
                            </div>

                            <!-- Class -->
                            <div>
                                <label for="class" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Kelas <span class="text-red-500">*</span>
                                </label>
                                <select name="class" id="class" required
                                    class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 outline-none transition">
                                    <option value="">Pilih Kelas</option>
                                    <option value="X" {{ old('class') == 'X' ? 'selected' : '' }}>X</option>
                                    <option value="XI" {{ old('class') == 'XI' ? 'selected' : '' }}>XI</option>
                                    <option value="XII" {{ old('class') == 'XII' ? 'selected' : '' }}>XII</option>
                                </select>
                            </div>

                            <!-- Jurusan -->
                            <div>
                                <label for="jurusan" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Jurusan <span class="text-red-500">*</span>
                                </label>
                                <select name="jurusan" id="jurusan" required
                                    class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 outline-none transition">
                                    <option value="">Pilih Jurusan</option>
                                    <option value="RPL" {{ old('jurusan') == 'RPL' ? 'selected' : '' }}>RPL</option>
                                    <option value="BR" {{ old('jurusan') == 'BR' ? 'selected' : '' }}>BR</option>
                                    <option value="AKL" {{ old('jurusan') == 'AKL' ? 'selected' : '' }}>AKL</option>
                                    <option value="MP" {{ old('jurusan') == 'MP' ? 'selected' : '' }}>MP</option>
                                </select>
                            </div>

                            <!-- Address -->
                            <div class="md:col-span-2">
                                <label for="address" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Alamat
                                </label>
                                <textarea name="address" id="address" rows="3"
                                    class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 outline-none transition">{{ old('address') }}</textarea>
                            </div>
                        </div>

                        <div class="mt-6 flex justify-end gap-3">
                            <a href="{{ route('admin.students.index') }}" class="px-6 py-3 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-300 rounded-lg font-medium transition">
                                Batal
                            </a>
                            <button type="submit" class="px-6 py-3 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl font-medium transition shadow-lg shadow-indigo-500/20">
                                <i class="fa-solid fa-save mr-2"></i>Simpan
                            </button>
                        </div>
                    </form>
                </div>

            </main>
        </div>
    </div>
    
    <div id="sidebarOverlay" class="fixed inset-0 bg-black/50 z-40 hidden md:hidden" onclick="closeSidebar()"></div>
    
    
</body>
<script src="{{ asset('js/min/tambahSiswa.js') }}"></script>
</html>
