@extends('layouts.app')
@section('content')
<div class="d-flex justify-content-between mb-3">
  <h3>Tambah Anggaran</h3>
  <a href="{{ route('anggaran.index') }}" class="btn btn-secondary">Kembali</a>
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

<form action="{{ route('anggaran.store') }}" method="POST" class="card p-4">
  @csrf

  <div class="mb-3">
    <label class="form-label">Tahun</label>
    <input type="number" name="tahun" class="form-control" value="{{ old('tahun', date('Y')) }}" required min="2000">
  </div>

  <div class="mb-3">
    <label class="form-label">Sumber Dana</label>
    <input type="text" name="sumber_dana" class="form-control" value="{{ old('sumber_dana') }}" placeholder="Contoh: APBD, Dana Desa, Hibah" required>
  </div>

  <div class="mb-3">
    <label class="form-label">Jumlah (Rp)</label>
    <input type="number" name="jumlah" class="form-control" value="{{ old('jumlah') }}" placeholder="Masukkan jumlah anggaran" required min="0" step="1000">
  </div>

  <div class="mb-3">
    <label class="form-label">Keterangan</label>
    <textarea name="keterangan" class="form-control" rows="4" placeholder="Masukkan keterangan anggaran">{{ old('keterangan') }}</textarea>
  </div>

  <button type="submit" class="btn btn-primary">Simpan</button>
</form>
@endsection