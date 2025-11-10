<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'produk_id', 'rating', 'comment'];

    // Relasi: 1 review milik 1 User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi: 1 review milik 1 Produk
    public function produk()
    {
        return $this->belongsTo(Produk::class, 'produk_id');
    }
}
