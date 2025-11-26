@extends('layouts.app')
@section('content')
<div class="d-flex justify-content-between mb-3">
  <h3>Edit Anggaran</h3>
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

<form action="{{ route('anggaran.update', $anggaran) }}" method="POST" class="card p-4">
  @csrf
  @method('PUT')

  <div class="mb-3">
    <label class="form-label">Tahun</label>
    <input type="number" name="tahun" class="form-control" value="{{ old('tahun', $anggaran->tahun) }}" required min="2000" max="{{ date('Y') + 10 }}">
  </div>

  <div class="mb-3">
    <label class="form-label">Sumber Dana</label>
    <input type="text" name="sumber_dana" class="form-control" value="{{ old('sumber_dana', $anggaran->sumber_dana) }}" required>
  </div>

  <div class="mb-3">
    <label class="form-label">Jumlah (Rp)</label>
    <input type="number" name="jumlah" class="form-control" value="{{ old('jumlah', $anggaran->jumlah) }}" required min="0" step="0.01">
  </div>

  <div class="mb-3">
    <label class="form-label">Keterangan</label>
    <textarea name="keterangan" class="form-control" rows="4">{{ old('keterangan', $anggaran->keterangan) }}</textarea>
  </div>

  <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
</form>
@endsection