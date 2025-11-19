<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    {{-- PENTING: Meta Token CSRF (Diperlukan oleh script saveScore di bawah) --}}
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Labirin Hijaiyah</title>

    {{-- Memuat CSS/Tailwind (Sesuaikan dengan setup Laravel kamu, biasanya @vite atau mix) --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    {{-- Jika tampilan berantakan (Tailwind tidak jalan), kamu bisa uncomment CDN di bawah ini untuk sementara: --}}
    {{-- <script src="https://cdn.tailwindcss.com"></script> --}}

    {{-- CSS Kustom --}}
    <style>
        /* Wrapper Utama Game */
        #game-content-wrapper {
            position: relative;
            z-index: 1;
            overflow: hidden;
            min-height: 100vh;

            /* BACKGROUND BARU: Gradien Biru Sesuai Permintaan (tanpa pattern) */
            background: linear-gradient(180deg, #56B1F3 0%, #D3F2FF 100%);
        }

        /* HAPUS atau KOMENTARI bagian ::before yang terkait dengan pattern gambar */
        /* Kode ini dihapus atau dikomentari agar pattern tidak muncul */
        /*
        #game-content-wrapper::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-image: url('/images/games/game-pattern.webp');
            background-repeat: no-repeat;
            background-size: cover;
            background-attachment: fixed;
            background-position: center;
            opacity: 0.3;
            z-index: -1;
        }
        */

        /* Font Kustom */
        @font-face {
            font-family: 'Tegak Bersambung_IWK';
            src: url("{{ asset('fonts/TegakBersambung_IWK.ttf') }}") format('truetype');
        }

        .font-cursive-iwk {
            font-family: 'Tegak Bersambung_IWK', cursive !important;
        }

        /* Styling Grid Labirin */
        .maze-cell {
            width: 33px;
            height: 30px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 5px;
        }

        .maze-wall {
            background-color: #D75C82;
            /* Warna Dinding */
        }

        .maze-path {
            background-color: #D9D9D9;
            /* Warna Jalan */
        }
    </style>
</head>

{{-- PENTING: Ganti class "bg-gray-50" di tag body menjadi "bg-white" atau hapus saja --}}
{{-- Saya sarankan "bg-white" agar tidak ada warna abu-abu default yang menimpa --}}

<body class="bg-white">

    {{-- Konten Halaman --}}
    <div id="game-content-wrapper">
        <div class="p-4">
            {{-- Tombol Kembali --}}
            <a href="{{ route('murid.games.index', $tingkatan->tingkatan_id) }}"
                class="relative flex items-center justify-center w-[140px] h-[45px] rounded-full bg-[#FEFFD0] shadow-md transition-transform hover:scale-105">

                {{-- Ikon: Tetap di posisi kiri (absolute) --}}
                <div class="absolute left-4 flex items-center">
                    <svg class="w-6 h-6 text-gray-800" fill="none" stroke="currentColor" stroke-width="3"
                        viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"></path>
                    </svg>
                </div>

                {{-- Teks: Ditambah pl-4 agar geser ke kanan sedikit --}}
                <span class="font-cursive-iwk text-gray-800 text-[25px] font-normal leading-none pt-2 pl-4">
                    Kembali
                </span>
            </a>
        </div>

        <div class="container mx-auto p-2 max-w-4xl">

            {{-- Area Target Pencarian Huruf --}}
            <div class="mb-8 text-center flex flex-col items-center">
                <p class="text-[#AC3F61] font-cursive-iwk text-[36px] leading-tight">Cari huruf:</p>
                {{-- Menampilkan Nama Latin (Contoh: Ba-Ta-Tsa) --}}
                <div
                    class="min-w-[200px] px-6 h-[60px] rounded-[30px] bg-[#D75C82] flex items-center justify-center my-1 shadow-lg">
                    <p id="target-letters-display"
                        class="text-white font-cursive-iwk text-2xl leading-none tracking-wide">
                        {{ implode(' - ', $targetLetters) }}
                    </p>
                </div>
            </div>

            <div class="flex flex-col md:flex-row justify-center items-start gap-8">

                {{-- Kolom Kiri: Papan Game --}}
                <div class="w-full md:w-auto flex flex-col items-center md:items-start">

                    {{-- Tampilan Progres Skor --}}
                    <p id="skor-labirin-display" class="text-lg font-cursive-iwk text-gray-800 mb-2 pl-2">
                        Huruf: 0/4
                    </p>

                    {{-- Grid Labirin (Akan diisi JS) --}}
                    <div id="maze-grid"
                        class="grid gap-[11px] p-4 bg-white rounded-[34px] shadow-[0_4px_10px_0_rgba(0,0,0,0.50)] place-content-start">
                        {{-- Cells generated by JS --}}
                    </div>
                </div>

                {{-- Kolom Kanan: Tombol Kontrol --}}
                <div class="w-full md:w-auto flex flex-col items-center gap-6 pt-4 md:pt-10">

                    {{-- Tombol Reset / Main Lagi --}}
                    <button id="reset-button"
                        class="flex items-center justify-center gap-2 w-[140px] h-[45px] rounded-[35px] border-2 border-[#AC3F61] bg-white/80 hover:bg-white shadow-md transition-all font-cursive-iwk text-[#AC3F61] text-2xl">
                        <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"
                            stroke-linecap="round" stroke-linejoin="round">
                            <path d="M23 4v6h-6"></path>
                            <path d="M20.49 15a9 9 0 1 1-2.12-9.36L23 10"></path>
                        </svg>
                        Main lagi
                    </button>

                    {{-- D-PAD Kontrol Arah --}}
                    <div
                        class="grid grid-cols-3 grid-rows-3 items-center justify-items-center w-[180px] h-[180px] bg-white rounded-[30px] shadow-lg p-3">
                        <div class="col-start-2 row-start-1">
                            <button id="btn-up"
                                class="dpad-btn w-[45px] h-[45px] rounded-full bg-[#FFCE6B] shadow-md hover:scale-110 active:scale-95 transition-transform flex items-center justify-center">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#D75C82"
                                    stroke-width="4" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M12 4L12 20M12 4L6 10M12 4L18 10" />
                                </svg>
                            </button>
                        </div>
                        <div class="col-start-1 row-start-2">
                            <button id="btn-left"
                                class="dpad-btn w-[45px] h-[45px] rounded-full bg-[#FFCE6B] shadow-md hover:scale-110 active:scale-95 transition-transform flex items-center justify-center">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#D75C82"
                                    stroke-width="4" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M20 12L4 12M4 12L10 6M4 12L10 18" />
                                </svg>
                            </button>
                        </div>
                        <div
                            class="col-start-2 row-start-2 w-[25px] h-[25px] rounded-full bg-[#FFCE6B]/50 border-2 border-[#D75C82]">
                        </div>
                        <div class="col-start-3 row-start-2">
                            <button id="btn-right"
                                class="dpad-btn w-[45px] h-[45px] rounded-full bg-[#FFCE6B] shadow-md hover:scale-110 active:scale-95 transition-transform flex items-center justify-center">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#D75C82"
                                    stroke-width="4" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M4 12L20 12M20 12L14 6M20 12L14 18" />
                                </svg>
                            </button>
                        </div>
                        <div class="col-start-2 row-start-3">
                            <button id="btn-down"
                                class="dpad-btn w-[45px] h-[45px] rounded-full bg-[#FFCE6B] shadow-md hover:scale-110 active:scale-95 transition-transform flex items-center justify-center">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#D75C82"
                                    stroke-width="4" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M12 20L12 4M12 20L18 14M12 20L6 14" />
                                </svg>
                            </button>
                        </div>
                    </div>

                    <p class="font-cursive-iwk text-lg text-center text-red-500 px-4">
                        Gunakan panah layar atau keyboard untuk bergerak.
                    </p>
                </div>
            </div>
        </div>

        {{-- Spacer Bottom --}}
        <div class="h-24"></div>
    </div>

    {{-- JavaScript Game --}}
    <script>
        // --- 1. DATA DARI CONTROLLER ---
        window.gameData = {
            mapLayout: @json($mapLayout),
            targetLetters: @json($targetLetters),
            targetFiles: @json($targetFiles)
        };
        
        // const gameStaticId = null; 
        // Ambil ID langsung dari $jenisGame
        const jenisGameId = {{ $jenisGame->jenis_game_id }};

        // URL Routes
        const saveScoreUrl = '{{ route('murid.game.saveScore') }}';
        const redirectUrl = '{{ route('murid.games.index', $tingkatan->tingkatan_id) }}';

        // --- 2. FUNGSI SIMPAN SKOR (ASYNC) ---
        async function saveScore(skor, poin) {
            // Cek validitas ID game
            if (!jenisGameId) {
                console.error("JenisGameID hilang. Skor tidak akan disimpan.");
                alert("Terjadi kesalahan konfigurasi game. Skor tidak tersimpan.");
                return;
            }

            try {
                // Kirim Request ke Server
                const response = await fetch(saveScoreUrl, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        // Ambil CSRF Token dari meta tag Laravel
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({                        
                        jenis_game_id: jenisGameId,                      
                        skor: skor,
                        total_poin: poin
                    })
                });

                const data = await response.json();

                // Jika Sukses
                if (data.success) {
                    console.log("Skor Berhasil Disimpan!", data);                    
                    alert("Alhamdulillah! Kamu berhasil menyelesaikan Labirin!\nPoin kamu: " + data.poin_didapat);                    
                    location.reload();
                } else {
                    console.error("Gagal response:", data);
                    alert("Gagal menyimpan skor.");
                }

            } catch (error) {
                console.error('Error saving score:', error);
                alert("Terjadi kesalahan koneksi saat menyimpan skor.");
            }
        }

        // --- 3. LOGIKA UTAMA GAME ---
        document.addEventListener("DOMContentLoaded", () => {
            const gridContainer = document.getElementById("maze-grid");
            const scoreDisplay = document.getElementById("skor-labirin-display");

            // Ambil data dari object window
            const mapLayout = window.gameData.mapLayout;
            const targetFiles = window.gameData.targetFiles; // File gambar huruf yang harus dicari

            const gridRows = 8;
            const gridCols = 9;

            // State Game
            let playerPosition = {
                x: 0,
                y: 0
            };
            let collectedLetters = [];
            let gameItems = [];

            // A. Render Papan
            function renderBoard() {
                gridContainer.innerHTML = "";
                // Setup CSS Grid dinamis sesuai jumlah kolom
                gridContainer.style.gridTemplateColumns = `repeat(${gridCols}, minmax(0, 1fr))`;

                for (let y = 0; y < gridRows; y++) {
                    for (let x = 0; x < gridCols; x++) {
                        const cell = document.createElement("div");
                        cell.className = "maze-cell"; // Kelas dasar
                        cell.dataset.x = x;
                        cell.dataset.y = y;

                        // Cek Tembok (1) atau Jalan (0)
                        if (mapLayout[y][x] === 1) {
                            cell.classList.add("maze-wall");
                        } else {
                            cell.classList.add("maze-path");
                        }
                        gridContainer.appendChild(cell);
                    }
                }
            }

            // B. Penempatan Item Random
            function placeItems() {
                const validCells = [];

                // Cari semua sel jalan (0)
                for (let y = 0; y < gridRows; y++) {
                    for (let x = 0; x < gridCols; x++) {
                        if (mapLayout[y][x] === 0) {
                            validCells.push({
                                x,
                                y
                            });
                        }
                    }
                }

                // Acak posisi
                shuffleArray(validCells);

                if (validCells.length < 6) {
                    console.error("Map terlalu kecil untuk menampung item!");
                    return;
                }

                // Ambil posisi unik untuk Player, 4 Huruf, 1 Finish
                const playerPos = validCells.pop();
                const letterPos1 = validCells.pop();
                const letterPos2 = validCells.pop();
                const letterPos3 = validCells.pop();
                const letterPos4 = validCells.pop();
                const goalPos = validCells.pop();

                // Set Posisi Player
                playerPosition = playerPos;

                // Set Data Item
                gameItems = [{
                        type: 'letter',
                        value: targetFiles[0],
                        ...letterPos1,
                        collected: false
                    },
                    {
                        type: 'letter',
                        value: targetFiles[1],
                        ...letterPos2,
                        collected: false
                    },
                    {
                        type: 'letter',
                        value: targetFiles[2],
                        ...letterPos3,
                        collected: false
                    },
                    {
                        type: 'letter',
                        value: targetFiles[3],
                        ...letterPos4,
                        collected: false
                    },
                    {
                        type: 'goal',
                        ...goalPos,
                        collected: false
                    }
                ];

                updateItemDisplay();
            }

            // C. Update Tampilan Item di Grid
            function updateItemDisplay() {
                // Hapus item lama
                gridContainer.querySelectorAll('.game-item').forEach(item => item.remove());

                // 1. Gambar Player
                const playerCell = getCell(playerPosition.x, playerPosition.y);
                if (playerCell) {
                    const playerIcon = document.createElement('div');
                    playerIcon.className = "game-item w-full h-full flex items-center justify-center animate-pulse";
                    playerIcon.innerHTML =
                        `<img src="/images/games/qira-labirin.webp" alt="Player" class="w-full h-full object-contain drop-shadow-md">`;
                    playerCell.appendChild(playerIcon);
                }

                // 2. Gambar Item (Huruf & Goal)
                gameItems.forEach(item => {
                    if (item.collected) return; // Jangan gambar jika sudah diambil

                    const itemCell = getCell(item.x, item.y);
                    if (itemCell) {
                        const itemIcon = document.createElement('div');
                        itemIcon.className = "game-item w-full h-full flex items-center justify-center";

                        if (item.type === 'letter') {
                            // Gambar Huruf
                            itemIcon.innerHTML =
                                `<img src="/images/hijaiyah/${item.value}" alt="Hijaiyah" class="w-5 h-5 object-contain hover:scale-125 transition-transform">`;
                        } else {
                            // Gambar Goal (Bendera/Pintu)
                            itemIcon.innerHTML =
                                `<img src="/images/games/finish-labirin.webp" alt="Finish" class="w-full h-full object-contain">`;
                        }
                        itemCell.appendChild(itemIcon);
                    }
                });
            }

            // D. Gerakan Player
            function movePlayer(dx, dy) {
                const newX = playerPosition.x + dx;
                const newY = playerPosition.y + dy;

                // Cek batas grid
                if (newX < 0 || newX >= gridCols || newY < 0 || newY >= gridRows) return;

                // Cek tabrak tembok
                if (mapLayout[newY][newX] === 1) return;

                // Update Posisi
                playerPosition.x = newX;
                playerPosition.y = newY;

                updateItemDisplay();
                checkCollisionWithItems();
            }

            // E. Cek Tabrakan dengan Item (Logika Menang)
            function checkCollisionWithItems() {
                // Cari item di posisi player saat ini yang belum diambil
                const item = gameItems.find(i =>
                    !i.collected && i.x === playerPosition.x && i.y === playerPosition.y
                );

                if (!item) return;

                if (item.type === 'letter') {
                    // Jika kena huruf
                    item.collected = true;
                    collectedLetters.push(item.value);

                    // Update teks skor
                    scoreDisplay.textContent = `Huruf: ${collectedLetters.length}/4`;

                    // Refresh tampilan (hilangkan huruf dari grid)
                    updateItemDisplay();

                } else if (item.type === 'goal') {
                    // Jika kena goal
                    if (collectedLetters.length === 4) {
                        // MENANG!
                        // Panggil fungsi saveScore dengan nilai 100
                        // Controller akan memastikan ini aman
                        saveScore(100, 100);
                    } else {
                        // Belum lengkap
                        alert(`Belum selesai! Kumpulkan ${4 - collectedLetters.length} huruf lagi.`);
                    }
                }
            }

            // Helper: Ambil elemen DIV cell berdasarkan koordinat
            function getCell(x, y) {
                return gridContainer.querySelector(`div[data-x='${x}'][data-y='${y}']`);
            }

            // Helper: Acak Array (Fisher-Yates Shuffle)
            function shuffleArray(array) {
                for (let i = array.length - 1; i > 0; i--) {
                    const j = Math.floor(Math.random() * (i + 1));
                    [array[i], array[j]] = [array[j], array[i]];
                }
            }

            // --- 4. EVENT LISTENERS (INPUT) ---

            // Tombol Layar (Mouse/Touch)
            document.getElementById("btn-up").onclick = () => movePlayer(0, -1);
            document.getElementById("btn-down").onclick = () => movePlayer(0, 1);
            document.getElementById("btn-left").onclick = () => movePlayer(-1, 0);
            document.getElementById("btn-right").onclick = () => movePlayer(1, 0);

            // Keyboard (Arrow Keys)
            document.addEventListener("keydown", (e) => {
                // Mencegah scrolling halaman saat main game
                if (["ArrowUp", "ArrowDown", "ArrowLeft", "ArrowRight"].indexOf(e.code) > -1) {
                    e.preventDefault();
                }

                switch (e.key) {
                    case "ArrowUp":
                        movePlayer(0, -1);
                        break;
                    case "ArrowDown":
                        movePlayer(0, 1);
                        break;
                    case "ArrowLeft":
                        movePlayer(-1, 0);
                        break;
                    case "ArrowRight":
                        movePlayer(1, 0);
                        break;
                }
            });

            // Tombol Reset
            document.getElementById("reset-button").onclick = () => {
                location.reload();
            };

            // --- 5. MULAI GAME ---
            renderBoard();
            placeItems();
        });
    </script>
</body>

</html>
