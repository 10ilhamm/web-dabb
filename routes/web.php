<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\HomeContentController;
use App\Http\Controllers\RoleDashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\FeatureController;
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

    // CMS Home Content Editor
    Route::middleware('role:admin')->prefix('cms/home')->name('cms.home.')->group(function () {
        Route::get('/', [HomeContentController::class, 'edit'])->name('edit');
        Route::post('/', [HomeContentController::class, 'update'])->name('update');
    });

    // CMS Features
    Route::middleware('role:admin')->prefix('cms/features')->name('cms.features.')->group(function () {
        Route::get('/', [FeatureController::class, 'index'])->name('index');
        Route::post('/', [FeatureController::class, 'store'])->name('store');
        Route::get('/{feature}', [FeatureController::class, 'show'])->name('show');
        Route::put('/{feature}', [FeatureController::class, 'update'])->name('update');
        Route::delete('/{feature}', [FeatureController::class, 'destroy'])->name('destroy');
        Route::put('/{feature}/content', [FeatureController::class, 'updateContent'])->name('update-content');
        Route::put('/{feature}/sub', [FeatureController::class, 'updateSub'])->name('update-sub');
        Route::delete('/{feature}/sub', [FeatureController::class, 'destroySub'])->name('destroy-sub');
    });
});

require __DIR__ . '/auth.php';
