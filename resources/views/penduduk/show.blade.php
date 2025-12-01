@extends('layouts.app')
@section('content')
<div class="d-flex justify-content-between mb-3">
  <h3>Detail Penduduk</h3>
  <div>
    <a href="{{ route('penduduk.index') }}" class="btn btn-secondary">Kembali</a>
    @if(auth()->check() && (
            (method_exists(auth()->user(),'hasRole') && auth()->user()->hasRole('admin')) ||
            (isset(auth()->user()->role) && auth()->user()->role === 'admin')
        ))
    <a href="{{ route('penduduk.edit', $penduduk) }}" class="btn btn-warning">Edit</a>
    @endif
  </div>
</div>

@if(session('success'))
  <div class="alert alert-success">{{ session('success') }}</div>
@endif

<!-- Card Informasi Dasar -->
<div class="card mb-4">
  <div class="card-header bg-primary text-white">
    <h5 class="mb-0">Informasi Dasar</h5>
  </div>
  <div class="card-body">
    <div class="row">
      <div class="col-md-6 mb-3">
        <p><strong>NIK:</strong> {{ $penduduk->nik }}</p>
        <p><strong>Nama:</strong> {{ $penduduk->nama }}</p>
        <p><strong>Jenis Kelamin:</strong> {{ $penduduk->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</p>
      </div>
      <div class="col-md-6 mb-3">
        <p><strong>Tanggal Lahir:</strong> {{ $penduduk->tanggal_lahir ? \Carbon\Carbon::parse($penduduk->tanggal_lahir)->format('d-m-Y') : '-' }}</p>
        <p><strong>Pekerjaan:</strong> {{ $penduduk->pekerjaan ?? '-' }}</p>
        <p><strong>Status:</strong> <span class="badge bg-success">Aktif</span></p>
      </div>
    </div>
    <hr>
    <p><strong>Alamat:</strong></p>
    <p>{{ $penduduk->alamat ?? '-' }}</p>
  </div>
</div>

<!-- Card Akun User Terkait -->
@if($penduduk->user)
<div class="card mb-4">
  <div class="card-header bg-info text-white">
    <h5 class="mb-0">Akun User Terkait</h5>
  </div>
  <div class="card-body">
    <div class="row">
      <div class="col-md-6 mb-3">
        <p><strong>Username:</strong> {{ $penduduk->user->username }}</p>
        <p><strong>Email:</strong> {{ $penduduk->user->email }}</p>
      </div>
      <div class="col-md-6 mb-3">
        <p><strong>Role:</strong> 
          @forelse($penduduk->user->roles as $role)
            <span class="badge bg-secondary">{{ $role->name }}</span>
          @empty
            <span class="text-muted">-</span>
          @endforelse
        </p>
        <p><strong>Terdaftar:</strong> {{ $penduduk->user->created_at->format('d-m-Y H:i') }}</p>
      </div>
    </div>
  </div>
</div>
@endif

<!-- Card Kegiatan -->
{{-- <div class="card mb-4">
  <div class="card-header bg-warning text-dark">
    <h5 class="mb-0">Kegiatan yang Diikuti</h5>
  </div>
  <div class="card-body">
    @if($penduduk->pesertaKegiatan->isNotEmpty())
      <div class="table-responsive">
        <table class="table table-striped table-bordered">
          <thead class="table-dark">
            <tr>
              <th>#</th>
              <th>Nama Kegiatan</th>
              <th>Tanggal Mulai</th>
              <th>Tanggal Selesai</th>
              <th>Lokasi</th>
              <th>Status Kehadiran</th>
            </tr>
          </thead>
          <tbody>
            @foreach($penduduk->pesertaKegiatan as $peserta)
            <tr>
              <td>{{ $loop->iteration }}</td>
              <td>
                <a href="{{ route('kegiatan.show', $peserta->kegiatan) }}">
                  {{ $peserta->kegiatan->nama_kegiatan }}
                </a>
              </td>
              <td>{{ \Carbon\Carbon::parse($peserta->kegiatan->tanggal_mulai)->format('d-m-Y') }}</td>
              <td>{{ \Carbon\Carbon::parse($peserta->kegiatan->tanggal_selesai)->format('d-m-Y') }}</td>
              <td>{{ $peserta->kegiatan->lokasi }}</td>
              <td>
                <span class="badge {{ $peserta->status_kehadiran === 'Hadir' ? 'bg-success' : 'bg-warning' }}">
                  {{ $peserta->status_kehadiran }}
                </span>
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    @else
      <p class="text-muted text-center">Belum mengikuti kegiatan apapun</p>
    @endif
  </div>
</div> --}}

<!-- Card Data Kesehatan -->
{{-- <div class="card mb-4">
  <div class="card-header bg-danger text-white">
    <h5 class="mb-0">Data Kesehatan</h5>
  </div>
  <div class="card-body">
    @if($penduduk->pesertaKesehatan->isNotEmpty())
      <div class="table-responsive">
        <table class="table table-striped table-bordered">
          <thead class="table-dark">
            <tr>
              <th>#</th>
              <th>Program Kesehatan</th>
              <th>Tanggal Pelaksanaan</th>
              <th>Lokasi</th>
              <th>Status Kehadiran</th>
              <th>Catatan</th>
            </tr>
          </thead>
          <tbody>
            @foreach($penduduk->pesertaKesehatan as $peserta)
            <tr>
              <td>{{ $loop->iteration }}</td>
              <td>
                <a href="{{ route('kesehatan.show', $peserta->kesehatan) }}">
                  {{ $peserta->kesehatan->nama_program }}
                </a>
              </td>
              <td>{{ \Carbon\Carbon::parse($peserta->kesehatan->tanggal_pelaksanaan)->format('d-m-Y') }}</td>
              <td>{{ $peserta->kesehatan->lokasi }}</td>
              <td>
                <span class="badge {{ $peserta->status_kehadiran === 'Hadir' ? 'bg-success' : 'bg-warning' }}">
                  {{ $peserta->status_kehadiran }}
                </span>
              </td>
              <td>{{ Str::limit($peserta->catatan, 30) ?? '-' }}</td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    @else
      <p class="text-muted text-center">Belum terdaftar dalam program kesehatan</p>
    @endif
  </div>
</div> --}}

<!-- Card Layanan -->
<div class="card mb-4">
  <div class="card-header bg-success text-white">
    <h5 class="mb-0">Layanan yang Diajukan</h5>
  </div>
  <div class="card-body">
    @if($penduduk->layanan->isNotEmpty())
      <div class="table-responsive">
        <table class="table table-striped table-bordered">
          <thead class="table-dark">
            <tr>
              <th>#</th>
              <th>Jenis Layanan</th>
              <th>Judul</th>
              <th>Tanggal Pengajuan</th>
              <th>Status</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
            @foreach($penduduk->layanan as $layanan)
            <tr>
              <td>{{ $loop->iteration }}</td>
              <td>{{ $layanan->jenis }}</td>
              <td>{{ $layanan->judul }}</td>
              <td>{{ \Carbon\Carbon::parse($layanan->tanggal_pengajuan)->format('d-m-Y H:i') }}</td>
              <td>
                <span class="badge {{ $layanan->status === 'Selesai' ? 'bg-success' : ($layanan->status === 'Ditolak' ? 'bg-danger' : 'bg-info') }}">
                  {{ $layanan->status }}
                </span>
              </td>
              <td>
                <a href="{{ route('layanan.show', $layanan) }}" class="btn btn-sm btn-info">Lihat</a>
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    @else
      <p class="text-muted text-center">Belum ada layanan yang diajukan</p>
    @endif
  </div>
</div>

<!-- Info Waktu -->
<div class="card">
  <div class="card-body text-muted small">
    <p class="mb-0">Dibuat: {{ $penduduk->created_at->format('d-m-Y H:i') }} | Diperbarui: {{ $penduduk->updated_at->format('d-m-Y H:i') }}</p>
  </div>
</div>
@endsection