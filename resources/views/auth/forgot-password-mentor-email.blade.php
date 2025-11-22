<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi Email - IQRAIN</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gradient-to-br from-blue-400 to-blue-600 min-h-screen flex items-center justify-center p-4">
    <div class="w-full max-w-md bg-white rounded-2xl shadow-2xl p-8">
        <div class="text-center mb-8">
            <div class="w-20 h-20 bg-green-100 rounded-full mx-auto flex items-center justify-center mb-4">
                <svg class="w-10 h-10 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                </svg>
            </div>
            <h1 class="text-3xl font-bold text-gray-800 mb-2">Verifikasi Email</h1>
            <p class="text-gray-600 text-sm">Masukkan alamat email yang terdaftar sebagai Mentor.</p>
        </div>

        @if (session('status'))
            <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded-lg text-sm">
                {{ session('status') }}
            </div>
        @endif

        @if ($errors->any() || session('error'))
            <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded-lg text-sm">
                @if (session('error'))
                    {{ session('error') }}
                @else
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                @endif
            </div>
        @endif

        <form method="POST" action="{{ route('password.mentor.send') }}" class="space-y-6">
            @csrf

            <div>
                <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                    Email Mentor
                </label>
                <input 
                    id="email" 
                    type="email" 
                    name="email" 
                    value="{{ old('email') }}"
                    required 
                    autofocus
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                    placeholder="Contoh: mentor@iqrain.com"
                >
            </div>
            
            <div class="bg-blue-50 rounded-lg p-4">
                <p class="text-xs text-gray-700">
                    💡 **Tips:** Jika email cocok, link reset akan dikirim.
                </p>
            </div>

            <button 
                type="submit"
                class="w-full bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-white font-bold py-3 px-4 rounded-lg transition duration-300 transform hover:scale-105 shadow-lg"
            >
                Kirim Link Reset
            </button>
        </form>

        <div class="mt-6 text-center">
            <a href="{{ route('password.request') }}" class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                ← Kembali ke Pengecekan Username
            </a>
        </div>
    </div>
</body>
</html>