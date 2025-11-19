<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'IQRAIN - Belajar Iqra Menyenangkan')</title>

    {{-- Tailwind CSS & Custom CSS via Vite --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        /* Font Tegak Bersambung IWK (Pastikan path benar) */
        @font-face {
            font-family: 'Tegak Bersambung IWK';
            src: url("{{ asset('fonts/TegakBersambung_IWK.ttf') }}") format('truetype');
            font-weight: normal;
            font-style: normal;
        }

        /* Import Font Titan One dari Google Fonts secara global */
        @import url('https://fonts.googleapis.com/css2?family=Titan+One&display=swap');
        /* Import Font Nanum Myeongjo dari Google Fonts secara global */
        @import url('https://fonts.googleapis.com/css2?family=Nanum+Myeongjo&display=swap');
        /* Import Font Fredoka dari Google Fonts secara global */
        @import url('https://fonts.googleapis.com/css2?family=Fredoka&display=swap');


        /* Default Font for everything */
        * {
            font-family: 'Fredoka', sans-serif;
        }

        /* --- Body --- */
        body {
            background: linear-gradient(180deg, #87CEEB 0%, #B0E0E6 100%);
            min-height: 100vh;
            position: relative;
            overflow-x: hidden;
        }

        /* Style Container Navbar */
        .navbar-murid {
            background: #F387A9;
            border-radius: 74px;
            box-shadow: 0 4px 4px 0 rgba(0, 0, 0, 0.25);
        }

        /* Navbar Link Items */
        .nav-item {
            font-family: 'Tegak Bersambung IWK', cursive;
            font-size: 25px;
            transition: all 0.3s ease;
        }

        .nav-item:hover {
            transform: translateY(-2px);
        }

        .nav-item.active {
            background: white;
            color: #FF6B9D;
            font-weight: 600;
        }

        .nav-item:not(.active) {
            color: white;
        }

        /* --- Padding Content --- */
        .content-wrapper {
            padding-top: 80px;
            padding-bottom: 50px;
        }

        /* Bee Animation */
        @keyframes float {
            0%, 100% { transform: translateY(0px) rotate(-5deg); }
            50% { transform: translateY(-20px) rotate(5deg); }
        }

        .bee-float {
            animation: float 3s ease-in-out infinite;
        }

        /* Card styles */
        .card-rounded {
            border-radius: 30px;
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.12);
        }

        /* Button styles */
        .btn-primary {
            background: linear-gradient(135deg, #FF6B9D 0%, #E85A8B 100%);
            color: white;
            padding: 12px 32px;
            border-radius: 25px;
            font-weight: 600;
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(255, 107, 157, 0.4);
        }

        .btn-secondary {
            background: white;
            color: #FF6B9D;
            padding: 12px 32px;
            border-radius: 25px;
            font-weight: 600;
            transition: all 0.3s ease;
            border: 2px solid #FF6B9D;
            cursor: pointer;
        }

        .btn-secondary:hover {
            background: #FF6B9D;
            color: white;
        }

        /* Custom scrollbar */
        ::-webkit-scrollbar { width: 10px; }
        ::-webkit-scrollbar-track { background: #f1f1f1; border-radius: 10px; }
        ::-webkit-scrollbar-thumb { background: #FF6B9D; border-radius: 10px; }
        ::-webkit-scrollbar-thumb:hover { background: #E85A8B; }

        /* Menambahkan font-family kustom (di sini kita bisa menambahkan !important) */
        .font-titan {
            font-family: 'Titan One', sans-serif !important;
        }

        .font-cursive-iwk {
            font-family: 'Tegak Bersambung IWK', cursive !important;
        }

        .font-nanum {
            font-family: 'Nanum Myeongjo', serif !important;
        }

        .phrase {
            display: inline-block;
            text-wrap: nowrap;
            font-family: 'Tegak Bersambung IWK', cursive;
        }

        .phrase::after {
            content: "";
            display: block;
            width: 100%;
            height: 16px;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 50' preserveAspectRatio='none'%3E%3Cpath fill='none' stroke='%23ffffff' stroke-width='4' d='M5,5 C30,35 70,35 95,5' stroke-linecap='round'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-size: 100% 100%;
        }
    </style>

    @stack('styles')
</head>

<body>

    @if (!isset($hideNavbar) || !$hideNavbar)
        <nav class="navbar-murid fixed top-4 left-0 right-0 z-50 w-11/12 max-w-5xl mx-auto rounded-full">
            <div class="container mx-auto px-4 py-3">
                <div class="flex items-center justify-between max-w-4xl mx-auto">
                    <a href="{{ route('murid.pilih-iqra') }}" class="flex items-center space-x-2">
                        <div class="bg-white rounded-full w-12 h-12 flex items-center justify-center">
                            <span class="text-2xl font-bold text-pink-500">IQ</span>
                        </div>
                    </a>

                    <div class="flex items-center space-x-2">
                        <a href="{{ route('murid.modul.index', ['tingkatan_id' => session('current_tingkatan_id', 1)]) }}"
                            class="nav-item px-6 py-2 rounded-full text-sm {{ request()->routeIs('murid.modul.*') ? 'active' : '' }}">
                            Modul
                        </a>
                        <a href="{{ route('murid.games.index', ['tingkatan_id' => session('current_tingkatan_id', 1)]) }}"
                            class="nav-item px-6 py-2 rounded-full text-sm {{ request()->routeIs('murid.games.*') ? 'active' : '' }}">
                            Games
                        </a>
                        <a href="{{ route('murid.evaluasi.index', ['tingkatan_id' => session('current_tingkatan_id', 1)]) }}"
                            class="nav-item px-6 py-2 rounded-full text-sm {{ request()->routeIs('murid.evaluasi.*') ? 'active' : '' }}">
                            Evaluasi
                        </a>
                        <a href="{{ route('murid.mentor.index') }}"
                            class="nav-item px-6 py-2 rounded-full text-sm {{ request()->routeIs('murid.mentor.*') ? 'active' : '' }}">
                            Mentor
                        </a>
                    </div>

                    <a href="#" class="bg-white rounded-full w-10 h-10 flex items-center justify-center">
                        <svg class="w-6 h-6 text-pink-500" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" />
                        </svg>
                    </a>
                </div>
            </div>
        </nav>
    @endif

    <main class="content-wrapper">
        @yield('content')
    </main>

    {{-- FOOTER GLOBAL --}}
    <div class="w-full relative z-20 -mt-12 pointer-events-none">
        <img src="{{ asset('images/games/game-footer.webp') }}" alt="Footer Decoration"
            class="w-full h-auto object-cover block select-none">
    </div>

    <script>
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        async function fetchAPI(url, options = {}) {
            try {
                const response = await fetch(url, {
                    ...options,
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        ...(options.headers || {})
                    }
                });
                if (!response.ok) {
                    const errorData = await response.json();
                    throw new Error(errorData.message || `API request failed with status ${response.status}`);
                }
                return await response.json();
            } catch (error) {
                console.error('API Fetch Error:', error);
                throw error;
            }
        }

        function showToast(message, type = 'success') {
            const toastContainer = document.createElement('div');
            toastContainer.className = 'fixed bottom-4 right-4 z-[9999] flex items-center p-4 rounded-lg shadow-lg text-white ' +
                (type === 'success' ? 'bg-green-500' : 'bg-red-500');
            toastContainer.innerHTML = `
                <div class="mr-2">
                    ${type === 'success' ? '<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>' : '<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>'}
                </div>
                <div>${message}</div>
            `;
            document.body.appendChild(toastContainer);
            setTimeout(() => {
                toastContainer.remove();
            }, 3000);
        }
    </script>

    @stack('scripts')
</body>

</html>