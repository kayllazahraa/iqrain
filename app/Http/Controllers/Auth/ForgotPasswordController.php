<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Validator;

class ForgotPasswordController extends Controller
{
    // STEP 1: Tampilkan Form Username
    public function showUsernameForm()
    {
        return view('auth.forgot-password-murid-username');
    }

    // STEP 2: Identifikasi User & Role
    public function checkUsername(Request $request)
    {
        $request->validate(['username' => 'required|exists:users,username']);

        $user = User::where('username', $request->username)->first();

        // Simpan username di session untuk langkah selanjutnya
        session(['reset_username' => $user->username]);

        // Logika Percabangan Role
        if ($user->hasRole('murid')) {
            return redirect()->route('password.murid.question');
        } elseif ($user->hasRole('mentor')) {
            return redirect()->route('password.mentor.email');
        } else {
            return back()->with('error', 'Role tidak diizinkan untuk reset password mandiri.');
        }
    }

    /*
    |--------------------------------------------------------------------------
    | ALUR MURID (Security Question)
    |--------------------------------------------------------------------------
    */

    public function showMuridQuestion()
    {
        $username = session('reset_username');
        if (!$username) return redirect()->route('password.request');

        $user = User::where('username', $username)->first();
        // Mengambil pertanyaan dari relasi PreferensiPertanyaan
        $preferensi = $user->murid->preferensiPertanyaan;

        if (!$preferensi) {
            return redirect()->route('login')->with('error', 'Anda belum mengatur pertanyaan keamanan.');
        }

        return view('auth.forgot-password-murid-questions', [
            'pertanyaan' => $preferensi->pertanyaan //
        ]);
    }

    public function verifyMuridAnswer(Request $request)
    {
        $username = session('reset_username');
        $user = User::where('username', $username)->first();
        
        // Mengambil jawaban hash dari DB
        $preferensi = $user->murid->preferensiPertanyaan;

        // Verifikasi jawaban (Case Insensitive sesuai logika di MODEL (1).txt atau manual check)
        // Asumsi jawaban di DB plain text atau di-hash, sesuaikan disini.
        // Contoh sederhana case-insensitive check:
        if (strtolower($request->jawaban) === strtolower($preferensi->jawaban)) {
            // Jika benar, beri akses reset
            session(['can_reset_password' => true]);
            return redirect()->route('password.reset.form');
        }

        return back()->with('error', 'Jawaban salah, coba lagi.');
    }

    /*
    |--------------------------------------------------------------------------
    | ALUR MENTOR (Email Verification)
    |--------------------------------------------------------------------------
    */

    public function showMentorEmailForm()
    {
        if (!session('reset_username')) return redirect()->route('password.request');
        return view('auth.forgot-password-mentor-email');
    }


    public function verifyMentorEmail(Request $request)
    {
        $request->validate(['email' => 'required|email']);
        
        $username = session('reset_username');
        $user = User::where('username', $username)->first();

        if (!$user || !$user->mentor) {
            return back()->with('error', 'Data akun Mentor tidak ditemukan atau tidak lengkap. Silakan hubungi admin.');
        }
        
        $mentorEmail = $user->mentor->email;

        if ($mentorEmail !== $request->email) {
            return back()->with('error', 'Alamat email tidak cocok dengan data pendaftaran Mentor.');
        }
        
        try {
            $token = Password::broker()->createToken($user);
            $user->sendPasswordResetNotification($token);

            return back()->with('status', 'Tautan reset password telah dikirim ke email: ' . $mentorEmail);
        
        } catch (\Exception $e) {
            \Log::error('Gagal mengirim email reset password Mentor: ' . $e->getMessage());
            return back()->with('error', 'Gagal mengirim email reset password. Silakan coba lagi.');
        }
    }

    public function showResetForm(Request $request)
{
    $isMuridApproved = session('can_reset_password');
    $token = $request->route('token');

    if (!$isMuridApproved && !$token) {
        return redirect()->route('login');
    }

    if ($token) {
        return view('auth.reset-password', [
            'token' => $token, 
            'email' => $request->email 
        ]);
    }

    if ($isMuridApproved) {
        return view('auth.forgot-password-murid-reset', [
            'username' => session('reset_username'),
            'token' => null, // Dibuat null agar tidak terjadi error Undefined
            'email' => null, // Dibuat null
        ]);
    }
    
    return redirect()->route('login')->with('error', 'Akses reset password tidak valid.');
}

    public function updatePassword(Request $request)
    {
        $request->validate([
            'password' => 'required|confirmed|min:8',
        ]);

        // LOGIKA MENYIMPAN PASSWORD BARU
        
        // KASUS 1: MURID (Via Session)
        if (session('can_reset_password')) {
            $username = session('reset_username');
            $user = User::where('username', $username)->first();
            
            $user->forceFill([
                'password' => Hash::make($request->password)
            ])->save();

            // Bersihkan session
            session()->forget(['reset_username', 'can_reset_password']);

            return redirect()->route('login')->with('status', 'Password berhasil diperbarui. Silakan login kembali.');
        }

        // KASUS 2: MENTOR (Via Token Laravel Standard)
        $status = Password::broker()->reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->save();
            }
        );

        return $status == Password::PASSWORD_RESET
            ? redirect()->route('login')->with('status', 'Password berhasil diperbarui. Silakan login kembali.')
            : back()->withErrors(['email' => __($status)]);
    }
}