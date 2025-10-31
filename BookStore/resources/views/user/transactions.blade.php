@extends('layouts.user')

@section('content')
    <div class="container py-5">
        {{-- Judul Halaman --}}
        <h2 class="text-center mb-4 fw-bold text-dark">📦 Riwayat Transaksi</h2>

        @forelse($transaksi as $trx)
            @php
                $style = match ($trx->status) {
                    'pending' => 'border-start border-4 border-warning bg-light',
                    'dikirim' => 'border-start border-4 border-primary bg-light',
                    'selesai' => 'border-start border-4 border-success bg-light',
                    default => 'border-start border-4 border-secondary bg-light',
                };

                $badgeClass = match ($trx->status) {
                    'pending' => 'bg-warning text-dark',
                    'dikirim' => 'bg-primary text-white',
                    'selesai' => 'bg-success text-white',
                    default => 'bg-secondary text-white',
                };

                $badgeText = match ($trx->status) {
                    'pending' => 'Menunggu Konfirmasi Admin',
                    'dikirim' => 'Pesanan Dikirim',
                    'selesai' => 'Pesanan Selesai',
                    default => 'Status Tidak Diketahui',
                };
            @endphp

            {{-- Card Transaksi --}}
            <div class="card shadow-sm mb-4 {{ $style }}">
                <div class="card-body d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">

                    {{-- Info Transaksi (Kiri) --}}
                    <div>
                        <h5 class="fw-semibold text-dark mb-2">📘 Pesanan #{{ $trx->id }}</h5>
                        <div class="d-flex align-items-center gap-2">
                            <strong class="text-muted small">Status:</strong>
                            <span class="badge rounded-pill {{ $badgeClass }}">{{ $badgeText }}</span>
                        </div>
                    </div>

                    {{-- Tombol Struk (masih disembunyikan) --}}
                    {{--
                    <div class="d-flex gap-2">
                        @if ($trx->status !== 'pending')
                        <a href="{{ route('user.struk', $trx->id) }}"
                            class="btn btn-outline-primary d-flex align-items-center gap-1">
                            📄 <span class="d-none d-sm-inline">Lihat Struk</span>
                        </a>
                        @endif
                    </div>
                    --}}
                </div>
            </div>

        @empty
            {{-- Status Kosong --}}
            <div class="alert alert-info text-center fw-medium">
                🚫 Belum ada transaksi yang tercatat.
            </div>
        @endforelse
    </div>
@endsection