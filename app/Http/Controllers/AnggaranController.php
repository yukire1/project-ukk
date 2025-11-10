<?php

namespace App\Http\Controllers;

use App\Models\Anggaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AnggaranController extends Controller
{
    public function index()
    {
        $anggaran = Anggaran::latest()->paginate(10);
        return view('anggaran.index', compact('anggaran'));
    }

    public function create()
    {
        return view('anggaran.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'tahun' => 'required',
            'jumlah' => 'required|numeric',
        ]);

        Anggaran::create([
            'tahun' => $request->tahun,
            'sumber_dana' => $request->sumber_dana,
            'jumlah' => $request->jumlah,
            'keterangan' => $request->keterangan,
            'created_by' => Auth::id(),
        ]);

        return redirect()->route('anggaran.index')->with('success', 'Data anggaran berhasil ditambahkan.');
    }

    public function show(Anggaran $anggaran)
    {
        return view('anggaran.show', compact('anggaran'));
    }

    public function edit(Anggaran $anggaran)
    {
        return view('anggaran.edit', compact('anggaran'));
    }

    public function update(Request $request, Anggaran $anggaran)
    {
        $anggaran->update($request->all());
        return redirect()->route('anggaran.index')->with('success', 'Data anggaran diperbarui.');
    }

    public function destroy(Anggaran $anggaran)
    {
        $anggaran->delete();
        return redirect()->route('anggaran.index')->with('success', 'Data anggaran dihapus.');
    }
}
