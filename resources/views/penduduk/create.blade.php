@extends('layouts.app')
@section('content')
<h3>Tambah Penduduk</h3>
<form action="{{ route('penduduk.store') }}" method="POST">
  @csrf
  <div class="mb-3"><label class="form-label">NIK</label><input name="nik" class="form-control" required></div>
  <div class="mb-3"><label class="form-label">Nama</label><input name="nama" class="form-control" required></div>
  <div class="mb-3"><label class="form-label">Alamat</label><textarea name="alamat" class="form-control"></textarea></div>
  <div class="mb-3"><label class="form-label">Tanggal Lahir</label><input type="date" name="tanggal_lahir" class="form-control"></div>
  <div class="mb-3"><label class="form-label">Jenis Kelamin</label>
    <select name="jenis_kelamin" class="form-control">
      <option value="">Pilih</option><option value="L">L</option><option value="P">P</option>
    </select>
  </div>
  <div class="mb-3"><label class="form-label">Pekerjaan</label><input name="pekerjaan" class="form-control"></div>
  <button class="btn btn-primary">Simpan</button>
</form>
@endsection
