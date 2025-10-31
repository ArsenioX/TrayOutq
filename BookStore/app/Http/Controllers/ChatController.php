<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Message;

class ChatController extends Controller
{
    /**
     * Menampilkan halaman chat (Daftar User atau Isi Chat)
     */
    public function index(Request $request)
    {
        $user = Auth::user();

        if ($user->role === 'admin') {
            // --- LOGIKA ADMIN ---
            $users = User::where('role', 'user')->get();
            $selectedUser = null;
            $messages = collect();

            if ($request->has('user_id')) {
                $selectedUser = User::findOrFail($request->user_id);

                // ▼▼▼ PERUBAHAN 1: "Mark as Read" (Langkah 3) ▼▼▼
                // Ganti logika Session dengan logika Database
                // session()->forget('has_new_message_from_user_' . $selectedUser->id); // <-- HAPUS INI

                // Tandai semua pesan DARI user ini UNTUK admin (kita) sebagai "sudah dibaca"
                Message::where('sender_id', $selectedUser->id)
                    ->where('receiver_id', Auth::id())
                    ->where('is_read', 0)
                    ->update(['is_read' => 1]);
                // ▲▲▲ AKHIR PERUBAHAN 1 ▲▲▲

                // Query untuk mengambil pesan (kode Anda sudah benar)
                $messages = Message::where(function ($query) use ($selectedUser) {
                    $query->where('sender_id', Auth::id())
                        ->where('receiver_id', $selectedUser->id);
                })->orWhere(function ($query) use ($selectedUser) {
                    $query->where('sender_id', $selectedUser->id)
                        ->where('receiver_id', Auth::id());
                })
                    ->with('sender', 'receiver')
                    ->orderBy('created_at')
                    ->get();
            }

            return view('admin.chat', compact('users', 'selectedUser', 'messages'));
        } else {
            // --- LOGIKA USER BIASA ---
            $admin = User::where('role', 'admin')->first();

            // ▼▼▼ PERUBAHAN 2: "Mark as Read" (Langkah 3) ▼▼▼
            // Ganti logika Session dengan logika Database
            // session()->forget('has_new_message_for_user_' . $user->id); // <-- HAPUS INI

            // Tandai semua pesan DARI admin UNTUK user (kita) sebagai "sudah dibaca"
            Message::where('sender_id', $admin->id) // Dari Admin
                ->where('receiver_id', $user->id) // Untuk Saya (user)
                ->where('is_read', 0)
                ->update(['is_read' => 1]);
            // ▲▲▲ AKHIR PERUBAHAN 2 ▲▲▲

            // Query untuk mengambil pesan (kode Anda sudah benar)
            $messages = Message::where(function ($query) use ($user, $admin) {
                $query->where('sender_id', $user->id)
                    ->where('receiver_id', $admin->id);
            })->orWhere(function ($query) use ($user, $admin) {
                $query->where('sender_id', $admin->id)
                    ->where('receiver_id', $user->id);
            })
                ->with('sender', 'receiver')
                ->orderBy('created_at')
                ->get();

            return view('user.chat', compact('messages'));
        }
    }

    /**
     * Menyimpan pesan baru
     */
    public function store(Request $request)
    {
        $request->validate([
            'receiver_id' => 'required|exists:users,id',
            'message' => 'required|string'
        ]);

        Message::create([
            'sender_id' => Auth::id(),
            'receiver_id' => $request->receiver_id,
            'message' => $request->message
            // Kita tidak perlu set 'is_read', karena default-nya 0 (belum dibaca)
        ]);

        // ▼▼▼ PERUBAHAN 3: Hapus Logika Notifikasi Session ▼▼▼
        // Kita tidak perlu ini lagi, karena kolom 'is_read' (default 0)
        // akan menangani ini secara otomatis.

        // $receiver = User::find($request->receiver_id);
        // if ($receiver && $receiver->role === 'admin') {
        //     session()->put('has_new_message_from_user_' . Auth::id(), true); // <-- HAPUS
        // }
        // if ($receiver && $receiver->role === 'user') {
        //     session()->put('has_new_message_for_user_' . $receiver->id, true); // <-- HAPUS
        // }
        // ▲▲▲ AKHIR PERUBAHAN 3 ▲▲▲

        return redirect()->back();
    }


    // ▼▼▼ FUNGSI BARU (Langkah 2: Backend API) ▼▼▼
    /**
     * API endpoint untuk di-cek oleh JavaScript (AJAX).
     * Menghitung semua pesan yang belum dibaca untuk user yang sedang login.
     */
    public function getUnreadCount()
    {
        // Hitung pesan di mana 'saya' adalah penerima, dan 'is_read' = 0
        $count = Message::where('receiver_id', Auth::id())
            ->where('is_read', 0)
            ->count();

        // Kembalikan sebagai JSON
        return response()->json(['unread_count' => $count]);
    }
    // ▲▲▲ AKHIR FUNGSI BARU ▲▲▲

}
