@extends('layouts.user')

@section('content')
    <div class="p-6 bg-white rounded shadow">
        <h1 class="text-2xl font-bold mb-4">Tentang BookStore</h1>
        <p class="mb-4">
            Selamat datang di <strong>BookStore</strong> 🎉 Tempat terbaik untuk mencari, membeli, dan membaca buku favorit
            Anda.
        </p>

        <h2 class="text-xl font-semibold mt-6 mb-2">📚 Misi Kami</h2>
        <ul class="list-disc list-inside mb-4">
            <li>Menyediakan koleksi buku yang lengkap untuk semua kalangan.</li>
            <li>Memudahkan pengguna dalam membeli buku secara online.</li>
            <li>Mendukung pembelajaran dan literasi di era digital.</li>
        </ul>

        <h2 class="text-xl font-semibold mt-6 mb-2">📖 Koleksi Buku Favorit</h2>
        <div class="grid grid-cols-2 gap-4">
            <div class="text-center">
                <img src="{{ asset('images/book4.jpg') }}" alt="Book 4" class="w-full h-48 object-cover rounded shadow">
                <p class="mt-2 font-medium">Komik Anak</p>
            </div>
            <div class="text-center">
                <img src="{{ asset('images/book5.jpg') }}" alt="Book 5" class="w-full h-48 object-cover rounded shadow">
                <p class="mt-2 font-medium">Buku Edukasi</p>
            </div>
        </div>

        <h2 class="text-xl font-semibold mt-6 mb-2">✨ Kenapa Memilih BookStore?</h2>
        <ul class="list-disc list-inside">
            <li>Pilihan buku yang bervariasi, mulai dari fiksi hingga edukasi.</li>
            <li>Proses pembelian mudah dan cepat.</li>
            <li>Dapat diakses kapan saja dan di mana saja.</li>
        </ul>
    </div>
@endsection