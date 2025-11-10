<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-bs-theme="{{ session('theme', 'light') }}">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>BookStore - Admin</title>

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

    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">

    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" />

    <style>
        /* ========== HOPE UI MODERN DESIGN ========== */
        * {
            font-family: 'Poppins', sans-serif;
        }

        :root {
            --bg-gradient-start: #f0f4ff;
            --bg-gradient-end: #faf5ff;
            --text-color: #1e293b;
            --card-bg: #ffffff;
            --card-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            --navbar-bg: #ffffff;
            --navbar-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }

        html.dark {
            --bg-gradient-start: #0f172a;
            --bg-gradient-end: #1e1b4b;
            --text-color: #e2e8f0;
            --card-bg: #1e293b;
            --card-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.3), 0 2px 4px -1px rgba(0, 0, 0, 0.2);
            --navbar-bg: #1e293b;
            --navbar-shadow: 0 1px 3px rgba(0, 0, 0, 0.3);
        }

        body {
            background: linear-gradient(135deg, var(--bg-gradient-start) 0%, var(--bg-gradient-end) 100%);
            min-height: 100vh;
            color: var(--text-color);
            padding-top: 80px;
            transition: all 0.3s ease;
        }

        /* ========== NAVBAR MODERN ========== */
        .navbar {
            background: var(--navbar-bg) !important;
            box-shadow: var(--navbar-shadow);
            backdrop-filter: blur(10px);
            padding: 1rem 0;
            transition: all 0.3s ease;
        }

        .navbar-brand {
            font-weight: 700;
            font-size: 1.4rem;
            background: var(--primary-gradient);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .navbar .nav-link,
        .navbar .dropdown-toggle {
            color: var(--text-color) !important;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .navbar .btn-outline-light {
            border: 2px solid #e2e8f0;
            color: var(--text-color);
            border-radius: 10px;
            transition: all 0.3s ease;
        }

        html.dark .navbar .btn-outline-light {
            border-color: #475569;
        }

        .navbar .btn-outline-light:hover {
            background: var(--primary-gradient);
            border-color: transparent;
            color: white;
            transform: translateY(-2px);
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
            transition: all 0.3s ease;
            color: var(--text-color);
        }

        .dropdown-item:hover {
            background: var(--primary-gradient);
            color: white;
            transform: translateX(5px);
        }

        /* ========== HAMBURGER MODERN ========== */
        .navbar-toggler-icon-custom {
            cursor: pointer;
            width: 25px;
            height: 20px;
            display: inline-block;
            position: relative;
        }

        .navbar-toggler-icon-custom span {
            background: var(--text-color);
            position: absolute;
            height: 3px;
            width: 100%;
            left: 0;
            transition: 0.3s;
            border-radius: 2px;
        }

        .navbar-toggler-icon-custom span:nth-child(1) {
            top: 0;
        }

        .navbar-toggler-icon-custom span:nth-child(2) {
            top: 8px;
        }

        .navbar-toggler-icon-custom span:nth-child(3) {
            top: 16px;
        }

        /* ========== DARK MODE COMPATIBILITY ========== */
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
        html.dark .card small,
        html.dark .card strong,
        html.dark .card em,
        html.dark .card .form-label,
        html.dark .card .form-check-label {
            color: var(--text-color);
        }

        html.dark .card .text-muted {
            color: #94a3b8 !important;
        }

        html.dark .table {
            color: var(--text-color);
            border-color: rgba(255, 255, 255, 0.1);
        }

        html.dark .table-hover>tbody>tr:hover>* {
            color: var(--text-color);
            background-color: #334155;
        }

        /* ========== SMOOTH ANIMATIONS ========== */
        * {
            transition: background-color 0.3s ease, color 0.3s ease;
        }
    </style>
</head>

<body>
    <div id="app">
        <nav class="navbar navbar-expand-md fixed-top">
            <div class="container d-flex justify-content-between align-items-center">
                <a class="navbar-brand fw-bold" href="{{ url('/admin/dashboard') }}">
                    {{ Auth::user()->name }} (Admin)
                </a>

                <div class="d-flex align-items-center gap-3">

           @if (config('features.show_darkmode'))
                    
                    {{-- Tombol Dark Mode (CHALLENGE) --}}
                    <button id="theme-toggle-button" class="btn btn-outline-light" type="button"
                        title="Toggle dark mode">
                        <span id="theme-icon-sun">☀️</span>
                        <span id="theme-icon-moon" style="display: none;">🌙</span>
                    </button>

                @endif

                {{-- Dropdown Bahasa (CHALLENGE) --}}
            @if (config('features.show_translator'))

                {{-- Dropdown Bahasa (CHALLENGE) --}}
                <div class="dropdown">
                    <button class="btn btn-outline-light dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
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

                    {{-- Menu Dropdown --}}
                    <div class="dropdown">
                        <a class="nav-link dropdown-toggle navbar-toggler-icon-custom" href="#" id="dropdownMenuButton"
                            role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <span></span>
                            <span></span>
                            <span></span>
                        </a>

                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton">
                            <li>
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    {{ __('Logout') }}
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>

                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            </div>
        </nav>

        <main class="container py-4">
            @yield('content')
        </main>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    {{-- Script Dark Mode --}}
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

            const isDark = htmlEl.getAttribute('data-bs-theme') === 'dark';
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