<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menunggu Persetujuan - IQRAIN</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gradient-to-br from-blue-400 to-blue-600 min-h-screen flex items-center justify-center p-4">
    <div class="max-w-md w-full bg-white rounded-2xl shadow-2xl p-8 text-center">
        <div class="mb-6">
            <div class="w-24 h-24 bg-yellow-100 rounded-full mx-auto flex items-center justify-center mb-4">
                <svg class="w-12 h-12 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <h1 class="text-3xl font-bold text-gray-800 mb-2">Menunggu Persetujuan Admin</h1>
            <p class="text-gray-600">
                Akun kamu masih dalam proses verifikasi. Admin akan segera mengecek dan menyetujui akun kamu. 
                Kamu akan diberi tahu melalui email (1x24 jam sampai admin menyetujui).
            </p>
        </div>
        
        <div class="bg-blue-50 rounded-lg p-4 mb-6">
            <p class="text-sm text-gray-700">
                <strong>Catatan:</strong> Silakan cek email kamu secara berkala untuk update status akun.
            </p>
        </div>

        <a href="{{ route('login') }}" 
           class="inline-block bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white font-bold py-3 px-8 rounded-lg transition duration-300">
            Kembali ke Login
        </a>
    </div>
</body>
</html>