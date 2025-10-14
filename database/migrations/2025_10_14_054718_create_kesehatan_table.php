<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  public function up(): void {
    Schema::create('kesehatan', function (Blueprint $table) {
      $table->id();
      $table->string('nama_program',200);
      $table->date('tanggal')->nullable();
      $table->text('keterangan')->nullable();
      $table->unsignedInteger('jumlah_peserta')->default(0);
      $table->foreignId('anggaran_id')->nullable()->constrained('anggaran')->nullOnDelete();
      $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
      $table->timestamps();
      $table->softDeletes();
      $table->index('tanggal','idx_kesehatan_tanggal');
    });
  }

  public function down(): void {
    Schema::dropIfExists('kesehatan');
  }
};
