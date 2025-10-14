<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  public function up(): void {
    Schema::create('tracking_layanan', function (Blueprint $table) {
      $table->id();
      $table->foreignId('layanan_id')->constrained('layanan')->cascadeOnDelete();
      $table->enum('status',['Menunggu','Diproses','Diverifikasi','Ditolak','Selesai']);
      $table->text('keterangan')->nullable();
      $table->foreignId('updated_by')->nullable()->constrained('users')->nullOnDelete();
      $table->dateTime('tanggal_update')->useCurrent();
      $table->timestamps();
      $table->index('layanan_id','idx_tracking_layanan_layanan');
      $table->index('tanggal_update','idx_tracking_layanan_tanggal');
    });
  }

  public function down(): void {
    Schema::dropIfExists('tracking_layanan');
  }
};
