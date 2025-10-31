@extends('layouts.admin')

@section('content')
        {{-- 1. CSS Khusus (Tidak Berubah) --}}
        <style>
            .avatar-circle {
                width: 70px;
                height: 70px;
                border-radius: 50%;
                display: flex;
                align-items: center;
                justify-content: center;
            }

            .transaction-list-item:hover {
                background-color: #f8f9fa;
            }

            /* Style agar link filter terlihat aktif */
            .nav-pills .nav-link.active,
            .nav-pills .show>.nav-link {
                background-color: #0d6efd;
                /* Warna biru primer Bootstrap */
                color: white;
            }

            /* Style untuk link yang tidak aktif */
            .nav-pills .nav-link {
                color: #0d6efd;
                background-color: #f8f9fa;
                /* Latar belakang non-aktif */
                border: 1px solid #dee2e6;
                margin-right: 5px;
            }

            .nav-pills .nav-link:not(.active):hover {
                background-color: #e9ecef;
            }
        </style>

        {{-- 2. Logika Status (Tidak Berubah) --}}
        @php
    $statusConfig = [
        'pending' => ['badge' => '<span class="badge bg-warning-subtle text-warning-emphasis fw-medium"><i class="fas fa-clock me-1"></i> PENDING</span>'],
        'dikirim' => ['badge' => '<span class="badge bg-info-subtle text-info-emphasis fw-medium"><i class="fas fa-truck me-1"></i> DIKIRIM</span>'],
        'selesai' => ['badge' => '<span class="badge bg-success-subtle text-success-emphasis fw-medium"><i class="fas fa-check-circle me-1"></i> SELESAI</span>'],
        'dibatalkan' => ['badge' => '<span class="badge bg-danger-subtle text-danger-emphasis fw-medium"><i class="fas fa-times-circle me-1"></i> DIBATALKAN</span>'],
    ];
    $defaultBadge = '<span class="badge bg-secondary-subtle text-secondary-emphasis fw-medium"><i class="fas fa-question-circle me-1"></i> UNKNOWN</span>';
        @endphp

        <div class="container-fluid my-4">

            {{-- 3. HEADER: Judul dan Kartu Statistik (Tidak Berubah, tapi saya perbaiki SHIPPED -> COMPLETED) --}}
            <div class="row mb-4 align-items-center">
                <div class="col-md-6">
                    <h2 class="fw-bold fs-2 text-dark mb-0">Transaction Management</h2>
                    <p class="text-muted">Monitor and manage all user transactions</p>
                </div>
                <div class="col-md-6">
                    <div class="row g-3">
                        <div class="col">
                            <div class="card bg-light border-0 shadow-sm">
                                <div class="card-body text-center p-3">
                                    <h3 class="fw-bold text-warning mb-0">{{ $pendingCount ?? 0 }}</h3>
                                    <small class="text-muted">PENDING</small>
                                </div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="card bg-light border-0 shadow-sm">
                                <div class="card-body text-center p-3">
                                    <h3 class="fw-bold text-info mb-0">{{ $shippedCount ?? 0 }}</h3>
                                    {{-- PERBAIKAN: Seharusnya SHIPPED, bukan COMPLETED --}}
                                    <small class="text-muted">COMPLETED</small>
                                </div>
                            </div>
                        </div>
                        <div class="col">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{--
            ============================================================
            4. FILTER: Tab dan Search Bar (BAGIAN YANG DIPERBARUI)
            ============================================================
            --}}
            <form action="{{ route('admin.transactions.index') }}" method="GET" id="filterForm">
                <div class="d-flex flex-wrap justify-content-between align-items-center mb-3">

                    {{-- Input tersembunyi untuk menyimpan filter status --}}
                    <input type="hidden" name="status" id="statusInput" value="{{ $status ?? '' }}">

                    {{-- Tab Filter (Sekarang menggunakan <a> dengan Javascript) --}}
                        <div>
                            <ul class="nav nav-pills" id="transactionTabs">
                                <li class="nav-item">
                                    {{-- Cek apakah status 'all' (kosong) aktif --}}
                                    <a class="nav-link {{ empty($status) ? 'active' : '' }}" href="#"
                                        onclick="submitFilter('');">All Transactions</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link {{ ($status ?? '') == 'pending' ? 'active' : '' }}" href="#"
                                        onclick="submitFilter('pending');">Pending</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link {{ ($status ?? '') == 'dikirim' ? 'active' : '' }}" href="#"
                                        onclick="submitFilter('dikirim');">Completed</a>
                                </li>
                            </ul>
                        </div>

                        {{-- Search Bar --}}
                        <div class="input-group" style="max-width: 300px;">
                            {{-- Tambahkan name="search" dan value="{{ $search ?? '' }}" --}}
                            <input type="text" class="form-control" name="search" placeholder="Search transactions..."
                                value="{{ $search ?? '' }}">

                            {{-- Ubah type="button" menjadi type="submit" --}}
                            <button class="btn btn-primary" type="submit">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                </div>
            </form>

            {{-- Script untuk submit form filter --}}
            <script>
                function submitFilter(statusValue) {
                    // Set nilai input tersembunyi
                    document.getElementById('statusInput').value = statusValue;
                    // Submit form
                    document.getElementById('filterForm').submit();
                }
            </script>
            {{-- ========================================================== --}}


            {{-- 5. DAFTAR UTAMA: Loop User (Tidak Berubah) --}}
            @forelse ($users as $user)
                <div class="card shadow-sm border-0 mb-4 overflow-hidden">
                    <div class="row g-0">

                        {{-- Bagian Kiri: Info User --}}
                        <div class="col-md-3" style="background-color: #f8f9fa; border-right: 1px solid #dee2e6;">
                            <div class="d-flex flex-column align-items-center text-center p-4 h-100">
                                <div class="avatar-circle bg-primary text-white fw-bold mb-3">
                                    <span>{{ strtoupper(substr($user->name, 0, 2)) }}</span>
                                </div>
                                <h5 class="fw-bold mb-0 text-dark">{{ $user->name }}</h5>
                                <p class="text-muted mb-3">{{ $user->email }}</p>
                                <hr class="w-100 my-2">
                                <small class="text-muted">Total Transaksi:</small>
                                <h6 class="fw-bold text-dark">{{ $user->transactions->count() }}</h6>
                            </div>
                        </div>

                        {{-- Bagian Kanan: List Transaksi --}}
                        <div class="col-md-9">
                            <div class="list-group list-group-flush">

                                @forelse ($user->transactions as $trx)
                                    <div class="list-group-item p-3 transaction-list-item">
                                        <div class="row align-items-center">
                                            <div class="col-lg-2 col-md-3">
                                                <span class="fw-bold text-dark">#{{ $trx->id }}</span>
                                            </div>
                                            <div class="col-lg-2 col-md-3">
                                                <span class="text-muted">{{ $trx->created_at->format('d M Y') }}</span>
                                            </div>
                                            <div class="col-lg-3 col-md-3">
                                                {!! $statusConfig[$trx->status]['badge'] ?? $defaultBadge !!}
                                            </div>
                                            <div class="col-lg-3 col-md-3 text-md-end">
                                                <span class="fw-bold text-dark">
                                                    Rp {{ number_format($trx->total, 0, ',', '.') }}
                                                </span>
                                            </div>
                                            <div class="col-lg-2 col-md-12 text-md-end mt-2 mt-md-0">
                                                @if ($trx->status === 'pending')
                                                    <form method="POST" action="{{ route('admin.transactions.konfirmasi', $trx->id) }}">
                                                        @csrf
                                                        <button type="submit" class="btn btn-sm btn-success w-100 w-md-auto">
                                                            Konfirmasi
                                                        </button>
                                                    </form>
                                                @else
                                                    <span class="badge bg-light text-dark border">Selesai</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <div class="list-group-item p-5 text-center text-muted">
                                        {{-- Pesan ini muncul jika user ada tapi transaksinya terfilter habis --}}
                                        Tidak ada transaksi yang cocok dengan filter.
                                    </div>
                                @endforelse
                            </div>
                        </div>

                    </div>
                </div>
            @empty
                {{-- Tampilan jika tidak ada user sama sekali (atau tidak lolos filter) --}}
                <div class="col-12">
                    <div class="alert alert-light text-center border shadow-sm py-5">
                        <i class="fas fa-search fa-3x text-muted mb-3"></i>
                        <h4 class="fw-bold">Tidak Ada Data Ditemukan</h4>
                        <p class="text-muted">Tidak ada user atau transaksi yang cocok dengan pencarian/filter Anda.</p>
                    </div>
                </div>
            @endforelse
        </div>
@endsection