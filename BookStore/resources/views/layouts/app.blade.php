<!DOCTYPE html>
<html lang="id" style="scroll-behavior: smooth;">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title', 'FlipBuku')</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        /* Style tambahan agar lebih rapi */
        .book-card {
            transition: all 0.2s ease-in-out;
        }

        .book-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.08) !important;
        }

        .category-card {
            transition: all 0.2s ease-in-out;
        }

        .category-card:hover {
            background-color: #f8f9fa;
        }
    </style>
</head>

<body class="bg-light">

    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm sticky-top border-bottom">
        <div class="container">

            <a class="navbar-brand fw-bold fs-4" href="/">FlipBuku</a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#main-nav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="main-nav">

                <ul class="navbar-nav mx-auto">
                    <li class="nav-item">
                        <a class="nav-link active" href="#beranda">BERANDA</a>
                    </li>
                    <li class="nav-item">
                        {{-- Link 'KATEGORI' diganti menjadi 'TENTANG' --}}
                        <a class="nav-link" href="#tentang">TENTANG</a>
                    </li>
                    {{-- Link 'TENTANG' yang lama dihapus --}}
                </ul>
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">
                            <i class="bi bi-cart"></i> Keranjang
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">Masuk</a>
                    </li>
                    <li class="nav-item">
                        <a class="btn btn-primary btn-sm ms-2" href="{{ route('register') }}">Daftar</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <main>
        @yield('content')
    </main>

    {{-- id="tentang" dihapus dari footer --}}
    <footer class="container text-center text-muted py-4 mt-5 border-top">
        <p class="mb-1">&copy; 2025 FlipBuku.</p>
        <p class="mb-0 small">Dibuat untuk Ujian Kompetensi Keahlian.</p>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>