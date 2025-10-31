<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Produk;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProdukController extends Controller
{
    // ... (Fungsi __construct() Anda yang di-comment) ...

    /**
     * [FUNGSI YANG DIPERBARUI]
     * Menampilkan daftar produk dengan pagination
     */
    public function index()
    {
        // ▼▼▼ INI DIA PERUBAHANNYA ▼▼▼
        // Kita ganti ->get() menjadi ->paginate(10)
        // Saya juga tambahkan 'latest()' agar produk terbaru ada di paling atas tabel
        $produks = Produk::with('kategori')->latest()->paginate(6); // <-- 10 produk per halaman
        // ▲▲▲ AKHIR PERUBAHAN ▲▲▲

        return view('admin.produk.index', compact('produks'));
    }

    /**
     * Fungsi di bawah ini TIDAK SAYA UBAH
     */
    public function create()
    {
        $kategoris = Kategori::all();
        return view('admin.produk.create', compact('kategoris'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'kategori_id' => 'required|exists:kategoris,id',
            'nama' => 'required|string|max:255',
            'harga' => 'required|numeric',
            'deskripsi' => 'nullable|string',
            'stok' => 'required|integer|min:0',
            'foto' => 'nullable|image|max:2048'
        ]);

        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('produk', 'public');
        }

        Produk::create($data);

        return redirect()->route('admin.produk.index')->with('success', 'Produk berhasil ditambahkan');
    }

    public function edit(Produk $produk)
    {
        $kategoris = Kategori::all();
        return view('admin.produk.edit', compact('produk', 'kategoris'));
    }

    public function update(Request $request, $id)
    {
        $produk = Produk::findOrFail($id);

        $request->validate([
            'nama' => 'required|string|max:255',
            'kategori_id' => 'required|exists:kategoris,id',
            'harga' => 'required|numeric|min:0',
            'stok' => 'required|integer|min:0',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        // Update data text
        $produk->nama = $request->nama;
        $produk->kategori_id = $request->kategori_id;
        $produk->harga = $request->harga;
        $produk->stok = $request->stok;

        // Cek kalau ada file baru
        if ($request->hasFile('foto')) {
            // Hapus foto lama kalau ada
            if ($produk->foto && Storage::disk('public')->exists($produk->foto)) {
                Storage::disk('public')->delete($produk->foto);
            }
            // Simpan foto baru
            $path = $request->file('foto')->store('produk', 'public');
            $produk->foto = $path;
        }

        $produk->save();

        return redirect()->route('admin.produk.index')->with('success', 'Produk berhasil diupdate!');
    }

    public function destroy(Produk $produk)
    {
        if ($produk->foto && Storage::disk('public')->exists($produk->foto)) {
            Storage::disk('public')->delete($produk->foto);
        }

        $produk->delete();

        return redirect()->back()->with('success', 'Produk berhasil dihapus');
    }
}
