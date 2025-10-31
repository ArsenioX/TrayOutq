<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>BookStore - User</title>

    <link href="https://fonts.bunny.net/css?family=Nunito:400,600,700&display=swap" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            font-family: 'Nunito', sans-serif;
            background-color: #f5f5f5;
            color: #212529;
        }

        .navbar-brand:hover {
            color: #6366f1 !important;
        }

        .dropdown-menu.show {
            display: block;
        }

        /* ▼▼▼ CSS BARU UNTUK TOMBOL CHAT & NOTIFIKASI ▼▼▼ */
        .user-chat-button {
            position: fixed;
            bottom: 2rem;
            right: 2rem;
            width: 56px;
            height: 56px;
            background-color: #0d6efd;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            z-index: 999;
            transition: background-color 0.3s;
            text-decoration: none;
            color: white;
            font-size: 24px;
        }

        .user-chat-button:hover {
            background-color: #0b5ed7;
            color: white;
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
            background-color: #d33;
            /* Merah */
            border-radius: 50%;
            display: none;
            /* Sembunyi secara default */
            align-items: center;
            justify-content: center;
            border: 2px solid white;
        }

        /* ▲▲▲ AKHIR CSS BARU ▲▲▲ */
    </style>
</head>

<body>
    <div id="app">
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top shadow">
            {{-- ... (Isi Navbar Anda tidak berubah) ... --}}
            <div class="container d-flex justify-content-between align-items-center py-2">
                <a href="{{ url('/user/dashboard') }}" class="navbar-brand fw-bold">
                    BookStore {{ Auth::user()->name }}
                </a>
                <div class="d-flex align-items-center gap-3">
                    <a href="{{ route('cart.index') }}" class="btn btn-outline-light position-relative">
                        🛒
                        @php
                            $cartCount = \App\Models\Cart::where('user_id', Auth::id())->count();
                        @endphp
                        @if ($cartCount > 0)
                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                {{ $cartCount }}
                            </span>
                        @endif
                    </a>
                    <a href="{{ route('user.transactions') }}" class="btn btn-primary fw-semibold">
                        📦 Riwayat Transaksi
                    </a>
                    <div class="dropdown">
                        <button id="dropdownButton" class="btn btn-outline-light dropdown-toggle" type="button"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            ☰
                        </button>
                        <ul id="dropdownMenu" class="dropdown-menu dropdown-menu-end mt-2">
                            <li>
                                <a class="dropdown-item" href="{{ route('user.about') }}">About Us</a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    Logout
                                </a>
                            </li>
                        </ul>
                    </div>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </div>
            </div>
        </nav>

        <main class="container pt-5 mt-5 mb-4">
            @yield('content')
        </main>

        {{-- ▼▼▼ HTML UNTUK TOMBOL CHAT DITEMPEL DI SINI ▼▼▼ --}}
        <a href="{{ route('user.chat') }}" class="user-chat-button" title="Chat Admin" id="user-chat-button">
            💬
            {{-- Tempat untuk angka notifikasi --}}
            <span id="chat-notification-badge" class="chat-notification-badge"></span>
        </a>
        {{-- ▲▲▲ AKHIR HTML TOMBOL CHAT ▲▲▲ --}}

    </div> {{-- <-- Penutup div #app --}} <script
        src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

        {{-- ▼▼▼ SCRIPT BARU UNTUK NOTIFIKASI DITAMBAHKAN DI SINI ▼▼▼ --}}
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                // Ambil elemen badge notifikasi
                const chatBadge = document.getElementById('chat-notification-badge');

                // Buat fungsi untuk mengecek pesan baru
                function fetchUnreadCount() {
                    // Pastikan route 'chat.unreadCount' sudah ada di web.php
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
                            if (chatBadge) { // Cek jika elemennya ada
                                if (count > 0) {
                                    chatBadge.style.display = 'flex';
                                    chatBadge.textContent = count;
                                } else {
                                    chatBadge.style.display = 'none';
                                }
                            }
                        })
                        .catch(error => {
                            console.error('Error fetching unread chat count:', error);
                        });
                }

                // 1. Jalankan fungsi ini 1x saat halaman pertama kali dimuat
                fetchUnreadCount();
                // 2. Jalankan fungsi ini lagi setiap 15 detik
                setInterval(fetchUnreadCount, 15000);
            });
        </script>
        {{-- ▲▲▲ AKHIR SCRIPT BARU ▲▲▲ --}}

        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</body>

</html>