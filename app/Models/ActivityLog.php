<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class ActivityLog extends Model {
  public $timestamps = false;
  protected $table = 'activity_logs';
  protected $fillable = ['user_id','action','entity','entity_id','ip_address','user_agent','meta','created_at'];

  public function user(){ return $this->belongsTo(User::class,'user_id'); }
}
