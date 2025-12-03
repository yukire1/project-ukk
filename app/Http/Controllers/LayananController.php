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
        $layanan = Layanan::with('createdBy', 'penduduk', 'suratDomisili')
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

            $validated['created_by'] = Auth::id();
            $validated['status'] = 'Menunggu';

            // Validasi conditional per jenis
            if ($request->jenis === 'Surat Domisili') {
                $request->validate([
                    'penduduk_id' => 'required|exists:penduduk,id',
                    'nik' => 'required|string|max:16',
                    'nama' => 'required|string|max:255',
                    'alamat_lama' => 'required|string',
                    'alamat_baru' => 'required|string',
                    'alasan_pindah' => 'required|string',
                    'tanggal_pindah' => 'nullable|date',
                    'tanggal_surat' => 'nullable|date',
                ]);

                DB::beginTransaction();
                try {
                    $layanan = Layanan::create($validated);

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

            } elseif ($request->jenis === 'Surat Layanan Umum') {
                $request->validate([
                    'jenis_surat' => 'required|string|max:255',
                    'tujuan_penggunaan' => 'required|string',
                ]);

                $validated['detail'] = [
                    'jenis_surat' => $request->jenis_surat,
                    'tujuan_penggunaan' => $request->tujuan_penggunaan,
                    'keterangan_surat' => $request->keterangan_surat,
                ];

            } elseif ($request->jenis === 'Keterangan Tidak Mampu') {
                $request->validate([
                    'nama_ktm' => 'required|string|max:255',
                    'no_kk' => 'required|string|max:16',
                ]);

                $validated['detail'] = [
                    'nama' => $request->nama_ktm,
                    'no_kk' => $request->no_kk,
                    'alasan' => $request->alasan_ktm,
                ];

            } elseif ($request->jenis === 'Pengaduan') {
                $request->validate([
                    'deskripsi_pengaduan' => 'required|string',
                ]);

                $validated['detail'] = [
                    'deskripsi' => $request->deskripsi_pengaduan,
                    'lampiran' => $request->lampiran_pengaduan,
                ];
            }

            // Buat layanan
            $layanan = Layanan::create($validated);

            return redirect()->route('layanan.show', $layanan)
                ->with('success', 'Layanan berhasil diajukan!');

        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()->withInput()
                ->withErrors($e->errors());
        } catch (\Exception $e) {
            Log::error('Error store layanan:', ['message' => $e->getMessage()]);
            return redirect()->back()->withInput()
                ->withErrors(['error' => 'Terjadi kesalahan: ' . $e->getMessage()]);
        }
    }

    public function show(Layanan $layanan)
    {
        $suratDomisili = $layanan->suratDomisili;
        return view('layanan.show', compact('layanan', 'suratDomisili'));
    }

    public function cetak(Layanan $layanan)
    {
        if ($layanan->jenis === 'Surat Domisili') {
            $surat = $layanan->suratDomisili;
            if (!$surat) {
                return redirect()->back()->withErrors(['error' => 'Data Surat Domisili tidak ditemukan.']);
            }
            $pdf = Pdf::loadView('layanan.pdf.surat_domisili', compact('layanan', 'surat'));
        } elseif ($layanan->jenis === 'Surat Layanan Umum') {
            $pdf = Pdf::loadView('layanan.pdf.surat_layanan_umum', compact('layanan'));
        } elseif ($layanan->jenis === 'Keterangan Tidak Mampu') {
            $pdf = Pdf::loadView('layanan.pdf.keterangan_tidak_mampu', compact('layanan'));
        } elseif ($layanan->jenis === 'Pengaduan') {
            $pdf = Pdf::loadView('layanan.pdf.pengaduan', compact('layanan'));
        } else {
            return redirect()->back()->withErrors(['error' => 'Jenis layanan tidak didukung untuk cetak PDF.']);
        }

        return $pdf->download("surat_{$layanan->jenis}_{$layanan->id}.pdf");
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