<!doctype html>
<html lang="en">
<head>
  @extends('layouts.app')
  @section('content')
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Welcome · Project Desa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
      body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
      
      .hero {
        min-height: 70vh;
        background: linear-gradient(135deg, #0b2f2e 0%, #1a5f5d 100%);
        position: relative;
        overflow: hidden;
      }

      .hero::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -10%;
        width: 500px;
        height: 500px;
        background: rgba(214, 243, 91, 0.1);
        border-radius: 50%;
        animation: float 6s ease-in-out infinite;
      }

      @keyframes float {
        0%, 100% { transform: translateY(0px); }
        50% { transform: translateY(20px); }
      }

      .hero .container { position: relative; z-index: 2; }
      
      .hero h1 {
        font-size: 3.5rem;
        font-weight: 800;
        color: #ffffff;
        margin-bottom: 1rem;
        text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
      }

      .hero p {
        font-size: 1.25rem;
        color: #d6f35b;
        margin-bottom: 2rem;
      }

      .hero .btn-group-hero {
        display: flex;
        gap: 1rem;
        flex-wrap: wrap;
      }

      .btn-primary-custom {
        background-color: #d6f35b;
        color: #0b2f2e;
        border: none;
        padding: 0.75rem 2rem;
        font-weight: 600;
        border-radius: 50px;
        transition: all 0.3s ease;
      }

      .btn-primary-custom:hover {
        background-color: #ffffff;
        transform: translateY(-2px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.2);
      }

      .btn-secondary-custom {
        background-color: transparent;
        color: #ffffff;
        border: 2px solid #d6f35b;
        padding: 0.75rem 2rem;
        font-weight: 600;
        border-radius: 50px;
        transition: all 0.3s ease;
      }

      .btn-secondary-custom:hover {
        background-color: #d6f35b;
        color: #0b2f2e;
        transform: translateY(-2px);
      }

      .navbar-brand {
        font-size: 1.5rem;
        font-weight: 700;
        color: #d6f35b !important;
      }

      .nav-highlight .nav-link {
        color: #ffffff !important;
        transition: all 0.3s ease;
        margin: 0 0.5rem;
      }

      .nav-highlight .nav-link:hover {
        color: #d6f35b !important;
        border-bottom: 2px solid #d6f35b;
      }

      .info-section {
        background-color: #f8f9fa;
        padding: 4rem 0;
      }

      .info-card {
        background: white;
        padding: 2rem;
        border-radius: 10px;
        box-shadow: 0 5px 15px rgba(0,0,0,0.08);
        border-left: 4px solid #d6f35b;
        transition: all 0.3s ease;
      }

      .info-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(0,0,0,0.15);
      }

      .gallery-section {
        background: linear-gradient(135deg, #0b2f2e 0%, #1a5f5d 100%);
        padding: 4rem 0;
        color: white;
      }

      .gallery-title {
        font-size: 2.5rem;
        font-weight: 800;
        margin-bottom: 3rem;
        text-align: center;
      }

      .gallery-placeholder {
        background: linear-gradient(135deg, #2a7f7d 0%, #1a5f5d 100%);
        border-radius: 10px;
        aspect-ratio: 1 / 1;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 3rem;
        color: #d6f35b;
        cursor: pointer;
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
      }

      .gallery-placeholder::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: rgba(214, 243, 91, 0.1);
        transition: left 0.3s ease;
      }

      .gallery-placeholder:hover {
        transform: scale(1.05);
        box-shadow: 0 15px 35px rgba(214, 243, 91, 0.2);
      }

      .gallery-placeholder:hover::before {
        left: 100%;
      }

      .gallery-label {
        text-align: center;
        margin-top: 1rem;
        font-size: 0.95rem;
        color: #d6f35b;
      }

      .content-box {
        background: white;
        padding: 2rem;
        border-radius: 10px;
        box-shadow: 0 5px 15px rgba(0,0,0,0.08);
      }

      .content-box h3 {
        color: #0b2f2e;
        font-weight: 700;
        margin-bottom: 1rem;
      }

      .content-box p {
        color: #555;
        line-height: 1.8;
        margin-bottom: 0.8rem;
      }

      .content-box ul {
        list-style: none;
        padding: 0;
      }

      .content-box li {
        padding-left: 1.5rem;
        margin-bottom: 0.5rem;
        position: relative;
      }

      .content-box li::before {
        content: '✓';
        position: absolute;
        left: 0;
        color: #d6f35b;
        font-weight: bold;
      }

      footer {
        background: #0b2f2e;
        color: #d6f35b;
      }

      footer a {
        color: #d6f35b;
        text-decoration: none;
      }

      footer a:hover {
        color: #ffffff;
      }
    </style>
</head>
<body>
  
    <!-- Navbar -->
    <nav class="navbar navbar-expand-md navbar-dark bg-dark sticky-top">
      <div class="container">
        <a class="navbar-brand">
          <i class="fas fa-map-location-dot"></i> Project Desa mojorangagung
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse nav-highlight" id="mainNav">
          <ul class="navbar-nav ms-auto">
            <li class="nav-item"><a class="nav-link" href="#tentang">Tentang mojorangagung</a></li>
            <li class="nav-item"><a class="nav-link" href="#galeri">berita</a></li>
            <li class="nav-item"><a class="nav-link" href="#kontak">tawaran</a></li>
          </ul>
          <div class="d-flex ms-3">
            @auth
              <a class="btn btn-primary-custom" href="/dashboard">Dashboard</a>
            @else
              <a class="btn btn-primary-custom me-2" href="/login">Login</a>
              <a class="btn btn-secondary-custom" href="/register">Register</a>
            @endauth
          </div>
        </div>
      </div>
    </nav>

    <!-- Hero Section -->
    <header class="hero d-flex align-items-center">
      <div class="container text-center">
        <h1>Selamat Datang di mojorangagung</h1>
        <p>Kabupaten Progresif dengan Inovasi Berkelanjutan</p>
        <div class="btn-group-hero justify-content-center">
          <a class="btn btn-primary-custom" href="/login">Mulai Sekarang</a>
          <a class="btn btn-secondary-custom" href="#tentang">Pelajari Lebih Lanjut</a>
        </div>
      </div>
    </header>

    <!-- Main Content -->
    <main>
      <!-- Tentang mojorangagung -->
      <section id="tentang" class="info-section">
        <div class="container">
          <h2 class="mb-4" style="font-size: 2.5rem; font-weight: 800; color: #0b2f2e;">Tentang Kabupaten mojorangagung</h2>
          
          <div class="row g-4 align-items-center">
            <div class="col-md-6">
              <div class="content-box">
                <h3><i class="fas fa-info-circle"></i> Profil Singkat</h3>
                <p>
                  Desa Mojorangagung adalah sebuah desa di Kecamatan Wonoayu, Kabupaten Sidoarjo, Jawa Timur, dengan kode pos 61261. Desa ini merupakan bagian dari 18 kecamatan yang ada di Kabupaten Sidoarjo. 
Lokasi: Berada di Kecamatan Wonoayu, Kabupaten Sidoarjo.
<strong>Kode Pos: 61261.</strong>
Secara administratif: Merupakan bagian dari Provinsi Jawa Timur dan Kabupaten Sidoarjo. 
                </p>
              </div>
            </div>

            <div class="col-md-6">
              <div class="content-box">
                <h3><i class="fas fa-star"></i> Perkembangan Terkini</h3>
                <ul>
                  <li>Pembangunan proyek perumahan orchid</li>
                  <li>Perluasan sawah di daerah dekat sungait</li>
                  <li>Pembangunan langgar di dekat gang sawah untuk jarak</li>
                  <li>Program digitalisasi layanan pemerintah</li>
                </ul>
              </div>
            </div>
          </div>

          <div class="row g-4 mt-3">
            <div class="col-md-6">
              <div class="content-box">
                <h3><i class="fas fa-landmark"></i> Warisan Budaya</h3>
                <p>
                  mojorangagung memiliki objek budaya berupa,<strong>pengajian rutin</strong> dan <strong>tradisi lokal</strong> yang masih dilestarikan oleh masyarakat setempat.
                </p>
                <p class="mb-0">
                  
                </p>
              </div>
            </div>

            <div class="col-md-6">
              <div class="content-box">
                <h3><i class="fas fa-handshake"></i> Visi & Misi Kami</h3>
                <p>
                  Platform Project Desa hadir untuk mendukung digitalisasi layanan desa dan meningkatkan kualitas hidup masyarakat melalui:
                </p>
                <ul>
                  <li>Transparansi pemerintahan yang lebih baik</li>
                  <li>Layanan publik yang lebih mudah diakses</li>
                  <li>Pemberdayaan ekonomi lokal</li>
                  <li>Keterlibatan masyarakat yang lebih aktif</li>
                </ul>
              </div>
            </div>
          </div>
        </div>
      </section>

      <!-- Galeri Section -->
     <section id="galeri" class="gallery-section">
        <div class="container">
          <h2 class="gallery-title">berita</h2>
          
          <div class="row g-4">
            <!-- Slot 1 -->
            <div class="col-md-4">
              <div class="text-center">
                <img src="{{ asset('images/desa.png') }}" alt="Infrastruktur mojorangagung" style="width: 100%; height: 100%; object-fit: cover; border-radius: 10px;">
              </div>
              <div class="gallery-label">tempat balai desa untuk mengajukan laporan dll</div>
            </div>

            <!-- Slot 2 (Tengah) -->
            <div class="col-md-4">
              <div class="text-center">
                <img src="{{ asset('images/images.jpg') }}" alt="Wisata & Budaya" style="width: 100%; height: 100%; object-fit: cover; border-radius: 10px;">
              </div>
              <div class="gallery-label">pergi ke warung alas kuto</div>
            </div>

            <!-- Slot 3 -->
            <div class="col-md-4">
              <div class="text-center">
                <img src="{{ asset('images/tes.jpg') }}" alt="Perekonomian Lokal" style="width: 100%; height: 100%; object-fit: cover; border-radius: 10px;">
              </div>
              <div class="gallery-label">rapat bersama dengan bupati sidoarjo</div>
            </div>
          </div>
        </div>
      </section>

      <!-- CTA Section -->
      <section id="kontak" class="py-5" style="background-color: #f8f9fa;">
        <div class="container text-center">
          <h3 style="font-size: 2rem; font-weight: 800; color: #0b2f2e; margin-bottom: 2rem;">
            Bergabunglah dengan Platform  Desa mojo
          </h3>
          <p style="font-size: 1.1rem; color: #555; margin-bottom: 2rem; max-width: 600px; margin-left: auto; margin-right: auto;">
            Akses layanan desa digital, ikuti kegiatan masyarakat, dan bersama membangun mojorangagung yang lebih maju.
          </p>
          <div class="d-flex gap-2 justify-content-center flex-wrap">
            @auth
              <a class="btn btn-primary-custom" href="/dashboard">Ke Dashboard</a>
            @else
              <a class="btn btn-primary-custom" href="/register">Daftar Sekarang</a>
              <a class="btn btn-secondary-custom" href="/login">Login</a>
            @endauth
          </div>
        </div>
          </div>
        </div>
      </section>
    </main>

    <!-- Footer -->
    <footer class="py-4">
      <div class="container">
        <div class="row">
          <div class="col-md-4 mb-3">
            <h6 style="color: #ffffff;">Project Desa mojorangagung</h6>
            <p>Platform digitalisasi layanan desa untuk masyarakat mojorangagung.</p>
          </div>
          <div class="col-md-4 mb-3">
            <h6 style="color: #ffffff;">Navigasi</h6>
            <ul style="list-style: none; padding: 0;">
              <li><a href="{{ route('layanan.index') }}">layanan mojorangagung</a></li>
              <li><a href="#galeri">berita</a></li>
              @if(auth()->check() && (
            (method_exists(auth()->user(),'hasRole') && auth()->user()->hasRole('admin')) ||
            (isset(auth()->user()->role) && auth()->user()->role === 'admin')
        ))
              <li><a href="{{ route('penduduk.index') }}">daftar penduduk</a></li>
              @endif
            </ul>
          </div>
          <div class="col-md-4 mb-3">
            <h6 style="color: #ffffff;">Kontak</h6>
            <p>
              <i class="fas fa-phone"></i> +62-31-XXXX-XXXX<br>
              <i class="fas fa-envelope"></i> info@mojorangagung.id<br>
              <i class="fas fa-map-location-dot"></i> mojorangagung, Jawa Timur
            </p>
          </div>
        </div>
        <hr style="border-color: rgba(214, 243, 91, 0.2);">
        <div class="text-center small">
          © {{ date('Y') }} Project Desa mojorangagung. All rights reserved.
        </div>
      </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
      // Simple gallery placeholder interactivity
      document.querySelectorAll('.gallery-placeholder').forEach((el, index) => {
        el.addEventListener('click', function() {
          alert(`Slot ${index + 1} - Klik untuk menambahkan gambar`);
        });
      });
    </script>
</body>
</html>
@endsection