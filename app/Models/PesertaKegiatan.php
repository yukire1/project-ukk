<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class PesertaKegiatan extends Model {
  protected $table = 'peserta_kegiatan';
  protected $fillable = ['kegiatan_id','penduduk_id','hadir'];

  public function kegiatan(){ return $this->belongsTo(Kegiatan::class,'kegiatan_id'); }
  public function penduduk(){ return $this->belongsTo(Penduduk::class,'penduduk_id'); }
}
