<?php
namespace App\Http\Controllers;
use App\Models\Penduduk;
use Illuminate\Http\Request;

class PendudukController extends Controller {
  public function index() {
    $penduduks = Penduduk::orderBy('nama')->paginate(15);
    return view('penduduk.index', compact('penduduks'));
  }

  public function create() {
    return view('penduduk.create');
  }

  public function store(Request $request) {
    $this->authorize('isAdmin');
    $data = $request->validate([
      'nik'=>'required|string|max:20|unique:penduduk,nik',
      'nama'=>'required|string|max:150',
      'alamat'=>'nullable|string',
      'tanggal_lahir'=>'nullable|date',
      'jenis_kelamin'=>'nullable|in:L,P',
      'pekerjaan'=>'nullable|string|max:150'
    ]);
    Penduduk::create($data);
    return redirect()->route('penduduk.index')->with('success','Penduduk berhasil ditambahkan.');
  }

  public function show(Penduduk $penduduk) {

    $penduduk->load([
        'user.roles',
        'pesertaKegiatan.kegiatan',
        'pesertaKesehatan.kesehatan',
        'layanan'
    ]);
    return view('penduduk.show', compact('penduduk'));
  }

  public function edit(Penduduk $penduduk) {
    $this->authorize('isAdmin');
    return view('penduduk.edit', compact('penduduk'));
  }

  public function update(Request $request, Penduduk $penduduk) {
    $this->authorize('isAdmin');
    $data = $request->validate([
      'nik'=>'required|string|max:20|unique:penduduk,nik,'.$penduduk->id,
      'nama'=>'required|string|max:150',
      'alamat'=>'nullable|string',
      'tanggal_lahir'=>'nullable|date',
      'jenis_kelamin'=>'nullable|in:L,P',
      'pekerjaan'=>'nullable|string|max:150'
    ]);
    $penduduk->update($data);
    return redirect()->route('penduduk.index')->with('success','Penduduk diperbarui.');
  }

  public function destroy(Penduduk $penduduk) {
    // $this->authorize('isAdmin');
    $penduduk->delete();
    return redirect()->route('penduduk.index')->with('success','Penduduk dihapus.');
  }
}
