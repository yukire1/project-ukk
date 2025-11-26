@extends('layouts.app')
@section('content')
<div class="d-flex justify-content-between mb-3">
  <h3>Daftar Anggaran</h3>
  <a href="{{ route('anggaran.create') }}" class="btn btn-primary">Tambah Anggaran</a>
</div>

@if(session('success'))
  <div class="alert alert-success">{{ session('success') }}</div>
@endif

<table class="table table-striped table-bordered">
  <thead class="table-dark">
    <tr>
      <th>#</th>
      <th>Tahun</th>
      <th>Sumber Dana</th>
      <th>Jumlah (Rp)</th>
      <th>Keterangan</th>
      <th>Dibuat Oleh</th>
      <th>Aksi</th>
    </tr>
  </thead>
  <tbody>
    @forelse($anggaran as $a)
    <tr>
      <td>{{ $a->id }}</td>
      <td>{{ $a->tahun }}</td>
      <td>{{ $a->sumber_dana }}</td>
      <td>Rp {{ number_format($a->jumlah, 0, ',', '.') }}</td>
      <td>{{ Str::limit($a->keterangan, 50) }}</td>
      <td>{{ $a->createdBy->username ?? '-' }}</td>
      <td>
        <a href="{{ route('anggaran.show', $a) }}" class="btn btn-sm btn-info">Lihat</a>
        <a href="{{ route('anggaran.edit', $a) }}" class="btn btn-sm btn-warning">Edit</a>
        <form action="{{ route('anggaran.destroy', $a) }}" method="POST" style="display:inline">
          @csrf @method('DELETE')
          <button class="btn btn-sm btn-danger" onclick="return confirm('Hapus?')">Hapus</button>
        </form>
      </td>
    </tr>
    @empty
    <tr><td colspan="7" class="text-center text-muted">Tidak ada data anggaran</td></tr>
    @endforelse
  </tbody>
</table>
@endsection