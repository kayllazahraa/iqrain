<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Isi Pertanyaan Dulu Yuk - IQRAIN</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>

        /* Font Mooli & Fredoka */
        @import url('https://fonts.googleapis.com/css2?family=Mooli&display=swap');
        @import url('https://fonts.googleapis.com/css2?family=Fredoka:wght@400;600;700&display=swap');
        
        /* Definisi Font Tegak Bersambung */
        @font-face {
            font-family: 'Tegak Bersambung_IWK';
            src: url("{{ asset('fonts/TegakBersambung_IWK.ttf') }}") format('truetype');
        }

        .color-block {
            width: 1rem;
            height: 1rem;
            border-radius: 0.25rem;
            display: inline-block;
            margin-right: 0.5rem;
            border: 1px solid rgba(0,0,0,0.1);
            vertical-align: middle;
        }

        .input-error-border {
            border-color: #ef4444 !important; /* Tailwind red-500 */
        }

        .hover-merah:hover { background-color: #fce7f3; } /* Pink-50 */
        .hover-biru:hover { background-color: #eff6ff; } /* Blue-50 */
        .hover-hijau:hover { background-color: #f0fdf4; } /* Green-50 */
        .hover-kuning:hover { background-color: #fffbeb; } /* Yellow-50 */
        .hover-ungu:hover { background-color: #f5f3ff; } /* Violet-50 */
        .hover-pink:hover { background-color: #fdf2f8; } /* Rose-50 */
        .hover-oranye:hover { background-color: #fff7ed; } /* Orange-50 */
        .hover-hitam:hover { background-color: #f3f4f6; } /* Gray-100 */

        .color-option {
            cursor: pointer;
            transition: background-color 0.15s ease;
        }

        .font-fredoka { font-family: 'Fredoka', sans-serif; }
        .font-mooli { font-family: 'Mooli', sans-serif; }
        .font-cursive { font-family: 'Tegak Bersambung_IWK', cursive; }

    </style>
</head>

<body class="min-h-screen bg-[var(--color-iqrain-blue)]">

    <div class="max-w-7xl mx-auto py-20 px-6 relative">
        <div class="lg:w-[calc(100%-500px)] lg:pr-10">

        <h1 class=" text-4xl lg:text-5xl font-fredoka font-bold text-white mb-6"
            style="text-shadow: 2px 2px 4px rgba(0,0,0,0.1);">
            Isi Pertanyaan Dulu Yuk !
        </h1>

        <p class="font-fredoka text-white text-lg mb-4 opacity-90">
            Pertanyaan keamanan kalau kamu lupa password
        </p>

        
        <div class="flex items-center mb-8 space-x-3">
            <div class="w-3 h-3 rounded-full bg-white opacity-60"></div> 
            <div class="w-8 h-8 rounded-full bg-yellow-400 text-white flex items-center justify-center font-bold">2</div>
            <div class="w-3 h-3 rounded-full bg-white opacity-60"></div>
        </div>

        {{-- Mengubah tampilan error agar lebih informatif --}}
        @if ($errors->any())
            <div class="mb-6 p-4 bg-red-100 border-l-4 border-red-600 text-red-700 rounded-lg">
                <p class="font-fredoka font-bold mb-2">Terjadi Kesalahan! Mohon periksa kembali isian Anda:</p>
                <ul class="list-disc ml-5 text-sm">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('register.murid.post') }}">
            @csrf
            <input type="hidden" name="step" value="2">

            <div class="bg-white rounded-2xl p-6 shadow-lg border-2 border-white">

                <label class="text-2xl font-fredoka text-pink-600 font-semibold block mb-3">
                    Pertanyaan Keamanan
                </label>

                <div class="w-full px-4 py-3 bg-blue-50 border-2 border-blue-300 rounded-xl mb-3">
                    <p class="font-fredoka text-gray-700 font-medium">Apa warna kesukaanmu?</p>
                </div>
                <input type="hidden" name="pertanyaan" value="Apa warna kesukaanmu?">

                <input type="hidden" name="jawaban" id="hidden_jawaban" value="{{ old('jawaban') }}" required>
                <div class="relative w-full" id="custom-dropdown">
                    
                    {{-- Tombol Tampil --}}
                    <button type="button" 
                        id="dropdown-button"
                        class="w-full px-4 py-3 text-left rounded-xl border-2 {{ $errors->has('jawaban') ? 'input-error-border' : 'border-white' }} text-gray-800 ring-2 ring-yellow-300 flex items-center justify-between transition duration-150 font-fredoka"
                        aria-haspopup="true" 
                        aria-expanded="false"
                    >
                        <span id="selected-color-display" class="flex items-center">
                            @php
                                $list_warna = [
                                    'Merah' => ['class' => 'bg-red-500', 'hover_class' => 'hover-merah'], 
                                    'Biru' => ['class' => 'bg-blue-500', 'hover_class' => 'hover-biru'], 
                                    'Hijau' => ['class' => 'bg-green-500', 'hover_class' => 'hover-hijau'], 
                                    'Kuning' => ['class' => 'bg-yellow-400', 'hover_class' => 'hover-kuning'], 
                                    'Ungu' => ['class' => 'bg-purple-500', 'hover_class' => 'hover-ungu'], 
                                    'Pink' => ['class' => 'bg-pink-500', 'hover_class' => 'hover-pink'], 
                                    'Oranye' => ['class' => 'bg-orange-500', 'hover_class' => 'hover-oranye'],
                                    'Hitam' => ['class' => 'bg-gray-800', 'hover_class' => 'hover-hitam'], 
                                ];
                                $old_jawaban = old('jawaban');
                                $display_class = $list_warna[$old_jawaban]['class'] ?? 'bg-transparent';
                            @endphp

                            @if($old_jawaban && array_key_exists($old_jawaban, $list_warna))
                                <span class="color-block {{ $display_class }}"></span>
                                {{ $old_jawaban }}
                            @else
                                Pilih Warna Kesukaanmu
                            @endif
                        </span>
                        
                        <svg class="h-5 w-5 ml-2 text-gray-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                    </button>

                    {{-- Daftar Opsi (Dropdown Menu) --}}
                    <div id="dropdown-menu" 
                         class="absolute z-10 mt-1 w-full bg-white rounded-xl shadow-lg border border-gray-200 hidden max-h-60 overflow-y-auto"
                         role="menu" 
                         aria-orientation="vertical" 
                         aria-labelledby="dropdown-button"
                    >
                        @foreach ($list_warna as $nama_warna => $data_warna)
                            <div class="color-option px-4 py-2 text-sm text-gray-700 flex items-center transition duration-150 {{ $data_warna['hover_class'] }}" 
                                 data-value="{{ $nama_warna }}" 
                                 data-class="{{ $data_warna['class'] }}"
                                 role="menuitem"
                            >
                                <span class="color-block {{ $data_warna['class'] }}"></span>
                                {{ $nama_warna }}
                            </div>
                        @endforeach
                    </div>
                </div>
                
                {{-- Pesan Error Validasi Spesifik --}}
                @error('jawaban')
                    <p class="text-red-600 text-sm mt-2 font-semibold">
                        ⚠️ {{ $message }}
                    </p>
                @enderror
                
                <p class="font-fredoka text-sm text-gray-600 mt-2">
                    💡 <strong>Tips:</strong> Ingat baik-baik jawabanmu ya! Jawaban ini akan dipakai jika kamu lupa password.
                </p>

                <div class="bg-yellow-50 rounded-xl p-4 mt-4 border border-yellow-300">
                    <p class="font-fredoka text-sm text-gray-700">
                        <strong class="text-pink-600 text-base">Kenapa hanya 1 pertanyaan?</strong><br>
                        Supaya lebih mudah diingat! Cukup ingat warna kesukaanmu saja 🌈
                    </p>
                </div>

            </div>

            <div class="mt-6 flex space-x-4">
                <a href="{{ route('register.murid') }}"
                    class="bg-gray-300 font-fredoka text-gray-800 font-bold py-3 px-10 rounded-xl shadow-lg 
                            hover:bg-gray-400 transition text-center flex-1">
                    Kembali
                </a>

                <button type="submit"
                    class="flex-1 bg-pink-400 text-white font-fredoka font-bold py-3 px-10 rounded-xl shadow-lg
                            hover:bg-pink-500 transition">
                    Daftar
                </button>
            </div>
        </form>

        <div class="border-t border-white mt-10 pt-4">
            <p class="font-fredoka text-white">
                Sudah punya akun?
                <a href="{{ route('login') }}" class="font-fredoka text-yellow-300">Klik untuk login</a>
            </p>
        </div>
    </div>
</div>

    <div class="absolute top-0 right-0 w-[500px] h-full hidden lg:block overflow-hidden">
        <img src="{{ asset('images/pattern/wafe-regist.webp') }}" 
            class="h-full object-fill"
            style="width: 700px; position: absolute; left: 0px;" alt="Background Pattern">
        <img src="{{ asset('images/maskot/ceria.webp') }}" 
            class="absolute bottom-0 right-0 w-[450px]" alt="Maskot Ceria">
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', () => {
        const dropdownButton = document.getElementById('dropdown-button');
        const dropdownMenu = document.getElementById('dropdown-menu');
        const hiddenInput = document.getElementById('hidden_jawaban');
        const selectedDisplay = document.getElementById('selected-color-display');
        const colorOptions = document.querySelectorAll('.color-option');

        dropdownButton.addEventListener('click', () => {
            const isExpanded = dropdownButton.getAttribute('aria-expanded') === 'true' || false;
            dropdownButton.setAttribute('aria-expanded', !isExpanded);
            dropdownMenu.classList.toggle('hidden');
        });

        colorOptions.forEach(option => {
            option.addEventListener('click', () => {
                const value = option.getAttribute('data-value');
                const className = option.getAttribute('data-class');

                hiddenInput.value = value;
                
                // Mengganti konten tampilan dengan kotak warna baru
                selectedDisplay.innerHTML = `<span class="color-block ${className}"></span> ${value}`;
                
                dropdownMenu.classList.add('hidden');
                dropdownButton.setAttribute('aria-expanded', 'false');

                // Menghapus border error
                dropdownButton.classList.remove('input-error-border');
            });
        });

        document.addEventListener('click', (event) => {
            const dropdown = document.getElementById('custom-dropdown');
            if (!dropdown.contains(event.target)) {
                dropdownMenu.classList.add('hidden');
                dropdownButton.setAttribute('aria-expanded', 'false');
            }
        });
        
        // Memastikan tampilan awal default jika tidak ada nilai lama
        if (!hiddenInput.value) {
             selectedDisplay.textContent = 'Pilih Warna Kesukaanmu';
        }
    });
</script>

</body>
</html>