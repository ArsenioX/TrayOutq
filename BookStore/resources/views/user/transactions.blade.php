@extends('layouts.user')

@section('content')
    <div class="container py-5">
        {{-- Judul Halaman --}}
        {{-- DITERJEMAHKAN --}}
        <h2 class="text-center mb-4 fw-bold text-dark">📦 {{ __('Riwayat Transaksi') }}</h2>

        @forelse($transaksi as $trx)
            @php
                $style = match ($trx->status ?? 'default') {
                    'pending' => 'border-start border-4 border-warning bg-light',
                    'diproses' => 'border-start border-4 border-primary bg-light',
                    'dikirim' => 'border-start border-4 border-info bg-light',
                    'selesai' => 'border-start border-4 border-success bg-light',
                    'dibatalkan' => 'border-start border-4 border-danger bg-light',
                    default => 'border-start border-4 border-secondary bg-light',
                };

                $badgeClass = match ($trx->status ?? 'default') {
                    'pending' => 'bg-warning text-dark',
                    'diproses' => 'bg-primary text-white',
                    'dikirim' => 'bg-info text-dark',
                    'selesai' => 'bg-success text-white',
                    'dibatalkan' => 'bg-danger text-white',
                    default => 'bg-secondary text-white',
                };

                // PERUBAHAN DI SINI: Teks badge sekarang dibungkus dengan __()
                $badgeText = match ($trx->status ?? 'default') {
                    'pending' => __('Menunggu Konfirmasi'),
                    'diproses' => __('Sedang Diproses'),
                    'dikirim' => __('Pesanan Dikirim'),
                    'selesai' => __('Pesanan Selesai'),
                    'dibatalkan' => __('Dibatalkan'),
                    default => __('Status Tidak Diketahui'),
                };
            @endphp

            {{-- Card Transaksi (Struktur HTML yang Benar) --}}
            <div class="card shadow-sm mb-4 {{ $style }}">
                <div class="card-body">
                    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">

                        {{-- Info Transaksi (Kiri) --}}
                        <div>
                            {{-- DITERJEMAHKAN --}}
                            <h5 class="fw-semibold text-dark mb-2">📘 {{ __('Pesanan #') }}{{ $trx->id }}</h5>
                            <div class="d-flex align-items-center gap-2 mb-2">
                                {{-- DITERJEMAHKAN --}}
                                <strong class="text-muted small">{{ __('Status:') }}</strong>
                                <span class="badge rounded-pill {{ $badgeClass }}">{{ $badgeText }}</span> {{-- Teks badge sudah
                                dari PHP --}}
                            </div>

                            @if ($trx->shipping_notes)
                                <div class="alert alert-info p-2 mt-2" style="font-size: 0.9rem; max-width: 400px;">
                                    {{-- DITERJEMAHKAN (Kunci sudah ada) --}}
                                    <strong>{{ __('Catatan Pengiriman:') }}</strong>
                                    <p class="mb-0">{{ $trx->shipping_notes }}</p>
                                </div>
                            @endif
                        </div>

                        {{-- Tombol Aksi (Kanan) --}}
                        <div class="d-flex gap-2">
{{--                             
                            @if ($trx->status !== 'pending')
                            <a href="{{ route('user.struk', $trx->id) }}"
                                class="btn btn-outline-primary d-flex align-items-center gap-1">
                                📄 <span class="d-none d-sm-inline">{{ __('Lihat Struk') }}</span>
                            </a>
                            @endif
                            --}}

                            @if ($trx->status == 'dikirim')
                                <form action="{{ route('user.transactions.selesai', $trx->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-success fw-semibold">
                                        {{-- DITERJEMAHKAN --}}
                                        {{ __('Pesanan Diterima') }}
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div> {{-- <-- Penutup .card-body --}} <hr class="my-3">
                    {{-- DITERJEMAHKAN --}}
                    <h6 class="fw-semibold px-3">{{ __('Produk yang dibeli:') }}</h6> {{-- Ditambah padding 'px-3' agar sejajar
                    --}}

                    <ul class="list-group list-group-flush">
                        @foreach($trx->items as $item)
                            <li class="list-group-item d-flex justify-content-between align-items-center bg-transparent px-3"> {{--
                                Ditambah padding 'px-3' --}}
                                <div>
                                    <a href="{{ route('user.product.show', $item->produk_id) }}"
                                        class="text-dark fw-semibold text-decoration-none">
                                        {{ $item->produk->nama }}
                                    </a>
                                    <small class="d-block text-muted">
                                        {{ $item->jumlah }} x Rp {{ number_format($item->harga, 0, ',', '.') }}
                                    </small>
                                </div>
                                <span class="fw-bold">Rp {{ number_format($item->jumlah * $item->harga, 0, ',', '.') }}</span>
                            </li>
                        @endforeach
                    </ul>
            </div> {{-- <-- INI ADALAH </div> PENUTUP CARD YANG HILANG TADI --}}

        @empty
                {{-- Status Kosong --}}
                <div class="alert alert-info text-center fw-medium">
                    {{-- DITERJEMAHKAN --}}
                    🚫 {{ __('Belum ada transaksi yang tercatat.') }}
                </div>
            @endforelse
    </div>
@endsection