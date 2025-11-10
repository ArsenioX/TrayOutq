@extends('layouts.admin')

@section('content')
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <div class="container py-5">
        <div class="mb-4 p-4 rounded" style="background-color: #14532d;">
            {{-- DITERJEMAHKAN --}}
            <h2 class="fw-bold text-white mb-2">🛒 {{ __('Daftar Produk') }}</h2>
            {{-- DITERJEMAHKAN --}}
            <p class="text-white mb-0">
                {{ __('Berikut adalah daftar produk yang tersedia. Anda dapat menambahkan, mengedit, atau menghapus produk sesuai kebutuhan.') }}
            </p>
        </div>

        <div class="mb-3 d-flex justify-content-between align-items-center">
            <a href="{{ route('admin.dashboard') }}" class="btn fw-semibold"
                style="background-color: #facc15; color: black;">
                {{-- DITERJEMAHKAN --}}
                {{ __('← Kembali ke Dashboard') }}
            </a>

            <a href="{{ route('admin.produk.create') }}" class="btn btn-success fw-semibold">
                {{-- DITERJEMAHKAN --}}
                {{ __('+ Tambah Produk') }}
            </a>
        </div>

        @if (session('success'))
            <script>
                Swal.fire({
                    icon: 'success',
                            {{-- DITERJEMAHKAN--}}
                    title: '{{ __('Sukses!') }}',
                    text: '{{ session('success') }}', {{-- Teks ini dari Controller--}}
                    showConfirmButton: false,
                    timer: 2000
                        });
            </script>
        @endif

        <div class="card shadow-sm border-0">
            <div class="card-body p-0">
                <table class="table table-hover mb-0 align-middle">
                    <thead style="background-color: #14532d; color: white;">
                        <tr>
                            {{-- DITERJEMAHKAN --}}
                            <th style="width: 5%;">{{ __('No') }}</th>
                            <th>{{ __('Nama Buku') }}</th>
                            <th>{{ __('Kategori') }}</th>
                            <th>{{ __('Harga') }}</th>
                            <th>{{ __('Stok') }}</th>
                            <th style="width: 15%;">{{ __('Gambar') }}</th>
                            <th style="width: 20%;">{{ __('Aksi') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($produks as $produk)
                            <tr>
                                <td class="text-center">
                                    {{ ($produks->currentPage() - 1) * $produks->perPage() + $loop->iteration }}
                                </td>

                                <td class="fw-semibold">{{ $produk->nama }}</td>
                                <td>{{ $produk->kategori->nama ?? '-' }}</td>
                                <td>Rp {{ number_format($produk->harga, 0, ',', '.') }}</td>
                                <td>{{ $produk->stok }}</td>
                                <td>
                                    @if ($produk->foto)
                                        <img src="{{ asset('storage/' . $produk->foto) }}" alt="{{ $produk->nama }}"
                                            class="img-fluid rounded shadow-sm" width="100">
                                    @else
                                        {{-- DITERJEMAHKAN --}}
                                        <span class="text-muted fst-italic">{{ __('Tidak ada gambar') }}</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('admin.produk.edit', $produk->id) }}" class="btn btn-success btn-sm me-2">
                                        {{-- DITERJEMAHKAN --}}
                                        ✏️ {{ __('Edit') }}
                                    </a>
                                    <form id="delete-form-{{ $produk->id }}"
                                        action="{{ route('admin.produk.destroy', $produk->id) }}" method="POST"
                                        class="d-inline-block">
                                        @csrf
                                        @method('DELETE')

                                        <button type="button" class="btn btn-danger btn-sm"
                                            onclick="confirmDelete({{ $produk->id }}, {{ $produk->stok }})">
                                            {{-- DITERJEMAHKAN --}}
                                            🗑️ {{ __('Hapus') }}
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-4 text-muted">
                                    {{-- DITERJEMAHKAN --}}
                                    {{ __('Belum ada Buku ditambahkan.') }}
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <div class="d-flex justify-content-center mt-4">
            {{ $produks->links() }}
        </div>

    </div>

   <script>
    function confirmDelete(id, stok) {
        // Jika stok LEBIH dari 0, TIDAK BISA dihapus
        if (stok > 0) {
            Swal.fire({
                title: 'Gagal Menghapus!',
                text: 'Produk tidak dapat dihapus karena stok masih tersedia (Stok saat ini: ' + stok + ').',
                icon: 'error',
                confirmButtonText: 'Mengerti'
            });
        } 
        // Jika stok = 0, BISA dihapus dengan konfirmasi
        else {
            Swal.fire({
                title: 'Yakin ingin menghapus?',
                text: "Data produk ini (stok 0) akan dihapus permanen!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete-form-' + id).submit();
                }
            });
        }
    }
</script>