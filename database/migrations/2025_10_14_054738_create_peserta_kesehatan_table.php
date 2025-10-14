<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  public function up(): void {
    Schema::create('peserta_kesehatan', function (Blueprint $table) {
      $table->id();
      $table->foreignId('kesehatan_id')->constrained('kesehatan')->cascadeOnDelete();
      $table->foreignId('penduduk_id')->constrained('penduduk')->cascadeOnDelete();
      $table->boolean('hadir')->default(false);
      $table->timestamps();
      $table->unique(['kesehatan_id','penduduk_id'],'uq_peserta_kesehatan');
    });
  }

  public function down(): void {
    Schema::dropIfExists('peserta_kesehatan');
  }
};
