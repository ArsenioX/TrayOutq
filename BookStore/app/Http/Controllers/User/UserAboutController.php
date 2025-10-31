<?php

namespace App\Http\Controllers\User; // <-- Namespace Anda sudah benar

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AboutUs;  // <-- Model untuk "Nama Toko", "Narasi"
use App\Models\Produk;  // <-- (PENTING) Model untuk "Produk Toko Kami" 
// (Ganti 'Product' jika nama Model Anda 'Produk' atau 'Buku')

class UserAboutController extends Controller
{
    /**
     * Menampilkan halaman About Us untuk user.
     */
    public function index()
    {
        // 1. Ambil data statis (Nama Toko, Foto, Narasi)
        // Kita ganti firstOrFail() dengan firstOrCreate()
        // Ini lebih aman, jika tabel masih kosong (setelah migrasi), dia akan buat baris baru
        $aboutData = AboutUs::firstOrCreate(['id' => 1]);

        // 2. (INI BAGIAN BARU) Ambil data dinamis (Produk Terbaru, 5 per halaman)
        // Ganti 'Product' dengan nama Model produk Anda
        $products = Produk::latest()->paginate(6);

        // 3. Kirim KEDUA data itu ke view 'user.about'
        return view('user.about', [
            'about'    => $aboutData,  // <-- Data "About Us"
            'products' => $products    // <-- Data 5 Produk Terbaru
        ]);
    }
}
