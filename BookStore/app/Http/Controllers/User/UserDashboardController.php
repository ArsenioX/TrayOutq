<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Produk;
use App\Models\Kategori;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class UserDashboardController extends Controller
{
    /**
     * [FUNGSI YANG DIPERBARUI]
     * Menampilkan dashboard dengan filter "Terlaris"
     */
    public function index(Request $request)
    {
        // 1. Ambil semua kategori untuk filter dropdown
        $kategori = Kategori::all();

        // 2. Mulai query produk, langsung dengan 'kategori' agar efisien
        // Kita tambahkan select('produks.*') agar aman saat di-join
        // 'latestReview.user' akan mengambil data user (seperti 'adrian') dari review terbaru
        $query = Produk::with(['kategori', 'latestReview', 'latestReview.user'])
            ->select('produks.*');

        // Ambil jumlah 'reviews' dan simpan sebagai 'reviews_count'
        $query->withCount('reviews');
        // Ambil rata-rata 'rating' dari 'reviews' dan simpan sebagai 'reviews_avg_rating'
        $query->withAvg('reviews', 'rating');

        // 3. Terapkan filter yang sudah ada (Search & Kategori)
        if ($request->filled('search')) {
            $query->where('nama', 'like', '%' . $request->search . '%');
        }
        if ($request->filled('kategori')) {
            $query->where('kategori_id', $request->kategori);
        }

        // 4. Filter Rentang Harga (Sudah ada)
        if ($request->filled('harga_min')) {
            $query->where('harga', '>=', $request->harga_min);
        }
        if ($request->filled('harga_max')) {
            $query->where('harga', '<=', $request->harga_max);
        }

        if ($request->filled('rating_min')) {
            // having() digunakan untuk memfilter hasil dari fungsi AVG (rata-rata)
            // Ini akan mencari produk yang rating rata-ratanya >= (lebih besar atau sama dengan)
            // nilai yang dipilih (misal: 4)
            $query->having('reviews_avg_rating', '>=', $request->rating_min);
        }

        // 5. ▼▼▼ LOGIKA PENGURUTAN (SORTING) DIPERBARUI ▼▼▼

        if ($request->get('show_wishlist') == 'on') {
            // 'wishlists' adalah nama relasi di model Produk
            $query->whereHas('wishlists', function ($q) {
                // Filter wishlist HANYA untuk user yang sedang login
                $q->where('user_id', Auth::id()); // atau auth()->id()
            });
        }

        if ($request->sort_harga == 'terlaris') {
            // --- LOGIKA BARU UNTUK "TERLARIS" ---
            // 1. Gabungkan (join) dengan tabel 'transaction_items'
            $query->leftJoin('transaction_items', 'produks.id', '=', 'transaction_items.produk_id')
                // 2. Tambahkan kolom virtual 'total_terjual' yang berisi JUMLAH total penjualan
                ->addSelect(DB::raw('COALESCE(SUM(transaction_items.jumlah), 0) as total_terjual'))
                // 3. Kelompokkan berdasarkan ID produk
                ->groupBy('produks.id')
                // 4. Urutkan berdasarkan 'total_terjual' (terbanyak dulu)
                ->orderBy('total_terjual', 'desc');

            // (Kita harus groupBy semua kolom produk agar lolos MySQL strict mode)
            $query->groupBy('produks.kategori_id', 'produks.nama', 'produks.harga', 'produks.deskripsi', 'produks.foto', 'produks.created_at', 'produks.updated_at', 'produks.stok');
        } elseif ($request->filled('sort_harga') && in_array($request->sort_harga, ['asc', 'desc'])) {
            // Urutkan berdasarkan harga (asc = termurah, desc = termahal)
            $query->orderBy('harga', $request->sort_harga);
        } else {
            // Default: urutkan berdasarkan terbaru
            $query->latest();
        }

        // ▲▲▲ AKHIR DARI LOGIKA BARU ▲▲▲

        // 6. Ambil data dengan pagination (Kita gunakan paginate(6) seperti kode Anda)
        $produk = $query->paginate(6);

        // 7. (PENTING) Agar filter TETAP AKTIF saat pindah halaman
        // (Kode 'appends' Anda sudah benar, tidak perlu diubah)
        $produk->appends($request->only([
            'search',
            'kategori',
            'sort_harga',
            'harga_min',
            'harga_max',
            'rating_min',
            'show_wishlist'
        ]));

        // 8. Kirim data ke view
        return view('user.dashboard', compact('produk', 'kategori'));
    }

    /**
     * Fungsi ini tidak berubah
     */
    // Di dalam file: app/Http/Controllers/User/UserDashboardController.php

    public function showProduct($id)
    {
        // 1. Ambil produk (kode Anda yang lama, sudah benar)
        $product = \App\Models\Produk::findOrFail($id);

        // 2. (BARU) Cek apakah user yang login punya review untuk produk ini
        $userReview = null; // Default-nya null (belum review)
        if (Auth::check()) {
            $userReview = \App\Models\Review::where('user_id', Auth::id())
                ->where('produk_id', $id)
                ->first();
        }

        // 3. Kirim KEDUA variabel ($product dan $userReview) ke view
        return view('user.product-detail', compact('product', 'userReview'));
    }

    public function searchSuggestions(Request $request)
    {
        // 1. Ambil kata kunci pencarian dari request AJAX
        // Kita pakai 'search' agar sama dengan nama input Anda
        $query = $request->input('search', '');

        // 2. Jangan cari jika ketikan terlalu pendek (hemat resource)
        if (strlen($query) < 2) {
            return response()->json([]); // Kirim array JSON kosong
        }

        // 3. Cari 5 produk teratas yang cocok
        $suggestions = Produk::where('nama', 'like', '%' . $query . '%')
            ->select('id', 'nama', 'foto') // Hanya ambil data yang kita perlukan
            ->take(5) // Batasi 5 hasil saja
            ->get();

        // 4. Kembalikan hasilnya sebagai JSON
        return response()->json($suggestions);
    }
}
