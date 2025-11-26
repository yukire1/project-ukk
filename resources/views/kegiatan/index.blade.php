@extends('layouts.app')
@section('content')
<div class="d-flex justify-content-between mb-3">
  <h3>Daftar Kegiatan</h3>
  <a href="{{ route('kegiatan.create') }}" class="btn btn-primary">Tambah Kegiatan</a>
</div>

@if(session('success'))
  <div class="alert alert-success">{{ session('success') }}</div>
@endif

<table class="table table-striped table-bordered">
  <thead class="table-dark">
    <tr>
      <th>#</th>
      <th>Nama Kegiatan</th>
      <th>Deskripsi</th>
      <th>Tanggal Mulai</th>
      <th>Tanggal Selesai</th>
      <th>Lokasi</th>
      <th>Status</th>
      <th>Aksi</th>
    </tr>
  </thead>
  <tbody>
    @forelse($kegiatan as $k)
    <tr>
      <td>{{ $k->id }}</td>
      <td>{{ $k->nama_kegiatan }}</td>
      <td>{{ Str::limit($k->deskripsi, 50) }}</td>
      <td>{{ \Carbon\Carbon::parse($k->tanggal_mulai)->format('d-m-Y') }}</td>
      <td>{{ \Carbon\Carbon::parse($k->tanggal_selesai)->format('d-m-Y') }}</td>
      <td>{{ $k->lokasi }}</td>
      <td>
        <span class="badge {{ $k->status === 'Aktif' ? 'bg-success' : 'bg-secondary' }}">
          {{ $k->status }}
        </span>
      </td>
      <td>
        <a href="{{ route('kegiatan.show', $k) }}" class="btn btn-sm btn-info">Lihat</a>
        <a href="{{ route('kegiatan.edit', $k) }}" class="btn btn-sm btn-warning">Edit</a>
        <form action="{{ route('kegiatan.destroy', $k) }}" method="POST" style="display:inline">
          @csrf @method('DELETE')
          <button class="btn btn-sm btn-danger" onclick="return confirm('Hapus?')">Hapus</button>
        </form>
      </td>
    </tr>
    @empty
    <tr><td colspan="8" class="text-center text-muted">Tidak ada data kegiatan</td></tr>
    @endforelse
  </tbody>
</table>
@endsection