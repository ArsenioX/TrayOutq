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

        @media (max-width: 600px) {
            .dashboard-card {
                flex: 1 1 100%;
            }
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
            transition: background 0.3s;
        }

        .chat-button:hover {
            background-color: #0b5ed7;
        }
    </style>

    <div class="dashboard-container">
        <h1 class="dashboard-title">Welcome, Admin</h1>
        <p class="dashboard-subtitle">
            This is your professional dashboard. Manage users, view reports, and control the system.
        </p>

        <div class="dashboard-grid">
            {{-- System Logs --}}
            <div class="dashboard-card">
                <h2>System Logs</h2>
                <p>Review activity and system alerts.</p>
            </div>

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

            {{-- About Us --}}
            <a href="{{ route('admin.about') }}" class="dashboard-card">
                <h2>About Us</h2>
                <p>Information about this BookStore application.</p>
            </a>
        </div>
    </div>

    {{-- Floating Chat Button --}}
    <a href="{{ route('admin.chat') }}" class="chat-button" title="Chat">
        💬
    </a>
@endsection