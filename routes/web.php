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

Route::get('/', function(){ return view('welcome'); });

require __DIR__.'/auth.php'; // breeze auth routes

Route::middleware(['auth'])->group(function(){
  // Penduduk (admin can manage)
  Route::resource('penduduk', PendudukController::class)->middleware('can:isAdmin');

  // Anggaran (admin only)
  Route::resource('anggaran', AnggaranController::class)->middleware('can:isAdmin');

  // Kegiatan (admin create/edit; kepala desa approve)
  Route::resource('kegiatan', KegiatanController::class)->middleware('can:manageAll');

  // Peserta Kegiatan - warga can register/view; admin manage attendance
  Route::resource('peserta-kegiatan', PesertaKegiatanController::class)->middleware('can:isAdmin');

  // Kesehatan
  Route::resource('kesehatan', KesehatanController::class)->middleware('can:isAdmin');

  // Peserta Kesehatan
  Route::resource('peserta-kesehatan', PesertaKesehatanController::class)->middleware('can:isAdmin');

  // Layanan: warga create; admin/kepala process
  Route::resource('layanan', LayananController::class); // handle inside controller gate checks

  // Tracking layanan (only admin/kepala can update)
  Route::resource('tracking-layanan', TrackingLayananController::class)->only(['index','store','show'])->middleware('can:manageAll');

  // Activity logs (admin/kepala)
  Route::get('activity-logs', [ActivityLogController::class,'index'])->name('activity-logs.index')->middleware('can:manageAll');
});
