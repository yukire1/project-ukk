<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  public function up(): void {
    Schema::create('activity_logs', function (Blueprint $table) {
      $table->id();
      $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
      $table->string('action',200);
      $table->string('entity',100)->nullable();
      $table->unsignedBigInteger('entity_id')->nullable();
      $table->string('ip_address',45)->nullable();
      $table->string('user_agent',255)->nullable();
      $table->json('meta')->nullable();
      $table->timestamp('created_at')->useCurrent();
      $table->index('user_id','idx_activity_logs_user');
      $table->index(['entity','entity_id'],'idx_activity_logs_entity');
    });
  }

  public function down(): void {
    Schema::dropIfExists('activity_logs');
  }
};
