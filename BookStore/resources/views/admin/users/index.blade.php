@extends('layouts.admin')

@section('content')
    <style>
        /* ========== USER MANAGEMENT PAGE - HOPE UI STYLE ========== */

        .page-header {
            margin-bottom: 2rem;
        }

        .page-title {
            font-size: 2rem;
            font-weight: 700;
            color: var(--text-color);
            margin-bottom: 0.5rem;
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .page-title-icon {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.5rem;
        }

        .total-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.5rem 1rem;
            background: linear-gradient(135deg, #f0f9ff 0%, #e0f2fe 100%);
            color: #0369a1;
            border-radius: 12px;
            font-size: 0.95rem;
            font-weight: 600;
        }

        html.dark .total-badge {
            background: linear-gradient(135deg, rgba(3, 105, 161, 0.2) 0%, rgba(14, 165, 233, 0.2) 100%);
            color: #7dd3fc;
        }

        /* ========== TABLE CARD ========== */
        .table-card {
            background: var(--card-bg);
            border-radius: 16px;
            padding: 1.5rem;
            box-shadow: var(--card-shadow);
            border: 1px solid rgba(226, 232, 240, 0.8);
            overflow: hidden;
        }

        html.dark .table-card {
            border-color: rgba(71, 85, 105, 0.5);
        }

        .table-responsive {
            overflow-x: auto;
            margin: -1.5rem;
            padding: 1.5rem;
        }

        .modern-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
        }

        .modern-table thead {
            background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
        }

        html.dark .modern-table thead {
            background: linear-gradient(135deg, #1e293b 0%, #334155 100%);
        }

        .modern-table thead th {
            padding: 1rem 1.5rem;
            text-align: left;
            font-weight: 600;
            font-size: 0.875rem;
            color: #64748b;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            border-bottom: 2px solid #e2e8f0;
        }

        html.dark .modern-table thead th {
            color: #94a3b8;
            border-bottom-color: #475569;
        }

        .modern-table tbody tr {
            border-bottom: 1px solid #f1f5f9;
        }

        html.dark .modern-table tbody tr {
            border-bottom-color: #334155;
        }

        .modern-table tbody tr:hover {
            background: linear-gradient(90deg, rgba(102, 126, 234, 0.05) 0%, rgba(118, 75, 162, 0.05) 100%);
        }

        .modern-table tbody td {
            padding: 1rem 1.5rem;
            color: var(--text-color);
            font-size: 0.95rem;
        }

        .user-number {
            font-weight: 600;
            color: #94a3b8;
            font-size: 0.875rem;
        }

        .user-name {
            font-weight: 600;
            color: var(--text-color);
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 10px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
            font-size: 1rem;
        }

        .user-email {
            color: #64748b;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        html.dark .user-email {
            color: #94a3b8;
        }

        .user-date {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            color: var(--text-color);
        }

        .date-badge {
            padding: 0.4rem 0.8rem;
            background: #f0fdf4;
            color: #16a34a;
            border-radius: 8px;
            font-size: 0.875rem;
            font-weight: 500;
        }

        html.dark .date-badge {
            background: rgba(22, 163, 74, 0.2);
            color: #86efac;
        }

        /* ========== PAGINATION ========== */
        .pagination-wrapper {
            margin-top: 1.5rem;
        }

        .pagination {
            display: flex;
            justify-content: center;
            gap: 0.5rem;
            flex-wrap: wrap;
        }

        .pagination .page-item .page-link {
            border-radius: 10px;
            padding: 0.6rem 1rem;
            border: 1px solid #e2e8f0;
            color: var(--text-color);
            font-weight: 500;
            background: var(--card-bg);
        }

        html.dark .pagination .page-item .page-link {
            border-color: #475569;
        }

        .pagination .page-item.active .page-link {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-color: transparent;
            color: white;
        }

        .pagination .page-item .page-link:hover {
            box-shadow: 0 4px 8px rgba(102, 126, 234, 0.3);
            border-color: #667eea;
        }

        /* ========== BACK BUTTON ========== */
        .back-button {
            display: inline-flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.875rem 1.75rem;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            font-weight: 600;
            border-radius: 12px;
            text-decoration: none;
            box-shadow: 0 4px 6px rgba(102, 126, 234, 0.3);
            margin-top: 2rem;
        }

        .back-button:hover {
            box-shadow: 0 8px 12px rgba(102, 126, 234, 0.4);
            color: white;
        }

        .back-button i {
            font-size: 1.2rem;
        }

        /* ========== EMPTY STATE ========== */
        .empty-state {
            text-align: center;
            padding: 3rem 1rem;
            color: #94a3b8;
        }

        .empty-state i {
            font-size: 4rem;
            margin-bottom: 1rem;
            opacity: 0.5;
        }

        /* ========== RESPONSIVE ========== */
        @media (max-width: 768px) {
            .page-title {
                font-size: 1.5rem;
            }

            .page-title-icon {
                width: 40px;
                height: 40px;
                font-size: 1.2rem;
            }

            .table-responsive {
                margin: -1rem;
                padding: 1rem;
            }

            .modern-table thead th,
            .modern-table tbody td {
                padding: 0.75rem 1rem;
                font-size: 0.875rem;
            }

            .user-avatar {
                width: 36px;
                height: 36px;
                font-size: 0.9rem;
            }

            .back-button {
                width: 100%;
                justify-content: center;
            }
        }
    </style>

    <div class="container">
        {{-- Page Header --}}
        <div class="page-header">
            <h1 class="page-title">
                <div class="page-title-icon">
                    <i class="fas fa-users"></i>
                </div>
                {{-- DITERJEMAHKAN --}}
                {{ __('Daftar Akun User') }}
            </h1>
            <div class="total-badge">
                <i class="fas fa-user-check"></i>
                {{-- DITERJEMAHKAN --}}
                {{ __('Total akun:') }} {{ $total }}
            </div>
        </div>

        {{-- Table Card --}}
        <div class="table-card">
            <div class="table-responsive">
                <table class="modern-table">
                    <thead>
                        <tr>
                            {{-- DITERJEMAHKAN --}}
                            <th>{{ __('#') }}</th>
                            <th>{{ __('Nama') }}</th>
                            <th>{{ __('Email') }}</th>
                            <th>{{ __('Tanggal Dibuat') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($users as $user)
                            <tr>
                                <td>
                                    <span class="user-number">
                                        {{ $loop->iteration + ($users->currentPage() - 1) * $users->perPage() }}
                                    </span>
                                </td>
                                <td>
                                    <div class="user-name">
                                        <div class="user-avatar">
                                            {{ strtoupper(substr($user->name, 0, 1)) }}
                                        </div>
                                        {{ $user->name }}
                                    </div>
                                </td>
                                <td>
                                    <div class="user-email">
                                        <i class="fas fa-envelope" style="font-size: 0.875rem; color: #94a3b8;"></i>
                                        {{ $user->email }}
                                    </div>
                                </td>
                                <td>
                                    <div class="user-date">
                                        <span class="date-badge">
                                            <i class="fas fa-calendar-alt me-1"></i>
                                            {{ $user->created_at->format('d M Y') }}
                                        </span>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4">
                                    <div class="empty-state">
                                        <i class="fas fa-users-slash"></i>
                                        {{-- DITERJEMAHKAN --}}
                                        <p class="mb-0">{{ __('Belum ada data user') }}</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Pagination (LOGIKA TIDAK DIUBAH) --}}
        <div class="pagination-wrapper">
            {{ $users->links() }}
        </div>

        {{-- Back Button --}}
        <a href="{{ route('admin.dashboard') }}" class="back-button">
            <i class="fas fa-arrow-left"></i>
            {{-- DITERJEMAHKAN --}}
            {{ __('Kembali ke Dashboard') }}
        </a>
    </div>
@endsection