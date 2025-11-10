@extends('layouts.user')

@section('content')
    <div class="container py-5">
        {{-- Judul Halaman --}}
        {{-- DITERJEMAHKAN (Kunci "My Wishlist" sudah ada) --}}
        <h2 class="text-center mb-4 fw-bold text-dark">❤️ {{ __('My Wishlist') }}</h2>
        {{-- DITERJEMAHKAN --}}
        <p class="text-center text-muted mb-4">{{ __('Daftar produk yang Anda simpan untuk nanti.') }}</p>

        {{-- Notifikasi Sukses/Error (dari tombol Hapus/Tambah) --}}
        @if (session('success'))
            <script>
                Swal.fire({
                        {{-- DITERJEMAHKAN(Kunci sudah ada)--}}
                    title: '{{ __('Berhasil!') }}',
                    text: "{{ session('success') }}",
                    icon: 'success',
                    timer: 1800,
                    showConfirmButton: false
                    });
            </script>
        @endif
        @if (session('error'))
            <script>
                Swal.fire({
                        {{-- DITERJEMAHKAN(Kunci sudah ada)--}}
                    title: '{{ __('Gagal!') }}',
                    text: "{{ session('error') }}",
                    icon: 'error'
                    });
            </script>
        @endif

        @forelse($wishlistItems as $item)
            {{-- $item adalah data dari tabel 'wishlists' --}}
            {{-- $item->produk adalah data dari tabel 'produks' (hasil relasi) --}}

            <div class="card shadow-sm mb-3">
                <div class="card-body p-3">
                    <div class="row g-3 align-items-center">

                        {{-- Kolom 1: Gambar --}}
                        <div class="col-md-2 col-4">
                            <img src="{{ asset('storage/' . $item->produk->foto) }}" alt="{{ $item->produk->nama }}"
                                class="img-fluid rounded border">
                        </div>

                        {{-- Kolom 2: Info Produk --}}
                        <div class="col-md-5 col-8">
                            <h5 class="fw-semibold text-dark mb-1">{{ $item->produk->nama }}</h5>
                            <p class="fw-bold text-primary mb-1">Rp {{ number_format($item->produk->harga, 0, ',', '.') }}</p>
                            <p class="mb-0 {{ $item->produk->stok > 0 ? 'text-success' : 'text-danger fw-semibold' }}">
                                {{-- DITERJEMAHKAN (Kunci "Stok:" dan "Out of Stock" sudah ada) --}}
                                {{ __('Stok:') }} {{ $item->produk->stok > 0 ? $item->produk->stok : __('Out of Stock') }}
                            </p>
                        </div>

                        {{-- Kolom 3: Tombol Aksi --}}
                        <div class="col-md-5 col-12 d-flex flex-md-row flex-column gap-2">

                            {{-- Ini akan memanggil route 'wishlist.toggle' yang sudah kita buat --}}
                            <form action="{{ route('user.wishlist.toggle', $item->produk_id) }}" method="POST"
                                class="flex-fill">
                                @csrf
                                <button type="submit" class="btn btn-outline-danger w-100">
                                    {{-- DITERJEMAHKAN (Kunci "Hapus" sudah ada) --}}
                                    🗑️ {{ __('Hapus') }}
                                </button>
                            </form>

                            <form action="{{ route('cart.add', $item->produk_id) }}" method="POST" class="flex-fill">
                                @csrf
                                <button type="submit" class="btn btn-success w-100" {{ $item->produk->stok == 0 ? 'disabled' : '' }}>
                                    {{-- DITERJEMAHKAN --}}
                                    + {{ __('Pindah ke Keranjang') }}
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        @empty
            {{-- Tampilan jika Wishlist Kosong --}}
            <div class="alert alert-info text-center fw-medium mt-4">
                {{-- DITERJEMAHKAN --}}
                <h4 class="alert-heading">{{ __('Wishlist Anda Kosong!') }}</h4>
                <p class="mb-0">{{ __('Anda belum menambahkan produk apapun ke wishlist.') }}</p>
            </div>
        @endforelse

    </div>
@endsection