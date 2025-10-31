<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\AboutUs; // <-- Import model

class AboutUsSeeder extends Seeder
{
    public function run(): void
    {
        // Buat satu baris data default
        AboutUs::create([
            'title' => 'Tentang Kami',
            'content' => '<p>Ini adalah konten awal. Silakan update melalui halaman admin.</p>'
        ]);
    }
}
