<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Transaction;
use App\Models\TransactionItem;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
{
    // Menampilkan form checkout
    public function checkoutForm()
    {
        $items = Cart::with('produk')->where('user_id', auth()->id())->get();

        if ($items->isEmpty()) {
            return redirect()->route('user.cart')->with('error', 'Keranjang Anda kosong!');
        }

        return view('user.checkout', compact('items'));
    }

    // Proses checkout (simpan transaksi)
    public function processCheckout(Request $request)
    {
        $request->validate([
            'alamat' => 'required|string|max:255',
            'telepon' => 'required|string|max:20',
            'metode_pembayaran' => 'required|string|max:100',
        ]);

        $user = auth()->user();
        $items = $user->cart()->with('produk')->get();

        if ($items->isEmpty()) {
            return redirect()->route('user.cart')->with('error', 'Keranjang kosong!');
        }

        // Cek apakah user sudah buat transaksi pending dalam 1 menit terakhir
        $recent = Transaction::where('user_id', $user->id)
            ->where('status', 'pending')
            ->where('created_at', '>=', now()->subMinute())
            ->first();

        if ($recent) {
            return redirect()->route('user.transactions')->with('info', 'Checkout sudah diproses. Silakan tunggu.');
        }

        $total = $items->sum(function ($item) {
            return $item->produk->harga * $item->jumlah;
        });

        DB::beginTransaction();

        try {
            $transaction = Transaction::create([
                'user_id' => $user->id,
                'alamat' => $request->alamat,
                'telepon' => $request->telepon,
                'metode_pembayaran' => $request->metode_pembayaran,
                'total' => $total,
                'status' => 'pending',
            ]);

            foreach ($items as $item) {
                // Cek stok cukup
                if ($item->produk->stok < $item->jumlah) {
                    DB::rollBack();
                    return back()->with('error', "Stok untuk {$item->produk->nama} tidak mencukupi.");
                }

                // Kurangi stok
                $item->produk->stok -= $item->jumlah;
                $item->produk->save();

                // Simpan item transaksi
                TransactionItem::create([
                    'transaction_id' => $transaction->id,
                    'produk_id' => $item->produk_id,
                    'jumlah' => $item->jumlah,
                    'harga' => $item->produk->harga,
                ]);
            }


            $user->cart()->delete();

            DB::commit();
            return redirect()->route('user.transactions')->with('success', 'Checkout berhasil! Pesanan sedang diproses.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan saat proses checkout.');
        }
    }

    // Menampilkan daftar transaksi milik user
    public function index()
    {
        $transactions = Transaction::where('user_id', Auth::id())
            ->with('items.produk')
            ->latest()
            ->get();

        return view('user.transactions', ['transaksi' => $transactions]);
    }

    // Konfirmasi pesanan diterima (ubah status jadi selesai)
    public function terimaPesanan($id)
    {
        $transaction = Transaction::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        if ($transaction->status !== 'dikirim') {
            return back()->with('error', 'Pesanan belum dikirim, tidak bisa dikonfirmasi.');
        }

        $transaction->update(['status' => 'selesai']);

        return back()->with('success', 'Pesanan telah diterima dan diselesaikan.');
    }
}
