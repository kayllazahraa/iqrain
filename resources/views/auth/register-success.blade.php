<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrasi Berhasil - IQRAIN</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gradient-to-br from-blue-400 to-blue-600 min-h-screen flex items-center justify-center p-4">
    <div class="max-w-md w-full bg-white rounded-2xl shadow-2xl p-8 text-center">
        <div class="mb-6">
            <div class="w-24 h-24 bg-green-100 rounded-full mx-auto flex items-center justify-center mb-4">
                <svg class="w-12 h-12 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
            </div>
            <h1 class="text-4xl font-bold text-gray-800 mb-2">Selamat!</h1>
            <p class="text-xl text-gray-600 mb-4">
                Akun kamu sudah berhasil didaftarkan!
            </p>
            
            @if(session('message'))
                <p class="text-gray-700 mb-4">{{ session('message') }}</p>
            @endif
        </div>

        <a href="{{ route('login') }}" 
           class="inline-block bg-gradient-to-r from-pink-400 to-pink-500 hover:from-pink-500 hover:to-pink-600 text-white font-bold py-3 px-8 rounded-lg transition duration-300 transform hover:scale-105 shadow-lg">
            Mulai Belajar
        </a>
    </div>
</body>
</html>