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
}
