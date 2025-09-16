@extends('layouts.admin')

@section('content')
    <div class="container">
        <h2 class="text-center fw-bold fs-2 mb-5 text-dark">📋 Daftar Transaksi Pengguna</h2>

        <div class="row">
            @forelse ($transactions as $trx)
                <div class="col-md-6 mb-4">
                    <div class="card shadow border-0 h-100">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start mb-3">
                                <div>
                                    <h5 class="card-title fw-bold text-dark mb-1">#Invoice {{ $trx->id }}</h5>
                                    <p class="mb-1 text-dark"><strong>Pengguna:</strong> {{ $trx->user->name }}</p>
                                    <p class="mb-1 text-dark"><strong>Telepon:</strong> {{ $trx->telepon }}</p>
                                    <p class="mb-1 text-dark"><strong>Alamat:</strong> {{ $trx->alamat }}</p>
                                    <p class="mb-1 text-dark"><strong>Metode Bayar:</strong>
                                        {{ ucfirst($trx->metode_pembayaran) }}</p>
                                    <p class="mb-2 text-dark"><strong>Total:</strong> Rp
                                        {{ number_format($trx->total, 0, ',', '.') }}</p>

                                    <span class="badge 
                                                @if($trx->status === 'pending') bg-warning text-dark
                                                @elseif($trx->status === 'dikirim') bg-primary
                                                @elseif($trx->status === 'selesai') bg-success
                                                @endif">
                                        {{ strtoupper($trx->status) }}
                                    </span>
                                </div>

                                <div class="text-end">
                                    @if ($trx->status === 'pending')
                                        <form method="POST" action="{{ route('admin.transactions.konfirmasi', $trx->id) }}">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-success w-100">
                                                ✅ Konfirmasi
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </div>

                            <div>
                                <h6 class="fw-semibold text-dark">🛒 Produk:</h6>
                                <ul class="ps-3 mb-0">
                                    @foreach ($trx->items as $item)
                                        <li class="text-dark">
                                            {{ $item->produk->nama }} x {{ $item->jumlah }} -
                                            Rp {{ number_format($item->harga * $item->jumlah, 0, ',', '.') }}
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="alert alert-info text-center">
                        🚫 Belum ada transaksi masuk saat ini.
                    </div>
                </div>
            @endforelse
        </div>
    </div>
@endsection