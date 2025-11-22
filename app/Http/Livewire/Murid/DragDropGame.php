<?php

namespace App\Http\Controllers\Murid;

use App\Http\Controllers\Controller;
// Hapus atau abaikan penggunaan Model SoalDragDrop karena sudah dihapus
// use App\Models\SoalDragDrop; 
use App\Models\HasilGame; // Tambahkan ini untuk menyimpan hasil
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DragDropGame extends Controller
{
    // Data statis 30 huruf hijaiyah dan terjemahan latinnya
    private $hijaiyahData = [
        ['gambar_hijaiyah' => 'images/hijaiyah/alif.webp', 'jawaban_latin' => 'Alif'],
        ['gambar_hijaiyah' => 'images/hijaiyah/ba.webp', 'jawaban_latin' => 'Ba'],
        ['gambar_hijaiyah' => 'images/hijaiyah/ta.webp', 'jawaban_latin' => 'Ta'],
        ['gambar_hijaiyah' => 'images/hijaiyah/tsa.webp', 'jawaban_latin' => 'Tsa'],
        ['gambar_hijaiyah' => 'images/hijaiyah/jim.webp', 'jawaban_latin' => 'Jim'],
        ['gambar_hijaiyah' => 'images/hijaiyah/kha.webp', 'jawaban_latin' => 'Kha'],
        ['gambar_hijaiyah' => 'images/hijaiyah/kho.webp', 'jawaban_latin' => 'Kho'],
        ['gambar_hijaiyah' => 'images/hijaiyah/dal.webp', 'jawaban_latin' => 'Dal'],
        ['gambar_hijaiyah' => 'images/hijaiyah/dzal.webp', 'jawaban_latin' => 'Dzal'],
        ['gambar_hijaiyah' => 'images/hijaiyah/ra.webp', 'jawaban_latin' => 'Ra'],
        ['gambar_hijaiyah' => 'images/hijaiyah/Zayn.webp', 'jawaban_latin' => 'Zay'],
        ['gambar_hijaiyah' => 'images/hijaiyah/sin.webp', 'jawaban_latin' => 'Sin'],
        ['gambar_hijaiyah' => 'images/hijaiyah/syin.webp', 'jawaban_latin' => 'Syin'],
        ['gambar_hijaiyah' => 'images/hijaiyah/Sad.webp', 'jawaban_latin' => 'Sad'],
        ['gambar_hijaiyah' => 'images/hijaiyah/Dhad.webp', 'jawaban_latin' => 'Dhad'],
        ['gambar_hijaiyah' => 'images/hijaiyah/Tha.webp', 'jawaban_latin' => 'Tha'],
        ['gambar_hijaiyah' => 'images/hijaiyah/Zha.webp', 'jawaban_latin' => 'Zha'],
        ['gambar_hijaiyah' => 'images/hijaiyah/ain.webp', 'jawaban_latin' => 'Ain'],
        ['gambar_hijaiyah' => 'images/hijaiyah/Ghain.webp', 'jawaban_latin' => 'Ghain'],
        ['gambar_hijaiyah' => 'images/hijaiyah/fa.webp', 'jawaban_latin' => 'Fa'],
        ['gambar_hijaiyah' => 'images/hijaiyah/Qaf.webp', 'jawaban_latin' => 'Qaf'],
        ['gambar_hijaiyah' => 'images/hijaiyah/kaf.webp', 'jawaban_latin' => 'Kaf'],
        ['gambar_hijaiyah' => 'images/hijaiyah/lam.webp', 'jawaban_latin' => 'Lam'],
        ['gambar_hijaiyah' => 'images/hijaiyah/mim.webp', 'jawaban_latin' => 'Mim'],
        ['gambar_hijaiyah' => 'images/hijaiyah/nun.webp', 'jawaban_latin' => 'Nun'],
        ['gambar_hijaiyah' => 'images/hijaiyah/Waw.webp', 'jawaban_latin' => 'Waw'],
        ['gambar_hijaiyah' => 'images/hijaiyah/Ha.webp', 'jawaban_latin' => 'Ha'],
        ['gambar_hijaiyah' => 'images/hijaiyah/ya.webp', 'jawaban_latin' => 'Ya'],
        ['gambar_hijaiyah' => 'images/hijaiyah/hamzah.webp', 'jawaban_latin' => 'Hamzah'],
        ['gambar_hijaiyah' => 'images/hijaiyah/Lamalif.webp', 'jawaban_latin' => 'Lamalif'],
    ];

    public function dragDrop()
    {
        $allSoal = collect($this->hijaiyahData); 

        // Pilih 10 soal secara acak (shuffle dan ambil 10)
        $jumlahSoal = min(10, $allSoal->count());
        $soalGame = $allSoal->shuffle()->take($jumlahSoal);

        $dataSoal = [];
        $jawabanLatin = [];
        $soalIdCounter = 1;

        foreach ($soalGame as $soal) {
            $dataSoal[] = [
                'soal_id' => $soalIdCounter++, 
                'gambar_hijaiyah' => $soal['gambar_hijaiyah'],
                'jawaban_latin' => $soal['jawaban_latin'], 
            ];
            $jawabanLatin[] = $soal['jawaban_latin'];
        }

        shuffle($jawabanLatin);

        $dataGame = [
            'soal' => $dataSoal,
            'targetLatin' => $jawabanLatin,
            'jumlahSoal' => $jumlahSoal,
        ];

        return view('pages.murid.games.drag-drop', $dataGame);
    }
    
    public function submitDragDrop(Request $request)
    {
        $request->validate([
            'score' => 'required|integer',
            'total' => 'required|integer',
        ]);

        $user = Auth::user();
        $murid = $user->murid;

        if (!$murid) {
            return response()->json(['success' => false, 'message' => 'Data Murid tidak ditemukan.'], 404);
        }

        $jenisGame = \App\Models\JenisGame::where('nama_game', 'Seret & Lepas')->first(); 
        $gameId = $jenisGame ? $jenisGame->jenis_game_id : 1; 

        HasilGame::create([
            'murid_id' => $murid->murid_id,
            'jenis_game_id' => $gameId, 
            'tanggal_main' => now(),
            'skor' => $request->score,
            'total_soal' => $request->total,
            'tingkatan_id' => $murid->tingkatan_id ?? 1,
        ]);

        return response()->json([
            'success' => true, 
            'message' => 'Hasil game berhasil disimpan.',
            'skor' => $request->score,
            'total' => $request->total
        ]);
    }

    // ... method lain ...
}