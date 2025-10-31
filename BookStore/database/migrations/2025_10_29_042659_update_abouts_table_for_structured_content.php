<?php
// File: database/migrations/...._update_abouts_table_for_structured_content.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Pastikan Anda meng-install: composer require doctrine/dbal
        Schema::table('about_us', function (Blueprint $table) {

          
            // (Pastikan backup dulu data 'Selamat Datang...' Anda)
            if (Schema::hasColumn('about_us', 'content')) {
                $table->dropColumn('content');
            }

            // 2. TAMBAHKAN kolom-kolom baru sesuai coretan
            $table->string('main_image')->nullable()->after('title')->comment('Untuk Foto Gedung');
            $table->text('narrative')->nullable()->after('main_image')->comment('Untuk Narasi 5 kalimat');
        });
    }

    public function down(): void
    {
        Schema::table('about_us', function (Blueprint $table) {
            // Logika untuk mengembalikan (rollback)
            $table->text('content')->nullable(); // Kembalikan kolom content

            $table->dropColumn(['main_image', 'narrative']);
        });
    }
};
