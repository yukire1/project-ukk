<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class PesertaKesehatan extends Model {
  protected $table = 'peserta_kesehatan';
  protected $fillable = ['kesehatan_id','penduduk_id','hadir'];

  public function kesehatan(){ return $this->belongsTo(Kesehatan::class,'kesehatan_id'); }
  public function penduduk(){ return $this->belongsTo(Penduduk::class,'penduduk_id'); }
}
