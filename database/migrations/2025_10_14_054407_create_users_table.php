<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  public function up(): void {
    Schema::create('users', function (Blueprint $table) {
      $table->id();
      $table->foreignId('penduduk_id')->nullable()->constrained('penduduk')->nullOnDelete();
      $table->string('username',100)->unique();
      $table->string('email',150)->nullable()->unique();
      $table->string('password');
      // keep role enum for backward compatibility; main relation uses roles table
      $table->enum('role',['warga','admin','kepala_desa'])->default('warga');
      $table->rememberToken();
      $table->timestamps();
      $table->softDeletes();
    });
  }

  public function down(): void {
    Schema::dropIfExists('users');
  }
};
