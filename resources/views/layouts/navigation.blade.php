<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <div class="container-fluid">
    <a class="navbar-brand" href="{{ url('/') }}">Sistem Desa</a>
    <div class="collapse navbar-collapse">
      <ul class="navbar-nav me-auto">
        @if('isAdmin')
          <li class="nav-item"><a class="nav-link" href="{{ route('penduduk.index') }}">Penduduk</a></li>
          {{-- <li class="nav-item"><a class="nav-link" href="{{ route('anggaran.index') }}">Anggaran</a></li>
          <li class="nav-item"><a class="nav-link" href="{{ route('kegiatan.index') }}">Kegiatan</a></li> --}}
        @endif
        
        @can('manageAll')
          <li class="nav-item"><a class="nav-link" href="{{ route('activity-logs.index') }}">Activity Logs</a></li>
        @endcan

        <li class="nav-item"><a class="nav-link" href="{{ route('layanan.index') }}">Layanan</a></li>
      </ul>
      

      <ul class="navbar-nav ms-auto">
        @guest
          <li class="nav-item"><a class="nav-link" href="{{ route('login') }}">Login</a></li>
          <li class="nav-item"><a class="nav-link" href="{{ route('register') }}">Register</a></li>
        @else
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">{{ auth()->user()->username }}</a>
            <ul class="dropdown-menu dropdown-menu-end">
              <li><a class="dropdown-item" href="{{ route('profile') }}">Profile</a></li>
              <li>
                <form method="POST" action="{{ route('logout') }}">
                  @csrf
                  <button class="dropdown-item">Logout</button>
                </form>
              </li>
            </ul>
          </li>
        @endguest
      </ul>
    </div>
  </div>
</nav>
