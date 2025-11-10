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

        .nav-pills .nav-link.active,
        .nav-pills .show>.nav-link {
            background-color: #0d6efd;
            color: white;
        }

        .nav-pills .nav-link {
            color: #0d6efd;
            background-color: #f8f9fa;
            border: 1px solid #dee2e6;
            margin-right: 5px;
        }

        .nav-pills .nav-link:not(.active):hover {
            background-color: #e9ecef;
        }
    </style>

    {{-- 2. Logika Status (TIDAK DIUBAH) --}}
    @php
        $statusConfig = [
            'pending' => ['badge' => '<span class="badge bg-warning-subtle text-warning-emphasis fw-medium"><i class="fas fa-clock me-1"></i> PENDING</span>'],
            'diproses' => ['badge' => '<span class="badge bg-primary-subtle text-primary-emphasis fw-medium"><i class="fas fa-spinner me-1"></i> DIPROSES</span>'],
            'dikirim' => ['badge' => '<span class="badge bg-info-subtle text-info-emphasis fw-medium"><i class="fas fa-truck me-1"></i> DIKIRIM</span>'],
            'selesai' => ['badge' => '<span class="badge bg-success-subtle text-success-emphasis fw-medium"><i class="fas fa-check-circle me-1"></i> SELESAI</span>'],
            'dibatalkan' => ['badge' => '<span class="badge bg-danger-subtle text-danger-emphasis fw-medium"><i class="fas fa-times-circle me-1"></i> DIBATALKAN</span>'],
        ];
        $defaultBadge = '<span class="badge bg-secondary-subtle text-secondary-emphasis fw-medium"><i class="fas fa-question-circle me-1"></i> UNKNOWN</span>';
    @endphp

    <div class="container-fluid my-4">

        {{-- 3. HEADER: Kartu Statistik --}}
        <div class="row mb-4 align-items-center">
            <div class="col-md-5">
                {{-- DITERJEMAHKAN --}}
                <h2 class="fw-bold fs-2 text-dark mb-0">{{ __('Transaction Management') }}</h2>
                <p class="text-muted">{{ __('Monitor and manage all user transactions') }}</p>
            </div>
            <div class="col-md-7">
                <div class="row g-3">
                    <div class="col">
                        <div class="card bg-light border-0 shadow-sm">
                            <div class="card-body text-center p-3">
                                <h3 class="fw-bold text-warning mb-0">{{ $pendingCount ?? 0 }}</h3>
                                {{-- DITERJEMAHKAN --}}
                                <small class="text-muted">{{ __('PENDING') }}</small>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="card bg-light border-0 shadow-sm">
                            <div class="card-body text-center p-3">
                                <h3 class="fw-bold text-primary mb-0">{{ $processingCount ?? 0 }}</h3>
                                {{-- DITERJEMAHKAN --}}
                                <small class="text-muted">{{ __('DIPROSES') }}</small>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="card bg-light border-0 shadow-sm">
                            <div class="card-body text-center p-3">
                                <h3 class="fw-bold text-info mb-0">{{ $shippedCount ?? 0 }}</h3>
                                {{-- DITERJEMAHKAN --}}
                                <small class="text-muted">{{ __('DIKIRIM') }}</small>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="card bg-light border-0 shadow-sm">
                            <div class="card-body text-center p-3">
                                <h3 class="fw-bold text-success mb-0">{{ $completedCount ?? 0 }}</h3>
                                {{-- DITERJEMAHKAN --}}
                                <small class="text-muted">{{ __('SELESAI') }}</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- 4. FILTER: Tab dan Search Bar --}}
        <form action="{{ route('admin.transactions.index') }}" method="GET" id="filterForm">
            <div class="d-flex flex-wrap justify-content-between align-items-center mb-3">
                <input type="hidden" name="status" id="statusInput" value="{{ $status ?? '' }}">
                <div>
                    <ul class="nav nav-pills" id="transactionTabs">
                        {{-- DITERJEMAHKAN --}}
                        <li class="nav-item"><a class="nav-link {{ empty($status) ? 'active' : '' }}" href="#"
                                onclick="submitFilter('');">{{ __('All Transactions') }}</a></li>
                        <li class="nav-item"><a class="nav-link {{ $status == 'pending' ? 'active' : '' }}" href="#"
                                onclick="submitFilter('pending');">{{ __('Pending') }}</a></li>
                        <li class="nav-item"><a class="nav-link {{ $status == 'diproses' ? 'active' : '' }}" href="#"
                                onclick="submitFilter('diproses');">{{ __('Diproses') }}</a></li>
                        <li class="nav-item"><a class="nav-link {{ $status == 'dikirim' ? 'active' : '' }}" href="#"
                                onclick="submitFilter('dikirim');">{{ __('Dikirim') }}</a></li>
                        <li class="nav-item"><a class="nav-link {{ $status == 'selesai' ? 'active' : '' }}" href="#"
                                onclick="submitFilter('selesai');">{{ __('Selesai') }}</a></li>
                    </ul>
                </div>
                <div class="input-group" style="max-width: 300px;">
                    {{-- DITERJEMAHKAN --}}
                    <input type="text" class="form-control" name="search" placeholder="{{ __('Search transactions...') }}"
                        value="{{ $search ?? '' }}">
                    <button class="btn btn-primary" type="submit"><i class="fas fa-search"></i></button>
                </div>
            </div>
        </form>

        {{-- 5. DAFTAR UTAMA: Loop User --}}
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
                            {{-- DITERJEMAHKAN --}}
                            <small class="text-muted">{{ __('Total Transaksi:') }}</small>
                            <h6 class="fw-bold text-dark">{{ $user->transactions->count() }}</h6>
                        </div>
                    </div>

                    {{-- Bagian Kanan: List Transaksi --}}
                    <div class="col-md-9">
                        <div class="list-group list-group-flush">
                            @forelse ($user->transactions as $trx)
                                <div class="list-group-item p-3 transaction-list-item">
                                    <div class="row align-items-center">
                                        <div class="col-lg-2 col-md-3"><span class="fw-bold text-dark">#{{ $trx->id }}</span></div>
                                        <div class="col-lg-2 col-md-3"><span
                                                class="text-muted">{{ $trx->created_at->format('d M Y') }}</span></div>
                                        <div class="col-lg-3 col-md-3">{!! $statusConfig[$trx->status]['badge'] ?? $defaultBadge !!}
                                        </div> {{-- Badge dari PHP, TIDAK DIUBAH --}}
                                        <div class="col-lg-3 col-md-3 text-md-end"><span class="fw-bold text-dark">Rp
                                                {{ number_format($trx->total, 0, ',', '.') }}</span></div>

                                        {{-- 6. TOMBOL AKSI --}}
                                        <div class="col-lg-2 col-md-12 text-md-end mt-2 mt-md-0">
                                            @if ($trx->status == 'pending')
                                                <button class="btn btn-sm btn-success w-100 w-md-auto update-status-btn"
                                                    data-trx-id="{{ $trx->id }}" data-new-status="diproses">
                                                    {{-- DITERJEMAHKAN --}}
                                                    {{ __('Konfirmasi Pesanan') }}
                                                </button>
                                            @elseif ($trx->status == 'diproses')
                                                <button class="btn btn-sm btn-primary w-100 w-md-auto" data-bs-toggle="modal"
                                                    data-bs-target="#shippingModal" data-trx-id="{{ $trx->id }}">
                                                    {{-- DITERJEMAHKAN --}}
                                                    {{ __('Kirim Pesanan') }}
                                                </button>
                                            @elseif ($trx->status == 'dikirim')
                                                {{-- DITERJEMAHKAN --}}
                                                <span class="badge bg-light text-dark border">{{ __('Menunggu User') }}</span>
                                            @elseif ($trx->status == 'selesai')
                                                {{-- DITERJEMAHKAN --}}
                                                <span class="badge bg-light text-dark border">{{ __('Sudah Selesai') }}</span>
                                            @endif
                                        </div>
                                    </div>

                                    @if ($trx->shipping_notes)
                                        <div class="alert alert-secondary mt-2 mb-0 p-2" style="font-size: 0.85rem;">
                                            {{-- DITERJEMAHKAN --}}
                                            <strong>{{ __('Catatan Pengiriman:') }}</strong> {{ $trx->shipping_notes }}
                                        </div>
                                    @endif
                                </div>
                            @empty
                                <div class="list-group-item p-5 text-center text-muted">
                                    {{-- DITERJEMAHKAN --}}
                                    {{ __('Tidak ada transaksi yang cocok dengan filter.') }}
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="alert alert-light text-center border shadow-sm py-5">
                    <i class="fas fa-search fa-3x text-muted mb-3"></i>
                    {{-- DITERJEMAHKAN --}}
                    <h4 class="fw-bold">{{ __('Tidak Ada Data Ditemukan') }}</h4>
                    <p class="text-muted">{{ __('Tidak ada user atau transaksi yang cocok dengan pencarian/filter Anda.') }}</p>
                </div>
            </div>
        @endforelse
    </div>

    {{-- 7. MODAL UNTUK CATATAN PENGIRIMAN --}}
    <div class="modal fade" id="shippingModal" tabindex="-1" aria-labelledby="shippingModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    {{-- DITERJEMAHKAN --}}
                    <h5 class="modal-title" id="shippingModalLabel">{{ __('Input Catatan Pengiriman (No. Resi)') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="shippingModalForm" action="" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <input type="hidden" name="status" value="dikirim">
                        <div class="mb-3">
                            {{-- DITERJEMAHKAN --}}
                            <label for="shipping_notes"
                                class="form-label">{{ __('Catatan / Nomor Resi (Opsional)') }}</label>
                            <textarea class="form-control" id="shipping_notes" name="shipping_notes" rows="3" {{--
                                DITERJEMAHKAN --}} placeholder="{{ __('Contoh: JNE-1234567890') }}"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        {{-- DITERJEMAHKAN (Kunci sudah ada) --}}
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('Batal') }}</button>
                        {{-- DITERJEMAHKAN --}}
                        <button type="submit" class="btn btn-primary">{{ __('Simpan & Tandai Dikirim') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Form tersembunyi untuk update status sederhana (TIDAK DIUBAH) --}}
    <form id="updateStatusForm" action="" method="POST" class="d-none">
        @csrf
        @method('PUT')
        <input type="hidden" id="simple_status" name="status" value="">
    </form>


    {{-- SCRIPT (LOGIKA TIDAK DIUBAH, HANYA TEKS SWEETALERT) --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {

            // --- 1. Script untuk Tab Filter (TIDAK DIUBAH) ---
            window.submitFilter = function (statusValue) {
                document.getElementById('statusInput').value = statusValue;
                document.getElementById('filterForm').submit();
            }

            // --- 2. Script untuk Modal "Kirim Pesanan" (TIDAK DIUBAH) ---
            const shippingModal = document.getElementById('shippingModal');
            if (shippingModal) {
                const modalForm = document.getElementById('shippingModalForm');

                shippingModal.addEventListener('show.bs.modal', function (event) {
                    const button = event.relatedTarget;
                    const trxId = button.getAttribute('data-trx-id');
                    const actionUrl = "{{ url('admin/transactions/update-status') }}/" + trxId;
                    modalForm.action = actionUrl;
                });
            }

            // --- 3. Script untuk Tombol "Konfirmasi" & "Selesaikan" (TEKS DITERJEMAHKAN) ---
            const updateButtons = document.querySelectorAll('.update-status-btn');
            const simpleForm = document.getElementById('updateStatusForm');
            const simpleStatusInput = document.getElementById('simple_status');

            updateButtons.forEach(button => {
                button.addEventListener('click', function () {
                    const trxId = this.getAttribute('data-trx-id');
                    const newStatus = this.getAttribute('data-new-status');

                    const actionUrl = "{{ url('admin/transactions/update-status') }}/" + trxId;
                    simpleForm.action = actionUrl;
                    simpleStatusInput.value = newStatus;

                    Swal.fire({
                            {{-- DITERJEMAHKAN--}}
                            title: '{{ __('Ubah Status?') }}',
                {{-- DITERJEMAHKAN(PENTING: String dipecah agar variabel JS tetap berfungsi)--}}
            text: '{{ __('Anda yakin ingin mengubah status pesanan #') }}' + trxId + '{{ __(' menjadi "') }}' + newStatus + '"?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            {{-- DITERJEMAHKAN(Kunci sudah ada)--}}
            confirmButtonText: '{{ __('Ya, ubah!') }}',
            cancelButtonText: '{{ __('Batal') }}'
                        }).then((result) => {
                if (result.isConfirmed) {
                    simpleForm.submit(); // Submit form tersembunyi
                }
            });
                    });
                });

            });
    </script>
@endsection