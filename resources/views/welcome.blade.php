<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Welcome · Project Desa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
      .hero {
        min-height: 60vh;
        background-size: cover;
        background-position: center;
        position: relative;
      }
      .hero .overlay { background: rgba(8, 46, 45, 0.55); position: absolute; inset: 0; }
      .hero .container { position: relative; z-index: 2; }
      .nav-highlight .nav-link { color: #ffffff !important; }
      .nav-highlight .nav-link:hover { color: #d6f35b !important; }
    </style>
  </head>
  @extends('layouts.app')
  @section('content')
  <body>
    <nav class="navbar navbar-expand-md navbar-dark bg-dark">
      <div class="container">
        <a class="navbar-brand" href="#">Project Desa</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse nav-highlight" id="mainNav">
          <ul class="navbar-nav mx-auto">
            <li class="nav-item"><a class="nav-link" href="#about">About us</a></li>
            <li class="nav-item"><a class="nav-link" href="#pricing">Pricing</a></li>
            <li class="nav-item"><a class="nav-link" href="#contact">Contact us</a></li>
            <li class="nav-item"><a class="nav-link" href="#blog">Blog</a></li>
          </ul>
          <div class="d-flex">
            <a class="btn btn-success me-2" href="/dashboard">Get in touch</a>
          </div>
        </div>
      </div>
    </nav>

    <header class="hero" style="background-image: url('{{ asset('images/desa.png') }}')">
      <div class="overlay"></div>
      <div class="container text-white text-center d-flex align-items-center" style="min-height:60vh">
        <div class="w-100">
          <h1 class="display-4 fw-bold">Selamat Datang di Project Desa</h1>
          <p class="lead mb-4">Solusi energi hijau dan pemberdayaan masyarakat desa.</p>
          <a class="btn btn-lg btn-light text-success" href="#about">Pelajari lebih lanjut</a>
        </div>
      </div>
    </header>

    <main class="py-5">
      <div class="container">
        <section id="about" class="mb-5">
          <div class="row align-items-center">
            <div class="col-md-6">
              <h2>About us</h2>
              <p>Kami mendukung penerapan energi terbarukan di desa-desa dengan teknologi dan pelatihan.</p>
            </div>
            <div class="col-md-6">
              <img src="{{ asset('landing/fauna-assets/about/about-image2.png') }}" class="img-fluid rounded" alt="">
            </div>
          </div>
        </section>

        <section id="pricing" class="mb-5">
          <h3 class="mb-3">Pricing</h3>
          <div class="row g-4">
            <div class="col-md-4">
              <div class="card shadow-sm">
                <div class="card-body">
                  <h5 class="card-title">Basic</h5>
                  <p class="card-text">Cocok untuk rumah tangga kecil.</p>
                  <a href="#" class="btn btn-outline-success">Choose</a>
                </div>
              </div>
            </div>
            <div class="col-md-4">
              <div class="card shadow-sm border-success">
                <div class="card-body">
                  <h5 class="card-title">Premium</h5>
                  <p class="card-text">Rencana yang direkomendasikan.</p>
                  <a href="#" class="btn btn-success">Choose</a>
                </div>
              </div>
            </div>
            <div class="col-md-4">
              <div class="card shadow-sm">
                <div class="card-body">
                  <h5 class="card-title">Enterprise</h5>
                  <p class="card-text">Solusi untuk perusahaan besar.</p>
                  <a href="#" class="btn btn-outline-success">Contact us</a>
                </div>
              </div>
            </div>
          </div>
        </section>

        <section id="contact" class="mb-5">
          <h3>Contact</h3>
          <form class="row g-3">
            <div class="col-md-6"><input class="form-control" placeholder="Name"></div>
            <div class="col-md-6"><input class="form-control" placeholder="Email"></div>
            <div class="col-12"><textarea class="form-control" rows="4" placeholder="Message"></textarea></div>
            <div class="col-12"><button class="btn btn-success">Send</button></div>
          </form>
        </section>
      </div>
    </main>

    <footer class="bg-dark text-white py-4">
      <div class="container text-center small">© {{ date('Y') }} Project Desa</div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  </body>
</html>
@endsection