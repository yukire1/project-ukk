@extends('layouts.app')
@section('content')
<div class="d-flex justify-content-between mb-3">
  <h3>Detail Layanan</h3>
  <div>
    <a href="{{ route('layanan.index') }}" class="btn btn-secondary">Kembali</a>
    @can('update',$layanan)
      <a href="{{ route('layanan.edit',$layanan) }}" class="btn btn-warning">Edit</a>
    @endcan
  </div>
</div>

<div>
    @if($errors->any())
      <div class="alert alert-danger">
        <ul class="mb-0">
          @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>

    @endif
</div>

<div class="card mb-3">
  <div class="card-body">
    <h5 class="card-title">{{ $layanan->judul }}</h5>
    <p><strong>Jenis:</strong> {{ $layanan->jenis }}</p>
    <p><strong>Pemohon:</strong> {{ $layanan->penduduk->nama ?? '-' }}</p>
    <p><strong>Tanggal:</strong> {{ $layanan->tanggal_pengajuan }}</p>
    <p><strong>Status:</strong> {{ $layanan->status }}</p>
    <hr>
    <p>{{ $layanan->deskripsi }}</p>
  </div>
</div>

@if($layanan->tracking->isNotEmpty())
  <h5>Riwayat Status</h5>
  <ul class="list-group mb-3">
    @foreach($layanan->tracking as $t)
      <li class="list-group-item">
        <strong>{{ $t->status }}</strong> — {{ $t->keterangan }} <span class="text-muted">({{ $t->created_at }})</span>
      </li>
    @endforeach
  </ul>
@endif
@endsection