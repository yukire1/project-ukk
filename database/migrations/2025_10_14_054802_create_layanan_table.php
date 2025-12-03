<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('layanan', function (Blueprint $table) {
            $table->id();
            $table->string('jenis');
            $table->string('judul');
            $table->text('deskripsi')->nullable();
            $table->text('keterangan')->nullable();
            $table->json('detail')->nullable();
            $table->unsignedBigInteger('penduduk_id')->nullable();
            $table->string('status')->default('Menunggu');
            $table->unsignedBigInteger('created_by')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('penduduk_id')->references('id')->on('penduduk')->onDelete('set null');
            $table->foreign('created_by')->references('id')->on('users')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('layanan');
    }
};