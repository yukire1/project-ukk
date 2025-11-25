<?php

namespace App\Http\Controllers;

use App\Models\PesertaKesehatan;
use App\Models\Kesehatan;
use App\Models\Penduduk;
use Illuminate\Http\Request;

class PesertaKesehatanController extends Controller
{
    public function index()
    {
        $peserta = PesertaKesehatan::with(['kesehatan','penduduk'])->paginate(10);
        return view('peserta_kesehatan.index', compact('peserta'));
    }

    public function create()
    {
        $this->authorize('isAdmin');
        $kesehatan = Kesehatan::all();
        $penduduk = Penduduk::all();
        return view('peserta_kesehatan.create', compact('kesehatan','penduduk'));
    }

    public function store(Request $request)
    {
        $this->authorize('isAdmin');

        $request->validate([
            'kesehatan_id'=>'required|exists:kesehatan,id',
            'penduduk_id'=>'required|exists:penduduk,id'
        ]);

        PesertaKesehatan::create($request->all());
        return redirect()->route('peserta_kesehatan.index')->with('success','Peserta kesehatan ditambahkan.');
    }

    public function show(PesertaKesehatan $peserta_kesehatan)
    {
        return view('peserta_kesehatan.show', compact('peserta_kesehatan'));
    }

    public function edit(PesertaKesehatan $peserta_kesehatan)
    {
        $this->authorize('isAdmin');
        $kesehatan = Kesehatan::all();
        $penduduk = Penduduk::all();
        return view('peserta_kesehatan.edit', compact('peserta_kesehatan','kesehatan','penduduk'));
    }

    public function update(Request $request, PesertaKesehatan $peserta_kesehatan)
    {
        $this->authorize('isAdmin');
        $peserta_kesehatan->update($request->all());
        return redirect()->route('peserta_kesehatan.index')->with('success','Peserta kesehatan diperbarui.');
    }

    public function destroy(PesertaKesehatan $peserta_kesehatan)
    {
        $this->authorize('isAdmin');
        $peserta_kesehatan->delete();
        return redirect()->route('peserta_kesehatan.index')->with('success','Peserta dihapus.');
    }
}
