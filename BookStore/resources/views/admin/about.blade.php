@extends('layouts.admin')

@section('content')
    <div class="container mx-auto p-4">
        <h1 class="text-2xl font-bold mb-4">Edit Halaman About Us</h1>

        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4">
                {{ session('success') }}
            </div>
        @endif

        <div class="bg-blue-100 border border-blue-400 text-blue-700 px-4 py-3 rounded relative mb-4">
            <strong>Info:</strong> Bagian "Produk Toko Kami" di-update secara otomatis berdasarkan produk terbaru. Anda
            tidak perlu mengaturnya di sini.
        </div>

        <form action="{{ route('admin.about.update') }}" method="POST" enctype="multipart/form-data"
            class="bg-white p-6 rounded shadow-md space-y-6">
            @csrf
            @method('PUT')

            {{-- Input Nama Toko --}}
            <div class="mb-4">
                <label for="title" class="block text-sm font-medium text-gray-700">Nama Toko</label>
                <input type="text" name="title" id="title" value="{{ old('title', $about->title) }}"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" placeholder="Contoh: Gramedia">
            </div>

            {{-- Upload Foto Gedung --}}
            <div class="mb-4 p-4 border rounded-md">
                <label for="main_image" class="block text-sm font-medium text-gray-700">Foto Gedung</label>
                <input type="file" name="main_image" id="main_image"
                    class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">

                @if ($about->main_image)
                    <div class="mt-4">
                        <p class="text-sm text-gray-600">Gambar saat ini:</p>
                        <img src="{{ Storage::url($about->main_image) }}" alt="Foto Gedung"
                            class="mt-2 w-auto h-40 rounded-md object-cover">
                        <div class="mt-2 flex items-center">
                            <input type="checkbox" name="delete_main_image" id="delete_main_image" value="1"
                                class="h-4 w-4 text-red-600 border-gray-300 rounded focus:ring-red-500">
                            <label for="delete_main_image" class="ml-2 block text-sm text-red-700">Centang untuk hapus
                                gambar</label>
                        </div>
                    </div>
                @endif
            </div>

            {{-- Textarea untuk Narasi --}}
            <div class="mb-4">
                <label for="narrative" class="block text-sm font-medium text-gray-700">Narasi (Minimal 5 Kalimat)</label>
                <textarea name="narrative" id="narrative" rows="7"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                    placeholder="Tulis narasi tentang toko Anda di sini...">{{ old('narrative', $about->narrative) }}</textarea>
            </div>

            <button type="submit"
                class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg font-medium shadow">
                Simpan Perubahan
            </button>
        </form>
    </div>
@endsection