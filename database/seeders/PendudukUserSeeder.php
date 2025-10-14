<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\Penduduk;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;

class PendudukUserSeeder extends Seeder {
  public function run(): void {
    // penduduk
    $p1 = Penduduk::create(['nik'=>'320101010001','nama'=>'Budi Santoso','alamat'=>'Jl. Melati No.10, Sukamaju','tanggal_lahir'=>'1985-03-12','jenis_kelamin'=>'L','pekerjaan'=>'Petani']);
    $p2 = Penduduk::create(['nik'=>'320101010002','nama'=>'Siti Aminah','alamat'=>'Jl. Mawar No.8, Sukamaju','tanggal_lahir'=>'1990-07-21','jenis_kelamin'=>'P','pekerjaan'=>'Guru SD']);
    $p3 = Penduduk::create(['nik'=>'320101010003','nama'=>'Agus Prabowo','alamat'=>'Jl. Dahlia No.5, Sukamaju','tanggal_lahir'=>'1982-11-04','jenis_kelamin'=>'L','pekerjaan'=>'Perangkat Desa']);
    $p4 = Penduduk::create(['nik'=>'320101010004','nama'=>'Lina Kartini','alamat'=>'Jl. Kenanga No.3, Sukamaju','tanggal_lahir'=>'1995-09-14','jenis_kelamin'=>'P','pekerjaan'=>'Bidan Desa']);
    $p5 = Penduduk::create(['nik'=>'320101010005','nama'=>'Rahmat Hidayat','alamat'=>'Jl. Anggrek No.12, Sukamaju','tanggal_lahir'=>'1978-01-25','jenis_kelamin'=>'L','pekerjaan'=>'Wiraswasta']);

    // users (password = 'password')
    $u1 = User::create(['penduduk_id'=>$p3->id,'username'=>'admin_desa','email'=>'admin@desa.id','password'=>Hash::make('password'),'role'=>'admin']);
    $u2 = User::create(['penduduk_id'=>$p5->id,'username'=>'kades_sukamaju','email'=>'kepala@desa.id','password'=>Hash::make('password'),'role'=>'kepala_desa']);
    $u3 = User::create(['penduduk_id'=>$p1->id,'username'=>'budi_s','email'=>'budi@mail.id','password'=>Hash::make('password'),'role'=>'warga']);
    $u4 = User::create(['penduduk_id'=>$p2->id,'username'=>'siti_a','email'=>'siti@mail.id','password'=>Hash::make('password'),'role'=>'warga']);
    $u5 = User::create(['penduduk_id'=>$p4->id,'username'=>'lina_k','email'=>'lina@mail.id','password'=>Hash::make('password'),'role'=>'warga']);

    // assign roles via pivot
    $roleAdmin = Role::where('name','admin')->first();
    $roleKades = Role::where('name','kepala_desa')->first();
    $roleWarga = Role::where('name','warga')->first();

    $u1->roles()->syncWithoutDetaching([$roleAdmin->id]);
    $u2->roles()->syncWithoutDetaching([$roleKades->id]);
    $u3->roles()->syncWithoutDetaching([$roleWarga->id]);
    $u4->roles()->syncWithoutDetaching([$roleWarga->id]);
    $u5->roles()->syncWithoutDetaching([$roleWarga->id]);
  }
}
