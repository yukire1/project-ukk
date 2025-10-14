<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  public function up(): void {
    Schema::create('peserta_kegiatan', function (Blueprint $table) {
      $table->id();
      $table->foreignId('kegiatan_id')->constrained('kegiatan')->cascadeOnDelete();
      $table->foreignId('penduduk_id')->constrained('penduduk')->cascadeOnDelete();
      $table->boolean('hadir')->default(false);
      $table->timestamps();
      $table->unique(['kegiatan_id','penduduk_id'],'uq_peserta_kegiatan');
      $table->index('kegiatan_id','idx_peserta_kegiatan_kegiatan');
    });
  }

  public function down(): void {
    Schema::dropIfExists('peserta_kegiatan');
  }
};
