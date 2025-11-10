@extends('layouts.user')

@section('content')
    {{-- CSS Khusus untuk Bintang Rating (Input & Tampilan) --}}
    <style>
        /* 1. CSS untuk Bintang di Form Input */
        .rating-input {
            display: inline-block;
            direction: rtl;
            /* Balik urutan bintang agar hover-nya benar */
        }

        .rating-input input[type="radio"] {
            display: none;
        }

        .rating-input label {
            font-size: 2.5rem;
            color: #ddd;
            cursor: pointer;
            padding: 0 2px;
            transition: color 0.2s;
        }

        .rating-input label:hover,
        .rating-input label:hover~label,
        .rating-input input[type="radio"]:checked~label {
            color: #facc15;
            /* Warna bintang (kuning) */
        }

        /* 2. CSS untuk Menampilkan Bintang (Rating Rata-rata & Ulasan) */
        .star-rating-display {
            color: #facc15;
            /* Warna bintang (kuning) */
            font-size: 1.2rem;
            letter-spacing: 1px;
        }

        .star-rating-display .star-empty {
            color: #ddd;
            /* Warna bintang kosong */
        }
    </style>

    <div class="container py-5">
        {{-- Notifikasi Sukses/Error (dari review, cart, atau wishlist) --}}
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        {{-- ▼▼▼ LAYOUT LAMA ANDA (TAILWIND) DIGANTI DENGAN BOOTSTRAP ▼▼▼ --}}
        <div class="row g-4">
            {{-- Kolom Kiri: Gambar Produk --}}
            <div class="col-md-5">
                <img src="{{ asset('storage/' . $product->foto) }}" alt="{{ $product->nama }}"
                    class="img-fluid rounded shadow-sm w-100" style="border: 1px solid #ddd;">
            </div>

            {{-- Kolom Kanan: Info Produk & Tombol Aksi --}}
            <div class="col-md-7">
                {{-- Judul --}}
                <h1 class="h2 fw-bold">{{ $product->nama }}</h1>

                {{-- Tampilan Rating Rata-rata --}}
                <div class="d-flex align-items-center mb-3">
                    @php
                        // Kita panggil accessor 'average_rating' dari Model Produk
                        $rating = round($product->average_rating ?? 0); 
                    @endphp
                    <div class="star-rating-display">
                        @for ($i = 1; $i <= 5; $i++)
                            @if ($i <= $rating)
                                <span>★</span> {{-- Bintang Penuh --}}
                            @else
                                <span class="star-empty">☆</span> {{-- Bintang Kosong --}}
                            @endif
                        @endfor
                    </div>
                    {{-- Kita panggil relasi 'reviews' dari Model Produk --}}
                    <span class="ms-2 text-muted">({{ $product->reviews->count() }} ulasan)</span>
                </div>

                {{-- Harga --}}
                <p class="h3 fw-bold text-primary mb-3">Rp {{ number_format($product->harga, 0, ',', '.') }}</p>

                {{-- Deskripsi --}}
                <h2 class="h5 fw-semibold mt-4">Deskripsi Produk</h2>
                <p class="text-muted">{{ $product->deskripsi ?? 'Deskripsi produk belum tersedia.' }}</p>

                {{-- Tombol Aksi (Cart & Wishlist) --}}
                <div class="d-flex gap-2 mt-4">
                    <form action="{{ route('cart.add', $product->id) }}" method="POST" class="flex-grow-1">
                        @csrf
                        <button type="submit" class="btn btn-success btn-lg w-100 fw-semibold" {{ $product->stok == 0 ? 'disabled' : '' }}>
                            + Tambah ke Keranjang
                        </button>
                    </form>
                    <form action="{{ route('user.wishlist.toggle', $product->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-outline-danger btn-lg" title="Tambah ke Wishlist">
                            ❤️
                        </button>
                    </form>
                </div>
            </div>
        </div>
        {{-- ▲▲▲ AKHIR DARI PERUBAHAN BOOTSTRAP ▲▲▲ --}}


        <hr class="my-5">

        {{-- ▼▼▼ BAGIAN ULASAN (DENGAN LOGIKA EDIT/KIRIM) ▼▼▼ --}}
        <div class="row g-5">
            <div class="col-lg-5">

                {{--
                Logika Baru:
                Cek apakah $userReview (dari controller) ada isinya
                --}}
                @auth {{-- Pastikan user login dulu --}}
                        @if ($userReview)
                                {{-- JIKA SUDAH REVIEW: Tampilkan Form "Edit Ulasan Anda" --}}

                                <h3 class="fw-bold mb-3">Edit Ulasan Anda</h3>
                                <form action="{{ route('user.review.update', $userReview->id) }}" method="POST">
                                    @csrf
                                    @method('PUT') {{-- <-- Method PUT untuk update --}} <div class="mb-3">
                                        <label class="form-label fw-semibold">Rating Anda:</label>
                                        <div class="rating-input">
                                            {{-- Kita pakai $userReview->rating untuk 'checked' --}}
                                            <input type="radio" id="star5-edit" name="rating" value="5" {{ $userReview->rating == 5 ? 'checked' : '' }} required><label for="star5-edit" title="5 bintang">&#9733;</label>
                                            <input type="radio" id="star4-edit" name="rating" value="4" {{ $userReview->rating == 4 ? 'checked' : '' }}><label for="star4-edit" title="4 bintang">&#9733;</label>
                                            <input type="radio" id="star3-edit" name="rating" value="3" {{ $userReview->rating == 3 ? 'checked' : '' }}><label for="star3-edit" title="3 bintang">&#9733;</label>
                                            <input type="radio" id="star2-edit" name="rating" value="2" {{ $userReview->rating == 2 ? 'checked' : '' }}><label for="star2-edit" title="2 bintang">&#9733;</label>
                                            <input type="radio" id="star1-edit" name="rating" value="1" {{ $userReview->rating == 1 ? 'checked' : '' }}><label for="star1-edit" title="1 bintang">&#9733;</label>
                                        </div>
                            </div>

                            <div class="mb-3">
                                <label for="comment-edit" class="form-label fw-semibold">Ulasan Anda (Opsional):</label>
                                {{-- Kita isi textarea dengan $userReview->comment --}}
                                <textarea class="form-control" id="comment-edit" name="comment"
                                    rows="4">{{ $userReview->comment }}</textarea>
                            </div>

                            <button type="submit" class="btn btn-primary w-100">Simpan Perubahan</button>
                            </form>

                            {{-- Tombol Hapus Review --}}
                            <form action="{{ route('user.review.destroy', $userReview->id) }}" method="POST" class="mt-2">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger w-100"
                                    onclick="return confirm('Anda yakin ingin menghapus review ini?')">
                                    Hapus Review
                                </button>
                            </form>

                        @else
                        {{-- JIKA BELUM REVIEW: Tampilkan Form "Beri Ulasan Anda" --}}

                        <h3 class="fw-bold mb-3">Beri Ulasan Anda</h3>
                        {{-- Ini adalah form 'store' Anda yang lama, sudah benar --}}
                        <form action="{{ route('user.review.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="produk_id" value="{{ $product->id }}">

                            <div class="mb-3">
                                <label class="form-label fw-semibold">Rating Anda:</label>
                                <div class="rating-input">
                                    <input type="radio" id="star5" name="rating" value="5" {{ old('rating') == 5 ? 'checked' : '' }}
                                        required><label for="star5" title="5 bintang">&#9733;</label>
                                    <input type="radio" id="star4" name="rating" value="4" {{ old('rating') == 4 ? 'checked' : '' }}><label for="star4" title="4 bintang">&#9733;</label>
                                    <input type="radio" id="star3" name="rating" value="3" {{ old('rating') == 3 ? 'checked' : '' }}><label for="star3" title="3 bintang">&#9733;</label>
                                    <input type="radio" id="star2" name="rating" value="2" {{ old('rating') == 2 ? 'checked' : '' }}><label for="star2" title="2 bintang">&#9733;</label>
                                    <input type="radio" id="star1" name="rating" value="1" {{ old('rating') == 1 ? 'checked' : '' }}><label for="star1" title="1 bintang">&#9733;</label>
                                </div>
                                @error('rating') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                            </div>

                            <div class="mb-3">
                                <label for="comment" class="form-label fw-semibold">Ulasan Anda (Opsional):</label>
                                <textarea class="form-control" id="comment" name="comment" rows="4"
                                    placeholder="Bagaimana pendapat Anda tentang buku ini?">{{ old('comment') }}</textarea>
                                @error('comment') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                            </div>

                            <button type="submit" class="btn btn-primary w-100">Kirim Ulasan</button>
                        </form>
                    @endif
                @else
                <div class="alert alert-secondary text-center">
                    Silakan <a href="{{ route('login') }}" class="alert-link">Login</a> untuk memberi ulasan.
                </div>
            @endauth
            {{-- ▲▲▲ AKHIR DARI @if ($userReview) ▲▲▲ --}}

        </div>

        {{-- Kolom Kanan: Daftar Ulasan (Tidak berubah) --}}
        <div class="col-lg-7">
            <h3 class="fw-bold mb-3">Ulasan Pelanggan ({{ $product->reviews->count() }})</h3>

            @forelse ($product->reviews->sortByDesc('created_at') as $review)
                <div class="card mb-3 shadow-sm">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <h5 class="card-title fw-semibold">{{ $review->user->name }}</h5>
                            <div class="star-rating-display">
                                @for ($i = 1; $i <= 5; $i++)
                                    <span>{{ $i <= $review->rating ? '★' : '☆' }}</span>
                                @endfor
                            </div>
                        </div>

                        @if ($review->comment)
                            <p class="card-text text-muted mt-2 mb-0">{{ $review->comment }}</p>
                        @endif

                        <small class="text-muted d-block mt-2">{{ $review->created_at->diffForHumans() }}</small>
                    </div>
                </div>
            @empty
                <div class="alert alert-light">
                    Jadilah yang pertama memberi ulasan untuk produk ini.
                </div>
            @endforelse
        </div>
    </div>
    {{-- ▲▲▲ AKHIR BAGIAN ULASAN ▲▲▲ --}}

    </div>
@endsection