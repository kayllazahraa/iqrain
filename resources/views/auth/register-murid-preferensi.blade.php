<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Isi Pertanyaan Dulu Yuk - IQRAIN</title>
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
                <h2 class="text-2xl font-bold text-gray-800">Jawab Pertanyaan Yuk!</h2>
                <p class="text-gray-600 mt-2">Pertanyaan ini untuk membantu kalau kamu lupa password</p>
            </div>
        </div>

        <!-- Right Side - Security Question Form -->
        <div class="w-full md:w-1/2 p-12">
            <div class="text-center mb-8">
                <h1 class="text-3xl font-bold text-blue-600 mb-2">Isi Pertanyaan Dulu Yuk</h1>
                <p class="text-gray-600 text-sm">Pertanyaan keamanan jika kamu lupa password</p>
                <div class="flex justify-center space-x-2 my-4">
                    <span class="text-2xl">🔒</span>
                    <span class="text-2xl">🎨</span>
                    <span class="text-2xl">✅</span>
                </div>
                
                <!-- Progress Indicator -->
                <div class="flex justify-center items-center space-x-2 mt-4">
                    <div class="w-8 h-8 rounded-full bg-green-500 text-white flex items-center justify-center font-bold">✓</div>
                    <div class="w-12 h-1 bg-blue-500"></div>
                    <div class="w-8 h-8 rounded-full bg-blue-500 text-white flex items-center justify-center font-bold">2</div>
                </div>
                <p class="text-sm text-gray-600 mt-2">Langkah 2 dari 2: Pertanyaan Keamanan</p>
            </div>

            @if ($errors->any())
                <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded-lg text-sm">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('register.murid.post') }}" class="space-y-6">
                @csrf
                <input type="hidden" name="step" value="2">

                <!-- Pertanyaan Warna Kesukaan -->
                <div>
                    <label for="pertanyaan" class="block text-sm font-medium text-blue-700 mb-2">
                        <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-yellow-400 text-white text-sm font-bold mr-2">🎨</span>
                        Pertanyaan Keamanan
                    </label>
                    
                    <!-- Display pertanyaan (readonly, karena hanya 1 pertanyaan) -->
                    <div class="w-full px-4 py-3 bg-blue-50 border-2 border-blue-300 rounded-lg mb-3">
                        <p class="text-gray-700 font-medium">Apa warna kesukaanmu?</p>
                    </div>
                    <input type="hidden" name="pertanyaan" value="Apa warna kesukaanmu?">
                    
                    <input 
                        type="text" 
                        name="jawaban" 
                        value="{{ old('jawaban') }}"
                        required
                        autofocus
                        class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-lg"
                        placeholder="Contoh: Merah, Biru, Hijau..."
                    >
                    <p class="text-xs text-gray-500 mt-2">
                        💡 <strong>Tips:</strong> Ingat baik-baik jawabanmu ya! Jawaban ini akan digunakan kalau kamu lupa password.
                    </p>
                </div>

                <div class="bg-yellow-50 rounded-lg p-4">
                    <p class="text-sm text-gray-700">
                        <strong>Kenapa hanya 1 pertanyaan?</strong><br>
                        Supaya lebih mudah diingat! Cukup ingat warna kesukaanmu saja 🌈
                    </p>
                </div>

                <!-- Buttons -->
                <div class="flex space-x-4">
                    <a 
                        href="{{ route('register.murid') }}"
                        class="flex-1 bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-3 px-4 rounded-lg transition duration-300 text-center"
                    >
                        Kembali
                    </a>
                    <button 
                        type="submit"
                        class="flex-1 bg-gradient-to-r from-green-400 to-green-500 hover:from-green-500 hover:to-green-600 text-white font-bold py-3 px-4 rounded-lg transition duration-300 transform hover:scale-105 shadow-lg"
                    >
                        Daftar
                    </button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>