<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Mentor - IQRAIN</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen bg-[var(--color-iqrain-blue)] font-sans">

    <div class="max-w-7xl mx-auto py-8 px-6 relative">

        <div class="lg:w-[calc(100%-500px)] lg:pr-10">
            
            <h1 class="text-4xl lg:text-5xl font-titan text-white mb-4"
                style="text-shadow: 2px 2px 4px rgba(0,0,0,0.1);">
                Buat Akun Baru
            </h1>

            <div class="inline-flex rounded-full border-2 border-white p-1 bg-white mb-4">
                <a href="{{ route('register.murid') }}" 
                    class="px-8 py-1 rounded-full text-gray-600 font-semibold text-base"> 
                    Murid
                </a>
                <a href="{{ route('register.mentor') }}" 
                    class="px-8 py-1 rounded-full bg-pink-400 text-white font-semibold text-base">
                    Mentor
                </a>
            </div>

            {{-- **BAGIAN INI DIHAPUS** karena error akan ditampilkan per field.
            @if ($errors->any())
                <div class="mb-4 p-4 bg-red-100 border-l-4 border-red-600 text-red-700 rounded-xl">
                    <ul class="list-disc ml-5 text-sm">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            --}}

            <form method="POST" action="{{ route('register.mentor.post') }}">
                @csrf
                
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-4"> 
                    
                    <div class="lg:col-span-2 flex items-center my-2"> 
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                        <span class="text-white font-bold text-base">Data Diri</span>
                    </div>

                    <div>
                        <label for="username" class="text-white font-semibold block mb-1 text-sm">Username</label>
                        <input id="username" type="text" name="username" value="{{ old('username') }}" required
                            class="w-full px-3 py-2 rounded-lg border-2 {{ $errors->has('username') ? 'border-red-500' : 'border-white' }} bg-white text-gray-800 focus:ring-2 focus:ring-yellow-300"
                            placeholder="Pilih username unik">
                        @error('username')
                            <p class="text-red-300 text-xs mt-1">{{ $message }}</p>
                        @enderror
                        <p class="text-xs text-white opacity-75 mt-1">Username hanya boleh huruf, angka, dash (-) dan underscore (_)</p>
                    </div>

                    <div>
                        <label for="nama_lengkap" class="text-white font-semibold block mb-1 text-sm">Nama Lengkap</label>
                        <input id="nama_lengkap" type="text" name="nama_lengkap" value="{{ old('nama_lengkap') }}" required autofocus
                            class="w-full px-3 py-2 rounded-lg border-2 {{ $errors->has('nama_lengkap') ? 'border-red-500' : 'border-white' }} bg-white text-gray-800 focus:ring-2 focus:ring-yellow-300"
                            placeholder="Masukkan nama lengkap">
                        @error('nama_lengkap')
                            <p class="text-red-300 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="no_wa" class="text-white font-semibold block mb-1 text-sm">Nomor WhatsApp</label>
                        <input id="no_wa" type="tel" name="no_wa" value="{{ old('no_wa') }}" required
                            class="w-full px-3 py-2 rounded-lg border-2 {{ $errors->has('no_wa') ? 'border-red-500' : 'border-white' }} bg-white text-gray-800 focus:ring-2 focus:ring-yellow-300"
                            placeholder="08xxxxxxxxxx">
                        @error('no_wa')
                            <p class="text-red-300 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="email" class="text-white font-semibold block mb-1 text-sm">Email</label>
                        <input id="email" type="email" name="email" value="{{ old('email') }}" required
                            class="w-full px-3 py-2 rounded-lg border-2 {{ $errors->has('email') ? 'border-red-500' : 'border-white' }} bg-white text-gray-800 focus:ring-2 focus:ring-yellow-300"
                            placeholder="email@example.com">
                        @error('email')
                            <p class="text-red-300 text-xs mt-1">{{ $message }}</p>
                        @enderror
                        <p class="text-xs text-white opacity-75 mt-1">Untuk reset password dan notifikasi</p>
                    </div>

                    <div class="lg:col-span-2 flex items-center my-2"> 
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                        </svg>
                        <span class="text-white font-bold text-base">Keamanan</span>
                    </div>

                    <div>
                        <label for="password" class="text-white font-semibold block mb-1 text-sm">Password</label>
                        <input id="password" type="password" name="password" required
                            class="w-full px-3 py-2 rounded-lg border-2 {{ $errors->has('password') ? 'border-red-500' : 'border-white' }} bg-white text-gray-800 focus:ring-2 focus:ring-yellow-300"
                            placeholder="Minimal 8 karakter">
                        @error('password')
                            <p class="text-red-300 text-xs mt-1">{{ $message }}</p>
                        @enderror
                        <p class="text-xs text-white opacity-75 mt-1">Password harus minimal 8 karakter.</p>
                    </div>

                    <div>
                        <label for="password_confirmation" class="text-white font-semibold block mb-1 text-sm">Konfirmasi Password</label>
                        <input id="password_confirmation" type="password" name="password_confirmation" required
                            class="w-full px-3 py-2 rounded-lg border-2 {{ $errors->has('password_confirmation') ? 'border-red-500' : 'border-white' }} bg-white text-gray-800 focus:ring-2 focus:ring-yellow-300"
                            placeholder="Ketik ulang password">
                        @error('password_confirmation')
                            <p class="text-red-300 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                </div> 
                
                <div class="mt-6 flex justify-end">
                    <button type="submit"
                        class="bg-pink-400 text-white font-bold py-2.5 px-8 rounded-xl shadow-lg hover:bg-pink-500 transition">
                        Ajukan Daftar
                    </button>
                </div>

            </form>

            <div class="border-t border-white mt-8 pt-4">
                <p class="text-white">
                    Sudah punya akun? 
                    <a href="{{ route('login') }}" class="text-yellow-300 underline">Login di sini</a>
                </p>
            </div>
        </div>

    </div>

    <div class="absolute top-0 right-0 w-[500px] h-full hidden lg:block overflow-hidden">
        <img src="{{ asset('images/pattern/wafe-regist.webp') }}" 
            class="h-full object-fill w-[700px] absolute left-0"
            alt="Pattern Gelombang Registrasi">
        <img src="{{ asset('images/maskot/ceria.webp') }}" class="absolute bottom-0 right-0 w-[450px]"
            alt="Maskot Ceria">
    </div>

</body>
</html>