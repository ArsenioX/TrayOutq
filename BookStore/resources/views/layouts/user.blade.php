<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-bs-theme="{{ session('theme', 'light') }}">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>BookStore - User</title>

    {{-- Script Pencegah Kedipan Dark Mode --}}
    <script>
        (function () {
            try {
                if (localStorage.getItem('theme') === 'dark' ||
                    (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
                    document.documentElement.classList.add('dark');
                    document.documentElement.setAttribute('data-bs-theme', 'dark');
                } else {
                    document.documentElement.classList.remove('dark');
                    document.documentElement.setAttribute('data-bs-theme', 'light');
                }
            } catch (_) { }
        })();
    </script>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    <style>
        /* ========== HOPE UI USER DESIGN - TOSCA GREEN THEME ========== */
        * {
            font-family: 'Poppins', sans-serif;
        }

        :root {
            --bg-gradient-start: #f0fdf4;
            --bg-gradient-end: #ecfeff;
            --text-color: #1e293b;
            --card-bg: #ffffff;
            --card-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            --primary-gradient: linear-gradient(135deg, #14b8a6 0%, #06b6d4 100%);
            --navbar-bg: linear-gradient(135deg, #14b8a6 0%, #06b6d4 100%);
            --navbar-shadow: 0 2px 8px rgba(20, 184, 166, 0.3);
        }

        html.dark {
            --bg-gradient-start: #0f172a;
            --bg-gradient-end: #1e293b;
            --text-color: #e2e8f0;
            --card-bg: #1e293b;
            --card-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.3), 0 2px 4px -1px rgba(0, 0, 0, 0.2);
            --navbar-bg: linear-gradient(135deg, #0f766e 0%, #0e7490 100%);
            --navbar-shadow: 0 2px 8px rgba(15, 118, 110, 0.5);
        }

        body {
            background: linear-gradient(135deg, var(--bg-gradient-start) 0%, var(--bg-gradient-end) 100%);
            min-height: 100vh;
            color: var(--text-color);
            padding-top: 80px;
        }

        /* ========== NAVBAR TOSCA-GREEN MODERN ========== */
        .navbar {
            background: var(--navbar-bg) !important;
            box-shadow: var(--navbar-shadow);
            backdrop-filter: blur(10px);
            padding: 1rem 0;
        }

        .navbar-brand {
            font-weight: 700;
            font-size: 1.4rem;
            color: white !important;
        }

        .navbar-brand:hover {
            color: #f0fdfa !important;
        }

        .navbar .btn-outline-light {
            border: 2px solid rgba(255, 255, 255, 0.3);
            color: white;
            border-radius: 10px;
            font-weight: 500;
        }

        .navbar .btn-outline-light:hover {
            background: rgba(255, 255, 255, 0.2);
            border-color: white;
        }

        .navbar .btn-primary {
            background: white;
            color: #14b8a6;
            border: none;
            border-radius: 10px;
            font-weight: 600;
        }

        .navbar .btn-primary:hover {
            background: #f0fdfa;
            color: #0f766e;
        }

        .dropdown-menu {
            border-radius: 12px;
            border: none;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
            background: var(--card-bg);
            padding: 0.5rem;
        }

        .dropdown-item {
            border-radius: 8px;
            padding: 0.6rem 1rem;
            color: var(--text-color);
        }

        .dropdown-item:hover {
            background: var(--primary-gradient);
            color: white;
        }

        /* ========== CARD STYLES ========== */
        html.dark .card {
            background-color: var(--card-bg);
            border-color: rgba(255, 255, 255, 0.1);
            box-shadow: var(--card-shadow);
        }

        html.dark .card h1,
        html.dark .card h2,
        html.dark .card h3,
        html.dark .card h4,
        html.dark .card h5,
        html.dark .card p,
        html.dark .card span,
        html.dark .card strong,
        html.dark .card .form-label,
        html.dark .card .form-check-label {
            color: var(--text-color);
        }

        html.dark .text-muted {
            color: #94a3b8 !important;
        }

        html.dark .dropdown-menu {
            background-color: var(--card-bg);
            border-color: rgba(255, 255, 255, 0.1);
        }

        html.dark .dropdown-item {
            color: var(--text-color);
        }

        html.dark .dropdown-item:hover {
            background: var(--primary-gradient);
            color: white;
        }

        html.dark .list-group-item {
            background-color: var(--card-bg) !important;
            color: var(--text-color);
            border-color: rgba(255, 255, 255, 0.1);
        }

        html.dark .list-group-item:hover {
            background-color: #334155 !important;
        }

        html.dark .alert-info {
            background-color: #0d6efd;
            color: white;
        }

        html.dark .alert-light {
            background-color: var(--card-bg);
            border-color: rgba(255, 255, 255, 0.1);
        }

        /* ========== CHAT BUTTON TOSCA ========== */
        .user-chat-button {
            position: fixed;
            bottom: 2rem;
            right: 2rem;
            width: 56px;
            height: 56px;
            background: var(--primary-gradient);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 8px 16px rgba(20, 184, 166, 0.4);
            z-index: 999;
            text-decoration: none;
            color: white;
            font-size: 24px;
        }

        .user-chat-button:hover {
            box-shadow: 0 12px 24px rgba(20, 184, 166, 0.6);
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
            background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
            border-radius: 50%;
            display: none;
            align-items: center;
            justify-content: center;
            border: 3px solid var(--card-bg);
        }
    </style>
</head>

<body>
    <div id="app">
        <nav class="navbar navbar-expand-lg fixed-top">
            <div class="container d-flex justify-content-between align-items-center py-2">

                <a href="{{ url('/user/dashboard') }}" class="navbar-brand fw-bold">
                    BookStore {{ Auth::user()->name }}
                </a>

                <div class="d-flex align-items-center gap-3">
                    {{-- Tombol Cart --}}
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

                    {{-- Tombol Riwayat --}}
                    <a href="{{ route('user.transactions') }}" class="btn btn-primary fw-semibold">
                        📦 {{ __('Transaction History') }}
                    </a>

                    {{-- Tombol Dark Mode --}}
                    @if (config('features.show_user_darkmode'))
                    <button id="theme-toggle-button" class="btn btn-outline-light" type="button"
                        title="Toggle dark mode">
                        <span id="theme-icon-sun">☀️</span>
                        <span id="theme-icon-moon" style="display: none;">🌙</span>
                    </button>
                    @endif

                    {{-- Dropdown Bahasa --}}
                    @if (config('features.show_user_translator'))
                    <div class="dropdown">
                        <button class="btn btn-outline-light dropdown-toggle" type="button" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            @if (App::getLocale() == 'id')
                                🇮🇩 ID
                            @else
                                🇬🇧 EN
                            @endif
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end mt-2">
                            <li>
                                <a class="dropdown-item" href="{{ route('lang.switch', 'id') }}">
                                    🇮🇩 Bahasa Indonesia
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="{{ route('lang.switch', 'en') }}">
                                    🇬🇧 English
                                </a>
                            </li>
                        </ul>
                    </div>
                    @endif

                    {{-- Dropdown Menu --}}
                    <div class="dropdown">
                        <button id="dropdownButton" class="btn btn-outline-light dropdown-toggle" type="button"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            ☰
                        </button>
                        <ul id="dropdownMenu" class="dropdown-menu dropdown-menu-end mt-2">
                            <li>
                                <a class="dropdown-item" href="{{ route('user.about') }}">{{ __('About Us') }}</a>
                            </li>
                            @if (config('features.show_user_wishlist'))
                            <li>
                                <a class="dropdown-item" href="{{ route('user.wishlist.index') }}">❤️
                                    {{ __('My Wishlist') }}</a>
                            </li>
                            @endif
                            <li>
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    {{ __('Logout') }}
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

        {{-- Tombol Chat --}}
        <a href="{{ route('user.chat') }}" class="user-chat-button" title="Chat Admin" id="user-chat-button">
            💬
            <span id="chat-notification-badge" class="chat-notification-badge"></span>
        </a>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

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
                        if (!response.ok) { throw new Error('Network response was not ok'); }
                        return response.json();
                    })
                    .then(data => {
                        const count = data.unread_count;
                        if (chatBadge) {
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
            fetchUnreadCount();
            setInterval(fetchUnreadCount, 15000);
        });
    </script>

    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init({
            duration: 800,
            once: true,
            offset: 50,
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    {{-- Script Fungsi Dark Mode --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const toggleButton = document.getElementById('theme-toggle-button');
            const sunIcon = document.getElementById('theme-icon-sun');
            const moonIcon = document.getElementById('theme-icon-moon');
            const htmlEl = document.documentElement;

            function updateIcons(isDarkMode) {
                if (isDarkMode) {
                    sunIcon.style.display = 'inline';
                    moonIcon.style.display = 'none';
                } else {
                    sunIcon.style.display = 'none';
                    moonIcon.style.display = 'inline';
                }
            }

            const isDark = htmlEl.classList.contains('dark');
            updateIcons(!isDark);

            if (toggleButton) {
                toggleButton.addEventListener('click', function () {
                    if (htmlEl.classList.contains('dark')) {
                        htmlEl.classList.remove('dark');
                        htmlEl.setAttribute('data-bs-theme', 'light');
                        localStorage.setItem('theme', 'light');
                        updateIcons(false);
                    } else {
                        htmlEl.classList.add('dark');
                        htmlEl.setAttribute('data-bs-theme', 'dark');
                        localStorage.setItem('theme', 'dark');
                        updateIcons(true);
                    }
                });
            }
        });
    </script>

    @stack('scripts')
</body>

</html>