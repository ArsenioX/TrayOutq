@extends('layouts.auth')

@section('title', 'Masuk ke FlipBuku')

@section('content')
    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-lg-5 col-md-7">

                <div class="card shadow-sm border-0">
                    <div class="card-body p-4 p-md-5">

                        <h2 class="text-center fw-bold mb-4">Selamat Datang Kembali</h2>
                        <p class="text-center text-muted mb-4">Silakan masuk ke akun Anda.</p>

                        <form method="POST" action="{{ route('login') }}">
                            @csrf

                            <div class="mb-3">
                                <label for="email" class="form-label fw-medium">{{ __('Alamat Email') }}</label>
                                {{-- REVISI: class 'form-control-lg' dihapus --}}
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                                    name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

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
                                    autocomplete="current-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                    <label class="form-check-label" for="remember">
                                        {{ __('Ingat Saya') }}
                                    </label>
                                </div>

                                @if (Route::has('password.request'))
                                    <a class="btn btn-link btn-sm text-decoration-none" href="{{ route('password.request') }}">
                                        {{ __('Lupa Password?') }}
                                    </a>
                                @endif
                            </div>

                            <div class="d-grid mb-3">
                                {{-- Tombol Login tetap besar agar mudah diklik --}}
                                <button type="submit" class="btn btn-primary btn-lg">
                                    {{ __('Login') }}
                                </button>
                            </div>

                            <p class="text-center text-muted mb-0">
                                Belum punya akun? <a href="{{ route('register') }}"
                                    class="text-decoration-none fw-medium">Daftar di sini</a>
                            </p>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection