<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\Anggaran;
use App\Models\Kegiatan;
use App\Models\Kesehatan;
use App\Models\Layanan;
use App\Models\TrackingLayanan;
use App\Models\ActivityLog;

class AnggaranKegiatanSeeder extends Seeder {
  public function run(): void {
    $ang1 = Anggaran::create(['tahun'=>2024,'sumber_dana'=>'Dana Desa (DD)','jumlah'=>150000000,'keterangan'=>'Pembangunan jalan','created_by'=>1]);
    $ang2 = Anggaran::create(['tahun'=>2024,'sumber_dana'=>'ADD','jumlah'=>80000000,'keterangan'=>'Sosialisasi & kesehatan','created_by'=>1]);
    $ang3 = Anggaran::create(['tahun'=>2025,'sumber_dana'=>'Dana Desa (DD)','jumlah'=>200000000,'keterangan'=>'Air bersih','created_by'=>1]);

    Kegiatan::create(['nama_kegiatan'=>'Pembangunan Jalan Desa','tanggal'=>'2024-03-10','lokasi'=>'Dusun I','deskripsi'=>'Pembangunan jalan utama desa','anggaran_id'=>$ang1->id,'created_by'=>1,'persetujuan_by'=>2,'status'=>'disetujui']);
    Kegiatan::create(['nama_kegiatan'=>'Sosialisasi Kesehatan Ibu & Anak','tanggal'=>'2024-04-20','lokasi'=>'Balai Desa','deskripsi'=>'Penyuluhan gizi','anggaran_id'=>$ang2->id,'created_by'=>1,'persetujuan_by'=>2,'status'=>'selesai']);
    Kegiatan::create(['nama_kegiatan'=>'Gotong Royong Bersih Desa','tanggal'=>'2025-01-12','lokasi'=>'Lapangan Desa','deskripsi'=>'Kerja bakti','anggaran_id'=>null,'created_by'=>1,'persetujuan_by'=>2,'status'=>'menunggu_persetujuan']);

    Kesehatan::create(['nama_program'=>'Posyandu Balita Bulanan','tanggal'=>'2024-05-02','keterangan'=>'Pemeriksaan balita','jumlah_peserta'=>15,'anggaran_id'=>$ang2->id,'created_by'=>1]);
    Kesehatan::create(['nama_program'=>'Pemeriksaan Lansia','tanggal'=>'2024-07-15','keterangan'=>'Pemeriksaan rutin lansia','jumlah_peserta'=>20,'anggaran_id'=>$ang2->id,'created_by'=>1]);
    Kesehatan::create(['nama_program'=>'Vaksinasi Rabies Hewan','tanggal'=>'2025-03-10','keterangan'=>'Vaksin hewan','jumlah_peserta'=>10,'anggaran_id'=>$ang3->id,'created_by'=>1]);

    Layanan::create(['jenis'=>'SuratLayananUmum','judul'=>'Surat Pengantar RT/RW','deskripsi'=>'Permohonan surat keterangan domisili','penduduk_id'=>1,'assigned_admin_id'=>1,'assigned_kepala_id'=>2,'status'=>'Selesai']);
    Layanan::create(['jenis'=>'Pengaduan','judul'=>'Jalan Rusak di Dusun II','deskripsi'=>'Jalan berlubang','penduduk_id'=>2,'assigned_admin_id'=>1,'assigned_kepala_id'=>2,'status'=>'Diproses']);
    Layanan::create(['jenis'=>'BerkasKependudukan','judul'=>'Permohonan Kartu Keluarga','deskripsi'=>'Pengajuan KK baru','penduduk_id'=>4,'assigned_admin_id'=>1,'assigned_kepala_id'=>2,'status'=>'Menunggu']);

    TrackingLayanan::create(['layanan_id'=>1,'status'=>'Menunggu','keterangan'=>'Pengajuan diterima','updated_by'=>1]);
    TrackingLayanan::create(['layanan_id'=>1,'status'=>'Diverifikasi','keterangan'=>'Diverifikasi kepala desa','updated_by'=>2]);
    TrackingLayanan::create(['layanan_id'=>1,'status'=>'Selesai','keterangan'=>'Surat selesai','updated_by'=>1]);

    ActivityLog::create(['user_id'=>1,'action'=>'Login Sistem','entity'=>'users','entity_id'=>1,'ip_address'=>'192.168.1.10','user_agent'=>'Chrome/Windows','meta'=>json_encode([])]);
  }
}
