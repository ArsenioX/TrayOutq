@extends('layouts.user')

@section('content')
<div class="container py-4">
    {{-- DITERJEMAHKAN --}}
    <h1 class="mb-4 fw-bold fs-3">🛒 {{ __('Keranjang Belanja') }}</h1>

    {{-- ✅ Notifikasi SweetAlert2 --}}
    @if (session('success'))
        <script>
            Swal.fire({
                {{-- DITERJEMAHKAN (Kunci sudah ada) --}}
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
                {{-- DITERJEMAHKAN (Kunci sudah ada) --}}
                title: '{{ __('Gagal!') }}',
                text: "{{ session('error') }}",
                icon: 'error'
            });
        </script>
    @endif

    @if ($items->count())
        <div class="card shadow-sm">
            <div class="card-body table-responsive">
                <table class="table table-striped table-hover align-middle">
                    <thead class="table-dark">
                        <tr>
                            {{-- DITERJEMAHKAN --}}
                            <th>📚 {{ __('Produk') }}</th>
                            <th class="text-center">{{ __('Qty') }}</th>
                            <th>💰 {{ __('Harga') }}</th> {{-- Kunci sudah ada --}}
                            <th>{{ __('Subtotal') }}</th>
                            <th class="text-center">🧹 {{ __('Aksi') }}</th> {{-- Kunci sudah ada --}}
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $totalHarga = 0;
                            $stokBermasalah = false;
                        @endphp

                        @foreach ($items as $item)
                            @php
                                $subtotal = $item->jumlah * $item->produk->harga;
                                $totalHarga += $subtotal;

                                if ($item->produk->stok < 1 || $item->produk->stok < $item->jumlah) {
                                    $stokBermasalah = true;
                                }
                            @endphp
                            <tr>
                                {{-- Produk --}}
                                <td>
                                    <div>
                                        <strong>{{ $item->produk->nama }}</strong><br>
                                        {{-- DITERJEMAHKAN --}}
                                        <small class="text-muted">{{ __('Stok:') }} {{ $item->produk->stok }}</small><br>
                                        @if ($item->produk->stok < 1)
                                            {{-- DITERJEMAHKAN --}}
                                            <span class="text-danger fw-semibold">❌ {{ __('Stok habis') }}</span>
                                        @elseif ($item->produk->stok < $item->jumlah)
                                            {{-- DITERJEMAHKAN --}}
                                            <span class="text-warning fw-semibold">⚠️ {{ __('Stok tidak cukup') }}</span>
                                        @endif
                                    </div>
                                </td>

                                {{-- Qty (Logika tidak diubah) --}}
                                <td class="text-center">
                                    <div class="d-flex justify-content-center align-items-center gap-2">
                                        <form action="{{ route('user.cart.decrease', $item->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('PUT')
                                            <button type="submit" class="btn btn-sm btn-secondary"
                                                {{ $item->jumlah <= 1 ? 'disabled' : '' }}>-</button>
                                        </form>
                                        <span class="fw-semibold">{{ $item->jumlah }}</span>
                                        <form action="{{ route('user.cart.increase', $item->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('PUT')
                                            <button type="submit" class="btn btn-sm btn-success"
                                                {{ $item->jumlah >= $item->produk->stok ? 'disabled' : '' }}>+</button>
                                        </form>
                                    </div>
                                </td>

                                {{-- Harga & Subtotal --}}
                                <td>Rp {{ number_format($item->produk->harga, 0, ',', '.') }}</td>
                                <td>Rp {{ number_format($subtotal, 0, ',', '.') }}</td>

                                {{-- Aksi --}}
                                <td class="text-center">
                                    <form method="POST" action="{{ route('user.cart.remove', $item->id) }}" class="d-inline delete-form">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn btn-sm btn-outline-danger delete-btn">
                                            {{-- DITERJEMAHKAN (Kunci sudah ada) --}}
                                            🗑️ {{ __('Hapus') }}
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                {{-- Total & Checkout --}}
                <div class="d-flex justify-content-between align-items-center mt-4">
                    <div class="fs-5">
                        {{-- DITERJEMAHKAN --}}
                        <strong>{{ __('Total:') }}</strong>
                        <span class="fw-bold text-dark">Rp {{ number_format($totalHarga, 0, ',', '.') }}</span>
                    </div>
                    @if ($stokBermasalah)
                        {{-- DITERJEMAHKAN --}}
                        <button class="btn btn-secondary" disabled>🚫 {{ __('Tidak bisa checkout (stok bermasalah)') }}</button>
                    @else
                        <a href="{{ route('user.checkout.form') }}" class="btn btn-warning fw-semibold">
                            {{-- DITERJEMAHKAN --}}
                            ✅ {{ __('Checkout Sekarang') }}
                        </a>
                    @endif
                </div>
            </div>
        </div>
    @else
        <div class="alert alert-info text-center mt-4 shadow-sm">
            {{-- DITERJEMAHKAN --}}
            🧺 {{ __('Keranjangmu masih kosong, yuk tambahkan buku!') }}
        </div>
    @endif
</div>

{{-- ✅ Script konfirmasi hapus --}}
<script>
    document.addEventListener('DOMContentLoaded', function () {
        function confirmDelete(form) {
            if (window.Swal) {
                Swal.fire({
                    {{-- DITERJEMAHKAN --}}
                    title: '{{ __('Hapus Produk?') }}',
                    text: "{{ __('Produk akan dihapus dari keranjang!') }}",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    {{-- DITERJEMAHKAN (Kunci sudah ada) --}}
                    confirmButtonText: '{{ __('Ya, hapus!') }}',
                    cancelButtonText: '{{ __('Batal') }}'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            } else {
                {{-- DITERJEMAHKAN (Fallback) --}}
                if (confirm('{{ __('Hapus produk dari keranjang?') }}')) {
                    form.submit();
                }
            }
        }

        // Logika event listener TIDAK DIUBAH
        document.body.addEventListener('click', function (e) {
            const btn = e.target.closest('.delete-btn');
            if (!btn) return;
            e.preventDefault();

            const form = btn.closest('form');
            if (!form) return;

            confirmDelete(form);
        });
    });
</script>
@endsection