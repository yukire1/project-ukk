@extends('layouts.app')
@section('content')
<div class="d-flex justify-content-between mb-3">
  <h3>Ajukan Layanan</h3>
  <a href="{{ route('layanan.index') }}" class="btn btn-secondary">Kembali</a>
</div>

@if($errors->any())
  <div class="alert alert-danger">
    <ul class="mb-0">
      @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
      @endforeach
    </ul>
  </div>
@endif

<form action="{{ route('layanan.store') }}" method="POST" class="card p-4">
  @csrf

  <div class="mb-3">
    <label class="form-label fw-bold">Jenis Layanan</label>
    <select name="jenis" id="jenis" class="form-select form-select-lg" required>
      <option value="">-- Pilih Jenis Layanan --</option>
      <option value="Surat Domisili" {{ old('jenis')=='Surat Domisili' ? 'selected' : '' }}>Surat Domisili</option>
      <option value="Surat Layanan Umum" {{ old('jenis')=='Surat Layanan Umum' ? 'selected' : '' }}>Surat Layanan Umum</option>
      <option value="Berkas Kependudukan" {{ old('jenis')=='Berkas Kependudukan' ? 'selected' : '' }}>Berkas Kependudukan</option>
      <option value="Pengaduan" {{ old('jenis')=='Pengaduan' ? 'selected' : '' }}>Pengaduan</option>
    </select>
  </div>

  <div class="mb-3">
    <label class="form-label fw-bold">Judul</label>
    <input type="text" name="judul" value="{{ old('judul') }}" class="form-control" required>
  </div>

  <div class="mb-3">
    <label class="form-label">Deskripsi</label>
    <textarea name="deskripsi" class="form-control" rows="3">{{ old('deskripsi') }}</textarea>
  </div>

  <div class="mb-3">
    <label class="form-label">Keterangan Tambahan</label>
    <textarea name="keterangan" class="form-control" rows="2">{{ old('keterangan') }}</textarea>
  </div>

  <hr class="my-4">

  <!-- SURAT DOMISILI FORM -->
  <div id="section-surat-domisili" class="dynamic-section d-none">
    <h5 class="mb-3"><i class="fas fa-file-alt"></i> Form Surat Domisili</h5>
    
    <div class="mb-3">
      <label class="form-label fw-bold">Pilih Warga</label>
      <select name="penduduk_id" id="penduduk_id" class="form-select" required>
        <option value="">-- Pilih Warga --</option>
        @foreach($penduduks as $p)
          <option value="{{ $p->id }}" data-nik="{{ $p->nik }}" data-nama="{{ $p->nama }}" data-alamat="{{ $p->alamat }}"
            {{ old('penduduk_id') == $p->id ? 'selected' : '' }}>
            {{ $p->nama }} ({{ $p->nik }})
          </option>
        @endforeach
      </select>
      @error('penduduk_id')
        <small class="text-danger">{{ $message }}</small>
      @enderror
    </div>

    <div class="row">
      <div class="col-md-6 mb-3">
        <label class="form-label fw-bold">NIK</label>
        <input type="text" class="form-control" id="nik" name="nik" value="{{ old('nik') }}" readonly>
        @error('nik')
          <small class="text-danger">{{ $message }}</small>
        @enderror
      </div>
      <div class="col-md-6 mb-3">
        <label class="form-label fw-bold">Nama</label>
        <input type="text" class="form-control" id="nama" name="nama" value="{{ old('nama') }}" readonly>
        @error('nama')
          <small class="text-danger">{{ $message }}</small>
        @enderror
      </div>
    </div>

    <div class="mb-3">
      <label class="form-label fw-bold">Alamat Lama (Asal)</label>
      <textarea name="alamat_lama" id="alamat_lama" class="form-control" rows="3" required>{{ old('alamat_lama') }}</textarea>
      @error('alamat_lama')
        <small class="text-danger">{{ $message }}</small>
      @enderror
    </div>

    <div class="mb-3">
      <label class="form-label fw-bold">Alamat Baru (Tujuan)</label>
      <textarea name="alamat_baru" class="form-control" rows="3" required>{{ old('alamat_baru') }}</textarea>
      @error('alamat_baru')
        <small class="text-danger">{{ $message }}</small>
      @enderror
    </div>

    <div class="mb-3">
      <label class="form-label fw-bold">Alasan Pindah</label>
      <select name="alasan_pindah" class="form-select" required>
        <option value="">-- Pilih Alasan --</option>
        <option value="Pekerjaan" {{ old('alasan_pindah')=='Pekerjaan' ? 'selected' : '' }}>Pekerjaan</option>
        <option value="Pendidikan" {{ old('alasan_pindah')=='Pendidikan' ? 'selected' : '' }}>Pendidikan</option>
        <option value="Keluarga" {{ old('alasan_pindah')=='Keluarga' ? 'selected' : '' }}>Keluarga</option>
        <option value="Kesehatan" {{ old('alasan_pindah')=='Kesehatan' ? 'selected' : '' }}>Kesehatan</option>
        <option value="Usaha" {{ old('alasan_pindah')=='Usaha' ? 'selected' : '' }}>Usaha</option>
        <option value="Lainnya" {{ old('alasan_pindah')=='Lainnya' ? 'selected' : '' }}>Lainnya</option>
      </select>
      @error('alasan_pindah')
        <small class="text-danger">{{ $message }}</small>
      @enderror
    </div>

    <div class="row">
      <div class="col-md-6 mb-3">
        <label class="form-label">Tanggal Pindah</label>
        <input type="date" class="form-control" name="tanggal_pindah" value="{{ old('tanggal_pindah') }}">
        @error('tanggal_pindah')
          <small class="text-danger">{{ $message }}</small>
        @enderror
      </div>
      <div class="col-md-6 mb-3">
        <label class="form-label">Tanggal Surat</label>
        <input type="date" class="form-control" name="tanggal_surat" value="{{ old('tanggal_surat', date('Y-m-d')) }}">
        @error('tanggal_surat')
          <small class="text-danger">{{ $message }}</small>
        @enderror
      </div>
    </div>

    <div class="mb-3">
      <label class="form-label">Catatan Tambahan</label>
      <textarea name="catatan" class="form-control" rows="2">{{ old('catatan') }}</textarea>
    </div>
  </div>

  <!-- FORM LAINNYA (PLACEHOLDER) -->
  <div id="section-lainnya" class="dynamic-section d-none">
    <p class="text-muted">Silahkan isi form di atas. Form khusus akan ditampilkan berdasarkan jenis layanan yang Anda pilih.</p>
  </div>

  <button type="submit" class="btn btn-primary btn-lg mt-4">
    <i class="fas fa-paper-plane"></i> Ajukan Layanan
  </button>
</form>

<style>
  .dynamic-section {
    background: #f8f9fa;
    padding: 1.5rem;
    border-radius: 8px;
    border-left: 4px solid #0b3f36;
  }
</style>

<script>
document.addEventListener('DOMContentLoaded', function () {
  const jenisSelect = document.getElementById('jenis');
  const pendudukSelect = document.getElementById('penduduk_id');
  const nikInput = document.getElementById('nik');
  const namaInput = document.getElementById('nama');
  const alamatLamaInput = document.getElementById('alamat_lama');

  function showSection(jenisValue) {
    document.querySelectorAll('.dynamic-section').forEach(s => s.classList.add('d-none'));
    
    if (jenisValue === 'Surat Domisili') {
      document.getElementById('section-surat-domisili').classList.remove('d-none');
    } else {
      document.getElementById('section-lainnya').classList.remove('d-none');
    }
  }

  // Auto-fill penduduk data
  pendudukSelect.addEventListener('change', function () {
    const option = this.options[this.selectedIndex];
    nikInput.value = option.dataset.nik || '';
    namaInput.value = option.dataset.nama || '';
    alamatLamaInput.value = option.dataset.alamat || '';
  });

  // Show section on page load
  if (jenisSelect.value) {
    showSection(jenisSelect.value);
  }

  // Show section on change
  jenisSelect.addEventListener('change', function () {
    showSection(this.value);
  });

  // Show section on click
  jenisSelect.addEventListener('click', function () {
    showSection(this.value);
  });
});
</script>
@endsection