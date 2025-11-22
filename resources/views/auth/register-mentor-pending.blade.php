<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menunggu Persetujuan - IQRAIN</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen bg-[var(--color-iqrain-blue)] font-sans flex items-center justify-center p-6">

    <div class="max-w-lg w-full bg-white rounded-2xl shadow-2xl p-8 relative">

        <h1 class="text-3xl lg:text-4xl font-titan text-gray-800 mb-4 text-center"
            style="text-shadow: 2px 2px 4px rgba(0,0,0,0.1);">
            Menunggu Persetujuan Admin
        </h1>

        <!-- Icon -->
        <div class="w-28 h-28 bg-yellow-100 rounded-full mx-auto flex items-center justify-center mb-6 shadow-inner">
            <svg class="w-14 h-14 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z">
                </path>
            </svg>
        </div>

        <!-- Deskripsi -->
        <p class="text-gray-700 text-center mb-6 leading-relaxed">
            Akun kamu masih dalam proses verifikasi. Admin akan segera mengecek dan menyetujui akun kamu. 
            Kamu akan diberi tahu melalui email (1x24 jam sejak pengajuan).
        </p>

        <!-- Catatan -->
        <div class="bg-blue-50 rounded-xl p-4 mb-6 border border-blue-200 shadow-sm">
            <p class="text-sm text-gray-700">
                <strong>Catatan:</strong> Silakan cek email kamu secara berkala untuk update status akun.
            </p>
        </div>

        <!-- Tombol -->
        <div class="flex justify-center">
            <a href="{{ route('login') }}" 
               class="bg-pink-400 text-white font-bold py-3 px-8 rounded-xl shadow-lg hover:bg-pink-500 transition">
                Kembali ke Login
            </a>
        </div>

    </div>

</body>
</html>
