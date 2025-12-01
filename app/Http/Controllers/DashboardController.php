<?php

namespace App\Http\Controllers;

use App\Models\Penduduk;
use App\Models\Layanan;
use App\Models\Kegiatan;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        // Total warga
        $totalWarga = Penduduk::count();

        // Total layanan
        $totalLayanan = Layanan::count();

        // Layanan berdasarkan status
        $layananSelesai = Layanan::where('status', 'Selesai')->count();
        $layananMenunggu = Layanan::where('status', 'Menunggu')->count();
        $layananDiproses = Layanan::where('status', 'Diproses')->count();
        $layananDiverifikasi = Layanan::where('status', 'Diverifikasi')->count();
        $layananDitolak = Layanan::where('status', 'Ditolak')->count();

        // Kegiatan aktif
        $kegiatanAktif = Kegiatan::where('status', 'Aktif')->count();

        // Gender warga
        $wariaLaki = Penduduk::where('jenis_kelamin', 'L')->count();
        $wariaPerempuan = Penduduk::where('jenis_kelamin', 'P')->count();

        return view('dashboard', compact(
            'totalWarga',
            'totalLayanan',
            'layananSelesai',
            'layananMenunggu',
            'layananDiproses',
            'layananDiverifikasi',
            'layananDitolak',
            'kegiatanAktif',
            'wariaLaki',
            'wariaPerempuan'
        ));
    }
}