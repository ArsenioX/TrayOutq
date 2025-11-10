<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;    // Panggil model User
use App\Models\Produk;   // Panggil model Produk
use App\Models\Transaction; // Panggil model Transaction (pastikan namanya benar)

class AdminDashboardController extends Controller
{
    /**
     * Menampilkan halaman dashboard admin dengan data statistik.
     */
    public function index()
    {
        // 1. Ambil data untuk Poin 5: Menampilkan jumlah total
        $totalUsers = User::where('role', 'user')->count();
        $totalProduks = Produk::count();

        // Asumsi: Anda punya model 'Transaction' dan kolom 'status'
        // Ganti 'Transaction' jika nama model Anda 'Transaksi'
        $totalTransactions = Transaction::count();

        // 2. (Bonus) Ambil data 'pending' yang sudah ada di dashboard Anda
        $pendingTransactionsCount = Transaction::where('status', 'pending')->count();


        // 3. Kirim semua data ini ke view
        return view('admin.dashboard', [
            'totalUsers' => $totalUsers,
            'totalProduks' => $totalProduks,
            'totalTransactions' => $totalTransactions,
            'pendingTransactionsCount' => $pendingTransactionsCount
        ]);
    }
}
