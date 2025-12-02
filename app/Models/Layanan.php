<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\User;

class Layanan extends Model
{
    use SoftDeletes;

    protected $table = 'layanan';

    protected $fillable = [
        'jenis',
        'judul',
        'deskripsi',
        'keterangan',
        'penduduk_id',
        'status',
        'created_by',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function penduduk()
    {
        return $this->belongsTo(Penduduk::class, 'penduduk_id');
    }

    public function suratDomisili()
    {
        return $this->hasOne(SuratDomisili::class, 'layanan_id');
    }

    public function trackingLayanan()
    {
        return $this->hasMany(TrackingLayanan::class, 'layanan_id');
    }
}