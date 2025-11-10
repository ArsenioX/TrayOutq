<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Wishlist;
use App\Models\Produk;

class WishlistController extends Controller
{
    // 1. Fungsi untuk MENAMPILKAN halaman wishlist
    public function index()
    {
        $wishlistItems = Wishlist::where('user_id', Auth::id())
            ->with('produk') // Ambil data produknya
            ->latest()
            ->get();

        return view('user.wishlist', compact('wishlistItems'));
    }

    // 2. Fungsi TOGGLE (Tambah/Hapus)
    public function toggle($produk_id)
    {
        $user_id = Auth::id();

        // Cek apakah produk sudah ada di wishlist
        $wishlistItem = Wishlist::where('user_id', $user_id)
            ->where('produk_id', $produk_id)
            ->first();

        if ($wishlistItem) {
            // Jika SUDAH ADA: Hapus dari wishlist
            $wishlistItem->delete();
            return back()->with('success', 'Produk dihapus dari wishlist.');
        } else {
            // Jika BELUM ADA: Tambahkan ke wishlist
            Wishlist::create([
                'user_id' => $user_id,
                'produk_id' => $produk_id
            ]);
            return back()->with('success', 'Produk ditambahkan ke wishlist.');
        }
    }
}
