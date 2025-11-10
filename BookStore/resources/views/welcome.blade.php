@extends('layouts.app')

@section('title', 'Selamat Datang di FlipBuku')

@section('content')

    <style>
        .hero-section-with-bg {
            background-image: url("{{ asset('images/banner-utama.jpg') }}");
            background-size: cover;
            background-position: center;
            position: relative;
            padding: 8rem 0;
        }

        .hero-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: rgba(0, 0, 0, 0.6);
            z-index: 1;
        }

        .hero-content {
            position: relative;
            z-index: 2;
        }
    </style>

    <div id="beranda" class="hero-section-with-bg text-white">
        <div class="hero-overlay"></div>
        <div class="container hero-content">
            <div class="row">
                <div class="col-lg-8 col-md-10 mx-auto text-center">
                    <h1 class="display-4 fw-bold">Jelajahi Dunia Literasi</h1>
                    <p class="lead my-4">Temukan lebih dari 50,000+ buku berkualitas tinggi dari berbagai kategori. Mulai
                        dari sejarah, sains, hingga sastra terbaik.</p>
                    <a href="{{ route('register') }}" class="btn btn-primary btn-lg">Mulai Jelajahi Sekarang</a>

                    {{-- Tombol "Lihat Kategori" sudah dihapus --}}

                </div>
            </div>
        </div>
    </div>

    <div class="container my-5">
        <div class="row g-4">
            <div class="col-lg-3 col-md-4 col-sm-6">
                <div class="card h-100 shadow-sm border-0 book-card">
                    <img src="https://via.placeholder.com/300x450/eeeeee/999999?text=Laskar+Pelangi" class="card-img-top"
                        alt="Sampul Buku">
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title">Laskar Pelangi</h5>
                        <h6 class="card-subtitle mt-1 mb-2 fw-bold text-primary">Rp 85.000</h6>
                        <a href="#" class="btn btn-outline-primary w-100 mt-auto">Lihat Detail</a>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-4 col-sm-6">
                <div class="card h-100 shadow-sm border-0 book-card">
                    <img src="https://via.placeholder.com/300x450/eeeeee/999999?text=Bung+Karno" class="card-img-top"
                        alt="Sampul Buku">
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title">Bung Karno</h5>
                        <h6 class="card-subtitle mt-1 mb-2 fw-bold text-primary">Rp 110.000</h6>
                        <a href="#" class="btn btn-outline-primary w-100 mt-auto">Lihat Detail</a>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-4 col-sm-6">
                <div class="card h-100 shadow-sm border-0 book-card">
                    <img src="https://via.placeholder.com/300x450/eeeeee/999999?text=Fisika+Kuantum" class="card-img-top"
                        alt="Sampul Buku">
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title">Fisika Kuantum</h5>
                        <h6 class="card-subtitle mt-1 mb-2 fw-bold text-primary">Rp 130.000</h6>
                        <a href="#" class="btn btn-outline-primary w-100 mt-auto">Lihat Detail</a>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-4 col-sm-6">
                <div class="card h-100 shadow-sm border-0 book-card">
                    <img src="https://via.placeholder.com/300x450/eeeeee/999999?text=Sejarah+Majapahit" class="card-img-top"
                        alt="Sampul Buku">
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title">Sejarah Majapahit</h5>
                        <h6 class="card-subtitle mt-1 mb-2 fw-bold text-primary">Rp 95.000</h6>
                        <a href="#" class="btn btn-outline-primary w-100 mt-auto">Lihat Detail</a>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <div id="tentang" class="container my-5"> {{-- ID diubah menjadi "tentang" --}}
        <div class="row">
            <div class="col-lg-8 mx-auto text-center">

                <h2 class="fw-bold mb-3">Lebih dari Sekadar Toko Buku</h2>

                <p class="lead text-muted mb-4">
                    <strong>FlipBuku</strong> lahir dari kecintaan yang mendalam terhadap literasi dan kekuatan sebuah
                    cerita. Kami percaya bahwa di setiap lembar halaman, ada dunia baru yang menunggu untuk dijelajahi, ada
                    pengetahuan yang siap mengubah pandangan, dan ada imajinasi yang tak terbatas.
                </p>

                <p class="text-muted">
                    Di era digital yang serba cepat ini, misi kami sederhana: menjadi jembatan terpercaya Anda menuju dunia
                    tersebut. Kami bukan sekadar penjual buku; kami adalah kurator, sahabat, dan komunitas Anda dalam
                    petualangan membaca. Proyek ini didedikasikan untuk Ujian Kompetensi, membuktikan bahwa teknologi dapat
                    menyebarkan gairah membaca dengan lebih luas.
                </p>

                <p class="lead text-dark fw-bold mt-4">
                    Selamat membalik halaman baru.
                </p>

            </div>
        </div>
    </div>
@endsection