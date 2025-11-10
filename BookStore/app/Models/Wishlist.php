<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wishlist extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'produk_id'];


    /**
     * ▼▼▼ INI FUNGSI YANG HILANG (PENYEBAB ERROR) ▼▼▼
     *
     * Mendefinisikan relasi: Satu item Wishlist dimiliki oleh (belongsTo) satu Produk.
     */
    public function produk()
    {
        // Pastikan Anda punya Model 'Produk' di app/Models/Produk.php
        // 'produk_id' adalah foreign key di tabel 'wishlists'
        return $this->belongsTo(Produk::class, 'produk_id');
    }

    /**
     * Relasi ke User (ini juga bagus untuk dimiliki)
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
