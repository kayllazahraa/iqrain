<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jawab Pertanyaan - IQRAIN</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gradient-to-br from-blue-400 to-blue-600 min-h-screen flex items-center justify-center p-4">
    <div class="w-full max-w-md bg-white rounded-2xl shadow-2xl p-8">
        <div class="text-center mb-8">
            <div class="w-20 h-20 bg-yellow-100 rounded-full mx-auto flex items-center justify-center mb-4">
                <svg class="w-10 h-10 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <h1 class="text-3xl font-bold text-gray-800 mb-2">Jawab Pertanyaan</h1>
            <p class="text-gray-600 text-sm">Jawab pertanyaan keamanan kamu dengan benar</p>
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

        @if (session('error'))
            <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded-lg text-sm">
                {{ session('error') }}
            </div>
        @endif

        <form method="POST" action="{{ route('password.murid.verify') }}" class="space-y-6">
            @csrf

            <!-- Pertanyaan -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-blue-500 text-white text-sm font-bold mr-2">🎨</span>
                    {{ $pertanyaan }}
                </label>
                <input 
                    type="text" 
                    name="jawaban" 
                    required
                    autofocus
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-lg"
                    placeholder="Jawaban kamu..."
                >
            </div>

            <div class="bg-blue-50 rounded-lg p-4">
                <p class="text-xs text-gray-700">
                    💡 <strong>Tips:</strong> Huruf besar/kecil tidak masalah. Yang penting jawabannya sama!
                </p>
            </div>

            <button 
                type="submit"
                class="w-full bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-white font-bold py-3 px-4 rounded-lg transition duration-300 transform hover:scale-105 shadow-lg"
            >
                Verifikasi
            </button>
        </form>

        <div class="mt-6 text-center">
            <a href="{{ route('password.murid.request') }}" class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                ← Kembali
            </a>
        </div>
    </div>
</body>
</html>