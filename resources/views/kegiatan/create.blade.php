@extends('layouts.app')
@section('content')
<div class="d-flex justify-content-between mb-3">
  <h3>Tambah Kegiatan</h3>
  <a href="{{ route('kegiatan.index') }}" class="btn btn-secondary">Kembali</a>
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

<form action="{{ route('kegiatan.store') }}" method="POST" class="card p-4">
  @csrf

  <div class="mb-3">
    <label class="form-label">Nama Kegiatan</label>
    <input type="text" name="nama_kegiatan" class="form-control" value="{{ old('nama_kegiatan') }}" required>
  </div>

  <div class="mb-3">
    <label class="form-label">Deskripsi</label>
    <textarea name="deskripsi" class="form-control" rows="4" required>{{ old('deskripsi') }}</textarea>
  </div>

  <div class="row">
    <div class="col-md-6 mb-3">
      <label class="form-label">Tanggal Mulai</label>
      <input type="date" name="tanggal_mulai" class="form-control" value="{{ old('tanggal_mulai') }}" required>
    </div>
    <div class="col-md-6 mb-3">
      <label class="form-label">Tanggal Selesai</label>
      <input type="date" name="tanggal_selesai" class="form-control" value="{{ old('tanggal_selesai') }}" required>
    </div>
  </div>

  <div class="mb-3">
    <label class="form-label">Lokasi</label>
    <input type="text" name="lokasi" class="form-control" value="{{ old('lokasi') }}" required>
  </div>

  <div class="mb-3">
    <label class="form-label">Status</label>
    <select name="status" class="form-control" required>
      <option value="Aktif" {{ old('status') == 'Aktif' ? 'selected' : '' }}>Aktif</option>
      <option value="Tidak Aktif" {{ old('status') == 'Tidak Aktif' ? 'selected' : '' }}>Tidak Aktif</option>
    </select>
  </div>

  <button type="submit" class="btn btn-primary">Simpan</button>
</form>
@endsection