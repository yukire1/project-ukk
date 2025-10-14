<?php
namespace App\Models;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable {
  use  Notifiable, SoftDeletes;

  protected $fillable = ['penduduk_id','username','email','password','role'];
  protected $hidden = ['password','remember_token'];

  public function penduduk() {
    return $this->belongsTo(Penduduk::class,'penduduk_id');
  }

  public function roles() {
    return $this->belongsToMany(Role::class,'role_user')->withTimestamps();
  }

  public function hasRole(string $roleName): bool {
    if ($this->role === $roleName) return true; // backward compatibility
    return $this->roles()->where('name',$roleName)->exists();
  }

  // relation helpers
  public function anggaransCreated() { return $this->hasMany(Anggaran::class,'created_by'); }
  public function kegiatanCreated() { return $this->hasMany(Kegiatan::class,'created_by'); }
  public function layananAssigned() { return $this->hasMany(Layanan::class,'assigned_admin_id'); }
}
