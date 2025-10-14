<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  public function up(): void {
    Schema::create('layanan', function (Blueprint $table) {
      $table->id();
      $table->enum('jenis',['SuratLayananUmum','BerkasKependudukan','Pengaduan']);
      $table->string('judul',200)->nullable();
      $table->text('deskripsi')->nullable();
      $table->dateTime('tanggal_pengajuan')->useCurrent();
      $table->enum('status',['Menunggu','Diproses','Diverifikasi','Ditolak','Selesai'])->default('Menunggu');
      $table->foreignId('penduduk_id')->constrained('penduduk')->cascadeOnDelete();
      $table->foreignId('assigned_admin_id')->nullable()->constrained('users')->nullOnDelete();
      $table->foreignId('assigned_kepala_id')->nullable()->constrained('users')->nullOnDelete();
      $table->timestamps();
      $table->softDeletes();
      $table->index('status','idx_layanan_status');
      $table->index('tanggal_pengajuan','idx_layanan_tanggal');
    });
  }

  public function down(): void {
    Schema::dropIfExists('layanan');
  }
};
