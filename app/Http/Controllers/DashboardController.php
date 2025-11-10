<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if ($user->hasRole('admin')) {
            return redirect()->route('admin.dashboard');
        } elseif ($user->hasRole('mentor')) {
            // Check if mentor is approved
            if ($user->mentor && $user->mentor->status_approval !== 'approved') {
                // 1. Logout pengguna yang baru saja login
                auth()->guard('web')->logout();

                // 2. Bersihkan session-nya
                request()->session()->invalidate();
                request()->session()->regenerateToken();

                // 3. Tampilkan halaman pending (sekarang dalam keadaan logged-out)
                return redirect()->route('register.mentor.pending');
            }
            return redirect()->route('mentor.dashboard');
        } elseif ($user->hasRole('murid')) {
            return redirect()->route('murid.dashboard');
        }

        // Fallback
        return redirect()->route('landing');
    }
}