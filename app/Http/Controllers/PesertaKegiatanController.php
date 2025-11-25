<?php

namespace App\Http\Controllers;

use App\Models\PesertaKegiatan;
use App\Models\Penduduk;
use App\Models\Kegiatan;
use Illuminate\Http\Request;

class PesertaKegiatanController extends Controller
{
    public function index()
    {
        $peserta = PesertaKegiatan::with(['kegiatan','penduduk'])->paginate(10);
        return view('peserta_kegiatan.index', compact('peserta'));
    }

    public function create()
    {
        $this->authorize('isAdmin');
        $kegiatan = Kegiatan::all();
        $penduduk = Penduduk::all();
        return view('peserta_kegiatan.create', compact('kegiatan','penduduk'));
    }

    public function store(Request $request)
    {
        $this->authorize('isAdmin');

        $request->validate([
            'kegiatan_id' => 'required|exists:kegiatan,id',
            'penduduk_id' => 'required|exists:penduduk,id'
        ]);

        PesertaKegiatan::create($request->all());
        return redirect()->route('peserta_kegiatan.index')->with('success','Peserta kegiatan ditambahkan.');
    }

    public function show(PesertaKegiatan $peserta_kegiatan)
    {
        return view('peserta_kegiatan.show', compact('peserta_kegiatan'));
    }

    public function edit(PesertaKegiatan $peserta_kegiatan)
    {
        $this->authorize('isAdmin');
        $kegiatan = Kegiatan::all();
        $penduduk = Penduduk::all();
        return view('peserta_kegiatan.edit', compact('peserta_kegiatan','kegiatan','penduduk'));
    }

    public function update(Request $request, PesertaKegiatan $peserta_kegiatan)
    {
        $this->authorize('isAdmin');
        $peserta_kegiatan->update($request->all());
        return redirect()->route('peserta_kegiatan.index')->with('success','Data peserta diperbarui.');
    }

    public function destroy(PesertaKegiatan $peserta_kegiatan)
    {
        $this->authorize('isAdmin');
        $peserta_kegiatan->delete();
        return redirect()->route('peserta_kegiatan.index')->with('success','Peserta dihapus.');
    }
}
