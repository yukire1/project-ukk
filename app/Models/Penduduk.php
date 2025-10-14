<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Penduduk extends Model {
  use SoftDeletes;
  protected $table = 'penduduk';
  protected $fillable = ['nik','nama','alamat','tanggal_lahir','jenis_kelamin','pekerjaan'];

  public function user() {
    return $this->hasOne(User::class,'penduduk_id');
  }

  public function pesertaKegiatan() {
    return $this->hasMany(PesertaKegiatan::class,'penduduk_id');
  }

  public function pesertaKesehatan() {
    return $this->hasMany(PesertaKesehatan::class,'penduduk_id');
  }

  public function layanan() {
    return $this->hasMany(Layanan::class,'penduduk_id');
  }
}
