<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class TrackingLayanan extends Model {
  protected $table = 'tracking_layanan';
  protected $fillable = ['layanan_id','status','keterangan','updated_by','tanggal_update'];

  public function layanan(){ return $this->belongsTo(Layanan::class,'layanan_id'); }
  public function updatedBy(){ return $this->belongsTo(User::class,'updated_by'); }
}
