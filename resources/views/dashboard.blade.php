@extends('layouts.app')
@section('content')
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Dashboard · Project Desa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
      body { min-height: 100vh; }
      .sidebar { min-height: 100vh; }
      .active-link { background: #d6f35b; color: #0b3f36 !important; }
      .stat-card { border-left: 4px solid #0b3f36; }
      .visi-misi-section { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; }
    </style>
</head>
<body>
    <div class="container-fluid">
      <main class="px-md-4 py-4">
        
        <!-- Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
          <h1 class="h2">Dashboard Desa</h1>
          <div>
            <span class="text-muted">Selamat datang, {{ auth()->user()->username }}</span>
          </div>
        </div>

        <!-- Statistik Utama -->
        <div class="row g-4 mb-5">
          <div class="col-sm-6 col-lg-3">
            <div class="card shadow-sm stat-card">
              <div class="card-body">
                <h6 class="card-title text-muted">Total Warga</h6>
                <p class="display-5 mb-0 fw-bold">{{ $totalWarga }}</p>
                <small class="text-muted">Penduduk terdaftar</small>
              </div>
            </div>
          </div>

          <div class="col-sm-6 col-lg-3">
            <div class="card shadow-sm stat-card">
              <div class="card-body">
                <h6 class="card-title text-muted">Request Layanan</h6>
                <p class="display-5 mb-0 fw-bold">{{ $totalLayanan }}</p>
                <small class="text-muted">Permintaan masuk</small>
              </div>
            </div>
          </div>

          <div class="col-sm-6 col-lg-3">
            <div class="card shadow-sm stat-card">
              <div class="card-body">
                <h6 class="card-title text-muted">Layanan Selesai</h6>
                <p class="display-5 mb-0 fw-bold">{{ $layananSelesai }}</p>
                <small class="text-muted">Status Selesai</small>
              </div>
            </div>
          </div>

          {{-- <div class="col-sm-6 col-lg-3">
            <div class="card shadow-sm stat-card">
              <div class="card-body">
                <h6 class="card-title text-muted">Kegiatan Aktif</h6>
                <p class="display-5 mb-0 fw-bold">{{ $kegiatanAktif }}</p>
                <small class="text-muted">Program berjalan</small>
              </div>
            </div>
          </div> --}}
        </div>

        <!-- Visi Misi -->
        <div class="visi-misi-section rounded p-5 mb-5">
          <div class="row">
            <div class="col-md-6 mb-4">
              <h3 class="fw-bold mb-3">VISI</h3>
              <p class="lead">
                Terwujudnya desa mojorangagung yang Sejahtera, Maju, Berkarakter dan Berkelanjutan
              </p>
            </div>

            <div class="col-md-6">
              <h3 class="fw-bold mb-3">MISI</h3>
              <ol class="ps-3">
                <li class="mb-2">
                  Mewujudkan tata kelola pemerintahan yang bersih, transparan dan tangkas melalui digitalisasi untuk meningkatkan kualitas pelayanan publik dan kemudahan berusaha.
                </li>
                <li class="mb-2">
                  Membangkitkan pertumbuhan ekonomi dengan fokus pada kemandirian lokal berbasis usaha mikro, koperasi, pertanian, perikanan, sektor jasa dan industri untuk membuka lapangan pekerjaan dan mengurangi kemiskinan.
                </li>
                <li class="mb-2">
                  Membangun infrastruktur ekonomi dan sosial yang modern dan berkeadilan dengan memperhatikan keberlanjutan lingkungan.
                </li>
                <li class="mb-2">
                  Membangun SDM unggul dan berkarakter melalui peningkatan akses pelayanan bidang pendidikan, kesehatan serta kebutuhan dasar lainnya.
                </li>
                <li class="mb-2">
                  Mewujudkan masyarakat religius yang berpegang teguh pada nilai – nilai keagamaan serta mampu menjaga kerukunan sosial antar warga.
                </li>
              </ol>
            </div>
          </div>
        </div>

        <!-- Status Layanan -->
        <div class="card mb-4">
          <div class="card-header bg-primary text-white">
            <h5 class="mb-0">Status Layanan</h5>
          </div>
          <div class="card-body">
            <div class="row text-center">
              <div class="col-md-3 mb-3">
                <h6 class="text-muted">Menunggu</h6>
                <p class="display-6 fw-bold text-warning">{{ $layananMenunggu }}</p>
              </div>
              <div class="col-md-3 mb-3">
                <h6 class="text-muted">Diproses</h6>
                <p class="display-6 fw-bold text-info">{{ $layananDiproses }}</p>
              </div>
              <div class="col-md-3 mb-3">
                <h6 class="text-muted">Diverifikasi</h6>
                <p class="display-6 fw-bold text-primary">{{ $layananDiverifikasi }}</p>
              </div>
              <div class="col-md-3 mb-3">
                <h6 class="text-muted">Ditolak</h6>
                <p class="display-6 fw-bold text-danger">{{ $layananDitolak }}</p>
              </div>
            </div>
          </div>
        </div>

        <!-- Statistik Gender Warga -->
        <div class="row g-4">
          <div class="col-md-6">
            <div class="card">
              <div class="card-header bg-secondary text-white">
                <h5 class="mb-0">Statistik Gender Warga</h5>
              </div>
              <div class="card-body text-center">
                <div class="row">
                  <div class="col-6 mb-3">
                    <h6 class="text-muted">Laki-laki</h6>
                    <p class="display-5 fw-bold text-primary">{{ $wariaLaki }}</p>
                  </div>
                  <div class="col-6 mb-3">
                    <h6 class="text-muted">Perempuan</h6>
                    <p class="display-5 fw-bold text-danger">{{ $wariaPerempuan }}</p>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="col-md-6">
            <div class="card">
              <div class="card-header bg-info text-white">
                <h5 class="mb-0">Informasi Kontak</h5>
              </div>
              <div class="card-body">
                <p><strong>Kantor Desa:</strong> Jl. Utama Desa No. 1</p>
                <p><strong>Telepon:</strong> +62-31-XXXX-XXXX</p>
                <p><strong>Email:</strong> admin@desamojorangagung.id</p>
                <p><strong>Website:</strong> www.desamojorangagung.id</p>
              </div>
              <a class="btn btn-primary-custom" href="/">kembali</a>

            </div>
          </div>
        </div>

      </main>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  </body>
</html>
@endsection