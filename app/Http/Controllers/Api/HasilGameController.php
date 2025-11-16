<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HasilGameController extends Controller
{
    //
}
// Di dalam App/Http/Controllers/Api/HasilGameController.php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\HasilGame; // Pastikan Anda punya Model ini
// use Illuminate\Support\Facades\Auth; // Jika pakai otentikasi

class HasilGameController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'murid_id' => 'required|integer|exists:murids,id',
            'jenis_game_id' => 'required|integer|exists:jenis_games,id',
            'skor' => 'required|integer',
        ]);

        // $muridId = Auth::id(); // Cara lebih aman jika user login

        $hasil = HasilGame::create([
            'murid_id' => $request->murid_id, 
            // 'murid_id' => $muridId, // Versi aman
            'jenis_game_id' => $request->jenis_game_id,
            'skor' => $request->skor,
        ]);

        // (Logika untuk update leaderboard bisa ditambahkan di sini)

        return response()->json([
            'message' => 'Skor berhasil disimpan!',
            'data' => $hasil
        ], 201);
    }
}