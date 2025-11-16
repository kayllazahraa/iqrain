<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Game - Pasangkan Huruf</title>
    
    <!-- Memuat CSS dan JS dari project Vite Laravel Anda -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- Token CSRF untuk kirim skor nanti -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <style>
        /* Gaya tambahan untuk feedback visual */
        .drop-target {
            transition: all 0.2s ease-in-out;
        }
        .drag-enter {
            border-style: dashed;
            border-color: #3b82f6; /* blue-500 */
            transform: scale(1.05);
        }
        .match-success {
            background-color: #dcfce7; /* green-100 */
            border-color: #22c55e; /* green-500 */
        }
        .match-fail {
            animation: shake 0.5s;
        }
        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            25% { transform: translateX(-5px); }
            75% { transform: translateX(5px); }
        }

        .dragging {
            opacity: 0.01;
        }
        
        /* Pastikan gambar pas di dalam kotak */
        .draggable {
            width: 100%;
            height: 100%;
            object-fit: contain;
        }
        .drop-target img {
            width: 100%;
            height: 100%;
            object-fit: contain;
        }
    </style>
</head>
<body class="bg-blue-100 min-h-screen flex items-center justify-center p-4" style="background-image: url('data:image/svg+xml;utf8,<svg xmlns=\"http://www.w2.org/2000/svg\" width=\"100\" height=\"100\" viewBox=\"0 0 100 100\"><text x=\"50%\" y=\"50%\" );">

    <!-- === KODE BARU ANDA (HTML) === -->
    <div id="welcome-backdrop" class="fixed inset-0 z-40 transition-opacity duration-1000" style="background-color: rgba(0, 0, 0, 0.6);"></div>
    <h1 id="welcome-message" class="fixed top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 z-50
                                      font-sans text-7xl md:text-8xl font-bold text-white 
                                      opacity-0 transition-opacity duration-1000 ease-out"
                                      style="text-shadow: 0 4px 10px rgba(0, 0, 0, 0.5);">
        Selamat Datang!
    </h1>
    <!-- === AKHIR KODE BARU === -->


    <div class="w-full max-w-4xl bg-white rounded-2xl shadow-xl p-6 md:p-8">

        <!-- Header -->
        <h1 class="text-3xl md:text-4xl font-bold text-center text-blue-800">Pasangkan Huruf</h1>
        <p class="text-center text-gray-600 mt-1">Tarik huruf hijaiyah sesuai dengan huruf latinnya!</p>

        <!-- Poin dan Tombol -->
        <div class="flex justify-between items-center my-6 p-4 bg-gray-50 rounded-lg">
            <div class="text-xl font-bold">
                Poin: <span id="skor" class="text-yellow-500 bg-gray-200 px-3 py-1 rounded-full">0</span>
            </div>
            <div class="text-xl font-bold">
                <span id="progress-count">0</span>/6
            </div>
            <button id="play-again" class="hidden bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg">
                Main Lagi
            </button>
        </div>

        <!-- Area Game -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            
            <!-- Kolom Hijaiyah (Draggable) -->
            <div class="bg-pink-50 rounded-lg p-4">
                <h2 class="text-2xl font-bold text-center text-pink-700 mb-4">Huruf Hijaiyah</h2>
                <div id="hijaiyah-container" class="grid grid-cols-3 gap-4">
                    <!-- Akan diisi oleh JavaScript -->
                </div>
            </div>

            <!-- Kolom Latin (Droppable) -->
            <div class="bg-purple-50 rounded-lg p-4">
                <h2 class="text-2xl font-bold text-center text-purple-700 mb-4">Huruf Latin</h2>
                <div id="latin-container" class="grid grid-cols-3 gap-4">
                    <!-- Akan diisi oleh JavaScript -->
                </div>
            </div>

        </div>
    </div>

    <!-- Animasi Masuk -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {

            const welcomeBackdrop = document.getElementById("welcome-backdrop");
            const welcomeMessage = document.getElementById("welcome-message");

            if (welcomeBackdrop && welcomeMessage) {
                // 1. Tampilkan teks (fade in)
                // Kita beri sedikit delay biar CSS awal opacity-0 kebaca dulu
                setTimeout(() => {
                    welcomeMessage.classList.remove("opacity-0"); // Tampilkan teks
                    welcomeMessage.classList.add("opacity-100"); // Pastikan opacity penuh
                }, 100); // Delay kecil agar transisi opacity-0 -> opacity-100 bekerja

                // 2. Setel alarm untuk menyembunyikan (fade out)
                setTimeout(() => {
                    welcomeMessage.classList.remove("opacity-100"); // Mulai fade out teks
                    welcomeMessage.classList.add("opacity-0"); // Pastikan opacity nol
                    
                    welcomeBackdrop.classList.remove("opacity-100"); // Mulai fade out backdrop
                    welcomeBackdrop.classList.add("opacity-0"); // Pastikan opacity nol

                    // 3. Setelah animasi fade out selesai, baru sembunyikan sepenuhnya (display: none)
                    setTimeout(() => {
                        welcomeBackdrop.classList.add("hidden");
                        welcomeMessage.classList.add("hidden");
                    }, 1000); // Tunggu selama durasi animasi (duration-1000ms = 1 detik)
                    
                }, 2000);
            }
           

            const allHijaiyah = {!! json_encode([
                ['id' => 'ain', 'latin' => 'Ain', 'imageFile' => asset('images/hijaiyah/ain.webp')],
                ['id' => 'alif', 'latin' => 'Alif', 'imageFile' => asset('images/hijaiyah/alif.webp')],
                ['id' => 'ba', 'latin' => 'Ba', 'imageFile' => asset('images/hijaiyah/ba.webp')],
                ['id' => 'dal', 'latin' => 'Dal', 'imageFile' => asset('images/hijaiyah/dal.webp')],
                ['id' => 'dhlo', 'latin' => 'Dho', 'imageFile' => asset('images/hijaiyah/dhlo.webp')],
                ['id' => 'dhod', 'latin' => 'Dhod', 'imageFile' => asset('images/hijaiyah/dhod.webp')],
                ['id' => 'dzal', 'latin' => 'Dzal', 'imageFile' => asset('images/hijaiyah/dzal.webp')],
                ['id' => 'fa', 'latin' => 'Fa', 'imageFile' => asset('images/hijaiyah/fa.webp')],
                ['id' => 'ghoin', 'latin' => 'Ghoin', 'imageFile' => asset('images/hijaiyah/ghoin.webp')],
                ['id' => 'hamzah', 'latin' => 'Hamzah', 'imageFile' => asset('images/hijaiyah/hamzah.webp')],
                ['id' => 'jim', 'latin' => 'Jim', 'imageFile' => asset('images/hijaiyah/jim.webp')],
                ['id' => 'kaf', 'latin' => 'Kaf', 'imageFile' => asset('images/hijaiyah/kaf.webp')],
                ['id' => 'kha', 'latin' => 'Kha', 'imageFile' => asset('images/hijaiyah/kha.webp')],
                ['id' => 'kho', 'latin' => 'Kho', 'imageFile' => asset('images/hijaiyah/kho.webp')],
                ['id' => 'lam', 'latin' => 'Lam', 'imageFile' => asset('images/hijaiyah/lam.webp')],
                ['id' => 'mim', 'latin' => 'Mim', 'imageFile' => asset('images/hijaiyah/mim.webp')],
                ['id' => 'nun', 'latin' => 'Nun', 'imageFile' => asset('images/hijaiyah/nun.webp')],
                ['id' => 'qof', 'latin' => 'Qof', 'imageFile' => asset('images/hijaiyah/qof.webp')],
                ['id' => 'ra', 'latin' => 'Ra', 'imageFile' => asset('images/hijaiyah/ra.webp')],
                ['id' => 'shod', 'latin' => 'Shod', 'imageFile' => asset('images/hijaiyah/shod.webp')],
                ['id' => 'sin', 'latin' => 'Sin', 'imageFile' => asset('images/hijaiyah/sin.webp')],
                ['id' => 'syin', 'latin' => 'Syin', 'imageFile' => asset('images/hijaiyah/syin.webp')],
                ['id' => 'ta', 'latin' => 'Ta', 'imageFile' => asset('images/hijaiyah/ta.webp')],
                ['id' => 'tho', 'latin' => 'Tho', 'imageFile' => asset('images/hijaiyah/tho.webp')],
                ['id' => 'tsa', 'latin' => 'Tsa', 'imageFile' => asset('images/hijaiyah/tsa.webp')],
                ['id' => 'wawu', 'latin' => 'Wawu', 'imageFile' => asset('images/hijaiyah/wawu.webp')],
                ['id' => 'ya', 'latin' => 'Ya', 'imageFile' => asset('images/hijaiyah/ya.webp')],
                ['id' => 'za', 'latin' => 'Za', 'imageFile' => asset('images/hijaiyah/za.webp')]
            ]) !!};

            function getGameRound(fullList, count) {
                // Di JS, `allHijaiyah` adalah array of objects
                const shuffled = [...fullList].map(item => ({
                    id: item.id,
                    latin: item.latin,
                    imageFile: item.imageFile
                })).sort(() => 0.5 - Math.random());
                return shuffled.slice(0, count);
            }

            function shuffleArray(array) {
                for (let i = array.length - 1; i > 0; i--) {
                    const j = Math.floor(Math.random() * (i + 1));
                    [array[i], array[j]] = [array[j], array[i]];
                }
            }

            function setupGame() {
                const hijaiyahContainer = document.getElementById('hijaiyah-container');
                const latinContainer = document.getElementById('latin-container');
                
                hijaiyahContainer.innerHTML = '';
                latinContainer.innerHTML = '';

                const gameLetters = getGameRound(allHijaiyah, 6);
                let hijaiyahElements = [];
                let latinElements = [];

                gameLetters.forEach(letter => {
                    const hijaiyahDiv = document.createElement('div');
                    hijaiyahDiv.className = 'w-24 h-24 p-2 rounded-lg shadow-md bg-white';
                    
                    // `letter.imageFile` sekarang sudah berisi URL LENGKAP
                    hijaiyahDiv.innerHTML = `<img id="drag-${letter.id}" src="${letter.imageFile}" alt="${letter.latin}" class="draggable cursor-grab active:cursor-grabbing">`;
                    hijaiyahElements.push(hijaiyahDiv);

                    const latinDiv = document.createElement('div');
                    latinDiv.className = 'drop-target w-24 h-24 flex items-center justify-center text-3xl font-bold text-purple-800 bg-white border-2 border-purple-200 rounded-lg shadow-inner';
                    latinDiv.dataset.match = `drag-${letter.id}`;
                    latinDiv.textContent = letter.latin;
                    latinElements.push(latinDiv);
                });

                shuffleArray(hijaiyahElements);
                shuffleArray(latinElements);

                hijaiyahElements.forEach(el => hijaiyahContainer.appendChild(el));
                latinElements.forEach(el => latinContainer.appendChild(el));

                attachDragDropListeners();
            }

            
            function attachDragDropListeners() {
                const draggables = document.querySelectorAll('.draggable');
                const dropTargets = document.querySelectorAll('.drop-target');
                
                draggables.forEach(draggable => {
                    draggable.addEventListener('dragstart', (e) => {
                        e.dataTransfer.setData('text/plain', e.target.id);
                        e.target.classList.add('dragging');
                        e.dataTransfer.setDragImage(e.target, e.target.clientWidth / 2, e.target.clientHeight / 2);
                    });

                    draggable.addEventListener('dragend', (e) => {
                        e.target.classList.remove('dragging');
                    });
                });

                dropTargets.forEach(target => {
                    target.addEventListener('dragenter', (e) => {
                        e.preventDefault();
                        if (!target.classList.contains('match-success')) {
                            target.classList.add('drag-enter');
                        }
                    });

                    target.addEventListener('dragleave', (e) => {
                        e.preventDefault();
                        target.classList.remove('drag-enter');
                    });

                    target.addEventListener('dragover', (e) => {
                        e.preventDefault();
                    });

                    target.addEventListener('drop', (e) => {
                        e.preventDefault();
                        target.classList.remove('drag-enter');

                        if (target.classList.contains('match-success')) {
                            return;
                        }

                        const draggedId = e.dataTransfer.getData('text/plain');
                        const draggedElement = document.getElementById(draggedId);
                        
                        if (!draggedElement) return;

                        if (target.dataset.match === draggedId) {
                            target.classList.add('match-success');
                            target.innerHTML = ''; 
                            target.appendChild(draggedElement); 

                            draggedElement.draggable = false;
                            draggedElement.classList.remove('cursor-grab', 'active:cursor-grabbing');
                            
                            if (draggedElement.parentElement) {
                                draggedElement.parentElement.classList.remove('shadow-md', 'bg-white');
                                draggedElement.parentElement.classList.add('bg-transparent');
                            }

                            currentScore += 10;
                            matchedCount++;
                            updateUI();
                            
                            if (matchedCount === totalMatches) {
                                endGame();
                            }

                        } else {
                            target.classList.add('match-fail');
                            setTimeout(() => {
                                target.classList.remove('match-fail');
                            }, 500);
                        }
                    });
                });
            }

            // --- Variabel Global & Fungsi UI ---
            const scoreElement = document.getElementById('skor');
            const progressElement = document.getElementById('progress-count');
            const playAgainButton = document.getElementById('play-again');

            let currentScore = 0;
            let matchedCount = 0;
            const totalMatches = 6; 

            function updateUI() {
                scoreElement.innerText = currentScore;
                progressElement.innerText = matchedCount;
            }

            function endGame() {
                playAgainButton.classList.remove('hidden');
                saveScoreToDatabase(currentScore);
            }

            playAgainButton.addEventListener('click', () => {
                location.reload();
            });
            
            setupGame();


            function saveScoreToDatabase(finalScore) {
                const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                const dataToSend = {
                    murid_id: 1, 
                    jenis_game_id: 1, 
                    skor: finalScore,
                };

                console.log('--- SIMULASI KIRIM KE DATABASE ---');
                console.log('Data:', JSON.stringify(dataToSend));
                console.log('------------------------------------');
            }
        });
    </script>

</body>
</html>