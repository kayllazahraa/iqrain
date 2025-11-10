<?php

namespace App\Http\Controllers\Mentor;

use App\Http\Controllers\Controller;
use App\Models\Murid;
use App\Models\HasilGame;
use App\Models\PermintaanBimbingan;
use App\Models\SoalDragDrop;
use App\Models\Leaderboard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MentorDashboardController extends Controller
{
    public function index()
    {
        $mentor = Auth::user()->mentor;

        $stats = [
            'total_murids' => $mentor->murids()->count(),
            'pending_requests' => $mentor->permintaanBimbingans()->where('status', 'pending')->count(),
            'total_soal_created' => $mentor->soalDragDrops()->count(),
            'avg_murid_score' => $mentor->murids()
                ->join('hasil_games', 'murids.murid_id', '=', 'hasil_games.murid_id')
                ->avg('hasil_games.skor') ?? 0,
        ];

        $recent_activities = HasilGame::whereIn('murid_id', $mentor->murids()->pluck('murid_id'))
            ->with(['murid.user', 'jenisGame'])
            ->latest('dimainkan_at')
            ->limit(10)
            ->get();

        $top_murids = Leaderboard::where('mentor_id', $mentor->mentor_id)
            ->with('murid.user')
            ->orderBy('ranking_mentor')
            ->limit(5)
            ->get();

        return view('mentor.dashboard', compact('stats', 'recent_activities', 'top_murids'));
    }

    public function murids()
    {
        return view('mentor.murids');
    }

    public function progress()
    {
        return view('mentor.progress');
    }

    public function soal()
    {
        return view('mentor.soal');
    }

    public function leaderboard()
    {
        return view('mentor.leaderboard');
    }

    public function requests()
    {
        return view('mentor.requests');
    }
}
