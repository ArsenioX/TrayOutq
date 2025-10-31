@extends('layouts.user')

@section('content')
    <div class="p-4">

        {{-- ... (Blok notifikasi Anda tidak berubah) ... --}}
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="card mb-4 shadow-sm">
            <div class="card-body">
                <h1 class="h4 fw-bold mb-1">Selamat Datang di Dashboard Anda</h1>
                <p class="text-muted mb-0">Lihat aktivitas dan produk yang tersedia untuk Anda.</p>
            </div>
        </div>

        <div class="card mb-4 shadow-sm">
            <div class="card-body">
                {{-- Form Filter Anda (dengan dropdown harga) sudah benar --}}
                <div class="d-flex flex-column flex-md-row align-items-start align-items-md-center justify-content-between gap-3 mb-4">
                    <h2 class="h5 fw-semibold mb-0">🛒 Daftar Produk</h2>

                    <form method="GET" action="{{ route('user.dashboard') }}" class="d-flex flex-column flex-md-row gap-2 w-100 w-md-auto">
                        
                        <input type="text" name="search" placeholder="Cari produk..." value="{{ request('search') }}"
                            class="form-control" style="min-width: 220px;" />

                        <select name="kategori" class="form-select" style="min-width: 200px;">
                            <option value="">Semua Kategori</option>
                            @foreach ($kategori as $kat)
                                <option value="{{ $kat->id }}" {{ request('kategori') == $kat->id ? 'selected' : '' }}>
                                    {{ $kat->nama }}
                                </option>
                            @endforeach
                        </select>

                        <div class="dropdown">
                            <button class="btn btn-outline-secondary dropdown-toggle w-100" type="button" id="filterHargaDropdown" 
                                    data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="false">
                                Urutkan Harga
                            </button>
                            
                            <div class="dropdown-menu p-3 shadow" aria-labelledby="filterHargaDropdown" style="min-width: 300px;">
                                <div class="mb-3">
                                    <label class="form-label fw-semibold">Urutkan:</label>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="sort_harga" id="termurah" value="asc" {{ request('sort_harga') == 'asc' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="termurah">
                                            Termurah
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="sort_harga" id="termahal" value="desc" {{ request('sort_harga') == 'desc' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="termahal">
                                            Termahal
                                        </label>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label fw-semibold">Rentang Harga (Rp)</label>
                                    <div class="d-flex align-items-center gap-2">
                                        <input type="number" class="form-control form-control-sm" name="harga_min" placeholder="80000" value="{{ request('harga_min') }}">
                                        <span>-</span>
                                        <input type="number" class="form-control form-control-sm" name="harga_max" placeholder="100000" value="{{ request('harga_max') }}">
                                    </div>
                                </div>
                                <a href="{{ route('user.dashboard') }}" class="btn btn-sm btn-outline-danger w-100">Reset Filter</a>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary">
                            Filter
                        </button>
                    </form>
                </div>

                <div class="row g-4">
                    @forelse ($produk as $item)
                        <div class="col-12 col-sm-6 col-md-4">
                            <div class="card h-100 shadow-sm">
                                <img src="{{ asset('storage/' . $item->foto) }}" alt="{{ $item->nama }}"
                                    class="card-img-top" style="height: 208px; object-fit: cover;">
                                <div class="card-body d-flex flex-column">
                                    <h5 class="card-title mb-1">{{ $item->nama }}</h5>
                                    <p class="text-muted small mb-1">{{ $item->kategori->nama ?? '-' }}</p>
                                    <p class="fw-bold text-primary mb-1">Rp {{ number_format($item->harga, 0, ',', '.') }}</p>
                                    <p class="mb-2 {{ $item->stok > 0 ? 'text-body' : 'text-danger fw-semibold' }}">
                                        Stok: {{ $item->stok > 0 ? $item->stok : 'Habis' }}
                                    </p>
                                    <form action="{{ route('cart.add', $item->id) }}" method="POST" class="mt-auto">
                                        @csrf
                                        <button type="submit"
                                            class="btn btn-success w-100 fw-semibold"
                                            {{ $item->stok == 0 ? 'disabled' : '' }}>
                                            + Tambah ke Keranjang
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-12 text-center py-5">
                            <p class="text-muted mb-0">Produk tidak ditemukan.</p>
                        </div>
                    @endforelse
                </div> 

                <div class="d-flex justify-content-center mt-4">
                    {{ $produk->links() }}
                </div>

            </div> 
        </div> 
    </div>

    {{-- ▼▼▼ TOMBOL CHAT MENGAMBANG SUDAH DIHAPUS DARI SINI ▼▼▼ --}}
    {{-- (Karena sudah dipindah ke layouts/user.blade.php) --}}
    {{-- <a href="{{ route('user.chat') }}" ...> ... </a> --}}
    
@endsection

@push('scripts')
    {{-- ... (Script Tooltip Anda tidak berubah) ... --}}
    <script>
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        })
    </script>
@endpush