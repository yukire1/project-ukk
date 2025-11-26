<?php

namespace App\Http\Controllers;

use App\Models\Anggaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class AnggaranController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if (!Gate::allows('isAdmin') && !Gate::allows('isKepala')) {
                abort(403, 'Anda tidak memiliki akses ke halaman ini.');
            }
            return $next($request);
        });
    }

    public function index()
    {
        $anggaran = Anggaran::with('createdBy')->orderByDesc('tahun')->paginate(10);
        return view('Anggaran.index', compact('anggaran'));
    }

    public function create()
    {
        return view('Anggaran.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'tahun' => 'required|integer|min:2000|max:' . (date('Y') + 10),
            'sumber_dana' => 'required|string|max:255',
            'jumlah' => 'required|numeric|min:0',
            'keterangan' => 'nullable|string',
        ]);

        // tambah created_by dari user yang login
        $validated['created_by'] = auth()->id();

        Anggaran::create($validated);

        return redirect()->route('anggaran.index')->with('success', 'Anggaran berhasil ditambahkan.');
    }

    public function show(Anggaran $anggaran)
    {
        $anggaran->load('createdBy');
        return view('Anggaran.show', compact('anggaran'));
    }

    public function edit(Anggaran $anggaran)
    {
        return view('Anggaran.edit', compact('anggaran'));
    }

    public function update(Request $request, Anggaran $anggaran)
    {
        $validated = $request->validate([
            'tahun' => 'required|integer|min:2000|max:' . (date('Y') + 10),
            'sumber_dana' => 'required|string|max:255',
            'jumlah' => 'required|numeric|min:0',
            'keterangan' => 'nullable|string',
        ]);

        $anggaran->update($validated);

        return redirect()->route('anggaran.show', $anggaran)->with('success', 'Anggaran berhasil diperbarui.');
    }

    public function destroy(Anggaran $anggaran)
    {
        $anggaran->delete();
        return redirect()->route('anggaran.index')->with('success', 'Anggaran berhasil dihapus.');
    }
}