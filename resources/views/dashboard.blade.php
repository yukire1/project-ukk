<!doctype html>
<html lang="en">
  @extends('layouts.app')
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Dashboard · Project Desa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
      body { min-height: 100vh; }
      .sidebar { min-height: 100vh; }
      .active-link { background: #d6f35b; color: #0b3f36 !important; }
    </style>
  </head>
  @section('content')
  <body>
    <nav class="navbar navbar-dark bg-dark sticky-top">
      <div class="container-fluid">
        <button class="btn btn-outline-light d-md-none" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasSidebar">Menu</button>
        <a class="navbar-brand ms-2" href="#">Project Desa</a>
        <div class="d-flex">
          <span class="navbar-text text-white me-3">Admin</span>
          <a class="btn btn-outline-light" href="{{ url('/') }}">View site</a>
        </div>
      </div>
    </nav>

    <div class="container-fluid">
      <div class="row">
        <nav class="col-md-3 col-lg-2 d-none d-md-block bg-light sidebar p-3">
          <div class="position-sticky">
            <ul class="nav flex-column">
              <li class="nav-item"><a class="nav-link active-link rounded mb-1" href="#">Overview</a></li>
              <li class="nav-item"><a class="nav-link" href="#">Users</a></li>
              <li class="nav-item"><a class="nav-link" href="#">Services</a></li>
              <li class="nav-item"><a class="nav-link" href="#">Reports</a></li>
            </ul>
          </div>
        </nav>

        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 py-4">
          <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h2">Dashboard</h1>
            <div>
              <button class="btn btn-outline-secondary">Settings</button>
            </div>
          </div>

          <div class="row g-4 mb-4">
            <div class="col-sm-6 col-lg-3">
              <div class="card shadow-sm">
                <div class="card-body">
                  <h6 class="card-title">Users</h6>
                  <p class="display-6 mb-0">1,234</p>
                </div>
              </div>
            </div>
            <div class="col-sm-6 col-lg-3">
              <div class="card shadow-sm">
                <div class="card-body">
                  <h6 class="card-title">Active Services</h6>
                  <p class="display-6 mb-0">24</p>
                </div>
              </div>
            </div>
            <div class="col-sm-6 col-lg-3">
              <div class="card shadow-sm">
                <div class="card-body">
                  <h6 class="card-title">Revenue</h6>
                  <p class="display-6 mb-0">$12k</p>
                </div>
              </div>
            </div>
            <div class="col-sm-6 col-lg-3">
              <div class="card shadow-sm">
                <div class="card-body">
                  <h6 class="card-title">Tickets</h6>
                  <p class="display-6 mb-0">7</p>
                </div>
              </div>
            </div>
          </div>

          <div class="card mb-4">
            <div class="card-body">
              <h5 class="card-title">Recent activity</h5>
              <div class="list-group list-group-flush">
                <div class="list-group-item">User A created a service <span class="text-muted small">2h ago</span></div>
                <div class="list-group-item">Payment received <span class="text-muted small">5h ago</span></div>
                <div class="list-group-item">New signups <span class="text-muted small">1d ago</span></div>
              </div>
            </div>
          </div>

        </main>
      </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  </body>
</html>
@endsection