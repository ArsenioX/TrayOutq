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
    // app/Http/Controllers/Admin/AdminTransactionController.php

    public function index(Request $request) // Tambahkan "Request $request"
    {
        // Cek apakah user adalah admin
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            abort(403, 'Akses hanya untuk admin.');
        }

        // Ambil input dari form (jika ada)
        $search = $request->input('search');
        $status = $request->input('status');

        // Mulai query builder untuk User
        $query = User::query()
            ->with([
                // Muat relasi transaksi
                'transactions' => function ($trxQuery) use ($status) {
                    $trxQuery->latest();
                    // Jika ada filter status, filter juga transaksi yang dimuat
                    if ($status) {
                        $trxQuery->where('status', $status);
                    }
                },
                'transactions.items',
                'transactions.items.produk'
            ])
            ->orderBy('name', 'asc');

        // --- LOGIKA FILTER ---

        // 1. Filter berdasarkan Status
        if ($status) {
            // Hanya tampilkan user yang MEMILIKI transaksi dengan status tsb
            $query->whereHas('transactions', function ($q) use ($status) {
                $q->where('status', $status);
            });
        } else {
            // Default: Hanya tampilkan user yang punya transaksi
            $query->whereHas('transactions');
        }

        // 2. Filter berdasarkan Search
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%") // Cari berdasarkan nama user
                    ->orWhere('email', 'LIKE', "%{$search}%") // Cari berdasarkan email user
                    ->orWhereHas('transactions', function ($trxQuery) use ($search) {
                        $trxId = ltrim($search, '#'); // Hapus # jika user mengetik #20
                        $trxQuery->where('id', 'LIKE', "%{$trxId}%") // Cari berdasarkan ID transaksi
                            ->orWhere('total', 'LIKE', "%{$search}%"); // Cari berdasarkan total
                    });
            });
        }

        // Eksekusi query
        $users = $query->get();

        // --- STATS HEADER (Tetap sama) ---
        $pendingCount = Transaction::where('status', 'pending')->count();
        $shippedCount = Transaction::where('status', 'dikirim')->count();
        $completedCount = Transaction::where('status', 'selesai')->count();

        // Kirim semua data ke view, TERMASUK $search dan $status
        return view('admin.transactions.index', compact(
            'users',
            'pendingCount',
            'shippedCount',
            'completedCount',
            'search', // Kirim balik value search
            'status'  // Kirim balik value status
        ));
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
