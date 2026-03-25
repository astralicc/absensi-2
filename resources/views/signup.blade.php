<!DOCTYPE html>
<html lang="id" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar - Absensi SMKN 12 Jakarta</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css"
        integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="icon" href="logo.png">
    <link rel="stylesheet" href="{{ asset('css/pageLogin/login.css') }}">
</head>

<body
    class="text-gray-800 dark:text-gray-200 min-h-screen flex items-center justify-center bg-gray-100 dark:bg-gray-950 py-8">

    <!-- DARK TOGGLE - Top Right Corner -->
    <button onclick="toggleDark()" id="darkBtn"
        class="dark-toggle fixed top-6 right-6 z-9999 
    px-4 py-3 rounded-xl 
    bg-white/90 dark:bg-gray-800/90 
    backdrop-blur-md 
    border border-gray-200 dark:border-gray-600 
    shadow-xl 
    transition-all duration-300 ease-in-out 
    transform hover:scale-110 active:scale-95 
    hover:shadow-2xl">
        <span id="darkIcon" class="inline-block text-xl transition-transform duration-500 ease-in-out">🌙</span>
    </button>



    <!-- SIGNUP CARD -->
    <div
        class="w-full max-w-md p-8 bg-white dark:bg-gray-900 rounded-2xl shadow-xl border border-gray-200 dark:border-gray-700">

        <!-- Logo -->
        <div class="text-center mb-8">
            <img src="/assets/logo.png" alt="Logo" class="h-16 mx-auto mb-4">
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Daftar Akun</h1>
            <p class="text-gray-500 dark:text-gray-400 mt-2">Buat akun baru untuk mengakses sistem</p>
        </div>

        <!-- FORM -->
        <form action="{{ route('register') }}" method="POST" class="space-y-6" id="signupForm">
            @csrf

            <!-- Google Data Hidden Fields -->
            @if (session('google_signup_data'))
                <input type="hidden" name="google_id" id="googleId"
                    value="{{ session('google_signup_data.google_id') }}">
                <input type="hidden" name="google_token" id="googleToken"
                    value="{{ session('google_signup_data.google_token') }}">
                <input type="hidden" name="avatar" id="avatar" value="{{ session('google_signup_data.avatar') }}">
                <input type="hidden" name="nisn_from_google" id="nisnFromGoogle"
                    value="{{ session('google_signup_data.nisn') }}">
            @endif

            <!-- Error Messages -->
            @if ($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative z-10"
                    role="alert">
                    <ul class="list-disc list-inside text-sm">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Hidden Role Input -->
            <input type="hidden" name="role" id="roleInput" value="Murid">


            <!-- ROLE -->
            <div class="relative w-full z-20" id="roleDropdown">
                <!-- BUTTON -->
                <button type="button" id="dropdownBtn"
                    class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600
        bg-white dark:bg-gray-800 flex justify-between items-center
        transition hover:border-blue-500">
                    <span id="selectedRole" class="flex items-center gap-2">
                        <i class="fa-solid fa-user-graduate text-blue-500"></i> Murid
                    </span>
                    <i id="arrowIcon" class="fa-solid fa-chevron-down transition duration-300"></i>
                </button>

                <!-- MENU -->
                <div id="dropdownMenu"
                    class="absolute w-full mt-2 z-50
        bg-white/95 dark:bg-gray-900/95 backdrop-blur-xl
        border border-gray-200 dark:border-gray-700
        rounded-xl shadow-lg
        opacity-0 scale-95 -translate-y-2 pointer-events-none
        transition-all duration-300 origin-top">

                    <div
                        class="role-item p-3 cursor-pointer hover:bg-blue-50 dark:hover:bg-gray-800 flex gap-3 items-center">
                        <i class="fa-solid fa-user-graduate text-blue-500"></i> Murid
                    </div>

                    <div
                        class="role-item p-3 cursor-pointer hover:bg-blue-50 dark:hover:bg-gray-800 flex gap-3 items-center">
                        <i class="fa-solid fa-chalkboard-user text-green-500"></i> Guru
                    </div>

                    <div
                        class="role-item p-3 cursor-pointer hover:bg-blue-50 dark:hover:bg-gray-800 flex gap-3 items-center">
                        <i class="fa-solid fa-people-roof text-purple-500"></i> Orang Tua
                    </div>
                </div>
            </div>

            <!-- NAME -->
            <div>
                <label class="block text-sm font-medium mb-2">Nama Lengkap</label>
                <input name="name" id="nameInput" type="text" placeholder="Masukkan nama lengkap" required
                    value="{{ session('google_signup_data.name') ?? old('name') }}"
                    class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600
        bg-white dark:bg-gray-800 outline-none transition-opacity duration-150" />
            </div>

            <!-- EMAIL -->
            <div>
                <label class="block text-sm font-medium mb-2">Email</label>
                <input name="email" id="emailInput" type="email" placeholder="Masukkan email" required
                    value="{{ session('google_signup_data.email') ?? old('email') }}"
                    class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600
        bg-white dark:bg-gray-800 outline-none transition-opacity duration-150
        {{ session('google_signup_data.email') ? 'bg-gray-100 dark:bg-gray-700 cursor-not-allowed' : '' }}"
                    {{ session('google_signup_data.email') ? 'readonly' : '' }} />
                @if (session('google_signup_data.email'))
                    <p class="text-xs text-green-600 dark:text-green-400 mt-1">
                        <i class="fa-solid fa-check-circle"></i> Email terverifikasi dari Google
                    </p>
                @endif
            </div>


            <!-- NISN (Khusus Murid) -->
            <div id="nisnField">
                <label class="block text-sm font-medium mb-2">
                    NISN
                    <span class="text-xs text-gray-500 dark:text-gray-400 font-normal">(dari akun belajar)</span>
                </label>
                <input name="nisn" id="nisnInput" type="text" placeholder="Masukkan NISN dari akun belajar.id"
                    value="{{ session('google_signup_data.nisn') ?? old('nisn') }}"
                    class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600
        bg-white dark:bg-gray-800 outline-none transition-opacity duration-150
        {{ session('google_signup_data.nisn') ? 'bg-green-50 dark:bg-green-900/20 border-green-300 dark:border-green-600' : '' }}" />
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1" id="nisnHelpText">
                    * Wajib diisi untuk siswa, gunakan NISN dari akun belajar.id
                </p>
                @if (session('google_signup_data.nisn'))
                    <p class="text-xs text-green-600 dark:text-green-400 mt-1">
                        <i class="fa-solid fa-check-circle"></i> NISN terisi otomatis dari akun Google
                    </p>
                @endif
            </div>

            <div id="muridKelasJurusan" class="space-y-4">
                <div>
                    <label class="block text-sm font-medium mb-2">Kelas <span class="text-red-500">*</span></label>
                    <select name="class" id="signupClass"
                        class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 outline-none">
                        <option value="">Pilih kelas</option>
                        <option value="X" {{ old('class') == 'X' ? 'selected' : '' }}>X</option>
                        <option value="XI" {{ old('class') == 'XI' ? 'selected' : '' }}>XI</option>
                        <option value="XII" {{ old('class') == 'XII' ? 'selected' : '' }}>XII</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium mb-2">Jurusan <span class="text-red-500">*</span></label>
                    <select name="jurusan" id="signupJurusan"
                        class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 outline-none">
                        <option value="">Pilih jurusan</option>
                        <option value="RPL" {{ old('jurusan') == 'RPL' ? 'selected' : '' }}>RPL</option>
                        <option value="BR" {{ old('jurusan') == 'BR' ? 'selected' : '' }}>BR</option>
                        <option value="AKL" {{ old('jurusan') == 'AKL' ? 'selected' : '' }}>AKL</option>
                        <option value="MP" {{ old('jurusan') == 'MP' ? 'selected' : '' }}>MP</option>
                    </select>
                </div>
            </div>




            <!-- NAMA ANAK -->
            <div id="childNameField" class="hidden">
                <label class="block text-sm font-medium mb-2">Nama Anak</label>
                <input type="text" id="childName" name="child_name"
                    class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600
                    bg-white dark:bg-gray-800 outline-none"
                    placeholder="Masukkan nama anak">
            </div>

            <!-- PASSWORD -->
            <div>
                <label class="block text-sm font-medium mb-2">Password</label>
                <div class="relative">
                    <input type="password" name="password" id="passwordInput" required
                        class="w-full px-4 py-3 pr-12 rounded-lg border border-gray-300 dark:border-gray-600
                        bg-white dark:bg-gray-800 outline-none"
                        placeholder="••••••••">
                    <button type="button" id="togglePassword"
                        class="absolute right-3 top-1/2 -translate-y-1/2 p-2 text-gray-500 dark:text-gray-400 
                        hover:text-gray-700 dark:hover:text-gray-200 transition">
                        <i class="fa-solid fa-eye" id="eyeIcon"></i>
                    </button>
                </div>
            </div>

            <!-- PASSWORD CONFIRMATION -->
            <div>
                <label class="block text-sm font-medium mb-2">Konfirmasi Password</label>
                <input type="password" name="password_confirmation" required
                    class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600
        bg-white dark:bg-gray-800 outline-none"
                    placeholder="••••••••">
            </div>

            <!-- BUTTON -->
            <button
                class="w-full bg-blue-600 hover:bg-blue-700 text-white py-3 rounded-lg font-semibold shadow transition">
                Daftar
            </button>
        </form>

        <!-- Divider -->
        <div class="relative my-6">
            <div class="absolute inset-0 flex items-center">
                <div class="w-full border-t border-gray-300 dark:border-gray-600"></div>
            </div>
            <div class="relative flex justify-center text-sm">
                <span class="px-2 bg-white dark:bg-gray-900 text-gray-500 dark:text-gray-400">atau</span>
            </div>
        </div>

        <!-- Google Signup Button -->
        <a href="{{ route('google.signup') }}"
            class="w-full flex items-center justify-center gap-3 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 hover:bg-gray-50 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-300 py-3 rounded-lg font-medium shadow-sm transition-all duration-300 ease-in-out transform hover:scale-[1.02] active:scale-[0.98] hover:shadow-md">
            <svg class="w-5 h-5 transition-transform duration-300" viewBox="0 0 24 24"
                xmlns="http://www.w3.org/2000/svg">
                <path fill="#4285F4"
                    d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" />
                <path fill="#34A853"
                    d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" />
                <path fill="#FBBC05"
                    d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z" />
                <path fill="#EA4335"
                    d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" />
            </svg>
            <span class="transition-transform duration-300">Daftar dengan Google</span>
        </a>


        <!-- LOGIN LINK -->
        <div class="mt-6 text-center">
            <p class="text-sm text-gray-500 dark:text-gray-400">
                Sudah punya akun?
                <a href="{{ route('login') }}" class="text-blue-600 hover:underline">Login di sini</a>
            </p>
        </div>

        <!-- BACK -->
        <div class="mt-4 text-center">
            <a href="/" class="text-sm text-gray-500">← Kembali ke beranda</a>
        </div>
    </div>

</body>
<script src="{{ asset('js/pageLogin/login.js') }}"></script>

</html>
