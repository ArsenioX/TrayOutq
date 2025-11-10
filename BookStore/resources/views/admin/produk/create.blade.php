@extends('layouts.admin')

@section('content')
    <div class="container py-5">
        <div class="mb-4 p-4 rounded" style="background-color: #14532d;">
            {{-- DITERJEMAHKAN --}}
            <h2 class="fw-bold text-white mb-0">➕ {{ __('Tambah Produk Baru') }}</h2>
        </div>

        {{-- DITERJEMAHKAN --}}
        <a href="{{ route('admin.produk.index') }}" class="btn btn-warning fw-semibold mb-4">
            {{ __('← Kembali ke Daftar Produk') }}
        </a>

        <div class="card shadow-sm border-0">
            <div class="card-body">
                <form action="{{ route('admin.produk.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="mb-3">
                        {{-- DITERJEMAHKAN (Kunci ini sudah ada) --}}
                        <label for="nama" class="form-label fw-semibold">{{ __('Nama Buku') }}</label>
                        <input type="text" name="nama" class="form-control" value="{{ old('nama') }}" required>
                    </div>

                    <div class="mb-3">
                        {{-- DITERJEMAHKAN (Kunci ini sudah ada) --}}
                        <label for="kategori" class="form-label fw-semibold">{{ __('Kategori') }}</label>
                        <select name="kategori_id" class="form-control" required>
                            {{-- DITERJEMAHKAN --}}
                            <option value="">{{ __('-- Pilih Kategori --') }}</option>
                            @foreach ($kategoris as $kategori)
                                <option value="{{ $kategori->id }}">{{ $kategori->nama }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        {{-- DITERJEMAHKAN (Kunci ini sudah ada) --}}
                        <label for="harga" class="form-label fw-semibold">{{ __('Harga') }}</label>
                        <input type="number" name="harga" class="form-control" value="{{ old('harga') }}" required>
                    </div>

                    <div class="mb-3">
                        {{-- DITERJEMAHKAN (Kunci ini sudah ada) --}}
                        <label for="stok" class="form-label">{{ __('Stok') }}</label>
                        <input type="number" name="stok" id="stok" class="form-control"
                            value="{{ old('stok', $produk->stok ?? 0) }}" required>
                    </div>


                    <div class="mb-3">
                        {{-- DITERJEMAHKAN --}}
                        <label for="foto" class="form-label fw-semibold">{{ __('Gambar Buku') }}</label>
                        <input type="file" name="foto" class="form-control">
                    </div>

                    {{-- DITERJEMAHKAN --}}
                    <button type="submit" class="btn btn-success fw-semibold">💾 {{ __('Simpan Buku') }}</button>
                </form>
            </div>
        </div>
    </div>
@endsection