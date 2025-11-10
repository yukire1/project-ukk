<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Layanan;
use App\Models\Penduduk;
use App\Models\TrackingLayanan;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class UserController extends Controller
{
    use AuthorizesRequests;
    // ...
}
class LayananController extends Controller {
  public function index() {
    $user = auth()->user();
    if ($user->hasRole('admin') || $user->hasRole('kepala_desa')) {
      $layanan = Layanan::with('penduduk')->orderByDesc('tanggal_pengajuan')->paginate(15);
    } else {
      // warga: hanya lihat miliknya
      $penduduk = $user->penduduk;
      $layanan = Layanan::where('penduduk_id', $penduduk->id)->orderByDesc('tanggal_pengajuan')->paginate(15);
    }
    return view('layanan.index', compact('layanan'));
  }

  public function create() {
    return view('layanan.create');
  }

  public function store(Request $request) {
    $user = auth()->user();
    // warga membuat layanan: pastikan user punya penduduk profile
    if (!$user->penduduk) return redirect()->back()->with('error','Lengkapi profil penduduk terlebih dahulu.');

    $data = $request->validate([
      'jenis'=>'required|in:SuratLayananUmum,BerkasKependudukan,Pengaduan',
      'judul'=>'nullable|string|max:200',
      'deskripsi'=>'nullable|string'
    ]);

    $data['penduduk_id'] = $user->penduduk->id;
    $layanan = Layanan::create($data);

    // initial tracking
    TrackingLayanan::create([
      'layanan_id'=>$layanan->id,
      'status'=>'Menunggu',
      'keterangan'=>'Pengajuan dibuat oleh warga',
      'updated_by'=>$user->id
    ]);

    return redirect()->route('layanan.index')->with('success','Layanan berhasil diajukan.');
  }

  public function show(Layanan $layanan) {
    $this->authorize('view', $layanan); // optional policy - else check manually
    $layanan->load('tracking','penduduk','assignedAdmin','assignedKepala');
    return view('layanan.show', compact('layanan'));
  }

  public function edit(Layanan $layanan) {
    // only admin or kepala can edit status/assignment
    $this->authorize('isAdmin');
    return view('layanan.edit', compact('layanan'));
  }

  public function update(Request $request, Layanan $layanan) {
    $this->authorize('isAdmin');
    $data = $request->validate([
      'status'=>'required|in:Menunggu,Diproses,Diverifikasi,Ditolak,Selesai',
      'assigned_admin_id'=>'nullable|exists:users,id',
      'assigned_kepala_id'=>'nullable|exists:users,id',
      'judul'=>'nullable|string|max:200',
      'deskripsi'=>'nullable|string'
    ]);
    $layanan->update($data);

    // record tracking
    TrackingLayanan::create([
      'layanan_id'=>$layanan->id,
      'status'=>$data['status'],
      'keterangan'=>'Status diubah oleh admin',
      'updated_by'=>auth()->id()
    ]);

    return redirect()->route('layanan.show',$layanan)->with('success','Layanan diperbarui.');
  }

  public function destroy(Layanan $layanan) {
    $this->authorize('isAdmin');
    $layanan->delete();
    return redirect()->route('layanan.index')->with('success','Layanan dihapus.');
  }
}
