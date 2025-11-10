@extends('layouts.user')

@section('content')
    <div class="container mt-5 mb-5">

        {{-- =================================== --}}
        {{-- 1. BAGIAN STATIS --}}
        {{-- =================================== --}}
        <h1 class="text-center fw-bold mb-4">
            {{-- DITERJEMAHKAN (Fallback-nya) --}}
            {{ $about->title ?? __('Nama Toko Belum Diatur') }}
        </h1>

        @if ($about->main_image)
            <div class="d-flex justify-content-center mb-4">
                {{-- DITERJEMAHKAN (Alt text) --}}
                <img src="{{ Storage::url($about->main_image) }}" alt="{{ __('Foto') }} {{ $about->title }}"
                    class="img-fluid rounded shadow" style="width: 27%; height: 250px; object-fit: cover; ">
            </div>
        @else
            <div class="d-flex align-items-center justify-content-center bg-light rounded mb-4" style="height: 250px;">
                {{-- DITERJEMAHKAN --}}
                <span class="text-muted">{{ __('Foto gedung belum di-upload') }}</span>
            </div>
        @endif


        {{-- =================================== --}}
        {{-- 2. BAGIAN NARASI (Teks dari DB, tidak diubah) --}}
        {{-- =================================== --}}
        <div class="mb-5">
            <div id="narrative-content" class="position-relative overflow-hidden"
                style="max-height: 150px; transition: max-height 0.4s ease;">

                <p class="fs-5 text-secondary">
                    {!! nl2br(e($about->narrative)) !!}
                </p>

                <div id="narrative-fade" class="position-absolute bottom-0 start-0 w-100"
                    style="height: 80px; background: linear-gradient(to top, white, transparent);">
                </div>
            </div>

            <div class="text-center mt-2">
                <button id="narrative-toggle" class="btn btn-link fw-bold text-decoration-none text-primary">
                    {{-- DITERJEMAHKAN --}}
                    {{ __('Read more...') }}
                </button>
            </div>
        </div>


        {{-- =================================== --}}
        {{-- 3. BAGIAN PRODUK --}}
        {{-- =================================== --}}
        {{-- DITERJEMAHKAN --}}
        <h2 class="fw-bold mb-4">{{ __('Produk Toko Kami') }}</h2>

        @if ($products->isEmpty())
            {{-- DITERJEMAHKAN --}}
            <p class="text-muted">{{ __('Belum ada produk untuk ditampilkan.') }}</p>
        @else
            <div class="row g-4">
                @foreach ($products as $product)
                    <div class="col-6 col-md-4 col-lg-2">
                        <div class="card h-100 shadow-sm border-0">
                            <img src="{{ Storage::url($product->foto) }}" alt="{{ $product->nama }}" class="card-img-top"
                                style="height: 180px; object-fit: cover;">
                            <div class="card-body text-center">
                                <h5 class="card-title text-truncate mb-0">{{ $product->nama }}</h5>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-4">
                {{ $products->links() }}
            </div>
        @endif

    </div> {{-- akhir .container --}}

    {{-- =================================== --}}
    {{-- 4. SCRIPT TOGGLE (Logika tidak diubah) --}}
    {{-- =================================== --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const content = document.getElementById('narrative-content');
            const fade = document.getElementById('narrative-fade');
            const toggleButton = document.getElementById('narrative-toggle');

            if (content && fade && toggleButton) {
                const collapsedHeight = '150px';
                let isExpanded = false;

                // Jika teks pendek, sembunyikan tombol
                if (content.scrollHeight <= content.clientHeight) {
                    toggleButton.style.display = 'none';
                    fade.style.display = 'none';
                    content.style.maxHeight = 'none';
                } else {
                    toggleButton.addEventListener('click', function () {
                        if (!isExpanded) {
                            // Buka
                            content.style.maxHeight = 'none';
                            fade.style.display = 'none';
                            // { { --DITERJEMAHKAN --} }
                            toggleButton.innerText = '{{ __('Read less...') }}';
                            isExpanded = true;
                        } else {
                            // Tutup
                            content.style.maxHeight = collapsedHeight;
                            fade.style.display = 'block';
                            // { { --DITERJEMAHKAN --} }
                            toggleButton.innerText = '{{ __('Read more...') }}';
                            isExpanded = false;
                        }
                    });
                }
            }
        });
    </script>
@endsection