@extends('layouts.app')
@section('content')
<div class="d-flex justify-content-between mb-3">
  <h3>Edit Layanan</h3>
  <a href="{{ route('layanan.index') }}" class="btn btn-secondary">Kembali</a>
</div>

@if ($errors->any())
  <div class="alert alert-danger">
    <ul class="mb-0">
      @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
      @endforeach
    </ul>
  </div>
@endif

<form action="{{ route('layanan.update', $layanan) }}" method="POST">
  @csrf
  @method('PUT')

  <div class="mb-3">
    <label class="form-label">Jenis</label>
    <select name="jenis" class="form-control" required>
      <option value="SuratLayananUmum" {{ old('jenis', $layanan->jenis) == 'SuratLayananUmum' ? 'selected' : '' }}>Surat Layanan Umum</option>
      <option value="BerkasKependudukan" {{ old('jenis', $layanan->jenis) == 'BerkasKependudukan' ? 'selected' : '' }}>Berkas Kependudukan</option>
      <option value="Pengaduan" {{ old('jenis', $layanan->jenis) == 'Pengaduan' ? 'selected' : '' }}>Pengaduan</option>
    </select>
  </div>

  <div class="mb-3">
    <label class="form-label">Judul</label>
    <input name="judul" class="form-control" value="{{ old('judul', $layanan->judul) }}" required>
  </div>

  <div class="mb-3">
    <label class="form-label">Deskripsi</label>
    <textarea name="deskripsi" class="form-control" rows="6" required>{{ old('deskripsi', $layanan->deskripsi) }}</textarea>
  </div>

  <div class="mb-3">
    <label class="form-label">Status</label>
    <select name="status" class="form-control">
      <option value="">-- Pilih Status --</option>
      <option value="Menunggu" {{ old('status', $layanan->status) == 'Menunggu' ? 'selected' : '' }}>Menunggu</option>
      <option value="Diproses" {{ old('status', $layanan->status) == 'Diproses' ? 'selected' : '' }}>Diproses</option>
      <option value="Diverifikasi" {{ old('status', $layanan->status) == 'Diverifikasi' ? 'selected' : '' }}>Diverifikasi</option>
      <option value="Ditolak" {{ old('status', $layanan->status) == 'Ditolak' ? 'selected' : '' }}>Ditolak</option>
      <option value="Selesai" {{ old('status', $layanan->status) == 'Selesai' ? 'selected' : '' }}>Selesai</option>
    </select>
  </div>

  <button class="btn btn-primary">Simpan Perubahan</button>
</form>
@endsection