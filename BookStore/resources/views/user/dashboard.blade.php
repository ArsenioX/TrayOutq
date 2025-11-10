@extends('layouts.user')

@section('content')

    <style>
        /* ========== HOPE UI USER DASHBOARD - PRODUCT CARDS ========== */

        .star-rating-display-small {
            color: #facc15;
            font-size: 0.9rem;
            letter-spacing: 0.5px;
        }
        .star-rating-display-small .star-empty {
            color: #ddd;
        }

        .search-suggestions-wrapper {
            position: relative;
        }
        .search-suggestions {
            position: absolute;
            top: 100%;
            left: 0;
            z-index: 1000;
            width: 100%;
            max-height: 300px;
            overflow-y: auto;
            border: 1px solid #dee2e6;
            border-top: none;
            border-radius: 0 0 .375rem .375rem;
            box-shadow: 0 .5rem 1rem rgba(0,0,0,.15);
            display: none;
        }
        .suggestion-item {
            display: flex;
            align-items: center;
        }
        .suggestion-item img {
            width: 40px;
            height: 40px;
            object-fit: cover;
            border-radius: .25rem;
            margin-right: 0.75rem;
        }

        /* ========== WELCOME CARD ========== */
        .welcome-card {
            background: var(--card-bg);
            border-radius: 16px;
            padding: 1.5rem;
            box-shadow: var(--card-shadow);
            border: 1px solid rgba(226, 232, 240, 0.8);
            margin-bottom: 1.5rem;
        }

        html.dark .welcome-card {
            border-color: rgba(71, 85, 105, 0.5);
        }

        .welcome-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--text-color);
            margin-bottom: 0.5rem;
        }

        .welcome-subtitle {
            color: #64748b;
            font-size: 1rem;
            margin-bottom: 0;
        }

        html.dark .welcome-subtitle {
            color: #94a3b8;
        }

        /* ========== FILTER CARD ========== */
        .filter-card {
            background: var(--card-bg);
            border-radius: 16px;
            padding: 1.5rem;
            box-shadow: var(--card-shadow);
            border: 1px solid rgba(226, 232, 240, 0.8);
            margin-bottom: 2rem;
        }

        html.dark .filter-card {
            border-color: rgba(71, 85, 105, 0.5);
        }

        .filter-title {
            font-size: 1.25rem;
            font-weight: 600;
            color: var(--text-color);
            margin-bottom: 1.5rem;
        }

        /* ========== PRODUCT CARD MODERN ========== */
        .product-card {
            background: var(--card-bg);
            border-radius: 16px;
            overflow: hidden;
            box-shadow: var(--card-shadow);
            border: 1px solid rgba(226, 232, 240, 0.8);
            height: 100%;
            display: flex;
            flex-direction: column;
        }

        html.dark .product-card {
            border-color: rgba(71, 85, 105, 0.5);
        }

        .product-card:hover {
            box-shadow: 0 12px 24px -4px rgba(0, 0, 0, 0.15);
        }

        .product-image-wrapper {
            position: relative;
            overflow: hidden;
            background: #f8fafc;
        }

        html.dark .product-image-wrapper {
            background: #0f172a;
        }

        .product-image {
            width: 100%;
            height: 280px;
            object-fit: cover;
            display: block;
        }

        .product-image:hover {
            transform: scale(1.05);
        }

        .wishlist-badge {
            position: absolute;
            top: 12px;
            right: 12px;
            width: 36px;
            height: 36px;
            background: rgba(255, 255, 255, 0.95);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
            cursor: pointer;
            border: none;
        }

        html.dark .wishlist-badge {
            background: rgba(30, 41, 59, 0.95);
        }

        .wishlist-badge:hover {
            transform: scale(1.1);
        }

        .product-body {
            padding: 1.25rem;
            display: flex;
            flex-direction: column;
            flex-grow: 1;
        }

        .product-category {
            font-size: 0.875rem;
            color: #14b8a6;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 0.5rem;
        }

        html.dark .product-category {
            color: #5eead4;
        }

        .product-title {
            font-size: 1rem;
            font-weight: 600;
            color: var(--text-color);
            margin-bottom: 0.75rem;
            line-height: 1.4;
            height: 2.8em;
            overflow: hidden;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
        }

        .product-price {
            font-size: 1.25rem;
            font-weight: 700;
            background: linear-gradient(135deg, #14b8a6 0%, #06b6d4 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 0.75rem;
        }

        .product-rating {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            margin-bottom: 0.75rem;
        }

        .stock-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.4rem 0.8rem;
            border-radius: 8px;
            font-size: 0.875rem;
            font-weight: 600;
            margin-bottom: 0.75rem;
        }

        .stock-available {
            background: #f0fdf4;
            color: #16a34a;
        }

        html.dark .stock-available {
            background: rgba(22, 163, 74, 0.2);
            color: #86efac;
        }

        .stock-out {
            background: #fef2f2;
            color: #dc2626;
        }

        html.dark .stock-out {
            background: rgba(220, 38, 38, 0.2);
            color: #fca5a5;
        }

        .product-review {
            background: #f8fafc;
            border-radius: 12px;
            padding: 0.875rem;
            margin-bottom: 1rem;
            font-size: 0.875rem;
        }

        html.dark .product-review {
            background: #0f172a;
        }

        .review-avatar {
            width: 28px;
            height: 28px;
            border-radius: 50%;
            background: linear-gradient(135deg, #14b8a6 0%, #06b6d4 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
            font-size: 0.75rem;
        }

        .product-actions {
            margin-top: auto;
            display: flex;
            gap: 0.75rem;
            padding-top: 1rem;
            border-top: 1px solid #f1f5f9;
        }

        html.dark .product-actions {
            border-top-color: #334155;
        }

        .btn-add-cart {
            flex-grow: 1;
            background: linear-gradient(135deg, #14b8a6 0%, #06b6d4 100%);
            border: none;
            color: white;
            font-weight: 600;
            padding: 0.75rem 1.5rem;
            border-radius: 10px;
        }

        .btn-add-cart:hover {
            box-shadow: 0 8px 16px rgba(20, 184, 166, 0.3);
            color: white;
        }

        .btn-add-cart:disabled {
            background: #e2e8f0;
            color: #94a3b8;
            cursor: not-allowed;
        }

        html.dark .btn-add-cart:disabled {
            background: #334155;
            color: #64748b;
        }

        .btn-wishlist {
            width: 48px;
            height: 48px;
            border: 2px solid #f1f5f9;
            background: white;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.25rem;
        }

        html.dark .btn-wishlist {
            background: var(--card-bg);
            border-color: #334155;
        }

        .btn-wishlist:hover {
            border-color: #ef4444;
            background: #fef2f2;
        }

        html.dark .btn-wishlist:hover {
            background: rgba(239, 68, 68, 0.2);
        }

        /* ========== EMPTY STATE ========== */
        .empty-state {
            text-align: center;
            padding: 4rem 2rem;
            color: #94a3b8;
        }

        .empty-state i {
            font-size: 4rem;
            margin-bottom: 1rem;
            opacity: 0.5;
        }

        /* ========== RESPONSIVE ========== */
        @media (max-width: 768px) {
            .product-image {
                height: 220px;
            }

            .welcome-title {
                font-size: 1.25rem;
            }

            .filter-card {
                padding: 1rem;
            }
        }
    </style>

    <div class="p-4">

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        {{-- Welcome Card --}}
        <div class="welcome-card">
            <h1 class="welcome-title">{{ __('Welcome to your Dashboard') }}</h1>
            <p class="welcome-subtitle">{{ __('See your activity and available products.') }}</p>
        </div>

        {{-- Filter Card --}}
        <div class="filter-card">
            <h2 class="filter-title">🛒 {{ __('Product List') }}</h2>

            <form method="GET" action="{{ route('user.dashboard') }}" class="d-flex flex-column flex-md-row gap-2">

                {{-- Search Bar --}}
                <div class="search-suggestions-wrapper position-relative flex-grow-1">
                    <input type="text" name="search" placeholder="{{ __('Search products...') }}" 
                           value="{{ request('search') }}" id="search-input" class="form-control" 
                           autocomplete="off" style="min-width: 220px;" />
                    <div id="search-suggestions" class="search-suggestions list-group"></div>
                </div>

                {{-- Category Select --}}
                 @if (config('features.show_user_kategori_filter_dropdown'))
                <select name="kategori" class="form-select" style="min-width: 200px;">
                    <option value="">{{ __('All Categories') }}</option>
                    @foreach ($kategori as $kat)
                        <option value="{{ $kat->id }}" {{ request('kategori') == $kat->id ? 'selected' : '' }}>
                            {{ $kat->nama }}
                        </option>
                    @endforeach
                </select>
                @endif 

                {{-- Filter Dropdown --}}
                @if (config('features.show_user_advanced_filter_dropdown'))
                <div class="dropdown">
                    <button class="btn btn-outline-secondary dropdown-toggle w-100" type="button" 
                            id="filterHargaDropdown" data-bs-toggle="dropdown" data-bs-auto-close="outside" 
                            aria-expanded="false">
                        {{ __('Sort & Filter') }}
                    </button>
                    <div class="dropdown-menu p-3 shadow" aria-labelledby="filterHargaDropdown" style="min-width: 300px;">

                        {{-- Sort Options --}}
                        <div class="mb-3">
                            <label class="form-label fw-semibold">{{ __('Sort by:') }}</label>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="sort_harga" id="terbaru" 
                                       value="terbaru" {{ (request('sort_harga') == 'terbaru' || !request()->has('sort_harga')) ? 'checked' : '' }}>
                                <label class="form-check-label" for="terbaru">{{ __('Newest') }}</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="sort_harga" id="termurah" 
                                       value="asc" {{ request('sort_harga') == 'asc' ? 'checked' : '' }}>
                                <label class="form-check-label" for="termurah">{{ __('Cheapest') }}</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="sort_harga" id="termahal" 
                                       value="desc" {{ request('sort_harga') == 'desc' ? 'checked' : '' }}>
                                <label class="form-check-label" for="termahal">{{ __('Most Expensive') }}</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="sort_harga" id="terlaris" 
                                       value="terlaris" {{ request('sort_harga') == 'terlaris' ? 'checked' : '' }}>
                                <label class="form-check-label" for="terlaris">{{ __('Best Selling') }}</label>
                            </div>
                            

                            {{-- Wishlist Only --}}
                            <div class="mb-3 border-top pt-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="show_wishlist" 
                                           id="show_wishlist" {{ request('show_wishlist') == 'on' ? 'checked' : '' }} 
                                           onchange="this.form.submit()">
                                    <label class="form-check-label" for="show_wishlist">
                                        {{ __('Show Wishlist Only') }}
                                    </label>
                                </div>
                            </div>
                        </div>

                        {{-- Price Range --}}
                        <div class="mb-3">
                            <label class="form-label fw-semibold">{{ __('Price Range (Rp)') }}</label>
                            <div class="d-flex align-items-center gap-2">
                                <input type="number" class="form-control form-control-sm" name="harga_min" 
                                       placeholder="{{ __('Price Min') }}" value="{{ request('harga_min') }}">
                                <span>-</span>
                                <input type="number" class="form-control form-control-sm" name="harga_max" 
                                       placeholder="{{ __('Price Max') }}" value="{{ request('harga_max') }}">
                            </div>
                        </div>

                        {{-- Rating Filter --}}
                        <div class="mb-3">
                            <label class="form-label fw-semibold">{{ __('Filter Rating:') }}</label>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="rating_min" id="rating4" 
                                       value="4" {{ request('rating_min') == 4 ? 'checked' : '' }}>
                                <label class="form-check-label" for="rating4">
                                    {{ __('4 Stars and up') }} (★★★★☆)
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="rating_min" id="rating3" 
                                       value="3" {{ request('rating_min') == 3 ? 'checked' : '' }}>
                                <label class="form-check-label" for="rating3">
                                    {{ __('3 Stars and up') }} (★★★☆☆)
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="rating_min" id="rating1" 
                                       value="1" {{ request('rating_min') == 1 ? 'checked' : '' }}>
                                <label class="form-check-label" for="rating1">
                                    {{ __('1 Star and up') }} (★☆☆☆☆)
                                </label>
                            </div>
                        </div>

                        <a href="{{ route('user.dashboard') }}" class="btn btn-sm btn-outline-danger w-100">
                            {{ __('Reset Filter') }}
                        </a>
                    </div>
                </div>
                @endif

                <button type="submit" class="btn btn-primary">{{ __('Filter') }}</button>
            </form>
        </div>

        {{-- Product Grid --}}
        <div class="row g-4">
            @forelse ($produk as $item)
                <div class="col-lg-3 col-md-4 col-sm-6" data-aos="fade-up">
                    <div class="product-card">

                        {{-- Product Image --}}
                        <div class="product-image-wrapper">
                            <a href="{{ route('user.product.show', $item->id) }}">
                                <img src="{{ asset('storage/' . $item->foto) }}" alt="{{ $item->nama }}" 
                                     class="product-image">
                            </a>

                            {{-- Wishlist Button --}}
                            @if (config('features.show_user_wishlist'))
                            <form action="{{ route('user.wishlist.toggle', $item->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="wishlist-badge" title="{{ __('Add to Wishlist') }}">
                                    ❤️
                                </button>
                            </form>
                            @endif
                        </div>
                       

                        {{-- Product Body --}}
                        <div class="product-body">
                            <div class="product-category">{{ $item->kategori->nama ?? '-' }}</div>

                            <h3 class="product-title">{{ $item->nama }}</h3>

                            <div class="product-price">Rp {{ number_format($item->harga, 0, ',', '.') }}</div>

                            {{-- Rating --}}
                            @if (config('features.show_user_rating_system'))
                            <div class="product-rating">
                                @php $rating = round($item->reviews_avg_rating ?? 0); @endphp
                                <div class="star-rating-display-small">
                                    @for ($i = 1; $i <= 5; $i++)
                                        <span>{{ $i <= $rating ? '★' : '☆' }}</span>
                                    @endfor
                                </div>
                                <span class="text-muted small">({{ $item->reviews_count ?? 0 }})</span>
                            </div>
                            @endif

                            {{-- Stock --}}
                            <div class="stock-badge {{ $item->stok > 0 ? 'stock-available' : 'stock-out' }}">
                                @if($item->stok > 0)
                                    <i class="fas fa-check-circle"></i>
                                    {{ __('Stock') }}: {{ $item->stok }}
                                @else
                                    <i class="fas fa-times-circle"></i>
                                    {{ __('Out of Stock') }}
                                @endif
                            </div>

                            {{-- Latest Review --}}
                            @if (config('features.show_user_rating_system'))
                            @if ($item->latestReview)
                                <div class="product-review">
                                    <div class="d-flex align-items-center mb-2">
                                        <div class="review-avatar me-2">
                                            {{ strtoupper(substr($item->latestReview->user->name, 0, 1)) }}
                                        </div>
                                        <small class="fw-semibold">{{ $item->latestReview->user->name }}</small>
                                    </div>
                                    <p class="mb-0 text-muted fst-italic small">
                                        "{{ Str::limit($item->latestReview->comment, 50, '...') }}"
                                    </p>
                                    @if (($item->reviews_count ?? 0) > 1)
                                        <a href="{{ route('user.product.show', $item->id) }}" 
                                           class="text-decoration-none small">
                                            {{ __('Read more') }} ({{ $item->reviews_count - 1 }} {{ __('more') }})
                                        </a>
                                    @endif
                                </div>
                            @endif
                            @endif

                            {{-- Actions --}}
                            <div class="product-actions">
                                <form action="{{ route('cart.add', $item->id) }}" method="POST" class="flex-grow-1">
                                    @csrf
                                    <button type="submit" class="btn btn-add-cart w-100" 
                                            {{ $item->stok == 0 ? 'disabled' : '' }}>
                                        {{ __('+ Add to Cart') }}
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="empty-state">
                        <i class="fas fa-box-open"></i>
                        <p class="mb-0">{{ __('Product not found.') }}</p>
                    </div>
                </div>
            @endforelse
        </div>

        {{-- Pagination --}}
        <div class="d-flex justify-content-center mt-4">
            {{ $produk->links() }}
        </div>

    </div>

@endsection

@push('scripts')
    {{-- Tooltip --}}
    <script>
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        })
    </script>

    {{-- Auto-Suggest Search --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('search-input');
            const suggestionsBox = document.getElementById('search-suggestions');

            if (searchInput && suggestionsBox) {
                searchInput.addEventListener('keyup', function() {
                    const query = this.value;

                    if (query.length < 2) {
                        suggestionsBox.innerHTML = '';
                        suggestionsBox.style.display = 'none';
                        return;
                    }

                    fetch(`{{ route('user.search.suggestions') }}?search=${query}`, {
                        method: 'GET',
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'Accept': 'application/json',
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        suggestionsBox.innerHTML = '';
                        if (data.length > 0) {
                            suggestionsBox.style.display = 'block';
                            data.forEach(item => {
                                const link = document.createElement('a');
                                link.href = `{{ url('/user/product') }}/${item.id}`;
                                link.className = 'suggestion-item list-group-item list-group-item-action';

                                const fotoUrl = item.foto ? `{{ asset('storage') }}/${item.foto}` : 'https://via.placeholder.com/40';

                                link.innerHTML = `
                                    <img src="${fotoUrl}" alt="${item.nama}">
                                    <span>${item.nama}</span>
                                `;

                                suggestionsBox.appendChild(link);
                            });
                        } else {
                            suggestionsBox.style.display = 'block';
                            suggestionsBox.innerHTML = '<span class="list-group-item text-muted p-2">{{ __("No results...") }}</span>';
                        }
                    })
                    .catch(error => {
                        console.error('Error fetching search suggestions:', error);
                    });
                });

                document.addEventListener('click', function(e) {
                    if (!searchInput.contains(e.target)) {
                        suggestionsBox.innerHTML = '';
                        suggestionsBox.style.display = 'none';
                    }
                });
            }
        });
    </script>
@endpush