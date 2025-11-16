<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Mentor;
use App\Models\Murid;
use App\Models\HasilGame;
use App\Models\SoalDragDrop;
use App\Models\VideoPembelajaran;
use App\Models\PermintaanBimbingan;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\DataFeed;

class AdminDashboardController extends Controller
{
    public function index()
    {
        // Get comprehensive statistics
        $stats = [
            // User Statistics
            'total_users' => User::count(),
            'total_mentors' => Mentor::count(),
            'total_murids' => Murid::count(),
            'active_murids' => Murid::whereHas('hasilGames', function ($query) {
                $query->where('dimainkan_at', '>=', now()->subDays(7));
            })->count(),

            // Mentor Approval Statistics
            'pending_mentors' => Mentor::where('status_approval', 'pending')->count(),
            'approved_mentors' => Mentor::where('status_approval', 'approved')->count(),
            'rejected_mentors' => Mentor::where('status_approval', 'rejected')->count(),

            // Content Statistics
            'total_videos' => VideoPembelajaran::count(),
            'total_soal' => SoalDragDrop::count(),
            'pending_soal' => SoalDragDrop::where('status_approval', 'pending')->count(),

            // Activity Statistics
            'total_games_played' => HasilGame::count(),
            'games_today' => HasilGame::whereDate('dimainkan_at', today())->count(),
            'games_this_week' => HasilGame::where('dimainkan_at', '>=', now()->subDays(7))->count(),

            // Bimbingan Requests
            'pending_requests' => PermintaanBimbingan::where('status', 'pending')->count(),
            'approved_requests' => PermintaanBimbingan::where('status', 'approved')->count(),
        ];

        // Recent Activities - Last 10 game plays
        $recent_activities = HasilGame::with(['murid.user', 'jenisGame'])
            ->latest('dimainkan_at')
            ->limit(10)
            ->get();

        // Pending Mentor Approvals
        $pending_mentors = Mentor::with('user')
            ->where('status_approval', 'pending')
            ->latest('created_at')
            ->limit(5)
            ->get();

        // Top Performers - Students with highest points
        $top_murids = Murid::with('user')
            ->withSum('hasilGames', 'total_poin')
            ->orderBy('hasil_games_sum_total_poin', 'desc')
            ->limit(5)
            ->get();

        // Game Statistics by Type
        $game_stats = DB::table('hasil_games')
            ->join('jenis_games', 'hasil_games.jenis_game_id', '=', 'jenis_games.jenis_game_id')
            ->select('jenis_games.nama_game', DB::raw('COUNT(*) as total_plays'), DB::raw('AVG(hasil_games.skor) as avg_score'))
            ->groupBy('jenis_games.nama_game', 'jenis_games.jenis_game_id')
            ->get();

        // Weekly Activity Chart Data (last 7 days)
        $weekly_data = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i);
            $weekly_data[] = [
                'date' => $date->format('M d'),
                'games' => HasilGame::whereDate('dimainkan_at', $date->toDateString())->count(),
                'students' => Murid::whereHas('hasilGames', function ($query) use ($date) {
                    $query->whereDate('dimainkan_at', $date->toDateString());
                })->count(),
            ];
        }

        return view('pages.admin.dashboard', compact(
            'stats',
            'recent_activities',
            'pending_mentors',
            'top_murids',
            'game_stats',
            'weekly_data'
        ));
    }

    public function approval()
    {
        return view('pages.admin.approval.index');
    }

    public function mentors()
    {
        return view('admin.mentors');
    }

    public function murids()
    {
        return view('admin.murids');
    }

    public function activities()
    {
        return view('admin.activities');
    }

    public function content()
    {
        return view('admin.content');
    }

    public function soalManagement()
    {
        return view('admin.soal-management');
    }
}
