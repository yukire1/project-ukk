<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PendudukController;
use App\Http\Controllers\AnggaranController;
use App\Http\Controllers\KegiatanController;
use App\Http\Controllers\PesertaKegiatanController;
use App\Http\Controllers\KesehatanController;
use App\Http\Controllers\PesertaKesehatanController;
use App\Http\Controllers\LayananController;
use App\Http\Controllers\TrackingLayananController;
use App\Http\Controllers\ActivityLogController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;

Route::get('/', function(){ return view('welcome'); });

// Dashboard route — PENTING: gunakan DashboardController
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard')->middleware('auth');

Route::middleware('guest')->group(function () {
    require __DIR__.'/auth.php';
});

Route::middleware('auth')->group(function () {
    // Profile routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Penduduk (admin only)
    Route::resource('penduduk', PendudukController::class);

    // Anggaran (admin only)
    Route::resource('anggaran', AnggaranController::class);

    // Kegiatan
    Route::resource('kegiatan', KegiatanController::class);

    // Peserta Kegiatan
    Route::resource('peserta-kegiatan', PesertaKegiatanController::class);

    // Kesehatan
    Route::resource('kesehatan', KesehatanController::class);

    // Peserta Kesehatan
    Route::resource('peserta-kesehatan', PesertaKesehatanController::class);

    // Layanan
    Route::resource('layanan', LayananController::class);

    // Tracking Layanan
    Route::resource('tracking-layanan', TrackingLayananController::class)->only(['index','store','show']);

    // Activity Logs
    Route::get('activity-logs', [ActivityLogController::class,'index'])->name('activity-logs.index');
});

require __DIR__.'/auth.php';