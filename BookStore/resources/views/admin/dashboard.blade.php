@extends('layouts.admin')

@section('content')
    <style>
        /* ========== HOPE UI DASHBOARD DESIGN ========== */

        .welcome-section {
            margin-bottom: 2rem;
        }

        .welcome-title {
            font-size: 2rem;
            font-weight: 700;
            color: var(--text-color);
            margin-bottom: 0.5rem;
        }

        .welcome-subtitle {
            color: #64748b;
            font-size: 1rem;
            font-weight: 400;
        }

        html.dark .welcome-subtitle {
            color: #94a3b8;
        }

        /* ========== STATS CARDS GRID ========== */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .stat-card {
            background: var(--card-bg);
            border-radius: 16px;
            padding: 1.5rem;
            box-shadow: var(--card-shadow);
            border: 1px solid rgba(226, 232, 240, 0.8);
        }

        html.dark .stat-card {
            border-color: rgba(71, 85, 105, 0.5);
        }

        .stat-card:hover {
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }

        .stat-icon {
            width: 56px;
            height: 56px;
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            margin-bottom: 1rem;
        }

        .stat-card:hover .stat-icon {
            transform: scale(1.05);
        }

        /* Icon Colors - Hope UI Style */
        .stat-icon-purple {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }

        .stat-icon-blue {
            background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
            color: white;
        }

        .stat-icon-green {
            background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);
            color: white;
        }

        .stat-icon-pink {
            background: linear-gradient(135deg, #fa709a 0%, #fee140 100%);
            color: white;
        }

        .stat-label {
            font-size: 0.875rem;
            font-weight: 500;
            color: #64748b;
            margin-bottom: 0.5rem;
        }

        html.dark .stat-label {
            color: #94a3b8;
        }

        .stat-value {
            font-size: 2rem;
            font-weight: 700;
            color: var(--text-color);
            margin-bottom: 0.5rem;
        }

        .stat-description {
            font-size: 0.875rem;
            color: #94a3b8;
        }

        .stat-pending {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.4rem 0.8rem;
            background: #fef2f2;
            color: #dc2626;
            border-radius: 8px;
            font-size: 0.875rem;
            font-weight: 600;
            margin-top: 0.5rem;
        }

        html.dark .stat-pending {
            background: rgba(220, 38, 38, 0.2);
            color: #fca5a5;
        }

        .stat-success {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.4rem 0.8rem;
            background: #f0fdf4;
            color: #16a34a;
            border-radius: 8px;
            font-size: 0.875rem;
            font-weight: 600;
            margin-top: 0.5rem;
        }

        html.dark .stat-success {
            background: rgba(22, 163, 74, 0.2);
            color: #86efac;
        }

        /* ========== QUICK ACTIONS BUTTONS ========== */
        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            border-radius: 12px;
            font-weight: 500;
            box-shadow: 0 4px 6px rgba(102, 126, 234, 0.3);
        }

        .btn-primary:hover {
            box-shadow: 0 8px 12px rgba(102, 126, 234, 0.4);
            background: linear-gradient(135deg, #764ba2 0%, #667eea 100%);
        }

        .btn-primary:active {
            transform: translateY(0);
        }

        /* ========== RESPONSIVE ========== */
        .management-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
            gap: 1.5rem;
            margin-top: 2rem;
        }

        .management-card {
            background: var(--card-bg);
            border-radius: 16px;
            padding: 2rem;
            text-decoration: none;
            color: var(--text-color);
            box-shadow: var(--card-shadow);
            border: 1px solid rgba(226, 232, 240, 0.8);
            position: relative;
            overflow: hidden;
        }

        html.dark .management-card {
            border-color: rgba(71, 85, 105, 0.5);
        }

        .management-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 4px;
            background: linear-gradient(90deg, #667eea 0%, #764ba2 100%);
            transform: scaleX(0);
            transform-origin: left;
        }

        .management-card:hover::before {
            transform: scaleX(1);
        }

        .management-card:hover {
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }

        .management-card h3 {
            font-size: 1.25rem;
            font-weight: 600;
            margin-bottom: 0.75rem;
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

        /* ========== CHAT BUTTON MODERN ========== */
        .chat-button {
            position: fixed;
            bottom: 30px;
            right: 30px;
            width: 60px;
            height: 60px;
            border-radius: 50%;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            box-shadow: 0 10px 25px rgba(102, 126, 234, 0.4);
            z-index: 999;
            cursor: pointer;
            text-decoration: none;
        }

        .chat-button:hover {
            box-shadow: 0 15px 35px rgba(102, 126, 234, 0.6);
        }

        .chat-notification-badge {
            position: absolute;
            top: -5px;
            right: -5px;
            min-width: 24px;
            height: 24px;
            padding: 4px;
            font-size: 12px;
            font-weight: bold;
            color: white;
            background: linear-gradient(135deg, #fa709a 0%, #fee140 100%);
            border-radius: 50%;
            display: none;
            align-items: center;
            justify-content: center;
            border: 3px solid var(--card-bg);
        }

        /* ========== RESPONSIVE ========== */
        @media (max-width: 768px) {
            .welcome-title {
                font-size: 1.5rem;
            }

            .stats-grid {
                grid-template-columns: 1fr;
            }

            .management-grid {
                grid-template-columns: 1fr;
            }

            .stat-value {
                font-size: 1.5rem;
            }

            .chat-button {
                width: 50px;
                height: 50px;
                font-size: 20px;
                bottom: 20px;
                right: 20px;
            }
        }
    </style>

    {{-- Welcome Section --}}
    <div class="welcome-section">
        <h1 class="welcome-title">{{ __('Welcome, Admin') }}</h1>
        <p class="welcome-subtitle">
            {{ __('This is your professional dashboard. Manage users, view reports, and control the system.') }}
        </p>
    </div>

    {{-- Statistics Cards --}}
    <div class="stats-grid">
        {{-- Total Books --}}
        <div class="stat-card">
            <div class="stat-icon stat-icon-purple">
                <i class="fas fa-book"></i>
            </div>
            <div class="stat-label">{{ __('Total Books') }}</div>
            <div class="stat-value">{{ $totalProduks ?? 0 }}</div>
            <div class="stat-description">{{ __('Product Management') }}</div>
        </div>

        {{-- Total Users --}}
        <div class="stat-card">
            <div class="stat-icon stat-icon-blue">
                <i class="fas fa-users"></i>
            </div>
            <div class="stat-label">{{ __('Total Users') }}</div>
            <div class="stat-value">{{ $totalUsers ?? 0 }}</div>
            <div class="stat-description">{{ __('User Management') }}</div>
        </div>

        {{-- Total Transactions --}}
        <div class="stat-card">
            <div class="stat-icon stat-icon-green">
                <i class="fas fa-shopping-cart"></i>
            </div>
            <div class="stat-label">{{ __('Total Transactions') }}</div>
            <div class="stat-value">{{ $totalTransactions ?? 0 }}</div>
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

        {{-- Categories --}}
        <div class="stat-card">
            <div class="stat-icon stat-icon-pink">
                <i class="fas fa-layer-group"></i>
            </div>
            <div class="stat-label">{{ __('Category Management') }}</div>
            <div class="stat-value">
                <i class="fas fa-folder-open" style="font-size: 1.5rem;"></i>
            </div>
            <div class="stat-description">{{ __('Manage categories in the catalog.') }}</div>
        </div>
    </div>

    {{-- Management Cards --}}
    <div class="management-grid">
        {{-- About Us Management --}}
        <a href="{{ route('admin.about.edit') }}" class="management-card">
            <h3>
                <i class="fas fa-info-circle me-2" style="color: #667eea;"></i>
                {{ __('About Us Management') }}
            </h3>
            <p>{{ __("Update the content of the 'About Us' page.") }}</p>
        </a>

        {{-- Quick Actions --}}
    <div class="management-card" style="cursor: default;">
        <h3>
            <i class="fas fa-bolt me-2" style="color: #764ba2;"></i>
            {{-- Kunci diubah dari 'dashboard.quick_actions.title' --}}
            {{ __('Quick Actions') }}
        </h3>
        <div class="d-flex flex-wrap gap-3 mt-3">
            <a href="{{ route('admin.produk.index') }}" class="btn btn-primary px-4 py-2">
                <i class="fas fa-book me-2"></i>
                {{-- Kunci diubah dari 'dashboard.quick_actions.products' --}}
                {{ __('Products') }}
            </a>
            <a href="{{ route('admin.users.index') }}" class="btn btn-primary px-4 py-2">
                <i class="fas fa-users me-2"></i>
                {{-- Kunci diubah dari 'dashboard.quick_actions.users' --}}
                {{ __('Users') }}
            </a>
            <a href="{{ route('admin.transactions.index') }}" class="btn btn-primary px-4 py-2">
                <i class="fas fa-shopping-cart me-2"></i>
                {{-- Kunci diubah dari 'dashboard.quick_actions.transactions' --}}
                {{ __('Transactions') }}
            </a>
            <a href="{{ route('admin.kategori.index') }}" class="btn btn-primary px-4 py-2">
                <i class="fas fa-layer-group me-2"></i>
                {{-- Kunci diubah dari 'dashboard.quick_actions.categories' --}}
                {{ __('Categories') }}
            </a>
        </div>
    </div>
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