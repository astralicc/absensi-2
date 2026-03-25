<!DOCTYPE html>
<html lang="id" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - Absensi SMKN 12 Jakarta</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css"
        integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="icon" href="/logo.png">
    <link rel="stylesheet" href="{{ asset('css/min/kelolaWali.css') }}">
    <link rel="stylesheet" href="{{ asset('js/min/loginAdmin.js') }}">
</head>

<body
    class="text-gray-800 dark:text-gray-200 min-h-screen flex items-center justify-center bg-gray-100 dark:bg-gray-950 py-8">

    <!-- LOGIN CARD -->
    <div
        class="w-full max-w-md p-8 bg-white dark:bg-gray-900 rounded-2xl shadow-xl border border-gray-200 dark:border-gray-700">

        <!-- Logo -->
        <div class="text-center mb-8">
            <div class="w-16 h-16 mx-auto mb-4 bg-red-600 rounded-full flex items-center justify-center">
                <i class="fa-solid fa-shield-halved text-white text-2xl"></i>
            </div>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Admin Login</h1>
            <p class="text-gray-500 dark:text-gray-400 mt-2">Akses terbatas untuk administrator</p>
        </div>

        <!-- FORM -->
        <form action="{{ route('admin.login.post') }}" method="POST" class="space-y-6">
            @csrf

            <!-- Error Messages -->
            @if ($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                    <ul class="list-disc list-inside text-sm">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- EMAIL -->
            <div>
                <label class="block text-sm font-medium mb-2">Email Admin</label>
                <input type="email" name="email" required
                    class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600
                    bg-white dark:bg-gray-800 outline-none focus:border-red-500 transition"
                    placeholder="admin@school.sch.id" />
            </div>

            <!-- PASSWORD -->
            <div>
                <label class="block text-sm font-medium mb-2">Password</label>
                <div class="relative">
                    <input type="password" name="password" id="passwordInput" required
                        class="w-full px-4 py-3 pr-12 rounded-lg border border-gray-300 dark:border-gray-600
                        bg-white dark:bg-gray-800 outline-none focus:border-red-500 transition"
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
            </div>

            <!-- BUTTON -->
            <button
                class="w-full bg-red-600 hover:bg-red-700 text-white py-3 rounded-lg font-semibold shadow transition">
                <i class="fa-solid fa-lock mr-2"></i> Login Admin
            </button>
        </form>

        <!-- BACK -->
        <div class="mt-6 text-center">
            <a href="/" class="text-sm text-gray-500 hover:text-gray-700">
                <i class="fa-solid fa-arrow-left mr-1"></i> Kembali ke beranda
            </a>
        </div>
    </div>

    
    
</body>
<script src="{{ asset('js/min/loginAdmin.js') }}"></script>
</html>
