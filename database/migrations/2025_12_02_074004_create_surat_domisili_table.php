<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('surat_domisili', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('layanan_id')->nullable();
            $table->unsignedBigInteger('penduduk_id');
            $table->string('nomor_surat')->nullable();
            $table->string('nik');
            $table->string('nama');
            $table->text('alamat_lama');
            $table->text('alamat_baru');
            $table->string('alasan_pindah');
            $table->date('tanggal_pindah')->nullable();
            $table->date('tanggal_surat')->nullable();
            $table->text('catatan')->nullable();
            $table->string('status')->default('Menunggu');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('layanan_id')->references('id')->on('layanan')->onDelete('set null');
            $table->foreign('penduduk_id')->references('id')->on('penduduk')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('surat_domisili');
    }
};