@extends('layouts.app')
@section('content')
<div class="d-flex justify-content-between mb-3">
  <h3>Daftar Layanan</h3>
  <a href="{{ route('layanan.create') }}" class="btn btn-primary">Ajukan Layanan</a>
</div>

<table class="table table-bordered">
  <thead><tr><th>#</th><th>Jenis</th><th>Judul</th><th>Pemohon</th><th>Status</th><th>Aksi</th></tr></thead>
  <tbody>
  @foreach($layanan as $l)
    <tr>
      <td>{{ $l->id }}</td>
      <td>{{ $l->jenis }}</td>
      <td>{{ $l->judul }}</td>
      <td>{{ $l->penduduk->nama ?? '-' }}</td>
      <td>{{ $l->status }}</td>
      <td>
        <a href="{{ route('layanan.show',$l) }}" class="btn btn-sm btn-info">Lihat</a>
        @can('isAdmin')
          <a href="{{ route('layanan.edit',$l) }}" class="btn btn-sm btn-warning">Edit</a>
        @endcan
      </td>
    </tr>
  @endforeach
  </tbody>
</table>
{{ $layanan->links() }}
@endsection
