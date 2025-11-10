@extends('layouts.user')

@section('content')
    <div class="container py-5">
        {{-- DITERJEMAHKAN --}}
        <h1 class="text-center fw-bold mb-5 text-dark">💳 {{ __('Checkout') }}</h1>

        @if ($items->count() > 0)
            {{-- Ringkasan Keranjang --}}
            <div class="card shadow mb-4">
                <div class="card-body">
                    {{-- DITERJEMAHKAN --}}
                    <h5 class="fw-semibold mb-4 d-flex align-items-center gap-2">📦 {{ __('Ringkasan Pesanan') }}</h5>

                    <ul class="list-group mb-4">
                        @php
                            $total = 0;
                            $stok_kurang = false;
                        @endphp

                        @foreach ($items as $item)
                            @php
                                $subtotal = $item->produk->harga * $item->jumlah;
                                $total += $subtotal;
                                if ($item->produk->stok < $item->jumlah) {
                                    $stok_kurang = true;
                                }
                            @endphp

                            <li class="list-group-item d-flex justify-content-between align-items-start">
                                <div>
                                    <p class="fw-semibold mb-1">{{ $item->produk->nama }}</p>
                                    {{-- DITERJEMAHKAN --}}
                                    <small class="text-muted d-block">{{ __('Harga:') }} Rp
                                        {{ number_format($item->produk->harga, 0, ',', '.') }}</small>
                                    {{-- DITERJEMAHKAN --}}
                                    <small class="text-muted d-block">{{ __('Jumlah:') }} {{ $item->jumlah }}</small>
                                    <small
                                        class="{{ $item->produk->stok < $item->jumlah ? 'text-danger fw-semibold' : 'text-success' }}">
                                        {{-- DITERJEMAHKAN --}}
                                        {{ __('Stok tersedia:') }} {{ $item->produk->stok }}
                                        @if ($item->produk->stok < $item->jumlah)
                                            {{-- DITERJEMAHKAN --}}
                                            ({{ __('Stok tidak cukup') }}) {{-- Kunci sudah ada --}}
                                        @endif
                                    </small>
                                </div>
                                <span class="fw-bold text-dark">Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                            </li>
                        @endforeach
                    </ul>

                    <div class="text-end fs-5 fw-bold text-success">
                        {{-- DITERJEMAHKAN (Kunci sudah ada) --}}
                        {{ __('Total:') }} Rp {{ number_format($total, 0, ',', '.') }}
                    </div>
                </div>
            </div>

            {{-- Form Checkout --}}
            <form method="POST" action="{{ route('user.checkout.process') }}" class="card shadow">
                @csrf
                <div class="card-body">
                    <div class="mb-3">
                        {{-- DITERJEMAHKAN --}}
                        <label class="form-label fw-semibold">📍 {{ __('Alamat Pengiriman') }}</label>
                        <textarea name="alamat" rows="3" class="form-control" required>{{ old('alamat') }}</textarea>
                    </div>

                    <div class="mb-3">
                        {{-- DITERJEMAHKAN --}}
                        <label class="form-label fw-semibold">📞 {{ __('Nomor Telepon') }}</label>
                        <input type="text" name="telepon" value="{{ old('telepon') }}" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        {{-- DITERJEMAHKAN --}}
                        <label class="form-label fw-semibold">💰 {{ __('Metode Pembayaran') }}</label>
                        <select name="metode_pembayaran" class="form-select" required>
                            {{-- DITERJEMAHKAN --}}
                            <option value="Transfer Bank" @selected(old('metode_pembayaran') === 'Transfer Bank')>
                                {{ __('Transfer Bank') }}
                                (BCA)</option>
                            <option value="OVO" @selected(old('metode_pembayaran') === 'OVO')>{{ __('OVO') }}</option>
                            <option value="Dana" @selected(old('metode_pembayaran') === 'Dana')>{{ __('Dana') }}</option>
                            <option value="Gopay" @selected(old('metode_pembayaran') === 'Gopay')>{{ __('Gopay') }}</option>
                        </select>
                    </div>

                    <div class="bg-light border rounded p-3 mb-3">
                        {{-- DITERJEMAHKAN --}}
                        <p class="fw-medium mb-1">{{ __('Silakan transfer ke nomor berikut:') }}</p>
                        <h4 class="fw-bold text-success mb-0">0857 7440 7831</h4>
                        {{-- DITERJEMAHKAN --}}
                        <small class="text-muted">{{ __('Atas nama: Admin Toko Buku') }}</small>
                    </div>

                    @if ($stok_kurang)
                        <div class="alert alert-danger text-center">
                            {{-- DITERJEMAHKAN --}}
                            ❌
                            {{ __('Beberapa produk memiliki stok tidak cukup. Silakan kurangi jumlah atau hapus item di keranjang.') }}
                        </div>
                    @endif

                    <button type="submit" class="btn btn-warning w-100 fw-bold py-2" {{ $stok_kurang ? 'disabled' : '' }}>
                        {{-- DITERJEMAHKAN --}}
                        🛒 {{ __('Konfirmasi dan Proses Pesanan') }}
                    </button>
                </div>
            </form>
        @else
            <div class="alert alert-danger text-center mt-4">
                {{-- DITERJEMAHKAN --}}
                {{ __('Keranjang kosong. Silakan tambahkan produk terlebih dahulu.') }}
            </div>
        @endif
    </div>
@endsection