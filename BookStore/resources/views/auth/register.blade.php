@extends('layouts.auth')

@section('title', 'Daftar Akun Baru')

@section('content')
    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-lg-6 col-md-8">

                <div class="card shadow-sm border-0">
                    <div class="card-body p-4 p-md-5">

                        <h2 class="text-center fw-bold mb-4">Buat Akun Baru</h2>
                        <p class="text-center text-muted mb-4">Bergabunglah dengan FlipBuku hari ini!</p>

                        <form method="POST" action="{{ route('register') }}">
                            @csrf

                            <div class="mb-3">
                                <label for="name" class="form-label fw-medium">{{ __('Nama Lengkap') }}</label>
                                {{-- REVISI: class 'form-control-lg' dihapus --}}
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror"
                                    name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="email" class="form-label fw-medium">{{ __('Alamat Email') }}</label>
                                {{-- REVISI: class 'form-control-lg' dihapus --}}
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                                    name="email" value="{{ old('email') }}" required autocomplete="email">

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="password" class="form-label fw-medium">{{ __('Password') }}</label>
                                {{-- REVISI: class 'form-control-lg' dihapus --}}
                                <input id="password" type="password"
                                    class="form-control @error('password') is-invalid @enderror" name="password" required
                                    autocomplete="new-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="password-confirm"
                                    class="form-label fw-medium">{{ __('Konfirmasi Password') }}</label>
                                {{-- REVISI: class 'form-control-lg' dihapus --}}
                                <input id="password-confirm" type="password" class="form-control"
                                    name="password_confirmation" required autocomplete="new-password">
                            </div>

                            <div class="d-grid mb-3">
                                <button type="submit" class="btn btn-primary btn-lg">
                                    {{ __('Daftar') }}
                                </button>
                            </div>

                            <p class="text-center text-muted mb-0">
                                Sudah punya akun? <a href="{{ route('login') }}"
                                    class="text-decoration-none fw-medium">Masuk di sini</a>
                            </p>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection