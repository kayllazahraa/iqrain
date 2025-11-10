<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Mentor\MentorDashboardController;
use App\Http\Controllers\Murid\MuridDashboardController;
use App\Http\Controllers\Auth\RegisterMuridController;
use App\Http\Controllers\Auth\RegisterMentorController;
use App\Http\Controllers\Auth\ForgotPasswordMuridController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', [LandingController::class, 'index'])->name('landing');

Route::redirect('/dashboard', '/')->middleware('guest');

/*
|--------------------------------------------------------------------------
| Authentication Routes (Custom)
|--------------------------------------------------------------------------
*/

Route::middleware('guest')->group(function () {

    // Murid Registration (2 steps)
    Route::get('/register/murid', [RegisterMuridController::class, 'showRegistrationForm'])
        ->name('register.murid');
    Route::post('/register/murid', [RegisterMuridController::class, 'register'])
        ->name('register.murid.post');
    Route::get('/register/murid/preferensi', [RegisterMuridController::class, 'showPreferensiForm'])
        ->name('register.murid.preferensi');

    // Mentor Registration
    Route::get('/register/mentor', [RegisterMentorController::class, 'showRegistrationForm'])
        ->name('register.mentor');
    Route::post('/register/mentor', [RegisterMentorController::class, 'register'])
        ->name('register.mentor.post');
    Route::get('/register/mentor/pending', [RegisterMentorController::class, 'showPendingPage'])
        ->name('register.mentor.pending');

    // Registration Success Page
    Route::get('/register/success', function () {
        return view('auth.register-success');
    })->name('register.success');

    // Forgot Password for Murid (with security question)
    Route::get('/password/murid/request', [ForgotPasswordMuridController::class, 'showUsernameForm'])
        ->name('password.murid.request');
    Route::post('/password/murid/check', [ForgotPasswordMuridController::class, 'checkUsername'])
        ->name('password.murid.check');
    Route::post('/password/murid/verify', [ForgotPasswordMuridController::class, 'verifyAnswer'])
        ->name('password.murid.verify');
    Route::post('/password/murid/reset', [ForgotPasswordMuridController::class, 'resetPassword'])
        ->name('password.murid.reset');
});

/*
|--------------------------------------------------------------------------
| Authenticated Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth:sanctum', 'verified'])->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Admin Routes
    Route::middleware(['role:admin'])->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
        Route::get('/mentors', [AdminDashboardController::class, 'mentors'])->name('mentors');
        Route::get('/murids', [AdminDashboardController::class, 'murids'])->name('murids');
        Route::get('/activities', [AdminDashboardController::class, 'activities'])->name('activities');
        Route::get('/content', [AdminDashboardController::class, 'content'])->name('content');
        Route::get('/soal-management', [AdminDashboardController::class, 'soalManagement'])->name('soal.management');
    });

    // Mentor Routes
    Route::middleware(['role:mentor'])->prefix('mentor')->name('mentor.')->group(function () {
        Route::get('/dashboard', [MentorDashboardController::class, 'index'])->name('dashboard');
        Route::get('/murids', [MentorDashboardController::class, 'murids'])->name('murids');
        Route::get('/progress', [MentorDashboardController::class, 'progress'])->name('progress');
        Route::get('/soal', [MentorDashboardController::class, 'soal'])->name('soal');
        Route::get('/leaderboard', [MentorDashboardController::class, 'leaderboard'])->name('leaderboard');
        Route::get('/requests', [MentorDashboardController::class, 'requests'])->name('requests');
    });

    // Murid Routes
    Route::middleware(['role:murid'])->prefix('murid')->name('murid.')->group(function () {
        Route::get('/dashboard', [MuridDashboardController::class, 'index'])->name('dashboard');
        Route::get('/learning', [MuridDashboardController::class, 'learning'])->name('learning');
        Route::get('/games', [MuridDashboardController::class, 'games'])->name('games');
        Route::get('/progress', [MuridDashboardController::class, 'progress'])->name('progress');
        Route::get('/mentors', [MuridDashboardController::class, 'mentors'])->name('mentors');
    });
});
