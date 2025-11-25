@extends('layouts.guest')

@section('content')
<div class="container">
  <div class="row justify-content-center mt-5">
    <div class="col-md-6">
      <div class="card shadow">
        <div class="card-body p-5">
          <h3 class="card-title text-center mb-4">Daftar Akun Baru</h3>

          <form method="POST" action="{{ route('register') }}">
            @csrf

            <!-- NIK -->
            <div class="mb-3">
              <label for="nik" class="form-label">NIK</label>
              <input id="nik" type="text" class="form-control @error('nik') is-invalid @enderror" name="nik" value="{{ old('nik') }}" required>
              @error('nik')
                <span class="invalid-feedback">{{ $message }}</span>
              @enderror
            </div>

            <!-- Nama -->
            <div class="mb-3">
              <label for="nama" class="form-label">Nama Lengkap</label>
              <input id="nama" type="text" class="form-control @error('nama') is-invalid @enderror" name="nama" value="{{ old('nama') }}" required>
              @error('nama')
                <span class="invalid-feedback">{{ $message }}</span>
              @enderror
            </div>

            <!-- Username (dari model User) -->
            <div class="mb-3">
              <label for="username" class="form-label">Username</label>
              <input id="username" type="text" class="form-control @error('username') is-invalid @enderror" name="username" value="{{ old('username') }}" required>
              @error('username')
                <span class="invalid-feedback">{{ $message }}</span>
              @enderror
            </div>

            <!-- Email -->
            <div class="mb-3">
              <label for="email" class="form-label">Email</label>
              <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required>
              @error('email')
                <span class="invalid-feedback">{{ $message }}</span>
              @enderror
            </div>

            <!-- Alamat -->
            <div class="mb-3">
              <label for="alamat" class="form-label">Alamat</label>
              <textarea id="alamat" class="form-control @error('alamat') is-invalid @enderror" name="alamat" rows="3">{{ old('alamat') }}</textarea>
              @error('alamat')
                <span class="invalid-feedback">{{ $message }}</span>
              @enderror
            </div>

            <!-- Tanggal Lahir -->
            <div class="mb-3">
              <label for="tanggal_lahir" class="form-label">Tanggal Lahir</label>
              <input id="tanggal_lahir" type="date" class="form-control @error('tanggal_lahir') is-invalid @enderror" name="tanggal_lahir" value="{{ old('tanggal_lahir') }}">
              @error('tanggal_lahir')
                <span class="invalid-feedback">{{ $message }}</span>
              @enderror
            </div>

            <!-- Jenis Kelamin -->
            <div class="mb-3">
              <label for="jenis_kelamin" class="form-label">Jenis Kelamin</label>
              <select id="jenis_kelamin" class="form-control @error('jenis_kelamin') is-invalid @enderror" name="jenis_kelamin">
                <option value="">-- Pilih --</option>
                <option value="L" {{ old('jenis_kelamin') == 'L' ? 'selected' : '' }}>Laki-laki</option>
                <option value="P" {{ old('jenis_kelamin') == 'P' ? 'selected' : '' }}>Perempuan</option>
              </select>
              @error('jenis_kelamin')
                <span class="invalid-feedback">{{ $message }}</span>
              @enderror
            </div>

            <!-- Password -->
            <div class="mb-3">
              <label for="password" class="form-label">Password</label>
              <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required>
              @error('password')
                <span class="invalid-feedback">{{ $message }}</span>
              @enderror
            </div>

            <!-- Konfirmasi Password -->
            <div class="mb-3">
              <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
              <input id="password_confirmation" type="password" class="form-control @error('password_confirmation') is-invalid @enderror" name="password_confirmation" required>
              @error('password_confirmation')
                <span class="invalid-feedback">{{ $message }}</span>
              @enderror
            </div>

            <button type="submit" class="btn btn-primary w-100 mb-3">Daftar</button>

            <p class="text-center">
              Sudah punya akun? <a href="{{ route('login') }}">Login di sini</a>
            </p>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection