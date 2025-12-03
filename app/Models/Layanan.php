<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Layanan extends Model
{
    use SoftDeletes;

    protected $table = 'layanan';

    protected $fillable = [
        'jenis',
        'judul',
        'deskripsi',
        'keterangan',
        'detail',
        'penduduk_id',
        'status',
        'created_by',
    ];

    protected $casts = [
        'detail' => 'array',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function penduduk()
    {
        return $this->belongsTo(Penduduk::class);
    }

    public function suratDomisili()
    {
        return $this->hasOne(SuratDomisili::class, 'layanan_id');
    }
}