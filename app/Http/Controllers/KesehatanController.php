<?php

namespace App\Http\Controllers;

use App\Models\Kesehatan;
use App\Models\Anggaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KesehatanController extends Controller
{
    public function index()
    {
        $kesehatan = Kesehatan::with('anggaran')->paginate(10);
        return view('kesehatan.index', compact('kesehatan'));
    }

    public function create()
    {
        $this->authorize('isAdmin');
        $anggaran = Anggaran::all();
        return view('kesehatan.create', compact('anggaran'));
    }

    public function store(Request $request)
    {
        $this->authorize('isAdmin');
        $request->validate(['nama_program'=>'required']);

        Kesehatan::create([
            'nama_program'=>$request->nama_program,
            'tanggal'=>$request->tanggal,
            'keterangan'=>$request->keterangan,
            'jumlah_peserta'=>$request->jumlah_peserta,
            'anggaran_id'=>$request->anggaran_id,
            'created_by'=>Auth::id(),
        ]);

        return redirect()->route('kesehatan.index')->with('success','Program kesehatan ditambahkan.');
    }

    public function show(Kesehatan $kesehatan)
    {
        return view('kesehatan.show', compact('kesehatan'));
    }

    public function edit(Kesehatan $kesehatan)
    {
        $this->authorize('isAdmin');
        $anggaran = Anggaran::all();
        return view('kesehatan.edit', compact('kesehatan','anggaran'));
    }

    public function update(Request $request, Kesehatan $kesehatan)
    {
        $this->authorize('isAdmin');
        $kesehatan->update($request->all());
        return redirect()->route('kesehatan.index')->with('success','Program kesehatan diperbarui.');
    }

    public function destroy(Kesehatan $kesehatan)
    {
        $this->authorize('isAdmin');
        $kesehatan->delete();
        return redirect()->route('kesehatan.index')->with('success','Data dihapus.');
    }
}
