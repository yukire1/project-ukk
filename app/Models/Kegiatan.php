<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Kegiatan extends Model {
  use SoftDeletes;
  protected $table = 'kegiatan';
  protected $fillable = ['nama_kegiatan','tanggal','lokasi','deskripsi','anggaran_id','created_by','persetujuan_by','status'];

  public function anggaran(){ return $this->belongsTo(Anggaran::class,'anggaran_id'); }
  public function creator(){ return $this->belongsTo(User::class,'created_by'); }
  public function persetujuanBy(){ return $this->belongsTo(User::class,'persetujuan_by'); }
  public function peserta(){ return $this->hasMany(PesertaKegiatan::class,'kegiatan_id'); }
}
