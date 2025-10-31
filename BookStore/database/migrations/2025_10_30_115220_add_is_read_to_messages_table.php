<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('messages', function (Blueprint $table) {
            // Tambahkan kolom 'is_read' setelah 'message'
            // default(0) artinya "belum dibaca"
            $table->boolean('is_read')->default(0)->after('message');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('messages', function (Blueprint $table) {
            // Hapus kolomnya jika kita rollback
            $table->dropColumn('is_read');
        });
    }
};
