@extends('layouts.app')
@section('content')
<div class="d-flex justify-content-between mb-3">
  <h3>Daftar Penduduk</h3>
  {{-- <a href="{{ route('penduduk.create') }}" class="btn btn-primary">Tambah Penduduk</a> --}}
</div>

<table class="table table-striped">
  <thead><tr><th>#</th><th>NIK</th><th>Nama</th><th>Pekerjaan</th><th>Aksi</th></tr></thead>
  <tbody>
    @foreach($penduduks as $p)
    <tr>
      <td>{{ $p->id }}</td>
      <td>{{ $p->nik }}</td>
      <td>{{ $p->nama }}</td>
      <td>{{ $p->pekerjaan }}</td>
      <td>
        <a href="{{ route('penduduk.show',$p) }}" class="btn btn-sm btn-info">Lihat</a>
        @if(auth()->check() && (
            (method_exists(auth()->user(),'hasRole') && auth()->user()->hasRole('admin')) ||
            (isset(auth()->user()->role) && auth()->user()->role === 'admin')
        ))
        <a href="{{ route('penduduk.edit',$p) }}" class="btn btn-sm btn-warning">Ubah</a>
        @endif
        {{-- <form action="{{ route('penduduk.destroy',$p) }}" method="POST" style="display:inline">
          @csrf @method('DELETE')
          <button class="btn btn-sm btn-danger" onclick="return confirm('Hapus?')">Hapus</button>
        </form> --}}
      </td>
    </tr>
    @endforeach
  </tbody>
</table>

{{ $penduduks->links() }}
@endsection
