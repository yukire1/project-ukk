<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  public function up(): void {
    Schema::create('kegiatan', function (Blueprint $table) {
      $table->id();
      $table->string('nama_kegiatan',200);
      $table->date('tanggal')->nullable();
      $table->string('lokasi',200)->nullable();
      $table->text('deskripsi')->nullable();
      $table->foreignId('anggaran_id')->nullable()->constrained('anggaran')->nullOnDelete();
      $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
      $table->foreignId('persetujuan_by')->nullable()->constrained('users')->nullOnDelete();
      $table->enum('status',['draft','menunggu_persetujuan','disetujui','ditolak','selesai'])->default('draft');
      $table->timestamps();
      $table->softDeletes();
      $table->index('tanggal','idx_kegiatan_tanggal');
      $table->index('status','idx_kegiatan_status');
    });
  }

  public function down(): void {
    Schema::dropIfExists('kegiatan');
  }
};
