<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  public function up(): void {
    Schema::create('penduduk', function (Blueprint $table) {
      $table->id();
      $table->string('nik', 20)->unique();
      $table->string('nama', 150);
      $table->text('alamat')->nullable();
      $table->date('tanggal_lahir')->nullable();
      $table->enum('jenis_kelamin',['L','P'])->nullable();
      $table->string('pekerjaan',150)->nullable();
      $table->timestamps();
      $table->softDeletes();
      $table->index('nama','idx_penduduk_nama');
    });
  }

  public function down(): void {
    Schema::dropIfExists('penduduk');
  }
};
