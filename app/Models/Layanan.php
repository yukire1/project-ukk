<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Layanan extends Model {
  use SoftDeletes;
  protected $table = 'layanan';
  protected $fillable = ['jenis','judul','deskripsi','tanggal_pengajuan','status','penduduk_id','assigned_admin_id','assigned_kepala_id'];

  public function penduduk(){ return $this->belongsTo(Penduduk::class,'penduduk_id'); }
  public function assignedAdmin(){ return $this->belongsTo(User::class,'assigned_admin_id'); }
  public function assignedKepala(){ return $this->belongsTo(User::class,'assigned_kepala_id'); }
  public function tracking(){ return $this->hasMany(TrackingLayanan::class,'layanan_id'); }
}
