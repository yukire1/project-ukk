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
use Illuminate\Http\Response;


class LayananController extends Controller
{
    public function index()
    {
        $layanan = Layanan::with('createdBy', 'penduduk')
            ->where('created_by', Auth::id())
            ->latest()
            ->paginate(10);

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
            // Validasi umum
            $validated = $request->validate([
                'jenis' => 'required|string|max:255',
                'judul' => 'required|string|max:255',
                'deskripsi' => 'nullable|string',
                'keterangan' => 'nullable|string',
            ]);

            // Tambahkan created_by secara manual
            $validated['created_by'] = Auth::id();
            $validated['status'] = 'Menunggu';

            // Validasi conditional
            if ($request->jenis === 'Surat Domisili') {
                $request->validate([
                    'penduduk_id' => 'required|exists:penduduk,id',
                    'nik' => 'required|string|max:16',
                    'nama' => 'required|string|max:255',
                    'alamat_lama' => 'required|string',
                    'alamat_baru' => 'required|string',
                    'alasan_pindah' => 'required|string|max:100',
                    'tanggal_pindah' => 'nullable|date',
                    'tanggal_surat' => 'nullable|date',
                ]);

                DB::beginTransaction();
                try {
                    // Buat layanan
                    $layanan = Layanan::create($validated);

                    Log::info('Layanan created:', ['id' => $layanan->id, 'jenis' => $layanan->jenis]);

                    // Buat surat domisili
                    $suratData = [
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
                    ];

                    Log::info('Creating surat domisili:', $suratData);

                    $suratDomisili = SuratDomisili::create($suratData);

                    Log::info('Surat domisili created:', ['id' => $suratDomisili->id]);

                    DB::commit();

                    return redirect()->route('layanan.show', $layanan)
                        ->with('success', 'Layanan Surat Domisili berhasil diajukan!');

                } catch (\Exception $e) {
                    DB::rollBack();
                    Log::error('Error creating surat domisili:', [
                        'message' => $e->getMessage(),
                        'trace' => $e->getTraceAsString(),
                    ]);

                    return redirect()->back()
                        ->withInput()
                        ->withErrors(['error' => 'Error: ' . $e->getMessage()]);
                }
            } else {
                // Jenis layanan lain
                $layanan = Layanan::create($validated);

                return redirect()->route('layanan.show', $layanan)
                    ->with('success', 'Layanan berhasil diajukan!');
            }

        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()
                ->withInput()
                ->withErrors($e->errors());
        } catch (\Exception $e) {
            Log::error('Unexpected error in store:', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return redirect()->back()
                ->withInput()
                ->withErrors(['error' => 'Terjadi kesalahan: ' . $e->getMessage()]);
        }
    }

    public function show(Layanan $layanan)
    {
        Log::info('Show layanan:', [
            'id' => $layanan->id,
            'jenis' => $layanan->jenis,
            'judul' => $layanan->judul,
        ]);

        $suratDomisili = $layanan->suratDomisili;
        
        return view('layanan.show', compact('layanan', 'suratDomisili'));
    }

    public function edit(Layanan $layanan)
    {
        $penduduks = Penduduk::all();
        $suratDomisili = $layanan->suratDomisili;

        return view('layanan.edit', compact('layanan', 'penduduks', 'suratDomisili'));
    }

    public function update(Request $request, Layanan $layanan)
    {
        $validated = $request->validate([
            'jenis' => 'required|string|max:255',
            'judul' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'keterangan' => 'nullable|string',
            'status' => 'required|string',
        ]);

        if ($request->jenis === 'Surat Domisili') {
            $request->validate([
                'penduduk_id' => 'required|exists:penduduk,id',
                'nik' => 'required|string',
                'nama' => 'required|string',
                'alamat_lama' => 'required|string',
                'alamat_baru' => 'required|string',
                'alasan_pindah' => 'required|string',
            ]);

            $suratDomisili = $layanan->suratDomisili;
            if ($suratDomisili) {
                $suratDomisili->update([
                    'penduduk_id' => $request->penduduk_id,
                    'nik' => $request->nik,
                    'nama' => $request->nama,
                    'alamat_lama' => $request->alamat_lama,
                    'alamat_baru' => $request->alamat_baru,
                    'alasan_pindah' => $request->alasan_pindah,
                    'tanggal_pindah' => $request->tanggal_pindah,
                    'status' => $request->status,
                ]);
            }
        }

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
       public function cetak(Layanan $layanan) // <-- hapus ": Response"
    {
        // hanya admin atau apabila layanan berstatus 'Selesai' (sesuaikan kebijakan)
        if (auth()->user()->cannot('view', $layanan)) {
            abort(403);
        }

        $surat = $layanan->suratDomisili;
        if (!$surat) {
            return redirect()->back()->withErrors(['error' => 'Data Surat Domisili tidak ditemukan.']);
        }

        $pdf = Pdf::loadView('layanan.pdf.surat_domisili', compact('layanan', 'surat'));

        // stream atau download
        return $pdf->download("surat_domisili_{$layanan->id}.pdf");
    }
}