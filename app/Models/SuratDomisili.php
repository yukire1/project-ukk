<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SuratDomisili extends Model
{
    use SoftDeletes;

    protected $table = 'surat_domisili';

    protected $fillable = [
        'layanan_id',
        'penduduk_id',
        'nomor_surat',
        'nik',
        'nama',
        'alamat_lama',
        'alamat_baru',
        'alasan_pindah',
        'tanggal_pindah',
        'tanggal_surat',
        'catatan',
        'status',
    ];

    protected $casts = [
        'tanggal_pindah' => 'date',
        'tanggal_surat' => 'date',
    ];

    public function layanan()
    {
        return $this->belongsTo(Layanan::class);
    }

    public function penduduk()
    {
        return $this->belongsTo(Penduduk::class);
    }
}