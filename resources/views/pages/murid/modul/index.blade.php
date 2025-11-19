@extends('layouts.murid')

@section('title', 'Modul Pembelajaran - Iqra ' . $tingkatan->level)

@section('content')
{{-- OUTER BACKGROUND: BIRU --}}
<div class="pt-4 sm:pt-8 pb-0 px-4 flex items-start justify-center relative overflow-hidden">
    
    {{-- Pattern Background --}}
    <img src="{{ asset('images/pattern/pattern1.webp') }}" class="absolute top-0 left-0 w-full h-full object-cover opacity-10 pointer-events-none mix-blend-overlay" alt="pattern">

    {{-- KONTEN UTAMA: BLOK KREM BESAR --}}
    <div class="w-full max-w-6xl bg-[#FDF6E9] rounded-[3rem] shadow-2xl border-[6px] border-white/30 relative z-10 overflow-hidden flex flex-col min-h-[75vh] mb-0">
        
        {{-- HEADER & TABS WRAPPER --}}
        <div class="bg-white/50 backdrop-blur-sm p-6 border-b border-orange-100/50">
            <div class="flex flex-col md:flex-row justify-between items-center gap-6">
                
                {{-- Judul Halaman --}}
                <h1 class="text-3xl font-bold text-indigo-900 flex items-center gap-3">
                    <img src="{{ asset('images/icon/bintang.webp') }}" class="w-10 h-10 animate-spin-slow" alt="star">
                    <span>Iqra Jilid {{ $tingkatan->level }}</span>
                    <img src="{{ asset('images/icon/bintang.webp') }}" class="w-10 h-10 animate-spin-slow" alt="star">
                </h1>

                {{-- TOMBOL TAB NAVIGASI --}}
                <div class="bg-white p-1.5 rounded-full shadow-lg border border-orange-100 inline-flex">
                    <button onclick="switchTab('video')" 
                            id="tab-video" 
                            class="px-8 py-3 rounded-full font-bold text-lg transition-all duration-300 flex items-center gap-2 text-pink-500 hover:bg-gray-50 hover:text-white-500">
                        <!-- <img src="{{ asset('images/icon/broadcast.webp') }}" class="w-6 h-6 grayscale opacity-60" alt="icon"> -->
                        Video
                    </button>
                    <button onclick="switchTab('materi')" 
                            id="tab-materi" 
                            class="px-8 py-3 rounded-full font-bold text-lg transition-all duration-300 flex items-center gap-2 shadow-md transform hover:-translate-y-0.5 bg-white-500 text-pink-500">
                        <!-- <img src="{{ asset('images/icon/blok-huruf.webp') }}" class="w-6 h-6" alt="icon"> -->
                        Materi
                    </button>
                </div>
            </div>
        </div>

        {{-- CONTENT AREA --}}
        <div class="flex-1 p-6 md:p-10 overflow-y-auto relative">
            
            {{-- ========================================== --}}
            {{-- 1. KONTEN MATERI (CAROUSEL STATIC)       --}}
            {{-- ========================================== --}}
            <div id="content-materi" class="tab-content h-full flex flex-col justify-center items-center transition-opacity duration-500">
                
                {{-- Container Galeri --}}
                <div class="w-full max-w-4xl flex items-center justify-between gap-4 md:gap-12">
                    
                    {{-- Tombol PREV (Mirror) --}}
                    <button onclick="prevMateri()" class="group relative z-20 p-4 transition-transform hover:scale-110 focus:outline-none">
                        <div class="absolute inset-0 bg-white rounded-full shadow-lg opacity-70 group-hover:opacity-100 transition-opacity"></div>
                        <img src="{{ asset('images/icon/next.webp') }}" 
                             class="w-12 h-12 md:w-16 md:h-16 relative z-10 transform rotate-180 opacity-80 group-hover:opacity-100 filter drop-shadow-sm" 
                             alt="Previous">
                    </button>

                    {{-- Kartu Materi Tengah --}}
                    <div class="flex-1 relative group perspective-1000">
                        {{-- Background Decor --}}
                        <div class="absolute inset-0 bg-gradient-to-b from-white to-indigo-50 rounded-[2.5rem] shadow-xl transform rotate-1 scale-95 opacity-60 transition-transform duration-500 group-hover:rotate-2"></div>
                        
                        {{-- Main Card --}}
                        <div id="materi-card" class="relative bg-white rounded-[2.5rem] shadow-2xl border-4 border-white p-8 md:p-12 text-center transform transition-all duration-500">
                            
                            {{-- Image Container --}}
                            <div class="relative h-48 md:h-64 flex items-center justify-center mb-6">
                                {{-- Glow Effect --}}
                                <div class="absolute w-40 h-40 bg-yellow-200 rounded-full blur-2xl opacity-30 animate-pulse"></div>
                                
                                <img id="materi-image" 
                                     src="" 
                                     class="h-full w-auto object-contain drop-shadow-2xl relative z-10 transition-transform duration-500" 
                                     alt="Huruf Hijaiyah"
                                     onerror="handleImageError(this)">
                                     
                                <div id="materi-fallback" class="hidden text-8xl font-arabic text-indigo-600 font-bold">?</div>
                            </div>

                            {{-- Text Info --}}
                            <div class="space-y-2">
                                <h2 id="materi-title" class="text-6xl md:text-7xl font-bold text-indigo-900 font-comic tracking-wide mb-2">
                                    </h2>
                                <div class="inline-block bg-indigo-100 px-4 py-2 rounded-xl">
                                    <p id="materi-desc" class="text-indigo-600 font-medium text-lg">
                                        </p>
                                </div>
                            </div>

                            {{-- Counter Badge --}}
                            <div class="absolute top-6 right-6 bg-gray-100 px-3 py-1 rounded-full text-sm font-bold text-gray-500 border border-gray-200">
                                <span id="materi-counter">1/1</span>
                            </div>
                        </div>
                    </div>

                    {{-- Tombol NEXT --}}
                    <button onclick="nextMateri()" class="group relative z-20 p-4 transition-transform hover:scale-110 focus:outline-none">
                        <div class="absolute inset-0 bg-white rounded-full shadow-lg opacity-70 group-hover:opacity-100 transition-opacity"></div>
                        <img src="{{ asset('images/icon/next.webp') }}" 
                             class="w-12 h-12 md:w-16 md:h-16 relative z-10 opacity-80 group-hover:opacity-100 filter drop-shadow-sm" 
                             alt="Next">
                    </button>
                </div>
            </div>


            {{-- ========================================== --}}
            {{-- 2. KONTEN VIDEO (DATA DARI DATABASE)     --}}
            {{-- ========================================== --}}
            <div id="content-video" class="tab-content hidden h-full">
                <div class="flex flex-col lg:flex-row gap-8 h-full">
                    
                    {{-- KIRI: Main Player --}}
                    <div class="w-full lg:w-2/3 flex flex-col gap-4">
                        <div class="bg-black rounded-3xl overflow-hidden shadow-lg aspect-video border-4 border-white ring-1 ring-gray-200 relative">
                            @if($videos->count() > 0)
                                <iframe id="main-video-player"
                                        class="w-full h-full"
                                        src="{{ $videos->first()->url_video }}" 
                                        title="Video Player"
                                        frameborder="0" 
                                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                                        allowfullscreen>
                                </iframe>
                            @else
                                <div class="absolute inset-0 flex flex-col items-center justify-center text-white bg-gray-800">
                                    <img src="{{ asset('images/maskot/bawa-hp.webp') }}" class="w-24 opacity-50 mb-4" alt="Empty">
                                    <p>Belum ada video tersedia.</p>
                                </div>
                            @endif
                        </div>
                        
                        {{-- Info Video Aktif --}}
                        <div class="bg-white p-6 rounded-3xl shadow-sm border border-indigo-50">
                            @if($videos->count() > 0)
                                <h2 id="main-video-title" class="text-2xl font-bold text-gray-800 mb-2">{{ $videos->first()->judul_video }}</h2>
                                <p id="main-video-desc" class="text-gray-600 leading-relaxed">{{ $videos->first()->deskripsi }}</p>
                            @endif
                        </div>
                    </div>

                    {{-- KANAN: Playlist --}}
                    <div class="w-full lg:w-1/3 flex flex-col h-full">
                        <div class="bg-white rounded-3xl p-5 shadow-md border border-indigo-50 h-full max-h-[600px] flex flex-col">
                            <h3 class="font-bold text-lg text-indigo-900 mb-4 flex items-center gap-2 pb-3 border-b border-gray-100">
                                <span class="bg-red-100 text-red-500 p-1.5 rounded-lg">▶</span>
                                Daftar Putar
                            </h3>
                            
                            <div class="overflow-y-auto flex-1 pr-2 custom-scrollbar space-y-3">
                                @forelse($videos as $video)
                                    <div onclick="changeVideo('{{ $video->url_video }}', '{{ $video->judul_video }}', '{{ $video->deskripsi }}')" 
                                         class="group flex gap-3 p-2 rounded-2xl hover:bg-indigo-50 cursor-pointer transition-colors border border-transparent hover:border-indigo-100">
                                        
                                        <div class="w-32 h-20 bg-gray-200 rounded-xl flex-shrink-0 overflow-hidden relative">
                                            <div class="absolute inset-0 bg-black/10 group-hover:bg-transparent transition-all z-10"></div>
                                            <iframe class="w-full h-full pointer-events-none" src="{{ $video->url_video }}?controls=0" tabindex="-1"></iframe>
                                        </div>
                                        
                                        <div class="flex flex-col justify-center flex-1 min-w-0">
                                            <h4 class="font-bold text-gray-800 text-sm line-clamp-2 group-hover:text-indigo-600 transition-colors">
                                                {{ $video->judul_video }}
                                            </h4>
                                            <p class="text-xs text-gray-400 mt-1 flex items-center gap-1">
                                                Putar Video
                                            </p>
                                        </div>
                                    </div>
                                @empty
                                    <div class="text-center py-10">
                                        <p class="text-gray-400 text-sm">Tidak ada video.</p>
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<footer class="w-full mt-12">
        <img src="/images/games/game-footer.webp" alt="Footer Hiasan" class="w-full object-cover">
</footer>

<script>
    // === DATA STATIC MATERI (DI LOAD LANGSUNG DI SINI) ===
    // Nama file disesuaikan persis dengan yang ada di folder public/images/hijaiyah/
    const staticMateriData = [
        { judul: 'Alif', desc: 'Huruf Alif', file: 'alif.webp' },
        { judul: 'Ba', desc: 'Huruf Ba', file: 'ba.webp' },
        { judul: 'Ta', desc: 'Huruf Ta', file: 'ta.webp' },
        { judul: 'Tsa', desc: 'Huruf Tsa', file: 'tsa.webp' },
        { judul: 'Jim', desc: 'Huruf Jim', file: 'jim.webp' },
        { judul: 'Kha', desc: 'Huruf Kha', file: 'Kha.webp' }, // Kapital H sesuai aset
        { judul: 'Kho', desc: 'Huruf Kho', file: 'kho.webp' },
        { judul: 'Dal', desc: 'Huruf Dal', file: 'dal.webp' },
        { judul: 'Dzal', desc: 'Huruf Dzal', file: 'dzal.webp' },
        { judul: 'Ra', desc: 'Huruf Ra', file: 'ra.webp' },
        { judul: 'Zai', desc: 'Huruf Zai', file: 'Zayn.webp' }, // Sesuai aset Zayn.webp
        { judul: 'Sin', desc: 'Huruf Sin', file: 'sin.webp' },
        { judul: 'Syin', desc: 'Huruf Syin', file: 'syin.webp' },
        { judul: 'Shad', desc: 'Huruf Shad', file: 'Sad.webp' }, // Sesuai aset Sad.webp
        { judul: 'Dhad', desc: 'Huruf Dhad', file: 'Dhad.webp' }, // Sesuai aset Dhad.webp
        { judul: 'Tha', desc: 'Huruf Tha', file: 'Tha.webp' }, // Sesuai aset Tha.webp
        { judul: 'Zha', desc: 'Huruf Zha', file: 'Zha.webp' }, // Sesuai aset Zha.webp
        { judul: 'Ain', desc: 'Huruf Ain', file: 'ain.webp' },
        { judul: 'Ghain', desc: 'Huruf Ghain', file: 'Ghain.webp' }, // Sesuai aset Ghain.webp
        { judul: 'Fa', desc: 'Huruf Fa', file: 'fa.webp' },
        { judul: 'Qaf', desc: 'Huruf Qaf', file: 'Qaf.webp' }, // Sesuai aset Qaf.webp
        { judul: 'Kaf', desc: 'Huruf Kaf', file: 'kaf.webp' },
        { judul: 'Lam', desc: 'Huruf Lam', file: 'lam.webp' },
        { judul: 'Mim', desc: 'Huruf Mim', file: 'mim.webp' },
        { judul: 'Nun', desc: 'Huruf Nun', file: 'nun.webp' },
        { judul: 'Waw', desc: 'Huruf Waw', file: 'Waw.webp' }, // Sesuai aset Waw.webp
        { judul: 'Ha', desc: 'Huruf Ha', file: 'Ha.webp' }, // Sesuai aset
        { judul: 'Lam Alif', desc: 'Huruf Lam Alif', file: 'Lamalif.webp' }, // Sesuai aset
        { judul: 'Hamzah', desc: 'Huruf Hamzah', file: 'hamzah.webp' },
        { judul: 'Ya', desc: 'Huruf Ya', file: 'ya.webp' }
    ];

    let currentIndex = 0;

    // === 1. LOGIKA TAB ===
    function switchTab(tabName) {
        const contentMateri = document.getElementById('content-materi');
        const contentVideo = document.getElementById('content-video');
        const btnMateri = document.getElementById('tab-materi');
        const btnVideo = document.getElementById('tab-video');

        const activeClasses = ['bg-indigo-500', 'text-white', 'shadow-md'];
        const inactiveClasses = ['text-gray-500', 'hover:bg-gray-50', 'hover:text-indigo-500'];

        if (tabName === 'materi') {
            contentMateri.classList.remove('hidden');
            contentVideo.classList.add('hidden');
            
            btnMateri.classList.add(...activeClasses);
            btnMateri.classList.remove(...inactiveClasses);
            btnVideo.classList.remove(...activeClasses);
            btnVideo.classList.add(...inactiveClasses);
            
            btnMateri.querySelector('img').classList.remove('grayscale', 'opacity-60');
            btnVideo.querySelector('img').classList.add('grayscale', 'opacity-60');

            updateMateriDisplay();
        } else {
            contentMateri.classList.add('hidden');
            contentVideo.classList.remove('hidden');
            
            btnVideo.classList.add(...activeClasses);
            btnVideo.classList.remove(...inactiveClasses);
            btnMateri.classList.remove(...activeClasses);
            btnMateri.classList.add(...inactiveClasses);
            
            btnVideo.querySelector('img').classList.remove('grayscale', 'opacity-60');
            btnMateri.querySelector('img').classList.add('grayscale', 'opacity-60');
        }
    }

    // === 2. LOGIKA MATERI CAROUSEL (STATIC) ===
    function updateMateriDisplay() {
        const materi = staticMateriData[currentIndex];
        const card = document.getElementById('materi-card');
        const imgEl = document.getElementById('materi-image');
        const fallbackEl = document.getElementById('materi-fallback');
        
        // Animasi
        card.classList.add('opacity-50', 'scale-95');

        setTimeout(() => {
            // Update Teks
            document.getElementById('materi-title').innerText = materi.judul;
            document.getElementById('materi-desc').innerText = materi.desc;
            document.getElementById('materi-counter').innerText = `${currentIndex + 1} / ${staticMateriData.length}`;
            
            // Update Gambar
            const imagePath = `{{ asset('images/hijaiyah/') }}/${materi.file}`;
            
            // Reset state gambar
            imgEl.style.display = 'block';
            fallbackEl.style.display = 'none';
            imgEl.src = imagePath;
            
            // Update Fallback Text kalau gambar ga ketemu
            fallbackEl.innerText = materi.judul;

            card.classList.remove('opacity-50', 'scale-95');
        }, 200);
    }

    function handleImageError(img) {
        img.style.display = 'none';
        document.getElementById('materi-fallback').style.display = 'block';
    }

    function nextMateri() {
        currentIndex = (currentIndex + 1) % staticMateriData.length;
        updateMateriDisplay();
    }

    function prevMateri() {
        currentIndex = (currentIndex - 1 + staticMateriData.length) % staticMateriData.length;
        updateMateriDisplay();
    }

    // === 3. LOGIKA VIDEO ===
    function changeVideo(url, title, desc) {
        document.getElementById('main-video-player').src = url;
        document.getElementById('main-video-title').innerText = title;
        document.getElementById('main-video-desc').innerText = desc;
        if(window.innerWidth < 1024) {
            document.getElementById('main-video-player').scrollIntoView({ behavior: 'smooth', block: 'center' });
        }
    }

    document.addEventListener('DOMContentLoaded', () => {
        switchTab('video');
        // document.addEventListener('keydown', (e) => {
        //     if (!document.getElementById('content-materi').classList.contains('hidden')) {
        //         if (e.key === 'ArrowRight') nextMateri();
        //         if (e.key === 'ArrowLeft') prevMateri();
        //     }
        // });
    });
</script>

<style>
    .font-comic { font-family: 'Comic Sans MS', 'Comic Sans', cursive; }
    .font-arabic { font-family: 'Amiri', serif; }
    @keyframes spin-slow {
        from { transform: rotate(0deg); }
        to { transform: rotate(360deg); }
    }
    .animate-spin-slow { animation: spin-slow 10s linear infinite; }
    .custom-scrollbar::-webkit-scrollbar { width: 6px; }
    .custom-scrollbar::-webkit-scrollbar-track { background: #f1f1f1; border-radius: 4px; }
    .custom-scrollbar::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 4px; }
</style>
@endsection