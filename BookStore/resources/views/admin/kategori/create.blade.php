@extends('layouts.admin')

@section('content')
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-8">

                <div class="card shadow-lg rounded-lg border-0">
                    <div class="card-header bg-dark text-white">
                        {{-- DITERJEMAHKAN --}}
                        <h4 class="mb-0">{{ __('Tambah Kategori Buku') }}</h4>
                    </div>

                    <div class="card-body bg-light">
                        <form action="{{ route('admin.kategori.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            {{-- Nama Kategori --}}
                            <div class="mb-3">
                                {{-- DITERJEMAHKAN (Kunci sudah ada) --}}
                                <label for="nama" class="form-label">{{ __('Nama Kategori') }}</label>
                                <input type="text" name="nama" id="nama"
                                    class="form-control shadow-sm @error('nama') is-invalid @enderror" {{-- DITERJEMAHKAN
                                    --}} placeholder="{{ __('Masukkan nama kategori') }}" required>
                                @error('nama')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            {{-- Deskripsi Kategori --}}
                            <div class="mb-3">
                                {{-- DITERJEMAHKAN (Kunci sudah ada) --}}
                                <label for="deskripsi" class="form-label">{{ __('Deskripsi') }}</label>
                                <textarea name="deskripsi" id="deskripsi" rows="4"
                                    class="form-control shadow-sm @error('deskripsi') is-invalid @enderror" {{--
                                    DITERJEMAHKAN --}} placeholder="{{ __('Deskripsi kategori...') }}"></textarea>
                                @error('deskripsi')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            {{-- Gambar Kategori --}}
                            {{-- <div class="mb-4">
                                {{-- DITERJEMAHKAN --}}
                                {{-- <label for="foto" class="form-label">{{ __('Gambar Kategori') }}</label>
                                <input type="file" name="foto" id="foto"
                                    class="form-control shadow-sm @error('foto') is-invalid @enderror" accept="image/*"
                                    required>
                                @error('foto')
                                <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div> --}}

                            {{-- Tombol Simpan --}}
                            <div class="d-flex justify-content-between">
                                {{-- DITERJEMAHKAN --}}
                                <a href="{{ route('admin.kategori.index') }}"
                                    class="btn btn-secondary">{{ __('Kembali') }}</a>
                                {{-- DITERJEMAHKAN --}}
                                <button type="submit" class="btn btn-success px-4">{{ __('Simpan') }}</button>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection