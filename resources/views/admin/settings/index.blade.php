<!DOCTYPE html>
<html lang="id" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Website Settings - Admin Panel</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
       
    </script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css"
        integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="icon" href="/logo.png">
    <link rel="stylesheet" href="/css/min/min.css">
    <link rel="stylesheet" href="{{ asset('css/min/kelolaWali.css') }}">
    <link rel="stylesheet" href="{{ asset('css/min/kelolaSiswa.css') }}">
</head>

<body class="text-gray-800 dark:text-gray-200 bg-gray-100 dark:bg-gray-950 min-h-screen">
    <div class="flex h-screen overflow-hidden">
        @include('admin.layouts.sidebar')

        <div class="flex-1 flex flex-col md:ml-64 min-w-0">
            @include('admin.layouts.header', ['title' => 'Website Settings'])

            <main class="flex-1 min-h-0 overflow-y-auto p-4 sm:p-6">
                <div class="relative overflow-hidden rounded-2xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 mb-8 shadow-sm">
                    <div class="absolute inset-0 bg-gradient-to-br from-indigo-500/10 via-violet-500/5 to-transparent pointer-events-none"></div>
                    <div class="relative p-6 sm:p-8">
                        <p class="text-xs font-semibold uppercase tracking-wider text-indigo-600 dark:text-indigo-400">Konfigurasi</p>
                        <h2 class="text-2xl sm:text-3xl font-bold text-gray-900 dark:text-white mt-1">Pengaturan website</h2>
                        <p class="text-gray-600 dark:text-gray-400 mt-2 max-w-2xl">Kelola kontak admin dan informasi sekolah untuk sistem absensi.</p>
                    </div>
                </div>

                @if(session('success'))
                    <div class="mb-6 p-4 bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-xl">
                        <div class="flex items-center gap-3">
                            <i class="fa-solid fa-check-circle text-green-600 dark:text-green-400"></i>
                            <span class="text-green-800 dark:text-green-400">{{ session('success') }}</span>
                        </div>
                    </div>
                @endif

                <!-- Settings Form -->
                <div class="max-w-3xl w-full mx-auto bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
                    <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                        <h2 class="text-xl font-bold text-gray-900 dark:text-white">Pengaturan Kontak Admin</h2>
                        <p class="text-gray-600 dark:text-gray-400 mt-1">Atur kontak yang akan digunakan untuk laporan dari siswa</p>
                    </div>
                    
                    <form action="{{ route('admin.settings.update') }}" method="POST" class="p-6 space-y-6">
                        @csrf
                        
                        <!-- Admin WhatsApp -->
                        <div>
                            <label for="admin_whatsapp" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                <i class="fa-brands fa-whatsapp text-green-600 mr-2"></i>
                                Nomor WhatsApp Admin
                            </label>
                            <input type="text" id="admin_whatsapp" name="admin_whatsapp" 
                                value="{{ old('admin_whatsapp', $settings['admin_whatsapp'] ?? '081234567890') }}"
                                class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-indigo-500 focus:border-transparent @error('admin_whatsapp') border-red-500 @enderror"
                                placeholder="Contoh: 081234567890">
                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                                Nomor ini akan digunakan untuk menerima laporan via WhatsApp
                            </p>
                            @error('admin_whatsapp')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Admin Email -->
                        <div>
                            <label for="admin_email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                <i class="fa-solid fa-envelope text-blue-600 mr-2"></i>
                                Email Admin
                            </label>
                            <input type="email" id="admin_email" name="admin_email" 
                                value="{{ old('admin_email', $settings['admin_email'] ?? 'admin@smkn12jakarta.sch.id') }}"
                                class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-indigo-500 focus:border-transparent @error('admin_email') border-red-500 @enderror"
                                placeholder="Contoh: admin@smkn12jakarta.sch.id">
                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                                Email ini akan digunakan untuk menerima laporan via Email
                            </p>
                            @error('admin_email')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="border-t border-gray-200 dark:border-gray-700 pt-6">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Informasi Sekolah</h3>
                            
                            <!-- School Name -->
                            <div class="mb-4">
                                <label for="school_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    <i class="fa-solid fa-school text-purple-600 mr-2"></i>
                                    Nama Sekolah
                                </label>
                                <input type="text" id="school_name" name="school_name" 
                                    value="{{ old('school_name', $settings['school_name'] ?? 'SMKN 12 Jakarta') }}"
                                    class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-indigo-500 focus:border-transparent @error('school_name') border-red-500 @enderror"
                                    placeholder="Nama Sekolah">
                                @error('school_name')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- School Address -->
                            <div class="mb-4">
                                <label for="school_address" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    <i class="fa-solid fa-location-dot text-red-600 mr-2"></i>
                                    Alamat Sekolah
                                </label>
                                <textarea id="school_address" name="school_address" rows="2"
                                    class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-indigo-500 focus:border-transparent @error('school_address') border-red-500 @enderror"
                                    placeholder="Alamat lengkap sekolah">{{ old('school_address', $settings['school_address'] ?? '') }}</textarea>
                                @error('school_address')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- School Phone -->
                            <div>
                                <label for="school_phone" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    <i class="fa-solid fa-phone text-green-600 mr-2"></i>
                                    Telepon Sekolah
                                </label>
                                <input type="text" id="school_phone" name="school_phone" 
                                    value="{{ old('school_phone', $settings['school_phone'] ?? '') }}"
                                    class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-indigo-500 focus:border-transparent @error('school_phone') border-red-500 @enderror"
                                    placeholder="Nomor telepon sekolah">
                                @error('school_phone')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Submit Buttons -->
                        <div class="flex flex-col-reverse sm:flex-row items-stretch sm:items-center justify-end gap-3 pt-6 border-t border-gray-200 dark:border-gray-700">
                            <button type="reset" 
                                class="px-6 py-3 sm:py-2 min-h-[44px] border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 rounded-xl hover:bg-gray-50 dark:hover:bg-gray-700 transition touch-manipulation">
                                Reset
                            </button>
                            <button type="submit" 
                                class="px-6 py-3 sm:py-2.5 min-h-[44px] bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl transition flex items-center justify-center gap-2 shadow-lg shadow-indigo-500/20 touch-manipulation">
                                <i class="fa-solid fa-save"></i>
                                Simpan Pengaturan
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Preview Card -->
                <div class="max-w-3xl mx-auto mt-6 bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
                    <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                        <h2 class="text-lg font-bold text-gray-900 dark:text-white">Preview Kontak</h2>
                        <p class="text-gray-600 dark:text-gray-400 mt-1">Tampilan kontak yang akan dilihat oleh siswa</p>
                    </div>
                    <div class="p-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="p-4 bg-green-50 dark:bg-green-900/20 rounded-xl border border-green-200 dark:border-green-800">
                                <div class="flex items-center gap-3 mb-2">
                                    <i class="fa-brands fa-whatsapp text-green-600 text-2xl"></i>
                                    <span class="font-medium text-gray-700 dark:text-gray-300">WhatsApp</span>
                                </div>
                                <p class="text-lg font-semibold text-gray-900 dark:text-white">{{ $settings['admin_whatsapp'] ?? '081234567890' }}</p>
                            </div>
                            <div class="p-4 bg-blue-50 dark:bg-blue-900/20 rounded-xl border border-blue-200 dark:border-blue-800">
                                <div class="flex items-center gap-3 mb-2">
                                    <i class="fa-solid fa-envelope text-blue-600 text-2xl"></i>
                                    <span class="font-medium text-gray-700 dark:text-gray-300">Email</span>
                                </div>
                                <p class="text-lg font-semibold text-gray-900 dark:text-white break-all">{{ $settings['admin_email'] ?? 'admin@smkn12jakarta.sch.id' }}</p>
                            </div>
                        </div>
                    </div>
                </div>

            </main>
        </div>
    </div>
    
    <!-- Mobile Sidebar Overlay -->
    <div id="sidebarOverlay" class="fixed inset-0 bg-black/50 z-40 hidden md:hidden" onclick="closeSidebar()"></div>
    
</body>
<script src="{{ asset('js/min/kelolaWali.js') }}"></script>
</html>
