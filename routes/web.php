<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\RoleDashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ChatController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/lang/{locale}', [HomeController::class, 'switchLocale'])->name('locale.switch');
Route::post('/api/chat', [ChatController::class, 'getBotResponse'])->name('api.chat');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [RoleDashboardController::class, 'index'])->name('dashboard');

    Route::get('/dashboard/admin', [RoleDashboardController::class, 'admin'])
        ->middleware('role:admin')
        ->name('dashboard.admin');

    Route::get('/dashboard/pegawai', [RoleDashboardController::class, 'pegawai'])
        ->middleware('role:pegawai')
        ->name('dashboard.pegawai');

    Route::get('/dashboard/umum', [RoleDashboardController::class, 'umum'])
        ->middleware('role:umum')
        ->name('dashboard.umum');

    Route::get('/dashboard/pelajar-mahasiswa', [RoleDashboardController::class, 'pelajar'])
        ->middleware('role:pelajar_mahasiswa')
        ->name('dashboard.pelajar');

    Route::get('/dashboard/instansi-swasta', [RoleDashboardController::class, 'instansi'])
        ->middleware('role:instansi_swasta')
        ->name('dashboard.instansi');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::get('/profile/password', [ProfileController::class, 'password'])->name('profile.password');
    Route::get('/profile/activity', [ProfileController::class, 'activity'])->name('profile.activity');
    Route::delete('/profile/activity/logout-others', [ProfileController::class, 'logoutOtherBrowserSessions'])->name('profile.activity.logout-others');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
