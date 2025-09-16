<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Transaction;
use App\Models\TransactionItem;
use App\Models\User;
use App\Models\Produk;

class AdminTransactionController extends Controller
{
    /**
     * Menampilkan daftar semua transaksi kepada admin.
     */
    public function index()
    {
        // Cek apakah user adalah admin
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            abort(403, 'Akses hanya untuk admin.');
        }

        // Ambil semua transaksi beserta relasi user dan item + produk
        $transactions = Transaction::with(['user', 'items.produk'])
            ->latest()
            ->get();

        return view('admin.transactions.index', compact('transactions'));
    }

    /**
     * Mengonfirmasi transaksi dan mengubah status menjadi 'dikirim'.
     *
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function konfirmasi($id)
    {
        // Cek apakah user adalah admin
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            abort(403, 'Akses hanya untuk admin.');
        }

        // Cari transaksi berdasarkan ID
        $transaction = Transaction::findOrFail($id);

        // Ubah status menjadi 'dikirim'
        $transaction->update([
            'status' => 'dikirim'
        ]);

        return back()->with('success', 'Transaksi telah dikonfirmasi.');
    }
}
