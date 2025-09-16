<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

<title>BookStore - User</title>


    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])

    <style>
        body {
            padding-top: 70px;
        }

        .navbar {
            background-color: #000 !important;
        }

        .navbar .nav-link,
        .navbar .navbar-brand,
        .navbar .dropdown-toggle {
            color: #fff !important;
        }

        .navbar-toggler-icon-custom {
            cursor: pointer;
            width: 25px;
            height: 20px;
            display: inline-block;
            position: relative;
        }

        .navbar-toggler-icon-custom span {
            background: white;
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
    </style>
</head>

<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-dark fixed-top shadow-sm">
            <div class="container d-flex justify-content-between align-items-center">
                <!-- Brand -->
                <a class="navbar-brand fw-bold" href="{{ url('/user/dashboard') }}">
                    {{ Auth::user()->name }}
                </a>

                <!-- Tombol kanan -->
                <div class="d-flex align-items-center gap-3">

                    <!-- Cart -->
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

                    <!-- Riwayat Transaksi -->
                    <a href="{{ route('user.transactions') }}" class="btn btn-primary">
                        📦 Riwayat Transaksi
                    </a>

                    <!-- Dropdown Menu -->
                    <div class="dropdown">
                        <a class="nav-link dropdown-toggle navbar-toggler-icon-custom" href="#" id="dropdownMenuButton"
                            role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <span></span>
                            <span></span>
                            <span></span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton">
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

                    <!-- Logout Form -->
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </div>
            </div>
        </nav>

        <main class="container py-4">
            @yield('content')
        </main>
    </div>
</body>

</html>