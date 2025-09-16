@extends('layouts.admin')

@section('content')
    <div class="p-6 bg-white rounded shadow">
        <h1 class="text-2xl font-bold mb-4">Tentang BookStore (Admin)</h1>
        <p class="mb-4">
            Halaman ini dibuat khusus untuk <strong>Admin</strong> agar bisa mengelola informasi aplikasi BookStore.
            Anda dapat menambahkan atau mengedit konten tentang aplikasi sesuai kebutuhan.
        </p>

        <h2 class="text-xl font-semibold mt-6 mb-2">📌 Misi Kami</h2>
        <ul class="list-disc list-inside mb-4">
            <li>Menyediakan pengalaman belanja buku yang mudah dikelola oleh admin.</li>
            <li>Memastikan koleksi buku selalu ter-update.</li>
            <li>Memberikan data transaksi yang jelas dan aman.</li>
        </ul>

        <h2 class="text-xl font-semibold mt-6 mb-2">📖 Koleksi Buku Populer</h2>
        <div class="grid grid-cols-3 gap-4">
            <div class="text-center">
                <img src="{{ asset('images/book1.jpg') }}" alt="Book 1" class="w-full h-40 object-cover rounded shadow">
                <p class="mt-2 font-medium">Buku Manajemen</p>
            </div>
            <div class="text-center">
                <img src="{{ asset('images/book2.jpg') }}" alt="Book 2" class="w-full h-40 object-cover rounded shadow">
                <p class="mt-2 font-medium">Buku Pemrograman</p>
            </div>
            <div class="text-center">
                <img src="{{ asset('images/book3.jpg') }}" alt="Book 3" class="w-full h-40 object-cover rounded shadow">
                <p class="mt-2 font-medium">Novel Fiksi</p>
            </div>
        </div>
    </div>
@endsection