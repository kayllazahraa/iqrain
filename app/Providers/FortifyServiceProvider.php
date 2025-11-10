<?php

namespace App\Providers;

use App\Actions\Fortify\CreateNewUser;
use App\Actions\Fortify\ResetUserPassword;
use App\Actions\Fortify\UpdateUserPassword;
use App\Actions\Fortify\UpdateUserProfileInformation;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use Laravel\Fortify\Fortify;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class FortifyServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Custom authentication dengan username
        Fortify::authenticateUsing(function (Request $request) {
            $user = User::where('username', $request->username)
                ->first();

            if ($user && Hash::check($request->password, $user->password)) {
                return $user;
            }

            return null;
        });

        // Custom views
        Fortify::loginView(function () {
            return view('auth.login');
        });

        // Disable default register view - kita akan buat custom
        // Fortify::registerView(function () {
        //     return view('auth.register');
        // });

        // Redirect after login berdasarkan role
        Fortify::redirects('login', function () {
            $user = auth()->user();

            if ($user->hasRole('admin')) {
                return route('admin.dashboard');
            } elseif ($user->hasRole('mentor')) {
                // Cek apakah mentor sudah diapprove
                if ($user->mentor && $user->mentor->status_approval === 'approved') {
                    return route('mentor.dashboard');
                } else {
                    auth()->logout();
                    return redirect()->route('login')
                        ->with('error', 'Akun Anda masih menunggu persetujuan admin.');
                }
            } elseif ($user->hasRole('murid')) {
                return route('murid.dashboard');
            }

            return '/dashboard';
        });

        // Fortify::createUsersUsing(CreateNewUser::class);
        Fortify::updateUserProfileInformationUsing(UpdateUserProfileInformation::class);
        Fortify::updateUserPasswordsUsing(UpdateUserPassword::class);
        Fortify::resetUserPasswordsUsing(ResetUserPassword::class);

        RateLimiter::for('login', function (Request $request) {
            $throttleKey = Str::transliterate(Str::lower($request->input(Fortify::username())) . '|' . $request->ip());

            return Limit::perMinute(5)->by($throttleKey);
        });

        RateLimiter::for('two-factor', function (Request $request) {
            return Limit::perMinute(5)->by($request->session()->get('login.id'));
        });
    }
}
