<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\Role;

class RolesTableSeeder extends Seeder {
  public function run(): void {
    $roles = [
      ['name'=>'admin','label'=>'Administrator'],
      ['name'=>'kepala_desa','label'=>'Kepala Desa'],
      ['name'=>'warga','label'=>'Warga']
    ];
    foreach($roles as $r) Role::updateOrCreate(['name'=>$r['name']],$r);
  }
}
