@extends('layouts.app')
@section('content')
<div class="d-flex justify-content-between mb-3">
  <h3>Detail Kegiatan</h3>
  <div>
    <a href="{{ route('kegiatan.index') }}" class="btn btn-secondary">Kembali</a>
    <a href="{{ route('kegiatan.edit', $kegiatan) }}" class="btn btn-warning">Edit</a>
  </div>
</div>

<div class="card mb-4">
  <div class="card-body">
    <h5 class="card-title">{{ $kegiatan->nama_kegiatan }}</h5>
    <p><strong>Deskripsi:</strong> {{ $kegiatan->deskripsi }}</p>
    <hr>
    <div class="row">
      <div class="col-md-6">
        <p><strong>Tanggal Mulai:</strong> {{ \Carbon\Carbon::parse($kegiatan->tanggal_mulai)->format('d-m-Y H:i') }}</p>
        <p><strong>Tanggal Selesai:</strong> {{ \Carbon\Carbon::parse($kegiatan->tanggal_selesai)->format('d-m-Y H:i') }}</p>
      </div>
      <div class="col-md-6">
        <p><strong>Lokasi:</strong> {{ $kegiatan->lokasi }}</p>
        <p><strong>Status:</strong> <span class="badge {{ $kegiatan->status === 'Aktif' ? 'bg-success' : 'bg-secondary' }}">{{ $kegiatan->status }}</span></p>
      </div>
    </div>
  </div>
</div>

<h5>Peserta Kegiatan</h5>
<div class="mb-3">
  <a href="{{ route('peserta-kegiatan.create', ['kegiatan_id' => $kegiatan->id]) }}" class="btn btn-sm btn-primary">Tambah Peserta</a>
</div>

<table class="table table-striped table-bordered">
  <thead class="table-dark">
    <tr>
      <th>#</th>
      <th>Nama Peserta</th>
      <th>NIK</th>
      <th>Status Kehadiran</th>
      <th>Aksi</th>
    </tr>
  </thead>
  <tbody>
    @forelse($kegiatan->pesertaKegiatan as $p)
    <tr>
      <td>{{ $p->id }}</td>
      <td>{{ $p->penduduk->nama ?? '-' }}</td>
      <td>{{ $p->penduduk->nik ?? '-' }}</td>
      <td>
        <span class="badge {{ $p->status_kehadiran === 'Hadir' ? 'bg-success' : 'bg-warning' }}">
          {{ $p->status_kehadiran }}
        </span>
      </td>
      <td>
        <a href="{{ route('peserta-kegiatan.edit', $p) }}" class="btn btn-sm btn-warning">Edit</a>
        <form action="{{ route('peserta-kegiatan.destroy', $p) }}" method="POST" style="display:inline">
          @csrf @method('DELETE')
          <button class="btn btn-sm btn-danger" onclick="return confirm('Hapus?')">Hapus</button>
        </form>
      </td>
    </tr>
    @empty
    <tr><td colspan="5" class="text-center text-muted">Belum ada peserta</td></tr>
    @endforelse
  </tbody>
</table>
@endsection