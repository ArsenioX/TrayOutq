@extends('layouts.user')

@section('content')
    <div class="container py-5" style="max-width: 720px;">
        <h1 class="text-white fw-bold mb-4">💳 Checkout</h1>

        @if ($items->count() > 0)
            {{-- Ringkasan Keranjang --}}
            <div class="card mb-4 shadow-sm">
                <div class="card-body">
                    <h5 class="card-title mb-3">📦 Ringkasan Pesanan</h5>
                    <ul class="list-group mb-3">
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
                                    <strong>{{ $item->produk->nama }}</strong><br>
                                    <small>Harga: Rp {{ number_format($item->produk->harga, 0, ',', '.') }}</small><br>
                                    <small>Jumlah: {{ $item->jumlah }}</small><br>
                                    <small
                                        class="{{ $item->produk->stok < $item->jumlah ? 'text-danger fw-bold' : 'text-success' }}">
                                        Stok tersedia: {{ $item->produk->stok }}
                                        @if ($item->produk->stok < $item->jumlah)
                                            (Stok tidak cukup)
                                        @endif
                                    </small>
                                </div>
                                <span class="fw-bold">Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                            </li>
                        @endforeach
                    </ul>

                    <div class="text-end fs-5 fw-bold text-success">
                        Total: Rp {{ number_format($total, 0, ',', '.') }}
                    </div>
                </div>
            </div>

            {{-- Form Checkout --}}
            <form method="POST" action="{{ route('user.checkout.process') }}" class="card shadow-sm">
                @csrf
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label">📍 Alamat Pengiriman</label>
                        <textarea name="alamat" rows="3" class="form-control" required>{{ old('alamat') }}</textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">📞 Nomor Telepon</label>
                        <input type="text" name="telepon" class="form-control" value="{{ old('telepon') }}" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">💰 Metode Pembayaran</label>
                        <select name="metode_pembayaran" class="form-select" required>
                            <option value="Transfer Bank" @selected(old('metode_pembayaran') === 'Transfer Bank')>Transfer Bank
                                (BCA)</option>
                            <option value="OVO" @selected(old('metode_pembayaran') === 'OVO')>OVO</option>
                            <option value="Dana" @selected(old('metode_pembayaran') === 'Dana')>Dana</option>
                            <option value="Gopay" @selected(old('metode_pembayaran') === 'Gopay')>Gopay</option>
                        </select>
                    </div>

                    <div class="bg-light p-3 rounded mb-4">
                        <p class="mb-1 fw-medium">Silakan transfer ke nomor berikut:</p>
                        <p class="h5 text-success fw-bold">0857 7440 7831</p>
                        <small class="text-muted">Atas nama: Admin Toko Buku</small>
                    </div>

                    @if ($stok_kurang)
                        <div class="alert alert-danger text-center">
                            ❌ Beberapa produk memiliki stok tidak cukup. Silakan kurangi jumlah atau hapus item di keranjang.
                        </div>
                    @endif

                    <button type="submit" class="btn btn-warning w-100 fw-bold" {{ $stok_kurang ? 'disabled' : '' }}>
                        🛒 Konfirmasi dan Proses Pesanan
                    </button>
                </div>
            </form>
        @else
            <div class="alert alert-danger text-center mt-4">
                Keranjang kosong. Silakan tambahkan produk terlebih dahulu.
            </div>
        @endif
    </div>
@endsection