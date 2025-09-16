<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Kategori extends Model
{
    use HasFactory;

    protected $fillable = ['nama', 'deskripsi', 'foto'];

    public function produk()
    {
        return $this->hasMany(Produk::class);
    }

    public function category()
    {
        return $this->belongsTo(Kategori::class, 'kategori_id');
    }
}
