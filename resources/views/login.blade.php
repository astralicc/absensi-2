<!DOCTYPE html>
<html lang="id" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Absensi SMKN 12 Jakarta</title>
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

    <!-- LOGIN CARD -->
    <div
        class="w-full max-w-md p-8 bg-white dark:bg-gray-900 rounded-2xl shadow-xl border border-gray-200 dark:border-gray-700">

        <!-- Logo -->
        <div class="text-center mb-8">
            <img src="/assets/logo.png" alt="Logo" class="h-16 mx-auto mb-4">
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Login Absensi</h1>
            <p class="text-gray-500 dark:text-gray-400 mt-2">Silakan login sesuai peran akun</p>
        </div>

        <!-- FORM -->
        <form action="{{ route('login') }}" method="POST" class="space-y-6">
            @csrf

            <!-- Error Messages - Moved to top -->
            @if ($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative z-10" role="alert">
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

            <!-- NIP / NISN -->
            <div>
                <label id="dynamicLabel" class="block text-sm font-medium mb-2">NISN</label>
                <input id="dynamicInput" name="identifier" type="text" placeholder="Masukkan NISN" required
                    class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600
        bg-white dark:bg-gray-800 outline-none transition-opacity duration-150" />
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

            <!-- REMEMBER -->
            <div class="flex justify-between items-center text-sm">
                <label class="flex items-center gap-2">
                    <input type="checkbox" name="remember" value="1"> Ingat saya
                </label>
                <div class="flex gap-3">
                    <a href="{{ route('signup') }}" class="text-blue-600 hover:underline">Daftar</a>
                    <span class="text-gray-400">|</span>
                    <a href="#" class="text-blue-600 hover:underline">Lupa password?</a>
                </div>
            </div>

            <!-- BUTTON -->
            <button
                class="w-full bg-blue-600 hover:bg-blue-700 text-white py-3 rounded-lg font-semibold shadow transition">
                Masuk
            </button>
        </form>



        <!-- BACK -->
        <div class="mt-6 text-center">
            <a href="/" class="text-sm text-gray-500">← Kembali ke beranda</a>
        </div>
    </div>

</body>
<script src="{{ asset('js/pageLogin/login.js') }}"></script>
</html>
