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
     * Fungsi index() Anda
     * (Saya perbarui statusnya agar cocok)
     */
    public function index(Request $request)
    {
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            abort(403, 'Akses hanya untuk admin.');
        }

        $search = $request->input('search');
        $status = $request->input('status');

        $query = User::query()
            ->with([
                'transactions' => function ($trxQuery) use ($status) {
                    $trxQuery->latest();
                    if ($status) {
                        $trxQuery->where('status', $status);
                    }
                },
                'transactions.items',
                'transactions.items.produk'
            ])
            ->orderBy('name', 'asc');

        if ($status) {
            $query->whereHas('transactions', function ($q) use ($status) {
                $q->where('status', $status);
            });
        } else {
            $query->whereHas('transactions');
        }

        if ($search) {
            // ... (logika search Anda tidak berubah) ...
            $query->where(function ($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                    ->orWhere('email', 'LIKE', "%{$search}%")
                    ->orWhereHas('transactions', function ($trxQuery) use ($search) {
                        $trxId = ltrim($search, '#');
                        $trxQuery->where('id', 'LIKE', "%{$trxId}%")
                            ->orWhere('total', 'LIKE', "%{$search}%");
                    });
            });
        }

        $users = $query->get();

        // --- STATS HEADER (Saya sesuaikan dengan status baru) ---
        $pendingCount = Transaction::where('status', 'pending')->count();
        $processingCount = Transaction::where('status', 'diproses')->count(); // <-- BARU
        $shippedCount = Transaction::where('status', 'dikirim')->count();
        $completedCount = Transaction::where('status', 'selesai')->count(); // <-- BARU

        return view('admin.transactions.index', compact(
            'users',
            'pendingCount',
            'processingCount', // <-- BARU
            'shippedCount',
            'completedCount',
            'search',
            'status'
        ));
    }


    /**
     * [FUNGSI DIPERBARUI]
     * Memperbarui status dan catatan pengiriman (versi Bahasa Indonesia)
     */
    public function updateStatus(Request $request, $id)
    {
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            abort(403, 'Akses hanya untuk admin.');
        }

        // 1. Validasi input (menggunakan status Bahasa Indonesia)
        $request->validate([
            'status' => 'required|string|in:pending,diproses,dikirim,selesai,dibatalkan',
            'shipping_notes' => 'nullable|string|max:1000',
        ]);

        $transaction = Transaction::findOrFail($id);
        $transaction->status = $request->status;

        // Simpan catatan HANYA JIKA statusnya 'dikirim'
        if ($request->status == 'dikirim') {
            $transaction->shipping_notes = $request->shipping_notes;
        }

        $transaction->save();

        return back()->with('success', 'Status transaksi #' . $transaction->id . ' berhasil diubah ke "' . $transaction->status . '".');
    }
}
