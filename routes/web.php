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

Route::get('/', function(){ return view('welcome'); });
route::get('/dashboard', function(){ return view('dashboard');});

Route::middleware('guest')->group(function () {
    Route::get('/penduduk/create', [PendudukController::class, 'create'])->name('penduduk.create');
    Route::post('/penduduk', [PendudukController::class, 'store'])->name('penduduk.store');
    });
    Route::middleware(['auth'])->group(function(){
    Route::resource('anggaran', AnggaranController::class);
    });

    Route::middleware('auth')->group(function () {
      Route::get('/profile', [ProfileController::class, 'edit'])->name('profile');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
    });

require __DIR__.'/auth.php'; // breeze auth routes

Route::middleware(['auth'])->group(function(){
  // Penduduk (admin can manage)
  Route::resource('penduduk', PendudukController::class);

  // Anggaran (admin only)
  Route::resource('anggaran', AnggaranController::class);

  // Kegiatan (admin create/edit; kepala desa approve)
  Route::resource('kegiatan', KegiatanController::class);

  // Peserta Kegiatan - warga can register/view; admin manage attendance
  Route::resource('peserta-kegiatan', PesertaKegiatanController::class);

  // Kesehatan
  Route::resource('kesehatan', KesehatanController::class);

  // Peserta Kesehatan
  Route::resource('peserta-kesehatan', PesertaKesehatanController::class);

  // Layanan: warga create; admin/kepala process
  Route::resource('layanan', LayananController::class); // handle inside controller gate checks

  // Tracking layanan (only admin/kepala can update)
  Route::resource('tracking-layanan', TrackingLayananController::class)->only(['index','store','show']);

  // Activity logs (admin/kepala)
  Route::get('activity-logs', [ActivityLogController::class,'index'])->name('activity-logs.index');
  
});
