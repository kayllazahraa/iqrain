<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Murid - IQRAIN</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gradient-to-br from-blue-400 to-blue-600 min-h-screen flex items-center justify-center p-4">
    <div class="w-full max-w-5xl flex bg-white rounded-3xl shadow-2xl overflow-hidden">
        <!-- Left Side - Mascot -->
        <div class="hidden md:flex md:w-1/2 bg-gradient-to-br from-blue-100 to-white items-center justify-center p-12 relative">
            <div class="absolute top-0 left-0 w-full h-full opacity-10">
                <!-- Decorative pattern -->
                <svg class="w-full h-full" xmlns="http://www.w3.org/2000/svg">
                    <pattern id="pattern" x="0" y="0" width="100" height="100" patternUnits="userSpaceOnUse">
                        <circle cx="25" cy="25" r="20" fill="#FF69B4" opacity="0.3"/>
                        <rect x="60" y="10" width="30" height="30" fill="#FFD700" opacity="0.3" rx="5"/>
                        <path d="M 10 70 Q 30 50, 50 70" stroke="#87CEEB" stroke-width="4" fill="none" opacity="0.3"/>
                    </pattern>
                    <rect width="100%" height="100%" fill="url(#pattern)"/>
                </svg>
            </div>
            <div class="relative z-10 text-center">
                <img src="{{ asset('images/qira-mascot.png') }}" alt="Qira Mascot" class="w-64 h-auto mx-auto mb-4">
                <h2 class="text-2xl font-bold text-gray-800">Ayo Bergabung!</h2>
            </div>
        </div>

        <!-- Right Side - Registration Form -->
        <div class="w-full md:w-1/2 p-12">
            <div class="text-center mb-8">
                <h1 class="text-4xl font-bold text-blue-600 mb-2">Buat Akun Baru</h1>
                <div class="flex justify-center space-x-2 mb-4">
                    <span class="text-2xl">😊</span>
                    <span class="text-2xl">📝</span>
                    <span class="text-2xl">✨</span>
                </div>
                
                <!-- Progress Indicator -->
                <div class="flex justify-center items-center space-x-2 mt-4">
                    <div class="w-8 h-8 rounded-full bg-blue-500 text-white flex items-center justify-center font-bold">1</div>
                    <div class="w-12 h-1 bg-gray-300"></div>
                    <div class="w-8 h-8 rounded-full bg-gray-300 text-gray-500 flex items-center justify-center font-bold">2</div>
                </div>
                <p class="text-sm text-gray-600 mt-2">Langkah 1 dari 2: Data Akun</p>
            </div>

            <!-- Role Toggle -->
            <div class="flex justify-center mb-6">
                <div class="inline-flex rounded-lg border border-gray-300 p-1">
                    <a href="{{ route('register.murid') }}" 
                       class="px-6 py-2 rounded-md bg-pink-400 text-white font-medium">
                        Murid
                    </a>
                    <a href="{{ route('register.mentor') }}" 
                       class="px-6 py-2 rounded-md text-gray-600 hover:bg-gray-100 font-medium">
                        Mentor
                    </a>
                </div>
            </div>

            @if ($errors->any())
                <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded-lg">
                    <ul class="list-disc list-inside text-sm">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('register.murid.post') }}" class="space-y-4">
                @csrf
                <input type="hidden" name="step" value="1">

                <!-- Nama Lengkap -->
                <div>
                    <label for="nama_lengkap" class="block text-sm font-medium text-gray-700 mb-2">
                        Nama Lengkap
                    </label>
                    <input 
                        id="nama_lengkap" 
                        type="text" 
                        name="nama_lengkap" 
                        value="{{ old('nama_lengkap') }}"
                        required 
                        autofocus
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        placeholder="Masukkan nama lengkap"
                    >
                </div>

                <!-- Username -->
                <div>
                    <label for="username" class="block text-sm font-medium text-gray-700 mb-2">
                        Username
                    </label>
                    <input 
                        id="username" 
                        type="text" 
                        name="username" 
                        value="{{ old('username') }}"
                        required
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        placeholder="Pilih username unik"
                    >
                    <p class="text-xs text-gray-500 mt-1">Username hanya boleh huruf, angka, dash (-) dan underscore (_)</p>
                </div>

                <!-- Sekolah (Optional) -->
                <div>
                    <label for="sekolah" class="block text-sm font-medium text-gray-700 mb-2">
                        Sekolah (Opsional)
                    </label>
                    <input 
                        id="sekolah" 
                        type="text" 
                        name="sekolah" 
                        value="{{ old('sekolah') }}"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        placeholder="Nama sekolah"
                    >
                </div>

                <!-- Password -->
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                        Password
                    </label>
                    <input 
                        id="password" 
                        type="password" 
                        name="password" 
                        required
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        placeholder="Minimal 8 karakter"
                    >
                </div>

                <!-- Confirm Password -->
                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">
                        Konfirmasi Password
                    </label>
                    <input 
                        id="password_confirmation" 
                        type="password" 
                        name="password_confirmation" 
                        required
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        placeholder="Ketik ulang password"
                    >
                </div>

                <!-- Submit Button -->
                <button 
                    type="submit"
                    class="w-full bg-gradient-to-r from-pink-400 to-pink-500 hover:from-pink-500 hover:to-pink-600 text-white font-bold py-3 px-4 rounded-lg transition duration-300 transform hover:scale-105 shadow-lg"
                >
                    Lanjut
                </button>
            </form>

            <!-- Login Link -->
            <div class="mt-6 text-center">
                <p class="text-gray-600">
                    Sudah punya akun? 
                    <a href="{{ route('login') }}" class="text-blue-600 hover:text-blue-800 font-medium">Login di sini</a>
                </p>
            </div>
        </div>
    </div>
</body>
</html>