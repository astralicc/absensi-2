<!DOCTYPE html>
<html lang="id" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lengkapi Data - Absensi SMKN 12 Jakarta</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css"
        integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="icon" href="/logo.png">
    <link rel="stylesheet" href="{{ asset('css/dashboard/lengkapiData.css') }}">
</head>

<body class="text-gray-800 dark:text-gray-200 bg-gray-100 dark:bg-gray-950 min-h-screen flex items-center justify-center p-4">
    
    <div class="w-full max-w-lg">
        <!-- Logo -->
        <div class="text-center mb-8">
            <img src="/assets/logo.png" alt="Logo" class="h-16 w-auto mx-auto mb-4">
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Lengkapi Data Anda</h1>
            <p class="text-gray-600 dark:text-gray-400 mt-2">Silakan lengkapi data berikut untuk melanjutkan</p>
        </div>

        <!-- Form Card -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-200 dark:border-gray-700 p-8">
            
            @if($errors->any())
                <div class="mb-6 p-4 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-lg">
                    <div class="flex items-center mb-2">
                        <i class="fa-solid fa-circle-exclamation text-red-600 dark:text-red-400 mr-2"></i>
                        <span class="font-medium text-red-800 dark:text-red-200">Terjadi kesalahan:</span>
                    </div>
                    <ul class="text-sm text-red-600 dark:text-red-400 ml-6 list-disc">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('complete-profile.post') }}" method="POST" class="space-y-6">
                @csrf

                <!-- Google Info Display -->
                <div class="p-4 bg-blue-50 dark:bg-blue-900/20 rounded-lg border border-blue-200 dark:border-blue-800">
                    <div class="flex items-center gap-3">
                        @if(session('google_avatar'))
                            <img src="{{ session('google_avatar') }}" alt="Avatar" class="h-12 w-12 rounded-full">
                        @else
                            <div class="h-12 w-12 rounded-full bg-blue-500 flex items-center justify-center text-white font-bold text-lg">
                                {{ strtoupper(substr(session('google_name', 'U'), 0, 1)) }}
                            </div>
                        @endif
                        <div>
                            <p class="font-medium text-gray-900 dark:text-white">{{ session('google_name') }}</p>
                            <p class="text-sm text-gray-500 dark:text-gray-400">{{ session('google_email') }}</p>
                        </div>
                    </div>
                </div>

                <!-- Role Selection -->
                <div>
                    <label for="role" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Peran <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <select name="role" id="role" required
                            class="w-full px-4 py-3 pr-10 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 appearance-none transition"
                            onchange="toggleRoleFields()">
                            <option value="">Pilih Peran</option>
                            <option value="Murid" {{ old('role') == 'Murid' ? 'selected' : '' }}>Murid (Siswa)</option>
                            <option value="Guru" {{ old('role') == 'Guru' ? 'selected' : '' }}>Guru</option>
                            <option value="Orang Tua" {{ old('role') == 'Orang Tua' ? 'selected' : '' }}>Orang Tua</option>
                        </select>
                        <i class="fa-solid fa-chevron-down absolute right-2 top-1/2 -translate-y-1/2 text-gray-500 dark:text-gray-400 pointer-events-none"></i>
                    </div>
                </div>

                <!-- Identifier (NIS/NIP/ID) -->
                <div>
                    <label for="identifier" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        <span id="identifier-label">Nomor Identitas</span> <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fa-solid fa-id-card text-gray-400"></i>
                        </div>
                        <input type="text" name="identifier" id="identifier" required
                            class="w-full pl-10 pr-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition"
                            placeholder="Masukkan nomor identitas"
                            value="{{ old('identifier') }}">
                    </div>
                    <p class="mt-1 text-xs text-gray-500 dark:text-gray-400" id="identifier-hint">
                        NIS untuk siswa, NIP untuk guru, atau ID untuk orang tua
                    </p>
                </div>

                <!-- NISN Field (Only for Murid) -->
                <div id="nisn-field" class="hidden">
                    <label for="nisn" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        NISN <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fa-solid fa-hashtag text-gray-400"></i>
                        </div>
                        <input type="text" name="nisn" id="nisn"
                            class="w-full pl-10 pr-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition"
                            placeholder="Masukkan NISN (10 digit)"
                            value="{{ old('nisn', session('google_nisn')) }}">
                    </div>
                    <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                        Nomor Induk Siswa Nasional (10 digit)
                    </p>
                </div>

                <!-- Child Name Field (Only for Orang Tua) -->
                <div id="child-field" class="hidden">
                    <label for="child_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Nama Anak <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fa-solid fa-child text-gray-400"></i>
                        </div>
                        <input type="text" name="child_name" id="child_name"
                            class="w-full pl-10 pr-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition"
                            placeholder="Masukkan nama anak"
                            value="{{ old('child_name') }}">
                    </div>
                </div>

                <!-- Hidden Google Data -->
                <input type="hidden" name="google_id" value="{{ session('google_id') }}">
                <input type="hidden" name="google_token" value="{{ session('google_token') }}">
                <input type="hidden" name="google_avatar" value="{{ session('google_avatar') }}">

                <!-- Submit Button -->
                <button type="submit" 
                    class="w-full py-3 px-4 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition duration-200 flex items-center justify-center gap-2">
                    <i class="fa-solid fa-check"></i>
                    Simpan & Lanjutkan
                </button>

                <!-- Cancel Link -->
                <div class="text-center">
                    <a href="{{ route('logout') }}" 
                        class="text-sm text-gray-500 dark:text-gray-400 hover:text-red-600 dark:hover:text-red-400 transition">
                        Batal dan Logout
                    </a>
                </div>
            </form>
        </div>

        <!-- Footer -->
        <p class="text-center text-sm text-gray-500 dark:text-gray-400 mt-6">
            &copy; {{ date('Y') }} Absensi SMKN 12 Jakarta. All rights reserved.
        </p>
    </div>

    
</body>
<script src="{{ asset('js/main/lengkapiData.js') }}"></script>
</html>
