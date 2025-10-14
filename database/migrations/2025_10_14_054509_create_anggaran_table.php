<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  public function up(): void {
    Schema::create('anggaran', function (Blueprint $table) {
      $table->id();
      $table->year('tahun');
      $table->string('sumber_dana',150)->nullable();
      $table->unsignedBigInteger('jumlah')->default(0);
      $table->text('keterangan')->nullable();
      $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
      $table->timestamps();
      $table->softDeletes();
      $table->index('tahun','idx_anggaran_tahun');
    });
  }

  public function down(): void {
    Schema::dropIfExists('anggaran');
  }
};
