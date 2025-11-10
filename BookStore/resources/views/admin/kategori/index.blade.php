@extends('layouts.admin')

@section('content')
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <div class="container py-5">
        <div class="mb-4 p-4 rounded" style="background-color: #14532d;">
            {{-- DITERJEMAHKAN --}}
            <h2 class="fw-bold text-white mb-2">📚 {{ __('Daftar Kategori Buku') }}</h2>
            {{-- DITERJEMAHKAN --}}
            <p class="text-white mb-0">{{ __('Berikut adalah daftar kategori buku yang tersedia di sistem. Anda dapat menambahkan, mengedit, atau menghapus kategori sesuai kebutuhan.') }}</p>
        </div>

        <div class="mb-3 d-flex justify-content-between align-items-center">
            <a href="{{ route('admin.dashboard') }}" class="btn fw-semibold"
                style="background-color: #facc15; color: black;">
                {{-- DITERJEMAHKAN (Kunci sudah ada) --}}
                {{ __('← Kembali ke Dashboard') }}
            </a>

            <a href="{{ route('admin.kategori.create') }}" class="btn btn-success fw-semibold">
                {{-- DITERJEMAHKAN --}}
                {{ __('+ Tambah Kategori') }}
            </a>
        </div>

        @if (session('success'))
            <script>
                Swal.fire({
                    icon: 'success',
                    {{-- DITERJEMAHKAN (Kunci sudah ada) --}}
                    title: '{{ __('Sukses!') }}',
                    text: '{{ session('success') }}',
                    showConfirmButton: false,
                    timer: 2000
                });
            </script>
        @endif

        @if (session('error'))
            <script>
                Swal.fire({
                    icon: 'error',
                    {{-- DITERJEMAHKAN --}}
                    title: '{{ __('Gagal!') }}',
                    text: '{{ session('error') }}'
                });
            </script>
        @endif

        <div class="card shadow-sm border-0">
            <div class="card-body p-0">
                <table class="table table-hover mb-0 align-middle">
                    <thead style="background-color: #14532d; color: white;">
                        <tr>
                            {{-- DITERJEMAHKAN (Kunci sudah ada) --}}
                            <th style="width: 5%;">{{ __('No') }}</th>
                            {{-- DITERJEMAHKAN --}}
                            <th>{{ __('Nama Kategori') }}</th>
                            <th>{{ __('Deskripsi') }}</th>
                            {{-- <th style="width: 20%;">Gambar</th> --}}
                            {{-- DITERJEMAHKAN (Kunci sudah ada) --}}
                            <th style="width: 20%;">{{ __('Aksi') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($kategoris as $index => $category)
                            <tr>
                                <td class="text-center">{{ $index + 1 }}</td>
                                <td class="fw-semibold">{{ $category->nama }}</td>
                                <td>{{ $category->deskripsi ?? '—' }}</td>
                                {{-- <td>
                                    @if ($category->foto)
                                        <img src="{{ asset('storage/' . $category->foto) }}" alt="{{ $category->nama }}"
                                            class="img-fluid rounded shadow-sm" width="100">
                                    @else
                                        <span class="text-muted fst-italic">Tidak ada gambar</span>
                                    @endif
                                </td> --}}
                                <td>
                                    <a href="{{ route('admin.kategori.edit', $category->id) }}"
                                        class="btn btn-success btn-sm me-2">
                                        {{-- DITERJEMAHKAN (Kunci sudah ada) --}}
                                        ✏️ {{ __('Edit') }}
                                    </a>
                                    <form id="delete-form-{{ $category->id }}"
                                        action="{{ route('admin.kategori.destroy', $category->id) }}" method="POST"
                                        class="d-inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn btn-danger btn-sm"
                                            onclick="confirmDelete({{ $category->id }})">
                                            {{-- DITERJEMAHKAN (Kunci sudah ada) --}}
                                            🗑️ {{ __('Hapus') }}
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-4 text-muted">
                                    {{-- DITERJEMAHKAN --}}
                                    {{ __('Belum ada kategori ditambahkan.') }}
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
                {{-- DITERJEMAHKAN (Kunci sudah ada) --}}
                title: '{{ __('Yakin ingin menghapus?') }}',
                {{-- DITERJEMAHKAN --}}
                text: "{{ __('Data kategori akan dihapus permanen!') }}",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                {{-- DITERJEMAHKAN (Kunci sudah ada) --}}
                confirmButtonText: '{{ __('Ya, hapus!') }}',
                cancelButtonText: '{{ __('Batal') }}'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete-form-' + id).submit();
                }
            })
        }
    </script>
@endsection