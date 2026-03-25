<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logout - Absensi SMKN 12 Jakarta</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css"
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

    <!-- LOGOUT CARD -->
    <div class="w-full max-w-md p-8 bg-white dark:bg-gray-900 rounded-2xl shadow-xl border border-gray-200 dark:border-gray-700">
        <div class="text-center mb-8">
            <i class="fa-solid fa-right-from-bracket text-red-500 text-4xl mb-4"></i>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Anda sudah keluar</h1>
            <p class="text-gray-500 dark:text-gray-400 mt-2">Silakan login kembali untuk melanjutkan.</p>
        </div>

        <div class="space-y-4">
            <a href="{{ route('login') }}"
                class="block w-full bg-blue-600 hover:bg-blue-700 text-white py-3 rounded-lg font-semibold shadow transition text-center">
                Kembali ke Login
            </a>

            <a href="{{ route('home') }}"
                class="block w-full text-center text-sm text-gray-500 dark:text-gray-400 hover:underline">
                Kembali ke beranda
            </a>
        </div>
    </div>

</body>

<script src="{{ asset('js/pageLogin/login.js') }}"></script>
</html>

