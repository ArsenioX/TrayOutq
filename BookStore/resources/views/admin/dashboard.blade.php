@extends('layouts.admin')

@section('content')
    <style>
        /* ========== SIMPLE CLEAN DASHBOARD ========== */

        .dashboard-container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 0 1rem;
        }

        .welcome-section {
            margin-bottom: 2.5rem;
        }

        .welcome-title {
            font-size: 2rem;
            font-weight: 600;
            color: var(--text-color);
            margin-bottom: 0.5rem;
        }

        .welcome-subtitle {
            color: #64748b;
            font-size: 1rem;
        }

        html.dark .welcome-subtitle {
            color: #94a3b8;
        }

        /* ========== STATS CARDS ========== */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1.25rem;
            margin-bottom: 2.5rem;
        }

        .stat-card {
            background: var(--card-bg);
            border-radius: 12px;
            padding: 1.5rem;
            border: 1px solid #e2e8f0;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.08);
        }

        html.dark .stat-card {
            border-color: #334155;
        }

        .stat-header {
            display: flex;
            align-items: center;
            gap: 1rem;
            margin-bottom: 1rem;
        }

        .stat-icon {
            width: 48px;
            height: 48px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.25rem;
            color: white;
        }

        .stat-icon-purple {
            background: #8b5cf6;
        }

        .stat-icon-blue {
            background: #3b82f6;
        }

        .stat-icon-green {
            background: #10b981;
        }

        .stat-icon-orange {
            background: #f59e0b;
        }

        .stat-content {
            flex: 1;
        }

        .stat-label {
            font-size: 0.875rem;
            color: #64748b;
            font-weight: 500;
            margin-bottom: 0.25rem;
        }

        html.dark .stat-label {
            color: #94a3b8;
        }

        .stat-value {
            font-size: 1.75rem;
            font-weight: 700;
            color: var(--text-color);
        }

        .stat-footer {
            margin-top: 0.75rem;
            padding-top: 0.75rem;
            border-top: 1px solid #e2e8f0;
        }

        html.dark .stat-footer {
            border-color: #334155;
        }

        .stat-description {
            font-size: 0.875rem;
            color: #94a3b8;
        }

        .stat-pending {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.375rem 0.75rem;
            background: #fee2e2;
            color: #dc2626;
            border-radius: 6px;
            font-size: 0.875rem;
            font-weight: 600;
        }

        html.dark .stat-pending {
            background: rgba(220, 38, 38, 0.2);
            color: #fca5a5;
        }

        .stat-success {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.375rem 0.75rem;
            background: #dcfce7;
            color: #16a34a;
            border-radius: 6px;
            font-size: 0.875rem;
            font-weight: 600;
        }

        html.dark .stat-success {
            background: rgba(22, 163, 74, 0.2);
            color: #86efac;
        }

        /* ========== QUICK ACTIONS SECTION ========== */
        .actions-section {
            background: var(--card-bg);
            border-radius: 12px;
            padding: 2.5rem;
            border: 1px solid #e2e8f0;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.08);
            margin-bottom: 2rem;
        }

        html.dark .actions-section {
            border-color: #334155;
        }

        .section-header {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            margin-bottom: 2rem;
        }

        .section-icon {
            width: 40px;
            height: 40px;
            background: #8b5cf6;
            color: white;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.125rem;
        }

        .section-title {
            font-size: 1.25rem;
            font-weight: 600;
            color: var(--text-color);
            margin: 0;
        }

        .actions-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 1.5rem;
        }

        .action-btn {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 1rem;
            padding: 3rem 2rem;
            background: #8b5cf6;
            color: white;
            border: none;
            border-radius: 12px;
            font-size: 1.125rem;
            font-weight: 500;
            text-decoration: none;
            text-align: center;
            min-height: 180px;
        }

        .action-btn:hover {
            background: #7c3aed;
            color: white;
        }

        .action-btn i {
            font-size: 2.5rem;
        }

        /* ========== MANAGEMENT SECTION ========== */
        .management-section {
            margin-top: 2rem;
        }

        .management-card {
            background: var(--card-bg);
            border-radius: 12px;
            padding: 2rem;
            border: 1px solid #e2e8f0;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.08);
            text-decoration: none;
            color: var(--text-color);
            display: block;
        }

        html.dark .management-card {
            border-color: #334155;
        }

        .management-card:hover {
            color: var(--text-color);
            border-color: #8b5cf6;
        }

        .management-card h3 {
            font-size: 1.125rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
            color: var(--text-color);
        }

        .management-card p {
            font-size: 0.95rem;
            color: #64748b;
            margin: 0;
        }

        html.dark .management-card p {
            color: #94a3b8;
        }

        /* ========== CHAT BUTTON ========== */
        .chat-button {
            position: fixed;
            bottom: 30px;
            right: 30px;
            width: 56px;
            height: 56px;
            border-radius: 50%;
            background: #8b5cf6;
            color: white;
            border: none;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            box-shadow: 0 4px 12px rgba(139, 92, 246, 0.3);
            z-index: 999;
            cursor: pointer;
            text-decoration: none;
        }

        .chat-button:hover {
            background: #7c3aed;
            color: white;
        }

        .chat-notification-badge {
            position: absolute;
            top: -4px;
            right: -4px;
            min-width: 22px;
            height: 22px;
            padding: 3px;
            font-size: 11px;
            font-weight: 700;
            color: white;
            background: #ef4444;
            border-radius: 50%;
            display: none;
            align-items: center;
            justify-content: center;
            border: 2px solid var(--card-bg);
        }

        /* ========== RESPONSIVE ========== */
        @media (max-width: 768px) {
            .welcome-title {
                font-size: 1.5rem;
            }

            .stats-grid {
                grid-template-columns: 1fr;
            }

            .actions-grid {
                grid-template-columns: 1fr;
            }

            .chat-button {
                width: 48px;
                height: 48px;
                font-size: 20px;
                bottom: 20px;
                right: 20px;
            }
        }
    </style>

    <div class="dashboard-container">
        {{-- Welcome Section --}}
        <div class="welcome-section">
            <h1 class="welcome-title">{{ __('Welcome, Admin') }}</h1>
            <p class="welcome-subtitle">
                {{ __('This is your professional dashboard. Manage users, view reports, and control the system.') }}
            </p>
        </div>

        {{-- Statistics Cards --}}
        @if (config('features.show_dashboard_stats'))
        <div class="stats-grid">
            {{-- Total Books --}}
            <div class="stat-card">
                <div class="stat-header">
                    <div class="stat-icon stat-icon-purple">
                        <i class="fas fa-book"></i>
                    </div>
                    <div class="stat-content">
                        <div class="stat-label">{{ __('Total Books') }}</div>
                        <div class="stat-value">{{ $totalProduks ?? 0 }}</div>
                    </div>
                </div>
                <div class="stat-footer">
                    <div class="stat-description">{{ __('Product Management') }}</div>
                </div>
            </div>

            {{-- Total Users --}}
            <div class="stat-card">
                <div class="stat-header">
                    <div class="stat-icon stat-icon-blue">
                        <i class="fas fa-users"></i>
                    </div>
                    <div class="stat-content">
                        <div class="stat-label">{{ __('Total Users') }}</div>
                        <div class="stat-value">{{ $totalUsers ?? 0 }}</div>
                    </div>
                </div>
                <div class="stat-footer">
                    <div class="stat-description">{{ __('User Management') }}</div>
                </div>
            </div>

            {{-- Total Transactions --}}
            <div class="stat-card">
                <div class="stat-header">
                    <div class="stat-icon stat-icon-green">
                        <i class="fas fa-shopping-cart"></i>
                    </div>
                    <div class="stat-content">
                        <div class="stat-label">{{ __('Total Transactions') }}</div>
                        <div class="stat-value">{{ $totalTransactions ?? 0 }}</div>
                    </div>
                </div>
                <div class="stat-footer">
                    @isset($pendingTransactionsCount)
                        @if ($pendingTransactionsCount > 0)
                            <div class="stat-pending">
                                <i class="fas fa-clock"></i>
                                {{ $pendingTransactionsCount }} {{ __('pending') }}
                            </div>
                        @else
                            <div class="stat-success">
                                <i class="fas fa-check-circle"></i>
                                {{ __('No pending transactions') }}
                            </div>
                        @endif
                    @endisset
                </div>
            </div>

            {{-- Categories --}}
            <div class="stat-card">
                <div class="stat-header">
                    <div class="stat-icon stat-icon-orange">
                        <i class="fas fa-layer-group"></i>
                    </div>
                    <div class="stat-content">
                        <div class="stat-label">{{ __('Category Management') }}</div>
                        <div class="stat-value">
                            <i class="fas fa-folder-open" style="font-size: 1.25rem;"></i>
                        </div>
                    </div>
                </div>
                <div class="stat-footer">
                    <div class="stat-description">{{ __('Manage categories in the catalog.') }}</div>
                </div>
            </div>
        </div>
        @endif

        {{-- Quick Actions Section (Diperbesar) --}}
        <div class="actions-section">
            <div class="section-header">
                <div class="section-icon">
                    <i class="fas fa-bolt"></i>
                </div>
                <h2 class="section-title">{{ __('Quick Actions') }}</h2>
            </div>
            <div class="actions-grid">
                <a href="{{ route('admin.produk.index') }}" class="action-btn">
                    <i class="fas fa-book"></i>
                    <span>{{ __('Products') }}</span>
                </a>
                <a href="{{ route('admin.users.index') }}" class="action-btn">
                    <i class="fas fa-users"></i>
                    <span>{{ __('Users') }}</span>
                </a>
                <a href="{{ route('admin.transactions.index') }}" class="action-btn">
                    <i class="fas fa-shopping-cart"></i>
                    <span>{{ __('Transactions') }}</span>
                </a>
                <a href="{{ route('admin.kategori.index') }}" class="action-btn">
                    <i class="fas fa-layer-group"></i>
                    <span>{{ __('Categories') }}</span>
                </a>
            </div>
        </div>

        {{-- About Us Management --}}
        @if (config('features.show_about_management'))
        <div class="management-section">
            <a href="{{ route('admin.about.edit') }}" class="management-card">
                <h3>
                    <i class="fas fa-info-circle me-2" style="color: #8b5cf6;"></i>
                    {{ __('About Us Management') }}
                </h3>
                <p>{{ __("Update the content of the 'About Us' page.") }}</p>
            </a>
        </div>
    </div>
    @endif

    {{-- Chat Button --}}
    <a href="{{ route('admin.chat') }}" class="chat-button" title="Chat" id="admin-chat-button">
        💬
        <span id="chat-notification-badge" class="chat-notification-badge"></span>
    </a>

    {{-- Script Notifikasi Chat --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const chatBadge = document.getElementById('chat-notification-badge');
            function fetchUnreadCount() {
                fetch("{{ route('chat.unreadCount') }}", {
                    method: 'GET',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Network response was not ok. Status: ' + response.status);
                        }
                        return response.json();
                    })
                    .then(data => {
                        const count = data.unread_count;
                        if (chatBadge && count > 0) {
                            chatBadge.style.display = 'flex';
                            chatBadge.textContent = count;
                        } else if (chatBadge) {
                            chatBadge.style.display = 'none';
                        }
                    })
                    .catch(error => {
                        console.error('Error fetching unread chat count:', error);
                    });
            }
            fetchUnreadCount();
            setInterval(fetchUnreadCount, 15000);
        });
    </script>
@endsection