<?php


namespace App\Http\Controllers;

use App\Models\Layanan;
use App\Models\SuratDomisili;
use App\Models\Penduduk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Barryvdh\DomPDF\Facade\Pdf;

class LayananController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        // Query builder
        $query = Layanan::with('createdBy', 'penduduk', 'suratDomisili');

        // Jika bukan admin atau kepala_desa, hanya tampilkan request milik user
        if (!$user->hasRole('admin') && !$user->hasRole('kepala_desa')) {
            $query->where('created_by', $user->id);
        }
        // Jika admin atau kepala_desa, tampilkan semua request

        $layanan = $query->latest()->paginate(10);

        return view('layanan.index', compact('layanan'));
    }

    public function create()
    {
        $penduduks = Penduduk::orderBy('nama')->get();
        return view('layanan.create', compact('penduduks'));
    }

    public function store(Request $request)
    {
        try {
            $jenis = $request->jenis;

            if ($jenis === 'Surat Domisili') {
                return $this->storeSuratDomisili($request);
            } elseif ($jenis === 'Surat Layanan Umum') {
                return $this->storeSuratLayananUmum($request);
            } elseif ($jenis === 'Keterangan Tidak Mampu') {
                return $this->storeKeteranganTidakMampu($request);
            } elseif ($jenis === 'Pengaduan') {
                return $this->storePengaduan($request);
            }

            return redirect()->back()->withErrors(['error' => 'Jenis layanan tidak valid']);

        } catch (\Exception $e) {
            Log::error('Error store layanan:', ['message' => $e->getMessage()]);
            return redirect()->back()->withInput()
                ->withErrors(['error' => 'Terjadi kesalahan: ' . $e->getMessage()]);
        }
    }

    private function storeSuratDomisili(Request $request)
    {
        $request->validate([
            'penduduk_id' => 'required|exists:penduduk,id',
            'nik' => 'required|string|max:16',
            'nama' => 'required|string|max:255',
            'alamat_lama' => 'required|string',
            'alamat_baru' => 'required|string',
            'alasan_pindah' => 'required|string',
            'tanggal_pindah' => 'nullable|date',
            'tanggal_surat' => 'nullable|date',
            'judul' => 'required|string',
            'deskripsi' => 'nullable|string',
        ]);

        DB::beginTransaction();
        try {
            $layanan = Layanan::create([
                'jenis' => 'Surat Domisili',
                'judul' => $request->judul,
                'deskripsi' => $request->deskripsi,
                'keterangan' => $request->keterangan ?? null,
                'status' => 'Menunggu',
                'created_by' => Auth::id(),
                'penduduk_id' => $request->penduduk_id,
            ]);

            SuratDomisili::create([
                'layanan_id' => $layanan->id,
                'penduduk_id' => $request->penduduk_id,
                'nomor_surat' => $request->nomor_surat ?? null,
                'nik' => $request->nik,
                'nama' => $request->nama,
                'alamat_lama' => $request->alamat_lama,
                'alamat_baru' => $request->alamat_baru,
                'alasan_pindah' => $request->alasan_pindah,
                'tanggal_pindah' => $request->tanggal_pindah ?? null,
                'tanggal_surat' => $request->tanggal_surat ?? now()->toDateString(),
                'catatan' => $request->catatan ?? null,
                'status' => 'Menunggu',
            ]);

            DB::commit();
            return redirect()->route('layanan.show', $layanan)
                ->with('success', 'Layanan Surat Domisili berhasil diajukan!');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error surat domisili:', ['message' => $e->getMessage()]);
            return redirect()->back()->withInput()
                ->withErrors(['error' => 'Error: ' . $e->getMessage()]);
        }
    }

    private function storeSuratLayananUmum(Request $request)
    {
        $request->validate([
            'jenis_surat' => 'required|string|max:255',
            'tujuan_penggunaan' => 'required|string',
            'judul' => 'required|string',
        ]);

        $layanan = Layanan::create([
            'jenis' => 'Surat Layanan Umum',
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi ?? null,
            'keterangan' => $request->keterangan ?? null,
            'status' => 'Menunggu',
            'created_by' => Auth::id(),
            'detail' => [
                'jenis_surat' => $request->jenis_surat,
                'tujuan_penggunaan' => $request->tujuan_penggunaan,
            ],
        ]);

        return redirect()->route('layanan.show', $layanan)
            ->with('success', 'Layanan Surat Layanan Umum berhasil diajukan!');
    }

    private function storeKeteranganTidakMampu(Request $request)
    {
        $request->validate([
            'no_kk' => 'required|string|max:16',
            'judul' => 'required|string',
        ]);

        $layanan = Layanan::create([
            'jenis' => 'Keterangan Tidak Mampu',
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi ?? null,
            'keterangan' => $request->keterangan ?? null,
            'status' => 'Menunggu',
            'created_by' => Auth::id(),
            'detail' => [
                'nama' => $request->nama_ktm,
                'no_kk' => $request->no_kk,
                'alasan' => $request->alasan_ktm ?? null,
            ],
        ]);

        return redirect()->route('layanan.show', $layanan)
            ->with('success', 'Layanan Keterangan Tidak Mampu berhasil diajukan!');
    }

    private function storePengaduan(Request $request)
    {
        $request->validate([
            'deskripsi_pengaduan' => 'required|string',
            'judul' => 'required|string',
        ]);

        $layanan = Layanan::create([
            'jenis' => 'Pengaduan',
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi_pengaduan,
            'keterangan' => $request->keterangan ?? null,
            'status' => 'Menunggu',
            'created_by' => Auth::id(),
            'detail' => [
                'lampiran' => $request->lampiran_pengaduan ?? null,
            ],
        ]);

        return redirect()->route('layanan.show', $layanan)
            ->with('success', 'Layanan Pengaduan berhasil diajukan!');
    }

    public function show(Layanan $layanan)
    {
        $suratDomisili = $layanan->suratDomisili;
        return view('layanan.show', compact('layanan', 'suratDomisili'));
    }

    public function cetak(Layanan $layanan)
    {
        try {
            $pdf = null;
            $filename = "";

            if ($layanan->jenis === 'Surat Domisili') {
                $surat = $layanan->suratDomisili;
                if (!$surat) {
                    return redirect()->back()->withErrors(['error' => 'Data Surat Domisili tidak ditemukan.']);
                }
                $pdf = Pdf::loadView('layanan.pdf.surat_domisili', compact('layanan', 'surat'));
                $filename = "Surat_Domisili_{$layanan->id}.pdf";
            } elseif ($layanan->jenis === 'Surat Layanan Umum') {
                $pdf = Pdf::loadView('layanan.pdf.surat_layanan_umum', compact('layanan'));
                $filename = "Surat_Layanan_Umum_{$layanan->id}.pdf";
            } elseif ($layanan->jenis === 'Keterangan Tidak Mampu') {
                $pdf = Pdf::loadView('layanan.pdf.keterangan_tidak_mampu', compact('layanan'));
                $filename = "Keterangan_Tidak_Mampu_{$layanan->id}.pdf";
            } elseif ($layanan->jenis === 'Pengaduan') {
                $pdf = Pdf::loadView('layanan.pdf.pengaduan', compact('layanan'));
                $filename = "Laporan_Pengaduan_{$layanan->id}.pdf";
            } else {
                return redirect()->back()->withErrors(['error' => 'Jenis layanan tidak didukung.']);
            }

            return $pdf->download($filename);

        } catch (\Exception $e) {
            Log::error('Error cetak PDF:', ['message' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
            return redirect()->back()->withErrors(['error' => 'Gagal generate PDF: ' . $e->getMessage()]);
        }
    }

    public function edit(Layanan $layanan)
    {
        $user = Auth::user();
        
        // Kepala desa tidak boleh edit
        if ($user->hasRole('kepala_desa')) {
            return redirect()->route('layanan.show', $layanan)
                ->withErrors(['error' => 'Anda tidak memiliki izin untuk mengedit layanan.']);
        }
        
        // Admin dan pembuat request boleh edit
        if (!$user->hasRole('admin') && $layanan->created_by !== $user->id) {
            return redirect()->route('layanan.show', $layanan)
                ->withErrors(['error' => 'Anda tidak memiliki izin untuk mengedit layanan ini.']);
        }
        
        $penduduks = Penduduk::all();
        $suratDomisili = $layanan->suratDomisili;
        return view('layanan.edit', compact('layanan', 'penduduks', 'suratDomisili'));
    }

    public function update(Request $request, Layanan $layanan)
    {
        $user = Auth::user();
        
        // Kepala desa tidak boleh update
        if ($user->hasRole('kepala_desa')) {
            return redirect()->route('layanan.show', $layanan)
                ->withErrors(['error' => 'Anda tidak memiliki izin untuk mengubah layanan.']);
        }
        
        // Admin dan pembuat request boleh update
        if (!$user->hasRole('admin') && $layanan->created_by !== $user->id) {
            return redirect()->route('layanan.show', $layanan)
                ->withErrors(['error' => 'Anda tidak memiliki izin untuk mengubah layanan ini.']);
        }
        
        $validated = $request->validate([
            'status' => 'required|string',
        ]);

        $layanan->update($validated);
        return redirect()->route('layanan.show', $layanan)
            ->with('success', 'Layanan berhasil diperbarui.');
    }

    public function destroy(Layanan $layanan)
    {
        $layanan->delete();
        return redirect()->route('layanan.index')
            ->with('success', 'Layanan berhasil dihapus.');
    }
}