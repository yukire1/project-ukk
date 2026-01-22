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
      <option value="Surat Domisili" {{ old('jenis', $layanan->jenis) == 'Surat Domisili' ? 'selected' : '' }}>Surat Domisili</option>
      <option value="Surat Layanan Umum" {{ old('jenis', $layanan->jenis) == 'Surat Layanan Umum' ? 'selected' : '' }}>Surat Layanan Umum</option>
      <option value="Keterangan Tidak Mampu" {{ old('jenis', $layanan->jenis) == 'Keterangan Tidak Mampu' ? 'selected' : '' }}>Keterangan Tidak Mampu</option>
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

  <button class="btn btn-primary">Simpan Perubahan</button>
</form>
@endsection