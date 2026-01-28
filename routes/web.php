<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\RegistrationController;
use App\Http\Controllers\Admin\DashboardAdminController;
use App\Http\Controllers\Validator\ValidatorController;
// Tambahkan Controller Sekolah di sini agar lebih rapi
use App\Http\Controllers\School\DashboardController;
use App\Http\Controllers\School\SurveyController;
use App\Http\Controllers\School\ProfileController;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/
// Halaman Utama (Portal)
Route::get('/', [LandingController::class, 'index'])->name('landing');

// Halaman Khusus Pendaftaran
Route::get('/pengajuan-akun', [LandingController::class, 'registrationPage'])->name('registration.page');
Route::post('/register-school', [LandingController::class, 'storeRegistration'])->name('register.store');

// Halaman Khusus Ranking
Route::get('/ranking-sekolah', [LandingController::class, 'rankingPage'])->name('ranking.page');

// --- Rute Login ---
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

/*
|--------------------------------------------------------------------------
| Authenticated Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {

    // Route Redirect Dashboard (Penghubung)
    Route::get('/dashboard', function () {
        $role = Auth::user()->role;
        if ($role === 'admin') return redirect()->route('admin.dashboard');
        if ($role === 'validator') return redirect()->route('validator.dashboard');
        if ($role === 'school') return redirect()->route('school.dashboard');
        return abort(403, 'Unauthorized action.');
    })->name('dashboard');

    // --- Route Khusus SEKOLAH (DIPERBARUI) ---
    Route::middleware(['role:school'])->prefix('school')->name('school.')->group(function () {

        // 1. Dashboard Utama
        // Menggunakan Controller, bukan function() biasa, agar bisa passing data nama user/notifikasi
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        // 2. Fitur Survei (Wizard / Step-by-Step)
        Route::get('/survey/start', [SurveyController::class, 'start'])->name('survey.start');       // Mulai ulang sesi
        Route::get('/survey/step/{step}', [SurveyController::class, 'step'])->name('survey.step');   // Tampilkan pertanyaan per langkah
        Route::post('/survey/process/{step}', [SurveyController::class, 'process'])->name('survey.process'); // Simpan jawaban sementara
        Route::get('/survey/result/{id}', [SurveyController::class, 'result'])->name('survey.result'); // Hasil Akhir

        // 3. Profil (Hanya Ganti Password) 
        Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
        Route::put('/profile/update-password', [ProfileController::class, 'updatePassword'])->name('profile.password');
    });

    // --- Route Khusus VALIDATOR ---
    Route::middleware(['role:validator'])->prefix('validator')->name('validator.')->group(function () {
        Route::get('/dashboard', [ValidatorController::class, 'index'])->name('dashboard');
        Route::get('/registrations/{id}', [ValidatorController::class, 'show'])->name('show');
        Route::post('/registrations/approve/{id}', [ValidatorController::class, 'approve'])->name('approve');
        Route::post('/registrations/reject/{id}', [ValidatorController::class, 'reject'])->name('reject');

        Route::get('/survey/verify/{id}', [ValidatorController::class, 'verifySurvey'])->name('survey.verify');
        Route::post('/survey/verify/{id}', [ValidatorController::class, 'storeVerification'])->name('survey.store');
        });

    // --- Route Khusus ADMIN ---
    Route::middleware(['role:admin'])->prefix('admin')->name('admin.')->group(function () {

        Route::get('/dashboard', [DashboardAdminController::class, 'index'])
            ->name('dashboard');

        // Menu "Penerbitan Akun"
        Route::get('/registrations-verified', [RegistrationController::class, 'index'])
            ->name('registrations.index');

        // Aksi 1: Terima & Buat Akun
        Route::post('/registrations/create-account/{id}', [RegistrationController::class, 'createAccount'])
            ->name('registrations.create');

        // Aksi 2: Tolak & Kembalikan ke Validator (TAMBAHAN PENTING)
        Route::post('/registrations/reject/{id}', [RegistrationController::class, 'rejectToValidator'])
            ->name('registrations.reject');
    });
});
