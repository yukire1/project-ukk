@extends('layouts.app')
@section('content')
<div class="d-flex justify-content-between mb-3">
  <h3>Daftar Layanan</h3>
  <a href="{{ route('layanan.create') }}" class="btn btn-primary">Ajukan Layanan</a>
</div>

@if($layanan->count())
  <table class="table table-bordered table-hover">
    <thead class="table-dark">
      <tr>
        <th>No</th>
        <th>Jenis Layanan</th>
        <th>Judul</th>
        <th>Status</th>
        <th>Tanggal</th>
        <th>Aksi</th>
      </tr>
    </thead>
    <tbody>
      @foreach($layanan as $l)
      <tr>
        <td>{{ $loop->iteration }}</td>
        <td>
          <span class="badge bg-info">{{ $l->jenis }}</span>
        </td>
        <td>{{ $l->judul }}</td>
        <td>
          <span class="badge {{ $l->status === 'Selesai' ? 'bg-success' : ($l->status === 'Ditolak' ? 'bg-danger' : 'bg-warning') }}">
            {{ $l->status }}
          </span>
        </td>
        <td>{{ $l->created_at->format('d-m-Y H:i') }}</td>
        <td>
          <a href="{{ route('layanan.show', $l) }}" class="btn btn-sm btn-primary">Lihat</a>
          <a href="{{ route('layanan.edit', $l) }}" class="btn btn-sm btn-warning">Edit</a>
        </td>
      </tr>
      @endforeach
    </tbody>
  </table>

  {{ $layanan->links() }}
@else
  <div class="alert alert-info">
    Tidak ada layanan. <a href="{{ route('layanan.create') }}">Buat layanan baru</a>
  </div>
@endif
@endsection