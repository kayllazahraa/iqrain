@extends('layouts.murid', ['hideNavbar' => true])

@section('title', 'Pilih Level Iqra-mu!')

@section('content')

    <div class="relative flex flex-col min-h-screen w-full bg-gradient-to-b from-[#87CEEB] to-[#BDE8F7] overflow-hidden">

        {{-- 
      KODE INI SUDAH BENAR.
      Jika kamu melihat emoji 🐝, itu artinya path di 'src' ini salah di server-mu.
      Pastikan file ada di: public/images/tingkatan/lebah.webp
    --}}
        <img src="{{ asset('images/tingkatan/lebah.webp') }}" alt="Lebah"
            class="absolute top-[25%] left-[8%] w-20 h-20 animate-float z-10" style="animation-delay: 0.5s;">
        <img src="{{ asset('images/tingkatan/lebah.webp') }}" alt="Lebah"
            class="absolute top-[35%] right-[10%] w-20 h-20 animate-float z-10 transform -scale-x-100">


        <div class="flex-grow z-20">

            <div class="max-w-6xl mx-auto my-8 px-4">
                <div class="bg-[#F387A9] rounded-[51px] px-4 sm:px-6 py-4 shadow-lg relative">
                    <div class="flex items-center justify-between">

                        <a href="{{ route('logout') }}"
                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                            class="text-[#680D2A] hover:scale-110 transition-transform p-2">
                            <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M15 19l-7-7 7-7" />
                            </svg>
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                            @csrf
                        </form>

                        <div class="text-center flex-1 mx-2 sm:mx-4">
                            <h1 class="font-titan-one text-white text-3xl md:text-[45px] text-shadow-custom leading-tight">
                                Pilih Level Iqra-mu!
                            </h1>
                            <p class="font-tegak-bersambung text-[#680D2A] text-2xl md:text-[40px] leading-snug -mt-1">
                                Ayo mulai petualangan belajar kita. Pilih Iqra 1 untuk memulai!
                            </p>
                        </div>

                        {{-- 
                      PERUBAHAN DI SINI:
                      1. Margin diubah dari -mt-24 -> -mt-20 (agar tidak terpotong)
                      2. 'transform: rotate(...)' DIHAPUS dari style <img>
                    --}}
                        <div class="w-56 h-56 flex-shrink-0 -mt-20">
                            <img src="{{ asset('images/maskot/bawa-hp.webp') }}" alt="Qira"
                                class="w-full h-full object-contain"
                                style="filter: drop-shadow(0 4px 4px rgba(0,0,0,0.25));">
                        </div>
                    </div>
                </div>
            </div>

            <div class="max-w-4xl mx-auto px-4 pb-16">
                <div class="grid grid-cols-3 gap-x-6 sm:gap-x-8 gap-y-12">

                    @foreach ($tingkatans as $index => $tingkatan)
                        @if ($tingkatan->level === 1)
                            <a href="{{ route('murid.modul.index', $tingkatan->tingkatan_id) }}"
                                onclick="sessionStorage.setItem('current_tingkatan_id', {{ $tingkatan->tingkatan_id }})"
                                class="group flex flex-col items-center">

                                <div
                                    class="w-[169px] h-[169px] rounded-full bg-[#FFEFAE] flex items-center justify-center shadow-custom-drop group-hover:scale-110 transition-transform duration-300">
                                    <img src="{{ asset('images/tingkatan/iqra.webp') }}"
                                        alt="{{ $tingkatan->nama_tingkatan }}" class="w-24 h-24 object-contain">
                                </div>

                                {{-- Teks ini diambil dari database ($tingkatan->nama_tingkatan) --}}
                                {{-- Jika hanya muncul 'Iqra', berarti font-mu tidak bisa render angka --}}
                                <p class="text-center mt-4 text-3xl font-tegak-bersambung text-[#680D2A]">
                                    {{ $tingkatan->nama_tingkatan }}
                                </p>
                            </a>
                        @else
                            <div class="flex flex-col items-center cursor-not-allowed opacity-60">

                                <div
                                    class="w-[169px] h-[169px] rounded-full bg-[#DFDADA] flex items-center justify-center shadow-custom-drop">
                                    <img src="{{ asset('images/tingkatan/gembok.webp') }}"
                                        alt="{{ $tingkatan->nama_tingkatan }} (Terkunci)" class="w-24 h-24 object-contain">
                                </div>

                                <p class="text-center mt-4 text-3xl font-tegak-bersambung text-[#680D2A] opacity-70">
                                    {{ $tingkatan->nama_tingkatan }}
                                </p>
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>
        </div>
        <div class="w-full flex-shrink-0 z-0">
            <img src="{{ asset('images/games/game-footer.webp') }}" alt="Footer Pemandangan"
                class="w-full h-auto object-cover" style="margin-bottom: -1px;">
        </div>

    </div>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Titan+One&display=swap');

        @font-face {
            font-family: 'Tegak Bersambung_IWK';
            src: url('{{ asset('fonts/TegakBersambung_IWK.ttf') }}') format('truetype');
        }

        .font-titan-one {
            font-family: 'Titan One', sans-serif;
        }

        .font-tegak-bersambung {
            font-family: 'Tegak Bersambung_IWK', cursive;
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
