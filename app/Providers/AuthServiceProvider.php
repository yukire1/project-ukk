<?php
namespace App\Providers;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\User;

class AuthServiceProvider extends ServiceProvider {
  public function boot(): void {
    $this->registerPolicies();

    Gate::define('isAdmin', function(User $user) {
      return $user->hasRole('admin');
    });
    Gate::define('isKepala', function(User $user) {
      return $user->hasRole('kepala_desa');
    });
    Gate::define('isWarga', function(User $user) {
      return $user->hasRole('warga');
    });

    // contoh gate kombinasi: siapa pun admin atau kepala_desa
    Gate::define('manageAll', function(User $user) {
      return $user->hasRole('admin') || $user->hasRole('kepala_desa');
    });
  }
}
