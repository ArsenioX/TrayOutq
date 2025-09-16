@extends('layouts.admin')

@section('content')
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <div class="container py-5">
        <div class="mb-4 p-4 rounded" style="background-color: #14532d;">
            <h2 class="fw-bold text-white mb-2">🛒 Daftar Produk</h2>
            <p class="text-white mb-0">Berikut adalah daftar produk yang tersedia. Anda dapat menambahkan, mengedit, atau
                menghapus produk sesuai kebutuhan.</p>
        </div>

        <div class="mb-3 d-flex justify-content-between align-items-center">
            <a href="{{ route('admin.dashboard') }}" class="btn fw-semibold"
                style="background-color: #facc15; color: black;">
                ← Kembali ke Dashboard
            </a>

            <a href="{{ route('admin.produk.create') }}" class="btn btn-success fw-semibold">
                + Tambah Produk
            </a>
        </div>

        @if (session('success'))
            <script>
                Swal.fire({
                    icon: 'success',
                    title: 'Sukses!',
                    text: '{{ session('success') }}',
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
                            <th style="width: 5%;">No</th>
                            <th>Nama Buku</th>
                            <th>Kategori</th>
                            <th>Harga</th>
                            <th>Stok</th>
                            <th style="width: 15%;">Gambar</th>
                            <th style="width: 20%;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($produks as $index => $produk)
                            <tr>
                                <td class="text-center">{{ $index + 1 }}</td>
                                <td class="fw-semibold">{{ $produk->nama }}</td>
                                <td>{{ $produk->kategori->nama ?? '-' }}</td>


                                <td>Rp {{ number_format($produk->harga, 0, ',', '.') }}</td>
                                <td>{{ $produk->stok }}</td>
                                <td>
                                    @if ($produk->foto)
                                        <img src="{{ asset('storage/' . $produk->foto) }}" alt="{{ $produk->nama }}"
                                            class="img-fluid rounded shadow-sm" width="100">
                                    @else
                                        <span class="text-muted fst-italic">Tidak ada gambar</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('admin.produk.edit', $produk->id) }}" class="btn btn-success btn-sm me-2">
                                        ✏️ Edit
                                    </a>
                                    <form id="delete-form-{{ $produk->id }}"
                                        action="{{ route('admin.produk.destroy', $produk->id) }}" method="POST"
                                        class="d-inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn btn-danger btn-sm"
                                            onclick="confirmDelete({{ $produk->id }})">
                                            🗑️ Hapus
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-4 text-muted">
                                    Belum ada Buku ditambahkan.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        function confirmDelete(id) {
            Swal.fire({
                title: 'Yakin ingin menghapus?',
                text: "Data produk akan dihapus permanen!",
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
            })
        }
    </script>
@endsection