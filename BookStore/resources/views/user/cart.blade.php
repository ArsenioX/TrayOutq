@extends('layouts.user')

@section('content')
    <div class="container py-5">
        <h1 class="text-white fw-bold mb-4">🛒 Keranjang Belanja</h1>

        {{-- Notifikasi sukses / error --}}
        @if (session('success'))
            <script>
                Swal.fire({
                    title: 'Berhasil!',
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
                    title: 'Gagal!',
                    text: "{{ session('error') }}",
                    icon: 'error'
                });
            </script>
        @endif

        @if ($items->count())
            <div class="card shadow">
                <div class="card-body p-4">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>📚 Produk</th>
                                    <th class="text-center">Qty</th>
                                    <th>💰 Harga</th>
                                    <th>Subtotal</th>
                                    <th class="text-center">🧹 Aksi</th>
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
                                        <td>
                                            <strong>{{ $item->produk->nama }}</strong><br>
                                            <small class="text-muted">Stok: {{ $item->produk->stok }}</small>

                                            {{-- Peringatan stok --}}
                                            @if ($item->produk->stok < 1)
                                                <div class="text-danger fw-bold">❌ Stok habis</div>
                                            @elseif ($item->produk->stok < $item->jumlah)
                                                <div class="text-warning fw-bold">⚠️ Stok tidak cukup</div>
                                            @endif
                                        </td>

                                        <td class="text-center">{{ $item->jumlah }}</td>
                                        <td>Rp {{ number_format($item->produk->harga, 0, ',', '.') }}</td>
                                        <td>Rp {{ number_format($subtotal, 0, ',', '.') }}</td>
                                        <td class="text-center">
                                            {{-- Tombol hapus item dari keranjang --}}
                                            <form method="POST" action="{{ route('user.cart.remove', $item->id) }}"
                                                class="d-inline delete-form">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" class="btn btn-sm btn-outline-danger delete-btn">
                                                    🗑️ Hapus
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    {{-- Total & Checkout --}}
                    <div class="d-flex justify-content-between align-items-center mt-3">
                        <div class="h5 mb-0">Total:
                            <span class="fw-bold">Rp {{ number_format($totalHarga, 0, ',', '.') }}</span>
                        </div>

                        @if ($stokBermasalah)
                            <button class="btn btn-secondary fw-bold shadow" disabled>
                                🚫 Tidak bisa checkout (stok bermasalah)
                            </button>
                        @else
                            <a href="{{ route('user.checkout.form') }}" class="btn btn-warning fw-bold shadow">
                                ✅ Checkout Sekarang
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        @else
            <div class="alert alert-info text-center text-dark mt-4" role="alert">
                🧺 Keranjangmu masih kosong, yuk tambahkan buku!
            </div>
        @endif
    </div>

    {{-- SweetAlert2 untuk konfirmasi hapus --}}
    <script>
        document.querySelectorAll('.delete-btn').forEach(button => {
            button.addEventListener('click', function () {
                const form = this.closest('form');
                Swal.fire({
                    title: 'Hapus Produk?',
                    text: "Produk akan dihapus dari keranjang!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Ya, hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        });
    </script>
@endsection