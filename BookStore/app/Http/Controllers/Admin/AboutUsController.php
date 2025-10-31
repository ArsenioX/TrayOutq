<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AboutUs; // <-- Menggunakan Model Anda
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage; // <-- Tetap dipakai untuk 'main_image'

class AboutUsController extends Controller
{
    /**
     * 1. Menampilkan form edit ('admin.about.blade.php')
     */
    public function edit()
    {
        // Menggunakan firstOrCreate. Ini lebih aman daripada firstOrFail.
        // Jika tabel masih kosong (misal setelah migrasi), ini akan membuat
        // baris baru secara otomatis, menghindari error "Not Found".
        $about = AboutUs::firstOrCreate(['id' => 1]);

        return view('admin.about', compact('about')); // <-- Sesuai struktur file Anda
    }

    /**
     * 2. Menyimpan perubahan data dari form admin
     */
    public function update(Request $request)
    {
        // 1. Validasi diubah total sesuai field baru
        $validated = $request->validate([
            'title' => 'required|string|max:255', // Nama Toko
            'main_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048', // Foto Gedung (Maks 2MB)
            'delete_main_image' => 'nullable|boolean', // Checkbox untuk hapus gambar
            'narrative' => 'required|string|min:20', // Narasi (minimal 20 karakter)
        ]);

        // Ambil data (atau buat baru jika belum ada)
        $about = AboutUs::firstOrCreate(['id' => 1]);

        // 2. Logika Hapus Gambar
        // Jika user mencentang 'delete_main_image' DAN ada gambar di database
        if ($request->filled('delete_main_image') && $about->main_image) {
            Storage::disk('public')->delete($about->main_image);
            $about->main_image = null; // Kosongkan di DB
        }

        // 3. Logika Upload Gambar Baru
        // Jika ada file baru yang diupload
        if ($request->hasFile('main_image')) {
            // Hapus gambar lama (jika ada) sebelum upload yang baru
            if ($about->main_image) {
                Storage::disk('public')->delete($about->main_image);
            }

            // Simpan gambar baru di 'storage/app/public/about-page'
            $path = $request->file('main_image')->store('about-page', 'public');
            $about->main_image = $path;
        }

        // 4. Simpan semua data teks
        $about->title = $validated['title'];
        $about->narrative = $validated['narrative'];

        $about->save(); // Simpan semua perubahan (gambar dan teks)

        // 5. Kembali ke halaman edit (nama route 'admin.about.edit' sudah benar)
        return redirect()->route('admin.about.edit')->with('success', 'Halaman About Us berhasil diperbarui!');
    }
}
