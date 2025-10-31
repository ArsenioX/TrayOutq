<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request; // ✅ Ini sudah benar
use App\Models\Produk;
use App\Models\Kategori;

class UserDashboardController extends Controller
{
    /**
     * [FUNGSI YANG DIPERBARUI]
     * Menampilkan dashboard dengan SEMUA filter (Search, Kategori, Harga, Urutan) DAN Pagination
     */
    public function index(Request $request)
    {
        // 1. Ambil semua kategori untuk filter dropdown
        $kategori = Kategori::all();

        // 2. Mulai query produk, langsung dengan 'kategori' agar efisien
        $query = Produk::with('kategori');

        // 3. Terapkan filter yang sudah ada (Search & Kategori)
        if ($request->filled('search')) {
            $query->where('nama', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('kategori')) {
            $query->where('kategori_id', $request->kategori);
        }

        // 4. ▼▼▼ LOGIKA FILTER HARGA BARU (dari screenshot) DIMASUKKAN DI SINI ▼▼▼

        // Filter Rentang Harga (Min/Max)
        if ($request->filled('harga_min')) {
            $query->where('harga', '>=', $request->harga_min);
        }
        if ($request->filled('harga_max')) {
            $query->where('harga', '<=', $request->harga_max);
        }

        // 5. ▼▼▼ LOGIKA PENGURUTAN (SORTING) BARU ▼▼▼
        // Kita ubah logika 'latest()' Anda
        if ($request->filled('sort_harga') && in_array($request->sort_harga, ['asc', 'desc'])) {
            // Urutkan berdasarkan harga (asc = termurah, desc = termahal)
            $query->orderBy('harga', $request->sort_harga);
        } else {
            // Default: urutkan berdasarkan terbaru (kode 'latest()' Anda sebelumnya)
            $query->latest();
        }

        // ▲▲▲ AKHIR DARI LOGIKA BARU ▲▲▲

        // 6. Ambil data dengan pagination (Kita gunakan paginate(6) seperti kode Anda)
        $produk = $query->paginate(6); // <-- Angka 6 dari kode Anda

        // 7. (PENTING) Agar filter TETAP AKTIF saat pindah halaman
        // Kita tambahkan filter baru ke 'appends'
        $produk->appends($request->only([
            'search',
            'kategori',
            'sort_harga',    // <-- BARU DITAMBAHKAN
            'harga_min',     // <-- BARU DITAMBAHKAN
            'harga_max'      // <-- BARU DITAMBAHKAN
        ]));

        // 8. Kirim data ke view
        return view('user.dashboard', compact('produk', 'kategori'));
    }

    /**
     * Fungsi ini tidak berubah
     */
    public function showProduct($id)
    {
        $product = Produk::findOrFail($id);
        return view('user.product-detail', compact('product'));
    }
}
