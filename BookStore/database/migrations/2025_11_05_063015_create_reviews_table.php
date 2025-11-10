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
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            // Kunci untuk user yang memberi review
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            // Kunci untuk produk yang di-review
            $table->foreignId('produk_id')->constrained('produks')->onDelete('cascade');

            // Rating bintang (1 s/d 5)
            $table->unsignedTinyInteger('rating'); // Angka 1-5

            // Teks ulasan/komentar
            $table->text('comment')->nullable(); // Boleh kosong

            $table->timestamps();

            // Opsional: User hanya boleh review 1 produk 1x
            $table->unique(['user_id', 'produk_id']);
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};
