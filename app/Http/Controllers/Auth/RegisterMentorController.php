<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Mentor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class RegisterMentorController extends Controller
{
    /**
     * Show the mentor registration form
     */
    public function showRegistrationForm()
    {
        return view('auth.register-mentor');
    }

    /**
     * Handle mentor registration
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_lengkap' => ['required', 'string', 'max:100'],
            'username' => ['required', 'string', 'max:50', 'unique:users,username', 'alpha_dash'],
            'email' => ['required', 'email', 'max:255', 'unique:mentors,email'],
            'no_wa' => ['required', 'string', 'max:20'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ], [
            'nama_lengkap.required' => 'Nama lengkap harus diisi',
            'username.required' => 'Username harus diisi',
            'username.unique' => 'Username sudah digunakan',
            'username.alpha_dash' => 'Username hanya boleh huruf, angka, dash dan underscore',
            'email.required' => 'Email harus diisi',
            'email.email' => 'Format email tidak valid',
            'email.unique' => 'Email sudah terdaftar',
            'no_wa.required' => 'Nomor WhatsApp harus diisi',
            'password.required' => 'Password harus diisi',
            'password.min' => 'Password minimal 8 karakter',
            'password.confirmed' => 'Konfirmasi password tidak cocok',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        DB::beginTransaction();
        try {
            // Create user
            $user = User::create([
                'username' => $request->username,
                'password' => Hash::make($request->password),
            ]);

            // Assign role mentor
            $user->assignRole('mentor');

            // Create mentor profile with pending status
            Mentor::create([
                'user_id' => $user->user_id,
                'nama_lengkap' => $request->nama_lengkap,
                'email' => $request->email,
                'no_wa' => $request->no_wa,
                'status_approval' => 'pending', // Menunggu approval admin
            ]);

            DB::commit();

            // Redirect to pending page
            return redirect()->route('register.mentor.pending')
                ->with('message', 'Registrasi berhasil! Akun Anda menunggu persetujuan dari admin.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Show pending approval page
     */
    public function showPendingPage()
    {
        return view('auth.register-mentor-pending');
    }
}
