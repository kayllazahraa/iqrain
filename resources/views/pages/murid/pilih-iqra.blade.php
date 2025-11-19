@extends('layouts.murid', ['hideNavbar' => true])

@section('title', 'Pilih Level Iqra-mu!')

@section('content')

    {{-- 
       1. BACKGROUND LAYER (FIXED)
       Ini adalah layer background yang diam (fixed) di belakang.
       Warnanya saya sesuaikan dengan kode asli Anda (#87CEEB ke #BDE8F7).
    --}}
    <div class="fixed inset-0 w-full h-full z-0 pointer-events-none"
        style="background: linear-gradient(180deg, #87CEEB 0%, #BDE8F7 100%);">

        {{-- Pattern --}}
        <div class="absolute inset-0 w-full h-full"
            style="background-image: url('{{ asset('images/games/game-pattern.webp') }}'); 
                   background-size: 500px;
                   background-repeat: repeat;
                   background-position: center; 
                   opacity: 0.3;">
        </div>
    </div>

    {{-- 
       2. KONTEN WRAPPER
       Ini adalah layer konten yang bisa di-scroll.
       Saya berikan z-10 agar berada di atas background.
    --}}
    <div class="min-h-screen w-full relative z-10 flex flex-col overflow-x-hidden">

        {{-- Animasi Lebah (Dimasukkan ke dalam wrapper agar ikut scroll/posisi relatif aman) --}}
        <img src="{{ asset('images/tingkatan/lebah.webp') }}" alt="Lebah"
            class="absolute top-[10%] left-[5%] md:top-[25%] md:left-[8%] w-16 h-16 md:w-20 md:h-20 animate-float z-10" style="animation-delay: 0.5s;">
        <img src="{{ asset('images/tingkatan/lebah.webp') }}" alt="Lebah"
            class="absolute top-[15%] right-[5%] md:top-[35%] md:right-[10%] w-16 h-16 md:w-20 md:h-20 animate-float z-10 transform -scale-x-100">


        <div class="flex-grow z-20 pt-8"> {{-- Tambahkan padding top sedikit --}}

            <div class="max-w-6xl mx-auto my-8 px-4">
                <div class="bg-[#F387A9] rounded-[51px] px-4 sm:px-6 py-4 shadow-lg relative">
                    <div class="flex items-center justify-between">

                        {{-- Tombol Logout --}}
                        <a href="{{ route('logout') }}"
                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                            class="text-[#680D2A] hover:scale-110 transition-transform p-2">
                            <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                                    d="M15 19l-7-7 7-7" />
                            </svg>
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                            @csrf
                        </form>

                        {{-- Header Text --}}
                        <div class="text-center flex-1 mx-2 sm:mx-4">
                            <h1
                                class="font-titan-one text-white text-3xl md:text-[45px] text-shadow-custom leading-tight">
                                Pilih Level Iqra-mu!
                            </h1>
                            {{-- Menggunakan font Nanum untuk angka '1' di deskripsi header --}}
                            <p class="font-tegak-bersambung text-[#680D2A] text-2xl md:text-[40px] leading-snug -mt-1">
                                Ayo mulai petualangan belajar kita. Pilih Iqra <span
                                    class="font-nanum font-bold">1</span>
                                untuk memulai!
                            </p>
                        </div>

                        {{-- Gambar Maskot --}}
                        <div class="w-24 h-24 md:w-56 md:h-56 flex-shrink-0 -mt-4 md:-mt-20">
                            <img src="{{ asset('images/maskot/bawa-hp.webp') }}" alt="Qira"
                                class="w-full h-full object-contain"
                                style="filter: drop-shadow(0 4px 4px rgba(0,0,0,0.25));">
                        </div>
                    </div>
                </div>
            </div>

            {{-- Grid Tingkatan --}}
            <div class="max-w-4xl mx-auto px-4 pb-16">
                <div class="grid grid-cols-2 md:grid-cols-3 gap-x-4 sm:gap-x-8 gap-y-8 md:gap-y-12">

                    @foreach ($tingkatans as $index => $tingkatan)
                        @if ($tingkatan->level === 1)
                            {{-- CARD AKTIF (IQRA 1) --}}
                            <a href="{{ route('murid.modul.index', $tingkatan->tingkatan_id) }}"
                                onclick="sessionStorage.setItem('current_tingkatan_id', {{ $tingkatan->tingkatan_id }})"
                                class="group flex flex-col items-center">

                                <div
                                    class="w-[120px] h-[120px] md:w-[169px] md:h-[169px] rounded-full bg-[#FFEFAE] flex items-center justify-center shadow-custom-drop group-hover:scale-110 transition-transform duration-300">
                                    <img src="{{ asset('images/tingkatan/iqra.webp') }}"
                                        alt="{{ $tingkatan->nama_tingkatan }}"
                                        class="w-16 h-16 md:w-24 md:h-24 object-contain">
                                </div>

                                {{-- LOGIKA FONT (Regex) --}}
                                <p class="text-center mt-4 text-2xl md:text-3xl font-tegak-bersambung text-[#680D2A]">
                                    {!! preg_replace(
                                        '/(\d+)/',
                                        '<span class="font-nanum font-bold text-3xl md:text-4xl">$1</span>',
                                        $tingkatan->nama_tingkatan,
                                    ) !!}
                                </p>
                            </a>
                        @else
                            {{-- CARD TERKUNCI --}}
                            <div class="flex flex-col items-center cursor-not-allowed opacity-60">

                                <div
                                    class="w-[120px] h-[120px] md:w-[169px] md:h-[169px] rounded-full bg-[#DFDADA] flex items-center justify-center shadow-custom-drop">
                                    <img src="{{ asset('images/tingkatan/gembok.webp') }}"
                                        alt="{{ $tingkatan->nama_tingkatan }} (Terkunci)"
                                        class="w-16 h-16 md:w-24 md:h-24 object-contain">
                                </div>

                                <p
                                    class="text-center mt-4 text-2xl md:text-3xl font-tegak-bersambung text-[#680D2A] opacity-70">
                                    {!! preg_replace(
                                        '/(\d+)/',
                                        '<span class="font-nanum font-bold text-3xl md:text-4xl">$1</span>',
                                        $tingkatan->nama_tingkatan,
                                    ) !!}
                                </p>
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>
        </div>

    </div>

    {{-- CSS SECTION --}}
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Titan+One&display=swap');

        /* Font Utama (Cursive) */
        @font-face {
            font-family: 'Tegak Bersambung_IWK';
            src: url('{{ asset('fonts/TegakBersambung_IWK.ttf') }}') format('truetype');
        }

        /* Font Khusus Angka (Nanum Myeongjo) */
        @font-face {
            font-family: 'NanumMyeongjo';
            src: url('{{ asset('fonts/NanumMyeongjo-Regular.ttf') }}') format('truetype');
        }

        .font-titan-one {
            font-family: 'Titan One', sans-serif;
        }

        .font-tegak-bersambung {
            font-family: 'Tegak Bersambung_IWK', cursive;
        }

        /* Class baru untuk angka */
        .font-nanum {
            font-family: 'NanumMyeongjo', serif;
            padding-left: 4px;
        }

        .text-shadow-custom {
            text-shadow: 0 4px 4px rgba(0, 0, 0, 0.25);
        }

        .shadow-custom-drop {
            filter: drop-shadow(0 4px 4px rgba(0, 0, 0, 0.25));
        }

        @keyframes float {

            0%,
            100% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(-15px);
            }
        }

        .animate-float {
            animation: float 3s ease-in-out infinite;
        }
    </style>

@endsection