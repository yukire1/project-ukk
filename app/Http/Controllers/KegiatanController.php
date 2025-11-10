<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Kegiatan;
use App\Models\Anggaran;

class KegiatanController extends Controller {
  public function index() {
    $kegiatan = Kegiatan::with('anggaran')->orderBy('tanggal','desc')->paginate(15);
    return view('kegiatan.index', compact('kegiatan'));
  }

  public function create() {
    $this->authorize('isAdmin');
    $anggarans = Anggaran::orderBy('tahun')->get();
    return view('kegiatan.create', compact('anggarans'));
  }

  public function store(Request $request) {
    $this->authorize('isAdmin');
    $data = $request->validate([
      'nama_kegiatan'=>'required|string|max:200',
      'tanggal'=>'nullable|date',
      'lokasi'=>'nullable|string|max:200',
      'deskripsi'=>'nullable|string',
      'anggaran_id'=>'nullable|exists:anggaran,id',
      'status'=>'nullable|in:draft,menunggu_persetujuan,disetujui,ditolak,selesai'
    ]);
    $data['created_by'] = auth()->id();
    Kegiatan::create($data);
    return redirect()->route('kegiatan.index')->with('success','Kegiatan dibuat.');
  }

  public function show(Kegiatan $kegiatan) {
    return view('kegiatan.show', compact('kegiatan'));
  }

  public function edit(Kegiatan $kegiatan) {
    $this->authorize('isAdmin');
    $anggarans = Anggaran::orderBy('tahun')->get();
    return view('kegiatan.edit', compact('kegiatan','anggarans'));
  }

  public function update(Request $request, Kegiatan $kegiatan) {
    // admin edits; kepala desa approves via status set to 'disetujui'
    if(auth()->user()->hasRole('kepala_desa') && $request->filled('status')) {
      // kepala desa dapat mengubah status untuk persetujuan
      $this->authorize('isKepala');
    } else {
      $this->authorize('isAdmin');
    }

    $data = $request->validate([
      'nama_kegiatan'=>'required|string|max:200',
      'tanggal'=>'nullable|date',
      'lokasi'=>'nullable|string|max:200',
      'deskripsi'=>'nullable|string',
      'anggaran_id'=>'nullable|exists:anggaran,id',
      'status'=>'nullable|in:draft,menunggu_persetujuan,disetujui,ditolak,selesai'
    ]);

    if(auth()->user()->hasRole('kepala_desa') && isset($data['status'])) {
      $data['persetujuan_by'] = auth()->id();
    }

    $kegiatan->update($data);
    return redirect()->route('kegiatan.show',$kegiatan)->with('success','Kegiatan diperbarui.');
  }

  public function destroy(Kegiatan $kegiatan) {
    $this->authorize('isAdmin');
    $kegiatan->delete();
    return redirect()->route('kegiatan.index')->with('success','Kegiatan dihapus.');
  }
}
