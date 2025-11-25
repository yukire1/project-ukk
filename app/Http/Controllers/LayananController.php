<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Layanan;
use App\Models\Penduduk;
use App\Models\TrackingLayanan;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Gate;

class LayananController extends Controller
{
    use AuthorizesRequests;

    public function index()
    {
        $user = auth()->user();

        if ($user && ($user->hasRole('admin') || $user->hasRole('kepala_desa'))) {
            $layanans = Layanan::with('penduduk')->orderByDesc('created_at')->get();
        } else {
            $pendudukId = $user->penduduk->id ?? null;
            $layanans = $pendudukId ? Layanan::with('penduduk')->where('penduduk_id', $pendudukId)->orderByDesc('created_at')->get() : collect();
        }

        return view('layanan.index', compact('layanans'));
    }

    public function create()
    {
        return view('layanan.create');
    }

    public function store(Request $request)
    {
        $user = auth()->user();

        if (!$user->penduduk) {
            return redirect()->back()->with('error','Profile penduduk belum lengkap.');
        }

        $data = $request->validate([
            'jenis' => 'required|in:SuratLayananUmum,BerkasKependudukan,Pengaduan',
            'judul' => 'nullable|string|max:200',
            'deskripsi' => 'nullable|string',
        ]);

        $data['penduduk_id'] = $user->penduduk->id;
        $data['status'] = 'Menunggu';
        $layanan = Layanan::create($data);

        TrackingLayanan::create([
            'layanan_id' => $layanan->id,
            'status' => $layanan->status,
            'keterangan' => 'Pengajuan dibuat',
            'updated_by' => $user->id,
        ]);

        return redirect()->route('layanan.index')->with('success','Layanan terkirim.');
    }

    public function show(Layanan $layanan)
    {
        $this->authorize('view', $layanan);
        $layanan->load('penduduk','tracking');
        return view('layanan.show', compact('layanan'));
    }

    public function edit(Layanan $layanan)
    {
    
        if (! (Gate::allows('isAdmin') || Gate::allows('isKepala')) ) {
          $this->authorize('update', $layanan);
        }
        return view('layanan.edit', compact('layanan'));
    }

    public function update(Request $request, Layanan $layanan)
    {
      
  
        // cek otorisasi — admin/kepala boleh edit semua, non-admin hanya bisa edit milik sendiri
        if (! (Gate::allows('isAdmin') || Gate::allows('isKepala')) ) {
          $this->authorize('update', $layanan);
        }

        // base rules untuk semua user
        $rules = [
          'jenis' => 'required|in:SuratLayananUmum,BerkasKependudukan,Pengaduan',
          'judul' => 'nullable|string|max:200',
          'deskripsi' => 'nullable|string'
        ];

      
        // // admin/kepala desa bisa ubah status
        // if (Gate::allows('manageAll') || Gate::allows('isAdmin') || Gate::allows('isKepala')) {
          $rules['status'] = 'nullable|in:Menunggu,Diproses,Diverifikasi,Ditolak,Selesai';
        // }

        $data = $request->validate($rules);


        // dump($layanan); 
        // dump($data);
        // update base fields
        $layanan->jenis = $data['jenis'];
        $layanan->judul = $data['judul'] ?? $layanan->judul;
        $layanan->deskripsi = $data['deskripsi'] ?? $layanan->deskripsi;

        // update status jika ada di request dan user diizinkan
        $oldStatus = $layanan->status;
        // if (isset($data['status']) && !empty($data['status']) && (Gate::allows('manageAll') || Gate::allows('isAdmin') || Gate::allows('isKepala'))) {
        $layanan->status = $data['status'];
        // }

        $layanan->save();
        // dump($layanan); 
    
        // record tracking jika status berubah
        if (isset($data['status']) && !empty($data['status']) && $oldStatus !== $data['status']) {
          TrackingLayanan::create([
            'layanan_id' => $layanan->id,
            'status' => $data['status'],
            'keterangan' => 'Status diubah dari ' . $oldStatus . ' menjadi ' . $data['status'],
            'updated_by' => auth()->id()
          ]);
        }

        // dd('done');
        return redirect()->route('layanan.show', $layanan)->with('success', 'Layanan berhasil diperbarui.');
    }

    public function destroy(Layanan $layanan)
    {
        $this->authorize('delete', $layanan);
        $layanan->delete();
        return redirect()->route('layanan.index')->with('success','Layanan dihapus.');
    }
}