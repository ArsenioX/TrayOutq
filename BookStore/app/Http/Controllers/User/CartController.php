<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Cart;
use App\Models\Produk; // <-- PENTING: Panggil Model Produk Anda
use Illuminate\Http\Request; // <-- Tambahkan ini

class CartController extends Controller
{
    /**
     * Menampilkan isi keranjang
     */
    public function index()
    {
        $items = Cart::with('produk')
            ->where('user_id', Auth::id())
            ->get();

        return view('user.cart', compact('items'));
    }

    /**
     * [FUNGSI YANG DIPERBAIKI]
     * Menambahkan produk ke keranjang dengan cek stok & gabung jumlah
     */
    public function add($id) // $id di sini adalah produk_id
    {
        // 1. Dapatkan produk untuk mengecek stok
        $produk = Produk::findOrFail($id);

        // 2. Dapatkan user ID
        $userId = Auth::id();

        // 3. Cek stok dasar (jika stok 0, langsung tolak)
        if ($produk->stok <= 0) {
            return redirect()->back()->with('error', 'Stok produk telah habis.');
        }

        // 4. Cari item ini di keranjang user
        $cartItem = Cart::where('user_id', $userId)
            ->where('produk_id', $id)
            ->first();

        // 5. Tentukan logikanya
        if ($cartItem) {
            // --- Item SUDAH ADA di keranjang ---

            // Cek apakah jumlah di keranjang SUDAH SAMA DENGAN stok
            if ($cartItem->jumlah >= $produk->stok) {
                // JIKA SUDAH MAKSIMAL, kembalikan pesan error
                return redirect()->back()->with('error', 'Jumlah di keranjang sudah mencapai batas stok produk.');
            }

            // Jika belum, tambahkan 1
            $cartItem->increment('jumlah'); // Ini sama dengan 'jumlah = jumlah + 1'

        } else {
            // --- Item BELUM ADA di keranjang ---
            // (Kita sudah cek stok > 0 di langkah 2, jadi aman untuk tambah 1)
            Cart::create([
                'user_id' => $userId,
                'produk_id' => $id,
                'jumlah' => 1 // Mulai dengan jumlah 1
            ]);
        }

        // 6. Kembalikan pesan sukses
        return redirect()->back()->with('success', 'Produk berhasil ditambahkan ke keranjang.');
    }

    /**
     * Menghapus 1 baris item dari keranjang
     * $id di sini adalah 'id' dari tabel 'carts'
     */
    public function remove($id)
    {
        // Kode Anda ini sudah benar untuk menghapus 1 baris
        Cart::where('id', $id)->where('user_id', Auth::id())->delete();

        return redirect()->back()->with('success', 'Produk berhasil dihapus dari keranjang.');
    }

    public function increase($id)
    {
        // Cari item keranjang, pastikan milik user ini
        // Kita 'with' produk untuk bisa cek stoknya
        $cartItem = Cart::with('produk')->where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        // Logika: Cek stok
        if ($cartItem->jumlah < $cartItem->produk->stok) {
            // Jika stok masih ada, tambah 1
            $cartItem->increment('jumlah');
            return redirect()->back()->with('success', 'Jumlah produk ditambah.');
        }

        // Jika stok sudah maks, beri pesan error
        return redirect()->back()->with('error', 'Jumlah sudah mencapai batas stok.');
    }

    /**
     * Mengurangi jumlah item di keranjang (- 1)
     * $id di sini adalah ID dari item keranjang (carts.id)
     */
    public function decrease($id)
    {
        // Cari item keranjang, pastikan milik user ini
        $cartItem = Cart::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        // Logika: Tidak bisa di-mines (minimal 1)
        if ($cartItem->jumlah > 1) {
            // Jika jumlah masih di atas 1, kurangi 1
            $cartItem->decrement('jumlah');
            return redirect()->back()->with('success', 'Jumlah produk dikurangi.');
        }

        // Jika jumlah sudah 1, beri pesan error
        return redirect()->back()->with('error', 'Jumlah minimal adalah 1.');
    }

    // Anda mungkin butuh fungsi 'update' nanti, tapi 'add' dan 'remove' ini sudah cukup
}
