@extends('layouts.guest')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-lg">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Verifikasi Kode Reset Password</h5>
                </div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="fas fa-check-circle"></i> {{ session('status') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <div class="alert alert-info">
                        <i class="fas fa-info-circle"></i>
                        <strong>Instruksi:</strong> Kami telah mengirimkan kode verifikasi 6 digit ke email <strong>{{ $email }}</strong>. 
                        Silahkan masukkan kode tersebut di bawah ini. Kode berlaku selama <strong>60 menit</strong>.
                    </div>

                    <form method="POST" action="{{ route('password.check-token') }}">
                        @csrf

                        <div class="row mb-3">
                            <label for="email" class="col-md-4 col-form-label text-md-end">Email</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" 
                                       name="email" value="{{ old('email', $email) }}" readonly>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="token" class="col-md-4 col-form-label text-md-end">Kode Verifikasi (6 Digit)</label>

                            <div class="col-md-6">
                                <input id="token" type="text" class="form-control @error('token') is-invalid @enderror" 
                                       name="token" placeholder="Contoh: 123456" maxlength="6" 
                                       required autofocus style="font-size: 1.5rem; letter-spacing: 0.5rem; text-align: center;">

                                @error('token')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-check"></i> Verifikasi Kode
                                </button>
                                <a href="{{ route('password.request') }}" class="btn btn-secondary ms-2">
                                    <i class="fas fa-arrow-left"></i> Minta Kode Baru
                                </a>
                            </div>
                        </div>
                    </form>

                    <hr>
                    <small class="text-muted">
                        <i class="fas fa-clock"></i> Jika kode sudah expired, silahkan klik "Minta Kode Baru" untuk mendapatkan kode baru.
                    </small>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection