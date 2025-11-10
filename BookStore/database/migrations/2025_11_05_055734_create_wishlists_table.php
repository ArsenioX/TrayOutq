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
        Schema::create('wishlists', function (Blueprint $table) {
            $table->id();
            // Kunci untuk user
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            // Kunci untuk produk
            $table->foreignId('produk_id')->constrained('produks')->onDelete('cascade');
            $table->timestamps();

            // Opsional: Pastikan user tidak bisa wishlist 1 produk 2x
            $table->unique(['user_id', 'produk_id']);
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wishlists');
    }
};
