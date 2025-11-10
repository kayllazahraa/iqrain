<?php

namespace App\Http\Controllers\Murid;

use App\Http\Controllers\Controller;
use App\Models\TingkatanIqra;
use App\Models\HasilGame;
use App\Models\ProgressModul;
use App\Models\Leaderboard;
use App\Models\Mentor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MuridDashboardController extends Controller
{
    public function index()
    {
        $murid = Auth::user()->murid;

        $stats = [
            'total_games_played' => $murid->hasilGames()->count(),
            'total_poin' => $murid->total_poin,
            'modules_completed' => $murid->progressModuls()->where('status', 'selesai')->count(),
            'global_ranking' => $murid->leaderboards()->whereNull('mentor_id')->first()->ranking_global ?? 0,
        ];

        $recent_games = $murid->hasilGames()
            ->with('jenisGame')
            ->latest('dimainkan_at')
            ->limit(5)
            ->get();

        $progress_data = ProgressModul::where('murid_id', $murid->murid_id)
            ->with('modul.materiPembelajaran')
            ->get()
            ->groupBy('modul.materiPembelajaran.tingkatan_id');

        return view('murid.dashboard', compact('stats', 'recent_games', 'progress_data'));
    }

    public function learning()
    {
        return view('murid.learning');
    }

    public function games()
    {
        return view('murid.games');
    }

    public function progress()
    {
        return view('murid.progress');
    }

    public function mentors()
    {
        return view('murid.mentors');
    }
}
