@extends('layouts.user')

@section('content')
    <div class="container py-5">
        <h2 class="text-center mb-4 text-white fw-bold">📦 Riwayat Transaksi</h2>

        @forelse($transaksi as $trx)
            <div class="card mb-4 border-start-5
                            @if($trx->status === 'pending') border-warning 
                            @elseif($trx->status === 'dikirim') border-primary 
                            @elseif($trx->status === 'selesai') border-success 
                            @else border-secondary @endif">

                <div class="card-body d-flex justify-content-between align-items-center text-dark">
                    <div>
                        <h5 class="card-title mb-2">
                            🧾 <span class="text-muted">Invoice:</span> #{{ $trx->id }}
                        </h5>
                        <p class="mb-0">
                            <strong>Status:</strong>
                            <span class="badge 
                                            @if($trx->status === 'pending') bg-warning text-dark
                                            @elseif($trx->status === 'dikirim') bg-primary
                                            @elseif($trx->status === 'selesai') bg-success
                                            @else bg-secondary @endif">
                                {{ ucfirst($trx->status) }}
                            </span>
                        </p>
                    </div>

                    <div class="d-flex gap-2">
                        {{-- Tampilkan struk hanya jika status bukan pending --}}
                        @if ($trx->status !== 'pending')
                            <a href="{{ route('user.struk', $trx->id) }}" class="btn btn-sm btn-outline-primary">
                                📄 Lihat Struk
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        @empty
            <div class="alert alert-info text-center text-dark" role="alert">
                🚫 Belum ada transaksi yang tercatat.
            </div>
        @endforelse
    </div>
@endsection