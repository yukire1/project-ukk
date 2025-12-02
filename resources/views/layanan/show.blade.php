@extends('layouts.app')
@section('content')
<div class="d-flex justify-content-between mb-3">
  <h3>Detail Layanan</h3>
  <div>
    <a href="{{ route('layanan.index') }}" class="btn btn-secondary">Kembali</a>
    <a href="{{ route('layanan.edit', $layanan) }}" class="btn btn-warning">Edit</a>
  </div>
</div>

<div class="card mb-4">
  <div class="card-header bg-primary text-white">
    <h5 class="mb-0">{{ $layanan->jenis }}</h5>
  </div>
  <div class="card-body">
    <div class="row">
      <div class="col-md-8">
        <p><strong>ID Layanan:</strong> {{ $layanan->id }}</p>
        <p><strong>Jenis:</strong> <span class="badge bg-info">{{ $layanan->jenis }}</span></p>
        <p><strong>Judul:</strong> {{ $layanan->judul }}</p>
        <p><strong>Deskripsi:</strong> {{ $layanan->deskripsi ?? '-' }}</p>
        <p><strong>Status:</strong> 
          <span class="badge {{ $layanan->status === 'Selesai' ? 'bg-success' : ($layanan->status === 'Ditolak' ? 'bg-danger' : 'bg-warning') }}">
            {{ $layanan->status }}
          </span>
        </p>
      </div>
      <div class="col-md-4">
        <p><strong>Tanggal Pengajuan:</strong><br>{{ $layanan->created_at->format('d-m-Y H:i') }}</p>
        <p><strong>Dibuat oleh:</strong><br>{{ $layanan->createdBy->username ?? 'N/A' }}</p>
      </div>
    </div>
  </div>
</div>

{{-- Detail khusus per jenis --}}
@if($layanan->jenis === 'Surat Domisili' && $suratDomisili)
  <div class="card mb-4">
    <div class="card-header bg-success text-white">
      <h5 class="mb-0"><i class="fas fa-file-alt"></i> Detail Surat Domisili</h5>
    </div>
    <div class="card-body">
      <div class="row">
        <div class="col-md-6 mb-3">
          <p><strong>Nama Warga:</strong> {{ $suratDomisili->nama }}</p>
          <p><strong>NIK:</strong> {{ $suratDomisili->nik }}</p>
          <p><strong>Nomor Surat:</strong> {{ $suratDomisili->nomor_surat ?? '-' }}</p>
        </div>
        <div class="col-md-6 mb-3">
          <p><strong>Tanggal Pindah:</strong> {{ $suratDomisili->tanggal_pindah?->format('d-m-Y') ?? '-' }}</p>
          <p><strong>Tanggal Surat:</strong> {{ $suratDomisili->tanggal_surat?->format('d-m-Y') ?? '-' }}</p>
          <p><strong>Status Surat:</strong> {{ $suratDomisili->status }}</p>
        </div>
      </div>
      <hr>
      <p><strong>Alamat Lama:</strong></p>
      <div class="alert alert-light">{{ $suratDomisili->alamat_lama }}</div>
      
      <p><strong>Alamat Baru:</strong></p>
      <div class="alert alert-light">{{ $suratDomisili->alamat_baru }}</div>
      
      <p><strong>Alasan Pindah:</strong></p>
      <div class="alert alert-light">{{ $suratDomisili->alasan_pindah }}</div>
      
      @if($suratDomisili->catatan)
        <p><strong>Catatan:</strong></p>
        <div class="alert alert-light">{{ $suratDomisili->catatan }}</div>
      @endif
    </div>
  </div>
@elseif($layanan->jenis === 'Surat Domisili' && !$suratDomisili)
  <div class="alert alert-warning">
    <i class="fas fa-exclamation-triangle"></i> 
    Data Surat Domisili tidak ditemukan untuk layanan ini.
  </div>
@endif
<div class="mb-3">
  @can('view', $layanan)
    @if($layanan->jenis === 'Surat Domisili' && $suratDomisili)
      <a href="{{ route('layanan.cetak', $layanan) }}" class="btn btn-success" target="_blank">
        <i class="fas fa-print"></i> Cetak Surat (PDF)
      </a>
    @endif
  @endcan
</div>
@if($layanan->keterangan)
  <div class="card">
    <div class="card-header">Keterangan Tambahan</div>
    <div class="card-body">
      {{ $layanan->keterangan }}
    </div>
    
  </div>
@endif
@endsection