{{--
File: resources/views/user/product-detail.blade.php
--}}
@extends('layouts.user') {{-- <-- Sesuaikan layout user Anda --}} @section('content') <div class="container mx-auto p-4">

    {{-- DIUBAH: Sesuai screenshot 'produks' Anda --}}
    <h1 class="text-3xl font-bold mb-4">{{ $product->nama }}</h1>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">

        <div>
            {{-- DIUBAH: Sesuai screenshot 'produks' Anda --}}
            <img src="{{ Storage::url($product->foto) }}" alt="{{ $product->nama }}"
                class="w-full rounded-lg shadow-md object-cover">
        </div>

        <div>
            {{-- BENAR: 'harga' sudah sesuai screenshot --}}
            <div class="mb-4">
                <span class="text-3xl font-bold text-indigo-600">Rp
                    {{ number_format($product->harga, 0, ',', '.') }}</span>
            </div>

            {{-- BENAR: 'deskripsi' sudah sesuai screenshot --}}
            <h2 class="text-2xl font-bold">Deskripsi Produk</h2>
            <p class="text-gray-700 mt-2 mb-6">{{ $product->deskripsi }}</p>

            {{-- Ini sudah benar, karena route 'user.cart.add' ada di web.php Anda --}}
            <form action="{{ route('user.cart.add', $product->id) }}" method="POST" class="mt-4">
                @csrf
                <button type="submit"
                    class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-3 rounded-lg font-medium shadow-lg">
                    + Tambah ke Keranjang
                </button>
            </form>
        </div>
    </div>
    </div>
@endsection