@extends('layouts.app')
@section('content')
<h3>Ajukan Layanan</h3>
<form action="{{ route('layanan.store') }}" method="POST">
  @csrf
  <div class="mb-3">
    <label class="form-label">Jenis</label>
    <select name="jenis" class="form-control" required>
      <option value="SuratLayananUmum">Surat Layanan Umum</option>
      <option value="BerkasKependudukan">Berkas Kependudukan</option>
      <option value="Pengaduan">Pengaduan</option>
    </select>
  </div>
  <div class="mb-3"><label class="form-label">Judul</label><input name="judul" class="form-control"></div>
  <div class="mb-3"><label class="form-label">Deskripsi</label><textarea name="deskripsi" class="form-control"></textarea></div>
  <button class="btn btn-primary">Kirim</button>
</form>
@endsection
