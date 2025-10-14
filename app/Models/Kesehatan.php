<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Kesehatan extends Model {
  use SoftDeletes;
  protected $table = 'kesehatan';
  protected $fillable = ['nama_program','tanggal','keterangan','jumlah_peserta','anggaran_id','created_by'];

  public function anggaran(){ return $this->belongsTo(Anggaran::class,'anggaran_id'); }
  public function creator(){ return $this->belongsTo(User::class,'created_by'); }
  public function peserta(){ return $this->hasMany(PesertaKesehatan::class,'kesehatan_id'); }
}
