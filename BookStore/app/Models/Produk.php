<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Produk extends Model
{
    use HasFactory;

    protected $fillable = ['kategori_id', 'nama', 'harga', 'deskripsi','stok', 'foto'];

    public function kategori()
    {
        return $this->belongsTo(Kategori::class);
    }

    // Di dalam class Produk extends Model

    // Relasi: 1 produk punya BANYAK reviews
    public function reviews()
    {
        return $this->hasMany(Review::class, 'produk_id');
    }

    // Accessor: Untuk menghitung rating rata-rata
    // Nanti kita panggil di view sebagai $produk->average_rating
    public function getAverageRatingAttribute()
    {
        // 'reviews' adalah nama relasi di atas
        // 'rating' adalah nama kolom di tabel 'reviews'
        return $this->reviews()->avg('rating');
    }
    public function latestReview()
    {
        return $this->hasOne(Review::class, 'produk_id')->latestOfMany();
    }

    public function wishlists()
    {
        // Pastikan nama Model Anda "Wishlist"
        return $this->hasMany(Wishlist::class, 'produk_id');
    }
}
