@extends('layouts.app')
@section('content')
<div class="d-flex justify-content-between mb-3">
  <h3>Daftar Layanan</h3>
  <a href="{{ route('layanan.create') }}" class="btn btn-primary">Ajukan Layanan</a>
</div>

<table class="table table-bordered">
  <thead>
    <tr>
      <th>#</th><th>Jenis</th><th>Judul</th><th>Pemohon</th><th>Status</th><th>Aksi</th>
    </tr>
  </thead>
  <tbody>
  @foreach($layanans as $l)
    <tr>
      <td>{{ $l->id }}</td>
      <td>{{ $l->jenis }}</td>
      <td>{{ $l->judul }}</td>
      <td>{{ $l->penduduk->nama ?? '-' }}</td>
      <td>{{ $l->status }}</td>
      <td>
        <a href="{{ route('layanan.show', $l) }}" class="btn btn-sm btn-info">Lihat</a>

        @if(auth()->check() && (
            (method_exists(auth()->user(),'hasRole') && auth()->user()->hasRole('admin')) ||
            (isset(auth()->user()->role) && auth()->user()->role === 'admin')
        ))
          <a href="{{ route('layanan.edit', $l) }}" class="btn btn-sm btn-warning">Edit</a>
        @endif
      </td>
    </tr>
  @endforeach
  </tbody>
</table>
@endsection