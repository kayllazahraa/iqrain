<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Murid;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class ForgotPasswordMuridController extends Controller
{
    /**
     * Show form untuk input username
     */
    public function showUsernameForm()
    {
        return view('auth.forgot-password-murid-username');
    }

    /**
     * Check username dan tampilkan pertanyaan preferensi
     */
    public function checkUsername(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => ['required', 'string', 'exists:users,username'],
        ], [
            'username.required' => 'Username harus diisi',
            'username.exists' => 'Username tidak ditemukan',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $user = User::where('username', $request->username)->first();

        // Check if user is murid
        if (!$user->hasRole('murid')) {
            return back()->with('error', 'Akun ini bukan akun murid. Gunakan fitur reset password melalui email untuk mentor.');
        }

        $murid = $user->murid;

        if (!$murid || !$murid->preferensi_terisi) {
            return back()->with('error', 'Anda belum mengisi pertanyaan keamanan. Silakan hubungi admin.');
        }

        $preferensi = $murid->preferensiPertanyaan;

        if (!$preferensi) {
            return back()->with('error', 'Data pertanyaan keamanan tidak ditemukan. Silakan hubungi admin.');
        }

        // Store username in session
        session(['forgot_password_username' => $request->username]);

        return view('auth.forgot-password-murid-questions', [
            'pertanyaan' => $preferensi->pertanyaan,
        ]);
    }

    /**
     * Verify answer dan tampilkan form reset password
     */
    public function verifyAnswer(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'jawaban' => ['required', 'string'],
        ], [
            'jawaban.required' => 'Jawaban harus diisi',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator);
        }

        $username = session('forgot_password_username');

        if (!$username) {
            return redirect()->route('password.murid.request')
                ->with('error', 'Sesi telah berakhir. Silakan mulai dari awal.');
        }

        $user = User::where('username', $username)->first();
        $murid = $user->murid;
        $preferensi = $murid->preferensiPertanyaan;

        // Verify answer (case insensitive)
        $isCorrect = $preferensi->verifyAnswer($request->jawaban);

        if (!$isCorrect) {
            return back()->with('error', 'Jawaban tidak sesuai. Silakan coba lagi.');
        }

        // Store verification status in session
        session(['password_reset_verified' => true]);

        return view('auth.forgot-password-murid-reset');
    }

    /**
     * Reset password
     */
    public function resetPassword(Request $request)
    {
        if (!session('password_reset_verified')) {
            return redirect()->route('password.murid.request')
                ->with('error', 'Verifikasi gagal. Silakan mulai dari awal.');
        }

        $validator = Validator::make($request->all(), [
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ], [
            'password.required' => 'Password baru harus diisi',
            'password.min' => 'Password minimal 8 karakter',
            'password.confirmed' => 'Konfirmasi password tidak cocok',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator);
        }

        $username = session('forgot_password_username');
        $user = User::where('username', $username)->first();

        // Update password
        $user->password = Hash::make($request->password);
        $user->save();

        // Clear session
        session()->forget(['forgot_password_username', 'password_reset_verified']);

        return redirect()->route('login')
            ->with('success', 'Password berhasil diubah! Silakan login dengan password baru Anda.');
    }
}
