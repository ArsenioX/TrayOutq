@extends('layouts.admin')

@section('content')
    <style>
        .dashboard-container {
            background: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            max-width: 900px;
            margin: 50px auto;
            padding: 30px;
            border-radius: 8px;
            font-family: 'Segoe UI', sans-serif;
        }

        /* ... (CSS .dashboard-title, .dashboard-subtitle, .dashboard-grid Anda tidak berubah) ... */
        .dashboard-title {
            font-size: 28px;
            font-weight: bold;
            color: #333;
            margin-bottom: 10px;
        }

        .dashboard-subtitle {
            color: #666;
            font-size: 16px;
            margin-bottom: 30px;
        }

        .dashboard-grid {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
        }

        .dashboard-card {
            flex: 1 1 calc(50% - 20px);
            background: #f0f0f0;
            border-radius: 6px;
            padding: 20px;
            text-decoration: none;
            color: #333;
            transition: background 0.3s;
        }

        .dashboard-card:hover {
            background: #e0e0e0;
        }

        .dashboard-card h2 {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 5px;
        }

        .dashboard-card p {
            font-size: 14px;
            color: #555;
        }

        /* Ini adalah CSS @media (responsif) Anda yang lama */
        @media (max-width: 600px) {
            .dashboard-card {
                flex: 1 1 100%;
            }

            /* ▼▼▼ PERMINTAAN "RESPONSIF CHAT" DITAMBAHKAN DI SINI ▼▼▼ */
            .chat-button {
                /* Buat tombol lebih kecil & lebih mepet di HP */
                width: 50px;
                height: 50px;
                right: 15px;
                bottom: 15px;
                font-size: 20px;
            }

            /* ▲▲▲ AKHIR CSS RESPONSIF ▲▲▲ */
        }

        .chat-button {
            position: fixed;
            bottom: 30px;
            right: 30px;
            background-color: #0d6efd;
            color: white;
            border: none;
            border-radius: 50%;
            width: 60px;
            height: 60px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            z-index: 999;
            transition: background 0.3s, width 0.3s, height 0.3s;
            /* <-- transisi ditambahkan */
            position: relative;
        }

        .chat-button:hover {
            background-color: #0b5ed7;
        }

        /* CSS Notifikasi (dari sebelumnya) */
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
            background-color: #d33;
            border-radius: 50%;
            display: none;
            align-items: center;
            justify-content: center;
            border: 2px solid white;
        }
    </style>

    {{-- Ini adalah HTML container asli Anda --}}
    <div class="dashboard-container">
        <h1 class="dashboard-title">Welcome, Admin</h1>
        <p class="dashboard-subtitle">
            This is your professional dashboard. Manage users, view reports, and control the system.
        </p>

        {{-- Ini adalah HTML grid asli Anda --}}
        <div class="dashboard-grid">
            {{-- Product Management --}}
            <a href="{{ route('admin.produk.index') }}" class="dashboard-card">
                <h2>Product Management</h2>
                <p>Manage products in the catalog.</p>
            </a>

            {{-- Category Management --}}
            <a href="{{ route('admin.kategori.index') }}" class="dashboard-card">
                <h2>Category Management</h2>
                <p>Manage categories in the catalog.</p>
            </a>

            {{-- User Management --}}
            <a href="{{ route('admin.users.index') }}" class="dashboard-card">
                <h2>User Management</h2>
                <p>Add, edit, or remove users.</p>
            </a>

            {{-- Transaction Management --}}
            <a href="{{ route('admin.transactions.index') }}" class="dashboard-card">
                <h2>Transaction Management</h2>
                <p>
                    View and confirm user transactions.<br>
                    @isset($pendingTransactionsCount)
                        @if ($pendingTransactionsCount > 0)
                            <strong style="color: red;">🕒 {{ $pendingTransactionsCount }} pending</strong>
                        @else
                            ✅ No pending transactions
                        @endif
                    @else
                        <em>Pending count not available</em>
                    @endisset
                </p>
            </a>

            {{-- About Us Management --}}
            <a href="{{ route('admin.about.edit') }}" class="dashboard-card">
                <h2>About Us Management</h2>
                <p>Update the content of the 'About Us' page.</p>
            </a>
        </div>
    </div>

    {{-- Tombol Chat (dari sebelumnya) --}}
    <a href="{{ route('admin.chat') }}" class="chat-button" title="Chat" id="admin-chat-button">
        💬
        <span id="chat-notification-badge" class="chat-notification-badge"></span>
    </a>

    {{-- Script Notifikasi (dari sebelumnya) --}}
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
                        if (chatBadge && count > 0) { // Saya tambahkan cek 'if (chatBadge)'
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