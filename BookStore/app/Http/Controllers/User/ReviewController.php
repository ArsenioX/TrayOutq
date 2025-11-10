<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Review;
use App\Models\Transaction; // <-- Kita panggil Transaction

class ReviewController extends Controller
{
    /**
     * Menyimpan review baru dari user.
     */
    public function store(Request $request)
    {
        // 1. Validasi input
        $request->validate([
            'produk_id' => 'required|exists:produks,id',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
        ]);

        $produk_id = $request->produk_id;
        $user_id = Auth::id();

        // 2. CEK APAKAH USER SUDAH PERNAH BELI PRODUK INI
        // (Sesuai challenge "yang sudah membeli")
        $hasPurchased = Transaction::where('user_id', $user_id)
            ->where('status', 'selesai') // Hanya yang sudah selesai
            ->whereHas('items', function ($query) use ($produk_id) {
                $query->where('produk_id', $produk_id);
            })
            ->exists(); // 'exists()' = true jika ada

        if (!$hasPurchased) {
            return back()->with('error', 'Anda hanya bisa memberi review untuk produk yang sudah Anda beli & selesaikan.');
        }

        // 3. CEK APAKAH USER SUDAH PERNAH REVIEW PRODUK INI
        $alreadyReviewed = Review::where('user_id', $user_id)
            ->where('produk_id', $produk_id)
            ->exists();

        if ($alreadyReviewed) {
            return back()->with('error', 'Anda sudah pernah memberi review untuk produk ini.');
        }

        // 4. Jika lolos, simpan review
        Review::create([
            'user_id' => $user_id,
            'produk_id' => $produk_id,
            'rating' => $request->rating,
            'comment' => $request->comment,
        ]);

        return back()->with('success', 'Terima kasih atas review Anda!');
    }

    // Di dalam file: app/Http/Controllers/User/ReviewController.php
    // ... (setelah fungsi store() yang sudah ada)

    /**
     * ▼▼▼ FUNGSI BARU UNTUK EDIT REVIEW ▼▼▼
     * Memperbarui review yang sudah ada.
     */
    public function update(Request $request, \App\Models\Review $review)
    {
        // 1. Validasi input
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
        ]);

        // 2. Cek Otorisasi (pastikan user ini pemilik review)
        if ($review->user_id !== Auth::id()) {
            abort(403, 'Anda tidak punya izin untuk mengedit review ini.');
        }

        // 3. Update review
        $review->update([
            'rating' => $request->rating,
            'comment' => $request->comment,
        ]);

        return back()->with('success', 'Review Anda berhasil diperbarui.');
    }

    /**
     * ▼▼▼ FUNGSI BARU UNTUK HAPUS REVIEW ▼▼▼
     * Menghapus review.
     */
    public function destroy(\App\Models\Review $review)
    {
        // 1. Cek Otorisasi
        if ($review->user_id !== Auth::id()) {
            abort(403, 'Anda tidak punya izin untuk menghapus review ini.');
        }

        // 2. Hapus review
        $review->delete();

        return back()->with('success', 'Review Anda berhasil dihapus.');
    }
}
