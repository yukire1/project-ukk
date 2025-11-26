@extends('layouts.app')
@section('content')
<div class="d-flex justify-content-between mb-3">
  <h3>Detail Anggaran</h3>
  <div>
    <a href="{{ route('anggaran.index') }}" class="btn btn-secondary">Kembali</a>
    <a href="{{ route('anggaran.edit', $anggaran) }}" class="btn btn-warning">Edit</a>
  </div>
</div>

<div class="card">
  <div class="card-body">
    <h5 class="card-title">Anggaran Tahun {{ $anggaran->tahun }}</h5>
    <hr>
    <div class="row">
      <div class="col-md-6">
        <p><strong>Tahun:</strong> {{ $anggaran->tahun }}</p>
        <p><strong>Sumber Dana:</strong> {{ $anggaran->sumber_dana }}</p>
        <p><strong>Jumlah:</strong> Rp {{ number_format($anggaran->jumlah, 0, ',', '.') }}</p>
      </div>
      <div class="col-md-6">
        <p><strong>Dibuat Oleh:</strong> {{ $anggaran->createdBy->username ?? '-' }}</p>
        <p><strong>Tanggal Dibuat:</strong> {{ \Carbon\Carbon::parse($anggaran->created_at)->format('d-m-Y H:i') }}</p>
        <p><strong>Terakhir Diperbarui:</strong> {{ \Carbon\Carbon::parse($anggaran->updated_at)->format('d-m-Y H:i') }}</p>
      </div>
    </div>
    <hr>
    <p><strong>Keterangan:</strong></p>
    <p>{{ $anggaran->keterangan ?? '-' }}</p>
  </div>
</div>
@endsection