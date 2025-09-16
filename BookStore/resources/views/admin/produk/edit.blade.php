@extends('layouts.admin')

@section('content')
    <div class="container py-5">
        <div class="mb-4 p-4 rounded" style="background-color: #14532d;">
            <h2 class="fw-bold text-white mb-0">✏ Edit Produk</h2>
        </div>

        <a href="{{ route('admin.produk.index') }}" class="btn btn-warning fw-semibold mb-4">
            ← Kembali ke Daftar Buku
        </a>

        <div class="card shadow-sm border-0">
            <div class="card-body">
                <form action="{{ route('admin.produk.update', $produk->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="nama" class="form-label fw-semibold">Nama Buku</label>
                        <input type="text" name="nama" class="form-control" value="{{ old('nama', $produk->nama) }}"
                            required>
                    </div>

                    <div class="mb-3">
                        <label for="kategori" class="form-label fw-semibold">Kategori</label>
                        <select name="kategori_id" class="form-control" required>
                            <option value="">-- Pilih Kategori --</option>
                            @foreach ($kategoris as $kategori)
                                <option value="{{ $kategori->id }}" {{ $produk->kategori_id == $kategori->id ? 'selected' : '' }}>
                                    {{ $kategori->nama }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="harga" class="form-label fw-semibold">Harga</label>
                        <input type="number" name="harga" class="form-control" value="{{ old('harga', $produk->harga) }}"
                            required>
                    </div>

                    <div class="mb-3">
                        <label for="stok" class="form-label">Stok</label>
                        <input type="number" name="stok" id="stok" class="form-control" value="{{ old('stok', $produk->stok ?? 0) }}"
                            required>
                    </div>


                    <div class="mb-3">
                        <label for="foto" class="form-label fw-semibold">Gambar Buku (Opsional)</label>
                        <input type="file" name="foto" class="form-control">
                        @if ($produk->foto)
                            <small class="d-block mt-2">Gambar saat ini:</small>
                            <img src="{{ asset('storage/' . $produk->foto) }}" alt="{{ $produk->nama }}"
                                class="img-fluid rounded shadow-sm" width="120">
                        @endif
                    </div>

                    <button type="submit" class="btn btn-primary fw-semibold">💾 Update Buku</button>
                </form>
            </div>
        </div>
    </div>
@endsection