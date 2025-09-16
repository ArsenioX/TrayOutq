@extends('layouts.user')

@section('content')
    <div class="container mt-5">
        <!-- Heading Selamat Datang -->
        <div class="bg-white shadow-sm rounded p-4 mb-4">
            <h1 class="h3 fw-bold text-dark">Selamat Datang di Dashboard Anda</h1>
            <p class="text-muted mb-0">Lihat aktivitas dan produk yang tersedia untuk Anda.</p>
        </div>

        <!-- Daftar Produk + Filter -->
        <div class="bg-white shadow-sm rounded p-4">
            <div
                class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4">
                <h2 class="h4 fw-semibold mb-3 mb-md-0">🛒 Daftar Produk</h2>

                <form method="GET" action="{{ route('user.dashboard') }}" class="d-flex flex-column flex-md-row gap-2">
                    <input type="text" name="search" placeholder="Cari produk..." value="{{ request('search') }}"
                        class="form-control" />

                    <select name="kategori" class="form-select">
                        <option value="">Semua Kategori</option>
                        @foreach ($kategori as $kat)
                            <option value="{{ $kat->id }}" {{ request('kategori') == $kat->id ? 'selected' : '' }}>
                                {{ $kat->nama }}
                            </option>
                        @endforeach
                    </select>

                    <button type="submit" class="btn btn-primary">
                        Filter
                    </button>
                </form>
            </div>

            <!-- Grid Produk -->
            <div class="row g-4">
                @forelse ($produk as $item)
                    <div class="col-12 col-sm-6 col-md-4">
                        <div class="card h-100 shadow-sm">
                            <img src="{{ asset('storage/' . $item->foto) }}" alt="{{ $item->nama }}"
                                class="card-img-top object-fit-cover" style="height: 200px;">

                            <div class="card-body d-flex flex-column">
                                <h5 class="card-title">{{ $item->nama }}</h5>
                                <p class="card-text text-muted mb-1">{{ $item->kategori->nama ?? '-' }}</p>
                                <p class="card-text text-primary fw-bold">Rp
                                    {{ number_format($item->harga, 0, ',', '.') }}
                                </p>

                                <!-- Tampilkan stok -->
                                <p class="card-text mb-2" style="color: {{ $item->stok > 0 ? 'inherit' : 'red' }}">
                                    Stok: {{ $item->stok > 0 ? $item->stok : 'Habis' }}
                                </p>

                                <!-- Tombol Tambah ke Keranjang -->
                                <form action="{{ route('cart.add', $item->id) }}" method="POST" class="mt-auto">
                                    @csrf
                                    <button type="submit" class="btn btn-success w-100" {{ $item->stok == 0 ? 'disabled' : '' }}>
                                        + Tambah ke Keranjang
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12">
                        <p class="text-muted text-center">Produk tidak ditemukan.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Tombol Chat Mengambang -->
    <a href="{{ route('user.chat') }}" class="btn btn-primary rounded-circle shadow-lg" data-bs-toggle="tooltip"
        data-bs-placement="left" title="Chat Admin" style="position: fixed; bottom: 30px; right: 30px; width: 60px; height: 60px;
                          display: flex; align-items: center; justify-content: center; font-size: 24px; z-index: 999;">
        💬
    </a>
@endsection

@push('scripts')
    <script>
        // Aktifkan tooltip Bootstrap untuk tombol chat
        const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
    </script>
@endpush