<?php
// app/Models/About.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AboutUs extends Model
{
    use HasFactory;

    // Sesuaikan nama tabel jika Laravel salah tebak
    protected $table = 'about_us';

    protected $fillable = [
        'title',        // Untuk "Nama Toko"
        'main_image',   // Untuk "Foto Gedung"
        'narrative',    // Untuk "Narasi"
    ];
}
