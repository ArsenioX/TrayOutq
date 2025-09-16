<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Cart;

class CartController extends Controller
{
    public function index()
    {
        $items = Cart::with('produk')
            ->where('user_id', Auth::id())
            ->get();

        return view('user.cart', compact('items'));
    }

    public function add($id)
    {
        \App\Models\Cart::create([
            'user_id' => Auth::id(),
            'produk_id' => $id,
            'jumlah' => 1
        ]);

        return redirect()->back()->with('success', 'Produk berhasil ditambahkan ke keranjang!');
    }

    public function remove($id)
    {
        \App\Models\Cart::where('id', $id)->where('user_id', Auth::id())->delete();

        return redirect()->back()->with('success', 'Produk berhasil dihapus dari keranjang.');
    }
}
