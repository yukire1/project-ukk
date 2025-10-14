<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Anggaran extends Model {
  use SoftDeletes;
  protected $table = 'anggaran';
  protected $fillable = ['tahun','sumber_dana','jumlah','keterangan','created_by'];

  public function creator() { return $this->belongsTo(User::class,'created_by'); }
  public function kegiatan() { return $this->hasMany(Kegiatan::class,'anggaran_id'); }
  public function kesehatan() { return $this->hasMany(Kesehatan::class,'anggaran_id'); }
}
